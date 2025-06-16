@props([
    'type' => 'button',
    'title' => '',
    'color' => 'primary',
    'onclick' => '',
    'class' => '',
])

@php
    $iconMap = [
        'Export PDF' => 'fa-solid fa-file-pdf',
        'Export Excel' => 'fa-solid fa-file-excel',
        'Import Excel' => 'fa-solid fa-file-import',
        'Tambah Baru' => 'fa-solid fa-plus',
        'Ajukan Lomba Baru' =>'fa-solid fa-paper-plane',
        'Lihat Detail' => 'fa-solid fa-eye',
        'Link Registrasi' => 'fa-solid fa-link',
        'Kembali' => "fa-solid fa-arrow-left",
        'Edit' => "fa-solid fa-pen-to-square",
    ];

    $icon = $iconMap[$title] ?? 'fa-solid fa-circle-question';
@endphp

<button type="{{ $type }}" onclick="{{ $onclick }}"
    class="{{ $class }} text-white bg-primary focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-xs px-4 py-2 text-center cursor-pointer">
    <i class="me-2 text-sm {{ $icon }}"></i>
    {{ $title }}
</button>
