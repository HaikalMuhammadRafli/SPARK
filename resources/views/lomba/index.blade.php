@extends('layouts.app')

@section('content')
    <section class="bg-white flex flex-col md:flex-row md:justify-between md:items-center gap-4 p-4 rounded-xl mb-2">
        <div class="flex flex-col gap-1">
            <h1 class="text-xl font-bold">{{ $title }}</h1>
            <x-breadcrumbs :items="$breadcrumbs" />
        </div>
        <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
            <div class="flex flex-row gap-2 flex-wrap">
                <x-buttons.table-actions type="button" title="Export PDF" color="primary" onclick="" />
                <x-buttons.table-actions type="button" title="Export Excel" color="primary" onclick="" />
            </div>
            <div class="flex flex-row gap-2 flex-wrap">
                <x-buttons.table-actions type="button" title="Import Excel" color="primary" onclick="" />
                <x-buttons.table-actions type="button" title="Tambah Baru" color="primary"
                    onclick="modalAction('{{ route('admin.manajemen.lomba.create') }}')" />
            </div>
        </div>
    </section>

    <section class="overflow-x-auto bg-white px-4 py-4 rounded-xl">
        <div class="flex justify-between items-center mb-4">
            <div class="flex gap-2">
                <x-dashboard.filter id="filter-kategori" label="Filter Kategori" placeholder="Pilih Kategori" :options="$kategoris"
                    :searchable="true" searchPlaceholder="Cari kategori..." class="w-36" />
                <x-dashboard.filter id="filter-lokasi" name="filter-lokasi" label="Filter Lokasi" placeholder="Pilih Lokasi"
                    :options="$lokasi_preferensis" :searchable="true" searchPlaceholder="Cari lokasi.." class="w-36" />
                <x-dashboard.filter id="filter-tingkat" name="filter-tingkat" label="Filter Tingkat" placeholder="Pilih Tingkat"
                    :options="$tingkats" :searchable="true" searchPlaceholder="Cari tingkat..." class="w-36" />
                <x-dashboard.filter id="filter-status" name="filter-status" label="Filter Status" placeholder="Pilih Status"
                    :options="$status_options" :searchable="true" searchPlaceholder="Cari status..." class="w-36" />
            </div>
            <div class="w-fit">
                <x-search-input id="datatable-search" placeholder="Cari Lomba..." />
            </div>
        </div>
        
        <div id="lomba-table-container">
            {{-- content will be loaded here --}}
        </div>
    </section>

    <x-modal />
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            let searchTimeout;

            function loadLombaData() {
                const searchQuery = $('#datatable-search').val();
                const filterKategori = $('#filter-kategori').val();
                const filterLokasi = $('#filter-lokasi').val();
                const filterTingkat = $('#filter-tingkat').val();
                const filterStatus = $('#filter-status').val();

                // Tampilkan loading state
                $('#lomba-table-container').html(
                    '<div class="text-center py-8"><p class="text-gray-500">Memuat data...</p></div>'
                );

                $.ajax({
                    url: '{{ route('admin.manajemen.lomba.data') }}',
                    method: 'GET',
                    data: {
                        search: searchQuery,
                        kategori: filterKategori,
                        lokasi: filterLokasi,
                        tingkat: filterTingkat,
                        status: filterStatus
                    },
                    success: function(response) {
                        console.log('Response:', response); // Debug log
                        if (response.status) {
                            $('#lomba-table-container').html(response.html);
                            console.log('Data count:', response.count); // Debug log
                        } else {
                            $('#lomba-table-container').html(
                                '<div class="text-center py-8"><p class="text-gray-500">Terjadi kesalahan saat memuat data.</p></div>'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', xhr.responseText); // Debug log
                        console.error('Status:', status);
                        console.error('Error:', error);
                        $('#lomba-table-container').html(
                            '<div class="text-center py-8"><p class="text-red-500">Terjadi kesalahan saat memuat data. Silakan coba lagi.</p></div>'
                        );
                    }
                });
            }

            // Initial load
            loadLombaData();

            // Search input with debounce
            $('#datatable-search').on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(loadLombaData, 300);
            });

            // Filter change events
            $('#filter-kategori, #filter-lokasi, #filter-tingkat, #filter-status').on('change', function() {
                loadLombaData();
            });

            // Expose function globally untuk reloadDataTable
            window.loadLombaData = loadLombaData;
        });

        function reloadDataTable() {
            if (typeof window.loadLombaData === 'function') {
                window.loadLombaData();
            }
        }
    </script>
@endpush