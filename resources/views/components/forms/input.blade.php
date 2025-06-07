@props([
    'name' => 'input',
    'label' => 'Default Label',
    'icon' => null,
    'placeholder' => 'Enter text...',
    'info' => null,
    'type' => 'text',
    'value' => '',
    'required' => false,
    'disabled' => false,
])

<fieldset class="form-group {{ empty($info) ? 'space-y-4' : '' }}">
    <label for="{{ $name }}" class="block mb-1 text-xs font-medium text-gray-600">
        {{ $label }}
        @if ($required)
            <span class="text-red-500" aria-label="required">*</span>
        @endif
    </label>

    @if ($info)
        <p id="{{ $name }}-info" class="mt-1 mb-3 text-xs text-gray-500">{{ $info }}</p>
    @endif

    <div class="relative">
        @if ($icon && $type !== 'file')
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 pointer-events-none"
                aria-hidden="true">
                <i class="{{ $icon }}" aria-hidden="true"></i>
            </span>
        @endif

        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
            placeholder="{{ $placeholder }}" value="{{ $type !== 'file' ? old($name, $value) : '' }}"
            @if ($disabled) disabled @endif
            @if ($required) required aria-required="true" @endif
            @if ($info) aria-describedby="{{ $name }}-info" @endif
            @error($name) aria-invalid="true" aria-describedby="{{ $name }}-error" @enderror
            class="w-full rounded-md bg-gray-50 border border-gray-300 text-xs text-gray-900 placeholder-gray-400 px-3 py-2 transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white focus:outline-none
                {{ $icon && $type !== 'file' ? 'pl-10' : 'pl-3' }}
                {{ $type === 'password' ? 'pr-12' : 'pr-4' }}
                {{ $type === 'file' ? 'file:mr-4 file:py-2 file:px-4 file:border-0 file:rounded file:bg-primary file:text-white file:cursor-pointer' : '' }}
                {{ $disabled ? 'opacity-50 cursor-not-allowed bg-gray-100' : 'hover:border-gray-400' }}
                @error($name) border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
            @if ($type === 'number') oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                onwheel="this.blur()" @endif
            @if ($type === 'text') oninput="this.value = this.value.replace(/[^a-zA-Z0-9\s.,?!:;'\-&quot;\-\()\/]/g, '')" @endif
            {{ $attributes }} />

        @if ($type === 'password')
            <button type="button"
                class="absolute top-1/2 right-0 -translate-y-1/2 pr-4 text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700"
                onclick="togglePassword('{{ $name }}')" aria-label="Toggle password visibility">
                <i class="fa-solid fa-eye" id="{{ $name }}-eye"></i>
            </button>
        @endif
    </div>

    @error($name)
        <span id="{{ $name }}-error" class="text-red-500 text-xs mt-1 block"
            role="alert">{{ $message }}</span>
    @enderror
</fieldset>

@if ($type === 'password')
    @push('scripts')
        <script>
            function togglePassword(inputName) {
                const input = document.getElementById(inputName);
                const eye = document.getElementById(inputName + '-eye');

                if (input.type === 'password') {
                    input.type = 'text';
                    eye.classList.remove('fa-eye');
                    eye.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    eye.classList.remove('fa-eye-slash');
                    eye.classList.add('fa-eye');
                }
            }
        </script>
    @endpush
@endif
