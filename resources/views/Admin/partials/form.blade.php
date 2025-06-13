<form id="form" method="{{ $method }}" action="{{ $action }}" data-reload-table class="p-4 md:p-5">
    @csrf

    @if (in_array(strtoupper($method), ['PUT']))
        @method($method)
    @endif

    <div class="gap-4 mb-4 grid grid-cols-1 md:grid-cols-2">
        {{-- NIP --}}
        @if ($method !== 'PUT')
            <div>
                <x-forms.default-input id="nip" name="nip" label="NIP" placeholder="Masukkan NIP"
                    value="{{ $admin->nip ?? '' }}" isRequired />
                <span id="error-nip" class="text-sm text-red-500 mt-1 block"></span>
            </div>
        @endif

        {{-- Nama (multiline) --}}
        <div class="md:col-span-2">
            <x-forms.default-input id="nama" name="nama" label="Nama" placeholder="Masukkan Nama Lengkap"
                value="{{ $admin->nama ?? '' }}" rows="3" />
            <span id="error-nama" class="text-sm text-red-500 mt-1 block"></span>
        </div>

    </div>

    <div class="flex justify-end">
        <x-buttons.default type="submit" title="{{ $buttonText }}" color="primary" icon="{{ $buttonIcon }}" />
    </div>
</form>
<script>
    $(document).ready(function() {
        $("#form").validate({
            rules: {
                nip: {
                    required: true
                },
                nama: {
                    required: true
                }
            },
            messages: {
                nip: {
                    required: "NIP wajib diisi."
                },
                nama: {
                    required: "Nama wajib diisi."
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

                // Extract form values to a JSON object
                const payload = {};
                $(form).find('input, select, textarea').each(function() {
                    const name = $(this).attr('name');
                    if (name && !['_token', '_method'].includes(name)) {
                        payload[name] = $(this).val();
                    }
                });

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

        // Clear error message on input
        $('#form input, #form select, #form textarea').on('input', function() {
            const fieldId = $(this).attr('id');
            $('#error-' + fieldId).text('');
            $(this).removeClass('is-invalid');
        });
    });
</script>
