@extends('layouts.app')

@section('content')
    <section class="bg-white flex flex-col md:flex-row md:justify-between md:items-center gap-4 p-4 rounded-xl mb-2">
        <div class="flex flex-col gap-1">
            <h1 class="text-xl font-bold">{{ $title }}</h1>
            <x-breadcrumbs :items="$breadcrumbs" />
        </div>
        <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
            <div class="flex flex-row gap-2 flex-wrap">
                <x-buttons.default type="button" title="Export PDF" color="primary" onclick="" />
                <x-buttons.default type="button" title="Export Excel" color="primary" onclick="" />
            </div>
            <div class="flex flex-row gap-2 flex-wrap">
                <x-buttons.default type="button" title="Import Excel" color="primary" onclick="" />
                <x-buttons.default type="button" title="Tambah Baru" color="primary"
                    onclick="modalAction('{{ route('admin.master.periode.create') }}')" />
            </div>
        </div>
    </section>
    <section class="overflow-x-auto bg-white px-4 py-4 rounded-xl">
        <div class="flex justify-end mb-2">
            <div class="w-fit">
                <x-search-input id="datatable-search" placeholder="Cari Periode..." />
            </div>
        </div>
        <table id="table" class="table-auto w-full text-left border-collapse border border-gray-200">
            <thead class="bg-gray-100 text-gray-700 uppercase text-sm font-medium">
                <tr>
                    <th class="px-4 py-3">
                        <span class="flex items-center gap-1">
                            No
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                            </svg>
                        </span>
                    </th>
                    <th class="px-4 py-3">
                        <span class="flex items-center gap-1">
                            ID
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                            </svg>
                        </span>
                    </th>
                    <th class="px-4 py-3">
                        <span class="flex items-center gap-1">
                            Nama Periode
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                            </svg>
                        </span>
                    </th>
                    <th class="px-4 py-3">
                        <span class="flex items-center gap-1">
                            Tahun Awal
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                            </svg>
                        </span>
                    </th>
                    <th class="px-4 py-3">
                        <span class="flex items-center gap-1">
                            Tahun Akhir
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                            </svg>
                        </span>
                    </th>
                    <th class="px-4 py-3">
                        <span class="flex items-center gap-1">
                            Status
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                            </svg>
                        </span>
                    </th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-800">
                @foreach ($periodes as $periode)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-1 whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="px-4 py-1">{{ $periode->periode_id }}</td>
                        <td class="px-4 py-1">{{ $periode->periode_nama }}</td>
                        <td class="px-4 py-1">{{ $periode->periode_tahun_awal }}</td>
                        <td class="px-4 py-1">{{ $periode->periode_tahun_akhir }}</td>
                        <td class="px-4 py-1">
                            @php
                                $currentYear = date('Y');
                                $isActive = $currentYear >= $periode->periode_tahun_awal && $currentYear <= $periode->periode_tahun_akhir;
                            @endphp
                            @if($isActive)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <svg class="w-2 h-2 mr-1 fill-current" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3"/>
                                    </svg>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <svg class="w-2 h-2 mr-1 fill-current" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3"/>
                                    </svg>
                                    Tidak Aktif
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-1 text-right">
                            <x-buttons.action route_prefix="admin.master.periode"
                                id="{{ $periode->periode_id }}" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>

    <div id="modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div id="modal-content" class="relative bg-white rounded-xl shadow-sm">
                {{-- Loaded content here --}}
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        #modal.show {
            display: flex !important;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            console.log("Checking for table and DataTable...");
            if (document.getElementById("table") && typeof simpleDatatables.DataTable !== 'undefined') {
                console.log("Initializing DataTable...");
                try {
                    window.dataTable = new simpleDatatables.DataTable("#table", {
                        searchable: false,
                        perPage: 10,
                        perPageSelect: false,
                        nextPrev: true,
                        columns: [{
                                select: 0,
                                sortable: true
                            },
                            {
                                select: 1,
                                sortable: true
                            },
                            {
                                select: 2,
                                sortable: true
                            },
                            {
                                select: 3,
                                sortable: true
                            },
                            {
                                select: 4,
                                sortable: true
                            },
                            {
                                select: 5,
                                sortable: true
                            },
                            {
                                select: 6,
                                sortable: false
                            },
                        ],

                        labels: {
                            placeholder: "Cari...",
                            perPage: "entri per halaman",
                            noRows: "Tidak ada entri ditemukan",
                            info: "Menampilkan {start} sampai {end} dari {rows} entri",
                            noResults: "Tidak ada hasil yang cocok dengan pencarian Anda"
                        }
                    });

                    $('#datatable-search').on('input', function() {
                        dataTable.search($(this).val());
                    });
                } catch (error) {
                    console.error("DataTable initialization failed:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal menginisialisasi tabel. Silakan coba lagi.'
                    });
                }
            } else {
                console.error("Table or DataTable library not found!");
            }

            const modal = document.getElementById('modal');
            let modalInstance = null;

            window.modalAction = function(url) {
                if (modalInstance) {
                    disposeModal();
                }

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        modalInstance = new Modal(modal);

                        $('#modal-content').html(response);
                        modalInstance.show();
                    },
                    error: function(xhr) {
                        console.error('Error loading modal content:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal memuat form. Silakan coba lagi.'
                        });
                    }
                });
            };

            $(document).off('click', '[data-modal-hide="modal"]').on('click', '[data-modal-hide="modal"]',
                function() {
                    disposeModal();
                });

            window.disposeModal = function() {
                if (modalInstance) {
                    if (typeof modalInstance.hide === 'function') {
                        modalInstance.hide();
                    }
                    if (typeof modalInstance.dispose === 'function') {
                        modalInstance.dispose();
                    }
                    $('#modal-content').empty();
                    modalInstance = null;
                }
            }
        });
    </script>
@endpush