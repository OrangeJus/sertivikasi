<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\GensetController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\RentalController as AdminRentalController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ReportController;

use App\Http\Controllers\User\RentalController as UserRentalController;
use App\Http\Controllers\User\PaymentController as UserPaymentController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Auth;



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::fallback(function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->role === 'user') {
            return redirect()->route('user.dashboard');
        }
    }

    return redirect()->route('login');
});


Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('/dashboard', [AdminController::class,'index'])->name('dashboard');
    Route::resource('users', UserManagementController::class);
    Route::resource('gensets', GensetController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('rentals', AdminRentalController::class)->only(['index','show','update']);
    Route::resource('payments', AdminPaymentController::class)->only(['index','show','update']);
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/rentals', [ReportController::class, 'rentals'])->name('reports.rentals'); // ajax / table
    Route::get('reports/exports', [ReportController::class, 'export'])->name('reports.export'); // ?type=csv/pdf
    // tambahkan route admin lainnya di sini
});

Route::middleware(['auth','role:user'])->prefix('user')->name('user.')->group(function(){
    Route::get('/dashboard', [UserController::class,'index'])->name('dashboard');
    Route::resource('rentals', UserRentalController::class)->only(['index','create','store','show']);
    Route::resource('payments', UserPaymentController::class)->only(['index','create','store','show']);
    // route user lainnya
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
