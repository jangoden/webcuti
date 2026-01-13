<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Web Cuti Pegawai' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col font-sans antialiased">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('pegawai.dashboard') }}" class="flex items-center">
                        <span class="text-xl font-bold text-amber-600">Web Cuti</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('pegawai.dashboard') }}" 
                       class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('pegawai.dashboard') ? 'bg-amber-100 text-amber-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('pegawai.profile') }}" 
                       class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('pegawai.profile') ? 'bg-amber-100 text-amber-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        Profil
                    </a>
                    <a href="{{ route('pegawai.leave.create') }}" 
                       class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('pegawai.leave.create') ? 'bg-amber-100 text-amber-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        Ajukan Cuti
                    </a>
                    <a href="{{ route('pegawai.leave.history') }}" 
                       class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('pegawai.leave.history') ? 'bg-amber-100 text-amber-700' : 'text-gray-600 hover:bg-gray-100' }}">
                        Riwayat Cuti
                    </a>
                </div>

                <!-- User Menu -->
                <div class="flex items-center">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                            <div class="w-8 h-8 bg-amber-500 rounded-full flex items-center justify-center text-white font-semibold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <span class="hidden md:block">{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" 
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button type="button" class="mobile-menu-button inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="mobile-menu hidden md:hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('pegawai.dashboard') }}" 
                   class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('pegawai.dashboard') ? 'bg-amber-100 text-amber-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    Dashboard
                </a>
                <a href="{{ route('pegawai.profile') }}" 
                   class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('pegawai.profile') ? 'bg-amber-100 text-amber-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    Profil
                </a>
                <a href="{{ route('pegawai.leave.create') }}" 
                   class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('pegawai.leave.create') ? 'bg-amber-100 text-amber-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    Ajukan Cuti
                </a>
                <a href="{{ route('pegawai.leave.history') }}" 
                   class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('pegawai.leave.history') ? 'bg-amber-100 text-amber-700' : 'text-gray-600 hover:bg-gray-100' }}">
                    Riwayat Cuti
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-20 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            {{ $slot }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-auto">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} Web Cuti Pegawai. All rights reserved.
            </p>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        document.querySelector('.mobile-menu-button').addEventListener('click', function() {
            document.querySelector('.mobile-menu').classList.toggle('hidden');
        });
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
