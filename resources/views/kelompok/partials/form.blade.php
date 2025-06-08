<form id="form" method="POST" action="{{ $action }}" data-reload-table class="p-4 md:p-5">
    @csrf

    @if (in_array(strtoupper($method), ['PUT']))
        @method($method)
    @endif

    <div class="grid grid-cols-2 gap-4 mb-4">
        <x-forms.input name="kelompok_nama" label="Nama Kelompok" placeholder="Masukkan Nama Kelompok"
            value="{{ $kelompok->kelompok_nama ?? '' }}" required />
        <x-forms.select name="lomba_id" label="Lomba" :options="$lombas->pluck('lomba_nama', 'lomba_id')->toArray()" placeholder="Pilih Lomba" required
            onchange="handleLombaChange(this.value)" selected="{{ $kelompok->lomba_id ?? '' }}" />
    </div>

    <!-- Dosen Pembimbing Section -->
    <div class="mb-4">
        <div class="relative overflow-x-auto sm:rounded-lg border border-gray-200">
            <table class="w-full text-xs text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-3">Dosen Pembimbing</th>
                        <th scope="col" class="px-6 py-3">Peran</th>
                        <th scope="col" class="px-6 py-3">Kompetensi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <x-forms.select name="dosen_pembimbing" placeholder="Pilih Dosen Pembimbing"
                                :options="$dosen_pembimbings->pluck('nama', 'nip')->toArray()"
                                selected="{{ isset($kelompok->dosen_pembimbing_peran) && $kelompok->dosen_pembimbing_peran ? $kelompok->dosen_pembimbing_peran->first()?->nip : '' }}"
                                required />
                        </td>
                        <td class="px-6 py-4">
                            <x-forms.select name="peran_dpm" placeholder="Pilih Peran" :options="$perans_dpm"
                                selected="{{ isset($kelompok->dosen_pembimbing_peran) ? $kelompok->dosen_pembimbing_peran->peran_nama : '' }}"
                                required />
                        </td>
                        <td class="px-6 py-4">
                            <x-forms.checkbox-dropdown title="Kompetensi" name="kompetensi_dpm[]" :options="$kompetensis->pluck('kompetensi_nama', 'kompetensi_id')->toArray()"
                                :selected="isset($kelompok->dosen_pembimbing_peran) &&
                                $kelompok->dosen_pembimbing_peran->kompetensis
                                    ? $kelompok->dosen_pembimbing_peran->kompetensis->pluck('kompetensi_id')->toArray()
                                    : []" searchable="true" required />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Notice message when no lomba is selected -->
    <div id="lombaNotice"
        class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg {{ isset($kelompok) && $kelompok->lomba_id ? 'hidden' : '' }}">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-blue-400 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            <p class="text-blue-800 text-sm">
                <span class="font-medium">Pilih lomba terlebih dahulu</span> untuk dapat menambahkan anggota kelompok.
            </p>
        </div>
    </div>

    <div class="mb-4" id="memberSection"
        style="{{ isset($kelompok) && $kelompok->lomba_id ? 'display: block;' : 'display: none;' }}">
        <div class="flex justify-between items-center mb-3">
            <x-buttons.default type="button" title="Tambah Anggota" color="primary" icon="fa-solid fa-plus"
                id="addRowBtn" />
        </div>

        <div class="relative overflow-x-auto sm:rounded-lg border border-gray-200">
            <table class="w-full text-xs text-left rtl:text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th scope="col" class="px-6 py-3 w-16 text-center">No</th>
                        <th scope="col" class="px-6 py-3">Mahasiswa</th>
                        <th scope="col" class="px-6 py-3">Peran</th>
                        <th scope="col" class="px-6 py-3">Kompetensi</th>
                        <th scope="col" class="px-6 py-3 text-center w-20">Aksi</th>
                    </tr>
                </thead>
                <tbody id="memberTableBody">
                    <!-- Load existing members for edit mode -->
                    @if (isset($kelompok) && $kelompok->mahasiswa_perans && $kelompok->mahasiswa_perans->count() > 0)
                        @foreach ($kelompok->mahasiswa_perans as $index => $mahasiswa_peran)
                            <tr class="bg-white hover:bg-gray-50 member-row" data-row-index="{{ $index }}">
                                <td class="px-6 py-4 text-center font-medium text-gray-900 row-number">
                                    {{ $index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <x-forms.select name="mahasiswa[{{ $index }}]" placeholder="Pilih Mahasiswa"
                                        :options="$mahasiswas->pluck('nama', 'nim')->toArray()" selected="{{ $mahasiswa_peran->nim }}" required />
                                </td>
                                <td class="px-6 py-4">
                                    <x-forms.select name="peran_mhs[{{ $index }}]" placeholder="Pilih Peran"
                                        :options="$perans_mhs" selected="{{ $mahasiswa_peran->peran_nama }}" required />
                                </td>
                                <td class="px-6 py-4">
                                    <x-forms.checkbox-dropdown title="Kompetensi"
                                        name="kompetensi_mhs[{{ $index }}][]" :options="$kompetensis->pluck('kompetensi_nama', 'kompetensi_id')->toArray()"
                                        :selected="$mahasiswa_peran->kompetensis->pluck('kompetensi_id')->toArray()" searchable="true" required />
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button type="button" class="text-red-600 hover:text-red-900 remove-row-btn"
                                        onclick="removeRow(this)">
                                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 18 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        <div class="mt-2 text-sm text-gray-600">
            <span
                id="memberCount">{{ isset($kelompok) && $kelompok->mahasiswa_perans ? $kelompok->mahasiswa_perans->count() : 0 }}</span>
            dari <span id="maxMembers">0</span> anggota
        </div>
    </div>

    <div class="flex justify-end">
        <div class="flex justify-end">
            <x-buttons.default type="submit" title="{{ $buttonText }}" color="primary"
                icon="{{ $buttonIcon }}" id="submitBtn" />
        </div>
    </div>
</form>

<!-- Hidden container for pre-rendered rows -->
<div id="componentTemplates" style="display: none;">
    <table style="display: none;">
        <tbody>
            @for ($i = 0; $i < 20; $i++)
                <tr class="bg-white hover:bg-gray-50 member-row" data-row-index="{{ $i }}"
                    data-template-index="{{ $i }}">
                    <td class="px-6 py-4 text-center font-medium text-gray-900 row-number">{{ $i + 1 }}</td>
                    <td class="px-6 py-4">
                        <x-forms.select name="mahasiswa[{{ $i }}]" placeholder="Pilih Mahasiswa"
                            :options="$mahasiswas->pluck('nama', 'nim')->toArray()" />
                    </td>
                    <td class="px-6 py-4">
                        <x-forms.select name="peran_mhs[{{ $i }}]" placeholder="Pilih Peran"
                            :options="$perans_mhs" />
                    </td>
                    <td class="px-6 py-4">
                        <x-forms.checkbox-dropdown title="Kompetensi" name="kompetensi_mhs[{{ $i }}][]"
                            :options="$kompetensis->pluck('kompetensi_nama', 'kompetensi_id')->toArray()" :selected="[]" searchable="true" />
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button type="button" class="text-red-600 hover:text-red-900 remove-row-btn"
                            onclick="removeRow(this)">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 18 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M1 5h16M7 8v8m4-8v8M7 1h4a1 1 0 0 1 1 1v3H6V2a1 1 0 0 1 1-1ZM3 5h12v13a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V5Z" />
                            </svg>
                        </button>
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>

<script>
    let rowIndex = 0;
    let maxMembers = 0;
    let currentRowCount =
        {{ isset($kelompok) && $kelompok->mahasiswa_perans ? $kelompok->mahasiswa_perans->count() : 0 }};
    let lombaSelected = {{ isset($kelompok) && $kelompok->lomba_id ? 'true' : 'false' }};
    let isEditMode = {{ isset($kelompok) && $kelompok->exists ? 'true' : 'false' }};

    // Load lomba data with group sizes
    let lombas = {!! json_encode(
        $lombas->map(function ($lomba) {
            return [
                'lomba_id' => $lomba->lomba_id,
                'lomba_nama' => $lomba->lomba_nama,
                'lomba_ukuran_kelompok' => $lomba->lomba_ukuran_kelompok ?? 1,
            ];
        }),
    ) !!};

    $(document).ready(function() {
        $('#addRowBtn').on('click', function() {
            if (currentRowCount < maxMembers) {
                addNewRow();
            }
        });

        initializeFormValidation();
        rowIndex = currentRowCount;

        // If editing existing kelompok, load the lomba
        @if (isset($kelompok) && $kelompok->lomba_id)
            handleLombaChange('{{ $kelompok->lomba_id }}');
        @endif

        updateRemoveButtonStates();
        updateSubmitButtonState();
        updateRowNumbers();
    });

    function handleLombaChange(lombaId) {
        if (!lombaId) {
            $('#memberSection').hide();
            $('#lombaNotice').show();
            lombaSelected = false;
            updateSubmitButtonState();
            return;
        }

        const selectedLomba = lombas.find(lomba => lomba.lomba_id == lombaId);
        if (!selectedLomba) return;

        maxMembers = selectedLomba.lomba_ukuran_kelompok;
        lombaSelected = true;

        $('#lombaNotice').hide();
        $('#memberSection').show();
        $('#maxMembers').text(maxMembers);
        $('#memberRequirement').text('(Maksimal ' + maxMembers + ' anggota)');

        if (!isEditMode && currentRowCount === 0) {
            addNewRow();
        }

        updateAddButtonState();
        updateRemoveButtonStates();
        updateSubmitButtonState();
    }

    function updateSubmitButtonState() {
        const submitBtn = $('#submitBtn');

        if (!lombaSelected) {
            submitBtn.prop('disabled', true)
                .addClass('opacity-50 cursor-not-allowed')
                .attr('title', 'Pilih lomba terlebih dahulu');
        } else {
            submitBtn.prop('disabled', false)
                .removeClass('opacity-50 cursor-not-allowed')
                .attr('title', '{{ $buttonText }}');
        }
    }

    function addNewRow() {
        if (currentRowCount >= maxMembers) {
            Swal.fire({
                icon: 'warning',
                title: 'Batas Maksimal',
                text: 'Maksimal ' + maxMembers + ' anggota dapat ditambahkan.'
            });
            return;
        }

        const templateIndex = rowIndex % 20;
        const templateRow = $('#componentTemplates tr[data-template-index="' + templateIndex + '"]');

        if (templateRow.length === 0) {
            console.error('Template row ' + templateIndex + ' not found');
            return;
        }

        let clonedRow = templateRow[0].outerHTML;

        // Update the row index in the cloned row
        clonedRow = clonedRow.replace(/data-row-index="\d+"/, 'data-row-index="' + rowIndex + '"');
        clonedRow = clonedRow.replace(/name="mahasiswa\[\d+\]"/, 'name="mahasiswa[' + rowIndex + ']"');
        clonedRow = clonedRow.replace(/name="peran_mhs\[\d+\]"/, 'name="peran_mhs[' + rowIndex + ']"');
        clonedRow = clonedRow.replace(/name="kompetensi_mhs\[\d+\]\[\]"/, 'name="kompetensi_mhs[' + rowIndex + '][]"');

        // Update row number
        clonedRow = clonedRow.replace(/class="[^"]*row-number[^"]*">(\d+)</,
            'class="px-6 py-4 text-center font-medium text-gray-900 row-number">' + (rowIndex + 1) + '<');

        $('#memberTableBody').append(clonedRow);

        rowIndex++;
        currentRowCount++;
        updateMemberCount();
        updateRemoveButtonStates();
        updateAddButtonState();
    }

    function removeRow(button) {
        if (currentRowCount <= 1) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Minimal harus ada satu anggota kelompok!'
            });
            return;
        }

        $(button).closest('tr').remove();
        currentRowCount--;
        updateMemberCount();
        updateRemoveButtonStates();
        updateAddButtonState();
        reindexRows();
    }

    function reindexRows() {
        $('#memberTableBody tr').each(function(index) {
            $(this).attr('data-row-index', index);
            $(this).find('select[name^="mahasiswa"]').attr('name', 'mahasiswa[' + index + ']');
            $(this).find('select[name^="peran_mhs"]').attr('name', 'peran_mhs[' + index + ']');
            $(this).find('input[name^="kompetensi_mhs"]').each(function() {
                const currentName = $(this).attr('name');
                const newName = currentName.replace(/kompetensi_mhs\[\d+\]\[\]/, 'kompetensi_mhs[' +
                    index + '][]');
                $(this).attr('name', newName);
            });
        });

        rowIndex = currentRowCount;
        updateRowNumbers();
    }

    function updateRowNumbers() {
        $('#memberTableBody tr').each(function(index) {
            $(this).find('.row-number').text(index + 1);
        });
    }

    function updateMemberCount() {
        $('#memberCount').text(currentRowCount);
    }

    function updateAddButtonState() {
        const addBtn = $('#addRowBtn');

        if (currentRowCount >= maxMembers) {
            addBtn.prop('disabled', true).addClass('opacity-50 cursor-not-allowed');
        } else {
            addBtn.prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');
        }
    }

    function updateRemoveButtonStates() {
        $('.member-row .remove-row-btn').each(function() {
            if (currentRowCount <= 1) {
                $(this).addClass('opacity-50 cursor-not-allowed').prop('disabled', true);
            } else {
                $(this).removeClass('opacity-50 cursor-not-allowed').prop('disabled', false);
            }
        });
    }

    function initializeFormValidation() {
        $("#form").validate({
            rules: {
                kelompok_nama: {
                    required: true
                },
                lomba_id: {
                    required: true
                },
                dosen_pembimbing: {
                    required: true
                },
                peran_dpm: {
                    required: true
                }
            },
            messages: {
                kelompok_nama: {
                    required: "Nama Kelompok wajib diisi."
                },
                lomba_id: {
                    required: "Lomba wajib dipilih."
                },
                dosen_pembimbing: {
                    required: "Dosen Pembimbing wajib dipilih."
                },
                peran_dpm: {
                    required: "Peran Dosen Pembimbing wajib dipilih."
                }
            },
            submitHandler: function(form, event) {
                event.preventDefault();

                if (!lombaSelected) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Pilih lomba terlebih dahulu!'
                    });
                    return false;
                }

                if ($('#memberTableBody tr').length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Minimal harus ada satu anggota kelompok!'
                    });
                    return false;
                }

                // Validate dosen pembimbing kompetensi (using explicit array notation)
                const dosenKompetensi = $('input[name="kompetensi_dpm[]"]:checked').length;
                if (dosenKompetensi === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Pilih minimal satu kompetensi untuk dosen pembimbing!'
                    });
                    return false;
                }

                let hasIncompleteRow = false;
                $('#memberTableBody tr').each(function() {
                    const mahasiswa = $(this).find('select[name^="mahasiswa"]').val();
                    const peran = $(this).find('select[name^="peran_mhs"]').val();
                    const kompetensi = $(this).find('input[type="checkbox"]:checked').length;

                    if (mahasiswa || peran || kompetensi > 0) {
                        if (!mahasiswa || !peran || kompetensi === 0) {
                            hasIncompleteRow = true;
                            return false;
                        }
                    }
                });

                if (hasIncompleteRow) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Lengkapi semua field untuk setiap anggota yang diisi!'
                    });
                    return false;
                }

                var formData = new FormData(form);

                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status) {
                            disposeModal();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            }).then(() => {
                                disposeModal();
                                reloadDataTable();
                            });
                        } else {
                            $('.error-text, .invalid-feedback').text('');
                            $('.is-invalid').removeClass('is-invalid');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                                const $field = $('#' + prefix);
                                if ($field.length) {
                                    $field.addClass('is-invalid');
                                } else {
                                    $('[name="' + prefix + '"]').addClass('is-invalid');
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat menyimpan data.'
                        });
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('td').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        $(document).on('input change', '#form input, #form select', function() {
            const fieldName = $(this).attr('name');
            if (fieldName) {
                $('#error-' + fieldName.replace(/[\[\]]/g, '')).text('');
                $(this).removeClass('is-invalid');
            }
        });
    }
</script>
