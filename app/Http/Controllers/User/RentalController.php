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

class RentalController extends Controller
{
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
            ]);

            DB::commit();

            return redirect()->route('user.rentals.show', $rental->id)
                ->with('success', 'Permintaan penyewaan berhasil dibuat. Menunggu konfirmasi admin.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Delete uploaded file if exists
            if (isset($paymentProofPath)) {
                \Storage::disk('public')->delete($paymentProofPath);
            }
            
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Rental $rental)
    {
        if ($rental->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $rental->load('genset', 'payment');
        return view('user.rentals.show', compact('rental'));
    }
}