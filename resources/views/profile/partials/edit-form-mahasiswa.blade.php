<form id="form" method="POST" action="{{ $action }}" enctype="multipart/form-data" data-reload-table
    class="p-4 md:p-5">
    @csrf

    @if (in_array(strtoupper($method), ['PUT']))
        @method($method)
    @endif

    <div class="space-y-2 mb-4">
        <x-forms.input name="foto_profil_url" type="file" label="Foto Profil" placeholder="Pilih Foto Profil Anda"
            accept="image/*" required />
        <x-forms.input name="nama" label="Nama Lengkap" placeholder="Masukkan Nama Lengkap Anda"
            value="{{ auth()->user()->getCurrentData()->nama ?? '' }}" required />
        <x-forms.input name="email" type="email" label="Email" placeholder="Masukkan Email Anda"
            value="{{ auth()->user()->email ?? '' }}" required />
        <x-forms.select name="lokasi_preferensi" label="Lokasi Preferensi" placeholder="Pilih Lokasi Preferensi"
            :options="$lokasi_preferensis" selected="{{ auth()->user()->getCurrentData()->lokasi_preferensi ?? '' }}" required />
    </div>
    <div class="flex justify-end">
        <x-buttons.default type="submit" title="{{ $buttonText }}" color="primary" icon="{{ $buttonIcon }}" />
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#form").validate({
            rules: {
                nama: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
                lokasi_preferensi: {
                    required: true
                }
            },
            messages: {
                nama: {
                    required: "Nama lengkap harus diisi."
                },
                email: {
                    required: "Email harus diisi.",
                    email: "Format email tidak valid."
                },
                lokasi_preferensi: {
                    required: "Lokasi preferensi harus dipilih."
                }
            },
            submitHandler: function(form, event) {
                event.preventDefault();
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
                                window.location.reload();
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
                                    $('[name="' + prefix + '"]').addClass(
                                        'is-invalid');
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        $('#form input').on('input', function() {
            const fieldId = $(this).attr('id');
            $('#error-' + fieldId).text('');
            $(this).removeClass('is-invalid');
        });

    });
</script>
