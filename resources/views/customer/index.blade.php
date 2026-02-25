@extends('customer.layouts.app')

@section('title', 'Recommended Stocks')
@section('header_title', 'Recommended Stocks')

@section('content')
    <div class="space-y-6">
        <!-- Dashboard Welcome -->
        <div
            class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-3xl p-8 text-white shadow-lg overflow-hidden relative">
            <div class="relative z-10">
                <h1 class="text-3xl font-extrabold mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
                <p class="text-blue-100 max-w-xl">Explore the latest stock picks curated specifically for your <span
                        class="font-bold text-white underline">{{ Auth::user()->subscription->name ?? 'Free' }}</span> plan.
                </p>
            </div>
            <!-- Abstract background shape -->
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-white/10 rounded-full blur-3xl"></div>
        </div>

        <!-- Recommendations Section -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900 px-2">Your Personal Picks</h2>
                <div class="flex space-x-2">
                    <span
                        class="px-3 py-1 bg-white border border-gray-200 rounded-lg text-xs font-semibold text-gray-500 shadow-sm">
                        Total Picks: {{ count($recommendations) }}
                    </span>
                </div>
            </div>

            <x-recommended-stocks :recommendations="$recommendations" />
        </div>
    </div>
@endsection