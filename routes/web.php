<?php

use App\Http\Controllers\AirConditionerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ContractItemController;
use App\Http\Controllers\ServiceOrderController;
use App\Http\Controllers\TicketController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::middleware(['auth:sanctum', 'verified'])->resource('brands', BrandController::class);
Route::middleware(['auth:sanctum', 'verified'])->resource('contract_items', ContractItemController::class);
Route::middleware(['auth:sanctum', 'verified'])->resource('air_conditioners', AirConditionerController::class);
Route::middleware(['auth:sanctum', 'verified'])->resource('air_conditioners.tickets', TicketController::class);
Route::middleware(['auth:sanctum', 'verified'])->resource('air_conditioners.service_orders', ServiceOrderController::class);