<aside class="w-64 bg-gray-800 text-white flex-shrink-0 hidden md:flex flex-col">
    <div class="h-16 flex items-center px-6 bg-gray-900">
        <h1 class="text-xl font-bold flex items-center">
            <!-- Icon placeholder -->
            <svg class="w-6 h-6 mr-2 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z">
                </path>
            </svg>
            Stock System
        </h1>
    </div>

    <div class="flex-1 overflow-y-auto py-4 px-3">
        <ul class="space-y-2">
            <!-- Dashboard -->
            <li>
                <a href="{{ route('admin.customers.index') }}"
                    class="flex items-center p-2 text-base font-normal rounded-lg hover:bg-gray-700 hover:text-white group transition duration-75 {{ request()->routeIs('admin.customers.index') ? 'bg-gray-700 text-white' : 'text-gray-400' }}">
                    <svg class="w-5 h-5 transition duration-75 group-hover:text-white" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <span class="ml-3">Manage Customers</span>
                </a>
            </li>
            <!-- Manage Subscriptions -->
            <li>
                <a href="{{ route('admin.subscriptions.index') }}"
                    class="flex items-center p-2 text-base font-normal rounded-lg hover:bg-gray-700 hover:text-white group transition duration-75 {{ request()->routeIs('admin.subscriptions.index') ? 'bg-gray-700 text-white' : 'text-gray-400' }}">
                    <svg class="w-5 h-5 transition duration-75 group-hover:text-white" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                        </path>
                    </svg>
                    <span class="ml-3">Manage Subscriptions</span>
                </a>
            </li>

            <!-- Manage Stocks -->
            <li>
                <a href="{{ route('admin.stocks.index') }}"
                    class="flex items-center p-2 text-base font-normal rounded-lg hover:bg-gray-700 hover:text-white group transition duration-75 {{ request()->routeIs('admin.stocks.index') ? 'bg-gray-700 text-white' : 'text-gray-400' }}">
                    <svg class="w-5 h-5 transition duration-75 group-hover:text-white" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6">
                        </path>
                    </svg>
                    <span class="ml-3">Manage Stocks</span>
                </a>
            </li>

        </ul>
    </div>
</aside>