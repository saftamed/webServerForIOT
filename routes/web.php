<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Controllers\ItemController;
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

// Route::get('/', function () {
//     return Inertia::render('Dashboard', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');
Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return Inertia::render('sa',["params"=>Auth::user()->param]);
})->name('/');
Route::middleware(['auth:sanctum', 'verified'])->get('/wifi', function () {
    return Inertia::render('wifi');
})->name('wifi');
Route::middleware('auth:sanctum')->get('/items/{id}',[ItemController::class, 'getItems']);
Route::get('/espitems/{id}',[ItemController::class, 'getEspItems']);
Route::middleware('auth:sanctum')->post('/items/set',[ItemController::class, 'setItems']);
Route::middleware('auth:sanctum')->post('/items/delete',[ItemController::class, 'deleteItem']);

Route::middleware('auth:sanctum')->post('/items/update',[ItemController::class, 'updateItem']);