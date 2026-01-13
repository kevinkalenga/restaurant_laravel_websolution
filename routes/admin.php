
<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SliderController;








// auth vient de larav breeze et on verif middleware (le prefix est dans bootstrap/app.php)
Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update'); 

//** Slider Route **/
Route::resource('/sliders', SliderController::class);


