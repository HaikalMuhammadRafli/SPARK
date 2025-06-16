<form id="form" method="{{ $method }}" action="{{ $action }}" data-reload-table class="p-4 md:p-5">
    @csrf

    @if (in_array(strtoupper($method), ['PUT']))
        @method($method)
    @endif

    <div class="gap-4 mb-4 grid grid-cols-1 md:grid-cols-2">
        {{-- Kelompok ID --}}
        <div>
            <x-forms.default-input id="kelompok_id" name="kelompok_id" label="Kelompok ID"
                placeholder="Masukkan ID Kelompok" value="{{ $dosenPembimbingPeran->kelompok_id ?? '' }}" isRequired />
            <span id="error-kelompok_id" class="text-sm text-red-500 mt-1 block"></span>
        </div>

        {{-- Peran Nama --}}
        <div>
            <x-forms.default-input id="peran_nama" name="peran_nama" label="Peran Nama"
                placeholder="Masukkan Nama Peran" value="{{ $dosenPembimbingPeran->peran_nama ?? '' }}" isRequired />
            <span id="error-peran_nama" class="text-sm text-red-500 mt-1 block"></span>
        </div>

        {{-- Kompetensi Dynamic Field --}}
        @php
            $allKompetensi = [
                1 => 'Python Programming',
                2 => 'JavaScript Programming',
                3 => 'React.js Framework',
                4 => 'Laravel Framework',
                5 => 'MySQL Database',
                6 => 'Node.js Backend',
                7 => 'Docker & Containerization',
                8 => 'Git & Version Control',
                9 => 'RESTful API Design',
                10 => 'Android Development',
                11 => 'UI/UX Prototyping (Figma)',
                12 => 'Machine Learning with TensorFlow',
                13 => 'Cybersecurity Fundamentals',
                14 => 'Agile & Scrum Methodology',
                15 => 'Cloud Deployment (AWS/GCP)',
            ];
        @endphp

        @if (strtoupper($method) !== 'POST')
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kompetensi</label>
                <div id="kompetensi-container" class="space-y-2">
                    @if (isset($dosenPembimbingPeranKompetensi) && count($dosenPembimbingPeranKompetensi) > 0)
                        @foreach ($dosenPembimbingPeranKompetensi as $item)
                            <div class="flex gap-2 items-center kompetensi-row">
                                <x-forms.default-select name="kompetensi_id[]" :data="$allKompetensi" :value="$item->kompetensi_id"
                                    :isRequired="true" disabled />

                                <button type="button"
                                    onclick="deleteKompetensi({{ $dosenPembimbingPeran->peran_id }}, {{ $item->kompetensi_id }}, this)"
                                    class="inline-flex items-center px-3 mt-5 py-1.5 text-xs font-medium text-white bg-red-500 rounded-lg cursor-pointer">
                                    <i class="fa-solid fa-trash-can me-2"></i>
                                    Hapus
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="flex justify-start mt-4">
                    <x-buttons.default type="button" title="Tambah Kompetensi" color="primary" id="add-kompetensi"
                        icon="{{ $buttonIcon }}" />
                </div>

                <span id="error-kompetensi_id" class="text-sm text-red-500 mt-1 block"></span>
            </div>
        @endif


    </div>

    <div class="flex justify-end mt-4">
        <x-buttons.default type="submit" title="{{ $buttonText }}" color="primary" icon="{{ $buttonIcon }}" />
    </div>
</form>
{{-- Template disiapkan sebagai string HTML yang valid --}}
<div id="kompetensi-select-template" class="hidden">
    {!! str_replace(
        "\n",
        '',
        view('components.forms.default-select', [
            'id' => 'kompetensi_id[]',
            'data' => [
                1 => 'Python Programming',
                2 => 'JavaScript Programming',
                3 => 'React.js Framework',
                4 => 'Laravel Framework',
                5 => 'MySQL Database',
                6 => 'Node.js Backend',
                7 => 'Docker & Containerization',
                8 => 'Git & Version Control',
                9 => 'RESTful API Design',
                10 => 'Android Development',
                11 => 'UI/UX Prototyping (Figma)',
                12 => 'Machine Learning with TensorFlow',
                13 => 'Cybersecurity Fundamentals',
                14 => 'Agile & Scrum Methodology',
                15 => 'Cloud Deployment (AWS/GCP)',
            ],
            'isRequired' => true,
        ])->render(),
    ) !!}
</div>

