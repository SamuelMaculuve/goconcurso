<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Company\DashboardController as CompanyDashboard;
use App\Http\Controllers\Company\ContestController as CompanyContestController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\CompanyController as AdminCompany;
use App\Http\Controllers\Admin\ContestController as AdminContest;
use App\Http\Controllers\Admin\PlanController as AdminPlan;
use App\Http\Controllers\Admin\CategoryController as AdminCategory;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
    Route::get('/register/empresa', [RegisterController::class, 'showCompanyForm'])->name('register.company');
    Route::post('/register/empresa', [RegisterController::class, 'registerCompany'])->name('register.company.post');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Contests - public
Route::get('/concursos', [ContestController::class, 'index'])->name('contests.index');
Route::get('/concursos/{slug}', [ContestController::class, 'show'])->name('contests.show');
Route::get('/concursos/{slug}/interesse', [ContestController::class, 'interestForm'])->name('contests.interest.form');
Route::post('/concursos/{slug}/interesse', [ContestController::class, 'storeInterest'])->name('contests.interest.store');

// Contests - authenticated actions
Route::middleware('auth')->group(function () {
    Route::post('/concursos/{slug}/guardar', [ContestController::class, 'save'])->name('contests.save');
    Route::get('/concursos/{slug}/candidatura', [ContestController::class, 'applyForm'])->name('contests.apply.form');
    Route::post('/concursos/{slug}/candidatura', [ContestController::class, 'apply'])->name('contests.apply');
});

// Static pages
Route::view('/sobre', 'pages.about')->name('about');
Route::get('/contacto', [HomeController::class, 'contact'])->name('contact');
Route::post('/contacto', [HomeController::class, 'sendContact'])->name('contact.send');
Route::get('/empresas', [HomeController::class, 'companies'])->name('companies');

/*
|--------------------------------------------------------------------------
| Authenticated User (Candidate) Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('perfil')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'show'])->name('show');
    Route::get('/editar', [ProfileController::class, 'edit'])->name('edit');
    Route::put('/editar', [ProfileController::class, 'update'])->name('update');
    Route::get('/candidaturas', [ProfileController::class, 'applications'])->name('applications');
    Route::get('/guardados', [ProfileController::class, 'saved'])->name('saved');
    Route::get('/interesses', [ProfileController::class, 'interests'])->name('interests');
});

/*
|--------------------------------------------------------------------------
| Company Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:company'])->prefix('empresa')->name('company.')->group(function () {
    Route::get('/dashboard', [CompanyDashboard::class, 'index'])->name('dashboard');

    Route::prefix('concursos')->name('contests.')->group(function () {
        Route::get('/', [CompanyContestController::class, 'index'])->name('index');
        Route::get('/criar', [CompanyContestController::class, 'create'])->name('create');
        Route::post('/criar', [CompanyContestController::class, 'store'])->name('store');
        Route::get('/{id}/editar', [CompanyContestController::class, 'edit'])->name('edit');
        Route::put('/{id}', [CompanyContestController::class, 'update'])->name('update');
        Route::delete('/{id}', [CompanyContestController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/interessados', [CompanyContestController::class, 'interests'])->name('interests');
        Route::get('/{id}/candidaturas', [CompanyContestController::class, 'applications'])->name('applications');
        Route::put('/{contestId}/candidaturas/{appId}/status', [CompanyContestController::class, 'updateApplicationStatus'])->name('applications.status');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:super-admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Users
    Route::prefix('utilizadores')->name('users.')->group(function () {
        Route::get('/', [AdminUser::class, 'index'])->name('index');
        Route::get('/{id}', [AdminUser::class, 'show'])->name('show');
        Route::get('/{id}/editar', [AdminUser::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminUser::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminUser::class, 'destroy'])->name('destroy');
        Route::post('/{id}/toggle', [AdminUser::class, 'toggleActive'])->name('toggle');
    });

    // Companies
    Route::prefix('empresas')->name('companies.')->group(function () {
        Route::get('/', [AdminCompany::class, 'index'])->name('index');
        Route::get('/{id}', [AdminCompany::class, 'show'])->name('show');
        Route::post('/{id}/verificar', [AdminCompany::class, 'verify'])->name('verify');
        Route::delete('/{id}', [AdminCompany::class, 'destroy'])->name('destroy');
    });

    // Contests
    Route::prefix('concursos')->name('contests.')->group(function () {
        Route::get('/', [AdminContest::class, 'index'])->name('index');
        Route::post('/{id}/aprovar', [AdminContest::class, 'approve'])->name('approve');
        Route::post('/{id}/rejeitar', [AdminContest::class, 'reject'])->name('reject');
        Route::delete('/{id}', [AdminContest::class, 'destroy'])->name('destroy');
    });

    // Plans
    Route::resource('planos', AdminPlan::class)->parameters(['planos' => 'plan'])->names([
        'index'   => 'plans.index',
        'create'  => 'plans.create',
        'store'   => 'plans.store',
        'show'    => 'plans.show',
        'edit'    => 'plans.edit',
        'update'  => 'plans.update',
        'destroy' => 'plans.destroy',
    ]);

    // Categories
    Route::resource('categorias', AdminCategory::class)->parameters(['categorias' => 'category'])->names([
        'index'   => 'categories.index',
        'create'  => 'categories.create',
        'store'   => 'categories.store',
        'show'    => 'categories.show',
        'edit'    => 'categories.edit',
        'update'  => 'categories.update',
        'destroy' => 'categories.destroy',
    ]);
});
