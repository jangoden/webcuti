<x-layouts.guest>
    <x-slot:title>Login - Web Cuti Pegawai</x-slot:title>

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-amber-600">Web Cuti</h1>
                <h2 class="mt-2 text-xl text-gray-600">Sistem Manajemen Cuti Pegawai</h2>
            </div>

            <div class="bg-white rounded-xl shadow-2xl p-8">
                <h3 class="text-2xl font-semibold text-gray-800 text-center mb-6">Masuk ke Akun Anda</h3>

                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        @foreach ($errors->all() as $error)
                            <p class="text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="login" class="block text-sm font-medium text-gray-700">Email atau Username</label>
                        <input type="text" name="login" id="login" value="{{ old('login') }}" required autofocus
                               class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="password" required
                               class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" 
                               class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Ingat saya</label>
                    </div>

                    <button type="submit" 
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-amber-600 hover:bg-amber-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-colors">
                        Masuk
                    </button>
                </form>
            </div>

            <p class="text-center text-gray-500 text-sm">
                &copy; {{ date('Y') }} Web Cuti Pegawai
            </p>
        </div>
    </div>
</x-layouts.guest>
