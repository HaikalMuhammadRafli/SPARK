@extends('layouts.app')

@section('content')
    <section class="bg-white flex flex-col md:flex-row md:justify-between md:items-center gap-4 p-4 rounded-xl mb-2">
        <div class="flex flex-col gap-1">
            <h1 class="text-xl font-bold">{{ $title }}</h1>
            <x-breadcrumbs :items="$breadcrumbs" />
        </div>
        <div class="flex flex-row gap-2">
            <x-buttons.table-actions type="button" title="Kembali" color="secondary" icon="arrow-left"
                onclick="window.location.href='{{ route('admin.manajemen.lomba.index') }}'" />
            <x-buttons.table-actions type="button" title="Edit" color="primary" icon="pencil"
                onclick="modalAction('{{ route('admin.manajemen.lomba.edit', $lomba->lomba_id) }}')" />
        </div>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <!-- Poster Lomba -->
        <section class="bg-white p-4 rounded-xl">
            <h2 class="text-lg font-semibold mb-4">Poster Lomba</h2>
            <div class="w-full">
                <img src="{{ $lomba->lomba_poster_url ? Storage::url($lomba->lomba_poster_url) : asset('images/default-poster.png') }}"
                     alt="Poster {{ $lomba->lomba_nama }}"
                     class="w-full h-auto rounded-lg border shadow-md object-cover object-center"
                     style="max-height:400px;">
            </div>
        </section>

        <!-- Detail Informasi -->
        <section class="lg:col-span-2 bg-white p-4 rounded-xl">
            <h2 class="text-lg font-semibold mb-4">Informasi Lomba</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Nama Lomba -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lomba</label>
                    <p class="text-lg font-semibold text-gray-900">{{ $lomba->lomba_nama }}</p>
                </div>
                <!-- Kategori -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <p class="text-gray-900">{{ $lomba->lomba_kategori }}</p>
                </div>
                <!-- Penyelenggara -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Penyelenggara</label>
                    <p class="text-gray-900">{{ $lomba->lomba_penyelenggara }}</p>
                </div>
                <!-- Tingkat -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat</label>
                    <span class="px-3 py-1 text-sm rounded-full font-medium
                        @if($lomba->lomba_tingkat == 'Internasional') bg-red-100 text-red-800
                        @elseif($lomba->lomba_tingkat == 'Nasional') bg-blue-100 text-blue-800
                        @elseif($lomba->lomba_tingkat == 'Regional') bg-yellow-100 text-yellow-800
                        @else bg-green-100 text-green-800 @endif">
                        {{ $lomba->lomba_tingkat }}
                    </span>
                </div>
                <!-- Lokasi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                    <p class="text-gray-900">{{ $lomba->lomba_lokasi_preferensi }}</p>
                </div>
                <!-- Periode -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Periode</label>
                    <p class="text-gray-900">{{ $lomba->periode->periode_nama ?? 'Tidak ada periode' }}</p>
                </div>
                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    @php
                        $statusColor = match($lomba->lomba_status) {
                            'Akan datang' => 'bg-blue-100 text-blue-800 border-blue-400',
                            'Sedang berlangsung' => 'bg-green-100 text-green-800 border-green-400',
                            'Berakhir' => 'bg-gray-100 text-gray-800 border-gray-400',
                            'Ditolak' => 'bg-red-100 text-red-800 border-red-400',
                            default => 'bg-gray-100 text-gray-800 border-gray-400'
                        };
                    @endphp
                    <span class="{{ $statusColor }} text-sm font-medium px-3 py-1 rounded-full border">
                        {{ ucfirst($lomba->lomba_status) }}
                    </span>
                </div>
                <!-- Tanggal Pendaftaran -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Mulai Pendaftaran</label>
                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($lomba->lomba_mulai_pendaftaran)->format('d F Y') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Akhir Pendaftaran</label>
                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($lomba->lomba_akhir_pendaftaran)->format('d F Y') }}</p>
                </div>
                <!-- Deskripsi -->
                @if($lomba->lomba_deskripsi)
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <div class="bg-gray-50 rounded-lg p-3">
                        <p class="text-gray-900 text-sm leading-relaxed">{{ $lomba->lomba_deskripsi }}</p>
                    </div>
                </div>
                @endif
                <!-- Informasi Tambahan -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Informasi Tambahan</label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 rounded-lg p-3">
                            <p class="text-xs text-blue-600 font-medium">Ukuran Kelompok</p>
                            <p class="text-lg font-semibold text-blue-900">{{ $lomba->lomba_ukuran_kelompok }} orang</p>
                        </div>
                        @if($lomba->lomba_mulai_pelaksanaan)
                        <div class="bg-green-50 rounded-lg p-3">
                            <p class="text-xs text-green-600 font-medium">Mulai Pelaksanaan</p>
                            <p class="text-sm font-semibold text-green-900">{{ \Carbon\Carbon::parse($lomba->lomba_mulai_pelaksanaan)->format('d/m/Y') }}</p>
                        </div>
                        @endif
                        @if($lomba->lomba_selesai_pelaksanaan)
                        <div class="bg-red-50 rounded-lg p-3">
                            <p class="text-xs text-red-600 font-medium">Selesai Pelaksanaan</p>
                            <p class="text-sm font-semibold text-red-900">{{ \Carbon\Carbon::parse($lomba->lomba_selesai_pelaksanaan)->format('d/m/Y') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                <!-- Link Registrasi -->
                @if($lomba->lomba_link_registrasi)
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Link Registrasi</label>
                    <a href="{{ $lomba->lomba_link_registrasi }}" target="_blank"
                       class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 text-sm">
                        <i class="fa-solid fa-external-link"></i>
                        {{ $lomba->lomba_link_registrasi }}
                    </a>
                </div>
                @endif
                <!-- Timestamps -->
                <div class="md:col-span-2 mt-4 pt-4 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row gap-4 text-xs text-gray-500">
                        <p><span class="font-medium">Dibuat:</span> {{ \Carbon\Carbon::parse($lomba->created_at)->format('d F Y H:i') }}</p>
                        <p><span class="font-medium">Diperbarui:</span> {{ \Carbon\Carbon::parse($lomba->updated_at)->format('d F Y H:i') }}</p>
                        @if($lomba->validated_at)
                        <p><span class="font-medium">Divalidasi:</span> {{ \Carbon\Carbon::parse($lomba->validated_at)->format('d F Y H:i') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>

    <x-modal />
@endsection

@push('scripts')
<script>
    function reloadDataTable() {
        location.reload();
    }
</script>
@endpush