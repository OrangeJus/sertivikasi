<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Genset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RentalController extends Controller
{
    public function index(Request $request)
    {
        $query = Rental::with('genset','user');

        if ($q = $request->input('q')) {
            $query->whereHas('user', function($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%");
            })->orWhereHas('genset', function($sub) use ($q) {
                $sub->where('nama_genset', 'like', "%{$q}%");
            });
        }

        $rentals = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        return view('admin.rentals.index', compact('rentals'));
    }

    public function show(Rental $rental)
    {
        $rental->load('user','genset');
        return view('admin.rentals.show', compact('rental'));
    }

    public function update(Request $request, Rental $rental)
    {
        $request->validate(['status' => 'required|in:pending,active,selesai,batal']);

        DB::transaction(function() use ($request, $rental) {
            $oldStatus = $rental->status;
            $newStatus = $request->status;

            // Calculate penalty if completing rental
            if ($newStatus === 'selesai' && $oldStatus === 'active') {
                $rental->tanggal_pengembalian_aktual = now();
                
                // Check if overdue
                if (now()->greaterThan($rental->tanggal_selesai)) {
                    $hariTerlambat = now()->diffInDays($rental->tanggal_selesai);
                    $dendaPerHari = $rental->genset->harga_sewa * 2; // 2x harga sewa
                    $totalDenda = $hariTerlambat * $dendaPerHari;
                    
                    $rental->hari_keterlambatan = $hariTerlambat;
                    $rental->denda = $totalDenda;
                    
                    // Update payment amount to include penalty
                    if ($rental->payment) {
                        $rental->payment->update([
                            'amount' => $rental->total_harga + $totalDenda
                        ]);
                    }
                }
            }

            $rental->update(['status' => $newStatus]);

            // Adjust genset status based on rental status transitions
            $genset = Genset::find($rental->genset_id);
            if (!$genset) {
                return;
            }

            if ($oldStatus !== 'active' && $newStatus === 'active') {
                $genset->update(['status' => 'disewa']);
            } elseif (in_array($newStatus, ['selesai','batal'])) {
                // Only set to tersedia if not reserved by other active rentals
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
}
