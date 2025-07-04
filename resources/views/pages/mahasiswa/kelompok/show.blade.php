@extends('layouts.app')

@section('content')
    <section class="bg-white flex flex-col md:flex-row md:justify-between md:items-center gap-4 p-4 rounded-xl mb-2">
        <div class="flex flex-col gap-1">
            <h1 class="text-xl font-bold">{{ $title }}</h1>
            <x-breadcrumbs :items="$breadcrumbs" />
        </div>
        <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
            <div class="flex flex-row gap-2 flex-wrap">
                @switch($mahasiswa_role)
                    @case('ketua')
                        <x-buttons.default type="button" title="Edit Kelompok" color="primary" icon="fa-solid fa-edit"
                            onclick="modalAction('{{ route('mahasiswa.kelompok.edit', $kelompok->kelompok_id) }}', 'big-modal')" />
                        <x-buttons.default type="button" title="Hapus Kelompok" color="primary" icon="fa-solid fa-trash-bin"
                            onclick="modalAction('{{ route('mahasiswa.kelompok.delete', $kelompok->kelompok_id) }}', 'small-modal')" />
                    @break

                    @case('member')
                        <form action="{{ route('mahasiswa.kelompok.leave', $kelompok->kelompok_id) }}" method="post"
                            id="form-keluar">
                            @csrf
                            <x-buttons.default type="submit" title="Keluar" color="primary"
                                icon="fa-solid fa-arrow-right-from-bracket" />
                        </form>
                    @break

                    @case('non_member')
                        <x-buttons.default type="button" title="Bergabung" color="primary"
                            icon="fa-solid fa-arrow-right-to-bracket"
                            {{ $kelompok->lomba->lomba_ukuran_kelompok == $kelompok->mahasiswas->count() ? 'disabled' : '' }}
                            onclick="modalAction('{{ route('mahasiswa.kelompok.join.form', $kelompok->kelompok_id) }}')" />
                    @break
                @endswitch
            </div>
        </div>
    </section>

    <section class="overflow-x-auto flex flex-row gap-2">
        <div class="w-1/3">
            <div class="bg-white border border-gray-200 rounded-xl">
                <img class="rounded-t-lg w-full h-48 object-cover object-top"
                    src="{{ $kelompok->lomba->lomba_poster_url ? Storage::url($kelompok->lomba->lomba_poster_url) : asset('images/default-poster.png') }}"
                    alt="" />
                <div class="p-5">
                    <h5 class="text-xl font-bold tracking-tight text-gray-900">{{ $kelompok->lomba->lomba_nama }}</h5>
                    <p class="mb-3 text-sm font-normal text-gray-700">{{ $kelompok->lomba->lomba_penyelenggara }}</p>
                    <div class="flex flex-wrap mb-3">
                        <span
                            class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm border border-blue-400">{{ $kelompok->lomba->lomba_status }}</span>
                        <span
                            class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm border border-blue-400">{{ $kelompok->lomba->lomba_ukuran_kelompok }}
                            orang</span>
                        <span
                            class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm border border-blue-400">{{ $kelompok->lomba->periode->periode_nama }}</span>
                    </div>
                    <x-buttons.default type="button" title="Lihat Lomba" color="primary" icon="fa-solid fa-eye"
                        onclick="window.location.href='{{ route('admin.manajemen.lomba.show', $kelompok->lomba->lomba_id) }}'" />
                </div>
            </div>
        </div>
        <div class="w-2/3">
            <div class="bg-white border border-gray-200 rounded-xl p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Informasi Kelompok</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-600">Nama Kelompok</label>
                        <p class="text-md font-semibold text-gray-900">{{ $kelompok->kelompok_nama }}</p>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-600">Dibuat Pada</label>
                        <p class="text-md font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($kelompok->created_at)->format('d M Y') }}
                        </p>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-medium text-gray-600">Jumlah Anggota</label>
                        <p class="text-md font-semibold text-gray-900">
                            {{ $kelompok->mahasiswas->count() ?? 0 }} /
                            {{ $kelompok->lomba->lomba_ukuran_kelompok }} orang
                        </p>
                    </div>
                </div>
                <hr class="my-4 border-gray-300" />
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div class="">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Dosen Pembimbing</label>
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
                    <div class="">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Peran</label>
                        <p class="text-sm font-bold text-gray-900">
                            {{ $kelompok->dosen_pembimbing_peran->peran_nama }}
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-4">
                    <label class="block text-xs font-medium text-gray-600">Mahasiswa</label>
                    <label class="block text-xs font-medium text-gray-600">Peran</label>
                    @foreach ($kelompok->mahasiswa_perans as $mahasiswa_peran)
                        <div class="">
                            <div class="flex flex-row">
                                <img class="w-10 h-10 rounded-full"
                                    src="{{ $kelompok->dosen_pembimbing_peran->dosen_pembimbing->user->foto_profil_url ? Storage::url($kelompok->dosen_pembimbing_peran->dosen_pembimbing->user->foto_profil_url) : asset('images/default-profile.svg') }}"
                                    alt="Rounded avatar">
                                <div class="ms-2">
                                    <p class="text-sm font-bold text-gray-900">
                                        {{ $mahasiswa_peran->mahasiswa->user->getCurrentData()->nama }}
                                    </p>
                                    <p class="text-xs text-gray-600">
                                        {{ $mahasiswa_peran->mahasiswa->nim }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <p class="text-sm font-bold text-gray-900">
                                {{ $mahasiswa_peran->peran_nama }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <x-modal id="big-modal" size="4xl" />
    <x-modal id="small-modal" />
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#form-keluar').on('submit', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi',
                    text: 'Apakah Anda yakin ingin keluar dari kelompok ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, keluar',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: $(this).attr('action'),
                            type: 'POST',
                            data: $(this).serialize(),
                            success: function(response) {
                                if (response.status) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.message
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: response.message
                                    });
                                }
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Terjadi kesalahan saat memproses permintaan.'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
