@extends('layouts.app')

@section('content')
    <section class="bg-white flex flex-col md:flex-row md:justify-between md:items-center gap-4 p-4 rounded-xl mb-2">
        <div class="flex flex-col gap-1">
            <h1 class="text-xl font-bold">{{ $title }}</h1>
            <x-breadcrumbs :items="$breadcrumbs" />
        </div>
        <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
            <div class="flex flex-row gap-2 flex-wrap">
                @if ($lomba->lomba_status === 'Sedang berlangsung')
                    <x-buttons.default type="button" title="Buat Kelompok" color="primary"
                        onclick="window.location.href='{{ route('mahasiswa.kelompok.create', ['lomba_id' => $lomba->lomba_id]) }}'" />
                @endif
                @if ($lomba->created_by === auth()->user()->user_id)
                    <x-buttons.default type="button" title="Edit Lomba" color="warning"
                        onclick="window.location.href='{{ route('mahasiswa.data-lomba.edit', $lomba->lomba_id) }}'" />
                @endif
            </div>
        </div>
    </section>

    <section class="overflow-x-auto flex flex-col gap-4">
        <div class="w-full">
            <div class="bg-white border border-gray-200 rounded-xl">
                <img class="rounded-t-lg w-full h-64 object-cover object-center"
                    src="{{ $lomba->lomba_poster_url ? Storage::url($lomba->lomba_poster_url) : asset('images/default-poster.png') }}"
                    alt="{{ $lomba->lomba_nama }}" />
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h5 class="text-2xl font-bold tracking-tight text-gray-900 mb-2">{{ $lomba->lomba_nama }}</h5>
                            <p class="text-lg font-medium text-gray-600">{{ $lomba->lomba_penyelenggara }}</p>
                        </div>
                        <div class="flex flex-col gap-2">
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
                                {{ $lomba->lomba_status }}
                            </span>
                            
                            {{-- Status Periode --}}
                            @if($lomba->periode)
                                @php
                                    $currentYear = date('Y');
                                    $periodeStatus = 'Periode Berakhir';
                                    $periodeColor = 'bg-gray-100 text-gray-800 border-gray-400';
                                    
                                    if ($currentYear >= $lomba->periode->periode_tahun_awal && $currentYear <= $lomba->periode->periode_tahun_akhir) {
                                        $periodeStatus = 'Periode Aktif';
                                        $periodeColor = 'bg-emerald-100 text-emerald-800 border-emerald-400';
                                    } elseif ($currentYear < $lomba->periode->periode_tahun_awal) {
                                        $periodeStatus = 'Periode Akan Datang';
                                        $periodeColor = 'bg-cyan-100 text-cyan-800 border-cyan-400';
                                    }
                                @endphp
                                <span class="{{ $periodeColor }} text-sm font-medium px-3 py-1 rounded-full border">
                                    {{ $periodeStatus }}
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full border border-blue-400">
                            {{ $lomba->lomba_kategori }}
                        </span>
                        <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full border border-green-400">
                            {{ $lomba->lomba_tingkat }}
                        </span>
                        <span class="bg-purple-100 text-purple-800 text-sm font-medium px-3 py-1 rounded-full border border-purple-400">
                            {{ $lomba->lomba_ukuran_kelompok }} orang per kelompok
                        </span>
                        <span class="bg-orange-100 text-orange-800 text-sm font-medium px-3 py-1 rounded-full border border-orange-400">
                            {{ $lomba->lomba_lokasi_preferensi }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Informasi Lomba -->
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Lomba</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-600">Nama Lomba</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $lomba->lomba_nama }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-600">Penyelenggara</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $lomba->lomba_penyelenggara }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-600">Kategori</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $lomba->lomba_kategori }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-600">Tingkat</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $lomba->lomba_tingkat }}</p>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-600">Ukuran Kelompok</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $lomba->lomba_ukuran_kelompok }} orang</p>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-600">Lokasi Preferensi</label>
                            <p class="text-sm font-semibold text-gray-900">{{ $lomba->lomba_lokasi_preferensi }}</p>
                        </div>
                    </div>
                    
                    @if ($lomba->lomba_persyaratan)
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-600">Persyaratan</label>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $lomba->lomba_persyaratan }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Jadwal Lomba -->
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Jadwal Lomba</h3>
                <div class="space-y-4">
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-600">Periode Pendaftaran</label>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($lomba->lomba_mulai_pendaftaran)->format('d M Y') }} - 
                            {{ \Carbon\Carbon::parse($lomba->lomba_akhir_pendaftaran)->format('d M Y') }}
                        </p>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-600">Periode Pelaksanaan</label>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($lomba->lomba_mulai_pelaksanaan)->format('d M Y') }} - 
                            {{ \Carbon\Carbon::parse($lomba->lomba_selesai_pelaksanaan)->format('d M Y') }}
                        </p>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-600">Periode Akademik</label>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $lomba->periode->periode_nama ?? 'Tidak ada periode' }}
                            @if($lomba->periode)
                                <span class="text-xs text-gray-500 block">
                                    ({{ $lomba->periode->periode_tahun_awal }} - {{ $lomba->periode->periode_tahun_akhir }})
                                </span>
                            @endif
                        </p>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-600">Status Validasi</label>
                        <p class="text-sm font-semibold text-gray-900">
                            @if($lomba->validated_at)
                                <span class="text-green-600">Tervalidasi</span>
                                <span class="text-xs text-gray-500 block">
                                    {{ \Carbon\Carbon::parse($lomba->validated_at)->format('d M Y H:i') }}
                                </span>
                            @else
                                <span class="text-yellow-600">Menunggu Validasi</span>
                            @endif
                        </p>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-600">Dibuat Pada</label>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($lomba->created_at)->format('d M Y H:i') }}
                        </p>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-600">Terakhir Diperbarui</label>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($lomba->updated_at)->format('d M Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Link dan Informasi Tambahan -->
        @if ($lomba->lomba_link_registrasi)
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Link Terkait</h3>
                <div class="flex flex-wrap gap-3">
                    <x-buttons.table-actions type="button" title="Link Registrasi" color="primary"
                        onclick="window.open('{{ $lomba->lomba_link_registrasi }}', '_blank')" />
                </div>
            </div>
        @endif

        <!-- Dibuat Oleh -->
        @if ($lomba->creator)
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Dibuat Oleh</h3>
                <div class="flex items-center space-x-4">
                    <img class="w-12 h-12 rounded-full"
                        src="{{ $lomba->creator->foto_profil_url ? Storage::url($lomba->creator->foto_profil_url) : asset('images/default-profile.svg') }}"
                        alt="Creator Profile">
                    <div>
                        <p class="text-sm font-bold text-gray-900">
                            {{ $lomba->creator->getCurrentData()->nama ?? 'Nama tidak tersedia' }}
                        </p>
                        <p class="text-xs text-gray-600">
                            {{ $lomba->creator->email }}
                        </p>
                        @if($lomba->creator->getCurrentData() && $lomba->creator->getCurrentData()->program_studi)
                            <p class="text-xs text-gray-500">
                                {{ $lomba->creator->getCurrentData()->program_studi }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        @endif

        {{-- Statistik Lomba (jika ada) --}}
        @if(isset($lomba->kelompok_count) || isset($lomba->peserta_count))
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Statistik Lomba</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @if(isset($lomba->kelompok_count))
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">{{ $lomba->kelompok_count }}</div>
                            <div class="text-sm text-blue-600">Total Kelompok</div>
                        </div>
                    @endif
                    @if(isset($lomba->peserta_count))
                        <div class="text-center p-4 bg-green-50 rounded-lg">
                            <div class="text-2xl font-bold text-green-600">{{ $lomba->peserta_count }}</div>
                            <div class="text-sm text-green-600">Total Peserta</div>
                        </div>
                    @endif
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">{{ $lomba->lomba_ukuran_kelompok }}</div>
                        <div class="text-sm text-purple-600">Maks per Kelompok</div>
                    </div>
                </div>
            </div>
        @endif
    </section>

    <x-modal size="4xl" />
@endsection