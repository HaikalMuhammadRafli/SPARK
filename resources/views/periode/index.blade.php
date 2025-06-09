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
        <x-data-table :headers="[
            ['title' => 'No', 'key' => 'no', 'sortable' => true],
            ['title' => 'Nama Periode', 'key' => 'nama', 'sortable' => true],
            ['title' => 'Tahun Awal', 'key' => 'tahun_awal', 'sortable' => true],
            ['title' => 'Tahun Akhir', 'key' => 'tahun_akhir', 'sortable' => true],
            ['title' => 'Status', 'key' => 'status', 'sortable' => true],
            ['title' => 'Aksi', 'key' => 'actions', 'sortable' => false],
        ]" :data-route="route('admin.master.periode.data')">
            @foreach ($periodes as $periode)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-1 whitespace-nowrap">{{ $loop->iteration }}</td>
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
        </x-data-table>
    </section>

    <x-modal />
@endsection