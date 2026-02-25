<header class="bg-white shadow">
    <div class="px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @yield('header_title', 'Customer Dashboard')
        </h2>

        <div class="flex items-center">
            @auth
                @if(Auth::user()->subscription)
                    <div class="flex items-center px-2.5 py-1.5 rounded-lg bg-blue-50 border border-blue-100">
                        <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        <div>
                            <p class="text-[10px] uppercase font-bold text-blue-500 tracking-wider">Active Plan</p>
                            <p class="text-sm font-bold text-blue-800">{{ Auth::user()->subscription->name }}</p>
                        </div>
                    </div>
                @endif
                <div class="relative ml-3" id="profileDropdownContainer">
                    <div>
                        <button type="button" id="user-menu-button"
                            class="flex items-center max-w-xs p-1 rounded-full hover:bg-gray-100 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                            aria-expanded="false" aria-haspopup="true">
                            <span class="sr-only">Open user menu</span>
                            <div
                                class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold border border-blue-200 shadow-sm">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <svg class="ml-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <!-- Dropdown menu -->
                    <div id="user-menu-dropdown"
                        class="absolute right-0 z-50 mt-2 w-72 origin-top-right rounded-xl bg-white py-2 shadow-2xl ring-1 ring-black ring-opacity-5 hidden transition-all duration-200 opacity-0 transform scale-95"
                        role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">

                        <!-- User Info Section -->
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-semibold text-gray-900 leading-none mb-1">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500 truncate mb-2">{{ Auth::user()->email }}</p>

                        </div>

                        <!-- Actions Section -->
                        <div class="px-2 py-1">
                            <a href="{{ route('logout') }}"
                                class="flex items-center px-3 py-2 text-sm font-medium text-red-600 rounded-lg hover:bg-red-50 transition-colors duration-200 group"
                                role="menuitem" tabindex="-1">
                                <svg class="w-4 h-4 mr-3 text-red-400 group-hover:text-red-500" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Sign Out
                            </a>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const button = document.getElementById('user-menu-button');
        const dropdown = document.getElementById('user-menu-dropdown');

        if (button && dropdown) {
            button.addEventListener('click', function (event) {
                event.stopPropagation();
                const isHidden = dropdown.classList.contains('hidden');

                if (isHidden) {
                    // Show
                    dropdown.classList.remove('hidden');
                    setTimeout(() => {
                        dropdown.classList.remove('opacity-0', 'scale-95');
                        dropdown.classList.add('opacity-100', 'scale-100');
                    }, 10);
                } else {
                    // Hide
                    dropdown.classList.remove('opacity-100', 'scale-100');
                    dropdown.classList.add('opacity-0', 'scale-95');
                    setTimeout(() => {
                        dropdown.classList.add('hidden');
                    }, 200);
                }
            });

            // Close on outside click
            document.addEventListener('click', function (event) {
                if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                    if (!dropdown.classList.contains('hidden')) {
                        dropdown.classList.remove('opacity-100', 'scale-100');
                        dropdown.classList.add('opacity-0', 'scale-95');
                        setTimeout(() => {
                            dropdown.classList.add('hidden');
                        }, 200);
                    }
                }
            });
        }
    });
</script>