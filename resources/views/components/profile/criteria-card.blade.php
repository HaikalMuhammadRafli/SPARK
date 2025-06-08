@props([
    'title' => 'Default Title',
    'description' => 'Default description for the criteria card.',
    'icon' => 'fa-solid fa-briefcase',
    'data_name' => '',
    'route' => 'home',
    'onclick' => '',
    'isEditable' => true,
])

@php
    $column_name = '';
    if (!empty($data_name)) {
        $column_name = substr($data_name, 0, -1);
    }
@endphp

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-4 py-3 space-y-3">
        <div class="flex flex-row justify-between items-center">
            <div class="flex flex-row items-center">
                <i class="{{ $icon }} text-primary text-2xl me-3"></i>
                <div class="">
                    <h3 class="font-semibold text-md">{{ $title }}</h3>
                    <p class="text-gray-500 text-xs">{{ $description }}</p>
                </div>
            </div>
            @if ($isEditable)
                <x-buttons.default title="Tambah" type="button" icon="fa-solid fa-plus" :onclick="$onclick" />
            @endif
        </div>
        <div class="flex flex-wrap gap-2 border rounded-lg p-2 border-gray-200">
            @if (count(auth()->user()->getCurrentData()->{$data_name}) > 0)
                @foreach (auth()->user()->getCurrentData()->{$data_name} as $data)
                    <div
                        class="flex flex-row items-center justify-between gap-2 px-2 bg-gray-100 rounded-full border border-gray-300">
                        <span class="text-xs">
                            {{ $data->{$column_name . '_nama'} }}
                        </span>
                        <a href="{{ route($route, $data->{$column_name . '_id'}) }}">
                            <i class="fa-solid fa-xmark text-sm text-gray-600"></i>
                        </a>
                    </div>
                @endforeach
            @else
                <span class="text-gray-400 text-xs">Tidak ada {{ strtolower($title) }} yang ditambahkan.</span>
            @endif
        </div>
    </div>
</div>
