<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Services\CustomerService;

class CustomerController extends Controller
{

    public function index()
    {
        $customers = Customer::with('subscription')->paginate(10);
        $subscriptions = Subscription::all();
        return view('admin.customers.index', compact('customers', 'subscriptions'));
    }

    public function store(Request $request, CustomerService $customerService)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|string|email|max:255|unique:customers',
            'subscription_id' => 'required|exists:subscriptions,id',
        ], [
            'name.regex' => 'The customer name may only contain letters and spaces.',
        ]);

        try {

            // customer create service
            $customerService->createCustomer($validated);

            return back()->with('success', 'Customer created successfully!');

        } catch (\Exception $e) {

            // Log::error('Something went wrong', [
            Log::error('Something went wrong', [
                'error' => $e->getMessage()
            ]);

            return back()->with('error', 'Something went wrong.');
        }
    }
    
    // public function update(Request $request, Customer $customer)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
    //         'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id,
    //         'subscription_id' => 'required|exists:subscriptions,id',
    //     ], [
    //         'name.regex' => 'The customer name may only contain letters and spaces.',
    //     ]);

    //     $customer->update($validated);

    //     return back()->with('success', 'Customer updated successfully!');
    // }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        return back()->with('success', 'Customer deleted successfully!');
    }
}
