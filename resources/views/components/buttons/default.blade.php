@props([
    'id' => '',
    'type' => 'button',
    'title' => 'Click Me',
    'color' => 'primary',
    'onclick' => '',
    'icon' => 'fa-solid fa-info-circle',
    'forModal' => false,
    'class' => '',
])


<button id="{{ $id }}" type="{{ $type }}" onclick="{{ $onclick }}"
    @if ($forModal) data-modal-target="modal" data-modal-toggle="modal" @endif
    class="{{ $class }} text-white bg-primary focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-md text-xs px-4 py-2 text-center cursor-pointer">
    <i class="me-2 text-sm {{ $icon }}"></i>
    {{ $title }}
</button>
