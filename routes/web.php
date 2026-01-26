<?php

use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\Frontend\ArticleController as PublicArticleController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\VideoController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

Route::get('lang/{locale}', [LanguageController::class, 'setLocale'])->name('lang.switch');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::post('/newsletter', [HomeController::class, 'subscribe'])->name('newsletter.subscribe');

Route::get('/articles/{article:slug}', [PublicArticleController::class, 'show'])->name('articles.show');
Route::post('/articles/{article:slug}/comment', [PublicArticleController::class, 'comment'])
    ->middleware('auth')
    ->name('articles.comment');

Route::get('/categories/{category:slug}', [PublicArticleController::class, 'category'])->name('categories.show');
Route::get('/videos', [VideoController::class, 'index'])->name('videos.index');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.perform');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.perform');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin,editor'])
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

        Route::get('/articles/{article}/preview', [AdminArticleController::class, 'preview'])
            ->name('articles.preview');
        Route::patch('/articles/{article}/publish', [AdminArticleController::class, 'publish'])
            ->name('articles.publish');
        Route::resource('articles', AdminArticleController::class)->except(['show']);

        Route::resource('videos', AdminVideoController::class)->except(['show']);

        Route::middleware('role:admin')->group(function () {
            Route::resource('users', AdminUserController::class);
            Route::get('/roles', [AdminRoleController::class, 'index'])->name('roles.index');

            Route::get('/comments', [AdminCommentController::class, 'index'])->name('comments.index');
            Route::patch('/comments/{comment}/approve', [AdminCommentController::class, 'approve'])->name('comments.approve');
            Route::patch('/comments/{comment}/reject', [AdminCommentController::class, 'reject'])->name('comments.reject');
            Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');

            Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
            Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
            Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
            Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
        });
    });
