<form id="form" method="{{ $method }}" action="{{ $action }}" data-reload-table class="p-4 md:p-5">
    @csrf

    @if (in_array(strtoupper($method), ['PUT']))
        @method($method)
    @endif

    <!-- Form Fields -->
    <div class="gap-4 mb-4">
        {{-- Status --}}
        <div>
            <label for="prestasi_status" class="form-label">Status</label>
            <select id="prestasi_status" name="prestasi_status" class="form-select" required>
                <option value="Disetujui" {{ old('prestasi_status', $laporan->prestasi_status ?? '') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="Pending" {{ old('prestasi_status', $laporan->prestasi_status ?? '') == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Tidak Valid" {{ old('prestasi_status', $laporan->prestasi_status ?? '') == 'Tidak Valid' ? 'selected' : '' }}>Tidak Valid</option>
            </select>
            <span id="error-prestasi_status" class="text-sm text-red-500 mt-1 block"></span>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="flex justify-end">
        <x-buttons.default type="submit" title="{{ $buttonText }}" color="primary" icon="{{ $buttonIcon }}" />
    </div>
</form>


<script>
    $(document).ready(function() {
        $("#form").validate({
            rules: {
                prestasi_juara: {
                    required: true
                },
                prestasi_surat_tugas_url: {
                    required: true
                },
                prestasi_poster_url: {
                    required: true
                },
                prestasi_foto_juara_url: {
                    required: true
                },
                prestasi_proposal_url: {
                    required: true
                },
                prestasi_sertifikat_url: {
                    required: true
                },
                lomba_id: {
                    required: true
                },
                nim: {
                    required: true
                }
            },
            messages: {
                prestasi_juara: {
                    required: "Juara wajib diisi."
                },
                prestasi_surat_tugas_url: {
                    required: "URL Surat Tugas wajib diisi."
                },
                prestasi_poster_url: {
                    required: "URL Poster wajib diisi."
                },
                prestasi_foto_juara_url: {
                    required: "URL Foto Juara wajib diisi."
                },
                prestasi_proposal_url: {
                    required: "URL Proposal wajib diisi."
                },
                prestasi_sertifikat_url: {
                    required: "URL Sertifikat wajib diisi."
                },
                lomba_id: {
                    required: "Lomba ID wajib diisi."
                },
                nim: {
                    required: "NIM wajib diisi."
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

    const payload = {
        prestasi_status: $('#prestasi_status').val() // Hanya kirim status
    };

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

                $.each(response.msgField, function(field, messages) {
                    $('#error-' + field).text(messages[0]);
                    const $input = $('#' + field);
                    if ($input.length) {
                        $input.addClass('is-invalid');
                    } else {
                        $('[name="' + field + '"]').addClass('is-invalid');
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

        // Clear error message on input
        $('#form input, #form select, #form textarea').on('input', function() {
            const fieldId = $(this).attr('id');
            $('#error-' + fieldId).text('');
            $(this).removeClass('is-invalid');
        });
    });
</script>
