
<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController;








// auth vient de larav breeze et on verif middleware (le prefix est dans bootstrap/app.php)
Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/profile', [ProfileController::class, 'index'])->name('admin.profile');
Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('admin.profile.update');

//  Route::get('/login', [AdminAuthController::class, 'index'])->name('admin.login');