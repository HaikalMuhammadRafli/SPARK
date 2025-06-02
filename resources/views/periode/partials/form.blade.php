<form id="form" method="POST" action="{{ $action }}" class="p-4 md:p-5">
    @csrf
    @if (in_array(strtoupper($method), ['PUT']))
        @method($method)
    @endif
    <div class="gap-4 mb-4">
        <x-forms.default-input id="periode_nama" label="Nama Periode"
            placeholder="Masukkan Nama Periode (Contoh: Genap 2023/2024)" value="{{ $periode->periode_nama ?? '' }}"
            isRequired />
    </div>
    <div class="grid grid-cols-2 gap-4 mb-4">
        <x-forms.default-input id="periode_tahun_awal" label="Tahun Awal" type="number"
            placeholder="2023" value="{{ $periode->periode_tahun_awal ?? '' }}" isRequired />
        <x-forms.default-input id="periode_tahun_akhir" label="Tahun Akhir" type="number"
            placeholder="2024" value="{{ $periode->periode_tahun_akhir ?? '' }}" isRequired />
    </div>
    <div class="flex justify-end">
        <x-buttons.default type="submit" title="{{ $buttonText }}" color="primary" icon="{{ $buttonIcon }}" />
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#form").validate({
            rules: {
                periode_nama: {
                    required: true,
                    minlength: 3
                },
                periode_tahun_awal: {
                    required: true,
                    digits: true,
                    min: 2000,
                    max: 2100
                },
                periode_tahun_akhir: {
                    required: true,
                    digits: true,
                    min: 2000,
                    max: 2100
                }
            },
            messages: {
                periode_nama: {
                    required: "Nama Periode wajib diisi.",
                    minlength: "Nama Periode minimal 3 karakter."
                },
                periode_tahun_awal: {
                    required: "Tahun Awal wajib diisi.",
                    digits: "Tahun Awal harus berupa angka.",
                    min: "Tahun Awal minimal 2000.",
                    max: "Tahun Awal maksimal 2100."
                },
                periode_tahun_akhir: {
                    required: "Tahun Akhir wajib diisi.",
                    digits: "Tahun Akhir harus berupa angka.",
                    min: "Tahun Akhir minimal 2000.",
                    max: "Tahun Akhir maksimal 2100."
                }
            },
            submitHandler: function(form, event) {
                event.preventDefault();
                
                // Validasi tambahan
                const tahunAwal = parseInt($('#periode_tahun_awal').val());
                const tahunAkhir = parseInt($('#periode_tahun_akhir').val());
                
                if (tahunAkhir <= tahunAwal) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Error',
                        text: 'Tahun Akhir harus lebih besar dari Tahun Awal!'
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
                                location.reload();
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
                            text: 'Terjadi kesalahan sistem!'
                        });
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

        // Clear error messages on input
        $('#form input').on('input change', function() {
            const fieldId = $(this).attr('id');
            $('#error-' + fieldId).text('');
            $(this).removeClass('is-invalid');
        });

        // Auto-fill tahun akhir when tahun awal changes
        $('#periode_tahun_awal').on('input', function() {
            const tahunAwal = parseInt($(this).val());
            if (tahunAwal && !$('#periode_tahun_akhir').val()) {
                $('#periode_tahun_akhir').val(tahunAwal + 1);
            }
        });
    });
</script>