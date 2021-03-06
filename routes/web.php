<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FuelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;

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
    return redirect('/login');
});



Route::middleware(['auth'])->group(function() {

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('fuel', FuelController::class);

    // Transaction Management
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transaction');
    Route::get('/transactions/{id}', [TransactionController::class, 'show'])->name('transaction.show');


    // Route::get('/transactions', function() {
    //     return view('manage.transaction.index');
    // })->name('transaction');

    // Route::get('/transactions/{id}', function() {
    //     return view('manage.transaction.show');
    // })->middleware('role.admin')->name('transaction.show');

});

require __DIR__.'/auth.php';
