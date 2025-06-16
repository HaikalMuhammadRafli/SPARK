@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-semibold mb-4">Daftar Prestasi Mahasiswa</h1>

        <!-- Menampilkan Data Prestasi Mahasiswa -->
        <div class="bg-white p-4 mb-6 rounded-xl shadow-md">
            <h2 class="text-lg font-semibold mb-4">Prestasi Anda</h2>
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 border border-gray-300 text-left">No</th>
                            <th class="px-4 py-2 border border-gray-300 text-left">Prestasi Juara</th>
                            <th class="px-4 py-2 border border-gray-300 text-left">Kelompok</th>
                            <th class="px-4 py-2 border border-gray-300 text-left">Status</th>
                            <th class="px-4 py-2 border border-gray-300 text-left">Catatan</th>
                        </tr>
                    </thead>
                    <tbody id="prestasi-table-body">
                        <!-- Data Prestasi akan ditampilkan disini menggunakan JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Form untuk Menambah Prestasi -->
        <div class="bg-white p-4 rounded-xl shadow-md">
            <h2 class="text-lg font-semibold mb-4">Tambah Prestasi</h2>
            <form id="createPrestasiForm">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="prestasi_juara" class="block text-sm font-medium text-gray-700 mb-1">Prestasi Juara</label>
                        <input type="text" id="prestasi_juara" name="prestasi_juara" class="form-input mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan Prestasi Juara" required />
                    </div>
                    <div>
                        <label for="kelompok_id" class="block text-sm font-medium text-gray-700 mb-1">Kelompok</label>
                        <select id="kelompok_id" name="kelompok_id" class="form-input mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">Pilih Kelompok</option>
                            <!-- Kelompok akan dimuat menggunakan JavaScript -->
                        </select>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="prestasi_surat_tugas_url" class="block text-sm font-medium text-gray-700 mb-1">URL Surat Tugas</label>
                        <input type="url" id="prestasi_surat_tugas_url" name="prestasi_surat_tugas_url" class="form-input mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan URL Surat Tugas" required />
                    </div>
                    <div>
                        <label for="prestasi_poster_url" class="block text-sm font-medium text-gray-700 mb-1">URL Poster</label>
                        <input type="url" id="prestasi_poster_url" name="prestasi_poster_url" class="form-input mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan URL Poster" required />
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="prestasi_foto_juara_url" class="block text-sm font-medium text-gray-700 mb-1">URL Foto Juara</label>
                        <input type="url" id="prestasi_foto_juara_url" name="prestasi_foto_juara_url" class="form-input mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan URL Foto Juara" required />
                    </div>
                    <div>
                        <label for="prestasi_proposal_url" class="block text-sm font-medium text-gray-700 mb-1">URL Proposal</label>
                        <input type="url" id="prestasi_proposal_url" name="prestasi_proposal_url" class="form-input mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan URL Proposal" required />
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="prestasi_sertifikat_url" class="block text-sm font-medium text-gray-700 mb-1">URL Sertifikat</label>
                    <input type="url" id="prestasi_sertifikat_url" name="prestasi_sertifikat_url" class="form-input mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan URL Sertifikat" required />
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition duration-200">
                        Simpan Prestasi
                    </button>
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
                alert('Token tidak ditemukan. Silakan login kembali.');
                return;
            }

            fetch('/api/prestasi/', {
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json',
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    const prestasiList = data.data;
                    const tbody = document.getElementById('prestasi-table-body');
                    tbody.innerHTML = ''; // Clear previous rows

                    if (prestasiList.length === 0) {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500 border border-gray-300">
                                Belum ada data prestasi
                            </td>
                        `;
                        tbody.appendChild(row);
                    } else {
                        prestasiList.forEach((prestasi, index) => {
                            const statusClass = prestasi.prestasi_status === 'Disetujui' ? 'text-green-600 font-semibold' : 
                                              prestasi.prestasi_status === 'Ditolak' ? 'text-red-600 font-semibold' : 
                                              'text-yellow-600 font-semibold';
                            
                            const row = document.createElement('tr');
                            row.innerHTML = `
                                <td class="px-4 py-2 border border-gray-300">${index + 1}</td>
                                <td class="px-4 py-2 border border-gray-300">${prestasi.prestasi_juara}</td>
                                <td class="px-4 py-2 border border-gray-300">${prestasi.kelompok ? prestasi.kelompok.kelompok_nama : 'Tidak Ada Kelompok'}</td>
                                <td class="px-4 py-2 border border-gray-300">
                                    <span class="${statusClass}">${prestasi.prestasi_status || 'Menunggu'}</span>
                                </td>
                                <td class="px-4 py-2 border border-gray-300">${prestasi.prestasi_catatan || '-'}</td>
                            `;
                            tbody.appendChild(row);
                        });
                    }
                } else {
                    console.error('Error in response:', data);
                    alert('Gagal memuat data prestasi');
                }
            })
            .catch(error => {
                console.error('Error fetching prestasi data:', error);
                alert('Terjadi kesalahan saat memuat data prestasi');
            });
        }

        // Fungsi untuk mengisi dropdown kelompok dari API (hanya kelompok yang pernah diikuti)
        function loadKelompok() {
            const token = localStorage.getItem('api_token');
            if (!token) {
                console.error('Token tidak ditemukan');
                return;
            }

            // Coba menggunakan endpoint khusus untuk kelompok yang diikuti user
            // Jika tidak ada, fallback ke endpoint umum dengan filter
            const endpoints = [
                '/api/kelompok/my-groups',  // Endpoint khusus untuk kelompok user
                '/api/user/kelompok',       // Alternative endpoint
                '/api/kelompok/joined',     // Alternative endpoint
                '/api/kelompok/?joined=true' // Endpoint dengan parameter
            ];

            // Fungsi untuk mencoba endpoint secara berurutan
            function tryEndpoint(index = 0) {
                if (index >= endpoints.length) {
                    // Jika semua endpoint khusus gagal, gunakan cara alternatif
                    loadKelompokFromPrestasi();
                    return;
                }

                fetch(endpoints[index], {
                    method: 'GET',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json',
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Endpoint not available');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success' && data.data && data.data.length > 0) {
                        populateKelompokDropdown(data.data);
                    } else {
                        throw new Error('No data or empty response');
                    }
                })
                .catch(error => {
                    console.log(`Endpoint ${endpoints[index]} failed, trying next...`);
                    tryEndpoint(index + 1);
                });
            }

            tryEndpoint();
        }

        // Fungsi alternatif: mengambil kelompok dari data prestasi yang sudah ada
        function loadKelompokFromPrestasi() {
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
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    // Ekstrak kelompok unik dari data prestasi
                    const uniqueKelompok = [];
                    const kelompokIds = new Set();

                    data.data.forEach(prestasi => {
                        if (prestasi.kelompok && !kelompokIds.has(prestasi.kelompok.kelompok_id)) {
                            kelompokIds.add(prestasi.kelompok.kelompok_id);
                            uniqueKelompok.push(prestasi.kelompok);
                        }
                    });

                    if (uniqueKelompok.length > 0) {
                        populateKelompokDropdown(uniqueKelompok);
                    } else {
                        // Jika tidak ada prestasi, coba ambil semua kelompok sebagai fallback
                        loadAllKelompokAsFallback();
                    }
                } else {
                    console.error('Error in prestasi response:', data);
                    loadAllKelompokAsFallback();
                }
            })
            .catch(error => {
                console.error('Error fetching prestasi data for kelompok:', error);
                loadAllKelompokAsFallback();
            });
        }

        // Fungsi fallback untuk memuat semua kelompok jika metode lain gagal
        function loadAllKelompokAsFallback() {
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
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    populateKelompokDropdown(data.data);
                    console.warn('Menampilkan semua kelompok karena tidak bisa mendapatkan kelompok yang diikuti');
                } else {
                    console.error('Error in kelompok response:', data);
                    showKelompokError();
                }
            })
            .catch(error => {
                console.error('Error fetching all kelompok data:', error);
                showKelompokError();
            });
        }

        // Fungsi untuk mengisi dropdown dengan data kelompok
        function populateKelompokDropdown(kelompokList) {
            const selectKelompok = document.getElementById('kelompok_id');
            selectKelompok.innerHTML = '<option value="">Pilih Kelompok</option>'; // Clear previous options

            if (kelompokList.length === 0) {
                const option = document.createElement('option');
                option.value = '';
                option.textContent = 'Tidak ada kelompok yang tersedia';
                option.disabled = true;
                selectKelompok.appendChild(option);
                return;
            }

            kelompokList.forEach(kelompok => {
                const option = document.createElement('option');
                option.value = kelompok.kelompok_id || kelompok.id;
                option.textContent = kelompok.kelompok_nama || kelompok.nama;
                selectKelompok.appendChild(option);
            });
        }

        // Fungsi untuk menampilkan error pada dropdown kelompok
        function showKelompokError() {
            const selectKelompok = document.getElementById('kelompok_id');
            selectKelompok.innerHTML = '<option value="">Error memuat kelompok</option>';
            selectKelompok.disabled = true;
            alert('Terjadi kesalahan saat memuat data kelompok. Silakan refresh halaman.');
        }

        // Fungsi untuk menambah prestasi
        document.getElementById('createPrestasiForm').addEventListener('submit', function (event) {
            event.preventDefault();

            const token = localStorage.getItem('api_token');
            if (!token) {
                console.error('Token tidak ditemukan');
                alert('Token tidak ditemukan. Silakan login kembali.');
                return;
            }

            // Mengambil data dari form menggunakan FormData
            const formData = new FormData(event.target);
            const formDataObj = {};
            
            // Konversi FormData ke object
            for (let [key, value] of formData.entries()) {
                formDataObj[key] = value;
            }

            // Validasi form
            if (!formDataObj.prestasi_juara || !formDataObj.kelompok_id) {
                alert('Mohon lengkapi semua field yang wajib diisi');
                return;
            }

            // Tampilkan loading state
            const submitButton = event.target.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;
            submitButton.textContent = 'Menyimpan...';
            submitButton.disabled = true;

            fetch('/api/prestasi/', {
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formDataObj)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    loadPrestasi(); // Reload data
                    event.target.reset(); // Reset form
                    alert('Prestasi berhasil ditambahkan!');
                } else {
                    console.error('Error in response:', data);
                    alert('Gagal menambahkan prestasi: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menambahkan prestasi');
            })
            .finally(() => {
                // Reset button state
                submitButton.textContent = originalText;
                submitButton.disabled = false;
            });
        });

        // Load data saat halaman pertama kali dimuat
        document.addEventListener('DOMContentLoaded', function () {
            loadPrestasi();
            loadKelompok(); // Untuk mengambil data kelompok
        });
    </script>
@endpush