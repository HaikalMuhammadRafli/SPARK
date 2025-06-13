@props([
    'id' => 'default-input',
    'label' => 'Default Label',
    'placeholder' => 'Enter text...',
    'type' => 'text',
    'value' => '',
    'disabled' => false,
    'isRequired' => false,
])

<div class="form-group">
    <label for="{{ $id }}" class="block mb-1 text-xs font-medium text-gray-600">{{ $label }}</label>
    <input type="{{ $type }}" id="{{ $id }}" name="{{ $id }}" placeholder="{{ $placeholder }}"
        value="{{ old($id, $value) }}" @if ($disabled) disabled @endif
        @if ($isRequired) required @endif
        class="w-full rounded-md bg-gray-50 border border-gray-300 text-xs text-gray-900 placeholder-gray-400 px-3 py-2 transition-all focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:text-xs" />
    <span id="error-{{ $id }}" class="error-text invalid-feedback"></span>
</div>
