<?php
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
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use App\Http\Controllers\web\UserMailSettingController;
use App\Models\Plan;
use App\Models\PlanOrder;
use App\Models\MailAvailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

// ... existing routes ...

Route::post('/start-trial', [HomeController::class, 'startTrial'])->name('start.trial');

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/find-niches', [BlogController::class, 'findNiches'])->name('find.niches');

Route::get('/about', fn() => view('web.about'))->name('about');
Route::get('/contact', fn() => view('web.contact'))->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/newsletter/subscribe', function() {
    return redirect()->route('contact');
})->name('newsletter.subscribe.get');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'store'])->name('newsletter.subscribe');


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
Route::get('/mailtemp',[HomeController::class,'mailtemp'])->name('mailtemp');

// Public route to store intended plan in session for guests
Route::post('/intent/plan', [HomeController::class, 'storeIntentPlan'])->name('intent.plan');

Route::middleware(['web'])->group(function () {
    Route::post('/checkout/create-order', [CheckoutController::class, 'createOrder'])->name('checkout.create-order');
    Route::post('/checkout/capture-payment', [CheckoutController::class, 'capturePayment'])->name('checkout.capture-payment');
    Route::post('/checkout/webhook', [CheckoutController::class, 'webhook'])->name('checkout.webhook');

    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])->name('checkout.cancel');
});
// Checkout routes (require authentication AND email verification)
Route::get('/find-niches', [BlogController::class, 'findNiches'])->name('find.niches');
Route::get('/term-of-service', [HomeController::class, 'termsOfService'])->name('terms-of-service');
Route::get('/privacy-policy', [HomeController::class, 'pirvecyPolicy'])->name('privacy-policy');
// Define specific checkout routes before the parameterized one
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/checkout/free-complete', [CheckoutController::class, 'completeTrial'])->name('checkout.free-complete');
    Route::match(['GET', 'POST'], '/checkout/{plan?}', [CheckoutController::class, 'show'])->name('checkout');


    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/mail/{id}', [BlogController::class, 'viewMail'])->name('blog.viewMail');
    Route::post('/sendMail', [BlogController::class, 'sendMail'])->name('blog.sendMail');
    Route::post('/singleMail', [BlogController::class, 'singleMail'])->name('blog.singleMail');

    Route::get('/mail-history', [MailController::class, 'mailHistory'])->name('blog.mailHistory');
    Route::get('/viewMail/{id}', [MailController::class, 'viewMail'])->name('blog.view-mail');
    
    
    //order routes
    Route::get('/my-orders', [OrderController::class, 'index'])->name('my-orders');
    Route::get('/my-orders/{id}', [OrderController::class, 'show'])->name('view-my-order');
    Route::get('/billing',[OrderController::class,'billing'])->name('order-billing');
    //contact routes
    
});
//user mail setting
Route::prefix('mail-setting')->middleware(['auth', 'verified'])->group(function () {

    Route::get('/',[UserMailSettingController::class,'mailSetting'])->name('mail-setting');
    Route::get('/add-mail',[UserMailSettingController::class,'addMail'])->name('add-mail');
    Route::post('/add-mail',[UserMailSettingController::class,'store'])->name('mail-store');
    Route::get('/edit-mail/{id}',[UserMailSettingController::class,'editMail'])->name('edit-mail-setting');
    Route::post('/update-mail/{id}',[UserMailSettingController::class,'updateMail'])->name('mail-update');
    Route::post('/admin/email/set-primary', [UserMailSettingController::class, 'setPrimary'])->name('setPrimary');
    Route::delete('/delete-mail/{id}',[UserMailSettingController::class,'destroy'])->name('mail-delete');

});

// Authenticated routes (require authentication only)
Route::middleware('auth')->group(function () {
    // Email verification notice (requires authenticated user)
    // Route::get('verify-email', EmailVerificationPromptController::class)
    //     ->name('verification.notice');

    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('/dashboard', [App\Http\Controllers\web\UserController::class, 'dashboard'])->name('dashboard');

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
        ->name('logout')->withoutMiddleware(ValidateCsrfToken::class);  // Skip CSRF only here;

    // Start Trial (no email verification required)
    Route::post('/trial/start', [HomeController::class, 'startTrial'])->name('trial.start');
    // Complete Trial (commit trial to DB)
    Route::post('/trial/complete', [HomeController::class, 'completeTrial'])->name('trial.complete');
});

// In routes/web.php, ensure this route is outside auth middleware
// Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
//     ->middleware(['signed', 'throttle:6,1'])
//     ->name('verification.verify');



// Remove this line since all routes are now in web.php
// require __DIR__.'/auth.php';
