@props([
    'name' => 'input',
    'label' => 'Default Label',
    'icon' => null,
    'placeholder' => 'Choose file...',
    'info' => null,
    'type' => 'text',
    'value' => '',
    'required' => false,
    'disabled' => false,
    'accept' => null, // New prop for file type restrictions
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

    <div class="relative m-0">
        @if ($type === 'file')
            <div class="relative">
                <input id="{{ $name }}" name="{{ $name }}" type="file"
                    @if ($accept) accept="{{ $accept }}" @endif
                    @if ($disabled) disabled @endif
                    @if ($required) required aria-required="true" @endif
                    @if ($info) aria-describedby="{{ $name }}-info" @enderror
                    @error($name) aria-invalid="true" aria-describedby="{{ $name }}-error" @enderror
                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10
                        {{ $disabled ? 'cursor-not-allowed' : '' }}"
                    onchange="updateFileDisplay('{{ $name }}')"
                    {{ $attributes }} />

                <div class="w-full rounded-md bg-gray-50 border border-gray-300 text-xs text-gray-900 px-3 py-2 transition-all duration-200 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-blue-500 focus-within:bg-white
                    {{ $disabled ? 'opacity-50 cursor-not-allowed bg-gray-100' : 'hover:border-gray-400' }}
                    ___inline_directive_____________________________________________________________________1___">

                    <div class="flex items-center justify-between">
                        <span id="{{ $name }}-display" class="text-gray-500 truncate flex-1">
                            {{ $placeholder }}
                        </span>
                        <span class="ml-2 px-3 py-1 bg-blue-500 text-white rounded text-xs font-medium shrink-0
                            {{ $disabled ? 'bg-gray-400' : 'bg-blue-500 hover:bg-blue-600' }}">
                            Browse
                        </span>
                    </div>
                </div>
            </div>
        @else
            @if ($icon)
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 pointer-events-none"
                    aria-hidden="true">
                    <i class="{{ $icon }}" aria-hidden="true"></i>
                </span> @endif
                    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}"
                    placeholder="{{ $placeholder }}" value="{{ old($name, $value) }}"
                    @if ($disabled) disabled @endif
                    @if ($required) required aria-required="true" @endif
                    @if ($info) aria-describedby="{{ $name }}-info" @endif
                    @error($name) aria-invalid="true" aria-describedby="{{ $name }}-error" @enderror
                    class="w-full rounded-md bg-gray-50 border border-gray-300 text-xs text-gray-900 placeholder-gray-400 px-3 py-2 transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white focus:outline-none
                    {{ $icon ? 'pl-10' : 'pl-3' }}
                    {{ $type === 'password' ? 'pr-12' : 'pr-4' }}
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
        @endif
    </div>

    @error($name)
        <span id="{{ $name }}-error" class="text-red-500 text-xs mt-1 block"
            role="alert">{{ $message }}</span>
    @enderror
</fieldset>

@if ($type === 'password' || $type === 'file')
    @push('js')
        <script>
            @if ($type === 'password')
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
            @endif

            @if ($type === 'file')
                function updateFileDisplay(inputName) {
                    const input = document.getElementById(inputName);
                    const display = document.getElementById(inputName + '-display');

                    if (input.files && input.files.length > 0) {
                        if (input.files.length === 1) {
                            display.textContent = input.files[0].name;
                            display.classList.remove('text-gray-500');
                            display.classList.add('text-gray-900');
                        } else {
                            display.textContent = `${input.files.length} files selected`;
                            display.classList.remove('text-gray-500');
                            display.classList.add('text-gray-900');
                        }
                    } else {
                        display.textContent = '{{ $placeholder }}';
                        display.classList.remove('text-gray-900');
                        display.classList.add('text-gray-500');
                    }
                }
            @endif
        </script>
    @endpush
@endif
