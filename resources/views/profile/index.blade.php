@extends('layouts.app')

@section('content')
    <section class="mx-auto flex flex-col md:flex-row gap-3">
        <div class="flex flex-col md:w-1/2 gap-3">
            <!-- Profile Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Profile Header -->
                <div class="relative h-32 bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 rounded-2xl">
                    <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2">
                        <img src="{{ Storage::url(auth()->user()->foto_profil_url) ?? asset('images/default-profile.svg') }}"
                            alt="Profile Picture" class="w-24 h-24 rounded-full border-4 border-white shadow-lg object-cover">
                    </div>
                </div>

                <!-- Profile Info -->
                <div class="pt-12 pb-6 px-8 text-center">
                    <p class="text-gray-500 text-sm mb-1">{{ auth()->user()->email }}</p>
                    <h1 class="text-xl font-semibold text-gray-900 mb-2">{{ auth()->user()->getCurrentData()->nama }}</h1>
                    <div class="flex items-center justify-center text-sm text-gray-500 mb-6">
                        <span class="text-blue-500">{{ ucfirst(auth()->user()->role) }}</span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-center mb-6">
                        <x-buttons.default title="Edit Profile" type="button" icon="fa-solid fa-pencil"
                            onclick="modalAction('{{ route('profile.edit') }}', 'edit_modal')" />
                    </div>

                    <!-- Quote -->
                    <p class="text-xs text-gray-600 leading-relaxed mb-4">
                        Sistem pencatatan prestasi mahasiswa jadi bukti nyata tiap usaha dan pencapaian. Terus semangat
                        berprestasi, karena setiap langkahmu berarti dan layak diapresiasi!
                    </p>
                </div>
            </div>

            <!-- Information Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-8 py-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Diri</h3>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-id-badge text-gray-400"></i>
                            <span class="text-sm text-gray-500">
                                @if (auth()->user()->role == 'mahasiswa')
                                    NIM
                                @else
                                    NIP
                                @endif
                            </span>
                            <span class="text-sm text-gray-900 ml-auto">
                                {{ auth()->user()->getCurrentData()->nim ?? auth()->user()->getCurrentData()->nip }}
                            </span>
                        </div>
                        @if (auth()->user()->role == 'mahasiswa')
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-location-dot text-gray-400"></i>
                                <span class="text-sm text-gray-500">Program Studi</span>
                                <span
                                    class="text-sm text-gray-900 ml-auto">{{ auth()->user()->mahasiswa->program_studi->program_studi_nama }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="fa-solid fa-location-dot text-gray-400"></i>
                                <span class="text-sm text-gray-500">Lokasi Preferensi</span>
                                <span
                                    class="text-sm text-gray-900 ml-auto">{{ auth()->user()->mahasiswa->lokasi_preferensi }}</span>
                            </div>
                        @endif
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-circle-exclamation text-gray-400"></i>
                            <span class="text-sm text-gray-500">Status</span>
                            <span
                                class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-sm ml-auto">{{ ucfirst(auth()->user()->status_akun) }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-arrows-to-dot text-gray-400"></i>
                            <span class="text-sm text-gray-500">Bergabung</span>
                            <span
                                class="bg-blue-100 text-blue-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded-sm border border-blue-400 ml-auto">
                                <svg class="w-2.5 h-2.5 me-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z" />
                                </svg>
                                {{ auth()->user()->getCurrentData()->created_at->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (auth()->user()->role != 'admin')
            <div class="flex flex-col md:w-1/2 gap-3">
                <x-profile.criteria-card title="Bidang Keahlian"
                    description="Daftar bidang keahlian yang dimiliki oleh mahasiswa." icon="fa-solid fa-briefcase"
                    route="profile.destroy.bidang-keahlian" data_name="bidang_keahlians"
                    onclick="modalAction('{{ route('profile.add.bidang-keahlian.form') }}', 'criteria_modal')" />

                <x-profile.criteria-card title="Minat" description="Daftar minat yang dimiliki oleh mahasiswa."
                    icon="fa-solid fa-heart" route="profile.destroy.minat" data_name="minats"
                    onclick="modalAction('{{ route('profile.add.minat.form') }}', 'criteria_modal')" />

                <x-profile.criteria-card title="Kompetensi" description="Daftar kompetensi yang dimiliki oleh mahasiswa."
                    icon="fa-solid fa-certificate" data_name="kompetensis" :isEditable="false" />
            </div>
        @else
            <div class="md:w-1/2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-4 py-3 space-y-3">
                        <div class="flex flex-row justify-between items-center">
                            <div class="flex flex-row items-center">
                                <i class="fa-solid fa-file-contract text-primary text-2xl me-3"></i>
                                <div class="">
                                    <h3 class="font-semibold text-md">Logs</h3>
                                    <p class="text-gray-500 text-xs">Log admin</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </section>

    <x-modal id="edit_modal" size="2xl" />
    @if (auth()->user()->role != 'admin')
        <x-modal id="criteria_modal" size="md" />
    @endif
@endsection
