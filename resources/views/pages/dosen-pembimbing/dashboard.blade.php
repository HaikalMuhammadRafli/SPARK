@extends('layouts.app')

@section('content')
    <section>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
            <x-dashboard.count-card title="Lomba Berlangsung" count="{{ $lomba_berlangsung_count }}"
                icon="fa-solid fa-medal" />
            <x-dashboard.count-card title="Lomba Akan Datang" count="{{ $lomba_akan_datang_count }}"
                icon="fa-solid fa-medal" />
            <x-dashboard.count-card title="Bimbingan Saya" count="{{ $bimbingan_saya_count }}" icon="fa-solid fa-users" />
            <x-dashboard.count-card title="Prestasi Bimbingan" count="{{ $prestasi_bimbingan_count }}"
                icon="fa-solid fa-trophy" />
        </div>
    </section>
@endsection
