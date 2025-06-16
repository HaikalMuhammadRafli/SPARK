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
                    onclick="modalAction('{{ route('dosen-pembimbing.kelompok-bimbingan.create') }}')" />
            </div>
        </div>
    </section>

    <section class="overflow-x-auto bg-white px-4 py-4 rounded-xl">
        <div class="flex justify-end mb-2">
            <div class="w-fit">
                <x-search-input id="datatable-search" placeholder="Cari Peran" />
            </div>
        </div>

        {{-- x-data-table with manually populated tbody --}}
        <x-data-table id="table-body" :headers="[
            ['title' => 'No', 'key' => 'no', 'sortable' => true],
            ['title' => 'Kelompok ID', 'key' => 'nip', 'sortable' => false],
            ['title' => 'Nama Peran', 'key' => 'nama', 'sortable' => false],
            ['title' => 'Kompetensi', 'key' => 'kompetensi', 'sortable' => false],
            ['title' => 'Aksi', 'key' => 'actions', 'sortable' => false],
        ]">

        </x-data-table>
    </section>

    <x-modal />
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            const token = localStorage.getItem('api_token');
            if (!token) {
                console.error("No API token found in localStorage.");
                return;
            }

            const peranUrl = 'http://127.0.0.1:8000/api/dosen-pembimbing-peran';
            const relasiUrl = 'http://127.0.0.1:8000/api/dosen-pembimbing-peran-kompetensi';
            const kompetensiBaseUrl = 'http://127.0.0.1:8000/api/kompetensi/';

            try {
                // Fetch data peran dan relasi peran-kompetensi
                const [peranRes, relasiRes] = await Promise.all([
                    fetch(peranUrl, {
                        method: 'GET',
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Accept': 'application/json',
                        }
                    }),
                    fetch(relasiUrl, {
                        method: 'GET',
                        headers: {
                            'Authorization': 'Bearer ' + token,
                            'Accept': 'application/json',
                        }
                    })
                ]);

                const peranData = await peranRes.json();
                const relasiData = await relasiRes.json();

                const tbody = document.querySelector('#table tbody');
                if (!tbody) {
                    console.error('tbody not found inside #table');
                    return;
                }

                tbody.innerHTML = '';

                // Cache untuk menghindari fetch nama kompetensi yang sama berulang kali
                const kompetensiCache = new Map();

                for (let [index, item] of peranData.data.entries()) {
                    // Dapatkan semua kompetensi_id terkait peran_id ini
                    const relatedRelasi = relasiData.data.filter(r => r.peran_id === item.peran_id);
                    const kompetensiIds = relatedRelasi.map(r => r.kompetensi_id);

                    // Fetch nama kompetensi satu per satu (atau dari cache)
                    const kompetensiNames = await Promise.all(
                        kompetensiIds.map(async (id) => {
                            if (kompetensiCache.has(id)) {
                                return kompetensiCache.get(id);
                            }
                            try {
                                const res = await fetch(kompetensiBaseUrl + id, {
                                    method: 'GET',
                                    headers: {
                                        'Authorization': 'Bearer ' + token,
                                        'Accept': 'application/json',
                                    }
                                });
                                const result = await res.json();
                                const nama = result.data?.kompetensi_nama || `ID: ${id}`;
                                kompetensiCache.set(id, nama);
                                return nama;
                            } catch (err) {
                                console.error(`Error fetching kompetensi ID ${id}`, err);
                                return `ID: ${id}`;
                            }
                        })
                    );

                    // Gabungkan nama kompetensi menjadi satu string
                    const kompetensiList = kompetensiNames.join(', ');

                    const row = document.createElement('tr');
                    row.className = 'border-b hover:bg-gray-50';
                    row.innerHTML = `
                <td class="px-4 py-1 whitespace-nowrap">${index + 1}</td>
                <td class="px-4 py-1">${item.kelompok_id}</td>
                <td class="px-4 py-1">${item.peran_nama}</td>
                <td class="px-4 py-1">${kompetensiList}</td>
                <td class="px-4 py-1 text-left">
                    <div class="inline-flex rounded-md shadow-xs" role="group">
                        <button type="button"
                            onclick="openEditModal('${item.peran_id}')"
                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-yellow-500 rounded-s-lg cursor-pointer">
                            <i class="fa-solid fa-pencil me-2"></i>
                            Edit
                        </button>
                        <button type="button"
                            onclick="openDeleteModal('${item.peran_id}')"
                            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-red-500 rounded-e-lg cursor-pointer">
                            <i class="fa-solid fa-trash-can me-2"></i>
                            Hapus
                        </button>
                    </div>
                </td>
            `;
                    tbody.appendChild(row);
                }

            } catch (error) {
                console.error('Fetch error:', error);
            }
        });


        function openEditModal(id) {
            const url = `{{ url('dosen-pembimbing/kelompok-bimbingan') }}/${id}/edit`;
            console.log(url);
            modalAction(url);
        }

        function openDeleteModal(id) {
            const url = `{{ url('dosen-pembimbing/kelompok-bimbingan') }}/${id}/delete`;
            modalAction(url)
        }
    </script>
@endpush
