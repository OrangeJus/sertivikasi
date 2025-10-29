<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;   // <-- 1. Tambahkan ini
use App\Models\Genset;  // <-- 2. Tambahkan ini

class AdminController extends Controller
{
    public function index()
    {
        // 3. Hitung data
        $totalUsers = User::count();
        $gensetTersedia = Genset::where('status', 'tersedia')->count();

        // 4. Kirim data ke view
        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'gensetTersedia' => $gensetTersedia,
        ]);
    }

}