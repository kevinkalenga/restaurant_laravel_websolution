
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
use App\Http\Controllers\Admin\ProductOptionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DeliveryAreaController;
use App\Http\Controllers\Admin\PaymentGatewaySettingController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\DailyOfferController;
use App\Http\Controllers\Admin\BannerSliderController;
use App\Http\Controllers\Admin\ChefController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\CounterController;
use App\Http\Controllers\Admin\AppDownloadSectionController;








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

// Coupon Routes
Route::resource('/coupon', CouponController::class);


// Delivery Area Routes
Route::resource('/delivery-area', DeliveryAreaController::class);


// Orders Routes 
Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/pending-orders', [OrderController::class, 'pendingOrdersIndex'])->name('pending-orders');
Route::get('/pending-orders/data', [OrderController::class, 'pendingOrders'])->name('orders.pending.data');
Route::get('/in-process-orders', [OrderController::class, 'inProcessOrdersIndex'])->name('in-process-orders');
Route::get('/in-process-orders/data', [OrderController::class, 'inProcessOrders'])->name('orders.in-process.data');
Route::get('/delivered-orders', [OrderController::class, 'deliveredOrdersIndex'])->name('delivered-orders');
Route::get('/delivered-orders/data', [OrderController::class, 'deliveredOrders'])->name('orders.delivered.data');
Route::get('/declined-orders', [OrderController::class, 'declinedOrdersIndex'])->name('declined-orders');
Route::get('/declined-orders/data', [OrderController::class, 'declinedOrders'])->name('orders.declined.data');
Route::get('orders/{order}', [OrderController::class,'show'])
    ->name('orders.show');

Route::get('orders/{order}/edit', [OrderController::class,'edit'])
    ->name('orders.edit');

Route::delete('orders/{order}', [OrderController::class, 'destroy'])
    ->name('orders.destroy');

// Récupérer le statut de la commande
Route::get('/orders/status/{id}', [OrderController::class, 'getOrderStatus'])
    ->name('orders.status');

// Modifier le statut de la commande
Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])
    ->name('orders.update-status');

// Order Notification Routes
Route::get('clear-notification', [AdminDashboardController::class, 'clearNotification'])->name('clear-notification');

// Chat routes
Route::get('chat', [ChatController::class, 'index'])->name('chat.index');
Route::get('chat/get-conversation/{senderId}', [ChatController::class, 'getConversation'])->name('chat.get-conversation');
Route::post('chat/send-message', [ChatController::class, 'sendMessage'])->name('chat.send-message');

// Daily Offer routes
Route::get('dayly-offer/search-product', [DailyOfferController::class, 'productSearch'])->name('dayly-offer.search-product');
Route::resource('dayly-offer', DailyOfferController::class);
Route::put('/daily-offer-title-update', [DailyOfferController::class, 'updateTitle'])->name('daily-offer-title.update');

// Banner Slider routes
Route::resource('/banner-slider', BannerSliderController::class);


//Chef routes
Route::put('/chefs-title-update', [ChefController::class, 'updateTitle'])->name('chefs-title.update');
Route::resource('/chefs', ChefController::class);


//App Download Routes
Route::get('app-download', [AppDownloadSectionController::class, 'index'])->name('app-download.index');
Route::post('app-download', [AppDownloadSectionController::class, 'store'])->name('app-download.store');

//Testimonial Routes 
Route::put('/testimonial-title-update', [TestimonialController::class, 'updateTitle'])->name('testimonial-title.update');
Route::resource('testimonial', TestimonialController::class);



//Counter Routes 
Route::get('counter', [CounterController::class, 'index'])->name('counter.index');
Route::put('counter', [CounterController::class, 'update'])->name('counter.update');



// Product Option Routes

Route::resource('/product-option', ProductOptionController::class);

// Setting Payment Gateway Routes
Route::get('/payment-gateway-setting', [PaymentGatewaySettingController::class, 'index'])->name('payment-setting.index');
Route::put('/paypal-setting', [PaymentGatewaySettingController::class, 'paypalSettingUpdate'])->name('paypal-setting.update');
Route::put('/stripe-setting', [PaymentGatewaySettingController::class, 'stripeSettingUpdate'])->name('stripe-setting.update');

// Setting Routes
Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
Route::put('/general-setting', [SettingController::class, 'UpdateGeneralSetting'])->name('general-setting.update');
Route::put('/pusher-setting', [SettingController::class, 'UpdatePusherSetting'])->name('pusher-setting.update');



