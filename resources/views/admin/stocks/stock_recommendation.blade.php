@extends('admin.layouts.app')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        .ts-control {
            border-radius: 0.75rem !important;
            padding: 0.75rem 1rem !important;
            border-color: #d1d5db !important;
        }

        .ts-dropdown {
            border-radius: 0.75rem !important;
            margin-top: 0.5rem !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@endpush

@section('title', 'Stock Recommendation')
@section('header_title', 'Stock Recommendation')

@section('content')
    <div class="p-6">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h3 class="text-2xl font-bold text-gray-800">Recommendation Management</h3>
                <p class="text-gray-500 mt-1">Send and track stock recommendations for your clients.</p>
            </div>
            <button type="button" id="openRecommendationModal"
                class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition duration-150 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Send Recommendation
            </button>
        </div>

        {{-- Recommendations Listing --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
            <div class="px-8 py-6 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                <h4 class="font-bold text-gray-800">Sent Recommendations</h4>
                <!-- <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Historical records</span> -->
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-8 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Stock</th>
                            <th class="px-8 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Plan</th>
                            <th class="px-8 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Target Customers
                            </th>
                            <th class="px-8 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Date Sent</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($recommendations as $rec)
                            <tr class="hover:bg-gray-50/50 transition duration-150 text-sm">
                                <td class="px-8 py-5">
                                    <div class="font-semibold text-gray-900">{{ $rec->stock->stock_name }}</div>
                                    <!-- <div class="text-xs text-gray-500">{{ $rec->stock->listing_type ?? 'N/A' }}</div> -->
                                </td>
                                <td class="px-8 py-5">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $rec->subscription->name }}
                                    </span>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($rec->customers->take(3) as $customer)
                                            <span class="text-xs text-gray-600 bg-gray-100 px-2 py-0.5 rounded">
                                                {{ $customer->name }} <span
                                                    class="opacity-70 text-[10px]">({{ $customer->email }})</span>
                                            </span>
                                        @endforeach
                                        @if($rec->customers->count() > 3)
                                            <span class="text-xs text-gray-400 font-medium">+{{ $rec->customers->count() - 3 }}
                                                more</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-5 text-gray-600">
                                    <div>{{ $rec->created_at->format('M d, Y') }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-12 text-center text-gray-500 italic">
                                    No recommendations sent yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recommendation Modal --}}
        <div id="recommendationModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                    onclick="closeModal('recommendationModal')"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <!-- Header -->
                    <div class="bg-gray-900 px-8 py-6 flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold text-white flex items-center">
                                <svg class="w-6 h-6 mr-3 text-blue-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                New Stock Recommendation
                            </h3>
                            <p class="text-gray-400 text-sm mt-1 ml-9">Select a stock and target your subscribers.</p>
                        </div>
                        <button type="button" class="text-gray-400 hover:text-white"
                            onclick="closeModal('recommendationModal')">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-8">
                        <form action="{{ route('stocks.recommendation.store') }}" method="POST" class="space-y-6">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Stock Selection --}}
                                <div>
                                    <label for="stock_id" class="block text-sm font-semibold text-gray-700 mb-2">Select
                                        Stock</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                            </svg>
                                        </div>
                                        <select id="stock_id" name="stock_id"
                                            class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl appearance-none focus:ring-2 focus:ring-blue-500 transition duration-150"
                                            required>
                                            <option value="">-- Choose Stock --</option>
                                            @foreach($stocks as $stock)
                                                <option value="{{ $stock->id }}">{{ $stock->stock_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('stock_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                {{-- Subscription Selection --}}
                                <div>
                                    <label for="subscription_id"
                                        class="block text-sm font-semibold text-gray-700 mb-2">Target Subscription</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                                                </path>
                                            </svg>
                                        </div>
                                        <select id="subscription_id" name="subscription_id"
                                            class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl appearance-none focus:ring-2 focus:ring-blue-500 transition duration-150"
                                            required>
                                            <option value="">-- Select Plan --</option>
                                            @foreach($subscriptions as $subscription)
                                                <option value="{{ $subscription->id }}">{{ $subscription->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('subscription_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Customers Multiple Selection --}}
                            <div>
                                <label for="customer_ids" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Target Customers
                                </label>

                                <div class="relative">
                                    <select name="customer_ids[]" id="customer_ids" multiple
                                        placeholder="Search and select customers..." autocomplete="off">
                                        {{-- Options loaded dynamically --}}
                                    </select>

                                    {{-- Loading Text --}}
                                    <div id="loadingCustomers"
                                        class="absolute top-2 right-3 hidden flex items-center text-xs text-blue-600 font-medium">

                                        <svg class="animate-spin h-4 w-4 mr-1" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z">
                                            </path>
                                        </svg>

                                        Loading...
                                    </div>
                                </div>

                                @error('customer_ids')
                                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Actions -->
                            <div class="pt-6 flex space-x-3">
                                <button type="button"
                                    class="flex-1 py-4 px-4 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition duration-150"
                                    onclick="closeModal('recommendationModal')">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="flex-[2] py-4 px-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition duration-150">
                                    Send Recommendations
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Tom Select
            const customerSelect = new TomSelect('#customer_ids', {
                plugins: ['remove_button'],
                valueField: 'id',
                labelField: 'name',
                searchField: ['name', 'email'],
                placeholder: 'Select target customers...',
                maxOptions: 1000,
                render: {
                    option: function (data, escape) {
                        return '<div>' +
                            '<span class="font-medium text-gray-900">' + escape(data.name) + '</span>' +
                            '<span class="ml-2 text-xs text-gray-500 italic">' + escape(data.email) + '</span>' +
                            '</div>';
                    },
                    item: function (data, escape) {
                        return '<div>' +
                            '<span>' + escape(data.name) + '</span>' +
                            '<span class="ml-1 text-xs opacity-70">(' + escape(data.email) + ')</span>' +
                            '</div>';
                    }
                }
            });

            // Modal Toggler
            const openBtn = document.getElementById('openRecommendationModal');
            if (openBtn) {
                openBtn.addEventListener('click', () => openModal('recommendationModal'));
            }

            // AJAX Customer Fetching
            document.getElementById('subscription_id').addEventListener('change', function () {
                let subscriptionId = this.value;
                let loadingText = document.getElementById('loadingCustomers');

                // Clear current options in Tom Select
                customerSelect.clear();
                customerSelect.clearOptions();

                if (!subscriptionId) {
                    customerSelect.enable();
                    customerSelect.settings.placeholder = "Select target customers...";
                    customerSelect.inputState();
                    const existingNotice = document.getElementById('noCustomersNotice');
                    if (existingNotice) existingNotice.remove();
                    return;
                }

                loadingText.classList.remove('hidden');

                fetch(`/admin/subscriptions/${subscriptionId}/customers`)
                    .then(response => response.json())
                    .then(data => {
                        loadingText.classList.add('hidden');

                        if (data.length === 0) {
                            customerSelect.disable();
                            customerSelect.settings.placeholder = "No customers found for this plan";
                            customerSelect.inputState(); // Refresh placeholder

                            // Optional: Show a small text notice
                            const notice = document.createElement('p');
                            notice.id = 'noCustomersNotice';
                            notice.className = 'text-amber-600 text-xs mt-2 font-medium flex items-center';
                            notice.innerHTML = '<svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg> This subscription plan currently has no assigned customers.';

                            const existingNotice = document.getElementById('noCustomersNotice');
                            if (!existingNotice) {
                                document.getElementById('customer_ids').closest('.relative').after(notice);
                            }
                        } else {
                            customerSelect.enable();
                            customerSelect.settings.placeholder = "Select target customers...";
                            customerSelect.inputState();

                            // Remove notice if exists
                            const existingNotice = document.getElementById('noCustomersNotice');
                            if (existingNotice) existingNotice.remove();

                            // Add new options to Tom Select
                            customerSelect.addOptions(data);
                            customerSelect.refreshOptions(false);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching customers:', error);
                        loadingText.classList.add('hidden');
                    });
            });

            // Close on Escape
            window.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeModal('recommendationModal');
                }
            });
        });
    </script>
@endpush