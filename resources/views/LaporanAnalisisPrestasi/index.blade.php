@extends('layouts.app')

@section('content')
<section class="bg-white flex flex-col md:flex-row md:justify-between md:items-center gap-4 p-4 rounded-xl mb-4">
    <div class="flex flex-col gap-1">
        <h1 class="text-xl font-bold">Data Laporan Prestasi</h1>
        <!-- Menampilkan breadcrumb -->
        <x-breadcrumbs :items="$breadcrumbs" />
    </div>
    <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
        <div class="flex flex-row gap-2 flex-wrap">
            <!-- Tombol Export PDF -->
            <x-buttons.default type="button" title="Export PDF" color="primary"
                onclick="window.location='{{ route('admin.laporan.export.pdf') }}'" />

            <!-- Tombol Export Excel -->
            <x-buttons.default type="button" title="Export Excel" color="primary"
                onclick="window.location='{{ route('admin.laporan.export.excel') }}'" />
        </div>
        <div class="flex flex-row gap-2 flex-wrap">
            <x-buttons.default type="button" title="Import Excel" color="primary" onclick="" />
        </div>
    </div>
</section>

<!-- Grafik Peningkatan/Penurunan Kategori Minat -->
<section class="max-w-full bg-white rounded-lg shadow-lg p-4 md:p-6 mt-4 mb-4">
    <div class="flex justify-between border-gray-200 border-b dark:border-gray-700 pb-3">
        <dl>
            <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Kategori Peminatan</dt>
            <dd class="leading-none text-3xl font-bold text-gray-900 dark:text-white">Peningkatan/Penurunan</dd>
        </dl>
    </div>
    <div id="minat-chart" class="mt-4"></div>
</section>

<!-- Grafik Statistik Kategori Lomba -->
<section class="max-w-full bg-white rounded-lg shadow-lg p-4 md:p-6 mt-4">
    <div class="flex justify-between border-gray-200 border-b dark:border-gray-700 pb-3">
        <dl>
            <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Kategori Lomba</dt>
            <dd class="leading-none text-3xl font-bold text-gray-900 dark:text-white">Statistik Lomba</dd>
        </dl>
    </div>
    <div id="lomba-chart" class="mt-4"></div>
</section>

<!-- Tabel Laporan Prestasi -->
<section class="overflow-x-auto bg-white px-4 py-4 rounded-xl mt-4">
    <x-data-table id="table-body" :headers="[ 
        ['title' => 'No', 'key' => 'no', 'sortable' => true],
        ['title' => 'Nama Kelompok', 'key' => 'kelompok.nama', 'sortable' => false],
        ['title' => 'Juara', 'key' => 'prestasi_juara', 'sortable' => false],
        ['title' => 'Surat Tugas', 'key' => 'prestasi_surat_tugas_url', 'sortable' => false],
        ['title' => 'Status', 'key' => 'prestasi_status', 'sortable' => false],
        ['title' => 'Catatan Prestasi', 'key' => 'prestasi_catatan', 'sortable' => false],
        ['title' => 'Aksi', 'key' => 'actions', 'sortable' => false],
    ]">
        @foreach ($laporans as $index => $laporan)
        <tr class="border-b hover:bg-gray-50">
            <td class="px-4 py-1 whitespace-nowrap">{{ $index + 1 }}</td>
            <td class="px-4 py-1">{{ $laporan->kelompok->nama }}</td>
            <td class="px-4 py-1">{{ $laporan->prestasi_juara }}</td>
            <td class="px-4 py-1"><a href="{{ $laporan->prestasi_surat_tugas_url }}" target="_blank">Lihat Surat
                    Tugas</a></td>
            <td class="px-4 py-1">
                @php
                // Cek apakah prestasi_status ada dan valid
                $status = $laporan->prestasi_status;
                @endphp

                @if ($status == 'Disetujui')
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    <svg class="w-2 h-2 mr-1 fill-current" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3" />
                    </svg>
                    Setujui
                </span>
                @elseif ($status == 'Pending')
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                    <svg class="w-2 h-2 mr-1 fill-current" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3" />
                    </svg>
                    pending
                </span>
                @else
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                    <svg class="w-2 h-2 mr-1 fill-current" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3" />
                    </svg>
                    Status Tidak Valid
                </span>
                @endif
            </td>

            <td class="px-4 py-1">{{ $laporan->prestasi_catatan }}</td>
            <td class="px-4 py-1 text-left">
                <div class="inline-flex rounded-md shadow-xs" role="group">
                    <button type="button" onclick="openEditModal('{{ $laporan->prestasi_id }}')"
                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-yellow-500 rounded-s-lg cursor-pointer">
                        <i class="fa-solid fa-pencil me-2"></i> Edit
                    </button>
                    <button type="button" onclick="openDeleteModal('{{ $laporan->prestasi_id }}')"
                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-red-500 rounded-e-lg cursor-pointer">
                        <i class="fa-solid fa-trash-can me-2"></i> Hapus
                    </button>
                </div>
            </td>
        </tr>
        @endforeach
    </x-data-table>
