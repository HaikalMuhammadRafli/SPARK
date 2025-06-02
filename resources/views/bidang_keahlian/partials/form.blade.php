<form id="form" method="POST" action="{{ $action }}" data-reload-table class="p-4 md:p-5">
    @csrf

    @if (in_array(strtoupper($method), ['PUT']))
        @method($method)
    @endif

    <div class="gap-4 mb-4">
        <x-forms.default-input id="bidang_keahlian_nama" label="Nama Bidang Lomba"
            placeholder="Masukkan Nama Bidang Keahlian" value="{{ $bidang_keahlian->bidang_keahlian_nama ?? '' }}"
            isRequired />
    </div>
    <div class="flex justify-end">
        <x-buttons.default type="submit" title="{{ $buttonText }}" color="primary" icon="{{ $buttonIcon }}" />
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#form").validate({
            rules: {
                bidang_keahlian_nama: {
                    required: true
                },
            },
            messages: {
                bidang_keahlian_nama: {
                    required: "Nama Bidang Keahlian wajib diisi."
                },
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
