<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Subscription;
use App\Models\User;
use App\Models\StockRecommendation;
use Illuminate\Support\Facades\DB;

class StockRecommendationController extends Controller
{
    // Display the recommendation form
    public function index()
    {
        $stocks = Stock::all();
        $subscriptions = Subscription::all();
        $recommendations = StockRecommendation::with(['stock', 'subscription', 'customers'])
            ->latest()
            ->get();

        return view('admin.stocks.stock_recommendation', compact('stocks', 'subscriptions', 'recommendations'));
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

        // Check for duplicates
        $duplicates = DB::table('recommend_customers')
            ->join('stock_recommends', 'recommend_customers.stock_recommend_id', '=', 'stock_recommends.id')
            ->where('stock_recommends.stock_id', $request->stock_id)
            ->where('stock_recommends.subscription_id', $request->subscription_id)
            ->whereIn('recommend_customers.customer_id', $request->customer_ids)
            ->join('customers', 'recommend_customers.customer_id', '=', 'customers.id')
            ->select('customers.name', 'customers.email')
            ->get()
            ->map(fn($item) => "{$item->name} ({$item->email})")
            ->toArray();

        if (!empty($duplicates)) {
            $names = implode(', ', $duplicates);
            return redirect()->back()->with('error', "The following customers have already received this recommendation: {$names}");
        }

        DB::transaction(function () use ($request) {
            // 1. Create the master record
            $recommendation = StockRecommendation::create([
                'stock_id' => $request->stock_id,
                'subscription_id' => $request->subscription_id,
            ]);

            // 2. Attach customers
            $recommendation->customers()->attach($request->customer_ids);
        });

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