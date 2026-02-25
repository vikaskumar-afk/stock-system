<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Subscription;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::all();
        // dd($stocks);
        // $subscriptions = Subscription::all();
        return view('admin.stocks.index', compact('stocks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'stock_name' => 'required|string|max:255',
            'stock_listing' => 'required|in:NSE,BSE,NASDAQ',
            // 'subscription_id' => 'required|exists:subscriptions,id',
        ]);

        Stock::create([
            'stock_name' => $request->stock_name,
            'stock_listing' => $request->stock_listing,
            // 'subscription_id' => $request->subscription_id,
        ]);

        return redirect()->route('admin.stocks.index')->with('success', 'Stock added successfully.');
    }
}