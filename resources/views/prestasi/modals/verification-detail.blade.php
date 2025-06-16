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
<section class="p-6 space-y-6 max-h-[80vh] overflow-y-auto">
    <!-- Competition Info Card -->
    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <div class="lg:col-span-1">
                <img src="{{ $prestasi->kelompok->lomba->lomba_poster_url ? Storage::url($prestasi->kelompok->lomba->lomba_poster_url) : asset('images/default-poster.png') }}"
                    alt="Competition Poster" class="w-full h-48 object-cover rounded-lg shadow-sm">
            </div>
            <div class="lg:col-span-3">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Nama
                            Lomba</label>
                        <p class="text-sm font-semibold text-gray-900 leading-relaxed">
                            {{ $prestasi->kelompok->lomba->lomba_nama }}</p>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Kategori</label>
                        <p class="text-sm font-semibold text-gray-900">{{ $prestasi->kelompok->lomba->lomba_kategori }}
                        </p>
                    </div>
                    <div class="space-y-2">
                        <label
                            class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Penyelenggara</label>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $prestasi->kelompok->lomba->lomba_penyelenggara }}</p>
                    </div>
                    <div class="space-y-2">
                        <label
                            class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Pendaftaran</label>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ date('d M Y', strtotime($prestasi->kelompok->lomba->lomba_mulai_pendaftaran)) }} -
                            {{ date('d M Y', strtotime($prestasi->kelompok->lomba->lomba_akhir_pendaftaran)) }}
                        </p>
                    </div>
                    <div class="space-y-2">
                        <label
                            class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Pelaksanaan</label>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ date('d M Y', strtotime($prestasi->kelompok->lomba->lomba_mulai_pelaksanaan)) }} -
                            {{ date('d M Y', strtotime($prestasi->kelompok->lomba->lomba_selesai_pelaksanaan)) }}
                        </p>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Status</label>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $prestasi->kelompok->lomba->lomba_status }}
                        </span>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <div class="space-y-2">
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide">Periode</label>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $prestasi->kelompok->lomba->periode->periode_nama }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Info -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Nama Kelompok</label>
            <p class="text-lg font-semibold text-gray-900">{{ $prestasi->kelompok->kelompok_nama }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Juara</label>
            <span
                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                🏆 {{ $prestasi->prestasi_juara }}
            </span>
        </div>
    </div>

    <!-- Team Members -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Supervisor -->
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <h4 class="text-sm font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fa-solid fa-chalkboard-teacher mr-2 text-primary"></i>
                Dosen Pembimbing
            </h4>
            <div class="flex items-center space-x-3">
                <img class="w-12 h-12 rounded-full object-cover border-2 border-gray-200"
                    src="{{ $prestasi->kelompok->dosen_pembimbing_peran->dosen_pembimbing->user->foto_profil_url ? Storage::url($prestasi->kelompok->dosen_pembimbing_peran->dosen_pembimbing->user->foto_profil_url) : asset('images/default-profile.svg') }}"
                    alt="Supervisor Avatar">
                <div class="flex-1">
                    <p class="text-sm font-bold text-gray-900">
                        {{ $prestasi->kelompok->dosen_pembimbing_peran->dosen_pembimbing->user->getCurrentData()->nama }}
                    </p>
                    <p class="text-xs text-gray-600">
                        {{ $prestasi->kelompok->dosen_pembimbing_peran->dosen_pembimbing->nip }}
                    </p>
                    <span class="inline-block mt-1 px-2 py-0.5 bg-blue-100 text-blue-800 text-xs rounded-full">
                        {{ $prestasi->kelompok->dosen_pembimbing_peran->peran_nama }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Students -->
        <div class="bg-white border border-gray-200 rounded-lg p-4">
            <h4 class="text-sm font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fa-solid fa-users mr-2 text-primary"></i>
                Mahasiswa
            </h4>
            <div class="space-y-3">
                @foreach ($prestasi->kelompok->mahasiswa_perans as $mahasiswa_peran)
                    <div class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 transition-colors">
                        <img class="w-10 h-10 rounded-full object-cover border-2 border-gray-200"
                            src="{{ $mahasiswa_peran->mahasiswa->user->foto_profil_url ? Storage::url($mahasiswa_peran->mahasiswa->user->foto_profil_url) : asset('images/default-profile.svg') }}"
                            alt="Student Avatar">
                        <div class="flex-1">
                            <p class="text-sm font-bold text-gray-900">
                                {{ $mahasiswa_peran->mahasiswa->user->getCurrentData()->nama }}
                            </p>
                            <p class="text-xs text-gray-600">
                                {{ $mahasiswa_peran->mahasiswa->nim }}
                            </p>
                        </div>
                        <span class="px-2 py-0.5 bg-green-100 text-green-800 text-xs rounded-full">
                            {{ $mahasiswa_peran->peran_nama }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Documents -->
    <div class="bg-white border border-gray-200 rounded-lg p-4">
        <h4 class="text-sm font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fa-solid fa-folder-open mr-2 text-primary"></i>
            Dokumen Prestasi
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Surat Tugas -->
            <div class="space-y-3">
                <h5 class="text-xs font-medium text-gray-700 uppercase tracking-wide">Surat Tugas</h5>
                @if ($prestasi->prestasi_surat_tugas_url && Storage::exists($prestasi->prestasi_surat_tugas_url))
                    <div class="border rounded-lg overflow-hidden shadow-sm">
                        <div class="bg-red-50 p-3 flex items-center justify-center h-32">
                            <i class="fa-solid fa-file-pdf text-red-600 text-3xl"></i>
                        </div>
                        <div class="p-3 bg-white">
                            <a href="{{ Storage::url($prestasi->prestasi_surat_tugas_url) }}" target="_blank"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                                <i class="fa-solid fa-external-link-alt mr-1"></i>
                                View PDF
                            </a>
                        </div>
                    </div>
                @else
                    <div
                        class="h-32 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center">
                        <span class="text-gray-400 text-sm">No file</span>
                    </div>
                @endif
            </div>

            <!-- Foto Juara -->
            <div class="space-y-3">
                <h5 class="text-xs font-medium text-gray-700 uppercase tracking-wide">Foto Juara</h5>
                <div class="border rounded-lg overflow-hidden shadow-sm">
                    <img src="{{ $prestasi->prestasi_foto_juara_url && Storage::exists($prestasi->prestasi_foto_juara_url)
                        ? Storage::url($prestasi->prestasi_foto_juara_url)
                        : asset('images/default-poster.png') }}"
                        alt="Achievement Photo" class="w-full h-32 object-cover" loading="lazy"
                        onerror="this.src='{{ asset('images/default-poster.png') }}'">
                </div>
            </div>

            <!-- Proposal -->
            <div class="space-y-3">
                <h5 class="text-xs font-medium text-gray-700 uppercase tracking-wide">Proposal</h5>
                @if ($prestasi->prestasi_proposal_url && Storage::exists($prestasi->prestasi_proposal_url))
                    <div class="border rounded-lg overflow-hidden shadow-sm">
                        <div class="bg-blue-50 p-3 flex items-center justify-center h-32">
                            <i class="fa-solid fa-file-pdf text-blue-600 text-3xl"></i>
                        </div>
                        <div class="p-3 bg-white">
                            <a href="{{ Storage::url($prestasi->prestasi_proposal_url) }}" target="_blank"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                                <i class="fa-solid fa-external-link-alt mr-1"></i>
                                View PDF
                            </a>
                        </div>
                    </div>
                @else
                    <div
                        class="h-32 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center">
                        <span class="text-gray-400 text-sm">No file</span>
                    </div>
                @endif
            </div>

            <!-- Sertifikat -->
            <div class="space-y-3">
                <h5 class="text-xs font-medium text-gray-700 uppercase tracking-wide">Sertifikat</h5>
                @if ($prestasi->prestasi_sertifikat_url && Storage::exists($prestasi->prestasi_sertifikat_url))
                    <div class="border rounded-lg overflow-hidden shadow-sm">
                        <div class="bg-green-50 p-3 flex items-center justify-center h-32">
                            <i class="fa-solid fa-file-pdf text-green-600 text-3xl"></i>
                        </div>
                        <div class="p-3 bg-white">
                            <a href="{{ Storage::url($prestasi->prestasi_sertifikat_url) }}" target="_blank"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                                <i class="fa-solid fa-external-link-alt mr-1"></i>
                                View PDF
                            </a>
                        </div>
                    </div>
                @else
                    <div
                        class="h-32 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center">
                        <span class="text-gray-400 text-sm">No file</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Verification Form -->
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
        <h4 class="text-sm font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fa-solid fa-clipboard-check mr-2 text-primary"></i>
            Verifikasi Prestasi
        </h4>

        <form id="form"
            action="{{ route('admin.manajemen.prestasi.verification.verify', $prestasi->prestasi_id) }}"
            method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="verification_action" id="verification_action" value="">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    <x-forms.textarea name="prestasi_catatan" label="Catatan Verifikasi"
                        placeholder="Masukkan catatan verifikasi di sini..."
                        value="{{ $prestasi->prestasi_catatan }}" rows="4" />
                </div>

                <div class="space-y-4">
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Status Saat
                            Ini</label>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                            @if ($prestasi->prestasi_status == 'Disetujui') bg-green-100 text-green-800
                            @elseif($prestasi->prestasi_status == 'Ditolak') bg-red-100 text-red-800
                            @else bg-yellow-100 text-yellow-800 @endif">
                            {{ $prestasi->prestasi_status }}
                        </span>
                    </div>

                    <div class="flex flex-col gap-3">
                        <x-buttons.default type="button" id="btn-tolak" title="Tolak Prestasi" color="danger"
                            icon="fa-solid fa-times-circle" class="w-full justify-center" />
                        <x-buttons.default type="button" id="btn-setuju" title="Setujui Prestasi" color="success"
                            icon="fa-solid fa-check-circle" class="w-full justify-center" />
                    </div>
                </div>
            </div>
        </form>
    </div>
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

                const actionText = currentAction === 'setuju' ? 'menerima' : 'menolak';
                const confirmText = `Apakah Anda yakin ingin ${actionText} prestasi ini?`;

                Swal.fire({
                    title: 'Konfirmasi Verifikasi',
                    text: confirmText,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: currentAction === 'setuju' ? '#10B981' : '#EF4444',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: `Ya, ${actionText}`,
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

        $('#btn-tolak').on('click', function() {
            currentAction = 'tolak';
            $('#verification_action').val('tolak');

            const $catatanField = $('#prestasi_catatan');
            const $label = $('label[for="prestasi_catatan"]');

            if (!$label.find('.text-red-500').length) {
                $label.append('<span class="text-red-500 ml-1" aria-label="required">*</span>');
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
