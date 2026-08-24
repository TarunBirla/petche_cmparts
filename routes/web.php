<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController as FrontProductController;
use App\Http\Controllers\Frontend\RequestController as FrontRequestController;
use App\Http\Controllers\Frontend\PageController as FrontPageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ManufacturerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\PdfController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\RequestController as AdminRequestController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/categories', [HomeController::class, 'categories'])->name('categories.index');
Route::get('/manufacturers', [HomeController::class, 'manufacturers'])->name('manufacturers.index');
Route::get('/products', [FrontProductController::class, 'index'])->name('products.index');
Route::get('/product/{slug}', [FrontProductController::class, 'show'])->name('products.show');
Route::get('/api/subcategories', [FrontProductController::class, 'getSubcategories'])->name('api.subcategories');
Route::post('/request/submit', [FrontRequestController::class, 'store'])->name('request.submit');

// Frontend CMS & Contact Pages
Route::get('/about-us', fn() => app(FrontPageController::class)->show('about-us'))->name('about-us');
Route::get('/delivery', fn() => app(FrontPageController::class)->show('delivery'))->name('delivery');
Route::get('/delivery-and-returns', fn() => app(FrontPageController::class)->show('delivery-and-returns'))->name('delivery-and-returns');
Route::get('/terms-and-conditions', fn() => app(FrontPageController::class)->show('terms-and-conditions'))->name('terms-and-conditions');
Route::get('/contact-us', [FrontPageController::class, 'showContact'])->name('contact');
Route::post('/contact-us', [FrontPageController::class, 'submitContact'])->name('contact.submit');
Route::get('/page/{slug}', [FrontPageController::class, 'show'])->name('page.show');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Panel Routes (Protected by Auth)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Modules
    Route::resource('manufacturers', ManufacturerController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('subcategories', SubCategoryController::class);
    Route::resource('pdfs', PdfController::class);
    Route::resource('products', AdminProductController::class);
    Route::resource('pages', AdminPageController::class);
    Route::resource('contact-messages', AdminContactMessageController::class)->only(['index', 'show', 'destroy']);
    Route::get('ajax/subcategories/{categoryId}', [AdminProductController::class, 'getSubcategories'])->name('products.subcategories');
    
    // Requests
    Route::get('requests', [AdminRequestController::class, 'index'])->name('requests.index');
    Route::get('requests/{productRequest}', [AdminRequestController::class, 'show'])->name('requests.show');
    Route::patch('requests/{productRequest}/status', [AdminRequestController::class, 'updateStatus'])->name('requests.update-status');
    Route::delete('requests/{productRequest}', [AdminRequestController::class, 'destroy'])->name('requests.destroy');
});
