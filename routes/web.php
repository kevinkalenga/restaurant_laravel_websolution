<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Frontend\ProfileController;



Route::get('/', [FrontendController::class, 'index'])->name('home');


Route::group(['middleware' => 'auth'], function(){
  Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
  Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
  Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});


// Admin Auth route
Route::get('admin/login', [AdminAuthController::class, 'index'])->name('admin.login');



require __DIR__.'/auth.php';
// require __DIR__.'/admin.php';

