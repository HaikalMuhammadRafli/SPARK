<form id="spk-form-element" method="POST" action="{{ $action }}" class="space-y-4">
    @csrf

    @if (in_array(strtoupper($method), ['PUT']))
        @method($method)
    @endif

    <div>
        <h3 class="text-md font-semibold">Kriteria Decision Maker</h3>
        <p class="text-xs text-gray-500 mb-3">Pilih kriteria yang dibutuhkan!</p>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
            <x-forms.select name="lokasi_preferensi_spk" :options="$lokasi_preferensis" placeholder="Lokasi Preferensi" required />
            <x-forms.checkbox-dropdown name="minat_spk[]" title="Minat" :options="$minats->pluck('minat_nama', 'minat_id')->toArray()" searchable required />
            <x-forms.checkbox-dropdown name="bidang_keahlian_spk[]" title="Bidang Keahlian" :options="$bidang_keahlians->pluck('bidang_keahlian_nama', 'bidang_keahlian_id')->toArray()" searchable
                required />
            <x-forms.checkbox-dropdown name="kompetensi_spk[]" title="Kompetensi" :options="$kompetensis->pluck('kompetensi_nama', 'kompetensi_id')->toArray()" searchable
                required />
        </div>
    </div>

    <div>
        <h3 class="text-md font-semibold">Prioritas Bobot</h3>
        <p class="text-xs text-gray-500 mb-3">( 1 = Tertinggi, 6 = Terendah )</p>
        <div class="grid grid-cols-2 lg:grid-cols-6 gap-3">
            <x-forms.select name="bobot_lokasi_preferensi_spk" label="Lokasi Preferensi" :options="$weight_ranks"
                selected="6" required />
            <x-forms.select name="bobot_minat_spk" label="Minat" :options="$weight_ranks" selected="5" required />
            <x-forms.select name="bobot_bidang_keahlian_spk" label="Bidang Keahlian" :options="$weight_ranks" selected="4"
                required />
            <x-forms.select name="bobot_kompetensi_spk" label="Kompetensi" :options="$weight_ranks" selected="3" required />
            <x-forms.select name="bobot_jumlah_lomba_spk" label="Jumlah Lomba" :options="$weight_ranks" selected="2"
                required />
            <x-forms.select name="bobot_jumlah_prestasi_spk" label="Jumlah Prestasi" :options="$weight_ranks" selected="1"
                required />
        </div>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-3 pt-4 border-t">
        <div class="w-full sm:w-auto">
            <x-forms.select name="jumlah_rekomendasi" :options="$jumlah_rekomendasis" placeholder="Jumlah Rekomendasi" required />
        </div>
        <div class="flex gap-2">
            <button type="button" onclick="submitSPK(false)" id="weighted-btn"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition-colors">
                <i class="fa-solid fa-chart-line me-1"></i>
                Weighted MOORA
            </button>
            <button type="button" onclick="submitSPK(true)" id="entropy-btn"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 transition-colors">
                <i class="fa-solid fa-calculator me-1"></i>
                Entropy MOORA
            </button>
        </div>
    </div>
</form>

