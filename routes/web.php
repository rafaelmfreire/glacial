<?php

use App\Http\Controllers\AirConditionerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ContractItemController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\QuoteItemController;
use App\Http\Controllers\RequisitionController;
use App\Http\Controllers\RequisitionItemController;
use App\Http\Controllers\ServiceOrderController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
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

Route::redirect('/', '/login');
// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/new_user', [UserController::class, 'create'])->name('new_user');
Route::middleware(['auth:sanctum', 'verified'])->post('/new_user', [UserController::class, 'store'])->name('new_user.store');


Route::middleware(['auth:sanctum', 'verified'])->resource('brands', BrandController::class);
Route::middleware(['auth:sanctum', 'verified'])->resource('contract_items', ContractItemController::class);
Route::middleware(['auth:sanctum', 'verified'])->resource('air_conditioners', AirConditionerController::class);

Route::middleware(['auth:sanctum', 'verified'])->resource('tickets', TicketController::class);
Route::middleware(['auth:sanctum', 'verified'])->resource('service_orders', ServiceOrderController::class);
Route::middleware(['auth:sanctum', 'verified'])->resource('quotes', QuoteController::class);
Route::middleware(['auth:sanctum', 'verified'])->resource('quotes.quote_items', QuoteItemController::class);
Route::middleware(['auth:sanctum', 'verified'])->resource('requisitions', RequisitionController::class);
Route::middleware(['auth:sanctum', 'verified'])->resource('requisitions.requisition_items', RequisitionItemController::class);

Route::middleware(['auth:sanctum', 'verified'])->get('/reports/tickets', [ReportController::class, 'tickets'])->name('reports.tickets');
Route::middleware(['auth:sanctum', 'verified'])->get('/reports/quotes', [ReportController::class, 'quotes'])->name('reports.quotes');
Route::middleware(['auth:sanctum', 'verified'])->get('/reports/quotes/{quote}/items', [ReportController::class, 'quote_items'])->name('reports.quotes.quote_items');
Route::middleware(['auth:sanctum', 'verified'])->get('/reports/requisitions', [ReportController::class, 'requisitions'])->name('reports.requisitions');
Route::middleware(['auth:sanctum', 'verified'])->get('/reports/requisitions/{requisition}/items', [ReportController::class, 'requisition_items'])->name('reports.requisitions.requisition_items');