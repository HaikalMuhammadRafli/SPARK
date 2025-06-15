<form id="form" method="POST" action="{{ $action }}" data-reload-table class="p-4 md:p-5" enctype="multipart/form-data">
    @csrf

    @if (in_array(strtoupper($method), ['PUT']))
        @method($method)
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <!-- Nama Lomba -->
        <div class="md:col-span-2">
            <x-forms.input id="lomba_nama" name="lomba_nama" label="Nama Lomba"
                placeholder="Masukkan Nama Lomba" value="{{ isset($lomba) ? $lomba->lomba_nama : '' }}"
                isRequired />
        </div>

        <!-- Kategori - Changed to Select -->
        <div>
            <label for="lomba_kategori" class="block text-sm font-medium text-gray-900 mb-2">
                Kategori Lomba <span class="text-red-500">*</span>
            </label>
            <select id="lomba_kategori" name="lomba_kategori" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                <option value="">Pilih Kategori</option>
                @if(isset($kategoris))
                    @foreach($kategoris as $key => $value)
                        <option value="{{ $key }}" {{ (isset($lomba) && $lomba->lomba_kategori == $key) ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                @endif
            </select>
            <span id="error-lomba_kategori" class="error-text text-red-500 text-xs"></span>
        </div>

        <!-- Penyelenggara -->
        <div>
            <x-forms.input id="lomba_penyelenggara" name="lomba_penyelenggara" label="Penyelenggara"
                placeholder="Masukkan Penyelenggara" value="{{ isset($lomba) ? $lomba->lomba_penyelenggara : '' }}"
                isRequired />
        </div>

        <!-- Tingkat - Updated with correct options -->
        <div>
            <label for="lomba_tingkat" class="block text-sm font-medium text-gray-900 mb-2">
                Tingkat Lomba <span class="text-red-500">*</span>
            </label>
            <select id="lomba_tingkat" name="lomba_tingkat" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                <option value="">Pilih Tingkat</option>
                @if(isset($tingkats))
                    @foreach($tingkats as $key => $value)
                        <option value="{{ $key }}" {{ (isset($lomba) && $lomba->lomba_tingkat == $key) ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                @endif
            </select>
            <span id="error-lomba_tingkat" class="error-text text-red-500 text-xs"></span>
        </div>

        <!-- Lokasi Preferensi - Changed to Select -->
        <div>
            <label for="lomba_lokasi_preferensi" class="block text-sm font-medium text-gray-900 mb-2">
                Lokasi Preferensi <span class="text-red-500">*</span>
            </label>
            <select id="lomba_lokasi_preferensi" name="lomba_lokasi_preferensi" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                <option value="">Pilih Lokasi Preferensi</option>
                @if(isset($lokasi_preferensis))
                    @foreach($lokasi_preferensis as $key => $value)
                        <option value="{{ $key }}" {{ (isset($lomba) && $lomba->lomba_lokasi_preferensi == $key) ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
                    @endforeach
                @endif
            </select>
            <span id="error-lomba_lokasi_preferensi" class="error-text text-red-500 text-xs"></span>
        </div>

        <!-- Periode -->
        <div>
            <label for="periode_id" class="block text-sm font-medium text-gray-900 mb-2">
                Periode <span class="text-red-500">*</span>
            </label>
            <select id="periode_id" name="periode_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                <option value="">Pilih Periode</option>
                @if(isset($periodes))
                    @foreach($periodes as $periode)
                        <option value="{{ $periode->periode_id }}" {{ (isset($lomba) && $lomba->periode_id == $periode->periode_id) ? 'selected' : '' }}>
                            {{ $periode->periode_nama }}
                        </option>
                    @endforeach
                @endif
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

        <!-- Tanggal Mulai Pelaksanaan -->
        <div>
            <label for="lomba_mulai_pelaksanaan" class="block text-sm font-medium text-gray-900 mb-2">
                Mulai Pelaksanaan <span class="text-red-500">*</span>
            </label>
            <input type="date" id="lomba_mulai_pelaksanaan" name="lomba_mulai_pelaksanaan" 
                value="{{ isset($lomba) && $lomba->lomba_mulai_pelaksanaan ? $lomba->lomba_mulai_pelaksanaan->format('Y-m-d') : '' }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            <span id="error-lomba_mulai_pelaksanaan" class="error-text text-red-500 text-xs"></span>
        </div>

        <!-- Tanggal Selesai Pelaksanaan -->
        <div>
            <label for="lomba_selesai_pelaksanaan" class="block text-sm font-medium text-gray-900 mb-2">
                Selesai Pelaksanaan <span class="text-red-500">*</span>
            </label>
            <input type="date" id="lomba_selesai_pelaksanaan" name="lomba_selesai_pelaksanaan" 
                value="{{ isset($lomba) && $lomba->lomba_selesai_pelaksanaan ? $lomba->lomba_selesai_pelaksanaan->format('Y-m-d') : '' }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            <span id="error-lomba_selesai_pelaksanaan" class="error-text text-red-500 text-xs"></span>
        </div>

        <!-- Link Registrasi -->
        <div>
            <x-forms.input id="lomba_link_registrasi" name="lomba_link_registrasi" label="Link Registrasi"
                placeholder="Masukkan Link Registrasi" value="{{ isset($lomba) ? $lomba->lomba_link_registrasi : '' }}"
                isRequired />
        </div>

        <!-- Ukuran Kelompok -->
        <div>
            <label for="lomba_ukuran_kelompok" class="block text-sm font-medium text-gray-900 mb-2">
                Ukuran Kelompok <span class="text-red-500">*</span>
            </label>
            <input type="number" id="lomba_ukuran_kelompok" name="lomba_ukuran_kelompok" min="1" max="20"
                value="{{ isset($lomba) ? $lomba->lomba_ukuran_kelompok : '1' }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
            <span id="error-lomba_ukuran_kelompok" class="error-text text-red-500 text-xs"></span>
        </div>

        <!-- Poster Upload -->
        <div class="md:col-span-2">
            <label for="lomba_poster_url" class="block text-sm font-medium text-gray-900 mb-2">
                Poster Lomba {{ !isset($lomba) ? '*' : '' }}
            </label>
            <input type="file" id="lomba_poster_url" name="lomba_poster_url" accept="image/*"
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                {{ !isset($lomba) ? 'required' : '' }}>
            <p class="mt-1 text-sm text-gray-500">PNG, JPG, JPEG (MAX. 2MB)</p>
            <span id="error-lomba_poster_url" class="error-text text-red-500 text-xs"></span>
            
            @if(isset($lomba) && $lomba->lomba_poster_url)
                <div class="mt-2 current-poster">
                    <p class="text-sm text-gray-600 mb-2">Poster saat ini:</p>
                    <img src="{{ asset('storage/' . $lomba->lomba_poster_url) }}" alt="Current Poster" class="w-32 h-32 object-cover rounded-lg border">
                </div>
            @endif
        </div>

        <!-- Persyaratan -->
        <div class="md:col-span-2">
            <label for="lomba_persyaratan" class="block text-sm font-medium text-gray-900 mb-2">
                Persyaratan Lomba <span class="text-red-500">*</span>
            </label>
            <textarea id="lomba_persyaratan" name="lomba_persyaratan" rows="4" 
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                placeholder="Masukkan persyaratan lomba..." required>{{ isset($lomba) ? $lomba->lomba_persyaratan : '' }}</textarea>
            <span id="error-lomba_persyaratan" class="error-text text-red-500 text-xs"></span>
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
                lomba_mulai_pelaksanaan: {
                    required: true,
                    date: true
                },
                lomba_selesai_pelaksanaan: {
                    required: true,
                    date: true
                },
                lomba_link_registrasi: {
                    required: true,
                    url: true
                },
                lomba_ukuran_kelompok: {
                    required: true,
                    min: 1,
                    max: 20
                },
                lomba_persyaratan: {
                    required: true,
                    minlength: 10
                },
                lomba_poster_url: {
                    @if(!isset($lomba))
                    required: true,
                    @endif
                    accept: "image/*"
                }
            },
            messages: {
                lomba_nama: {
                    required: "Nama lomba wajib diisi.",
                    minlength: "Nama lomba minimal 3 karakter."
                },
                lomba_kategori: {
                    required: "Kategori lomba wajib dipilih."
                },
                lomba_penyelenggara: {
                    required: "Penyelenggara wajib diisi."
                },
                lomba_tingkat: {
                    required: "Tingkat lomba wajib dipilih."
                },
                lomba_lokasi_preferensi: {
                    required: "Lokasi preferensi wajib dipilih."
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
                lomba_mulai_pelaksanaan: {
                    required: "Tanggal mulai pelaksanaan wajib diisi.",
                    date: "Format tanggal tidak valid."
                },
                lomba_selesai_pelaksanaan: {
                    required: "Tanggal selesai pelaksanaan wajib diisi.",
                    date: "Format tanggal tidak valid."
                },
                lomba_link_registrasi: {
                    required: "Link registrasi wajib diisi.",
                    url: "Format URL tidak valid."
                },
                lomba_ukuran_kelompok: {
                    required: "Ukuran kelompok wajib diisi.",
                    min: "Ukuran kelompok minimal 1 orang.",
                    max: "Ukuran kelompok maksimal 20 orang."
                },
                lomba_persyaratan: {
                    required: "Persyaratan lomba wajib diisi.",
                    minlength: "Persyaratan minimal 10 karakter."
                },
                lomba_poster_url: {
                    @if(!isset($lomba))
                    required: "Poster lomba wajib diupload.",
                    @endif
                    accept: "File harus berupa gambar (PNG, JPG, JPEG)."
                }
            },
            submitHandler: function(form, event) {
                event.preventDefault();
                
                // Validate date sequence
                const startReg = new Date($('#lomba_mulai_pendaftaran').val());
                const endReg = new Date($('#lomba_akhir_pendaftaran').val());
                const startEvent = new Date($('#lomba_mulai_pelaksanaan').val());
                const endEvent = new Date($('#lomba_selesai_pelaksanaan').val());
                
                // Clear previous date errors
                $('input[type="date"]').each(function() {
                    const fieldId = $(this).attr('id');
                    $('#error-' + fieldId).text('');
                    $(this).removeClass('is-invalid');
                });
                
                let dateValidationError = false;
                
                // Registration end must be after registration start
                if (endReg <= startReg) {
                    $('#error-lomba_akhir_pendaftaran').text('Tanggal akhir pendaftaran harus setelah tanggal mulai pendaftaran.');
                    $('#lomba_akhir_pendaftaran').addClass('is-invalid');
                    dateValidationError = true;
                }
                
                // Event start should be after or equal to registration end
                if (startEvent < endReg) {
                    $('#error-lomba_mulai_pelaksanaan').text('Tanggal mulai pelaksanaan harus setelah atau sama dengan tanggal akhir pendaftaran.');
                    $('#lomba_mulai_pelaksanaan').addClass('is-invalid');
                    dateValidationError = true;
                }
                
                // Event end must be after event start
                if (endEvent <= startEvent) {
                    $('#error-lomba_selesai_pelaksanaan').text('Tanggal selesai pelaksanaan harus setelah tanggal mulai pelaksanaan.');
                    $('#lomba_selesai_pelaksanaan').addClass('is-invalid');
                    dateValidationError = true;
                }
                
                if (dateValidationError) {
                    return false;
                }
                
                // Validate file if uploaded
                const fileInput = $('#lomba_poster_url')[0];
                if (fileInput.files.length > 0) {
                    const file = fileInput.files[0];
                    const fileError = validateFile(file);
                    if (fileError) {
                        $('#error-lomba_poster_url').text(fileError);
                        $('#lomba_poster_url').addClass('is-invalid');
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
                                } else if (typeof loadLombaData === 'function') {
                                    loadLombaData();
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
                        // Reset button state
                        submitButton.html(originalText).prop('disabled', false);
                        
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

        // Clear errors on input
        $('#form input, #form select, #form textarea').on('input change', function() {
            const fieldId = $(this).attr('id') || $(this).attr('name');
            $('#error-' + fieldId).text('');
            $(this).removeClass('is-invalid');
        });

        // Preview image before upload with validation
        $('#lomba_poster_url').on('change', function() {
            const file = this.files[0];
            if (file) {
                // Validate file
                const fileError = validateFile(file);
                if (fileError) {
                    $('#error-lomba_poster_url').text(fileError);
                    $(this).addClass('is-invalid');
                    this.value = '';
                    $('.poster-preview').remove();
                    return;
                }
                
                // Clear any previous errors
                $('#error-lomba_poster_url').text('');
                $(this).removeClass('is-invalid');
                
                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Remove existing preview if any
                    $('.poster-preview').remove();
                    
                    // Add new preview
                    const preview = `
                        <div class="poster-preview mt-2">
                            <p class="text-sm text-gray-600 mb-2">Preview poster baru:</p>
                            <img src="${e.target.result}" alt="Preview" class="w-32 h-32 object-cover rounded-lg border">
                        </div>
                    `;
                    $('#lomba_poster_url').parent().append(preview);
                };
                reader.readAsDataURL(file);
            } else {
                $('.poster-preview').remove();
            }
        });

        // Date validation with improved logic
        $('#lomba_mulai_pendaftaran, #lomba_akhir_pendaftaran, #lomba_mulai_pelaksanaan, #lomba_selesai_pelaksanaan').on('change', function() {
            const startReg = $('#lomba_mulai_pendaftaran').val();
            const endReg = $('#lomba_akhir_pendaftaran').val();
            const startEvent = $('#lomba_mulai_pelaksanaan').val();
            const endEvent = $('#lomba_selesai_pelaksanaan').val();
            
            // Clear previous errors for date fields only
            $('input[type="date"]').each(function() {
                const fieldId = $(this).attr('id');
                $('#error-' + fieldId).text('');
                $(this).removeClass('is-invalid');
            });
            
            if (startReg && endReg) {
                if (new Date(endReg) <= new Date(startReg)) {
                    $('#error-lomba_akhir_pendaftaran').text('Tanggal akhir pendaftaran harus setelah tanggal mulai pendaftaran.');
                    $('#lomba_akhir_pendaftaran').addClass('is-invalid');
                }
            }
            
            if (endReg && startEvent) {
                if (new Date(startEvent) < new Date(endReg)) {
                    $('#error-lomba_mulai_pelaksanaan').text('Tanggal mulai pelaksanaan harus setelah atau sama dengan tanggal akhir pendaftaran.');
                    $('#lomba_mulai_pelaksanaan').addClass('is-invalid');
                }
            }
            
            if (startEvent && endEvent) {
                if (new Date(endEvent) <= new Date(startEvent)) {
                    $('#error-lomba_selesai_pelaksanaan').text('Tanggal selesai pelaksanaan harus setelah tanggal mulai pelaksanaan.');
                    $('#lomba_selesai_pelaksanaan').addClass('is-invalid');
                }
            }
        });
    });
</script>