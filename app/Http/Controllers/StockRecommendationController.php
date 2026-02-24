<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Subscription;
use App\Models\User;
use App\Models\StockRecommendation;

class StockRecommendationController extends Controller
{
    // Display the recommendation form
    public function index()
    {
        $stocks = Stock::all();
        $subscriptions = Subscription::all();

        // dd($stocks, $subscriptions);

        return view('admin.stocks.stock_recommendation', compact('stocks', 'subscriptions'));
    }

    public function getRelatedCustomers(Subscription $subscription)
    {
        $customers = $subscription->customers()
            ->select('id', 'name', 'email')
            ->get();

        return response()->json($customers);
    }

    // Store the recommendation
    public function store(Request $request)
    {
        $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'subscription_id' => 'required|exists:subscriptions,id',
            'customer_ids' => 'required|array',
            'customer_ids.*' => 'exists:customers,id',
        ]);

        foreach ($request->customer_ids as $customerId) {
            StockRecommendation::create([
                'stock_id' => $request->stock_id,
                'subscription_id' => $request->subscription_id,
                'customer_id' => $customerId,
            ]);
        }

        return redirect()->back()->with('success', 'Stock recommendation sent successfully!');
    }

    // Fetch customers by subscription (AJAX)
    // public function getCustomersBySubscription($subscriptionId)
    // {
    //     // Adjust this if your User model has a relation with subscription
    //     $customers = User::where('subscription_id', $subscriptionId)
    //                      ->get(['id', 'name', 'email']);

    //     return response()->json($customers);
    // }
}