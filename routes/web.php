<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppsController;
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
use App\Http\Controllers\ChartsController;
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
                        Route::post('/edit/role', [UserController::class, 'edit_role'])->name('edit.role');
                        Route::post('/remove', [UserController::class, 'remove'])->name('remove');
                    }
                );
                Route::group(
                    [
                        'prefix' => 'categories',
                        'as' => 'categories.'
                    ],
                    function () {
                        Route::get('/manage', [AdvertisingController::class, 'manage'])->name('manage');
                        Route::post('/save', [AdvertisingController::class, 'save'])->name('save');
                        Route::get('/categories', [AdvertisingController::class, 'categories'])->name('categories');
                        Route::get('/single/{id}', [AdvertisingController::class, 'single'])->name('single');
                        Route::post('/edit', [AdvertisingController::class, 'edit'])->name('edit');
                        Route::post('/remove', [AdvertisingController::class, 'remove'])->name('remove');
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
