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
                <x-dashboard.filter id="filter-juara" label="Filter Juara" placeholder="Pilih Juara" :options="$juaras"
                    :searchable="true" searchPlaceholder="Cari juara..." class="w-42" />
                <x-dashboard.filter id="filter-kategori" label="Filter Kategori" placeholder="Pilih Kategori"
                    :options="$kategoris" :searchable="true" searchPlaceholder="Cari kategori..." class="w-42" />
                <x-dashboard.filter id="filter-tingkat" name="filter-tingkat" label="Filter Tingkat"
                    placeholder="Pilih Tingkat" :options="$tingkats" :searchable="true" searchPlaceholder="Cari tingkat..."
                    class="w-42" />
            </div>
            <div class="w-fit">
                <x-search-input id="datatable-search" placeholder="Cari Prestasi..." />
            </div>
        </div>
        <x-data-table :headers="[
            ['title' => 'No', 'key' => 'no', 'sortable' => true],
            ['title' => 'Nama Kelompok', 'key' => 'kelompok_nama', 'sortable' => true],
            ['title' => 'Juara', 'key' => 'prestasi_juara', 'sortable' => true],
            ['title' => 'Tingkat', 'key' => 'prestasi_tingkat', 'sortable' => true],
            ['title' => 'Nama Lomba', 'key' => 'lomba_nama', 'sortable' => true],
            ['title' => 'Kategori Lomba', 'key' => 'lomba_kategori', 'sortable' => true],
            ['title' => 'Penyelenggara Lomba', 'key' => 'lomba_penyelenggara', 'sortable' => true],
            ['title' => 'Nama Ketua', 'key' => 'nama_ketua', 'sortable' => true],
            ['title' => 'Nama Dosen Pembimbing', 'key' => 'nama_dpm', 'sortable' => true],
            ['title' => 'Status Prestasi', 'key' => 'prestasi_status', 'sortable' => true],
            ['title' => 'Tanggal Dibuat', 'key' => 'created_at', 'sortable' => true],
            ['title' => 'Tanggal Diubah', 'key' => 'updated_at', 'sortable' => true],
            ['title' => 'Aksi', 'key' => 'actions', 'sortable' => false],
        ]" :data-route="route('admin.manajemen.prestasi.verification.data')" :filters="['filter-juara', 'filter-kategori', 'filter-tingkat']" :filter-column-map="[
            'filter-juara' => 2,
            'filter-kategori' => 5,
            'filter-tingkat' => 3,
        ]">

            @foreach ($prestasis as $prestasi)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-1 whitespace-nowrap">{{ $loop->iteration }}</td>
                    <td class="px-4 py-1">{{ $prestasi->kelompok->kelompok_nama }}</td>
                    <td class="px-4 py-1">{{ $prestasi->prestasi_juara }}</td>
                    <td class="px-4 py-1">{{ $prestasi->kelompok->lomba->lomba_tingkat }}</td>
                    <td class="px-4 py-1">{{ $prestasi->kelompok->lomba->lomba_nama }}</td>
                    <td class="px-4 py-1">{{ $prestasi->kelompok->lomba->lomba_kategori }}</td>
                    <td class="px-4 py-1">{{ $prestasi->kelompok->lomba->lomba_penyelenggara }}</td>
                    <td class="px-4 py-1">
                        {{ $prestasi->kelompok->mahasiswa_perans->where('peran_nama', 'Ketua')->first()->mahasiswa->nama }}
                    </td>
                    <td class="px-4 py-1">{{ $prestasi->kelompok->dosen_pembimbing_peran->dosen_pembimbing->nama }}</td>
                    <td class="px-4 py-1">{{ $prestasi->prestasi_status }}</td>
                    <td class="px-4 py-1">{{ $prestasi->created_at }}</td>
                    <td class="px-4 py-1">{{ $prestasi->updated_at }}</td>
                    <td class="px-4 py-1 text-right">
                        <x-buttons.default type="button" title="Verify" color="primary" icon="fa-solid fa-file-circle-check"
                            onclick="modalAction('{{ route('admin.manajemen.prestasi.verification.detail', $prestasi->prestasi_id) }}')" />
                    </td>
                </tr>
            @endforeach
        </x-data-table>
    </section>

    <x-modal size="4xl" />
@endsection
