@props([
    'name' => 'select',
    'label' => 'Opsi',
    'icon' => null,
    'placeholder' => null,
    'options' => [],
    'selected' => null,
    'required' => false,
    'disabled' => false,
])

<fieldset class="form-group w-full">
    <label for="{{ $name }}" class="block mb-1 text-xs font-medium text-gray-600">
        {{ $label }}
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </label>

    <div class="relative">
        @if ($icon)
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 pointer-events-none">
                <i class="{{ $icon }}" aria-hidden="true"></i>
            </span>
        @endif

        <select id="{{ $name }}" name="{{ $name }}" @if ($required) required @endif
            @if ($disabled) disabled @endif
            class="w-full rounded-md bg-gray-50 border border-gray-300 text-xs text-gray-900 px-3 py-2.5 transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white focus:outline-none {{ $disabled ? 'opacity-50 cursor-not-allowed bg-gray-100' : 'hover:border-gray-400' }} {{ $icon ? 'pl-10' : 'pl-3' }}"
            {{ $attributes->except(['class']) }}>

            @if ($placeholder)
                <option value="" disabled @selected(empty(old($name, $selected)))>
                    {{ $placeholder }}
                </option>
            @endif

            @forelse ($options as $value => $optionLabel)
                <option value="{{ $value }}" @selected((string) old($name, $selected) === (string) $value)>
                    {{ $optionLabel }}
                </option>
            @empty
                <option value="" disabled>No options available</option>
            @endforelse
        </select>
    </div>

    @error($name)
        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
    @enderror
</fieldset>
