<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Genset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;    // Ditambahkan
use Illuminate\Support\Facades\Storage; // Ditambahkan

class RentalController extends Controller
{
    /**
     * Menampilkan daftar semua rental.
     */
    public function index(Request $request)
    {
        $query = Rental::with('genset', 'user');

        if ($q = $request->input('q')) {
            $query->whereHas('user', function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%");
            })->orWhereHas('genset', function ($sub) use ($q) {
                $sub->where('nama_genset', 'like', "%{$q}%");
            });
        }

        $rentals = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        return view('admin.rentals.index', compact('rentals'));
    }

    /**
     * Menampilkan detail rental.
     */
    public function show(Rental $rental)
    {
        // Memuat semua relasi yang diperlukan untuk view admin
        $rental->load('user', 'genset', 'payment', 'pendingPenaltyPayment');
        return view('admin.rentals.show', compact('rental'));
    }

    /**
     * Update status rental (misal: dari 'pending' ke 'active').
     * Ini adalah method UPDATE BARU Anda.
     */
    public function update(Request $request, Rental $rental)
    {
        $request->validate(['status' => 'required|in:pending,active,selesai,batal']);

        DB::transaction(function () use ($request, $rental) {
            $oldStatus = $rental->status;
            $newStatus = $request->status;

            // Logika baru jika menyelesaikan rental
            if ($newStatus === 'selesai' && $oldStatus === 'active') {
                $rental->tanggal_pengembalian_aktual = now();

                // Cek keterlambatan
                if ($rental->isOverdue()) {
                    // Harus sudah ada pembayaran denda yang terverifikasi
                    if (!$rental->isPenaltyPaidAndVerified()) {
                        throw new \Exception('Verifikasi pembayaran denda terlebih dahulu sebelum menyelesaikan rental.');
                    }
                    $rental->hari_keterlambatan = $rental->getOverdueDays();
                    // Denda sudah di-set saat proses verifikasi pembayaran
                }
            }

            $rental->update(['status' => $newStatus]);

            // Sesuaikan status genset
            $genset = Genset::find($rental->genset_id);
            if (!$genset) {
                return;
            }

            // Jika diaktifkan, genset jadi 'disewa'
            if ($oldStatus !== 'active' && $newStatus === 'active') {
                $genset->update(['status' => 'disewa']);
            } 
            // Jika selesai atau batal, cek apakah ada rental lain yang aktif
            elseif (in_array($newStatus, ['selesai', 'batal'])) {
                $otherActive = Rental::where('genset_id', $genset->id)
                    ->where('id', '!=', $rental->id)
                    ->where('status', 'active')
                    ->exists();
                
                if (!$otherActive) {
                    $genset->update(['status' => 'tersedia']);
                }
            }
        });

        return redirect()->back()->with('success', 'Status rental diperbarui.');
    }

    /**
     * Method BARU: Verifikasi pembayaran denda.
     */
    public function verifyPenaltyPayment(Request $request, Rental $rental)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'rejection_reason' => 'required_if:action,reject|nullable|string|max:500',
        ]);

        $pendingPayment = $rental->pendingPenaltyPayment;
        if (!$pendingPayment) {
            return back()->with('error', 'Tidak ada pembayaran denda yang perlu diverifikasi.');
        }

        try {
            DB::beginTransaction();

            if ($request->action === 'approve') {
                // 1. Setujui pembayaran
                $pendingPayment->update([
                    'payment_status' => 'paid',
                    'verified_by' => Auth::id(),
                    'verified_at' => now(),
                ]);

                // 2. Update status denda di rental
                $rental->update([
                    'denda' => $pendingPayment->amount,
                    'denda_dibayar' => true,
                    'denda_verified_by' => Auth::id(),
                    'denda_verified_at' => now(),
                ]);

                DB::commit();
                return back()->with('success', 'Pembayaran denda berhasil diverifikasi. User sekarang dapat request pengembalian.');

            } else {
                // 1. Tolak pembayaran
                $pendingPayment->update([
                    'payment_status' => 'cancelled',
                    'verified_by' => Auth::id(),
                    'verified_at' => now(),
                    'rejection_reason' => $request->rejection_reason,
                ]);

                // 2. Hapus file bukti bayar
                if ($pendingPayment->payment_proof) {
                    Storage::disk('public')->delete($pendingPayment->payment_proof);
                }

                // 3. Reset status denda di rental
                $rental->update([
                    'tanggal_bayar_denda' => null,
                    'bukti_bayar_denda' => null,
                ]);

                DB::commit();
                return back()->with('success', 'Pembayaran denda ditolak. User dapat mengupload ulang bukti pembayaran.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Method BARU: Menyetujui/menolak request pengembalian dari user.
     */
    public function approveReturnRequest(Request $request, Rental $rental)
    {
        if ($rental->status_pengembalian !== 'diminta') {
            return back()->with('error', 'Tidak ada request pengembalian yang perlu disetujui.');
        }

        $request->validate([
            'action' => 'required|in:approve,reject',
            'catatan_admin' => 'required_if:action,reject|nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            if ($request->action === 'approve') {
                // Cek denda jika terlambat
                if ($rental->isOverdue() && !$rental->isPenaltyPaidAndVerified()) {
                    throw new \Exception('Verifikasi pembayaran denda terlebih dahulu.');
                }

                // 1. Setujui pengembalian
                $rental->update([
                    'status' => 'selesai',
                    'status_pengembalian' => 'disetujui',
                    'tanggal_pengembalian_aktual' => now(),
                    'catatan_pengembalian_admin' => $request->catatan_admin,
                ]);

                // 2. Update status genset
                $genset = $rental->genset;
                $otherActive = Rental::where('genset_id', $genset->id)
                    ->where('id', '!=', $rental->id)
                    ->where('status', 'active')
                    ->exists();
                if (!$otherActive) {
                    $genset->update(['status' => 'tersedia']);
                }

                DB::commit();
                return back()->with('success', 'Request pengembalian berhasil disetujui.');

            } else {
                // 1. Tolak pengembalian
                $rental->update([
                    'status_pengembalian' => 'ditolak',
                    'catatan_pengembalian_admin' => $request->catatan_admin,
                ]);
                DB::commit();
                return back()->with('success', 'Request pengembalian ditolak.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}

