<?php

use Illuminate\Support\Facades\Route;
use App\Models\Subscription;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

// test mail route
// Route::get('/test-mail', function () {
//     try {
//         Mail::raw('Laravel SMTP Working ✅', function ($message) {
//             $message->to('tester@gmail.com')
//                     ->subject('SMTP Test Success');
//         });

//         return '✅ Mail Sent Successfully';

//     } catch (\Exception $e) {

//         Log::error($e->getMessage());

//         return '❌ Mail Failed: ' . $e->getMessage();
//     }
// });




Route::get('/', function () {
    return view('welcome');
});

// Admin dashboard route
Route::get('/admin', function () {
    $subscriptions = Subscription::all();
    return view('admin.dashboard', compact('subscriptions'));
})->name('admin.dashboard');

// Customer routes
Route::get('/admin/customers', [CustomerController::class, 'index'])->name('admin.customers.index');
Route::post('/admin/customers/store', [CustomerController::class, 'store'])->name('admin.customers.store');
Route::put('/admin/customers/{customer}', [CustomerController::class, 'update'])->name('admin.customers.update');
Route::delete('/admin/customers/{customer}', [CustomerController::class, 'destroy'])->name('admin.customers.destroy');

// Subscription routes
Route::get('/admin/subscriptions', [SubscriptionController::class, 'index'])->name('admin.subscriptions.index');
Route::post('/admin/subscriptions', [SubscriptionController::class, 'store'])->name('admin.subscriptions.store');
Route::put('/admin/subscriptions/{subscription}', [SubscriptionController::class, 'update'])->name('admin.subscriptions.update');
Route::delete('/admin/subscriptions/{subscription}', [SubscriptionController::class, 'destroy'])->name('admin.subscriptions.destroy');

// Stock routes
Route::get('/admin/stocks', [StockController::class, 'index'])->name('admin.stocks.index');
Route::post('/admin/stocks', [StockController::class, 'store'])->name('admin.stocks.store');