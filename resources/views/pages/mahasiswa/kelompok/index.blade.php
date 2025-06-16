@extends('layouts.app')

@section('content')
    <section class="bg-white flex flex-col md:flex-row md:justify-between md:items-center gap-4 p-4 rounded-xl mb-2">
        <div class="flex flex-col gap-1">
            <h1 class="text-xl font-bold">{{ $title }}</h1>
            <x-breadcrumbs :items="$breadcrumbs" />
        </div>
        <x-buttons.default type="button" title="Tambah Baru" color="primary"
            onclick="modalAction('{{ route('mahasiswa.kelompok.create') }}', 'big-modal')" />
    </section>

    <section class="flex justify-between items-center bg-white px-4 py-4 rounded-xl mb-2">
        <div class="flex gap-2">
            <x-dashboard.filter id="filter-kategori" label="Filter Kategori" placeholder="Pilih Kategori" :options="$kategoris"
                :searchable="true" searchPlaceholder="Cari kategori..." class="w-36" />
            <x-dashboard.filter id="filter-lokasi" name="filter-lokasi" label="Filter Lokasi" placeholder="Pilih Lokasi"
                :options="$lokasi_preferensis" :searchable="true" searchPlaceholder="Cari lokasi.." class="w-36" />
            <x-dashboard.filter id="filter-tingkat" name="filter-tingkat" label="Filter Tingkat" placeholder="Pilih Tingkat"
                :options="$tingkats" :searchable="true" searchPlaceholder="Cari tingkat..." class="w-36" />
        </div>
        <div class="w-fit">
            <x-search-input id="search" placeholder="Cari Lomba..." />
        </div>
    </section>

    <section id="kelompok-grid">
        {{-- content will be loaded here --}}
    </section>

    <x-modal id="big-modal" size="4xl" />
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            let searchTimeout;

            function loadKelompokData() {
                const searchQuery = $('#search').val();
                const filterKategori = $('#filter-kategori').val();
                const filterLokasi = $('#filter-lokasi').val();
                const filterTingkat = $('#filter-tingkat').val();
                const filterStatus = $('#filter-status').val();

                $.ajax({
                    url: '{{ route('mahasiswa.kelompok.data') }}',
                    method: 'GET',
                    data: {
                        search: searchQuery,
                        kategori: filterKategori,
                        lokasi: filterLokasi,
                        tingkat: filterTingkat,
                        status: filterStatus
                    },
                    success: function(response) {
                        if (response.status) {
                            $('#kelompok-grid').html(response.html);
                        } else {
                            $('#kelompok-grid').html(
                                '<div class="text-center py-8"><p class="text-gray-500">Terjadi kesalahan saat memuat data.</p></div>'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Load failed:', error);
                        $('#kelompok-grid').html(
                            '<div class="text-center py-8"><p class="text-red-500">Terjadi kesalahan saat memuat data. Silakan coba lagi.</p></div>'
                        );
                    }
                });
            }

            // Initial load
            loadKelompokData();

            // Search input with debounce
            $('#search').on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(loadKelompokData, 300);
            });

            // Filter change events
            $('#filter-kategori, #filter-lokasi, #filter-tingkat, #filter-status').on('change', function() {
                loadKelompokData();
            });
        });
    </script>
@endpush
