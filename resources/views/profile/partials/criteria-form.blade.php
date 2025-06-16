<form id="form" method="POST" action="{{ $action }}" class="p-4 md:p-5">
    @csrf

    @if (in_array(strtoupper($method), ['PUT']))
        @method($method)
    @endif

    <div class="mb-4 w-full">
        <x-forms.checkbox-dropdown title="{{ $title }}" name="{{ $nama }}[]" :options="$datas->pluck($nama . '_nama', $nama . '_id')->toArray()"
            searchable="true" />
    </div>
    <div class="flex justify-end">
        <x-buttons.default type="submit" title="{{ $buttonText }}" color="primary" icon="{{ $buttonIcon }}" />
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#form").validate({
            rules: {
                "{{ $nama }}[]": {
                    required: true,
                    minlength: 1
                }
            },
            messages: {
                "{{ $nama }}[]": {
                    required: "{{ $title }} wajib dipilih minimal satu.",
                    minlength: "{{ $title }} wajib dipilih minimal satu."
                }
            },
            submitHandler: function(form, event) {
                event.preventDefault();

                var formData = new FormData(form);
                var selectedItems = $('input[name="{{ $nama }}[]"]:checked').length;
                if (selectedItems === 0) {
                    $('#error-{{ $nama }}').text(
                        '{{ $title }} wajib dipilih minimal satu.');
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
                            disposeModal('edit_modal');
                            disposeModal('criteria_modal');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            }).then(() => {
                                disposeModal('edit_modal');
                                disposeModal('criteria_modal');
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

        $('input[name="{{ $nama }}[]"]').on('change', function() {
            $('#error-{{ $nama }}').text('');
            $(this).removeClass('is-invalid');
        });
    });
</script>
