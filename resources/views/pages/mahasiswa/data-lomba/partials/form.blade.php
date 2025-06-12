<form id="form" method="POST" action="{{ $action }}" data-reload-table class="p-4 md:p-5">
    @csrf

    @if (in_array(strtoupper($method), ['PUT']))
        @method($method)
    @endif

    <!-- Informasi Dasar Lomba -->
    <div class="mb-6">
        <h4 class="text-md font-semibold text-gray-800 mb-3 flex items-center">
            <i class="fa-solid fa-info-circle me-2 text-primary"></i>
            Informasi Dasar Lomba
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-forms.input name="lomba_nama" label="Nama Lomba" placeholder="Masukkan Nama Lomba"
                    value="{{ $lomba->lomba_nama ?? '' }}" required />
            </div>
            <div>
                <x-forms.input name="lomba_penyelenggara" label="Penyelenggara" placeholder="Masukkan Nama Penyelenggara"
                    value="{{ $lomba->lomba_penyelenggara ?? '' }}" required />
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <div>
                <x-forms.select name="lomba_kategori" label="Kategori" :options="$kategoris" 
                    placeholder="Pilih Kategori" selected="{{ $lomba->lomba_kategori ?? '' }}" required />
            </div>
            <div>
                <x-forms.select name="lomba_tingkat" label="Tingkat" :options="$tingkats" 
                    placeholder="Pilih Tingkat" selected="{{ $lomba->lomba_tingkat ?? '' }}" required />
            </div>
            <div>
                <x-forms.select name="lomba_lokasi_preferensi" label="Lokasi Preferensi" :options="$lokasi_preferensis" 
                    placeholder="Pilih Lokasi" selected="{{ $lomba->lomba_lokasi_preferensi ?? '' }}" required />
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <x-forms.select name="periode_id" label="Periode" :options="$periodes->pluck('periode_nama', 'periode_id')->toArray()" 
                    placeholder="Pilih Periode" selected="{{ $lomba->periode_id ?? '' }}" required />
            </div>
            <div>
                <x-forms.input name="lomba_ukuran_kelompok" label="Ukuran Kelompok" type="number" 
                    placeholder="Masukkan Ukuran Kelompok" value="{{ $lomba->lomba_ukuran_kelompok ?? '1' }}" 
                    min="1" max="10" required />
            </div>
        </div>
    </div>

    <!-- Tanggal dan Waktu -->
    <div class="mb-6">
        <h4 class="text-md font-semibold text-gray-800 mb-3 flex items-center">
            <i class="fa-solid fa-calendar me-2 text-primary"></i>
            Jadwal Lomba
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <x-forms.input name="lomba_mulai_pendaftaran" label="Mulai Pendaftaran" type="date"
                    value="{{ isset($lomba->lomba_mulai_pendaftaran) ? date('Y-m-d', strtotime($lomba->lomba_mulai_pendaftaran)) : '' }}" required />
            </div>
            <div>
                <x-forms.input name="lomba_akhir_pendaftaran" label="Akhir Pendaftaran" type="date"
                    value="{{ isset($lomba->lomba_akhir_pendaftaran) ? date('Y-m-d', strtotime($lomba->lomba_akhir_pendaftaran)) : '' }}" required />
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
                <x-forms.input name="lomba_mulai_pelaksanaan" label="Mulai Pelaksanaan" type="date"
                    value="{{ isset($lomba->lomba_mulai_pelaksanaan) ? date('Y-m-d', strtotime($lomba->lomba_mulai_pelaksanaan)) : '' }}" required />
            </div>
            <div>
                <x-forms.input name="lomba_selesai_pelaksanaan" label="Selesai Pelaksanaan" type="date"
                    value="{{ isset($lomba->lomba_selesai_pelaksanaan) ? date('Y-m-d', strtotime($lomba->lomba_selesai_pelaksanaan)) : '' }}" required />
            </div>
        </div>
    </div>

    <!-- Persyaratan dan Detail -->
    <div class="mb-6">
        <h4 class="text-md font-semibold text-gray-800 mb-3 flex items-center">
            <i class="fa-solid fa-file-text me-2 text-primary"></i>
            Persyaratan dan Detail
        </h4>
        <div class="mb-4">
            <x-forms.textarea name="lomba_persyaratan" label="Persyaratan Lomba" placeholder="Masukkan persyaratan lomba..."
                value="{{ $lomba->lomba_persyaratan ?? '' }}" rows="4" required />
        </div>
        <div>
            <x-forms.input name="lomba_link_registrasi" label="Link Registrasi" type="url" placeholder="https://example.com/register"
                value="{{ $lomba->lomba_link_registrasi ?? '' }}" required />
        </div>
    </div>

    <!-- Status Notice for Edit Mode -->
    @if(isset($lomba) && $lomba->exists)
        <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-400 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <p class="text-blue-800 text-sm">
                    <span class="font-medium">Status saat ini:</span> 
                    @if($lomba->lomba_status == 'Akan datang')
                        <span class="text-yellow-600">Akan Datang</span>
                    @elseif($lomba->lomba_status == 'Sedang berlangsung')
                        <span class="text-green-600">Sedang Berlangsung</span>
                    @elseif($lomba->lomba_status == 'Berakhir')
                        <span class="text-red-600">Berakhir</span>
                    @elseif($lomba->lomba_status == 'Ditolak')
                        <span class="text-gray-600">Ditolak</span>
                    @endif
                </p>
            </div>
        </div>
    @endif

    <div class="flex justify-end">
        <x-buttons.default type="submit" title="{{ $buttonText }}" color="primary" icon="{{ $buttonIcon }}" id="submitBtn" />
    </div>