<script>
    const peranId = @json($dosenPembimbingPeran->peran_id ?? null);
    document.getElementById('add-kompetensi').addEventListener('click', function() {
        const container = document.getElementById('kompetensi-container');
        const template = document.getElementById('kompetensi-select-template');

        const wrapper = document.createElement('div');
        wrapper.innerHTML = template.innerHTML;
        container.appendChild(wrapper);
    });

    $(document).ready(function() {
        $("#form").validate({
            rules: {
                kelompok_id: {
                    required: true
                },
                peran_nama: {
                    required: true
                }
            },
            messages: {
                kelompok_id: {
                    required: "Kelompok ID wajib diisi."
                },
                peran_nama: {
                    required: "Nama Peran wajib diisi."
                }
            },
            submitHandler: function(form, event) {
                event.preventDefault();

                const token = localStorage.getItem('api_token');
                if (!token) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Token Hilang',
                        text: 'Token tidak ditemukan di localStorage.'
                    });
                    return;
                }

                const url = form.getAttribute('action');
                const method = form.getAttribute('method').toUpperCase();

                // Kumpulkan semua input
                const payload = {};
                $(form).find('input, select, textarea').each(function() {
                    const name = $(this).attr('name');
                    if (name && !['_token', '_method'].includes(name)) {
                        if (name.endsWith('[]')) {
                            const key = name.replace('[]', '');
                            payload[key] = payload[key] || [];
                            payload[key].push($(this).val());
                        } else {
                            payload[name] = $(this).val();
                        }
                    }
                });

                // Submit utama: simpan peran
                $.ajax({
                    url: url,
                    method: method,
                    data: JSON.stringify(payload),
                    contentType: 'application/json',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        if (response.success) {
                            const kompetensiIds = payload.kompetensi_id || [];

                            // Submit tambahan: simpan setiap kompetensi_id
                            const postKompetensi = kompetensiIds.map(id => {
                                return fetch(
                                    `http://127.0.0.1:8000/api/dosen-pembimbing-peran-kompetensi/${peranId}`, {
                                        method: 'POST',
                                        headers: {
                                            'Authorization': 'Bearer ' +
                                                token,
                                            'Content-Type': 'application/json',
                                            'Accept': 'application/json',
                                        },
                                        body: JSON.stringify({
                                            kompetensi_id: id
                                        })
                                    });
                            });

                            Promise.all(postKompetensi)
                                .then(() => {
                                    disposeModal();
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.message ||
                                            'Data berhasil disimpan.'
                                    }).then(() => {
                                        disposeModal();
                                        reloadDataTable();
                                    });
                                })
                                .catch(err => {
                                    console.error('Gagal menyimpan kompetensi:',
                                        err);
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Sebagian Gagal',
                                        text: 'Peran berhasil disimpan, tapi gagal menautkan kompetensi.'
                                    });
                                });
                        } else {
                            $('.error-text, .invalid-feedback').text('');
                            $('.is-invalid').removeClass('is-invalid');
                            $.each(response.msgField, function(field, messages) {
                                $('#error-' + field).text(messages[0]);
                                const $input = $('#' + field);
                                if ($input.length) {
                                    $input.addClass('is-invalid');
                                } else {
                                    $('[name="' + field + '"]').addClass(
                                        'is-invalid');
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: 'Terjadi kesalahan pada server.'
                        });
                    }
                });
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            }
        });

        // Bersihkan error saat input
        $('#form input, #form select, #form textarea').on('input', function() {
            const fieldId = $(this).attr('id');
            $('#error-' + fieldId).text('');
            $(this).removeClass('is-invalid');
        });
    });

    function deleteKompetensi(peranId, kompetensiId, el) {
        const token = localStorage.getItem('api_token');
        if (!token) {
            console.error('Token tidak ditemukan.');
            return;
        }

        fetch(`http://127.0.0.1:8000/api/dosen-pembimbing-peran-kompetensi/${peranId}`, {
                method: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    kompetensi_id: kompetensiId
                })
            })
            .then(res => res.json())
            .then(res => {
                if (res.success) {
                    // Hapus elemen parent terdekat (baris kompetensi)
                    const row = el.closest('.kompetensi-row');
                    if (row) row.remove();
                    console.log('Kompetensi berhasil dihapus.');
                } else {
                    console.warn('Gagal menghapus:', res.message || 'Terjadi kesalahan.');
                }
            })
            .catch(err => {
                console.error('Fetch error:', err);
            });
    }
</script>
