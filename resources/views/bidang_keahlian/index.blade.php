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
                    onclick="modalAction('{{ route('admin.master.bidang-keahlian.create') }}')" />
            </div>
        </div>
    </section>

    <section class="overflow-x-auto bg-white px-4 py-4 rounded-xl">
        <div class="flex justify-end mb-2">
            <div class="w-fit">
                <x-search-input id="datatable-search" placeholder="Cari Bidang Keahlian..." />
            </div>
        </div>
        <x-data-table :headers="[
            ['title' => 'No', 'key' => 'no', 'sortable' => true],
            ['title' => 'ID', 'key' => 'id', 'sortable' => true],
            ['title' => 'Nama Bidang Keahlian', 'key' => 'nama', 'sortable' => true],
            ['title' => 'Aksi', 'key' => 'actions', 'sortable' => false],
        ]" :data-route="route('admin.master.bidang-keahlian.data')">
            @foreach ($bidang_keahlians as $bidang_keahlian)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-1 whitespace-nowrap">{{ $loop->iteration }}</td>
                    <td class="px-4 py-1">{{ $bidang_keahlian->bidang_keahlian_id }}</td>
                    <td class="px-4 py-1">{{ $bidang_keahlian->bidang_keahlian_nama }}</td>
                    <td class="px-4 py-1 text-right">
                        <x-buttons.action route_prefix="admin.master.bidang-keahlian"
                            id="{{ $bidang_keahlian->bidang_keahlian_id }}" />
                    </td>
                </tr>
            @endforeach
        </x-data-table>
    </section>

    <x-modal />
@endsection
