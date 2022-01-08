<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppsController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\UserInterfaceController;
use App\Http\Controllers\CardsController;
use App\Http\Controllers\ComponentsController;
use App\Http\Controllers\ExtensionController;
use App\Http\Controllers\PageLayoutController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\MiscellaneousController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CapacityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChartsController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (!Auth::check()) {
        return redirect('/login');
    } else {
        $user = Auth::user();
        if ( $user->hasRole('Admin')) {
            return redirect('/dashboard');
        } elseif ($user->hasRole('Appointment Manager')) {
            return redirect('/dashboard');
        } elseif ($user->hasRole('Advertising Manager')) {
            return redirect('/dashboard');
        } elseif ($user->hasRole('User')) {
            return redirect('/home');
        } else {
            return redirect('/dashboard');
        }
    }
});

Route::group(
    [
        'middleware' => 'auth'
    ],
    function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    }
);

Route::group(
    [
        'middleware' => 'auth'
    ],
    function () {

        Route::group(
            [
                'prefix' => 'admin',
                'as' => 'admin.'
            ],
            function () {

                Route::group(
                    [
                        'prefix' => 'users',
                        'as' => 'users.'
                    ],
                    function () {
                        Route::get('/manage', [UserController::class, 'manage'])->name('manage');
                        Route::get('/users', [UserController::class, 'users'])->name('users');
                        Route::post('/edit', [UserController::class, 'edit'])->name('edit');
                        Route::post('/save', [UserController::class, 'save'])->name('save');
                        // Route::post('/edit/role', [UserController::class, 'edit_role'])->name('edit.role');
                        Route::post('/remove', [UserController::class, 'remove'])->name('remove');
                    }
                );
                Route::group(
                    [
                        'prefix' => 'categories',
                        'as' => 'categories.'
                    ],
                    function () {
                        Route::get('/manage', [CategoryController::class, 'manage'])->name('manage');
                        Route::post('/save', [CategoryController::class, 'save'])->name('save');
                        Route::get('/categories', [CategoryController::class, 'categories'])->name('categories');
                        // Route::get('/single/{id}', [CategoryController::class, 'single'])->name('single');
                        Route::post('/edit', [CategoryController::class, 'edit'])->name('edit');
                        Route::post('/remove', [CategoryController::class, 'remove'])->name('remove');
                    }
                );
                Route::group(
                    [
                        'prefix' => 'attributes',
                        'as' => 'attributes.'
                    ],
                    function () {
                        Route::get('/manage', [AttributeController::class, 'manage'])->name('manage');
                        Route::get('/update/{id}', [AttributeController::class, 'update'])->name('update');
                        Route::post('/save', [AttributeController::class, 'save'])->name('save');
                        Route::get('/attributes', [AttributeController::class, 'attributes'])->name('attributes');
                        // Route::get('/single/{id}', [AttributeController::class, 'single'])->name('single');
                        Route::post('/edit', [AttributeController::class, 'edit'])->name('edit');
                        Route::post('/remove', [AttributeController::class, 'remove'])->name('remove');
                    }
                );
                Route::group(
                    [
                        'prefix' => 'colors',
                        'as' => 'colors.'
                    ],
                    function () {
                        Route::get('/manage', [ColorController::class, 'manage'])->name('manage');
                        Route::post('/save', [ColorController::class, 'save'])->name('save');
                        Route::get('/colors', [ColorController::class, 'colors'])->name('colors');
                        // Route::get('/single/{id}', [ColorController::class, 'single'])->name('single');
                        Route::post('/edit', [ColorController::class, 'edit'])->name('edit');
                        Route::post('/remove', [ColorController::class, 'remove'])->name('remove');
                    }
                );
                Route::group(
                    [
                        'prefix' => 'capacities',
                        'as' => 'capacities.'
                    ],
                    function () {
                        Route::get('/manage', [CapacityController::class, 'manage'])->name('manage');
                        Route::post('/save', [CapacityController::class, 'save'])->name('save');
                        Route::get('/capacities', [CapacityController::class, 'capacities'])->name('capacities');
                        // Route::get('/single/{id}', [CapacityController::class, 'single'])->name('single');
                        Route::post('/edit', [CapacityController::class, 'edit'])->name('edit');
                        Route::post('/remove', [CapacityController::class, 'remove'])->name('remove');
                    }
                );
                Route::group(
                    [
                        'prefix' => 'products',
                        'as' => 'products.'
                    ],
                    function () {
                        Route::get('/manage', [ProductController::class, 'manage'])->name('manage');
                        Route::post('/save', [ProductController::class, 'save'])->name('save');
                        Route::get('/products', [ProductController::class, 'products'])->name('categories');
                        // Route::get('/single/{id}', [ProductController::class, 'single'])->name('single');
                        Route::post('/edit', [ProductController::class, 'edit'])->name('edit');
                        Route::post('/remove', [ProductController::class, 'remove'])->name('remove');
                    }
                );
                Route::group(
                    [
                        'prefix' => 'suppliers',
                        'as' => 'suppliers.'
                    ],
                    function () {
                        Route::get('/manage', [SupplierController::class, 'manage'])->name('manage');
                        Route::post('/save', [SupplierController::class, 'save'])->name('save');
                        Route::get('/suppliers', [SupplierController::class, 'suppliers'])->name('suppliers');
                        // Route::get('/single/{id}', [SupplierController::class, 'single'])->name('single');
                        Route::post('/edit', [SupplierController::class, 'edit'])->name('edit');
                        Route::post('/remove', [SupplierController::class, 'remove'])->name('remove');
                    }
                );
            }
        );
    }
);
/* Route Pages */
Route::get('/error', [MiscellaneousController::class, 'error'])->name('error');


// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);

Auth::routes();
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
