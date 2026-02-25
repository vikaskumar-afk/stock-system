@extends('customer.layouts.app')

@section('title', 'Recommended Stocks')
@section('header_title', 'Customer Recommended Stocks')

@section('content')
    <div class="space-y-6">

        <!-- Recommendations Section -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900 px-2">Recommended Stocks Listing</h2>
                <div class="flex space-x-2">
                    <span
                        class="px-3 py-1 bg-white border border-gray-200 rounded-lg text-xs font-semibold text-gray-500 shadow-sm">
                        Total Picks: {{ $recommendations->total() }}
                    </span>
                </div>
            </div>

            <x-recommended-stocks :recommendations="$recommendations" />

            <div class="mt-6">
                {{ $recommendations->links() }}
            </div>
        </div>
    </div>
@endsection