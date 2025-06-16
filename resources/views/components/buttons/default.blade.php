@props([
    'id' => '',
    'type' => 'button',
    'title' => 'Click Me',
    'color' => 'primary',
    'onclick' => '',
    'icon' => 'fa-solid fa-info-circle',
    'class' => '',
])

<button id="{{ $id }}" type="{{ $type }}" onclick="{{ $onclick }}"
    class="{{ $class }} flex items-center justify-center text-white bg-primary focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-xs px-4 py-2 text-center cursor-pointer"
    {{ $attributes }}>
    <i class="me-2 text-sm {{ $icon }}"></i>
    {{ $title }}
</button>
