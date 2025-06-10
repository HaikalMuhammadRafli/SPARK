<div class="grid grid-cols-1 md:grid-cols-3 gap-3">
    @foreach ($kelompoks as $kelompok)
        <div class="bg-white border border-gray-200 rounded-xl">
            <img class="rounded-t-lg w-full h-24 object-cover object-top"
                src="{{ $kelompok->lomba->lomba_poster_url ? Storage::url($kelompok->lomba->lomba_poster_url) : asset('images/default-poster.png') }}" />
            <div class="p-5">
                <h5 class="text-xl font-bold tracking-tight text-gray-900">{{ $kelompok->kelompok_nama }}</h5>
                <p class="mb-3 text-sm font-normal text-gray-700">{{ $kelompok->lomba->lomba_nama }}</p>
                <hr class="my-3 border-gray-200">
                <div class="space-y-2 mb-3">
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-600">Dosen Pembimbing</label>
                        <div class="flex flex-row">
                            <img class="w-10 h-10 rounded-full"
                                src="{{ $kelompok->dosen_pembimbing_peran->dosen_pembimbing->user->foto_profil_url ? Storage::url($kelompok->dosen_pembimbing_peran->dosen_pembimbing->user->foto_profil_url) : asset('images/default-profile.svg') }}"
                                alt="Rounded avatar">
                            <div class="ms-2">
                                <p class="text-sm font-bold text-gray-900">
                                    {{ $kelompok->dosen_pembimbing_peran->dosen_pembimbing->user->getCurrentData()->nama }}
                                </p>
                                <p class="text-xs text-gray-600">
                                    {{ $kelompok->dosen_pembimbing_peran->dosen_pembimbing->nip }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @php
                        $ketua = $kelompok->mahasiswa_perans->where('peran_nama', 'Ketua')->first();
                    @endphp
                    @if ($ketua)
                        <div class="space-y-1">
                            <label class="block text-xs font-medium text-gray-600">Ketua Kelompok</label>
                            <div class="flex flex-row">
                                <img class="w-10 h-10 rounded-full"
                                    src="{{ $ketua->mahasiswa->user->foto_profil_url ? Storage::url($ketua->mahasiswa->user->foto_profil_url) : asset('images/default-profile.svg') }}"
                                    alt="Rounded avatar">
                                <div class="ms-2">
                                    <p class="text-sm font-bold text-gray-900">
                                        {{ $ketua->mahasiswa->user->getCurrentData()->nama }}
                                    </p>
                                    <p class="text-xs text-gray-600">
                                        {{ $ketua->mahasiswa->nim }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="flex justify-between items-center">
                    <div class="flex -space-x-4 rtl:space-x-reverse items-center">
                        @foreach ($kelompok->mahasiswa_perans as $mahasiswa_peran)
                            <img class="w-6 h-6 border-2 border-white rounded-full"
                                src="{{ $mahasiswa_peran->mahasiswa->user->foto_profil_url ? Storage::url($mahasiswa_peran->mahasiswa->user->foto_profil_url) : asset('images/default-profile.svg') }}">
                        @endforeach
                    </div>
                    <x-buttons.default type="button" title="Lihat Kelompok" color="primary"
                        onclick="window.location.href='{{ route('mahasiswa.kelompok.show', $kelompok->lomba->lomba_id) }}'" />
                </div>
            </div>
        </div>
    @endforeach
</div>

@if ($kelompoks->isEmpty())
    <div class="text-center py-8">
        <div class="flex flex-col items-center">
            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            <p class="text-gray-500 text-lg font-medium">Tidak ada kelompok ditemukan</p>
            <p class="text-gray-400 text-sm mt-1">Coba ubah filter atau kata kunci pencarian</p>
        </div>
    </div>
@endif
