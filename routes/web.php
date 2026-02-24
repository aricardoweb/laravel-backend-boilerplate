<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

// dashboard pages
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('pages.dashboard.welcome', ['title' => 'Dashboard']);
    })->name('dashboard');

    // Perfil do usuário logado
    Route::get('/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\UserController::class, 'updateProfile'])->name('profile.update');

    // Gerenciamento de usuários e roles (apenas Super Admin)
    Route::middleware('role:Super Admin')->group(function () {
        Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');

        // Galeria de Imagens
        Route::get('/gallery', [App\Http\Controllers\GalleryController::class, 'index'])->name('gallery.index');
        Route::post('/gallery', [App\Http\Controllers\GalleryController::class, 'store'])->name('gallery.store');
        Route::delete('/gallery/{image}', [App\Http\Controllers\GalleryController::class, 'destroy'])->name('gallery.destroy');

        // Configurações
        Route::get('/settings', [App\Http\Controllers\SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [App\Http\Controllers\SettingController::class, 'update'])->name('settings.update');
    });

    /* Ocultando rotas de template conforme solicitação do usuário
    Route::get('/calendar', function () {
        return view('pages.calender', ['title' => 'Calendar']);
    })->name('calendar');

    Route::get('/profile', function () {
        return view('pages.profile', ['title' => 'Profile']);
    })->name('profile');

    Route::get('/form-elements', function () {
        return view('pages.form.form-elements', ['title' => 'Form Elements']);
    })->name('form-elements');

    Route::get('/basic-tables', function () {
        return view('pages.tables.basic-tables', ['title' => 'Basic Tables']);
    })->name('basic-tables');

    Route::get('/blank', function () {
        return view('pages.blank', ['title' => 'Blank']);
    })->name('blank');

    Route::get('/line-chart', function () {
        return view('pages.chart.line-chart', ['title' => 'Line Chart']);
    })->name('line-chart');

    Route::get('/bar-chart', function () {
        return view('pages.chart.bar-chart', ['title' => 'Bar Chart']);
    })->name('bar-chart');

    Route::get('/alerts', function () {
        return view('pages.ui-elements.alerts', ['title' => 'Alerts']);
    })->name('alerts');

    Route::get('/avatars', function () {
        return view('pages.ui-elements.avatars', ['title' => 'Avatars']);
    })->name('avatars');

    Route::get('/badge', function () {
        return view('pages.ui-elements.badges', ['title' => 'Badges']);
    })->name('badges');

    Route::get('/buttons', function () {
        return view('pages.ui-elements.buttons', ['title' => 'Buttons']);
    })->name('buttons');

    Route::get('/image', function () {
        return view('pages.ui-elements.images', ['title' => 'Images']);
    })->name('images');

    Route::get('/videos', function () {
        return view('pages.ui-elements.videos', ['title' => 'Videos']);
    })->name('videos');
    */
});

// authentication pages
Route::middleware('guest')->group(function () {
    Route::get('/signin', function () {
        return view('pages.auth.signin', ['title' => 'Sign In']);
    })->name('login');

    Route::get('/signup', function () {
        return view('pages.auth.signup', ['title' => 'Sign Up']);
    })->name('signup');
});

// error pages (public)
Route::get('/error-404', function () {
    return view('pages.errors.error-404', ['title' => 'Error 404']);
})->name('error-404');























// authentication API (in web group for session support)
Route::post('/api/login', [App\Http\Controllers\AuthController::class, 'login']);

// logout API (in web group for session support)
Route::post('/api/logout', [App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth');
