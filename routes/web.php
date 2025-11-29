<?php
// use App\Http\Controllers\ProfileController;
// use App\Http\Controllers\CheckoutController;
// use App\Http\Controllers\web\MailController;
// use Illuminate\Support\Facades\Route;
// use App\Models\Plan;

// Route::get('/', function () {
//     $plans = Plan::with('features')
//         ->where('is_active', true)
//         ->orderBy('price', 'asc')
//         ->get();
    
//     return view('web.home', compact('plans'));
// })->name('home');

// Route::get('/', function () {
//     $plans = Plan::with('features')
//         ->where('is_active', true)
//         ->orderBy('price', 'asc')
//         ->get();
    
//     return view('web.home', compact('plans'));
// })->name('home');

// Route::get('/about', function () {
//     return view('web.about');
// });
// Route::get('/contact', function () {
//     return view('web.contact');
// });

// // Checkout routes
// // Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
// Route::match(['GET', 'POST'], '/checkout/success', [CheckoutController::class, 'success'])
//     ->name('checkout.success');
// Route::get('/checkout/{plan?}', [CheckoutController::class, 'show'])->name('checkout');
// Route::post('/checkout/create-order', [CheckoutController::class, 'createOrder'])->name('checkout.create-order');
// Route::post('/checkout/capture-payment', [CheckoutController::class, 'capturePayment'])->name('checkout.capture-payment');
// Route::post('/checkout/webhook', [CheckoutController::class, 'webhook'])->name('checkout.webhook');
// // Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

// // Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
// Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');

// Checkout
// Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
// Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');

// Route::get('/checkout/{plan?}', [CheckoutController::class, 'show'])->name('checkout');
// Route::post('/checkout/create-order', [CheckoutController::class, 'createOrder'])->name('checkout.create-order');
// Route::post('/checkout/capture-payment', [CheckoutController::class, 'capturePayment'])->name('checkout.capture-payment');
// Route::post('/checkout/webhook', [CheckoutController::class, 'webhook'])->name('checkout.webhook');


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });


// require __DIR__.'/auth.php'; 



use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\web\BlogController;
use App\Http\Controllers\web\MailController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\web\OrderController;
use App\Http\Controllers\web\NewsletterController;  
use Illuminate\Support\Facades\Route;
use App\Models\Plan;

// ... existing routes ...




Route::get('/about', function () {
    return view('web.about');
});
Route::get('/contact', function () {
    return view('web.contact');
})->name('contact');

// Blog routes




// Email verification routes (MUST be outside auth middleware)
Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

// Guest routes (for non-authenticated users)
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::get('/',[HomeController::class,'index'])->name('home');

Route::middleware(['web'])->group(function () {
    Route::post('/checkout/create-order', [CheckoutController::class, 'createOrder'])->name('checkout.create-order');
    Route::post('/checkout/capture-payment', [CheckoutController::class, 'capturePayment'])->name('checkout.capture-payment');
    Route::post('/checkout/webhook', [CheckoutController::class, 'webhook'])->name('checkout.webhook');

    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
});
// Checkout routes (require authentication AND email verification)
 Route::get('/find-niches', [BlogController::class, 'findNiches'])->name('find.niches');
Route::middleware(['auth', 'verified'])->group(function () {
    // Route::get('/checkout/{plan?}', [CheckoutController::class, 'show'])->name('checkout');
    Route::match(['GET', 'POST'], '/checkout/{plan?}', [CheckoutController::class, 'show'])->name('checkout');


    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/mail/{id}', [BlogController::class, 'viewMail'])->name('blog.viewMail');
    Route::post('/sendMail', [BlogController::class, 'sendMail'])->name('blog.sendMail');
    Route::post('/singleMail', [BlogController::class, 'singleMail'])->name('blog.singleMail');
    // web.php
   




    Route::get('/mailHistory/{id}', [MailController::class, 'mailHistory'])->name('blog.mailHistory');
    Route::get('/viewMail/{id}', [MailController::class, 'viewMail'])->name('blog.view-mail');

    //order routes
    Route::get('/my-orders', [OrderController::class, 'index'])->name('my-orders');
    Route::get('/my-orders/{id}', [OrderController::class, 'show'])->name('view-my-order');
    Route::get('/billing',[OrderController::class,'billing'])->name('order-billing');
    //contact routes
    
});
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
// Add this near other public routes
// Add this before the POST route
Route::get('/newsletter/subscribe', function() {
    return redirect()->route('contact');
})->name('newsletter.subscribe.get');

// Keep your existing POST route
Route::post('/newsletter/subscribe', [NewsletterController::class, 'store'])->name('newsletter.subscribe');
// Authenticated routes (require authentication only)
Route::middleware('auth')->group(function () {
    // Email verification notice (requires authenticated user)
    // Route::get('verify-email', EmailVerificationPromptController::class)
    //     ->name('verification.notice');

    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');


    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

    // Start Trial (no email verification required)
    Route::post('/trial/start', [HomeController::class, 'startTrial'])->name('trial.start');
});

// In routes/web.php, ensure this route is outside auth middleware
// Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
//     ->middleware(['signed', 'throttle:6,1'])
//     ->name('verification.verify');



// Remove this line since all routes are now in web.php
// require __DIR__.'/auth.php';
