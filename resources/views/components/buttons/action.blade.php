@props([
    'route_prefix' => null,
    'id' => null,
    'showDetail' => true,
])

<div class="inline-flex rounded-md shadow-xs" role="group">
    @if ($showDetail)
        <button type="button" onclick="window.location.href='{{ route($route_prefix . '.show', $id) }}'"
            class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-blue-600 rounded-s-lg cursor-pointer">
            <i class="fa-solid fa-receipt me-2"></i>
            Detail
        </button>
    @endif

    <button type="button" onclick="modalAction('{{ route($route_prefix . '.edit', $id) }}')"
        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-yellow-500 {{ !$showDetail ? 'rounded-s-lg' : '' }} cursor-pointer">
        <i class="fa-solid fa-pencil me-2"></i>
        Edit
    </button>

    <button type="button" onclick="modalAction('{{ route($route_prefix . '.delete', $id) }}')"
        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-white bg-red-500 rounded-e-lg cursor-pointer">
        <i class="fa-solid fa-trash-can me-2"></i>
        Hapus
    </button>
</div>
