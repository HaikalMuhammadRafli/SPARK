@extends('layouts.app')

@section('content')
    <section class="bg-white flex flex-col md:flex-row md:justify-start md:items-center gap-4 p-4 rounded-xl mb-2">
        <div class="flex flex-col gap-1">
            <h1 class="text-xl font-bold">{{ $title }}</h1>
            <x-breadcrumbs :items="$breadcrumbs" />
        </div>
    </section>

    <section class="overflow-x-auto bg-white px-4 py-4 rounded-xl">
        <div class="flex justify-between items-center mb-2">
            <div class="flex gap-2">
                <x-dashboard.filter id="filter-kategori" label="Filter Kategori" placeholder="Pilih Kategori"
                    :options="$kategoris ?? []" :searchable="true" searchPlaceholder="Cari kategori..." class="w-42" />
                <x-dashboard.filter id="filter-tingkat" name="filter-tingkat" label="Filter Tingkat"
                    placeholder="Pilih Tingkat" :options="$tingkats ?? []" :searchable="true" searchPlaceholder="Cari tingkat..."
                    class="w-42" />
                <x-dashboard.filter id="filter-status" name="filter-status" label="Filter Status"
                    placeholder="Pilih Status" :options="$status_options ?? []" :searchable="true" searchPlaceholder="Cari status..."
                    class="w-42" />
            </div>
            <div class="w-fit">
                <x-search-input id="datatable-search" placeholder="Cari Lomba..." />
            </div>
        </div>
        <x-data-table :headers="[
            ['title' => 'No', 'key' => 'no', 'sortable' => true],
            ['title' => 'Nama Lomba', 'key' => 'lomba_nama', 'sortable' => true],
            ['title' => 'Kategori', 'key' => 'lomba_kategori', 'sortable' => true],
            ['title' => 'Tingkat', 'key' => 'lomba_tingkat', 'sortable' => true],
            ['title' => 'Penyelenggara', 'key' => 'lomba_penyelenggara', 'sortable' => true],
            ['title' => 'Periode', 'key' => 'periode_nama', 'sortable' => true],
            ['title' => 'Status', 'key' => 'lomba_status', 'sortable' => true],
            ['title' => 'Tanggal Dibuat', 'key' => 'created_at', 'sortable' => true],
            ['title' => 'Aksi', 'key' => 'actions', 'sortable' => false],
        ]"
        :data-route="route('admin.manajemen.lomba.verification.data')"
        :filters="['filter-kategori', 'filter-tingkat', 'filter-status']"
        :filter-column-map="[
            'filter-kategori' => 2,
            'filter-tingkat' => 3,
            'filter-status' => 6
        ]">
        </x-data-table>
    </section>

    <x-modal size="4xl" />
@endsection