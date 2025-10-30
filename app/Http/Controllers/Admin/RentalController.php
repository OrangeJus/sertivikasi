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

            $rental->update(['status' => $newStatus]);

            // adjust genset status based on rental status transitions
            $genset = Genset::find($rental->genset_id);
            if (!$genset) {
                return;
            }

            if ($oldStatus !== 'active' && $newStatus === 'active') {
                $genset->update(['status' => 'disewa']);
            } elseif (in_array($newStatus, ['selesai','batal'])) {
                // only set to tersedia if not reserved by other active rentals
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