<!-- Results Section -->
<div id="spk-results" class="hidden mt-6 space-y-6">
    <!-- Quick Summary -->
    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
        <h4 class="text-lg font-semibold text-green-800 mb-2">
            <i class="fa-solid fa-trophy me-2"></i>Rekomendasi Teratas
        </h4>
        <div id="quick-summary" class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <!-- Will be populated via JavaScript -->
        </div>
    </div>

    <!-- Bobot Table -->
    <div>
        <h4 class="text-md font-semibold mb-2">Bobot Kriteria</h4>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-xs text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th class="px-3 py-2">Lokasi Preferensi</th>
                        <th class="px-3 py-2">Minat</th>
                        <th class="px-3 py-2">Bidang Keahlian</th>
                        <th class="px-3 py-2">Kompetensi</th>
                        <th class="px-3 py-2">Jumlah Lomba</th>
                        <th class="px-3 py-2">Jumlah Prestasi</th>
                    </tr>
                </thead>
                <tbody id="bobot-table-body">
                    <!-- Will be populated via JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recommendation Table -->
    <div>
        <h4 class="text-md font-semibold mb-2">Rekomendasi Mahasiswa</h4>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg max-h-64">
            <table class="w-full text-xs text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 sticky top-0">
                    <tr>
                        <th class="px-3 py-2">Rank</th>
                        <th class="px-3 py-2">Nama</th>
                        <th class="px-3 py-2">NIM</th>
                        <th class="px-3 py-2">Skor</th>
                        <th class="px-3 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody id="spk-table-body">
                    <!-- Will be populated via JavaScript -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function submitSPK(useEntropy) {
        console.log('submitSPK called with entropy:', useEntropy);

        const form = $('#spk-form-element');
        if (form.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Form tidak ditemukan!'
            });
            return;
        }

        // Validate form before submission
        if (!validateSPKForm()) {
            return;
        }

        const formData = new FormData(form[0]);
        formData.append('entropy', useEntropy ? '1' : '0');

        // Show loading
        Swal.fire({
            title: 'Memproses SPK...',
            text: 'Sedang melakukan perhitungan, mohon tunggu',
            icon: 'info',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Show loading state on buttons
        setButtonsState(true);

        // AJAX Request
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            timeout: 60000,
            success: function(response) {
                console.log('AJAX success response:', response);

                if (response.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message || 'SPK berhasil diproses',
                        showConfirmButton: true,
                        timer: 3000
                    });

                    // Display results
                    displaySPKResults(response.data, response.matrices, response.method, useEntropy);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message || 'Terjadi kesalahan saat memproses SPK'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', {
                    xhr,
                    status,
                    error
                });

                let errorMessage = 'Terjadi kesalahan saat memproses SPK';

                if (xhr.status === 422) {
                    try {
                        const errors = xhr.responseJSON.errors || xhr.responseJSON.msgField;
                        if (errors) {
                            showValidationErrors(errors);
                            return;
                        }
                    } catch (e) {
                        errorMessage = 'Kesalahan validasi form';
                    }
                } else if (xhr.status === 500) {
                    errorMessage = xhr.responseJSON?.message || 'Kesalahan server internal';
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMessage
                });
            },
            complete: function() {
                setButtonsState(false);
            }
        });
    }

    function validateSPKForm() {
        const form = $('#spk-form-element');
        let isValid = true;
        let errorMessages = [];

        // Basic validation
        form.find('select[required]').each(function() {
            if (!$(this).val()) {
                isValid = false;
                const label = $(this).siblings('label').text() || $(this).attr('name');
                errorMessages.push(`${label} harus dipilih`);
            }
        });

        if (!isValid) {
            Swal.fire({
                icon: 'warning',
                title: 'Validasi Error!',
                html: '<div style="text-align: left;"><ul style="padding-left: 20px;">' +
                    errorMessages.map(error => `<li>${error}</li>`).join('') +
                    '</ul></div>'
            });
            return false;
        }

        return true;
    }

    function showValidationErrors(errors) {
        let errorList = '';

        for (const field in errors) {
            if (errors[field]) {
                if (Array.isArray(errors[field])) {
                    errors[field].forEach(error => {
                        errorList += `<li>${error}</li>`;
                    });
                } else {
                    errorList += `<li>${errors[field]}</li>`;
                }
            }
        }

        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal!',
            html: `<div style="text-align: left;">
                  <p>Terdapat kesalahan pada input:</p>
                  <ul style="padding-left: 20px; margin-top: 10px;">
                      ${errorList}
                  </ul>
               </div>`
        });
    }

    function setButtonsState(disabled) {
        const weightedBtn = $('#weighted-btn');
        const entropyBtn = $('#entropy-btn');

        weightedBtn.prop('disabled', disabled);
        entropyBtn.prop('disabled', disabled);

        if (disabled) {
            weightedBtn.html('<i class="fa-solid fa-spinner fa-spin me-1"></i>Processing...');
            entropyBtn.html('<i class="fa-solid fa-spinner fa-spin me-1"></i>Processing...');
        } else {
            weightedBtn.html('<i class="fa-solid fa-chart-line me-1"></i>Weighted MOORA');
            entropyBtn.html('<i class="fa-solid fa-calculator me-1"></i>Entropy MOORA');
        }
    }

    function displaySPKResults(data, matrices, method, useEntropy) {
        console.log('Displaying SPK results:', {
            data,
            matrices,
            method,
            useEntropy
        });

        const resultsSection = $('#spk-results');
        const quickSummary = $('#quick-summary');
        const bobotTableBody = $('#bobot-table-body');
        const spkTableBody = $('#spk-table-body');

        // Show results section
        resultsSection.removeClass('hidden');

        // Clear previous results
        quickSummary.empty();
        bobotTableBody.empty();
        spkTableBody.empty();

        // Generate quick summary
        if (Array.isArray(data) && data.length > 0) {
            const top3 = data.slice(0, 3);
            top3.forEach((item, index) => {
                const medalColors = ['text-yellow-600', 'text-gray-500', 'text-yellow-700'];
                const medalIcons = ['fa-trophy', 'fa-medal', 'fa-award'];

                const summaryCard = `
                <div class="bg-white border-2 border-green-200 rounded-lg p-3 text-center">
                    <div class="flex items-center justify-center mb-2">
                        <i class="fa-solid ${medalIcons[index]} ${medalColors[index]} text-2xl"></i>
                        <span class="ml-2 text-lg font-bold text-gray-700">#${index + 1}</span>
                    </div>
                    <h5 class="font-semibold text-gray-900 text-sm mb-1">${item.mahasiswa?.nama || 'N/A'}</h5>
                    <p class="text-xs text-gray-600 mb-1">${item.mahasiswa?.nim || 'N/A'}</p>
                    <p class="text-sm font-bold text-green-600">Score: ${(item.nilai_preferensi || 0).toFixed(4)}</p>
                    <button type="button"
                            onclick="selectMahasiswa('${item.mahasiswa?.nim || ''}', '${item.mahasiswa?.nama || ''}')"
                            class="mt-2 px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700 transition-colors">
                        <i class="fa-solid fa-user-plus me-1"></i>Pilih
                    </button>
                </div>
            `;
                quickSummary.append(summaryCard);
            });
        }

        // Display bobot
        if (matrices && matrices.bobot) {
            const bobot = matrices.bobot;
            const bobotRow = `
            <tr class="bg-white border-b">
                <td class="px-3 py-2">${(bobot.PL || 0).toFixed(4)}</td>
                <td class="px-3 py-2">${(bobot.M || 0).toFixed(4)}</td>
                <td class="px-3 py-2">${(bobot.BK || 0).toFixed(4)}</td>
                <td class="px-3 py-2">${(bobot.K || 0).toFixed(4)}</td>
                <td class="px-3 py-2">${(bobot.JL || 0).toFixed(4)}</td>
                <td class="px-3 py-2">${(bobot.JP || 0).toFixed(4)}</td>
            </tr>
        `;
            bobotTableBody.append(bobotRow);
        }

        // Display recommendations
        if (Array.isArray(data) && data.length > 0) {
            data.forEach((item, index) => {
                const row = `
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="px-3 py-2 font-medium">${index + 1}</td>
                    <td class="px-3 py-2">${item.mahasiswa?.nama || 'N/A'}</td>
                    <td class="px-3 py-2">${item.mahasiswa?.nim || 'N/A'}</td>
                    <td class="px-3 py-2">${(item.nilai_preferensi || 0).toFixed(4)}</td>
                    <td class="px-3 py-2">
                        <button type="button"
                                onclick="selectMahasiswa('${item.mahasiswa?.nim || ''}', '${item.mahasiswa?.nama || ''}')"
                                class="px-2 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">
                            Pilih
                        </button>
                    </td>
                </tr>
            `;
                spkTableBody.append(row);
            });
        }

        // Scroll to results
        resultsSection[0].scrollIntoView({
            behavior: 'smooth',
            block: 'nearest'
        });
    }

    function selectMahasiswa(nim, nama) {
        if (!nim || !nama) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: 'Data mahasiswa tidak valid'
            });
            return;
        }

        Swal.fire({
            title: 'Konfirmasi',
            text: `Pilih mahasiswa ${nama} untuk kelompok?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Pilih!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Switch to kelompok form tab
                const kelompokTabButton = $('[data-tab="kelompok-form"]');
                if (kelompokTabButton.length > 0) {
                    kelompokTabButton.trigger('click');
                }

                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: `Mahasiswa ${nama} berhasil dipilih`,
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    }

    // Initialize when DOM is ready
    $(document).ready(function() {
        console.log('SPK script loaded successfully');

        // Setup AJAX defaults
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
    });
</script>
