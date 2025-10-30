<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Genset;
use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $search = $request->input('search');
        $kapasitas = $request->input('kapasitas');
        $status = $request->input('status');

        // Query gensets with filters
        $query = Genset::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_genset', 'like', "%{$search}%")
                  ->orWhere('kapasitas', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($kapasitas) {
            $query->where('kapasitas', $kapasitas);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $gensets = $query->orderBy('nama_genset')->get();

        // Get unique capacities for filter dropdown
        $capacities = Genset::select('kapasitas')
            ->distinct()
            ->orderBy('kapasitas')
            ->pluck('kapasitas');

        // Get user's rentals
        $myRentals = Rental::with('genset')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        // Statistics
        $stats = [
            'total_gensets' => Genset::count(),
            'available_gensets' => Genset::where('status', 'tersedia')->count(),
            'my_active_rentals' => Rental::where('user_id', Auth::id())
                ->where('status', 'active')
                ->count(),
            'my_total_rentals' => Rental::where('user_id', Auth::id())->count(),
        ];

        return view('user.dashboard', compact('gensets', 'capacities', 'myRentals', 'stats'));
    }
}