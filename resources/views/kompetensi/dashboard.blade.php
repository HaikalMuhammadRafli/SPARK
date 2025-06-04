@extends('layouts.app')

@section('content')
    <section>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
            <x-dashboard.count-card title="Total Mahasiswa" count="1,000" icon="fa-solid fa-users" />
            <x-dashboard.count-card title="Total Kelompok" count="200" icon="fa-solid fa-medal" />
            <x-dashboard.count-card title="Total Lomba" count="50" icon="fa-solid fa-trophy" />
            <x-dashboard.count-card title="Total Prestasi" count="200" icon="fa-solid fa-medal" />
        </div>
    </section>
@endsection
