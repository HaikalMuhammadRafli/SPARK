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
    $status = $laporan->prestasi_status;
    @endphp

    @if ($status == 'Disetujui')
    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
        <svg class="w-2 h-2 mr-1 fill-current" viewBox="0 0 8 8">
            <circle cx="4" cy="4" r="3" />
        </svg>
        Disetujui
    </span>
    @elseif ($status == 'Pending')
    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
        <svg class="w-2 h-2 mr-1 fill-current" viewBox="0 0 8 8">
            <circle cx="4" cy="4" r="3" />
        </svg>
        Pending
    </span>
    @elseif ($status == 'Ditolak')
    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
        <svg class="w-2 h-2 mr-1 fill-current" viewBox="0 0 8 8">
            <circle cx="4" cy="4" r="3" />
        </svg>
        Ditolak
    </span>
    @else
    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
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
<script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>

<script>
    // Pastikan ApexCharts sudah loaded sebelum menjalankan script
    document.addEventListener('DOMContentLoaded', function() {
        // Cek apakah data tersedia dan valid
        var minatData = @json($minatStats ?? []);
        var lombaData = @json($lombaStats ?? []);

        // Inisialisasi grafik hanya jika ApexCharts tersedia dan data ada
        if (typeof ApexCharts !== 'undefined') {
            // Grafik Kategori Minat
            if (minatData && minatData.length > 0) {
                var minatChart = new ApexCharts(document.querySelector("#minat-chart"), {
                    chart: {
                        type: 'bar',
                        height: 350,
                        toolbar: {
                            show: false
                        }
                    },
                    series: [{
                        name: 'Jumlah Prestasi',
                        data: minatData.map(function(data) { 
                            return data.jumlah ? parseInt(data.jumlah) : 0; 
                        })
                    }],
                    xaxis: {
                        categories: minatData.map(function(data) { 
                            return data.minat || 'Tidak Diketahui'; 
                        })
                    },
                    title: {
                        text: 'Peningkatan/Penurunan Kategori Minat',
                        align: 'center',
                        style: {
                            fontSize: '18px',
                            fontWeight: 'bold',
                            color: '#333'
                        }
                    },
                    colors: ['#3B82F6'],
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            horizontal: false,
                        }
                    }
                });
                minatChart.render();
            } else {
                document.querySelector("#minat-chart").innerHTML = '<p class="text-center text-gray-500">Tidak ada data kategori minat</p>';
            }

            // Grafik Statistik Lomba
            if (lombaData && lombaData.length > 0) {
                var lombaChart = new ApexCharts(document.querySelector("#lomba-chart"), {
                    chart: {
                        type: 'bar',
                        height: 350,
                        toolbar: {
                            show: false
                        }
                    },
                    series: [{
                        name: 'Jumlah Prestasi',
                        data: lombaData.map(function(data) { 
                            return data.jumlah ? parseInt(data.jumlah) : 0; 
                        })
                    }],
                    xaxis: {
                        categories: lombaData.map(function(data) { 
                            return data.lomba || 'Tidak Diketahui'; 
                        })
                    },
                    title: {
                        text: 'Statistik Kategori Lomba',
                        align: 'center',
                        style: {
                            fontSize: '18px',
                            fontWeight: 'bold',
                            color: '#333'
                        }
                    },
                    colors: ['#10B981'],
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            horizontal: false,
                        }
                    }
                });
                lombaChart.render();
            } else {
                document.querySelector("#lomba-chart").innerHTML = '<p class="text-center text-gray-500">Tidak ada data kategori lomba</p>';
            }
        } else {
            console.error('ApexCharts tidak tersedia');
            document.querySelector("#minat-chart").innerHTML = '<p class="text-center text-red-500">Error: ApexCharts tidak dapat dimuat</p>';
            document.querySelector("#lomba-chart").innerHTML = '<p class="text-center text-red-500">Error: ApexCharts tidak dapat dimuat</p>';
        }
    });

    // Fungsi untuk membuka modal edit
    function openEditModal(id) {
        const token = localStorage.getItem('api_token');
        if (!token) {
            console.error("No API token found in localStorage.");
            Swal.fire({
                icon: 'error',
                title: 'Token Hilang',
                text: 'Token tidak ditemukan di localStorage.'
            });
            return;
        }

        // Cek apakah elemen modal dan form ada
        const modalElement = document.getElementById('modal');
        const formElement = document.getElementById('Form');
        
        if (!modalElement) {
            console.error('Modal element tidak ditemukan');
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Modal tidak ditemukan. Pastikan modal sudah dibuat dengan ID "modal".'
            });
            return;
        }

        if (!formElement) {
            console.error('Form element tidak ditemukan');
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Form tidak ditemukan. Pastikan form sudah dibuat dengan ID "form".'
            });
            return;
        }

        const url = 'http://127.0.0.1:8000/api/laporan/' + id;

        // Tampilkan loading
        Swal.fire({
            title: 'Memuat data...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        fetch(url, {
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            Swal.close(); // Tutup loading

            if (data.status || data.success) {
                const laporan = data.data;

                // Reset form terlebih dahulu
                formElement.reset();
                
                // Clear error states
                const errorElements = formElement.querySelectorAll('.is-invalid');
                errorElements.forEach(el => el.classList.remove('is-invalid'));
                
                const errorTexts = formElement.querySelectorAll('.text-red-500');
                errorTexts.forEach(el => el.textContent = '');

                // Set nilai status
                const statusSelect = document.getElementById('prestasi_status');
                if (statusSelect && laporan.prestasi_status) {
                    statusSelect.value = laporan.prestasi_status;
                    
                    // Trigger change event untuk show/hide catatan section
                    statusSelect.dispatchEvent(new Event('change'));
                }

                // Set catatan jika ada
                const catatanTextarea = document.getElementById('prestasi_catatan');
                if (catatanTextarea && laporan.prestasi_catatan) {
                    catatanTextarea.value = laporan.prestasi_catatan;
                }

                // Set form action dan method
                formElement.setAttribute('action', 'http://127.0.0.1:8000/api/laporan/' + id);
                
                // Set method field untuk PUT
                const methodField = document.getElementById('method_field');
                if (methodField) {
                    methodField.value = 'PUT';
                }

                // Tampilkan modal
                if (typeof bootstrap !== 'undefined') {
                    const modal = new bootstrap.Modal(modalElement);
                    modal.show();
                } else {
                    console.error('Bootstrap tidak ditemukan');
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Bootstrap tidak ditemukan. Pastikan Bootstrap sudah dimuat.'
                    });
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Data Tidak Ditemukan',
                    text: data.message || 'Data laporan tidak ditemukan',
                });
            }
        })
        .catch(error => {
            Swal.close(); // Tutup loading
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: 'Tidak dapat mengambil data laporan. ' + error.message,
            });
        });
    }

    // Fungsi untuk membuka modal hapus
    function openDeleteModal(id) {
        const url = 'http://127.0.0.1:8000/api/laporan/' + id;

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data ini akan dihapus permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const token = localStorage.getItem('api_token');
                if (!token) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Token Hilang',
                        text: 'Token tidak ditemukan di localStorage.'
                    });
                    return;
                }

                // Tampilkan loading
                Swal.fire({
                    title: 'Menghapus data...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status || data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data laporan telah dihapus.',
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Dihapus',
                            text: data.message || 'Terjadi kesalahan saat menghapus data',
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
</script>

@endsection