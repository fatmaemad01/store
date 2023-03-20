<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Dashboard\PageController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Models\Product;

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

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'index']);



Route::prefix('dashboard')
        ->as('dashboard.')
        // ->middleware(['auth'])
        ->group(function () {

                Route::get('/products/trash', [ProductController::class, 'trash'])
                        ->name('products.trash');
                Route::patch('/products/{product}/restore', [ProductController::class, 'restore'])
                        ->name('products.restore');

                Route::resource('/products', ProductController::class); // here the route name defined automatically
                Route::group(
                        [
                                'prefix' => '/categories',
                                'as' => 'categories.'
                        ],
                        function () {
                                // CRUD : Create , Read , Update , Delete
                                Route::get('/', [CategoriesController::class, 'index'])
                                        ->name('index');
                                // Route::get('/dashboard/categories','App\Http\Controllers\Dashboard\CategoriesController@index');  // طريقة مختصرة للتعريف

                                Route::get('/trash', [CategoriesController::class, 'trash'])
                                        ->name('trash');

                                Route::get('/create', [CategoriesController::class, 'create'])
                                        ->name('create');

                                Route::patch('/{id}/restore', [CategoriesController::class, 'restore'])
                                        ->name('restore');

                                Route::post('/', [CategoriesController::class, 'store'])
                                        ->name('store');

                                Route::get('/{id}/edit', [CategoriesController::class, 'edit'])
                                        ->name('edit');

                                Route::put('/{id}', [CategoriesController::class, 'update'])
                                        ->name('update');

                                Route::delete('/{id}', [CategoriesController::class, 'destroy'])
                                        ->name('destroy');
                        }
                );
        });


Route::get('/dashboard/breeze', function () {
        return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
