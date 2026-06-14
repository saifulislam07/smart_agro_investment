<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\InvestmentController as AdminInvestmentController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvestmentController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

Route::get('/about-us', [PageController::class, 'about'])->name('about');
Route::redirect('/about', '/about-us');
Route::get('/properties', [PageController::class, 'properties'])->name('properties.index');
Route::get('/products', [PageController::class, 'products'])->name('products.index');
Route::get('/ngo-activities', [PageController::class, 'ngoActivities'])->name('ngo.activities');
Route::get('/ngo-activities/{slug}', [PageController::class, 'ngoActivityShow'])->name('ngo.activities.show');
Route::get('/news', [PageController::class, 'news'])->name('news');
Route::get('/news/{post}', [PageController::class, 'newsShow'])->name('news.show');
Route::get('/blogs', [PageController::class, 'blogs'])->name('blogs');
Route::get('/blogs/{post}', [PageController::class, 'blogShow'])->name('blogs.show');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/refund-policy', [PageController::class, 'refund'])->name('refund');
Route::get('/delivery-policy', [PageController::class, 'delivery'])->name('delivery');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/risk-disclosure', [PageController::class, 'risk'])->name('risk');
Route::get('/contact-us', [ContactController::class, 'create'])->name('contact');
Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.store');
Route::redirect('/contact', '/contact-us');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('login.store');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::post('/projects/{project}/invest', [InvestmentController::class, 'store'])->name('investments.store');
    Route::get('/investments/{investment}/edit', [InvestmentController::class, 'edit'])->name('investments.edit');
    Route::put('/investments/{investment}', [InvestmentController::class, 'update'])->name('investments.update');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', AdminDashboardController::class)->name('dashboard');
        Route::resource('projects', AdminProjectController::class)->except(['show']);
        Route::resource('investments', AdminInvestmentController::class)->only(['index']);
        Route::post('/investments/{investment}/approve', [AdminInvestmentController::class, 'approve'])->name('investments.approve');
        Route::post('/investments/{investment}/reject', [AdminInvestmentController::class, 'reject'])->name('investments.reject');
        Route::resource('users', AdminUserController::class)->only(['index']);
        Route::get('/reports/investments', [AdminReportController::class, 'investments'])->name('reports.investments');
    });
});
