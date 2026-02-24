<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.partials.head')
</head>

<body class="bg-gray-100 font-sans antialiased flex h-screen overflow-hidden text-gray-900">

    <!-- Sidebar -->
    @include('admin.partials.sidebar')

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col overflow-hidden relative">

        <!-- Header -->
        @include('admin.partials.header')

        <!-- Main Content -->
        <main class="flex-1 flex flex-col overflow-x-hidden overflow-y-auto bg-gray-100 z-0">
            <!-- Page Header Option (Optional) -->
            @hasSection('page_header')
                <div class="px-6 py-4 border-b border-gray-200 bg-white">
                    @yield('page_header')
                </div>
            @endif

            <div class="flex-1 p-6">
                <!-- Session Status / Alerts -->
                @if (session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative flex items-center"
                        role="alert">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative flex items-center"
                        role="alert">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </div>

            <!-- Footer -->
            @include('admin.partials.footer')
        </main>

    </div>

    <!-- Additional Custom Scripts -->
    @stack('scripts')
</body>

</html>