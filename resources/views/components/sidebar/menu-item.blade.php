@props([
    'route' => 'home',
    'icon' => 'fa-solid fa-circle-info',
    'title' => 'Default Title',
    'activeClass' => 'text-primary border-l-4 border-primary bg-purple-100/30',
    'inactiveClass' => 'text-gray-500 border-l-4 border-transparent',
    'onclick' => '',
])

@php
    $route = empty($route) ? 'home' : $route;
    $isActive = request()->routeIs($route);
@endphp

@if (!empty($onclick))
    <a class="border-l-4 border-transparent text-red-500 flex items-center p-2 transition-colors duration-200 ease-in-out rounded-r-md group hover:bg-gray-100 cursor-pointer"
        onclick="{{ $onclick }}">
        <i class="ms-2 me-3 {{ $icon }} w-4 text-center" aria-hidden="true"></i>
        <span class="ms-1 text-sm font-medium">{{ $title }}</span>
    </a>
@else
    <a href="{{ route($route) }}" @class([
        'flex items-center p-2 transition-colors duration-200 ease-in-out rounded-r-md group',
        $activeClass => $isActive,
        "{$inactiveClass} hover:bg-gray-100" => !$isActive,
    ])
        @if ($isActive) aria-current="page" @endif>
        <i class="ms-2 me-3 {{ $icon }} w-4 text-center" aria-hidden="true"></i>
        <span class="ms-1 text-sm font-medium">{{ $title }}</span>
    </a>
@endif
