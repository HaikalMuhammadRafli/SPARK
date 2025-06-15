@props([
    'id' => 'select_id',
    'label' => 'Opsi',
    'data' => [],
    'value' => null,
    'isRequired' => false,
    'disabled' => false,
])

@php
    $selected = old($id, $value);

    if (is_object($data) && method_exists($data, 'pluck')) {
        $options = $data->pluck($id . '_nama', $id . '_id')->toArray();
    } elseif (is_array($data) && array_is_list($data)) {
        $options = array_combine($data, $data);
    } else {
        $options = $data;
    }
@endphp

<div class="form-group w-full">
    <label for="{{ $id }}" class="block mb-1 text-xs font-medium text-gray-600">
        Pilih {{ $label }}
    </label>
    <select id="{{ $id }}" name="{{ $id }}" {{ $isRequired ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        class="w-full rounded-md bg-gray-50 border border-gray-300 text-xs text-gray-900 placeholder-gray-400 px-3 py-2 transition-all focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder:text-xs">

        <option value="" disabled {{ is_null($selected) ? 'selected' : '' }}>-- Pilih {{ $label }} --
        </option>

        @foreach ($options as $optionValue => $text)
            <option value="{{ $optionValue }}" {{ $selected == $optionValue ? 'selected' : '' }}>
                {{ $text }}
            </option>
        @endforeach
    </select>
</div>
