<?php
use App\Http\Controllers\web\BlogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\web\MailController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('web.home');
});

Route::get('/about', function () {
    return view('web.about');
});
Route::get('/contact', function () {
    return view('web.contact');
});
Route::get('/checkout', function () {
    return view('web.checkout');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth')->group(function () {

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/Mail/{email}', [BlogController::class, 'viewMail'])->name('blog.viewMail');
Route::post('/sendMail', [BlogController::class, 'sendMail'])->name('blog.sendMail');

Route::get('/mailHistory/{id}', [MailController::class, 'mailHistory'])->name('blog.mailHistory');
Route::get('/viewMail/{id}', [MailController::class, 'viewMail'])->name('blog.view-mail');
});
require __DIR__.'/auth.php';
