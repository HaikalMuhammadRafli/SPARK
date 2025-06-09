<form id="form" method="POST" action="{{ $action }}" data-reload-table class="p-4 md:p-5" enctype="multipart/form-data">
    @csrf

    @if (in_array(strtoupper($method), ['PUT']))
        @method($method)
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <!-- Nama Lomba -->
        <div class="md:col-span-2">
            <x-forms.default-input id="lomba_nama" label="Nama Lomba"
                placeholder="Masukkan Nama Lomba" value="{{ $lomba->lomba_nama ?? '' }}"
                isRequired />
        </div>

        <!-- Kategori -->
        <div>
            <x-forms.default-input id="lomba_kategori" label="Kategori Lomba"
                placeholder="Masukkan Kategori Lomba" value="{{ $lomba->lomba_kategori ?? '' }}"
                isRequired />
        </div>

        <!-- Penyelenggara -->
        <div>
            <x-forms.default-input id="lomba_penyelenggara" label="Penyelenggara"
                placeholder="Masukkan Penyelenggara" value="{{ $lomba->lomba_penyelenggara ?? '' }}"
                isRequired />
        </div>

        <!-- Tingkat -->
        <div>
            <label for="lomba_tingkat" class="block text-sm font-medium text-gray-900 mb-2">
                Tingkat Lomba <span class="text-red-500">*</span>
            </label>
            <select id="lomba_tingkat" name="lomba_tingkat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                <option value="">Pilih Tingkat</option>
                <option value="Lokal" {{ (isset($lomba) && $lomba->lomba_tingkat == 'Lokal') ? 'selected' : '' }}>Lokal</option>
                <option value="Regional" {{ (isset($lomba) && $lomba->lomba_tingkat == 'Regional') ? 'selected' : '' }}>Regional</option>
                <option value="Nasional" {{ (isset($lomba) && $lomba->lomba_tingkat == 'Nasional') ? 'selected' : '' }}>Nasional</option>
                <option value="Internasional" {{ (isset($lomba) && $lomba->lomba_tingkat == 'Internasional') ? 'selected' : '' }}>Internasional</option>
            </select>
            <span id="error-lomba_tingkat" class="error-text text-red-500 text-xs"></span>
        </div>

        <!-- Lokasi -->
        <div>
            <x-forms.default-input id="lomba_lokasi_preferensi" label="Lokasi Lomba"
                placeholder="Masukkan Lokasi Lomba" value="{{ $lomba->lomba_lokasi_preferensi ?? '' }}"
                isRequired />
        </div>

        <!-- Periode -->
        <div>
            <label for="periode_id" class="block text-sm font-medium text-gray-900 mb-2">
                Periode <span class="text-red-500">*</span>
            </label>
            <select id="periode_id" name="periode_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                <option value="">Pilih Periode</option>
                @foreach($periodes as $periode)
                    <option value="{{ $periode->periode_id }}" {{ (isset($lomba) && $lomba->periode_id == $periode->periode_id) ? 'selected' : '' }}>
                        {{ $periode->periode_nama }}
                    </option>
                @endforeach
            </select>
            <span id="error-periode_id" class="error-text text-red-500 text-xs"></span>
        </div>

        <!-- Tanggal Mulai Pendaftaran -->
        <div>
            <label for="lomba_mulai_pendaftaran" class="block text-sm font-medium text-gray-900 mb-2">
                Mulai Pendaftaran <span class="text-red-500">*</span>
            </label>
            <input type="date" id="lomba_mulai_pendaftaran" name="lomba_mulai_pendaftaran" 
                value="{{ isset($lomba) && $lomba->lomba_mulai_pendaftaran ? $lomba->lomba_mulai_pendaftaran->format('Y-m-d') : '' }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            <span id="error-lomba_mulai_pendaftaran" class="error-text text-red-500 text-xs"></span>
        </div>

        <!-- Tanggal Akhir Pendaftaran -->
        <div>
            <label for="lomba_akhir_pendaftaran" class="block text-sm font-medium text-gray-900 mb-2">
                Akhir Pendaftaran <span class="text-red-500">*</span>
            </label>
            <input type="date" id="lomba_akhir_pendaftaran" name="lomba_akhir_pendaftaran" 
                value="{{ isset($lomba) && $lomba->lomba_akhir_pendaftaran ? $lomba->lomba_akhir_pendaftaran->format('Y-m-d') : '' }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            <span id="error-lomba_akhir_pendaftaran" class="error-text text-red-500 text-xs"></span>
        </div>

        <!-- Status -->
        <div>
            <label for="lomba_status" class="block text-sm font-medium text-gray-900 mb-2">
                Status <span class="text-red-500">*</span>
            </label>
            <select id="lomba_status" name="lomba_status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                <option value="">Pilih Status</option>
                <option value="buka" {{ (isset($lomba) && $lomba->lomba_status == 'buka') ? 'selected' : '' }}>Buka</option>
                <option value="tutup" {{ (isset($lomba) && $lomba->lomba_status == 'tutup') ? 'selected' : '' }}>Tutup</option>
                <option value="selesai" {{ (isset($lomba) && $lomba->lomba_status == 'selesai') ? 'selected' : '' }}>Selesai</option>
            </select>
            <span id="error-lomba_status" class="error-text text-red-500 text-xs"></span>
        </div>

        <!-- Poster Upload -->
        <div class="md:col-span-2">
            <label for="lomba_poster" class="block text-sm font-medium text-gray-900 mb-2">
                Poster Lomba
            </label>
            <input type="file" id="lomba_poster" name="lomba_poster" accept="image/*"
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
            <p class="mt-1 text-sm text-gray-500">PNG, JPG, JPEG (MAX. 2MB)</p>
            <span id="error-lomba_poster" class="error-text text-red-500 text-xs"></span>
            
            @if(isset($lomba) && $lomba->lomba_poster_url)
                <div class="mt-2">
                    <p class="text-sm text-gray-600 mb-2">Poster saat ini:</p>
                    <img src="{{ asset('storage/' . $lomba->lomba_poster_url) }}" alt="Current Poster" class="w-32 h-32 object-cover rounded-lg border">
                </div>
            @endif
        </div>

        <!-- Deskripsi -->
        <div class="md:col-span-2">
            <label for="lomba_deskripsi" class="block text-sm font-medium text-gray-900 mb-2">
                Deskripsi Lomba
            </label>
            <textarea id="lomba_deskripsi" name="lomba_deskripsi" rows="4" 
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                placeholder="Masukkan deskripsi lomba...">{{ $lomba->lomba_deskripsi ?? '' }}</textarea>
            <span id="error-lomba_deskripsi" class="error-text text-red-500 text-xs"></span>
        </div>
    </div>

    <div class="flex justify-end">
        <x-buttons.default type="submit" title="{{ $buttonText }}" color="primary" icon="{{ $buttonIcon }}" />
    </div>
