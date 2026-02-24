@extends('admin.layouts.app')

@section('title', 'Manage Stocks')
@section('header_title', 'Stocks')

@section('content')
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-6" role="alert">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="space-y-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                <h4 class="font-bold text-gray-800">Stock Inventory</h4>
                <div class="flex items-center space-x-4">
                    <button type="button" onclick="openModal('addStockModal')"
                        class="px-4 py-2 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition duration-150 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add New Stock
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-400 text-xs font-bold uppercase tracking-wider border-b border-gray-50">
                            <th class="px-6 py-4">Stock Name</th>
                            <th class="px-6 py-4">Listing</th>
                            <th class="px-6 py-4">Subscription Plan</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($stocks as $stock)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900">{{ $stock->stock_name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-lg uppercase">
                                        {{ $stock->stock_listing }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($stock->subscription)
                                        <span class="px-2 py-1 bg-blue-50 text-blue-600 text-xs font-semibold rounded-md">
                                            {{ $stock->subscription->name }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs italic">No Plan Linked</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <span class="text-gray-400 text-sm italic">No actions</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    No stocks found. Add your first stock!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Stock Modal -->
    <div id="addStockModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeModal('addStockModal')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Add New Stock</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeModal('addStockModal')">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="bg-white p-6">
                    <form action="{{ route('admin.stocks.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="stock_name" class="block text-sm font-semibold text-gray-700 mb-1">Stock
                                Name</label>
                            <input type="text" id="stock_name" name="stock_name" placeholder="e.g. RELIANCE" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        </div>
                        <div>
                            <label for="stock_listing" class="block text-sm font-semibold text-gray-700 mb-1">Stock
                                Listing</label>
                            <select id="stock_listing" name="stock_listing" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                                <option value="NSE">NSE</option>
                                <option value="BSE">BSE</option>
                                <option value="NASDAQ">NASDAQ</option>
                            </select>
                        </div>
                        <div>
                            <label for="subscription_id" class="block text-sm font-semibold text-gray-700 mb-1">Subscription
                                Plan</label>
                            <select id="subscription_id" name="subscription_id" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                                <option value="" disabled selected>Select a plan</option>
                                @foreach ($subscriptions as $subscription)
                                    <option value="{{ $subscription->id }}">{{ $subscription->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button"
                                class="px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition"
                                onclick="closeModal('addStockModal')">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition">
                                Add Stock
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
@endsection