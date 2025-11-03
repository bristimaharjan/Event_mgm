<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChirpController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorEventController;
use App\Http\Controllers\VendorVenueController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorForgotPasswordController;
use App\Http\Controllers\KhaltiController;
use App\Http\Controllers\VenueBookingController;
use App\Http\Controllers\ReviewController;


Route::get('/', function () {
    return view('welcome');
});


// Route::get('/about', function () {
//     return view('about');
// });


// http verbs
// get, post, put/patch, delete, any, match 

// Route::get('/user', function () {
//     return 'User Access';
// });

// Route::post('/user', function (){
//     return 'User Created';
// });

// Route::match(['get', 'post'], '/user', function () {
//     return 'User Access';
// });

// Route::put('/user/{id}', function ($id) {
//     return "User with ID {$id} updated";
// });

// Route::patch('/user/{id}', function ($id) {
//     return "User with ID {$id} partially updated";
// });

// Route::delete('/user/{id}', function ($id) {
//     return "User with ID {$id} deleted";
// });

// Route::any('/anything', function() {
//     return 'Matched any HTTP method';
// });



// // Route parameter
// Route::get('/user/{id}', function ($id) {
//     return "User with ID {$id}";
// });


// // optional Route parameter
// Route::get('/user/{id?}', function ($id = null) {
//     return "User with ID {$id}";
// });


//multiple parameter
// Route::get('/user/{id}/{name}', function ($id, $name) {
//     return "User with ID {$id} and Name {$name}";
// });



// // named parameter
// Route::get('/user/{id}', function ($id) {
//     return "User id {$id}";
// })->name('user.show');

// // grouping
// Route::prefix('admin')->group(function (){
//     Route::get('/dashboard', function (){
//         return 'Admin Dashboard';
//     });

//     Route::get('/settings', function (){
//         return 'Admin Settings';
//     });

// });

// // middleware
// Route::middleware(['auth'])->group(function (){
//     Route::get('/profile', function (){
//         return 'User Profile';
//     });

//     Route::get('/settings', function (){
//         return 'User Settings';
//     });
// });

// // combine 
// Route::prefix('admin')->middleware(['auth'])->group(function () {
//     Route::get('/dashboard', function (){
//         return 'Admin Dashboard';
//     });

//     Route::get('/settings', function (){
//         return 'Admin Settings';
//     });
// });


// // Constraint 
// Route::get('/user/{id}', function ($id){
//     return "User with ID {$id}";
// })->where('id', '[0-9]+');

// Route::get('/post/{slug}', function ($slug){
//     return "Post with Slug {$slug}";
// })->where('slug', '[a-zA-Z0-9-]+');

// fallback
Route::fallback(function () {
    return view('errors.404');
});

// Route::get('/posts', [PostControllercls::class, 'index'])->name('posts.index');
// Route::get('/posts/create', [PostControllercls::class, 'create'])->name('posts.create');
// Route::post('/posts', [PostControllercls::class, 'store'])->name('posts.store');
// Route::get('/posts/{$id}', [PostControllercls::class, 'show'])->name('posts.show');
// Route::get('/posts/{$id}/edit', [PostControllercls::class, 'edit'])->name('posts.edit');
// Route::put('/posts/{$id}', [PostControllercls::class, 'update'])->name('posts.update');
// Route::delete('/posts/{$id}', [PostControllercls::class, 'destory'])->name('posts.destory');

// alternative for above 7 routes
// Route::resource('/posts', PostControllercls::class);

// Route::resource('/posts', PostControllercls::class)->only(['index', 'show']);

// Route::resource('/posts', PostControllercls::class)->except(['destory', 'update']);


// // grouping postController routes
// Route::controller(PostControllercls::class)->group(function (){
//     Route::get('/posts', 'index')->name('posts.index');
//     Route::get('/posts/create', 'create')->name('posts.create');
//     Route::post('/posts', 'store')->name('posts.store');
//     Route::get('/posts/{id}', 'show')->name('posts.show');
//     Route::get('/posts/{id}/edit', 'edit')->name('posts.edit');
//     Route::put('/posts/{id}', 'update')->name('posts.update');
//     Route::delete('/posts/{id}', 'destroy')->name('posts.destroy');
// });
Route::get('/venues', [ChirpController::class, 'venues'])->name('venues');


Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// For root URL
Route::get('/', [ChirpController::class, 'showWelcomePage']);

