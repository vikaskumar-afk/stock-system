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
            ->paginate(10);

        return view('admin.stocks.stock_recommendation', compact('stocks', 'subscriptions', 'recommendations'));
    }

    public function getRelatedCustomers(Subscription $subscription)
    {
        $customers = $subscription->customers()
            ->where('remaining_recommendations', '>', 0)
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

        $customers = \App\Models\Customer::whereIn('id', $request->customer_ids)->get();

        // Check if all selected customers have enough limit
        // $customersWithNoLimit = $customers->filter(fn($c) => $c->remaining_recommendations <= 0);

        // if ($customersWithNoLimit->isNotEmpty()) {
        //     $names = $customersWithNoLimit->pluck('name')->implode(', ');
        //     return redirect()->back()->with('error', "The following customers have no remaining recommendation limit: {$names}");
        // }

        DB::transaction(function () use ($request, $customers) {
            // 1. Create the master record
            $recommendation = StockRecommendation::create([
                'stock_id' => $request->stock_id,
                'subscription_id' => $request->subscription_id,
            ]);

            // 2. Attach customers
            $recommendation->customers()->attach($request->customer_ids);

            // 3. Decrement limit for each customer
            foreach ($customers as $customer) {
                $customer->decrement('remaining_recommendations');
            }
        });

        return redirect()->back()->with('success', 'Stock recommendation sent successfully!');
    }

}