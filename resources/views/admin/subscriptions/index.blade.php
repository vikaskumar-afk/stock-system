@extends('admin.layouts.app')

@section('title', 'Manage Subscriptions')
@section('header_title', 'Subscriptions')

@section('content')
    <!-- Session Status / Alerts -->
   

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
                <h4 class="font-bold text-gray-800">Available Subscription Plans</h4>
                <div class="flex items-center space-x-4">
                    <span class="text-xs font-semibold px-2 py-1 bg-blue-100 text-blue-700 rounded-full">
                        {{ $subscriptions->count() }} Plans Total
                    </span>
                    <button type="button" id="addPlanBtn"
                        class="px-4 py-2 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 transition duration-150 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add New Plan
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-400 text-xs font-bold uppercase tracking-wider border-b border-gray-50">
                            <th class="px-6 py-4">Plan Name</th>
                            <th class="px-6 py-4">Limit</th>
                            <th class="px-6 py-4">Created</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($subscriptions as $subscription)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900">{{ $subscription->name }}</div>
                                </td>
                                <td class="px-6 py-4 text-gray-600 text-sm">
                                    {{ $subscription->recommendation_limit == -1 ? 'Unlimited' : $subscription->recommendation_limit . ' Recommendations' }}
                                </td>
                                <td class="px-6 py-4 text-gray-500 text-sm">
                                    {{ $subscription->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <button type="button"
                                        class="text-blue-600 hover:text-blue-800 font-semibold mr-3 edit-plan-btn"
                                        data-id="{{ $subscription->id }}" data-name="{{ $subscription->name }}"
                                        data-limit="{{ $subscription->recommendation_limit }}">
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.subscriptions.destroy', $subscription) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold"
                                            onclick="return confirm('Are you sure you want to delete this plan?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    No subscription plans found. Start by creating one!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Add Modal -->
    <div id="addModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeModal('addModal')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Add New Subscription Plan</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeModal('addModal')">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="bg-white p-6">
                    <form action="{{ route('admin.subscriptions.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Plan Name</label>
                            <input type="text" id="name" name="name" placeholder="e.g. Pro Plan"
                                value="{{ request()->isMethod('post') ? old('name') : '' }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('name') border-red-500 @enderror">
                        </div>
                        <div>
                            <label for="recommendation_limit" class="block text-sm font-semibold text-gray-700 mb-1">
                                Recommendation Limit
                            </label>
                            <input type="number" id="recommendation_limit" name="recommendation_limit" placeholder="50"
                                value="{{ request()->isMethod('post') ? old('recommendation_limit') : '' }}" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('recommendation_limit') border-red-500 @enderror">
                        </div>
                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button"
                                class="px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition"
                                onclick="closeModal('addModal')">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition">
                                Create Plan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal"
        class="fixed inset-0 z-50 {{ $errors->any() && request()->isMethod('put') ? '' : 'hidden' }} overflow-y-auto"
        aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                onclick="closeModal('editModal')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800" id="modal-title">Edit Subscription Plan</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-500" onclick="closeModal('editModal')">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="bg-white p-6">
                    <form id="editForm" method="POST"
                        action="{{ $errors->any() && request()->isMethod('put') ? route('admin.subscriptions.update', old('edit_id', 0)) : '#' }}"
                        class="space-y-4">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="edit_id" id="edit_id" value="{{ old('edit_id') }}">
                        <div>
                            <label for="edit_name" class="block text-sm font-semibold text-gray-700 mb-1">Plan Name</label>
                            <input type="text" id="edit_name" name="name" required
                                value="{{ request()->isMethod('put') ? old('name') : '' }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('name') border-red-500 @enderror">
                        </div>
                        <div>
                            <label for="edit_recommendation_limit"
                                class="block text-sm font-semibold text-gray-700 mb-1">Recommendation Limit</label>
                            <input type="number" id="edit_recommendation_limit" name="recommendation_limit" required
                                value="{{ request()->isMethod('put') ? old('recommendation_limit') : '' }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition @error('recommendation_limit') border-red-500 @enderror">
                        </div>
                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button"
                                class="px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition"
                                onclick="closeModal('editModal')">
                                Cancel
                            </button>
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition">
                                Update Plan
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

            // If closing addModal, handle potential errors shown in there if needed
            // But usually we just let them stay or clear them on next open
        }

        document.addEventListener('DOMContentLoaded', function () {
            const addPlanBtn = document.getElementById('addPlanBtn');
            const editForm = document.getElementById('editForm');
            const editIdInput = document.getElementById('edit_id');
            const editNameInput = document.getElementById('edit_name');
            const editLimitInput = document.getElementById('edit_recommendation_limit');
            const editBtns = document.querySelectorAll('.edit-plan-btn');

            // Handle failed validation for Add form
            @if($errors->any() && request()->isMethod('post'))
                openModal('addModal');
            @endif

                if (addPlanBtn) {
                addPlanBtn.addEventListener('click', () => openModal('addModal'));
            }

            editBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const limit = this.getAttribute('data-limit');

                    editIdInput.value = id;
                    editNameInput.value = name;
                    editLimitInput.value = limit;
                    editForm.action = `/admin/subscriptions/${id}`;

                    openModal('editModal');
                });
            });

            // Close modal on escape key
            window.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeModal('addModal');
                    closeModal('editModal');
                }
            });
        });
    </script>
@endsection