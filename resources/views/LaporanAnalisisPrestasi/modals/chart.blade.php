@extends('layouts.app')

@section('content')
<section class="bg-white flex flex-col md:flex-row md:justify-between md:items-center gap-4 p-4 rounded-xl mb-2">
    <div class="flex flex-col gap-1">
        <h1 class="text-xl font-bold">Data Laporan Prestasi</h1>
        <!-- Menampilkan breadcrumb -->
        <x-breadcrumbs :items="$breadcrumbs" />
    </div>
    <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
        <div class="flex flex-row gap-2 flex-wrap">
            <x-buttons.default type="button" title="Export PDF" color="primary" onclick="" />
            <x-buttons.default type="button" title="Export Excel" color="primary" onclick="" />
        </div>
        <div class="flex flex-row gap-2 flex-wrap">
            <x-buttons.default type="button" title="Import Excel" color="primary" onclick="" />
        </div>
    </div>
</section>

<section class="overflow-x-auto bg-white px-4 py-4 rounded-xl">
    <!-- Visualisasi Grafik Peningkatan/Penurunan Kategori Peminatan -->
    <div class="max-w-sm w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6">
        <div class="flex justify-between border-gray-200 border-b dark:border-gray-700 pb-3">
            <dl>
                <dt class="text-base font-normal text-gray-500 dark:text-gray-400 pb-1">Kategori Peminatan</dt>
                <dd class="leading-none text-3xl font-bold text-gray-900 dark:text-white">Peningkatan/Penurunan</dd>
            </dl>
        </div>
        
        <!-- Bar Chart Visualization -->
        <div id="bar-chart">
            <div class="w-full max-w-5xl mx-auto">
                <div class="text-center mb-4">
                    <h3 class="text-lg font-semibold">Statistik Kategori Peminatan</h3>
                </div>
                <div>{!! $chart->container() !!}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
            <div class="flex justify-between items-center pt-5">
                <!-- Filter Dropdown -->
                <button
                    id="dropdownDefaultButton"
                    data-dropdown-toggle="lastDaysdropdown"
                    data-dropdown-placement="bottom"
                    class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                    type="button">
                    Last 6 months
                    <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>

<x-modal />
@endsection

<!-- Menambahkan script untuk chart -->
{!! $chart->script() !!}