</form>

<script>
    $(document).ready(function() {
        initializeFormValidation();
        initializeDateValidation();
    });

    function initializeFormValidation() {
        $("#form").validate({
            rules: {
                lomba_nama: {
                    required: true,
                    minlength: 3
                },
                lomba_penyelenggara: {
                    required: true,
                    minlength: 3
                },
                lomba_kategori: {
                    required: true
                },
                lomba_tingkat: {
                    required: true
                },
                lomba_lokasi_preferensi: {
                    required: true
                },
                periode_id: {
                    required: true
                },
                lomba_ukuran_kelompok: {
                    required: true,
                    min: 1,
                    max: 10
                },
                lomba_mulai_pendaftaran: {
                    required: true
                },
                lomba_akhir_pendaftaran: {
                    required: true
                },
                lomba_mulai_pelaksanaan: {
                    required: true
                },
                lomba_selesai_pelaksanaan: {
                    required: true
                },
                lomba_persyaratan: {
                    required: true,
                    minlength: 10
                },
                lomba_link_registrasi: {
                    required: true,
                    url: true
                }
            },
            messages: {
                lomba_nama: {
                    required: "Nama lomba wajib diisi.",
                    minlength: "Nama lomba minimal 3 karakter."
                },
                lomba_penyelenggara: {
                    required: "Penyelenggara wajib diisi.",
                    minlength: "Penyelenggara minimal 3 karakter."
                },
                lomba_kategori: {
                    required: "Kategori wajib dipilih."
                },
                lomba_tingkat: {
                    required: "Tingkat wajib dipilih."
                },
                lomba_lokasi_preferensi: {
                    required: "Lokasi preferensi wajib dipilih."
                },
                periode_id: {
                    required: "Periode wajib dipilih."
                },
                lomba_ukuran_kelompok: {
                    required: "Ukuran kelompok wajib diisi.",
                    min: "Ukuran kelompok minimal 1 orang.",
                    max: "Ukuran kelompok maksimal 10 orang."
                },
                lomba_mulai_pendaftaran: {
                    required: "Tanggal mulai pendaftaran wajib diisi."
                },
                lomba_akhir_pendaftaran: {
                    required: "Tanggal akhir pendaftaran wajib diisi."
                },
                lomba_mulai_pelaksanaan: {
                    required: "Tanggal mulai pelaksanaan wajib diisi."
                },
                lomba_selesai_pelaksanaan: {
                    required: "Tanggal selesai pelaksanaan wajib diisi."
                },
                lomba_persyaratan: {
                    required: "Persyaratan lomba wajib diisi.",
                    minlength: "Persyaratan lomba minimal 10 karakter."
                },
                lomba_link_registrasi: {
                    required: "Link registrasi wajib diisi.",
                    url: "Format URL tidak valid."
                }
            },
            submitHandler: function(form, event) {
                event.preventDefault();

                // Validate date sequence
                if (!validateDateSequence()) {
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
                            if (typeof window.disposeModal === 'function') {
                                window.disposeModal();
                            }
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            }).then(() => {
                                if (typeof window.reloadDataTable === 'function') {
                                    window.reloadDataTable();
                                } else if (typeof reloadDataTable === 'function') {
                                    reloadDataTable();
                                } else {
                                    window.location.reload();
                                }
                            });
                        } else {
                            $('.error-text, .invalid-feedback').text('');
                            $('.is-invalid').removeClass('is-invalid');
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
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        let errorMessage = 'Terjadi kesalahan saat menyimpan data.';
                        
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        });
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group, .mb-4, div').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });

        // Clear errors on input change
        $(document).on('input change', '#form input, #form select', function() {
            const fieldName = $(this).attr('name');
            if (fieldName) {
                $('#error-' + fieldName.replace(/[\[\]]/g, '')).text('');
                $(this).removeClass('is-invalid');
            }
        });
    }

    function initializeDateValidation() {
        // Add change event listeners to date inputs
        $('input[type="date"]').on('change', function() {
            validateDateSequence();
        });
    }

    function validateDateSequence() {
        const mulaiPendaftaran = new Date($('input[name="lomba_mulai_pendaftaran"]').val());
        const akhirPendaftaran = new Date($('input[name="lomba_akhir_pendaftaran"]').val());
        const mulaiPelaksanaan = new Date($('input[name="lomba_mulai_pelaksanaan"]').val());
        const selesaiPelaksanaan = new Date($('input[name="lomba_selesai_pelaksanaan"]').val());
        const now = new Date();

        // Check if all dates are filled
        if (!mulaiPendaftaran || !akhirPendaftaran || !mulaiPelaksanaan || !selesaiPelaksanaan) {
            return true; // Let required validation handle empty fields
        }

        // Check date sequence
        if (mulaiPendaftaran >= akhirPendaftaran) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Tanggal akhir pendaftaran harus setelah tanggal mulai pendaftaran!'
            });
            return false;
        }

        if (akhirPendaftaran >= mulaiPelaksanaan) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Tanggal mulai pelaksanaan harus setelah tanggal akhir pendaftaran!'
            });
            return false;
        }

        if (mulaiPelaksanaan >= selesaiPelaksanaan) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Tanggal selesai pelaksanaan harus setelah tanggal mulai pelaksanaan!'
            });
            return false;
        }

        // Check if start registration is in the future (for new lomba)
        @if(!isset($lomba) || !$lomba->exists)
        if (mulaiPendaftaran <= now) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Tanggal mulai pendaftaran harus di masa depan!'
            });
            return false;
        }
        @endif

        return true;
    }
</script>