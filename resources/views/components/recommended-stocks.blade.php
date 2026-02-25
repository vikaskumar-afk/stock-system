@props(['recommendations'])

<div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Stock Name</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Listing</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Plan Alignment</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest">Recommended On</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-widest text-right">Action
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($recommendations as $recommendation)

                    <tr class="hover:bg-blue-50/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                {{ $recommendation->stock->stock_name }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $recommendation->stock->stock_listing }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <span
                                    class="px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-bold border border-blue-100 shadow-sm">
                                    {{ $recommendation->subscription->name }} Plan
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $recommendation->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button
                                class="text-sm font-bold text-blue-600 hover:text-blue-800 transition-colors flex items-center justify-end ml-auto group/btn">
                                Details
                                <svg class="w-4 h-4 ml-1 transform group-hover/btn:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">No Recommendations Yet</h3>
                                <p class="text-gray-500 max-w-xs mx-auto text-sm">When our analysts recommend a stock for
                                    your {{ Auth::user()->subscription->name ?? 'current' }} plan, it will appear here.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>