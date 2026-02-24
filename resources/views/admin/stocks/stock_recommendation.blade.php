@extends('admin.layouts.app')

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
                                    <select name="customer_ids[]" id="customer_ids" multiple class="block w-full px-4 py-3 text-sm border border-gray-300 rounded-xl shadow-sm
                           focus:ring-2 focus:ring-blue-500 focus:border-blue-500
                           transition duration-200 ease-in-out
                           bg-white
                           min-h-[180px]
                           overflow-y-auto">

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
            // Modal Toggler
            const openBtn = document.getElementById('openRecommendationModal');
            if (openBtn) {
                openBtn.addEventListener('click', () => openModal('recommendationModal'));
            }

            // AJAX Customer Fetching
            document.getElementById('subscription_id').addEventListener('change', function () {
                let subscriptionId = this.value;
                let customerSelect = document.getElementById('customer_ids');
                let loadingText = document.getElementById('loadingCustomers');

                customerSelect.innerHTML = '';

                if (!subscriptionId) return;

                loadingText.classList.remove('hidden');

                fetch(`/admin/subscriptions/${subscriptionId}/customers`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(customer => {
                            let option = document.createElement('option');
                            option.value = customer.id;
                            option.text = `${customer.name} (${customer.email})`;
                            customerSelect.appendChild(option);
                        });

                        loadingText.classList.add('hidden');
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