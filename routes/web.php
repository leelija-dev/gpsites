<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;
use App\Models\Plan;

Route::get('/', function () {
    $plans = Plan::with('features')
        ->where('is_active', true)
        ->orderBy('price', 'asc')
        ->get();
    
    return view('web.home', compact('plans'));
})->name('home');

Route::get('/about', function () {
    return view('web.about');
});
Route::get('/contact', function () {
    return view('web.contact');
});

// Checkout routes
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
Route::post('/checkout/create-order', [CheckoutController::class, 'createOrder'])->name('checkout.create-order');
Route::post('/checkout/capture-payment', [CheckoutController::class, 'capturePayment'])->name('checkout.capture-payment');
Route::post('/checkout/webhook', [CheckoutController::class, 'webhook'])->name('checkout.webhook');
Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
