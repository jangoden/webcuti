<x-layouts.app>
    <x-slot:title>Dashboard - Web Cuti Pegawai</x-slot:title>

    <div class="space-y-6">
        <!-- Welcome Section -->
        <div class="bg-gradient-to-r from-amber-500 to-orange-500 rounded-xl p-6 text-white shadow-lg">
            <h1 class="text-2xl font-bold">Selamat Datang, {{ $user->name }}!</h1>
            <p class="text-amber-100 mt-1">{{ $user->jabatan }} | {{ $user->jenis_pegawai }}</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Jatah Cuti -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Jatah Cuti Tahunan</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $jatahCuti }} <span class="text-lg font-normal text-gray-500">hari</span></p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Sisa Cuti -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Sisa Cuti</p>
                        <p class="text-3xl font-bold {{ $sisaCuti > 3 ? 'text-green-600' : 'text-red-600' }} mt-1">{{ $sisaCuti }} <span class="text-lg font-normal text-gray-500">hari</span></p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Cuti Terpakai -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Cuti Terpakai</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $cutiTerpakai }} <span class="text-lg font-normal text-gray-500">hari</span></p>
                    </div>
                    <div class="bg-amber-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & Last Request -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h2>
                <div class="space-y-3">
                    <a href="{{ route('pegawai.leave.create') }}" 
                       class="flex items-center p-4 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors group">
                        <div class="bg-amber-500 p-2 rounded-lg text-white group-hover:bg-amber-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="font-medium text-gray-800">Ajukan Cuti</p>
                            <p class="text-sm text-gray-500">Buat pengajuan cuti baru</p>
                        </div>
                    </a>
                    <a href="{{ route('pegawai.leave.history') }}" 
                       class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors group">
                        <div class="bg-gray-500 p-2 rounded-lg text-white group-hover:bg-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="font-medium text-gray-800">Riwayat Cuti</p>
                            <p class="text-sm text-gray-500">Lihat semua pengajuan cuti</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Last Leave Request -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Status Pengajuan Terakhir</h2>
                @if ($lastLeaveRequest)
                    <div class="border rounded-lg p-4">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm font-medium text-gray-600">{{ $lastLeaveRequest->leaveType->name }}</span>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                {{ $lastLeaveRequest->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $lastLeaveRequest->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $lastLeaveRequest->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ $lastLeaveRequest->status === 'pending' ? 'Menunggu' : '' }}
                                {{ $lastLeaveRequest->status === 'approved' ? 'Disetujui' : '' }}
                                {{ $lastLeaveRequest->status === 'rejected' ? 'Ditolak' : '' }}
                            </span>
                        </div>
                        <p class="text-gray-800">
                            {{ $lastLeaveRequest->start_date->format('d M Y') }} - {{ $lastLeaveRequest->end_date->format('d M Y') }}
                        </p>
                        <p class="text-sm text-gray-500 mt-1">{{ $lastLeaveRequest->total_days }} hari</p>
                        @if ($lastLeaveRequest->admin_notes)
                            <div class="mt-3 pt-3 border-t">
                                <p class="text-sm text-gray-500">Catatan: {{ $lastLeaveRequest->admin_notes }}</p>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p>Belum ada pengajuan cuti</p>
                        <a href="{{ route('pegawai.leave.create') }}" class="text-amber-600 hover:text-amber-700 text-sm font-medium">
                            Ajukan cuti sekarang →
                        </a>
                    </div>
                @endif

                @if ($pendingCount > 0)
                    <div class="mt-4 p-3 bg-yellow-50 rounded-lg">
                        <p class="text-sm text-yellow-800">
                            <span class="font-semibold">{{ $pendingCount }}</span> pengajuan sedang menunggu persetujuan
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
