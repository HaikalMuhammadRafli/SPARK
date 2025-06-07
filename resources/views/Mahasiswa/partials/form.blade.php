<form id="form" method="{{ $method }}" action="{{ $action }}" data-reload-table class="p-4 md:p-5">
    @csrf

    @if (in_array(strtoupper($method), ['PUT']))
        @method($method)
    @endif

    <div class="gap-4 mb-4 grid grid-cols-1 md:grid-cols-2">
        {{-- NIM --}}
        <div>
            <x-forms.input name="nim" label="NIM" placeholder="Masukkan NIM"
                value="{{ $mahasiswa->nim ?? '' }}" required />
            <span id="error-nim" class="text-sm text-red-500 mt-1 block"></span>
        </div>

        {{-- Lokasi Preferensi --}}
        <div>
            <x-forms.input name="lokasi_preferensi" label="Lokasi Preferensi"
                placeholder="Masukkan Lokasi" value="{{ $mahasiswa->lokasi_preferensi ?? '' }}" required />
            <span id="error-lokasi_preferensi" class="text-sm text-red-500 mt-1 block"></span>
        </div>

        {{-- Nama (multiline) --}}
        <div class="md:col-span-2">
            <x-forms.input name="nama" label="Nama" placeholder="Masukkan Nama Lengkap"
                value="{{ $mahasiswa->nama ?? '' }}" rows="3" />
            <span id="error-nama" class="text-sm text-red-500 mt-1 block"></span>
        </div>

        {{-- Prodi ID Dropdown --}}
        <div>
            <x-forms.select name="prodi_id" label="Program Studi" :data="[
                1 => 'D-IV TI',
                2 => 'D-IV SIB',
                3 => 'D-II PPLS',
            ]" :value="$mahasiswa->prodi_id ?? null"
                :required="true" />
            <span id="error-prodi_id" class="text-sm text-red-500 mt-1 block"></span>
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
                nim: {
                    required: true
                },
                nama: {
                    required: true
                },
                lokasi_preferensi: {
                    required: true
                },
                prodi_id: {
                    required: true
                }
            },
            messages: {
                nim: {
                    required: "NIM wajib diisi."
                },
                nama: {
                    required: "Nama wajib diisi."
                },
                lokasi_preferensi: {
                    required: "Lokasi preferensi wajib diisi."
                },
                prodi_id: {
                    required: "Program Studi wajib dipilih."
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
