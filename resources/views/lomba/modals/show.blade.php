<!-- Modal header -->
<div class="flex items-center justify-between px-4 py-3 border-b rounded-t-xl bg-primary border-gray-200">
    <h3 class="text-sm font-semibold text-white">
        <i class="fa-solid fa-eye me-1"></i>
        Detail Lomba
    </h3>
    <button type="button" class="text-white bg-transparent text-sm text-center" data-modal-hide="modal">
        <i class="fa-solid fa-xmark"></i>
        <span class="sr-only">Close modal</span>
    </button>
</div>

<!-- Modal body -->
<div class="p-4 md:p-5">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <!-- Poster -->
        @if($lomba->lomba_poster_url)
        <div class="md:col-span-2 flex justify-center">
            <div class="max-w-sm">
                <img src="{{ asset('storage/' . $lomba->lomba_poster_url) }}" alt="Poster {{ $lomba->lomba_nama }}" 
                     class="w-full h-auto object-cover rounded-lg border shadow-md">
            </div>
        </div>
        @endif

        <!-- Nama Lomba -->
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lomba</label>
            <div class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5">
                {{ $lomba->lomba_nama }}
            </div>
        </div>

        <!-- Kategori -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
            <div class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5">
                {{ $lomba->lomba_kategori }}
            </div>
        </div>

        <!-- Penyelenggara -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Penyelenggara</label>
            <div class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5">
                {{ $lomba->lomba_penyelenggara }}
            </div>
        </div>

        <!-- Tingkat -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat Lomba</label>
            <div class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5">
                <span class="px-2 py-1 text-xs rounded-full 
                    @if($lomba->lomba_tingkat == 'Internasional') bg-red-100 text-red-800
                    @elseif($lomba->lomba_tingkat == 'Nasional') bg-blue-100 text-blue-800
                    @else bg-green-100 text-green-800 @endif">
                    {{ $lomba->lomba_tingkat }}
                </span>
            </div>
        </div>

        <!-- Lokasi -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi Lomba</label>
            <div class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5">
                {{ $lomba->lomba_lokasi_preferensi }}
            </div>
        </div>

        <!-- Periode -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Periode</label>
            <div class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5">
                {{ $lomba->periode->periode_nama ?? 'Tidak ada periode' }}
            </div>
        </div>

        <!-- Status -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <div class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5">
                <span class="px-2 py-1 text-xs rounded-full 
                    @if($lomba->lomba_status == 'buka') bg-green-100 text-green-800
                    @elseif($lomba->lomba_status == 'tutup') bg-gray-100 text-gray-800
                    @else bg-red-100 text-red-800 @endif">
                    {{ ucfirst($lomba->lomba_status) }}
                </span>
            </div>
        </div>

        <!-- Tanggal Mulai Pendaftaran -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Mulai Pendaftaran</label>
            <div class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5">
                {{ $lomba->lomba_mulai_pendaftaran->format('d F Y') }}
            </div>
        </div>

        <!-- Tanggal Akhir Pendaftaran -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Akhir Pendaftaran</label>
            <div class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5">
                {{ $lomba->lomba_akhir_pendaftaran->format('d F Y') }}
            </div>
        </div>

        <!-- Deskripsi -->
        @if($lomba->lomba_deskripsi)
        <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Lomba</label>
            <div class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg p-2.5 min-h-[100px]">
                {{ $lomba->lomba_deskripsi }}
            </div>
        </div>
        @endif

        <!-- Timestamps -->
        <div class="md:col-span-2 pt-4 border-t border-gray-200">
            <div class="grid grid-cols-2 gap-4 text-xs text-gray-500">
                <div>
                    <span class="font-medium">Dibuat:</span>
                    {{ $lomba->created_at->format('d F Y H:i') }}
                </div>
                <div>
                    <span class="font-medium">Diperbarui:</span>
                    {{ $lomba->updated_at->format('d F Y H:i') }}
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        <button type="button" class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200" data-modal-hide="modal">
            <i class="fa-solid fa-times me-1"></i>
            Tutup
        </button>
    </div>
</div>