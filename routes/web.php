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


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('users', UserManagementController::class);
    Route::resource('gensets', GensetController::class);
    Route::resource('categories', CategoryController::class);

    // Rentals
    Route::get('/rentals', [AdminRentalController::class, 'index'])->name('rentals.index');
    Route::get('/rentals/{rental}', [AdminRentalController::class, 'show'])->name('rentals.show');
    Route::patch('/rentals/{rental}', [AdminRentalController::class, 'update'])->name('rentals.update');

    // Penalty & Return Verification
    Route::post('/rentals/{rental}/verify-penalty', [AdminRentalController::class, 'verifyPenaltyPayment'])->name('rentals.verify-penalty');
    Route::post('/rentals/{rental}/approve-return', [AdminRentalController::class, 'approveReturnRequest'])->name('rentals.approve-return');

    // Payments
    Route::resource('payments', AdminPaymentController::class)->only(['index', 'show', 'update']);
    
    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/rentals', [ReportController::class, 'rentals'])->name('reports.rentals'); // ajax / table
    Route::get('reports/exports', [ReportController::class, 'export'])->name('reports.export'); // ?type=csv/pdf
    
    // tambahkan route admin lainnya di sini
});

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

    // Rentals
    Route::get('/rentals', [UserRentalController::class, 'index'])->name('rentals.index');
    Route::get('/rentals/create', [UserRentalController::class, 'create'])->name('rentals.create');
    Route::post('/rentals', [UserRentalController::class, 'store'])->name('rentals.store');
    Route::get('/rentals/{rental}', [UserRentalController::class, 'show'])->name('rentals.show');

    // Return Request
    Route::get('/rentals/{rental}/request-return', [UserRentalController::class, 'requestReturn'])->name('rentals.request-return');
    Route::post('/rentals/{rental}/request-return', [UserRentalController::class, 'storeReturnRequest'])->name('rentals.store-return');

    // Penalty Payment
    Route::get('/rentals/{rental}/upload-penalty', [UserRentalController::class, 'showUploadPenalty'])->name('rentals.show-upload-penalty');
    Route::post('/rentals/{rental}/upload-penalty', [UserRentalController::class, 'uploadPenaltyProof'])->name('rentals.upload-penalty');
    Route::delete('/rentals/{rental}/cancel-penalty', [UserRentalController::class, 'cancelPenaltyPayment'])->name('rentals.cancel-penalty');
    
    // Payments
    Route::resource('payments', UserPaymentController::class)->only(['index', 'create', 'store', 'show']);
    
    // route user lainnya
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';