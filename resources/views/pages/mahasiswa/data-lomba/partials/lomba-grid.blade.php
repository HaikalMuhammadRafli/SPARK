<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach ($lombas as $lomba)
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 flex flex-col h-full">
            <!-- Image Section -->
            <div class="relative overflow-hidden rounded-t-xl">
                <img 
                    src="{{ $lomba->lomba_poster_url && \Illuminate\Support\Facades\Storage::disk('public')->exists($lomba->lomba_poster_url) 
                        ? Storage::url($lomba->lomba_poster_url) 
                        : asset('images/default-poster.png') }}"
                    alt="Poster {{ $lomba->lomba_nama }}"
                    class="w-full h-auto rounded-lg border shadow-md object-cover object-center"
                    style="max-height:400px;">
                
                <!-- Status Badge Overlay -->
                @php
                    $statusColor = match($lomba->lomba_status) {
                        'Akan datang' => 'bg-blue-500 text-white',
                        'Sedang berlangsung' => 'bg-green-500 text-white',
                        'Berakhir' => 'bg-gray-500 text-white',
                        'Ditolak' => 'bg-red-500 text-white',
                        default => 'bg-gray-500 text-white'
                    };
                @endphp
                <div class="absolute top-3 right-3">
                    <span class="{{ $statusColor }} text-xs font-semibold px-2.5 py-1 rounded-full shadow-sm">
                        {{ $lomba->lomba_status }}
                    </span>
                </div>
            </div>

            <!-- Content Section - Flex grow untuk mengisi ruang -->
            <div class="p-5 flex flex-col flex-grow">
                <!-- Header Info -->
                <div class="mb-4">
                    <h5 class="text-lg font-bold tracking-tight text-gray-900 mb-2 line-clamp-2 leading-tight">
                        {{ $lomba->lomba_nama }}
                    </h5>
                    <p class="text-sm text-gray-600 font-medium">{{ $lomba->lomba_penyelenggara }}</p>
                </div>

                <!-- Tags Section -->
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="inline-flex items-center bg-blue-50 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-md border border-blue-200">
                        <i class="fa-solid fa-layer-group mr-1.5 text-blue-500"></i>
                        {{ $lomba->lomba_kategori }}
                    </span>
                    <span class="inline-flex items-center bg-green-50 text-green-700 text-xs font-medium px-2.5 py-1 rounded-md border border-green-200">
                        <i class="fa-solid fa-trophy mr-1.5 text-green-500"></i>
                        {{ $lomba->lomba_tingkat }}
                    </span>
                    <span class="inline-flex items-center bg-purple-50 text-purple-700 text-xs font-medium px-2.5 py-1 rounded-md border border-purple-200">
                        <i class="fa-solid fa-users mr-1.5 text-purple-500"></i>
                        {{ $lomba->lomba_ukuran_kelompok }} orang
                    </span>
                    
                    {{-- Status Periode berdasarkan tahun --}}
                    @if($lomba->periode)
                        @php
                            $currentYear = date('Y');
                            $periodeStatus = 'berakhir';
                            $periodeColor = 'bg-gray-50 text-gray-700 border-gray-200';
                            $periodeIcon = 'clock';
                            
                            if ($currentYear >= $lomba->periode->periode_tahun_awal && $currentYear <= $lomba->periode->periode_tahun_akhir) {
                                $periodeStatus = 'periode aktif';
                                $periodeColor = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                $periodeIcon = 'check-circle';
                            } elseif ($currentYear < $lomba->periode->periode_tahun_awal) {
                                $periodeStatus = 'akan datang';
                                $periodeColor = 'bg-cyan-50 text-cyan-700 border-cyan-200';
                                $periodeIcon = 'clock';
                            }
                        @endphp
                        <span class="inline-flex items-center {{ $periodeColor }} text-xs font-medium px-2.5 py-1 rounded-md border">
                            <i class="fa-solid fa-{{ $periodeIcon }} mr-1.5"></i>
                            {{ $periodeStatus }}
                        </span>
                    @endif
                </div>

                <!-- Details Section - Flex grow untuk mengisi ruang yang tersisa -->
                <div class="flex-grow">
                    <div class="bg-gray-50 rounded-lg p-3 space-y-2 mb-4">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-500 font-medium flex items-center">
                                <i class="fa-solid fa-calendar-plus mr-2 text-gray-400"></i>
                                Pendaftaran
                            </span>
                            <span class="font-semibold text-gray-700">
                                {{ \Carbon\Carbon::parse($lomba->lomba_mulai_pendaftaran)->format('d M') }} - 
                                {{ \Carbon\Carbon::parse($lomba->lomba_akhir_pendaftaran)->format('d M Y') }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-500 font-medium flex items-center">
                                <i class="fa-solid fa-play-circle mr-2 text-gray-400"></i>
                                Pelaksanaan
                            </span>
                            <span class="font-semibold text-gray-700">
                                {{ \Carbon\Carbon::parse($lomba->lomba_mulai_pelaksanaan)->format('d M') }} - 
                                {{ \Carbon\Carbon::parse($lomba->lomba_selesai_pelaksanaan)->format('d M Y') }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-gray-500 font-medium flex items-center">
                                <i class="fa-solid fa-map-marker-alt mr-2 text-gray-400"></i>
                                Lokasi
                            </span>
                            <span class="font-semibold text-gray-700">{{ $lomba->lomba_lokasi_preferensi }}</span>
                        </div>
                    </div>
                </div>

                <!-- Footer Section - Selalu di bagian bawah -->
                <div class="mt-auto pt-4 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="text-xs text-gray-500">
                            @if($lomba->periode)
                                <div class="flex items-center">
                                    <i class="fa-solid fa-calendar-alt mr-1.5 text-gray-400"></i>
                                    <div>
                                        <div class="font-medium text-gray-700">{{ $lomba->periode->periode_nama }}</div>
                                        <div class="text-gray-500">
                                            {{ $lomba->periode->periode_tahun_awal }} - {{ $lomba->periode->periode_tahun_akhir }}
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span class="text-gray-400 italic">Tidak ada periode</span>
                            @endif
                        </div>
                        
                        <x-buttons.table-actions 
                            type="button" 
                            title="Lihat Detail" 
                            color="primary"
                            class="!px-4 !py-2 !text-sm font-medium shadow-sm hover:shadow-md transition-all duration-200"
                            onclick="window.location.href='{{ route('mahasiswa.data-lomba.show', $lomba->lomba_id) }}'" />
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

@if ($lombas->isEmpty())
    <div class="text-center py-16">
        <div class="flex flex-col items-center max-w-sm mx-auto">
            <div class="bg-gray-100 rounded-full p-6 mb-6">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada lomba ditemukan</h3>
            <p class="text-gray-500 text-center leading-relaxed">
                Coba ubah filter atau kata kunci pencarian untuk menemukan lomba yang Anda cari
            </p>
            <button onclick="$('#search').val(''); $('.filter-select').val('').trigger('change'); $('#filter-periode-aktif').prop('checked', false).trigger('change');" 
                    class="mt-4 text-blue-600 hover:text-blue-800 font-medium text-sm">
                Reset Filter
            </button>
        </div>
    </div>
@endif

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>