@extends('layouts.app')

@section('content')
    <section class="bg-white flex flex-col md:flex-row md:justify-between md:items-center gap-4 p-4 rounded-xl mb-2">
        <div class="flex flex-col gap-1">
            <h1 class="text-xl font-bold">{{ $title }}</h1>
            <x-breadcrumbs :items="$breadcrumbs" />
        </div>
        <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
            <div class="flex flex-row gap-2 flex-wrap">
                <x-buttons.table-actions type="button" title="Export PDF" color="primary" :onclick="'window.location.href=\'' . route('admin.manajemen-pengguna.mahasiswa.export-pdf') . '\''" />
                <x-buttons.table-actions type="button" title="Export Excel" color="primary" onclick="" />
            </div>
            <div class="flex flex-row gap-2 flex-wrap">
                <x-buttons.table-actions type="button" title="Import Excel" color="primary" onclick="" />
                <x-buttons.table-actions type="button" title="Tambah Baru" color="primary"
                    onclick="modalAction('{{ route('admin.manajemen-pengguna.mahasiswa.create') }}')" />
            </div>
        </div>
    </section>

    <section class="overflow-x-auto bg-white px-4 py-4 rounded-xl">
        <div class="flex justify-end mb-2">
            <div class="w-fit">
                <x-search-input id="datatable-search" placeholder="Cari Bidang Keahlian..." />
            </div>
        </div>

        {{-- x-data-table with manually populated tbody --}}
        <x-data-table id="table-body" :headers="[
            ['title' => 'No', 'key' => 'no', 'sortable' => true],
            ['title' => 'NIM', 'key' => 'nim', 'sortable' => false],
            ['title' => 'Nama', 'key' => 'nama', 'sortable' => false],
            ['title' => 'Lokasi Preferensi', 'key' => 'lokasi_preferensi', 'sortable' => false],
            ['title' => 'User ID', 'key' => 'user_id', 'sortable' => false],
            ['title' => 'Prodi ID', 'key' => 'prodi_id', 'sortable' => false],
            ['title' => 'Aksi', 'key' => 'actions', 'sortable' => false],
        ]">

        </x-data-table>
    </section>

    <x-modal />
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('api_token');
            if (!token) {
                console.error("No API token found in localStorage.");
                return;
            }

            const route = 'http://127.0.0.1:8000/api/mahasiswa';

            fetch(route, {
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('#table tbody'); // Selects the component's tbody

                    if (!tbody) {
                        console.error('tbody not found inside #table');
                        return;
                    }

                    tbody.innerHTML = ''; // Clear any existing content (optional)

                    data.data.forEach((item, index) => {
                        const row = document.createElement('tr');
                        row.className = 'border-b hover:bg-gray-50';
                        row.innerHTML = `
<td class="px-4 py-1 whitespace-nowrap">${index + 1}</td>
<td class="px-4 py-1">${item.nim}</td>
<td class="px-4 py-1">${item.nama}</td>
<td class="px-4 py-1">${item.lokasi_preferensi}</td>
<td class="px-4 py-1">${item.user_id}</td>
<td class="px-4 py-1">${item.program_studi_id}</td>
<td class="px-4 py-1 text-left">
    <div class="inline-flex rounded-md shadow-xs" role="group">
        <button type="button"
            onclick="openEditModal('${item.nim}')"
            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-yellow-500 rounded-s-lg cursor-pointer">
            <i class="fa-solid fa-pencil me-2"></i>
            Edit
        </button>
        <button type="button"
            onclick="openDeleteModal('${item.nim}')"
            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-red-500 rounded-e-lg cursor-pointer">
            <i class="fa-solid fa-trash-can me-2"></i>
            Hapus
        </button>
    </div>
</td>
`;
                        tbody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                });
        });

        function openEditModal(id) {
            const url = `{{ url('admin/manajemen-pengguna/mahasiswa') }}/${id}/edit`;
            modalAction(url);
        }

        function openDeleteModal(id) {
            const url = `{{ url('admin/manajemen-pengguna/mahasiswa') }}/${id}/delete`;
            modalAction(url)
        }
    </script>
@endpush
