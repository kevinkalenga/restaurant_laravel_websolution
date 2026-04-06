
<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\WhyChooseUsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\ProductSizeController;








// auth vient de larav breeze et on verif middleware (le prefix est dans bootstrap/app.php)
Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update'); 

//** Slider Route **/
// Cette seule ligne crée automatiquement toutes les routes CRUD pour les sliders.(php artisan route:list)
Route::resource('/sliders', SliderController::class);

// Why choose us Routes
Route::put('/why-choose-title-update', [WhyChooseUsController::class, 'updateTitle'])->name('why-choose-title.update');
Route::resource('/why-choose-us', WhyChooseUsController::class);

// Product Category Routes(pour le crud)
Route::resource('/category', CategoryController::class);

// Product Routes(pour le crud)
Route::resource('/product', ProductController::class);

// Product Gellery Routes
Route::get('/product-gallery/{product}', [ProductGalleryController::class, 'index'])->name('product-gallery.show-index');
Route::resource('/product-gallery', ProductGalleryController::class);

// Product Size Routes
Route::get('/product-size/{product}', [ProductSizeController::class, 'index'])->name('product-size.show-index');
Route::resource('/product-size', ProductSizeController::class);



