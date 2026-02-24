<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::all();
        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
            'recommendation_limit' => 'required|integer|min:1|max:500',
        ], [
            'name.regex' => 'The plan name must only contain characters and spaces.',
            'recommendation_limit.max' => 'The recommendation limit may not be greater than 500.',
            'recommendation_limit.min' => 'The recommendation limit must be at least 1.',
        ]);

        Subscription::create($request->all());

        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'Subscription created successfully.');
    }

    public function update(Request $request, Subscription $subscription)
    {
        $request->validate([
            'name' => 'required|regex:/^[a-zA-Z\s]+$/|max:255',
            'recommendation_limit' => 'required|integer|min:1|max:500',
        ], [
            'name.regex' => 'The plan name must only contain characters and spaces.',
            'recommendation_limit.max' => 'The recommendation limit may not be greater than 500.',
            'recommendation_limit.min' => 'The recommendation limit must be at least 1.',
        ]);

        $subscription->update($request->all());

        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'Subscription updated successfully.');
    }

    public function destroy(Subscription $subscription)
    {
        $subscription->delete();

        return redirect()->route('admin.subscriptions.index')
            ->with('success', 'Subscription deleted successfully.');
    }
}
