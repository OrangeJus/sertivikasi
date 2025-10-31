<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Genset;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage; // Pastikan ini ada

class RentalController extends Controller
{
    /**
     * Menampilkan daftar rental milik user.
     */
    public function index(Request $request)
    {
        $query = Rental::with('genset')
            ->where('user_id', Auth::id());

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $rentals = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        return view('user.rentals.index', compact('rentals'));
    }

    /**
     * Menampilkan form untuk membuat rental baru.
     */
    public function create(Request $request)
    {
        // Check if user already has 2 or more active/pending rentals
        $activeRentalsCount = Rental::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'active'])
            ->count();

        if ($activeRentalsCount >= 2) {
            return redirect()->route('user.dashboard')
                ->with('error', 'Anda sudah mencapai batas maksimal 2 penyewaan aktif. Silakan selesaikan penyewaan yang ada terlebih dahulu.');
        }

        $genset_id = $request->input('genset_id');
        $genset = null;

        if ($genset_id) {
            $genset = Genset::findOrFail($genset_id);
            
            if ($genset->status !== 'tersedia') {
                return redirect()->route('user.dashboard')
                    ->with('error', 'Genset tidak tersedia untuk disewa.');
            }

            // Check if genset is already rented by this user
            $existingRental = Rental::where('user_id', Auth::id())
                ->where('genset_id', $genset_id)
                ->whereIn('status', ['pending', 'active'])
                ->exists();

            if ($existingRental) {
                return redirect()->route('user.dashboard')
                    ->with('error', 'Anda sudah menyewa genset ini. Tidak dapat menyewa genset yang sama lebih dari sekali.');
            }
        }

        $gensets = Genset::where('status', 'tersedia')
            ->orderBy('nama_genset')
            ->get();

        return view('user.rentals.create', compact('genset', 'gensets', 'activeRentalsCount'));
    }

    /**
     * Menyimpan data rental baru.
     */
    public function store(Request $request)
    {
        // Validate active rentals count
        $activeRentalsCount = Rental::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'active'])
            ->count();

        if ($activeRentalsCount >= 2) {
            return back()->with('error', 'Anda sudah mencapai batas maksimal 2 penyewaan aktif.')
                ->withInput();
        }

        $request->validate([
            'genset_id' => 'required|exists:gensets,id',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'payment_method' => 'required|in:transfer,cash',
            'payment_proof' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'genset_id.required' => 'Silakan pilih genset',
            'genset_id.exists' => 'Genset tidak ditemukan',
            'tanggal_mulai.required' => 'Tanggal mulai harus diisi',
            'tanggal_mulai.after_or_equal' => 'Tanggal mulai tidak boleh kurang dari hari ini',
            'tanggal_selesai.required' => 'Tanggal selesai harus diisi',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai',
            'payment_method.required' => 'Metode pembayaran harus dipilih',
            'payment_proof.image' => 'Bukti pembayaran harus berupa gambar',
            'payment_proof.mimes' => 'Format bukti pembayaran harus jpeg, jpg, atau png',
            'payment_proof.max' => 'Ukuran bukti pembayaran maksimal 2MB',
        ]);

        $tanggal_mulai = Carbon::parse($request->tanggal_mulai);
        $tanggal_selesai = Carbon::parse($request->tanggal_selesai);
        $durasi = $tanggal_mulai->diffInDays($tanggal_selesai) + 1;

        // VALIDASI: Maksimal 5 hari
        if ($durasi > 5) {
            return back()->with('error', 'Durasi penyewaan maksimal adalah 5 hari. Durasi yang Anda pilih: ' . $durasi . ' hari.')
                ->withInput();
        }

        $genset = Genset::findOrFail($request->genset_id);

        // Check if genset is available
        if ($genset->status !== 'tersedia') {
            return back()->with('error', 'Genset tidak tersedia untuk disewa.')
                ->withInput();
        }

        // Check if user already renting this genset
        $existingRental = Rental::where('user_id', Auth::id())
            ->where('genset_id', $request->genset_id)
            ->whereIn('status', ['pending', 'active'])
            ->exists();

        if ($existingRental) {
            return back()->with('error', 'Anda sudah menyewa genset ini. Tidak dapat menyewa genset yang sama lebih dari sekali.')
                ->withInput();
        }

        // Check if genset has overlapping rental period
        $overlappingRental = Rental::where('genset_id', $request->genset_id)
            ->whereIn('status', ['pending', 'active'])
            ->where(function($query) use ($tanggal_mulai, $tanggal_selesai) {
                $query->whereBetween('tanggal_mulai', [$tanggal_mulai, $tanggal_selesai])
                    ->orWhereBetween('tanggal_selesai', [$tanggal_mulai, $tanggal_selesai])
                    ->orWhere(function($q) use ($tanggal_mulai, $tanggal_selesai) {
                        $q->where('tanggal_mulai', '<=', $tanggal_mulai)
                        ->where('tanggal_selesai', '>=', $tanggal_selesai);
                    });
            })
            ->exists();

        if ($overlappingRental) {
            return back()->with('error', 'Genset sudah disewa pada periode tanggal tersebut. Silakan pilih tanggal lain atau genset lain.')
                ->withInput();
        }

        $total_harga = $durasi * $genset->harga_sewa;

        try {
            DB::beginTransaction();

            // Create Rental
            $rental = Rental::create([
                'user_id' => Auth::id(),
                'genset_id' => $request->genset_id,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'total_harga' => $total_harga,
                'denda' => 0,
                'hari_keterlambatan' => 0,
                'status' => 'pending',
                'catatan' => $request->catatan,
            ]);

            // Handle payment proof upload
            $paymentProofPath = null;
            if ($request->hasFile('payment_proof')) {
                $paymentProofPath = $request->file('payment_proof')->store('payment-proofs', 'public');
            }

            // Create Payment
            Payment::create([
                'rental_id' => $rental->id,
                'payment_date' => now(),
                'amount' => $total_harga,
                'payment_method' => $request->payment_method,
                'payment_proof' => $paymentProofPath,
                'payment_status' => 'pending',
                'payment_type' => 'rental', // Tambahkan payment_type
            ]);

            DB::commit();

            return redirect()->route('user.rentals.show', $rental->id)
                ->with('success', 'Permintaan penyewaan berhasil dibuat. Menunggu konfirmasi admin.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Delete uploaded file if exists
            if (isset($paymentProofPath)) {
                Storage::disk('public')->delete($paymentProofPath);
            }
            
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan detail rental (Versi UPDATE).
     */
    public function show(Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Muat relasi yang diperlukan
        $rental->load('genset', 'payment', 'pendingPenaltyPayment');
                
        // Hitung denda saat ini jika terlambat
        $currentPenalty = 0;
        $overdueDays = 0;
        if ($rental->isOverdue()) {
            $overdueDays = $rental->getOverdueDays();
            $currentPenalty = $rental->calculatePenaltyAmount();
        }

        return view('user.rentals.show', compact('rental', 'currentPenalty', 'overdueDays'));
    }

    /**
     * Menampilkan halaman konfirmasi request pengembalian.
     */
    public function requestReturn(Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validasi apakah user bisa request return
        if (!$rental->canRequestReturn()) {
            $message = 'Anda tidak dapat request pengembalian saat ini.';
                        
            if ($rental->status !== 'active') {
                $message = 'Rental harus dalam status aktif.';
            } elseif ($rental->status_pengembalian === 'diminta') {
                $message = 'Anda sudah mengajukan request pengembalian sebelumnya.';
            } elseif ($rental->isOverdue() && !$rental->isPenaltyPaidAndVerified()) {
                $message = 'Anda harus membayar denda keterlambatan terlebih dahulu.';
            }
            return redirect()->route('user.rentals.show', $rental->id)
                ->with('error', $message);
        }

        $rental->load('genset');
                
        return view('user.rentals.request-return', compact('rental'));
    }

    /**
     * Menyimpan data request pengembalian.
     */
    public function storeReturnRequest(Request $request, Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$rental->canRequestReturn()) {
            return back()->with('error', 'Anda tidak dapat request pengembalian saat ini.');
        }

        $request->validate([
            'catatan_pengembalian' => 'nullable|string|max:1000',
        ]);

        try {
            $rental->update([
                'status_pengembalian' => 'diminta',
                'tanggal_request_pengembalian' => now(),
                'catatan_pengembalian_user' => $request->catatan_pengembalian,
            ]);

            return redirect()->route('user.rentals.show', $rental->id)
                ->with('success', 'Request pengembalian berhasil diajukan. Menunggu persetujuan admin.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan halaman upload bukti bayar denda.
     */
    public function showUploadPenalty(Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$rental->canUploadPenaltyProof()) {
            return redirect()->route('user.rentals.show', $rental->id)
                ->with('error', 'Anda tidak dapat upload bukti pembayaran saat ini.');
        }

        $rental->load('genset');
        $overdueDays = $rental->getOverdueDays();
        $penaltyAmount = $rental->calculatePenaltyAmount();
        $penaltyPerDay = $rental->genset->harga_sewa * 2; // Asumsi denda 2x harga sewa

        return view('user.rentals.upload-penalty', compact('rental', 'overdueDays', 'penaltyAmount', 'penaltyPerDay'));
    }

    /**
     * Menyimpan bukti pembayaran denda.
     */
    public function uploadPenaltyProof(Request $request, Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$rental->canUploadPenaltyProof()) {
            return back()->with('error', 'Anda tidak dapat upload bukti pembayaran saat ini.');
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'catatan' => 'nullable|string|max:500', // Menambahkan validasi catatan jika ada
        ], [
            'payment_proof.required' => 'Bukti pembayaran harus diupload',
            'payment_proof.image' => 'File harus berupa gambar',
            'payment_proof.mimes' => 'Format file harus jpeg, jpg, atau png',
            'payment_proof.max' => 'Ukuran file maksimal 2MB',
        ]);

        try {
            DB::beginTransaction();

            // Upload file
            $paymentProofPath = $request->file('payment_proof')->store('penalty-proofs', 'public');
            
            // Hitung denda
            $penaltyAmount = $rental->calculatePenaltyAmount();

            // Buat record payment baru untuk denda
            Payment::create([
                'rental_id' => $rental->id,
                'payment_date' => now(),
                'amount' => $penaltyAmount,
                'payment_method' => 'transfer', // Denda diasumsikan transfer
                'payment_proof' => $paymentProofPath,
                'payment_status' => 'pending',
                'payment_type' => 'penalty',
                'catatan' => $request->catatan, // Menyimpan catatan
            ]);

            // Update rental (opsional, tapi di kode Anda ada)
            // Sebaiknya ini dihapus jika sudah ditangani oleh relasi Payment
            // Tapi saya ikuti kode Anda:
            $rental->update([
                'tanggal_bayar_denda' => now(),
                'bukti_bayar_denda' => $paymentProofPath,
            ]);

            DB::commit();

            return redirect()->route('user.rentals.show', $rental->id)
                ->with('success', 'Bukti pembayaran denda berhasil diupload. Menunggu verifikasi admin.');

        } catch (\Exception $e) {
            DB::rollBack();
                        
            if (isset($paymentProofPath)) {
                Storage::disk('public')->delete($paymentProofPath);
            }
                        
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Membatalkan upload bukti bayar denda (jika masih pending).
     */
    public function cancelPenaltyPayment(Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $pendingPayment = $rental->pendingPenaltyPayment;

        if (!$pendingPayment) {
            return back()->with('error', 'Tidak ada pembayaran pending yang bisa dibatalkan.');
        }

        // Pastikan statusnya memang 'pending'
        if ($pendingPayment->payment_status !== 'pending') {
             return back()->with('error', 'Pembayaran ini tidak bisa dibatalkan.');
        }

        try {
            DB::beginTransaction();

            // Hapus file
            if ($pendingPayment->payment_proof) {
                Storage::disk('public')->delete($pendingPayment->payment_proof);
            }
            
            // Hapus record payment
            $pendingPayment->delete();

            // Reset data di rental
            $rental->update([
                'tanggal_bayar_denda' => null,
                'bukti_bayar_denda' => null,
            ]);

            DB::commit();

            return redirect()->route('user.rentals.show', $rental->id)
                ->with('success', 'Pembayaran denda berhasil dibatalkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}