</form>

<script>
    $(document).ready(function() {
        // File validation function
        function validateFile(file) {
            const maxSize = 2 * 1024 * 1024; // 2MB
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            
            if (file.size > maxSize) {
                return 'Ukuran file maksimal 2MB.';
            }
            
            if (!allowedTypes.includes(file.type)) {
                return 'Format file harus JPG, JPEG, atau PNG.';
            }
            
            return null;
        }

        $("#form").validate({
            rules: {
                lomba_nama: {
                    required: true,
                    minlength: 3
                },
                lomba_kategori: {
                    required: true
                },
                lomba_penyelenggara: {
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
                lomba_mulai_pendaftaran: {
                    required: true,
                    date: true
                },
                lomba_akhir_pendaftaran: {
                    required: true,
                    date: true
                },
                lomba_status: {
                    required: true
                },
                lomba_poster: {
                    accept: "image/*"
                }
            },
            messages: {
                lomba_nama: {
                    required: "Nama lomba wajib diisi.",
                    minlength: "Nama lomba minimal 3 karakter."
                },
                lomba_kategori: {
                    required: "Kategori lomba wajib diisi."
                },
                lomba_penyelenggara: {
                    required: "Penyelenggara wajib diisi."
                },
                lomba_tingkat: {
                    required: "Tingkat lomba wajib dipilih."
                },
                lomba_lokasi_preferensi: {
                    required: "Lokasi lomba wajib diisi."
                },
                periode_id: {
                    required: "Periode wajib dipilih."
                },
                lomba_mulai_pendaftaran: {
                    required: "Tanggal mulai pendaftaran wajib diisi.",
                    date: "Format tanggal tidak valid."
                },
                lomba_akhir_pendaftaran: {
                    required: "Tanggal akhir pendaftaran wajib diisi.",
                    date: "Format tanggal tidak valid."
                },
                lomba_status: {
                    required: "Status lomba wajib dipilih."
                },
                lomba_poster: {
                    accept: "File harus berupa gambar (PNG, JPG, JPEG)."
                }
            },
            submitHandler: function(form, event) {
                event.preventDefault();
                
                // Validate end date is after start date
                const startDate = new Date($('#lomba_mulai_pendaftaran').val());
                const endDate = new Date($('#lomba_akhir_pendaftaran').val());
                
                if (endDate <= startDate) {
                    $('#error-lomba_akhir_pendaftaran').text('Tanggal akhir harus setelah tanggal mulai pendaftaran.');
                    $('#lomba_akhir_pendaftaran').addClass('is-invalid');
                    return false;
                }
                
                // Validate file if uploaded
                const fileInput = $('#lomba_poster')[0];
                if (fileInput.files.length > 0) {
                    const file = fileInput.files[0];
                    const fileError = validateFile(file);
                    if (fileError) {
                        $('#error-lomba_poster').text(fileError);
                        $('#lomba_poster').addClass('is-invalid');
                        return false;
                    }
                }
                
                var formData = new FormData(form);
                
                // Show loading state
                const submitButton = $(form).find('button[type="submit"]');
                const originalText = submitButton.html();
                submitButton.html('<i class="fa-solid fa-spinner fa-spin me-1"></i>Menyimpan...').prop('disabled', true);
                
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Reset button state
                        submitButton.html(originalText).prop('disabled', false);
                        
                        if (response.status) {
                            disposeModal();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            }).then(() => {
                                if (typeof reloadDataTable === 'function') {
                                    reloadDataTable();
                                } else {
                                    location.reload();
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
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message || 'Terjadi kesalahan saat menyimpan data.'
                                });
                            }
                        }
                    },
                    error: function(xhr) {
                        // Reset button state
                        submitButton.html(originalText).prop('disabled', false);
                        
                        console.log(xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.'
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

        // Clear errors on input
        $('#form input, #form select, #form textarea').on('input change', function() {
            const fieldId = $(this).attr('id');
            $('#error-' + fieldId).text('');
            $(this).removeClass('is-invalid');
        });

        // Preview image before upload with validation
        $('#lomba_poster').on('change', function() {
            const file = this.files[0];
            if (file) {
                // Validate file
                const fileError = validateFile(file);
                if (fileError) {
                    $('#error-lomba_poster').text(fileError);
                    $(this).addClass('is-invalid');
                    this.value = '';
                    $('.poster-preview').remove();
                    return;
                }
                
                // Clear any previous errors
                $('#error-lomba_poster').text('');
                $(this).removeClass('is-invalid');
                
                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Remove existing preview if any
                    $('.poster-preview').remove();
                    
                    // Add new preview
                    const preview = `
                        <div class="poster-preview mt-2">
                            <p class="text-sm text-gray-600 mb-2">Preview poster:</p>
                            <img src="${e.target.result}" alt="Preview" class="w-32 h-32 object-cover rounded-lg border">
                        </div>
                    `;
                    $('#lomba_poster').parent().append(preview);
                };
                reader.readAsDataURL(file);
            }
        });

        // Add date validation
        $('#lomba_mulai_pendaftaran, #lomba_akhir_pendaftaran').on('change', function() {
            const startDate = new Date($('#lomba_mulai_pendaftaran').val());
            const endDate = new Date($('#lomba_akhir_pendaftaran').val());
            
            if (startDate && endDate && endDate <= startDate) {
                $('#error-lomba_akhir_pendaftaran').text('Tanggal akhir harus setelah tanggal mulai pendaftaran.');
                $('#lomba_akhir_pendaftaran').addClass('is-invalid');
            } else {
                $('#error-lomba_akhir_pendaftaran').text('');
                $('#lomba_akhir_pendaftaran').removeClass('is-invalid');
            }
        });
    });
</script>