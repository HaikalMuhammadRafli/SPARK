@props([
    'name' => 'textarea',
    'label' => 'Default Label',
    'placeholder' => '',
    'info' => null,
    'value' => '',
    'rows' => 4,
    'required' => false,
    'disabled' => false,
])

<fieldset class="form-group w-full {{ empty($info) ? 'space-y-4' : '' }}">
    <label for="{{ $name }}" class="block mb-1 text-xs font-medium text-gray-600">
        {{ $label }}
        @if ($required)
            <span class="text-red-500" aria-label="required">*</span>
        @endif
    </label>

    @if ($info)
        <p id="{{ $name }}-info" class="mt-1 mb-3 text-xs text-gray-500">{{ $info }}</p>
    @endif

    <div class="relative m-0">
        <textarea id="{{ $name }}" name="{{ $name }}"
            placeholder="{{ $placeholder }}"
            rows="{{ $rows }}"
            @if ($disabled) disabled @endif
            @if ($required) required aria-required="true" @endif
            @if ($info) aria-describedby="{{ $name }}-info" @endif
            @error($name) aria-invalid="true" aria-describedby="{{ $name }}-error" @enderror
            class="w-full rounded-md bg-gray-50 border border-gray-300 text-xs text-gray-900 placeholder-gray-400 px-3 py-2 transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white focus:outline-none resize-y
            {{ $disabled ? 'opacity-50 cursor-not-allowed bg-gray-100' : 'hover:border-gray-400' }}
            @error($name) border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
            {{ $attributes }}>{{ old($name, $value) }}</textarea>
    </div>

    @error($name)
        <span id="{{ $name }}-error" class="text-red-500 text-xs mt-1 block"
            role="alert">{{ $message }}</span>
    @enderror
</fieldset>