// For /welcome URL
Route::get('/welcome', [ChirpController::class, 'showWelcomePage'])->name('welcome');

Route::get('/about',[ChirpController::class, 'about'])->name('about');
Route::get('/contact',[ChirpController::class, 'contact'])->name('contact');
Route::post('/contact', [ChirpController::class, 'storeContact'])->name('contact.store');
Route::get('/events',[ChirpController::class, 'events'])->name('events');
// Route::resource('events', ChirpController::class);
// Route::get('/events/{id}', [ChirpController::class, 'show'])->name('events.show');
Route::get('/venues', [ChirpController::class, 'venues'])->name('venues');
Route::get('/userbooking', [UserController::class, 'showReport'])->name('userbooking');
Route::get('/usereventbook', [UserController::class, 'showUserEvent'])->name('usereventbook');


Route::middleware(['auth'])->group(function (){
    Route::get('/chirps', [ChirpController::class, 'index'])->name('chirps.index');
    Route::post('/chirps', [ChirpController::class, 'store'])->name('chirps.store');

    Route::get('/chirps/{id}/edit', [ChirpController::class, 'edit'])->name('chirps.edit');
    Route::put('/chirps/{id}', [ChirpController::class, 'update'])->name('chirps.update');

    Route::delete('/chirps/{id}', [ChirpController::class, 'destroy'])->name('chirps.destroy');
    Route::post('/events/{event}/book', [ChirpController::class, 'book'])->name('events.book');

});


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/chirps', [ChirpController::class, 'adminIndex'])->name('chirps.adminIndex');
    Route::post('/admin/chirps', [ChirpController::class, 'adminStore'])->name('chirps.adminStore');
    Route::get('/admin/users/{id}/edit', [UserController::class, 'adminEdit'])->name('users.adminEdit');
    Route::put('/admin/users/{id}', [UserController::class, 'adminUpdate'])->name('users.adminUpdate');
    Route::delete('/admin/users/{id}', [UserController::class, 'adminDestroy'])->name('users.adminDestroy');
    Route::get('/admin/users', [UserController::class, 'adminView'])->name('chirps.user');
    Route::post('/admin/logout', [AuthController::class, 'logout'])->name('chirps.adminLogout');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/bookings', [UserController::class, 'bookings'])->name('profile.bookings');
    Route::get('/admin/reports/booking', [VenueBookingController::class, 'showReport'])->name('admin.reports.adminbooking');
    Route::get('/admin/reports/admineventbooking', [UserController::class, 'showAllEvents'])->name('admin.reports.admineventbooking');


});

Route::middleware(['auth', 'vendor'])->group(function () {
    Route::get('/vendor/dashboard', [VendorController::class, 'dashboard'])->name('vendor.dashboard');
    Route::post('/vendor/logout', [VendorController::class, 'logout'])->name('vendor.vendorLogout');
    Route::get('vendor/venuebooking', [VenueBookingController::class, 'showVenues'])->name('vendor.venuebooking');
    Route::get('vendor/eventbooking', [VendorEventController::class, 'showEvents'])->name('vendor.eventbooking');
    Route::get('/vendor/reports/booking', [VenueBookingController::class, 'bookingReport'])->name('vendor.reports.booking');
    Route::get('/vendor/reports/eventbooking', [VendorEventController::class, 'EventbookingReport'])->name('vendor.reports.eventbooking');


});

Route::prefix('vendor/venues')->middleware(['auth','vendor'])->group(function() {
    Route::get('/', [VendorVenueController::class, 'index'])->name('vendor.venues.index');
    Route::get('/create', [VendorVenueController::class, 'create'])->name('vendor.venues.create');
    Route::post('/', [VendorVenueController::class, 'store'])->name('vendor.venues.store');
    Route::get('/{venue}/edit', [VendorVenueController::class, 'edit'])->name('vendor.venues.edit');
    Route::put('/{venue}', [VendorVenueController::class, 'update'])->name('vendor.venues.update');
    Route::delete('/{venue}', [VendorVenueController::class, 'destroy'])->name('vendor.venues.destroy');
});

