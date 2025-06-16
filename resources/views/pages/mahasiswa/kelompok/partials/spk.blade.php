<div class="p-4">
    <form id="spk-form-element" method="POST" action="{{ $action }}">
        @csrf

        @if (in_array(strtoupper($method), ['PUT']))
            @method($method)
        @endif

        <div class="space-y-4">
            <div>
                <h3 class="text-sm font-semibold text-gray-800">Kriteria Decision Maker</h3>
                <p class="text-xs text-gray-500 mb-3">Pilih kriteria yang dibutuhkan!</p>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                    <x-forms.select name="lokasi_preferensi_spk" label="Lokasi Preferensi" :options="$lokasi_preferensis"
                        placeholder="Lokasi Preferensi" required />

                    <x-forms.checkbox-dropdown name="minat_spk[]" label="Minat" title="Minat" :options="$minats->pluck('minat_nama', 'minat_id')->toArray()"
                        searchable required />

                    <x-forms.checkbox-dropdown name="bidang_keahlian_spk[]" label="Bidang Keahlian"
                        title="Bidang Keahlian" :options="$bidang_keahlians->pluck('bidang_keahlian_nama', 'bidang_keahlian_id')->toArray()" searchable required />

                    <x-forms.checkbox-dropdown name="kompetensi_spk[]" label="Kompetensi" title="Kompetensi"
                        :options="$kompetensis->pluck('kompetensi_nama', 'kompetensi_id')->toArray()" searchable required />
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-gray-800">Prioritas Bobot</h3>
                <p class="text-xs text-gray-500 mb-3">( 1 = Tertinggi, 6 = Terendah )</p>
                <div class="grid grid-cols-2 lg:grid-cols-6 gap-3">
                    <x-forms.select name="bobot_lokasi_preferensi_spk" label="Lokasi Preferensi" :options="$weight_ranks"
                        selected="6" required />

                    <x-forms.select name="bobot_minat_spk" label="Minat" :options="$weight_ranks" selected="5" required />

                    <x-forms.select name="bobot_bidang_keahlian_spk" label="Bidang Keahlian" :options="$weight_ranks"
                        selected="4" required />

                    <x-forms.select name="bobot_kompetensi_spk" label="Kompetensi" :options="$weight_ranks" selected="3"
                        required />

                    <x-forms.select name="bobot_jumlah_lomba_spk" label="Jumlah Lomba" :options="$weight_ranks" selected="2"
                        required />

                    <x-forms.select name="bobot_jumlah_prestasi_spk" label="Jumlah Prestasi" :options="$weight_ranks"
                        selected="1" required />
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-3 pt-4">
                <x-forms.select name="jumlah_rekomendasi" label="Jumlah Rekomendasi" :options="$jumlah_rekomendasis"
                    placeholder="Jumlah Rekomendasi" required class="w-48" />
                <div class="flex gap-2">
                    <x-buttons.default type="submit" title="Weighted MOORA" data-method="weighted"
                        icon="fa-solid fa-chart-line" />
                    <x-buttons.default type="submit" title="Entropy MOORA" data-method="entropy"
                        icon="fa-solid fa-calculator" />
                </div>
            </div>
        </div>
    </form>

    <!-- Results Section -->
    <div id="spk-results" class="hidden mt-4 space-y-4">
        <!-- Quick Summary -->
        <h4 class="text-base font-bold text-gray-800 mb-3">
            <i class="fa-solid fa-trophy me-1 text-yellow-500"></i>🏆 Top 3 Rekomendasi Terbaik
        </h4>
        <div id="quick-summary" class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <!-- Will be populated via JavaScript -->
        </div>

        <!-- Bobot Table -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-3">
                <h4 class="text-sm font-bold text-white mb-0">
                    <i class="fa-solid fa-weight-hanging me-1"></i>Bobot Kriteria
                </h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-3 py-2 text-left font-semibold text-gray-700 uppercase tracking-wide text-xs">
                                Lokasi Preferensi</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-700 uppercase tracking-wide text-xs">
                                Minat</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-700 uppercase tracking-wide text-xs">
                                Bidang Keahlian</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-700 uppercase tracking-wide text-xs">
                                Kompetensi</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-700 uppercase tracking-wide text-xs">
                                Jumlah Lomba</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-700 uppercase tracking-wide text-xs">
                                Jumlah Prestasi</th>
                        </tr>
                    </thead>
                    <tbody id="bobot-table-body">
                        <!-- Will be populated via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recommendation Table - Modified for full height without internal scrolling -->
        <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-purple-700 p-3">
                <h4 class="text-sm font-bold text-white mb-0">
                    <i class="fa-solid fa-users me-1"></i>Rekomendasi Mahasiswa
                    <span id="top-performers-info" class="text-xs font-normal opacity-90 ml-2"></span>
                </h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th
                                class="px-3 py-2 text-center font-semibold text-gray-700 uppercase tracking-wide w-12 text-xs">
                                Rank</th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-700 uppercase tracking-wide text-xs">
                                Nama
                            </th>
                            <th class="px-3 py-2 text-left font-semibold text-gray-700 uppercase tracking-wide text-xs">
                                NIM
                            </th>
                            <th
                                class="px-3 py-2 text-center font-semibold text-gray-700 uppercase tracking-wide w-20 text-xs">
                                Skor</th>
                        </tr>
                    </thead>
                    <tbody id="spk-table-body" class="divide-y divide-gray-200">
                        <!-- Will be populated via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let currentMethod = 'weighted';

        // Handle button clicks to set method
        $('button[data-method]').on('click', function(e) {
            e.preventDefault();
            currentMethod = $(this).data('method');
            $('#spk-form-element').submit();
        });

        // Simple form submission
        $("#spk-form-element").on('submit', function(e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);
            formData.append('entropy', currentMethod === 'entropy' ? '1' : '0');

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

            $.ajax({
                url: form.action,
                type: form.method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('Response received:', response);

                    if (response.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message || 'SPK berhasil diproses',
                            showConfirmButton: true,
                            timer: 3000
                        });
                        displaySPKResults(response.data, response.matrices);
                    } else {
                        Swal.close();

                        if (response.message) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Validasi Gagal!',
                                text: response.message
                            });
                        }
                    }
                },
                error: function(xhr) {
                    console.error('AJAX Error:', xhr);

                    let errorMessage = 'Terjadi kesalahan saat memproses SPK';

                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON
                        .message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMessage
                    });
                }
            });
        });

        function getTop5Scores(data) {
            // Get all unique scores, sort them in descending order, and take top 5
            const uniqueScores = [...new Set(data.map(item => item.nilai_preferensi || 0))]
                .sort((a, b) => b - a)
                .slice(0, 5);

            return uniqueScores;
        }

        function isTopPerformer(score, top5Scores) {
            return top5Scores.includes(score);
        }

        function getRankIcon(index) {
            if (index === 0) return '<i class="fa-solid fa-trophy text-yellow-600 mr-1"></i>';
            if (index === 1) return '<i class="fa-solid fa-medal text-yellow-500 mr-1"></i>';
            if (index === 2) return '<i class="fa-solid fa-award text-yellow-400 mr-1"></i>';
            return '<i class="fa-solid fa-star text-blue-500 mr-1"></i>';
        }

        function displaySPKResults(data, matrices) {
            console.log('Displaying results with data:', data);

            const resultsSection = $('#spk-results');
            const quickSummary = $('#quick-summary');
            const bobotTableBody = $('#bobot-table-body');
            const spkTableBody = $('#spk-table-body');
            const topPerformersInfo = $('#top-performers-info');

            // Show results section
            resultsSection.removeClass('hidden');

            // Clear previous results
            quickSummary.empty();
            bobotTableBody.empty();
            spkTableBody.empty();

            if (Array.isArray(data) && data.length > 0) {
                // Get top 5 unique scores
                const top5Scores = getTop5Scores(data);
                const topPerformersCount = data.filter(item => isTopPerformer(item.nilai_preferensi || 0,
                    top5Scores)).length;

                // Update info text
                topPerformersInfo.text(`(${topPerformersCount} mahasiswa dengan skor tertinggi)`);

                // Generate quick summary
                const top3 = data.slice(0, 3);
                top3.forEach((item, index) => {
                    const medals = [{
                            color: 'from-yellow-400 to-yellow-600',
                            icon: 'fa-trophy',
                            textColor: 'text-gray-800',
                            bgIcon: 'bg-yellow-500'
                        },
                        {
                            color: 'from-gray-400 to-gray-600',
                            icon: 'fa-medal',
                            textColor: 'text-gray-800',
                            bgIcon: 'bg-gray-500'
                        },
                        {
                            color: 'from-orange-400 to-orange-600',
                            icon: 'fa-award',
                            textColor: 'text-gray-800',
                            bgIcon: 'bg-orange-500'
                        }
                    ];

                    const medal = medals[index];
                    const summaryCard = `
                    <div class="bg-gradient-to-br ${medal.color} rounded-lg p-4 text-center shadow-lg transform hover:scale-105 transition-all duration-300">
                        <div class="flex items-center justify-center mb-2">
                            <div class="${medal.bgIcon} rounded-full p-2 shadow-md">
                                <i class="fa-solid ${medal.icon} text-white text-lg"></i>
                            </div>
                        </div>
                        <div class="bg-white bg-opacity-90 rounded-md p-3 backdrop-blur-sm">
                            <h3 class="text-sm font-bold ${medal.textColor} mb-1">Peringkat ${index + 1}</h3>
                            <h5 class="font-bold ${medal.textColor} text-base mb-1">${item.mahasiswa?.nama || 'N/A'}</h5>
                            <p class="text-sm ${medal.textColor} mb-2">${item.mahasiswa?.nim || 'N/A'}</p>
                            <div class="bg-gray-100 rounded-md p-2">
                                <p class="text-xs font-semibold ${medal.textColor}">Skor</p>
                                <p class="text-lg font-bold ${medal.textColor}">${(item.nilai_preferensi || 0).toFixed(4)}</p>
                            </div>
                        </div>
                    </div>
                `;
                    quickSummary.append(summaryCard);
                });

                // Display recommendations with unified highlighting
                data.forEach((item, index) => {
                    const score = item.nilai_preferensi || 0;
                    const isHighlighted = isTopPerformer(score, top5Scores);

                    // Single color highlight for top performers
                    const rowClass = isHighlighted ?
                        'bg-gradient-to-r from-blue-50 to-indigo-100 border-l-4 border-blue-500 font-semibold' :
                        'bg-white hover:bg-gray-50';

                    const rankIcon = index < 3 ? getRankIcon(index) : '';

                    const row = `
                    <tr class="${rowClass} transition-all duration-300">
                        <td class="px-3 py-3 text-center">
                            <div class="flex items-center justify-center">
                                ${rankIcon}
                                <span class="font-bold text-base ${isHighlighted ? 'text-blue-800' : 'text-gray-600'}">${index + 1}</span>
                            </div>
                        </td>
                        <td class="px-3 py-3 text-sm ${isHighlighted ? 'text-blue-900 font-semibold' : 'text-gray-800'}">${item.mahasiswa?.nama || 'N/A'}</td>
                        <td class="px-3 py-3 font-mono text-sm ${isHighlighted ? 'text-blue-800' : 'text-gray-700'}">${item.mahasiswa?.nim || 'N/A'}</td>
                        <td class="px-3 py-3 text-center">
                            <span class="inline-block ${isHighlighted ? 'bg-gradient-to-r from-blue-600 to-indigo-700' : 'bg-gradient-to-r from-gray-500 to-gray-600'} text-white px-2 py-1 rounded-full text-xs font-bold font-mono">
                                ${score.toFixed(4)}
                            </span>
                        </td>
                    </tr>
                `;
                    spkTableBody.append(row);
                });
            } else {
                // Show message if no data
                quickSummary.append(`
                    <div class="col-span-3 text-center py-4">
                        <p class="text-gray-500 text-sm">Tidak ada data untuk ditampilkan</p>
                    </div>
                `);
                spkTableBody.append(`
                    <tr>
                        <td colspan="4" class="px-3 py-4 text-center text-gray-500 text-sm">
                            Tidak ada data rekomendasi untuk ditampilkan
                        </td>
                    </tr>
                `);
            }

            // Display bobot
            if (matrices && matrices.bobot) {
                const bobot = matrices.bobot;
                const bobotRow = `
                <tr class="bg-white border-b border-gray-200 hover:bg-gray-50 transition-colors">
                    <td class="px-3 py-3 font-mono text-center bg-blue-50 text-sm font-semibold text-gray-800">${(bobot.PL || 0).toFixed(4)}</td>
                    <td class="px-3 py-3 font-mono text-center bg-green-50 text-sm font-semibold text-gray-800">${(bobot.M || 0).toFixed(4)}</td>
                    <td class="px-3 py-3 font-mono text-center bg-purple-50 text-sm font-semibold text-gray-800">${(bobot.BK || 0).toFixed(4)}</td>
                    <td class="px-3 py-3 font-mono text-center bg-yellow-50 text-sm font-semibold text-gray-800">${(bobot.K || 0).toFixed(4)}</td>
                    <td class="px-3 py-3 font-mono text-center bg-red-50 text-sm font-semibold text-gray-800">${(bobot.JL || 0).toFixed(4)}</td>
                    <td class="px-3 py-3 font-mono text-center bg-indigo-50 text-sm font-semibold text-gray-800">${(bobot.JP || 0).toFixed(4)}</td>
                </tr>
            `;
                bobotTableBody.append(bobotRow);
            }

            // Scroll to results
            setTimeout(() => {
                resultsSection[0].scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }, 100);
        }
    });
</script>
