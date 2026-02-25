@extends('admin.layouts.app')

@section('title', 'Manage Customers')
@section('header_title', 'Customers')

@section('content')
    <!-- Session Status / Alerts -->

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

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
                <h4 class="font-bold text-gray-800">Customer List</h4>
                <div class="flex items-center space-x-4">
                    <span class="text-xs font-semibold px-2 py-1 bg-blue-100 text-blue-700 rounded-full">
                        {{ $customers->total() }} Customers Total
                    </span>
                    <button type="button" id="addCustomerBtn"
                        class="px-4 py-2 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition duration-150 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add New Customer
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-400 text-xs font-bold uppercase tracking-wider border-b border-gray-50">
                            <th class="px-6 py-4">Name</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Subscription</th>
                            <th class="px-6 py-4">Remaining Recommendations</th>
                            <th class="px-6 py-4">Created Date</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($customers as $customer)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900">{{ $customer->name }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-600 text-sm">
                                    {{ $customer->email }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded-full">
                                        {{ $customer->subscription->name ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-blue-50 text-blue-700 text-xs font-bold rounded-full">
                                        {{ $customer->remaining_recommendations ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-500 text-sm">
                                    {{ $customer->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <button type="button"
                                        class="text-blue-600 hover:text-blue-800 font-bold mr-3 edit-customer-btn"
                                        data-id="{{ $customer->id }}"
                                        data-name="{{ $customer->name }}"
                                        data-email="{{ $customer->email }}"
                                        data-subscription="{{ $customer->subscription_id }}">
                                        Edit
                                    </button>
                                    <!-- <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-bold"
                                            onclick="return confirm('Are you sure you want to delete this customer?')">
                                            Delete
                                        </button>
                                    </form> -->
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                    No customers found. Register your first client!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($customers->hasPages())
                <div class="px-6 py-4 border-t border-gray-50">
                    {{ $customers->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Add Customer Modal -->
    <div id="addCustomerModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal('addCustomerModal')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                <!-- Header -->
                <div class="bg-gray-900 px-8 py-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            Create New Customer
                        </h3>
                        <p class="text-gray-400 text-sm mt-1 ml-9">Fill in the details below to register a new client.</p>
                    </div>
                    <button type="button" class="text-gray-400 hover:text-white" onclick="closeModal('addCustomerModal')">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-8">
                    <form action="{{ route('admin.customers.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="form_type" value="add">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Customer Name -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Customer Name</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" id="name" name="name" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 transition duration-150" placeholder="e.g. John Doe" value="{{ old('form_type') == 'add' ? old('name') : '' }}" required>
                                </div>
                            </div>

                            <!-- Customer Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Customer Email</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input type="email" id="email" name="email" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 transition duration-150" placeholder="john@example.com" value="{{ old('form_type') == 'add' ? old('email') : '' }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Subscription Type -->
                            <div>
                                <label for="subscription" class="block text-sm font-semibold text-gray-700 mb-2">Assign Subscription</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                        </svg>
                                    </div>
                                    <select id="subscription" name="subscription_id" class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl appearance-none focus:ring-2 focus:ring-blue-500 transition duration-150" required>
                                        <option value="">-- Select Plan --</option>
                                        @foreach($subscriptions as $sub)
                                            <option value="{{ $sub->id }}" data-limit="{{ $sub->recommendation_limit }}" {{ (old('form_type') == 'add' && old('subscription_id') == $sub->id) ? 'selected' : '' }}>
                                                {{ $sub->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Recommended Limit Display -->
                            <div id="limit-container" class="hidden">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Recommendation Limit</label>
                                <div class="flex items-center px-4 py-3 bg-blue-50 border border-blue-100 rounded-xl">
                                    <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-blue-700 font-medium">Included: </span>
                                    <span id="limit-value" class="ml-1 text-blue-900 font-bold">0</span>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4 flex space-x-3">
                            <button type="button" class="flex-1 py-4 px-4 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition duration-150" onclick="closeModal('addCustomerModal')">
                                Cancel
                            </button>
                            <button type="submit" class="flex-[2] py-4 px-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition duration-150">
                                Create Customer Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Customer Modal -->
    <div id="editCustomerModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal('editCustomerModal')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">

                <div class="bg-blue-900 px-8 py-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold text-white flex items-center">
                            <svg class="w-6 h-6 mr-3 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Customer Details
                        </h3>
                        <p class="text-blue-200 text-sm mt-1 ml-9">Update information for this customer.</p>
                    </div>
                    <button type="button" class="text-blue-300 hover:text-white" onclick="closeModal('editCustomerModal')">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="p-8">
                    <form id="editCustomerForm" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="form_type" value="edit">
                        <input type="hidden" name="edit_id" id="edit_modal_id" value="{{ old('form_type') == 'edit' ? old('edit_id') : '' }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div>
                                <label for="edit_name" class="block text-sm font-semibold text-gray-700 mb-2">Customer Name</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" id="edit_name" name="name" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 transition duration-150" placeholder="e.g. John Doe" value="{{ old('form_type') == 'edit' ? old('name') : '' }}" required>
                                </div>
                            </div>

                            
                            <div>
                                <label for="edit_email" class="block text-sm font-semibold text-gray-700 mb-2">Customer Email</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <input type="email" id="edit_email" name="email" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl bg-gray-50 text-gray-500 cursor-not-allowed focus:outline-none" placeholder="john@example.com" value="{{ old('form_type') == 'edit' ? old('email') : '' }}" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                           
                            <div>
                                <label for="edit_subscription" class="block text-sm font-semibold text-gray-700 mb-2">Assign Subscription</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                        </svg>
                                    </div>
                                    <select id="edit_subscription" name="subscription_id" class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl appearance-none focus:ring-2 focus:ring-blue-500 transition duration-150" required>
                                        <option value="">-- Select Plan --</option>
                                        @foreach($subscriptions as $sub)
                                            <option value="{{ $sub->id }}" data-limit="{{ $sub->recommendation_limit }}" {{ (old('form_type') == 'edit' && old('subscription_id') == $sub->id) ? 'selected' : '' }}>
                                                {{ $sub->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            
                            <div id="edit-limit-container" class="hidden">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Recommendation Limit</label>
                                <div class="flex items-center px-4 py-3 bg-blue-50 border border-blue-100 rounded-xl">
                                    <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-blue-700 font-medium">Included: </span>
                                    <span id="edit-limit-value" class="ml-1 text-blue-900 font-bold">0</span>
                                </div>
                            </div>
                        </div>

                        
                        <div class="pt-4 flex space-x-3">
                            <button type="button" class="flex-1 py-4 px-4 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition duration-150" onclick="closeModal('editCustomerModal')">
                                Cancel
                            </button>
                            <button type="submit" class="flex-[2] py-4 px-4 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-200 transition duration-150">
                                Update Customer
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

        document.addEventListener('DOMContentLoaded', function () {
            const addCustomerBtn = document.getElementById('addCustomerBtn');
            const subscriptionSelect = document.getElementById('subscription');
            const editSubscriptionSelect = document.getElementById('edit_subscription');
            const editBtns = document.querySelectorAll('.edit-customer-btn');
            const editForm = document.getElementById('editCustomerForm');

            if (addCustomerBtn) {
                addCustomerBtn.addEventListener('click', () => openModal('addCustomerModal'));
            }

            function updateLimit(selectEl, containerId, valueId) {
                const selectedOption = selectEl.options[selectEl.selectedIndex];
                const limit = selectedOption.getAttribute('data-limit');
                const container = document.getElementById(containerId);
                const valueSpan = document.getElementById(valueId);

                if (limit) {
                    valueSpan.textContent = limit == -1 ? 'Unlimited' : limit;
                    container.classList.remove('hidden');
                } else {
                    container.classList.add('hidden');
                }
            }

            subscriptionSelect.addEventListener('change', function () {
                updateLimit(this, 'limit-container', 'limit-value');
            });

            editSubscriptionSelect.addEventListener('change', function () {
                updateLimit(this, 'edit-limit-container', 'edit-limit-value');
            });

            editBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const email = this.getAttribute('data-email');
                    const subscriptionId = this.getAttribute('data-subscription');

                    document.getElementById('edit_modal_id').value = id;
                    document.getElementById('edit_name').value = name;
                    document.getElementById('edit_email').value = email;
                    document.getElementById('edit_subscription').value = subscriptionId;
                    
                    editForm.action = `/admin/customers/${id}`;
                    
                    updateLimit(editSubscriptionSelect, 'edit-limit-container', 'edit-limit-value');
                    openModal('editCustomerModal');
                });
            });

            // Reopen modal and handle old values on error
            // @if($errors->any())
            //     const formType = "{{ old('form_type') }}";
            //     if (formType === 'add') {
            //         openModal('addCustomerModal');
            //         updateLimit(subscriptionSelect, 'limit-container', 'limit-value');
            //     } else if (formType === 'edit') {
            //         const editId = "{{ old('edit_id') }}";
            //         if (editId) {
            //             editForm.action = `/admin/customers/${editId}`;
            //             openModal('editCustomerModal');
            //             updateLimit(editSubscriptionSelect, 'edit-limit-container', 'edit-limit-value');
            //         }
            //     }
            // @endif

            // Close on Escape
            window.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeModal('addCustomerModal');
                    closeModal('editCustomerModal');
                }
            });
        });
    </script>
@endsection
