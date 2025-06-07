@extends('layouts.app')

@section('content')
    <section class="mx-auto flex flex-col md:flex-row gap-3">
        <div class="flex flex-col md:w-1/2 gap-3">
            <!-- Profile Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <!-- Profile Header -->
                <div class="relative h-32 bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 rounded-2xl">
                    <div class="absolute -bottom-8 left-1/2 transform -translate-x-1/2">
                        <img alt="Profile"
                            src="data:image/jpeg;base64,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"
                            class="w-28 h-28 rounded-full border-4 border-white shadow-lg object-cover">
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
                        <x-buttons.default title="Edit Profile" type="button" icon="fa-solid fa-pencil" onclick="modalAction('{{ route('profile.edit') }}')"/>
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
                    onclick="modalAction('{{ route('profile.add.bidang-keahlian.form') }}')" />

                <x-profile.criteria-card title="Minat" description="Daftar minat yang dimiliki oleh mahasiswa."
                    icon="fa-solid fa-heart" route="profile.destroy.minat" data_name="minats"
                    onclick="modalAction('{{ route('profile.add.minat.form') }}')" />

                <x-profile.criteria-card title="Kompetensi" description="Daftar kompetensi yang dimiliki oleh mahasiswa."
                    icon="fa-solid fa-certificate" data_name="kompetensis" :isEditable="false" />
            </div>
        @else
            <div class="md:w1/2">

            </div>
        @endif
    </section>

    <x-modal size="2xl"/>
@endsection
