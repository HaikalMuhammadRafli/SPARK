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
                <x-buttons.table-actions type="button" title="Tambah Lomba" color="primary"
                    onclick="modalAction('{{ route('admin.manajemen.lomba.create') }}')" />
            </div>
        </div>
    </section>

    <section class="overflow-x-auto bg-white px-4 py-4 rounded-xl">
        <div class="flex justify-end mb-2">
            <div class="w-fit">
                <x-search-input id="datatable-search" placeholder="Cari Data Lomba..." />
            </div>
        </div>
        <x-data-table :headers="[
            ['title' => 'No', 'key' => 'no', 'sortable' => true],
            ['title' => 'Nama Lomba', 'key' => 'nama', 'sortable' => true],
            ['title' => 'Kategori', 'key' => 'kategori', 'sortable' => true],
            ['title' => 'Penyelenggara', 'key' => 'penyelenggara', 'sortable' => true],
            ['title' => 'Tingkat', 'key' => 'tingkat', 'sortable' => true],
            ['title' => 'Lokasi', 'key' => 'lokasi', 'sortable' => true],
            ['title' => 'Mulai Daftar', 'key' => 'mulai_pendaftaran', 'sortable' => true],
            ['title' => 'Akhir Daftar', 'key' => 'akhir_pendaftaran', 'sortable' => true],
            ['title' => 'Status', 'key' => 'status', 'sortable' => true],
            ['title' => 'Aksi', 'key' => 'actions', 'sortable' => false],
        ]" :data-route="route('admin.manajemen.lomba.data')">
            @foreach ($lombas as $lomba)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-1 whitespace-nowrap">{{ $loop->iteration }}</td>
                    <td class="px-4 py-1">{{ $lomba->lomba_nama }}</td>
                    <td class="px-4 py-1">{{ $lomba->lomba_kategori }}</td>
                    <td class="px-4 py-1">{{ $lomba->lomba_penyelenggara }}</td>
                    <td class="px-4 py-1">
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($lomba->lomba_tingkat == 'Internasional') bg-red-100 text-red-800
                            @elseif($lomba->lomba_tingkat == 'Nasional') bg-blue-100 text-blue-800
                            @else bg-green-100 text-green-800 @endif">
                            {{ $lomba->lomba_tingkat }}
                        </span>
                    </td>
                    <td class="px-4 py-1">{{ $lomba->lomba_lokasi_preferensi }}</td>
                    <td class="px-4 py-1">{{ \Carbon\Carbon::parse($lomba->lomba_mulai_pendaftaran)->format('d/m/Y') }}</td>
                    <td class="px-4 py-1">{{ \Carbon\Carbon::parse($lomba->lomba_akhir_pendaftaran)->format('d/m/Y') }}</td>
                    <td class="px-4 py-1">
                        <span class="px-2 py-1 text-xs rounded-full 
                            @if($lomba->lomba_status == 'buka') bg-green-100 text-green-800
                            @elseif($lomba->lomba_status == 'tutup') bg-gray-100 text-gray-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($lomba->lomba_status) }}
                        </span>
                    </td>
                    <td class="px-4 py-1 text-right">
                        <x-buttons.action route_prefix="admin.manajemen.lomba" id="{{ $lomba->lomba_id }}" />
                    </td>
                </tr>
            @endforeach
        </x-data-table>
    </section>

    <x-modal />
@endsection

@push('scripts')
<script>
    function reloadDataTable() {
        // Add your DataTable reload logic here
        location.reload();
    }
</script>
@endpush