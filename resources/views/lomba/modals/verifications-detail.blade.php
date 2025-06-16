<!-- Modal header -->
<div class="flex items-center justify-between px-4 py-3 border-b rounded-t-xl bg-primary border-gray-200">
    <h3 class="text-sm font-semibold text-white">
        <i class="fa-solid fa-file-circle-check me-1"></i>
        Verifikasi Lomba
    </h3>
    <button type="button" class="text-white bg-transparent text-sm text-center cursor-pointer" data-modal-hide="modal">
        <i class="fa-solid fa-xmark"></i>
        <span class="sr-only">Close modal</span>
    </button>
</div>
<!-- Modal body -->
<section class="p-4 space-y-2">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 border-gray-200 border rounded-lg p-2">
        <img src="{{ $lomba->lomba_poster_url ? Storage::url($lomba->lomba_poster_url) : asset('images/default-poster.png') }}"
            alt="Poster Lomba" class="col-span-1 w-full h-48 object-cover object-top rounded-lg">
        <div class="col-span-3 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="space-y-1">
                <label class="block text-xs font-medium text-gray-600">Nama Lomba</label>
                <p class="text-sm font-semibold text-gray-900">{{ $lomba->lomba_nama }}</p>
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-medium text-gray-600">Kategori Lomba</label>
                <p class="text-sm font-semibold text-gray-900">{{ $lomba->lomba_kategori }}</p>
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-medium text-gray-600">Penyelenggara Lomba</label>
                <p class="text-sm font-semibold text-gray-900">{{ $lomba->lomba_penyelenggara }}</p>
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-medium text-gray-600">Pendaftaran Lomba</label>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $lomba->lomba_mulai_pendaftaran }} - {{ $lomba->lomba_akhir_pendaftaran }}
                </p>
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-medium text-gray-600">Pelaksanaan Lomba</label>
                <p class="text-sm font-semibold text-gray-900">
                    {{ $lomba->lomba_mulai_pelaksanaan }} - {{ $lomba->lomba_selesai_pelaksanaan }}
                </p>
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-medium text-gray-600">Status Lomba</label>
                <p class="text-sm font-semibold text-gray-900">{{ $lomba->lomba_status }}</p>
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-medium text-gray-600">Periode Lomba</label>
                <p class="text-sm font-semibold text-gray-900">{{ $lomba->periode->periode_nama ?? '-' }}</p>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <label class="block text-xs font-medium text-gray-600 mb-1">Persyaratan Lomba</label>
        <div class="bg-gray-50 rounded-lg p-3">
            <p class="text-gray-900 text-sm leading-relaxed">{{ $lomba->lomba_persyaratan }}</p>
        </div>
    </div>
    <form id="form" action="{{ route('admin.manajemen.lomba.verification.verify', $lomba->lomba_id) }}"
        method="POST" class="flex flex-row gap-4 items-center mt-4">
        @csrf
        <input type="hidden" name="verification_action" id="verification_action" value="">

        <x-forms.textarea name="catatan_verifikasi" label="Catatan"
            placeholder="Masukkan catatan verifikasi di sini..." value="{{ $lomba->catatan_verifikasi }}"
            rows="4" />

        <div class="flex flex-col gap-3">
            <div class="">
                <label class="block text-xs font-medium text-gray-600">Status Lomba</label>
                <p class="text-sm font-semibold text-gray-900">{{ $lomba->lomba_status }}</p>
            </div>
            <div class="flex flex-row gap-2">
                <x-buttons.default type="button" id="btn-tolak" title="Tolak" color="danger"
                    icon="fa-solid fa-square-xmark" />
                <x-buttons.default type="button" id="btn-setuju" title="Setuju" color="success"
                    icon="fa-solid fa-square-check" />
            </div>
        </div>
    </form>
</section>

<script>
    $(document).ready(function() {
        let currentAction = '';

        $("#form").validate({
            rules: {
                catatan_verifikasi: {
                    required: function() {
                        return currentAction === 'tolak';
                    },
                    minlength: function() {
                        return currentAction === 'tolak' ? 10 : 0;
                    }
                }
            },
            messages: {
                catatan_verifikasi: {
                    required: "Catatan wajib diisi saat menolak lomba.",
                    minlength: "Catatan minimal 10 karakter."
                }
            },
            submitHandler: function(form, event) {
                event.preventDefault();

                // Konfirmasi sebelum submit
                const actionText = currentAction === 'setuju' ? 'menerima' : 'menolak';
                const confirmText = `Apakah Anda yakin ingin ${actionText} lomba ini?`;

                Swal.fire({
                    title: 'Konfirmasi',
                    text: confirmText,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: currentAction === 'setuju' ? '#10B981' : '#EF4444',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Ya, ' + actionText,
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitForm(form);
                    }
                });

                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('fieldset').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        // Event handler untuk button Tolak
        $('#btn-tolak').on('click', function() {
            currentAction = 'tolak';
            $('#verification_action').val('tolak');

            // Tambahkan visual indicator bahwa catatan wajib diisi
            const $catatanField = $('#catatan_verifikasi');
            const $label = $('label[for="catatan_verifikasi"]');

            if (!$label.find('.text-red-500').length) {
                $label.append('<span class="text-red-500" aria-label="required">*</span>');
            }

            $catatanField.focus();

            $('#form').submit();
        });

        $('#btn-setuju').on('click', function() {
            currentAction = 'setuju';
            $('#verification_action').val('setuju');

            $('label[for="catatan_verifikasi"] .text-red-500').remove();

            $('#form').submit();
        });

        function submitForm(form) {
            const formAction = form.action;
            const formMethod = form.method || 'POST';
            const formData = new FormData(form);

            Swal.fire({
                title: 'Memproses...',
                html: 'Mohon tunggu sebentar',
                allowEscapeKey: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: formAction,
                type: formMethod,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.close();

                    if (response.status) {
                        const actionText = currentAction === 'setuju' ? 'disetujui' : 'ditolak';

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: `Lomba berhasil ${actionText}!`,
                            confirmButtonColor: '#10B981'
                        }).then(() => {
                            if (typeof disposeModal === 'function') {
                                disposeModal();
                            }
                            if (typeof reloadDataTable === 'function') {
                                reloadDataTable();
                            }
                        });
                    } else {
                        // Clear previous errors
                        $('.error-text, .invalid-feedback').text('');
                        $('.is-invalid').removeClass('is-invalid');

                        // Show field errors
                        if (response.msgField) {
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

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message ||
                                'Terjadi kesalahan saat memproses data.',
                            confirmButtonColor: '#EF4444'
                        });
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    console.log(xhr);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Terjadi kesalahan sistem. Silakan coba lagi.',
                        confirmButtonColor: '#EF4444'
                    });
                }
            });
        }

        $('#form textarea').on('input', function() {
            const fieldId = $(this).attr('id');
            $('#error-' + fieldId).text('');
            $(this).removeClass('is-invalid');
        });

        $(document).on('shown.bs.modal', function() {
            currentAction = '';
            $('#verification_action').val('');
            $('label[for="catatan_verifikasi"] .text-red-500').remove();
            $('.error-text, .invalid-feedback').text('');
            $('.is-invalid').removeClass('is-invalid');
        });
    });
</script>