<aside class="w-64 bg-slate-800 text-white flex-shrink-0 hidden md:flex flex-col">
    <div class="h-16 flex items-center px-6 bg-slate-900">
        <h1 class="text-xl font-bold flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z">
                </path>
            </svg>
            Stock System
        </h1>
    </div>

    <div class="flex-1 overflow-y-auto py-4 px-3">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('customer.index') }}"
                    class="flex items-center p-2 text-base font-normal rounded-lg hover:bg-slate-700 transition duration-75 {{ request()->routeIs('customer.index') ? 'bg-slate-700' : 'text-gray-400' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6">
                        </path>
                    </svg>
                    <span class="ml-3">Recommended Stocks</span>
                </a>
            </li>
        </ul>
    </div>
</aside>