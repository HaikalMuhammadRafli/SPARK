@props([
    'href' => '/',
    'icon' => 'fa-solid fa-circle-info',
    'title' => 'Default Title',
    'count' => '0',
    'color' => 'gray-500',
])

<div class="max-w-sm p-4 bg-white border border-gray-200 rounded-xl shadow-sm space-y-2">
    <div class="flex flex-row items-center justify-between">
        <div class="flex flex-row gap-2 items-center">
            <i class="{{ $icon }} text-sm text-primary bg-gray-200 rounded-lg p-2"></i>
            <h6 class="text-sm font-semibold">{{ $title }}</h6>
        </div>
        <button type="button"
            class="text-primary border border-primary hover:bg-primary hover:text-white focus:ring-2 focus:outline-none focus:ring-secondary font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center">
            <i class="fa-solid fa-arrow-right-long"></i>
            <span class="sr-only">Icon description</span>
        </button>
    </div>
    <div class="flex flex-row items-center gap-2">
        <h6 class="font-extrabold text-3xl">{{ $count }}</h6>
        <span class="bg-purple-100 text-primary text-xs font-medium px-1.5 py-0.5 rounded-sm border border-primary"><i
                class="fa-solid fa-arrow-trend-up"></i> 20%</span>
    </div>
</div>
