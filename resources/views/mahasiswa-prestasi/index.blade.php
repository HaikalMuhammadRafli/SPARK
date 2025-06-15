@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-4">Daftar Prestasi Mahasiswa</h1>

        <!-- Menampilkan Data Prestasi Mahasiswa -->
        <div class="bg-white p-4 mb-6 rounded-xl shadow-md">
            <h2 class="text-lg font-semibold mb-4">Prestasi Anda</h2>
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr>
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Prestasi Juara</th>
                        <th class="px-4 py-2">Kelompok</th>
                    </tr>
                </thead>
                <tbody id="prestasi-table-body">
                    <!-- Data Prestasi akan ditampilkan disini menggunakan JavaScript -->
                </tbody>
            </table>
        </div>

        <!-- Form untuk Menambah Prestasi -->
        <div class="bg-white p-4 rounded-xl shadow-md">
            <h2 class="text-lg font-semibold mb-4">Tambah Prestasi</h2>
            <form id="createPrestasiForm">
                @csrf
                <div class="mb-4">
                    <label for="prestasi_juara" class="block">Prestasi Juara</label>
                    <input type="text" id="prestasi_juara" class="form-input mt-1 w-full" placeholder="Masukkan Prestasi Juara" required />
                </div>
                <div class="mb-4">
                    <label for="prestasi_surat_tugas_url" class="block">URL Surat Tugas</label>
                    <input type="url" id="prestasi_surat_tugas_url" class="form-input mt-1 w-full" placeholder="Masukkan URL Surat Tugas" required />
                </div>
                <div class="mb-4">
                    <label for="prestasi_poster_url" class="block">URL Poster</label>
                    <input type="url" id="prestasi_poster_url" class="form-input mt-1 w-full" placeholder="Masukkan URL Poster" required />
                </div>
                <div class="mb-4">
                    <label for="prestasi_foto_juara_url" class="block">URL Foto Juara</label>
                    <input type="url" id="prestasi_foto_juara_url" class="form-input mt-1 w-full" placeholder="Masukkan URL Foto Juara" required />
                </div>
                <div class="mb-4">
                    <label for="prestasi_proposal_url" class="block">URL Proposal</label>
                    <input type="url" id="prestasi_proposal_url" class="form-input mt-1 w-full" placeholder="Masukkan URL Proposal" required />
                </div>
                <div class="mb-4">
                    <label for="prestasi_sertifikat_url" class="block">URL Sertifikat</label>
                    <input type="url" id="prestasi_sertifikat_url" class="form-input mt-1 w-full" placeholder="Masukkan URL Sertifikat" required />
                </div>
                <div class="mb-4">
                    <label for="kelompok_id" class="block">Kelompok</label>
                    <select id="kelompok_id" class="form-input mt-1 w-full" required>
                        <option value="">Pilih Kelompok</option>
                        <!-- Kelompok akan dimuat menggunakan JavaScript -->
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary">Simpan Prestasi</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('js')
    <script>
        // Fungsi untuk mengambil data prestasi mahasiswa
        function loadPrestasi() {
            const token = localStorage.getItem('api_token');
            if (!token) {
                console.error('Token tidak ditemukan');
                return;
            }

            fetch('/api/prestasi/', {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const prestasiList = data.data;
                    const tbody = document.getElementById('prestasi-table-body');
                    tbody.innerHTML = ''; // Clear previous rows

                    prestasiList.forEach((prestasi, index) => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="px-4 py-2">${index + 1}</td>
                            <td class="px-4 py-2">${prestasi.prestasi_juara}</td>
                            <td class="px-4 py-2">${prestasi.kelompok.nama}</td>
                        `;
                        tbody.appendChild(row);
                    });
                }
            })
            .catch(error => console.error('Error fetching data:', error));
        }

        // Fungsi untuk mengisi dropdown kelompok dari API
        function loadKelompok() {
            const token = localStorage.getItem('api_token');
            if (!token) {
                console.error('Token tidak ditemukan');
                return;
            }

            fetch('/api/kelompok/', {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const kelompokList = data.data;
                    const selectKelompok = document.getElementById('kelompok_id');
                    selectKelompok.innerHTML = '<option value="">Pilih Kelompok</option>'; // Clear previous options

                    kelompokList.forEach(kelompok => {
                        const option = document.createElement('option');
                        option.value = kelompok.id;
                        option.textContent = kelompok.nama;
                        selectKelompok.appendChild(option);
                    });
                }
            })
            .catch(error => console.error('Error fetching kelompok data:', error));
        }

        // Fungsi untuk menambah prestasi
        document.getElementById('createPrestasiForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const token = localStorage.getItem('api_token');
            if (!token) {
                console.error('Token tidak ditemukan');
                return;
            }

            const formData = new FormData(event.target);
            const formDataObj = {};
            formData.forEach((value, key) => formDataObj[key] = value);

            fetch('/api/prestasi/', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formDataObj)
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    loadPrestasi(); // Reload data
                    alert('Prestasi berhasil ditambahkan!');
                } else {
                    alert('Gagal menambahkan prestasi');
                }
            })
            .catch(error => console.error('Error:', error));
        });

        // Load data saat halaman pertama kali dimuat
        document.addEventListener('DOMContentLoaded', function () {
            loadPrestasi();
            loadKelompok(); // Untuk mengambil data kelompok
        });
    </script>
@endpush
