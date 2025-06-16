<form id="Form" method="POST" action="{{ $action }}" data-reload-table class="p-4 md:p-5">
    @csrf
    <input type="hidden" id="method_field" name="_method" value="">

    <!-- Form Fields -->
    <div class="gap-4 mb-4">
        {{-- Status --}}
        <div class="mb-3">
            <label for="prestasi_status" class="form-label">Status</label>
            <select id="prestasi_status" name="prestasi_status" class="form-select" required>
                <option value="">Pilih Status</option>
                <option value="Disetujui">Disetujui</option>
                <option value="Pending">Pending</option>
                <option value="Ditolak">Ditolak</option>
            </select>
            <span id="error-prestasi_status" class="text-sm text-red-500 mt-1 block"></span>
        </div>

        {{-- Catatan (tampil jika status ditolak) --}}
        <div id="catatan_section" class="mb-3" style="display: none;">
            <label for="prestasi_catatan" class="form-label">Catatan/Alasan Penolakan</label>
            <textarea id="prestasi_catatan" name="prestasi_catatan" class="form-control" rows="3" 
                placeholder="Masukkan alasan penolakan..."></textarea>
            <span id="error-prestasi_catatan" class="text-sm text-red-500 mt-1 block"></span>
        </div>
    </div>

    <!-- Submit Button -->
    <div class="flex justify-end">
        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-save me-2"></i>Simpan
        </button>
    </div>
</form>

<script>
$(document).ready(function() {
    // Show/hide catatan section based on status
    $('#prestasi_status').change(function() {
        if ($(this).val() === 'Ditolak') {
            $('#catatan_section').show();
            $('#prestasi_catatan').attr('required', true);
        } else {
            $('#catatan_section').hide();
            $('#prestasi_catatan').attr('required', false);
            $('#prestasi_catatan').val('');
        }
    });

    $("#form").validate({
        rules: {
            prestasi_status: {
                required: true
            },
            prestasi_catatan: {
                required: function() {
                    return $('#prestasi_status').val() === 'Ditolak';
                }
            }
        },
        messages: {
            prestasi_status: {
                required: "Status wajib dipilih."
            },
            prestasi_catatan: {
                required: "Catatan wajib diisi jika status ditolak."
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
            const method = $('#method_field').val() || 'POST';

            const payload = {
                prestasi_status: $('#prestasi_status').val(),
                prestasi_catatan: $('#prestasi_catatan').val() || null
            };

            // Jika method PUT, gunakan fetch karena jQuery tidak support PUT dengan JSON
            if (method === 'PUT') {
                fetch(url, {
                    method: 'PUT',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success || data.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.message || 'Status berhasil diperbarui'
                        }).then(() => {
                            $('#modal').modal('hide');
                            location.reload();
                        });
                    } else {
                        // Handle validation errors
                        $('.error-text, .invalid-feedback').text('');
                        $('.is-invalid').removeClass('is-invalid');

                        if (data.errors || data.msgField) {
                            const errors = data.errors || data.msgField;
                            $.each(errors, function(field, messages) {
                                const message = Array.isArray(messages) ? messages[0] : messages;
                                $('#error-' + field).text(message);
                                $('#' + field).addClass('is-invalid');
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: data.message || 'Terjadi kesalahan'
                            });
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: 'Terjadi kesalahan pada server.'
                    });
                });
            } else {
                // Untuk method POST (jika diperlukan)
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
                        if (response.success || response.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message || 'Status berhasil diperbarui'
                            }).then(() => {
                                $('#modal').modal('hide');
                                location.reload();
                            });
                        } else {
                            // Handle validation errors
                            $('.error-text, .invalid-feedback').text('');
                            $('.is-invalid').removeClass('is-invalid');

                            if (response.errors || response.msgField) {
                                const errors = response.errors || response.msgField;
                                $.each(errors, function(field, messages) {
                                    const message = Array.isArray(messages) ? messages[0] : messages;
                                    $('#error-' + field).text(message);
                                    $('#' + field).addClass('is-invalid');
                                });
                            }
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
            }
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