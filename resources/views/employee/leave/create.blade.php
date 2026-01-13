<x-layouts.app>
    <x-slot:title>Ajukan Cuti - Web Cuti Pegawai</x-slot:title>

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Ajukan Cuti</h1>
            <p class="text-gray-600">Isi form di bawah untuk mengajukan cuti</p>
        </div>

        <div class="bg-white rounded-xl shadow-md p-6">
            <!-- Remaining Leave Info -->
            <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-blue-600 font-medium">Sisa Cuti Anda</p>
                        <p class="text-2xl font-bold text-blue-700">{{ $user->getRemainingLeave() }} hari</p>
                    </div>
                    <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>

            <form method="POST" action="{{ route('pegawai.leave.store') }}" enctype="multipart/form-data" class="space-y-6"
                  x-data="{ requiresAttachment: false }">
                @csrf

                <!-- Auto-filled Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" value="{{ $user->name }}" disabled
                               class="block w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-gray-600">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                        <input type="text" value="{{ $user->jabatan }}" disabled
                               class="block w-full px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-gray-600">
                    </div>
                </div>

                <!-- Leave Type -->
                <div>
                    <label for="leave_type_id" class="block text-sm font-medium text-gray-700 mb-1">Jenis Cuti <span class="text-red-500">*</span></label>
                    <select name="leave_type_id" id="leave_type_id" required
                            @change="requiresAttachment = $event.target.options[$event.target.selectedIndex].dataset.requiresAttachment === '1'"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('leave_type_id') border-red-500 @enderror">
                        <option value="" data-requires-attachment="0">-- Pilih Jenis Cuti --</option>
                        @foreach ($leaveTypes as $leaveType)
                            <option value="{{ $leaveType->id }}" 
                                    data-requires-attachment="{{ $leaveType->requires_attachment ? '1' : '0' }}"
                                    {{ old('leave_type_id') == $leaveType->id ? 'selected' : '' }}>
                                {{ $leaveType->name }}
                            </option>
                        @endforeach
                    </select>
                    
                    <!-- Info Message Dynamic -->
                    <div x-show="requiresAttachment" x-transition class="mt-2 text-sm text-blue-600 bg-blue-50 p-2 rounded-md flex items-start gap-2">
                         <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                         <span>Jenis cuti ini <strong>WAJIB</strong> melampirkan dokumen pendukung.</span>
                    </div>

                    @error('leave_type_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date Range -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                        <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required
                               min="{{ date('Y-m-d') }}"
                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('start_date') border-red-500 @enderror">
                        @error('start_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai <span class="text-red-500">*</span></label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}" required
                               min="{{ date('Y-m-d') }}"
                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('end_date') border-red-500 @enderror">
                        @error('end_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Reason -->
                <div>
                    <label for="reason" class="block text-sm font-medium text-gray-700 mb-1">Alasan / Keterangan</label>
                    <textarea name="reason" id="reason" rows="4"
                              class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('reason') border-red-500 @enderror"
                              placeholder="Tuliskan alasan mengajukan cuti (opsional)">{{ old('reason') }}</textarea>
                    @error('reason')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Attachment -->
                <div>
                    <label for="attachment" class="block text-sm font-medium text-gray-700 mb-1">
                        File Pendukung 
                        <span x-show="requiresAttachment" class="text-red-500 ml-1" style="display: none;">* (Wajib)</span>
                    </label>
                    <input type="file" name="attachment" id="attachment" accept=".pdf,.jpg,.jpeg,.png"
                           :required="requiresAttachment"
                           class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 @error('attachment') border-red-500 @enderror">
                    <p class="mt-1 text-sm text-gray-500">Format: PDF, JPG, PNG. Maksimal 2MB.</p>
                    @error('attachment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 pt-4 border-t">
                    <a href="{{ route('pegawai.dashboard') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition-colors">
                        Ajukan Cuti
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
