<?php

use Illuminate\Support\Facades\Route;
use App\Models\Subscription;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\Auth\AuthController;
    use App\Http\Controllers\StockRecommendationController;




// use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/logout', function () {
    Auth::logout();      // log out current user
    session()->flush();  // clear all session data
    session()->regenerateToken(); // regenerate CSRF token

    // return '✅ All sessions cleared, user logged out!';
    return redirect()->route('login');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



/*
|--------------------------------------------------------------------------
| Protected Routes (ONLY Logged In Users)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Admin dashboard
    Route::get('/admin', function () {
       return redirect()->route('admin.customers.index');
    });



    Route::get('/customer', function () {
        $subscriptions = Subscription::all();
        return view('customer.index', compact('subscriptions'));
    })->name('customer.index');

    // Customer management
    Route::get('/admin/customers', [CustomerController::class, 'index'])->name('admin.customers.index');
    Route::post('/admin/customers/store', [CustomerController::class, 'store'])->name('admin.customers.store');
    Route::put('/admin/customers/{customer}', [CustomerController::class, 'update'])->name('admin.customers.update');
    Route::delete('/admin/customers/{customer}', [CustomerController::class, 'destroy'])->name('admin.customers.destroy');

    // Subscription management
    Route::get('/admin/subscriptions', [SubscriptionController::class, 'index'])->name('admin.subscriptions.index');
    Route::post('/admin/subscriptions', [SubscriptionController::class, 'store'])->name('admin.subscriptions.store');
    Route::put('/admin/subscriptions/{subscription}', [SubscriptionController::class, 'update'])->name('admin.subscriptions.update');
    Route::delete('/admin/subscriptions/{subscription}', [SubscriptionController::class, 'destroy'])->name('admin.subscriptions.destroy');

    // Stock management
    Route::get('/admin/stocks', [StockController::class, 'index'])->name('admin.stocks.index');
    Route::post('/admin/stocks', [StockController::class, 'store'])->name('admin.stocks.store');

    // Stocks Recommendation

// Display form
Route::get('/admin/stocks/recommendation', [StockRecommendationController::class, 'index'])
     ->name('admin.stocks.recommendation');

// Handle submission
 Route::post('/admin/stocks/recommendation/store', [StockRecommendationController::class, 'store'])
      ->name('stocks.recommendation.store');

// AJAX to fetch customers
// Route::get('/admin/subscription/{id}/customers', [StockRecommendationController::class, 'getCustomersBySubscription'])
//      ->name('admin.subscription.customers');


     Route::get('/admin/subscriptions/{subscription}/customers',
    [StockRecommendationController::class, 'getRelatedCustomers'])
    ->name('admin.subscriptions.customers');

});