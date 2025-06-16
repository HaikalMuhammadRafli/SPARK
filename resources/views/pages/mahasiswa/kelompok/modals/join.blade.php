<!-- Modal header -->
<div class="flex items-center justify-between px-4 py-3 border-b rounded-t-xl bg-primary border-gray-200">
    <h3 class="text-sm font-semibold text-white">
        <i class="fa-solid fa-file-circle-plus me-1"></i>
        Pilih kompetensi anda untuk kelompok ini
    </h3>
    <button type="button" class="text-white bg-transparent text-sm text-center cursor-pointer"
        data-modal-hide="small-modal">
        <i class="fa-solid fa-xmark"></i>
        <span class="sr-only">Close modal</span>
    </button>
</div>
<!-- Modal body -->
<form id="form" method="POST" action="{{ route('mahasiswa.kelompok.join', $kelompok->kelompok_id) }}"
    class="p-4">
    @csrf

    <div class="mb-4 w-full">
        <x-forms.checkbox-dropdown title="Pilih kompetensi" name="kompetensi[]" :options="$kompetensis->pluck('kompetensi_nama', 'kompetensi_id')->toArray()" searchable="true" />
    </div>
    <div class="flex justify-end">
        <x-buttons.default type="submit" title="Bergabung" color="primary" icon="fa-solid fa-arrow-right-to-bracket" />
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#form").validate({
            rules: {
                "kompetensi[]": {
                    required: true,
                    minlength: 1
                }
            },
            messages: {
                "kompetensi[]": {
                    required: "Kompetensi wajib dipilih minimal satu.",
                    minlength: "Kompetensi wajib dipilih minimal satu."
                }
            },
            submitHandler: function(form, event) {
                event.preventDefault();

                var formData = new FormData(form);
                var selectedItems = $('input[name="kompetensi[]"]:checked').length;
                if (selectedItems === 0) {
                    $('#error-kompetensi').text(
                        'Kompetensi wajib dipilih minimal satu.');
                    return false;
                }

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

        $('input[name="kompetensi[]"]').on('change', function() {
            $('#error-kompetensi').text('');
            $(this).removeClass('is-invalid');
        });
    });
</script>
