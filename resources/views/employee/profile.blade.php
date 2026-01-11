<x-layouts.app>
    <x-slot:title>Profil - Web Cuti Pegawai</x-slot:title>

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Profil Saya</h1>
            <p class="text-gray-600">Informasi data pegawai Anda</p>
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Profile Header -->
            <div class="bg-gradient-to-r from-amber-500 to-orange-500 px-6 py-8">
                <div class="flex items-center">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center text-3xl font-bold text-amber-600 shadow-lg">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div class="ml-6">
                        <h2 class="text-2xl font-bold text-white">{{ $user->name }}</h2>
                        <p class="text-amber-100">{{ $user->jabatan }}</p>
                    </div>
                </div>
            </div>

            <!-- Profile Details -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- NIP -->
                    <div class="border rounded-lg p-4">
                        <label class="block text-sm font-medium text-gray-500 mb-1">NIP</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $user->nip ?? '-' }}</p>
                    </div>

                    <!-- Nama -->
                    <div class="border rounded-lg p-4">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Nama Lengkap</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $user->name }}</p>
                    </div>

                    <!-- Jabatan -->
                    <div class="border rounded-lg p-4">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Jabatan</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $user->jabatan ?? '-' }}</p>
                    </div>

                    <!-- Jenis Pegawai -->
                    <div class="border rounded-lg p-4">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Jenis Pegawai</label>
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                            {{ $user->jenis_pegawai === 'ASN' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $user->jenis_pegawai === 'PPPK' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $user->jenis_pegawai === 'NON ASN' ? 'bg-gray-100 text-gray-800' : '' }}">
                            {{ $user->jenis_pegawai ?? '-' }}
                        </span>
                    </div>

                    <!-- Email -->
                    <div class="border rounded-lg p-4">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Email</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $user->email }}</p>
                    </div>

                    <!-- Username -->
                    <div class="border rounded-lg p-4">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Username</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $user->username ?? '-' }}</p>
                    </div>
                </div>

                <!-- Leave Info -->
                <div class="mt-6 pt-6 border-t">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Cuti</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-blue-50 rounded-lg p-4 text-center">
                            <p class="text-sm font-medium text-blue-600 mb-1">Jatah Cuti Tahunan</p>
                            <p class="text-3xl font-bold text-blue-700">{{ $user->jumlah_cuti }}</p>
                            <p class="text-sm text-blue-500">hari</p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4 text-center">
                            <p class="text-sm font-medium text-green-600 mb-1">Sisa Cuti</p>
                            <p class="text-3xl font-bold text-green-700">{{ $user->getRemainingLeave() }}</p>
                            <p class="text-sm text-green-500">hari</p>
                        </div>
                        <div class="bg-amber-50 rounded-lg p-4 text-center">
                            <p class="text-sm font-medium text-amber-600 mb-1">Cuti Terpakai</p>
                            <p class="text-3xl font-bold text-amber-700">{{ $user->getUsedLeave() }}</p>
                            <p class="text-sm text-amber-500">hari</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
