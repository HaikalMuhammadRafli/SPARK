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
                    onclick="modalAction('{{ route('admin.manajemen.kelompok.create') }}')" />
            </div>
        </div>
    </section>

    <section class="overflow-x-auto bg-white px-4 py-4 rounded-xl">
        <div class="flex justify-between items-center mb-2">
            <div class="flex gap-2">
                <x-dashboard.filter id="filter-kategori" label="Filter Kategori" placeholder="Pilih Kategori"
                    :options="$kategoris" :searchable="true" searchPlaceholder="Cari kategori..." class="w-42" />
                <x-dashboard.filter id="filter-tingkat" name="filter-tingkat" label="Filter Tingkat"
                    placeholder="Pilih Tingkat" :options="$tingkats" :searchable="true" searchPlaceholder="Cari tingkat..."
                    class="w-42" />
            </div>
            <div class="w-fit">
                <x-search-input id="datatable-search" placeholder="Cari Kelompok..." />
            </div>
        </div>
        <x-data-table :headers="[
            ['title' => 'No', 'key' => 'no', 'sortable' => true],
            ['title' => 'Nama Lomba', 'key' => 'lomba_nama', 'sortable' => true],
            ['title' => 'Kategori Lomba', 'key' => 'lomba_kategori', 'sortable' => true],
            ['title' => 'Tingkat Lomba', 'key' => 'lomba_tingkat', 'sortable' => true],
            ['title' => 'Nama Kelompok', 'key' => 'kelompok_nama', 'sortable' => true],
            ['title' => 'Nama Ketua', 'key' => 'nama_ketua', 'sortable' => true],
            ['title' => 'Nama Dosen Pembimbing', 'key' => 'nama_dpm', 'sortable' => true],
            ['title' => 'Aksi', 'key' => 'actions', 'sortable' => false],
        ]" :data-route="route('admin.manajemen.kelompok.data')" :filters="['filter-kategori', 'filter-tingkat']" :filter-column-map="[
            'filter-kategori' => 2,
            'filter-tingkat' => 3,
        ]">

            @foreach ($kelompoks as $kelompok)
                <tr class="border-b hover:bg-gray-50 text-xs">
                    <td class="px-4 py-1 whitespace-nowrap">{{ $loop->iteration }}</td>
                    <td class="px-4 py-1">{{ $kelompok->lomba->lomba_nama }}</td>
                    <td class="px-4 py-1">{{ $kelompok->lomba->lomba_kategori ?? '' }}</td>
                    <td class="px-4 py-1">{{ $kelompok->lomba->lomba_tingkat ?? '' }}</td>
                    <td class="px-4 py-1">{{ $kelompok->kelompok_nama }}</td>
                    <td class="px-4 py-1">
                        {{ $kelompok->mahasiswa_perans->where('peran_nama', 'Ketua')->first()->mahasiswa->nama }}</td>
                    <td class="px-4 py-1">{{ $kelompok->dosen_pembimbing_peran->dosen_pembimbing->nama }}</td>
                    <td class="px-4 py-1 text-right">
                        <x-buttons.action route_prefix="admin.manajemen.kelompok" id="{{ $kelompok->kelompok_id }}" />
                    </td>
                </tr>
            @endforeach
        </x-data-table>
    </section>

    <x-modal size="4xl" />
@endsection
