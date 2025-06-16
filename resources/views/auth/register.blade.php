@extends('layouts.app')

@section('content')
    <div class="min-h-screen w-full bg-gradient-to-bl from-secondary to-primary">
        <a href="{{ route('home') }}" class="absolute bg-white text-sm rounded-lg px-3 py-1.5 m-3 z-10"><i
                class="fa-solid fa-arrow-left-long"></i> Kembali</a>
        <section class="min-h-screen w-full flex flex-col items-center justify-center py-8 px-4">
            <div class="flex items-center justify-center w-full max-w-sm mb-8">
                <ol class="flex items-center w-full">
                    <li
                        class="flex w-full items-center text-primary after:content-[''] after:w-full after:h-1 after:border-b after:border-primary/30 after:border-4 after:inline-block">
                        <span
                            class="flex items-center justify-center w-8 h-8 bg-primary text-white rounded-full shrink-0 text-sm font-semibold">
                            1
                        </span>
                    </li>
                    <li class="flex items-center">
                        <span
                            class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full shrink-0 text-sm font-semibold">
                            2
                        </span>
                    </li>
                </ol>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-xl">
                <h1 class="text-gray-900 text-lg font-semibold">Selamat datang di {{ config('app.name') }}</h1>
                <p class="text-gray-500 text-xs">Silakan daftar untuk melanjutkan!</p>
                <hr class="text-gray-300 my-4">
                <form id="form" action="{{ route('register') }}" method="POST">
                    @csrf
                    <div id="step-1" class="">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-6">
                            <x-forms.input name="nim" label="NIM" placeholder="Masukkan NIM" required />
                            <x-forms.input name="nama" label="Nama Lengkap" placeholder="Masukkan Nama Lengkap"
                                required />
                            <x-forms.input name="email" type="email" label="Email" placeholder="Masukkan Email"
                                required />
                            <x-forms.input name="password" type="password" label="Password" placeholder="Masukkan Password"
                                required />
                            <x-forms.select name="program_studi" label="Program Studi" :options="$program_studis->pluck('program_studi_nama', 'program_studi_id')->toArray()"
                                placeholder="Pilih Program Studi" required />
                            <x-forms.select name="lokasi_preferensi" label="Lokasi Preferensi" :options="$lokasi_preferensis"
                                placeholder="Pilih Lokasi Preferensi" required />
                        </div>
                        <x-buttons.default id="next-step" type="button" title="Selanjutnya" color="primary"
                            icon="fa-solid fa-arrow-right" class="w-full" />
                    </div>
                    <div id="step-2" class="space-y-4 hidden">
                        <div class="form-group">
                            <h2 class="text-md text-gray-800 font-semibold">Pilih Minat Anda</h2>
                            <p class="text-gray-500 text-xs mb-2">Silahkan memilih skill yang ingin anda asah!</p>
                            <div
                                class="flex flex-wrap gap-2 border border-gray-300 rounded-lg p-3 max-h-48 overflow-y-auto">
                                @foreach ($minats as $minat)
                                    <label class="cursor-pointer">
                                        <input type="checkbox" class="sr-only peer" name="minat[]"
                                            value="{{ $minat->minat_id }}" />
                                        <span
                                            class="inline-block px-3 py-1 text-xs font-semibold border-2 border-gray-400 text-gray-600 rounded-full transition-all duration-200
                    peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary
                    hover:bg-primary/10 peer-checked:hover:bg-primary/80">
                                            {{ $minat->minat_nama }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            <span id="error-minat" class="text-red-500 text-xs"></span>
                        </div>

                        <div class="form-group">
                            <h2 class="text-md text-gray-800 font-semibold">Pilih Bidang Keahlian Anda</h2>
                            <p class="text-gray-500 text-xs mb-2">Silahkan memilih skill yang anda miliki saat ini!</p>
                            <div
                                class="flex flex-wrap gap-2 border border-gray-300 rounded-lg p-3 max-h-48 overflow-y-auto">
                                @foreach ($bidang_keahlians as $bidang_keahlian)
                                    <label class="cursor-pointer">
                                        <input type="checkbox" class="sr-only peer" name="bidang_keahlian[]"
                                            value="{{ $bidang_keahlian->bidang_keahlian_id }}" />
                                        <span
                                            class="inline-block px-3 py-1 text-xs font-semibold border-2 border-gray-400 text-gray-600 rounded-full transition-all duration-200
                    peer-checked:bg-primary peer-checked:text-white peer-checked:border-primary
                    hover:bg-primary/10 peer-checked:hover:bg-primary/80">
                                            {{ $bidang_keahlian->bidang_keahlian_nama }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                            <span id="error-bidang_keahlian" class="text-red-500 text-xs"></span>
                        </div>

                        <div class="flex items-center justify-between">
                            <x-buttons.default id="prev-step" type="button" title="Kembali" color="primary"
                                icon="fa-solid fa-arrow-left" />
                            <div class="flex items-center gap-2">
                                <x-buttons.default id="reset-form" type="button" title="Reset" color="primary"
                                    icon="fa-solid fa-arrow-rotate-right" />
                                <x-buttons.default type="submit" title="Register" color="primary"
                                    icon="fa-solid fa-arrow-right-to-bracket" />
                            </div>
                        </div>
                    </div>
                </form>
                <hr class="text-gray-300 my-4">
                <div class="text-center">
                    <p class="text-gray-500 text-xs">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-primary font-semibold">Masuk Sekarang</a>
                    </p>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            let currentStep = 1;
            const totalSteps = 2;

            function updateStepperUI() {
                const stepIndicators = $('ol li');

                stepIndicators.each(function(index) {
                    const stepNumber = index + 1;
                    const $this = $(this);
                    const $span = $this.find('span');

                    if (stepNumber < currentStep) {
                        // Completed step
                        $this.removeClass('text-gray-500').addClass('text-primary');
                        $span.removeClass('bg-gray-100').addClass('bg-primary text-white');
                    } else if (stepNumber === currentStep) {
                        // Current step
                        $this.removeClass('text-gray-500').addClass('text-primary');
                        $span.removeClass('bg-gray-100').addClass('bg-primary text-white');
                    } else {
                        // Future step
                        $this.removeClass('text-primary').addClass('text-gray-500');
                        $span.removeClass('bg-primary text-white').addClass('bg-gray-100');
                    }
                });
            }

            function showStep(step) {
                $('#step-1, #step-2').addClass('hidden');
                $('#step-' + step).removeClass('hidden');
                currentStep = step;
                updateStepperUI();
            }

            // Initialize jQuery Validator
            const validator = $("#form").validate({
                rules: {
                    nim: {
                        required: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    nama: {
                        required: true,
                        minlength: 3,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    program_studi: {
                        required: true
                    },
                    lokasi_preferensi: {
                        required: true
                    },
                    password: {
                        required: true,
                        minlength: 8,
                        maxlength: 50
                    },
                    "minat[]": {
                        required: true
                    },
                    "bidang_keahlian[]": {
                        required: true
                    }
                },
                messages: {
                    nim: {
                        required: "NIM wajib diisi.",
                        minlength: "NIM minimal 10 karakter.",
                        maxlength: "NIM maksimal 10 karakter."
                    },
                    nama: {
                        required: "Nama lengkap wajib diisi.",
                        minlength: "Nama lengkap minimal 3 karakter."
                    },
                    email: {
                        required: "Email wajib diisi.",
                        email: "Format email tidak valid."
                    },
                    program_studi: {
                        required: "Program studi wajib dipilih."
                    },
                    lokasi_preferensi: {
                        required: "Lokasi preferensi wajib dipilih."
                    },
                    password: {
                        required: "Password wajib diisi.",
                        minlength: "Password minimal 8 karakter.",
                        maxlength: "Password maksimal 50 karakter."
                    },
                    "minat[]": {
                        required: "Pilih minimal satu minat."
                    },
                    "bidang_keahlian[]": {
                        required: "Pilih minimal satu bidang keahlian."
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Register Berhasil',
                                    text: response.message,
                                }).then(function() {
                                    window.location = response.redirect;
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
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Register Gagal',
                                    text: response.message
                                });
                            }
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

            // Validate only step 1 fields
            function validateStep1() {
                const step1Fields = ['#nim', '#nama', '#email', '#password', '#program_studi',
                    '#lokasi_preferensi'
                ];
                let isValid = true;

                step1Fields.forEach(field => {
                    if (!validator.element(field)) {
                        isValid = false;
                    }
                });

                return isValid;
            }

            $('#next-step').on('click', function(e) {
                e.preventDefault();

                if (currentStep === 1) {
                    if (validateStep1()) {
                        showStep(currentStep + 1);
                    }
                }
            });

            $('#prev-step').on('click', function(e) {
                e.preventDefault();

                if (currentStep > 1) {
                    showStep(currentStep - 1);
                }
            });

            updateStepperUI();

            $('#form input').on('input', function() {
                const fieldId = $(this).attr('id');
                $('#error-' + fieldId).text('');
                $(this).removeClass('is-invalid');
            });

            $('#program_studi, #lokasi_preferensi').on('change', function() {
                const fieldId = $(this).attr('id');
                $('#error-' + fieldId).text('');
                $(this).removeClass('is-invalid');
            });
        });
    </script>
@endpush