Route::prefix('vendor/events')->middleware(['auth','vendor'])->group(function() {
    Route::get('/', [VendorEventController::class, 'index'])->name('vendor.events.index');
    Route::get('/create', [VendorEventController::class, 'create'])->name('vendor.events.create');
    Route::post('/', [VendorEventController::class, 'store'])->name('vendor.events.store');
    Route::get('/{event}/edit', [VendorEventController::class, 'edit'])->name('vendor.events.edit');
    Route::put('/{event}', [VendorEventController::class, 'update'])->name('vendor.events.update');
    Route::delete('/{event}', [VendorEventController::class, 'destroy'])->name('vendor.events.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'update'])->name('profile.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::delete('/profile/photo', [UserController::class, 'deletePhoto'])->name('profile.photo.delete');

});


Route::middleware(['auth'])->group(function () {
    Route::get('/vendor/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/vendor/profile/update', [ProfileController::class, 'update'])->name('profile.updates');

});

// Forgot Password
Route::get('/vendor/forgot-password', [VendorForgotPasswordController::class, 'showForgotForm'])
    ->name('vendor.password.request');
Route::post('/vendor/forgot-password', [VendorForgotPasswordController::class, 'sendResetLink'])
    ->name('vendor.password.email');

// Reset Password
Route::get('/vendor/reset-password/{token}', [VendorForgotPasswordController::class, 'showResetForm'])
    ->name('vendor.password.reset');
Route::post('/vendor/reset-password', [VendorForgotPasswordController::class, 'reset'])
    ->name('vendor.password.update');
// Change password while logged in
Route::post('/vendor/change-password', [ProfileController::class, 'updatePassword'])
    ->name('vendor.password.change');
Route::post('/vendor/password/check', [ProfileController::class, 'checkCurrentPassword'])
     ->name('vendor.password.check');


Route::get('/payment', function () {
    return view('payment'); // corresponds to resources/views/payment.blade.php
});
Route::post('/khalti/verify', [KhaltiController::class, 'verify'])
    ->name('khalti.verify')
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
Route::post('/khalti/payment/verify',[PaymentController::class,'verifyPayment'])->name('khalti.verifyPayment');

Route::post('/khalti/payment/store',[PaymentController::class,'storePayment'])->name('khalti.storePayment');

Route::middleware(['auth'])->group(function () {
    Route::post('/venues/book', [VenueBookingController::class, 'store'])->name('venues.book');
    Route::get('/venues/{venue}/booked-dates', [VenueBookingController::class, 'getBookedDates']);
    Route::post('/venues/{id}/mark-as-paid', [VenueBookingController::class, 'markAsPaid'])->name('venue_bookings.markAsPaid');
});
Route::get('/vendor/reports/booking/pdf', [VenueBookingController::class, 'downloadBookingPdf'])->name('vendor.reports.booking.pdf');
Route::get('/admin/reports/adminbooking/pdf', [VenueBookingController::class, 'downloadAdminBookingPdf'])->name('admin.reports.adminbooking.pdf');
Route::post('/khalti/save-booking', [App\Http\Controllers\KhaltiController::class, 'saveBooking'])->name('khalti.saveBooking');
Route::delete('/venue-bookings/{id}/cancel', [VenueBookingController::class, 'cancel'])->name('venueBooking.cancel');
Route::post('/chatbot/message', [App\Http\Controllers\ChatbotController::class, 'respond'])
    ->name('chatbot.message');

Route::get('/vendor/reports/eventbooking/pdf', [VendorEventController::class, 'downloadPdf'])->name('vendor.reports.eventbooking.pdf');
Route::get('/admin/reports/admineventbooking/pdf', [UserController::class, 'downloadAdminPdf'])->name('admin.reports.admineventbooking.pdf');

Route::post('/venue-review', [ReviewController::class, 'store'])->name('venueReview.store');
Route::get('/admin/reviews', [ReviewController::class, 'index'])
    ->name('admin.reports.review');

Route::delete('/venue-review/{review}', [ReviewController::class, 'destroy'])->name('venueReview.destroy');
Route::get('/vendor/reviews', [ReviewController::class, 'vendorIndex'])
    ->name('vendor.venue-reviews')
    ->middleware('auth');
 Route::get('/venues/{venue}/reviews', [ReviewController::class, 'getVenueReviews'])->name('venues.reviews');


?>