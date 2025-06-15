<!-- Modal header -->
<div class="flex items-center justify-between px-4 py-3 border-b rounded-t-xl bg-primary border-gray-200">
    <h3 class="text-sm font-semibold text-white">
        <i class="fa-solid fa-file-circle-plus me-1"></i>
        Verification Detail
    </h3>
    <button type="button" class="text-white bg-transparent text-sm text-center cursor-pointer" data-modal-hide="modal">
        <i class="fa-solid fa-xmark"></i>
        <span class="sr-only">Close modal</span>
    </button>
</div>
<!-- Modal body -->
<section class="p-4 space-y-2">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 border-gray-200 border rounded-lg p-2">
        <img src="{{ $prestasi->kelompok->lomba->lomba_poster_url ? Storage::url($prestasi->kelompok->lomba->lomba_poster_url) : asset('images/default-poster.png') }}"
            alt="" class="col-span-1 w-full h-48 object-cover object-top rounded-lg">
        <div class="col-span-3 grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="space-y-1">
                <label class="block text-xs font-medium text-gray-600">Nama Lomba</label>
                <p class="text-sm font-semibold text-gray-900">{{ $prestasi->kelompok->lomba->lomba_nama }}</p>
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-medium text-gray-600">Kategori Lomba</label>
                <p class="text-sm font-semibold text-gray-900">{{ $prestasi->kelompok->lomba->lomba_kategori }}</p>
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-medium text-gray-600">Penyelenggara Lomba</label>
                <p class="text-sm font-semibold text-gray-900">{{ $prestasi->kelompok->lomba->lomba_penyelenggara }}</p>
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-medium text-gray-600">Pendaftaran Lomba</label>
                <p class="text-sm font-semibold text-gray-900">{{ $prestasi->kelompok->lomba->lomba_mulai_pendaftaran }}
                    -
                    {{ $prestasi->kelompok->lomba->lomba_akhir_pendaftaran }}</p>
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-medium text-gray-600">Pelaksanaan Lomba</label>
                <p class="text-sm font-semibold text-gray-900">{{ $prestasi->kelompok->lomba->lomba_mulai_pelaksanaan }}
                    -
                    {{ $prestasi->kelompok->lomba->lomba_selesai_pelaksanaan }}</p>
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-medium text-gray-600">Status Lomba</label>
                <p class="text-sm font-semibold text-gray-900">{{ $prestasi->kelompok->lomba->lomba_status }}</p>
            </div>
            <div class="space-y-1">
                <label class="block text-xs font-medium text-gray-600">Periode Lomba</label>
                <p class="text-sm font-semibold text-gray-900">{{ $prestasi->kelompok->lomba->periode->periode_nama }}
                </p>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="space-y-1">
            <label class="block text-xs font-medium text-gray-600">Nama Kelompok</label>
            <p class="text-sm font-semibold text-gray-900">{{ $prestasi->kelompok->kelompok_nama }}</p>
        </div>
        <div class="space-y-1">
            <label class="block text-xs font-medium text-gray-600">Juara</label>
            <p class="text-sm font-semibold text-gray-900">{{ $prestasi->prestasi_juara }}</p>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <div class="">
                <label class="block text-xs font-medium text-gray-600 mb-1">Dosen Pembimbing</label>
                <div class="flex flex-row">
                    <img class="w-10 h-10 rounded-full"
                        src="{{ $prestasi->kelompok->dosen_pembimbing_peran->dosen_pembimbing->user->foto_profil_url ? Storage::url($kelompok->dosen_pembimbing_peran->dosen_pembimbing->user->foto_profil_url) : asset('images/default-profile.svg') }}"
                        alt="Rounded avatar">
                    <div class="ms-2">
                        <p class="text-sm font-bold text-gray-900">
                            {{ $prestasi->kelompok->dosen_pembimbing_peran->dosen_pembimbing->user->getCurrentData()->nama }}
                        </p>
                        <p class="text-xs text-gray-600">
                            {{ $prestasi->kelompok->dosen_pembimbing_peran->dosen_pembimbing->nip }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="">
                <label class="block text-xs font-medium text-gray-600 mb-1">Peran</label>
                <p class="text-sm font-bold text-gray-900">
                    {{ $prestasi->kelompok->dosen_pembimbing_peran->peran_nama }}
                </p>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            <label class="block text-xs font-medium text-gray-600">Mahasiswa</label>
            <label class="block text-xs font-medium text-gray-600">Peran</label>
            @foreach ($prestasi->kelompok->mahasiswa_perans as $mahasiswa_peran)
                <div class="">
                    <div class="flex flex-row">
                        <img class="w-10 h-10 rounded-full"
                            src="{{ $mahasiswa_peran->mahasiswa->user->foto_profil_url ? Storage::url($mahasiswa_peran->mahasiswa->user->foto_profil_url) : asset('images/default-profile.svg') }}"
                            alt="Rounded avatar">
                        <div class="ms-2">
                            <p class="text-sm font-bold text-gray-900">
                                {{ $mahasiswa_peran->mahasiswa->user->getCurrentData()->nama }}
                            </p>
                            <p class="text-xs text-gray-600">
                                {{ $mahasiswa_peran->mahasiswa->nim }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="">
                    <p class="text-sm font-bold text-gray-900">
                        {{ $mahasiswa_peran->peran_nama }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <!-- Surat Tugas -->
        <div class="flex flex-col space-y-2">
            <h3 class="text-xs font-medium text-gray-700">Surat Tugas</h3>
            @if ($prestasi->prestasi_surat_tugas_url && Storage::exists($prestasi->prestasi_surat_tugas_url))
                <div class="border rounded-lg overflow-hidden">
                    <embed src="{{ Storage::url($prestasi->prestasi_surat_tugas_url) }}" type="application/pdf"
                        class="w-full h-48" title="Surat Tugas PDF">
                    <div class="p-2 bg-gray-50">
                        <a href="{{ Storage::url($prestasi->prestasi_surat_tugas_url) }}" target="_blank"
                            class="text-blue-600 hover:text-blue-800 text-sm">
                            View Full PDF
                        </a>
                    </div>
                </div>
            @else
                <div class="h-48 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center">
                    <span class="text-gray-500 text-sm">No file available</span>
                </div>
            @endif
        </div>

        <!-- Foto Juara -->
        <div class="flex flex-col space-y-2">
            <h3 class="text-xs font-medium text-gray-700">Foto Juara</h3>
            <div class="border rounded-lg overflow-hidden">
                <img src="{{ $prestasi->prestasi_foto_juara_url && Storage::exists($prestasi->prestasi_foto_juara_url)
                    ? Storage::url($prestasi->prestasi_foto_juara_url)
                    : asset('images/default-poster.png') }}"
                    alt="Foto prestasi {{ $prestasi->nama ?? 'achievement' }}" class="w-full h-48 object-cover"
                    loading="lazy" onerror="this.src='{{ asset('images/default-poster.png') }}'">
            </div>
        </div>

        <!-- Proposal -->
        <div class="flex flex-col space-y-2">
            <h3 class="text-xs font-medium text-gray-700">Proposal</h3>
            @if ($prestasi->prestasi_proposal_url && Storage::exists($prestasi->prestasi_proposal_url))
                <div class="border rounded-lg overflow-hidden">
                    <embed src="{{ Storage::url($prestasi->prestasi_proposal_url) }}" type="application/pdf"
                        class="w-full h-48" title="Proposal PDF">
                    <div class="p-2 bg-gray-50">
                        <a href="{{ Storage::url($prestasi->prestasi_proposal_url) }}" target="_blank"
                            class="text-blue-600 hover:text-blue-800 text-sm">
                            View Full PDF
                        </a>
                    </div>
                </div>
            @else
                <div class="h-48 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center">
                    <span class="text-gray-500 text-sm">No file available</span>
                </div>
            @endif
        </div>

        <!-- Sertifikat -->
        <div class="flex flex-col space-y-2">
            <h3 class="text-xs font-medium text-gray-700">Sertifikat</h3>
            @if ($prestasi->prestasi_sertifikat_url && Storage::exists($prestasi->prestasi_sertifikat_url))
                <div class="border rounded-lg overflow-hidden">
                    <embed src="{{ Storage::url($prestasi->prestasi_sertifikat_url) }}" type="application/pdf"
                        class="w-full h-48" title="Sertifikat PDF">
                    <div class="p-2 bg-gray-50">
                        <a href="{{ Storage::url($prestasi->prestasi_sertifikat_url) }}" target="_blank"
                            class="text-blue-600 hover:text-blue-800 text-sm">
                            View Full PDF
                        </a>
                    </div>
                </div>
            @else
                <div class="h-48 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center">
                    <span class="text-gray-500 text-sm">No file available</span>
                </div>
            @endif
        </div>
    </div>
    <form id="form" action="{{ route('admin.manajemen.prestasi.verification.verify', $prestasi->prestasi_id) }}"
        method="POST" class="flex flex-row gap-4 items-center">
        @csrf
        <input type="hidden" name="verification_action" id="verification_action" value="">

        <x-forms.textarea name="prestasi_catatan" label="Catatan"
            placeholder="Masukkan catatan verifikasi di sini..." value="{{ $prestasi->prestasi_catatan }}"
            rows="4" />

        <div class="flex flex-col gap-3">
            <div class="">
                <label class="block text-xs font-medium text-gray-600">Status Prestasi</label>
                <p class="text-sm font-semibold text-gray-900">{{ $prestasi->prestasi_status }}</p>
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
                prestasi_catatan: {
                    required: function() {
                        return currentAction === 'tolak';
                    }
                }
            },
            messages: {
                prestasi_catatan: {
                    required: "Catatan wajib diisi saat menolak prestasi."
                }
            },
            submitHandler: function(form, event) {
                event.preventDefault();

                // Konfirmasi sebelum submit
                const actionText = currentAction === 'setuju' ? 'menerima' : 'menolak';
                const confirmText = `Apakah Anda yakin ingin ${actionText} prestasi ini?`;

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
            const $catatanField = $('#prestasi_catatan');
            const $label = $('label[for="prestasi_catatan"]');

            if (!$label.find('.text-red-500').length) {
                $label.append('<span class="text-red-500" aria-label="required">*</span>');
            }

            $catatanField.focus();

            $('#form').submit();
        });

        $('#btn-setuju').on('click', function() {
            currentAction = 'setuju';
            $('#verification_action').val('setuju');

            $('label[for="prestasi_catatan"] .text-red-500').remove();

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
                            text: `Prestasi berhasil ${actionText}!`,
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
                        $.each(response.msgField, function(prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                            const $field = $('#' + prefix);
                            if ($field.length) {
                                $field.addClass('is-invalid');
                            } else {
                                $('[name="' + prefix + '"]').addClass('is-invalid');
                            }
                        });

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
            $('label[for="prestasi_catatan"] .text-red-500').remove();
            $('.error-text, .invalid-feedback').text('');
            $('.is-invalid').removeClass('is-invalid');
        });
    });
</script>
