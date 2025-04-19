<?php

// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Auth;


// Nyilvános útvonalak
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [PageController::class, 'bemutatkozas'])->name('bemutatkozas');
Route::get('/academy', [PageController::class, 'akademia'])->name('akademia');
Route::get('/course', [PageController::class, 'tanfolyam'])->name('tanfolyam');


// Registration routes
Route::get('/registration', [App\Http\Controllers\RegistrationController::class, 'showForm'])->name('registration');
Route::post('/registration', [App\Http\Controllers\RegistrationController::class, 'submitForm'])->name('registration.submit');
Route::post('/change-language', [App\Http\Controllers\RegistrationController::class, 'changeLanguage'])->name('change.language');



// Tanfolyam videó route-ok a frontend számára
Route::get('/course/videos', [App\Http\Controllers\CourseVideoController::class, 'index'])->name('course.videos');
Route::get('/course/videos/{id}', [App\Http\Controllers\CourseVideoController::class, 'show'])->name('course.videos.show');
Route::get('/course/videos/{id}/download', [App\Http\Controllers\CourseVideoController::class, 'download'])->name('course.videos.download')->middleware('auth');
Route::get('/course/videos/{id}/stream', [App\Http\Controllers\CourseVideoController::class, 'stream'])->name('course.videos.stream');



// Authentikáció
Auth::routes();

// Admin útvonalak
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

    // Tartalom kezelése
    Route::get('/content', [AdminController::class, 'contentList'])->name('admin.content.list');
    Route::get('/content/create', [AdminController::class, 'contentCreate'])->name('admin.content.create');
    Route::post('/content', [AdminController::class, 'contentStore'])->name('admin.content.store');
    Route::get('/content/{id}/edit', [AdminController::class, 'contentEdit'])->name('admin.content.edit');
    Route::put('/content/{id}', [AdminController::class, 'contentUpdate'])->name('admin.content.update');


    // Regisztráció kezelése
    Route::get('/registrations', [AdminController::class, 'registrationList'])->name('admin.registrations.list');
    Route::get('/registrations/{id}', [AdminController::class, 'viewRegistration'])->name('admin.registrations.view');
    Route::post('/registrations/{id}/approve', [App\Http\Controllers\Admin\AdminRegistrationController::class, 'approve'])->name('registrations.approve');
    Route::post('/registrations/{id}/reject', [App\Http\Controllers\Admin\AdminRegistrationController::class, 'reject'])->name('registrations.reject');


    // Felhasználó kezelés
    Route::resource('users', 'App\Http\Controllers\Admin\UserController')->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);

    // Tagság hosszabbítás
    Route::post('/users/{user}/extend-membership', [App\Http\Controllers\Admin\UserController::class, 'extendMembership'])->name('admin.users.extend-membership');

    // Konzultációs alkalmak kezelése
    Route::post('/users/{user}/add-consultation', [App\Http\Controllers\Admin\UserController::class, 'addConsultation'])->name('admin.users.add-consultation');
    Route::post('/users/{user}/use-consultation', [App\Http\Controllers\Admin\UserController::class, 'useConsultation'])->name('admin.users.use-consultation');

    // Kapcsolati adatok kezelése
    Route::get('/contact-info', [App\Http\Controllers\Admin\ContactInfoController::class, 'edit'])->name('admin.contact_info.edit');
    Route::post('/contact-info', [App\Http\Controllers\Admin\ContactInfoController::class, 'update'])->name('admin.contact_info.update');



    // Course Video kezelés
    Route::resource('videos', App\Http\Controllers\Admin\CourseVideoController::class)->names([
        'index' => 'admin.videos.index',
        'create' => 'admin.videos.create',
        'store' => 'admin.videos.store',
        'edit' => 'admin.videos.edit',
        'update' => 'admin.videos.update',
        'show' => 'admin.videos.show',
        'destroy' => 'admin.videos.destroy',
    ]);
    Route::post('videos/{video}/toggle-active', [App\Http\Controllers\Admin\CourseVideoController::class, 'toggleActive'])->name('admin.videos.toggle-active');
    Route::post('videos/{video}/toggle-downloadable', [App\Http\Controllers\Admin\CourseVideoController::class, 'toggleDownloadable'])->name('admin.videos.toggle-downloadable');


});



