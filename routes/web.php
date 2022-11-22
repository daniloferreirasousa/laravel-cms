<?php
// Classes nativas do laravel
use Illuminate\Support\Facades\Route;

/* Abaixo inserir as classes para ADMIN
|Exemplo de use:
| use App\Http\Controllers\Admin\NomeController;
*/
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\RegisterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\DatabaseController;

/* Abaixo inserir as classes para SITE
|Exemplo de use: 
|use App\Http\Controllers\Site\NomeController;
*/
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Site\HomeController;

// Rotas privadas de uso do painel adm
Route::prefix('panel')->group(function() {
    // Rotas com acesso apenas a usuário logado
    Route::middleware(['auth'])->group(function() {
        Route::get('/', [AdminController::class, 'index'])->name('panel.home');
        Route::get('profile', [ProfileController::class, 'index'])->name('panel.profile');
        Route::put('profilesave', [ProfileController::class, 'save'])->name('panel.profile.save');

        Route::get('settings', [SettingController::class, 'index'])->name('panel.settings');
        Route::put('settingssave', [SettingController::class, 'save'])->name('panel.settings.save');

        //Usuários administradores
        Route::middleware('can:edit-users')->group(function() {
            Route::resource('users', UserController::class);
        });
        Route::resource('pages', PageController::class);
    });
    
    // Rotas com acesso sem estar logado
    Route::get('login', [LoginController::class, 'index'])->name('panel.login');
    Route::post('login', [LoginController::class, 'authenticate']);
    Route::post('logout', [LoginController::class, 'logout']);

    Route::get('register', [RegisterController::class, 'index'])->name('panel.register');
    Route::post('register', [RegisterController::class, 'register']);
});



// Rotas padrão de uso do site
Route::prefix('/')->group(function() {
    Route::get('/', [SiteController::class, 'index'])->name('site.home');
});

Route::fallback([HomeController::class, 'index']);
