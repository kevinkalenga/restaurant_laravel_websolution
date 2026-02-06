
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
// Cette seule ligne crée automatiquement toutes les routes CRUD pour les sliders.(php artisan route:list)
Route::resource('/sliders', SliderController::class);


