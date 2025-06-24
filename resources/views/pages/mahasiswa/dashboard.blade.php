@extends('layouts.app')

@section('content')
    <section>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
            <x-dashboard.count-card title="Lomba Berlangsung" count="{{ $lomba_berlangsung_count }}"
                icon="fa-solid fa-medal" />
            <x-dashboard.count-card title="Lomba Akan Datang" count="{{ $lomba_akan_datang_count }}"
                icon="fa-solid fa-medal" />
            <x-dashboard.count-card title="Lomba Saya" count="{{ $lomba_saya_count }}" icon="fa-solid fa-medal" />
            <x-dashboard.count-card title="Prestasi Saya" count="{{ $prestasi_saya_count }}" icon="fa-solid fa-trophy" />
        </div>
    </section>
@endsection
