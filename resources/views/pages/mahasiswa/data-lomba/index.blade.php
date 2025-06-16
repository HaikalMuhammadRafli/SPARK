@extends('layouts.app')

@section('content')
    <!-- Header Section -->
    <section class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 p-6">
            <div class="flex flex-col gap-2">
                <h1 class="text-2xl font-bold text-gray-900">{{ $title }}</h1>
                <x-breadcrumbs :items="$breadcrumbs" />
            </div>
            <x-buttons.table-actions 
                type="button" 
                title="Ajukan Lomba Baru" 
                color="primary"
                class="!px-6 !py-3 !font-semibold shadow-sm hover:shadow-md transition-all duration-200"
                onclick="modalAction('{{ route('mahasiswa.data-lomba.create') }}')" />
        </div>
    </section>

    <!-- Filter and Search Section -->
    <section class="bg-white rounded-xl shadow-sm border border-gray-200 mb-6">
        <div class="p-6">
            <!-- Filter Row -->
            <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4">
                <div class="flex flex-col sm:flex-row gap-3 flex-wrap">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <x-dashboard.filter 
                            id="filter-kategori" 
                            label="Kategori" 
                            placeholder="Semua Kategori" 
                            :options="$kategoris"
                            :searchable="true" 
                            searchPlaceholder="Cari kategori..." 
                            class="w-full sm:w-44" />
                        
                        <x-dashboard.filter 
                            id="filter-lokasi" 
                            name="filter-lokasi" 
                            label="Lokasi" 
                            placeholder="Semua Lokasi"
                            :options="$lokasi_preferensis" 
                            :searchable="true" 
                            searchPlaceholder="Cari lokasi.." 
                            class="w-full sm:w-44" />
                        
                        <x-dashboard.filter 
                            id="filter-tingkat" 
                            name="filter-tingkat" 
                            label="Tingkat" 
                            placeholder="Semua Tingkat"
                            :options="$tingkats" 
                            :searchable="true" 
                            searchPlaceholder="Cari tingkat..." 
                            class="w-full sm:w-44" />
                        
                        <x-dashboard.filter 
                            id="filter-status" 
                            name="filter-status" 
                            label="Status" 
                            placeholder="Semua Status"
                            :options="$statuses" 
                            :searchable="true" 
                            searchPlaceholder="Cari status..." 
                            class="w-full sm:w-44" />
                    </div>
                    
                    <!-- Filter Periode Aktif -->
                    <div class="flex items-center">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   id="filter-periode-aktif" 
                                   class="rounded border-gray-300 text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 transition-colors duration-200">
                            <span class="ml-2 text-sm text-gray-700 font-medium">Hanya Periode Aktif</span>
                        </label>
                    </div>
                </div>
                
                <!-- Search Section -->
                <div class="w-full lg:w-80">
                    <x-search-input 
                        id="search" 
                        placeholder="Cari lomba berdasarkan nama, penyelenggara..." 
                        class="w-full" />
                </div>
            </div>
            
            <!-- Filter Info & Reset -->
            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                <div id="filter-info" class="text-sm text-gray-500">
                    <!-- Filter information will be populated by JavaScript -->
                </div>
                <button type="button" 
                        id="reset-filters" 
                        class="text-sm text-gray-600 hover:text-gray-800 font-medium transition-colors duration-200">
                    Reset Semua Filter
                </button>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section id="lomba-grid" class="min-h-[400px]">
        <!-- Loading state -->
        <div id="loading-state" class="hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @for($i = 0; $i < 6; $i++)
                    <div class="bg-white border border-gray-200 rounded-xl animate-pulse">
                        <div class="h-48 bg-gray-200 rounded-t-xl"></div>
                        <div class="p-5">
                            <div class="h-6 bg-gray-200 rounded mb-2"></div>
                            <div class="h-4 bg-gray-200 rounded w-2/3 mb-3"></div>
                            <div class="flex gap-2 mb-3">
                                <div class="h-6 bg-gray-200 rounded w-16"></div>
                                <div class="h-6 bg-gray-200 rounded w-20"></div>
                                <div class="h-6 bg-gray-200 rounded w-12"></div>
                            </div>
                            <div class="h-16 bg-gray-200 rounded mb-3"></div>
                            <div class="flex justify-between items-center">
                                <div class="h-4 bg-gray-200 rounded w-24"></div>
                                <div class="h-8 bg-gray-200 rounded w-20"></div>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
        
        <!-- Content will be loaded here -->
    </section>

    <x-modal size="2xl"/>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            let searchTimeout;
            let currentFilters = {
                search: '',
                kategori: '',
                lokasi: '',
                tingkat: '',
                status: '',
                periode_aktif: false
            };

            function showLoading() {
                $('#loading-state').removeClass('hidden');
                $('#lomba-grid').children().not('#loading-state').hide();
            }

            function hideLoading() {
                $('#loading-state').addClass('hidden');
                $('#lomba-grid').children().not('#loading-state').show();
            }

            function updateFilterInfo() {
                let activeFilters = [];
                
                if (currentFilters.search) activeFilters.push(`Pencarian: "${currentFilters.search}"`);
                if (currentFilters.kategori) activeFilters.push(`Kategori: ${currentFilters.kategori}`);
                if (currentFilters.lokasi) activeFilters.push(`Lokasi: ${currentFilters.lokasi}`);
                if (currentFilters.tingkat) activeFilters.push(`Tingkat: ${currentFilters.tingkat}`);
                if (currentFilters.status) activeFilters.push(`Status: ${currentFilters.status}`);
                if (currentFilters.periode_aktif) activeFilters.push('Periode Aktif');

                if (activeFilters.length > 0) {
                    $('#filter-info').html(`<i class="fa-solid fa-filter mr-1"></i> Filter aktif: ${activeFilters.join(', ')}`);
                    $('#reset-filters').show();
                } else {
                    $('#filter-info').html('Menampilkan semua lomba');
                    $('#reset-filters').hide();
                }
            }

            function loadLombaData() {
                const searchQuery = $('#search').val();
                const filterKategori = $('#filter-kategori').val();
                const filterLokasi = $('#filter-lokasi').val();
                const filterTingkat = $('#filter-tingkat').val();
                const filterStatus = $('#filter-status').val();
                const filterPeriodeAktif = $('#filter-periode-aktif').is(':checked');

                // Update current filters
                currentFilters = {
                    search: searchQuery,
                    kategori: filterKategori,
                    lokasi: filterLokasi,
                    tingkat: filterTingkat,
                    status: filterStatus,
                    periode_aktif: filterPeriodeAktif
                };

                updateFilterInfo();
                showLoading();

                $.ajax({
                    url: '{{ route('mahasiswa.data-lomba.data') }}',
                    method: 'GET',
                    data: {
                        search: searchQuery,
                        kategori: filterKategori,
                        lokasi: filterLokasi,
                        tingkat: filterTingkat,
                        status: filterStatus,
                        periode_aktif: filterPeriodeAktif
                    },
                    success: function(response) {
                        hideLoading();
                        if (response.status) {
                            $('#lomba-grid').html(response.html);
                        } else {
                            $('#lomba-grid').html(
                                '<div class="text-center py-16">' +
                                    '<div class="bg-red-50 rounded-full p-6 mb-6 inline-block">' +
                                        '<i class="fa-solid fa-exclamation-triangle text-red-400 text-2xl"></i>' +
                                    '</div>' +
                                    '<h3 class="text-xl font-semibold text-gray-900 mb-2">Terjadi Kesalahan</h3>' +
                                    '<p class="text-gray-500">Tidak dapat memuat data lomba. Silakan coba lagi.</p>' +
                                '</div>'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        hideLoading();
                        console.error('Load failed:', error);
                        $('#lomba-grid').html(
                            '<div class="text-center py-16">' +
                                '<div class="bg-red-50 rounded-full p-6 mb-6 inline-block">' +
                                    '<i class="fa-solid fa-wifi text-red-400 text-2xl"></i>' +
                                '</div>' +
                                '<h3 class="text-xl font-semibold text-gray-900 mb-2">Koneksi Bermasalah</h3>' +
                                '<p class="text-gray-500 mb-4">Gagal memuat data. Periksa koneksi internet Anda.</p>' +
                                '<button onclick="reloadDataTable()" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200">Coba Lagi</button>' +
                            '</div>'
                        );
                    }
                });
            }

            // Fungsi untuk reload data table
            window.reloadDataTable = function() {
                loadLombaData();
            };

            // Reset filters function
            $('#reset-filters').on('click', function() {
                $('#search').val('');
                $('#filter-kategori, #filter-lokasi, #filter-tingkat, #filter-status').val('').trigger('change');
                $('#filter-periode-aktif').prop('checked', false);
                loadLombaData();
            });

            // Initial load
            loadLombaData();

            // Search input with debounce
            $('#search').on('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(loadLombaData, 500);
            });

            // Filter change events
            $('#filter-kategori, #filter-lokasi, #filter-tingkat, #filter-status').on('change', function() {
                loadLombaData();
            });

            // Periode aktif checkbox change event
            $('#filter-periode-aktif').on('change', function() {
                loadLombaData();
            });

            // Hide reset button initially
            $('#reset-filters').hide();
        });
    </script>
@endpush