</section>

<x-modal />

<!-- Script untuk grafik -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    var minatData = @json($minatStats);
    var lombaData = @json($lombaStats);

    // Grafik Kategori Minat
    var minatChart = new ApexCharts(document.querySelector("#minat-chart"), {
        chart: {
            type: 'bar',
            height: 350
        },
        series: [{
            name: 'Jumlah Prestasi',
            data: minatData.map(function (data) { return data.jumlah; })
        }],
        xaxis: {
            categories: minatData.map(function (data) { return data.minat; })
        },
        title: {
            text: 'Peningkatan/Penurunan Kategori Minat',
            align: 'center',
            style: {
                fontSize: '18px',
                fontWeight: 'bold',
                color: '#333'
            }
        }
    });

    // Grafik Statistik Lomba
    var lombaChart = new ApexCharts(document.querySelector("#lomba-chart"), {
        chart: {
            type: 'bar',
            height: 350
        },
        series: [{
            name: 'Jumlah Prestasi',
            data: lombaData.map(function (data) { return data.jumlah; })
        }],
        xaxis: {
            categories: lombaData.map(function (data) { return data.lomba; })
        },
        title: {
            text: 'Statistik Kategori Lomba',
            align: 'center',
            style: {
                fontSize: '18px',
                fontWeight: 'bold',
                color: '#333'
            }
        }
    });

    function openEditModal(id) {
    const token = localStorage.getItem('api_token');
    if (!token) {
        console.error("No API token found in localStorage.");
        return;
    }

    const url = 'http://127.0.0.1:8000/api/laporan/' + id; // URL untuk mendapatkan data laporan

    fetch(url, {
        method: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token,
            'Content-Type': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            const laporan = data.data;

            // Setel nilai status berdasarkan data yang diterima
            document.getElementById('prestasi_status').value = laporan.prestasi_status;

            // Atur aksi form modal untuk memperbarui status (PUT)
            const form = document.getElementById('form');
            form.action = '/api/laporan/' + id;
            form.method = 'PUT';

            // Tampilkan modal menggunakan Bootstrap 5
            var myModal = new bootstrap.Modal(document.getElementById('modal'));
            myModal.show();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Data Tidak Ditemukan',
                text: data.message,
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            text: 'Tidak dapat mengambil data laporan.',
        });
    });
}




    // Fungsi untuk membuka modal hapus
    function openDeleteModal(id) {
        const url = '/api/laporan/' + id;

        // Logika untuk menghapus data jika diperlukan (dengan confirmation)
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data ini akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
        }).then((result) => {
            if (result.isConfirmed) {
                // Mengirim permintaan DELETE untuk menghapus laporan
                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + localStorage.getItem('api_token'),
                        'Accept': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        Swal.fire(
                            'Dihapus!',
                            'Data laporan telah dihapus.',
                            'success'
                        );
                        // Reload data tabel atau update tampilan lainnya
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Dihapus',
                            text: data.message,
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: 'Tidak dapat menghapus data laporan.',
                    });
                });
            }
        });
    }

    // Render charts
    minatChart.render();
    lombaChart.render();
</script>

@endsection