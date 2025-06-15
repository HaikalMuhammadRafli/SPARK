@props([
    'name' => 'select',
    'label' => null,
    'icon' => null,
    'placeholder' => null,
    'options' => [],
    'selected' => null,
    'required' => false,
    'disabled' => false,
    'searchable' => false,
    'searchPlaceholder' => 'Search options...',
    'allowClear' => true,
    'clearText' => 'Select an option',
    'class' => '',
])

@php
    $clean_name = str_replace(['[', ']'], '', $name);
    $unique_id = $clean_name . '_' . uniqid();
@endphp

<fieldset class="form-group {{ $class }}">
    @if ($label)
        <label for="{{ $clean_name }}" class="block mb-1 text-xs font-medium text-gray-600">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative w-full">
        @if ($searchable)
            <!-- Searchable Select Button -->
            <button type="button"
                class="w-full rounded-md bg-gray-50 border border-gray-300 text-xs text-gray-900 px-3 py-2 transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white focus:outline-none {{ $disabled ? 'opacity-50 cursor-not-allowed bg-gray-100' : 'hover:border-gray-400 cursor-pointer' }} {{ $icon ? 'pl-10' : 'pl-3' }} text-left"
                onclick="toggleSelectDropdown('{{ $unique_id }}')" {{ $disabled ? 'disabled' : '' }}>

                @if ($icon)
                    <i class="{{ $icon }} absolute left-3 text-gray-400" aria-hidden="true"></i>
                @endif

                <span class="block truncate text-xs" data-selected-text="{{ $unique_id }}">
                    @if ($selected && isset($options[$selected]))
                        {{ $options[$selected] }}
                    @elseif($placeholder)
                        {{ $placeholder }}
                    @else
                        {{ $clearText }}
                    @endif
                </span>
                <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400 transition-transform dropdown-arrow" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </span>
            </button>

            <!-- Hidden select for form submission -->
            <select id="{{ $clean_name }}" name="{{ $name }}" class="hidden"
                data-hidden-select="{{ $unique_id }}" @if ($required) required @endif
                {{ $attributes->except(['class']) }}>
                @if ($placeholder || $allowClear)
                    <option value="" @selected(empty(old($clean_name, $selected)))>
                        {{ $placeholder ?: $clearText }}
                    </option>
                @endif

                @forelse ($options as $value => $optionLabel)
                    <option value="{{ $value }}" @selected((string) old($clean_name, $selected) === (string) $value)>
                        {{ $optionLabel }}
                    </option>
                @empty
                    <option value="" disabled>No options available</option>
                @endforelse
            </select>
        @else
            <!-- Regular Select -->
            @if ($icon)
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 pointer-events-none">
                    <i class="{{ $icon }}" aria-hidden="true"></i>
                </span>
            @endif

            <select id="{{ $clean_name }}" name="{{ $name }}"
                @if ($required) required @endif @if ($disabled) disabled @endif
                class="w-full rounded-md bg-gray-50 border border-gray-300 text-xs text-gray-900 px-3 py-2 transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white focus:outline-none {{ $disabled ? 'opacity-50 cursor-not-allowed bg-gray-100' : 'hover:border-gray-400' }} {{ $icon ? 'pl-10' : 'pl-3' }}"
                {{ $attributes->except(['class']) }}>

                @if ($placeholder)
                    <option value="" disabled @selected(empty(old($clean_name, $selected)))>
                        {{ $placeholder }}
                    </option>
                @endif

                @forelse ($options as $value => $optionLabel)
                    <option value="{{ $value }}" @selected((string) old($clean_name, $selected) === (string) $value)>
                        {{ $optionLabel }}
                    </option>
                @empty
                    <option value="" disabled>No options available</option>
                @endforelse
            </select>
        @endif
    </div>

    @error($name)
        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
    @enderror
</fieldset>

@if ($searchable)
    <!-- Dropdown rendered at body level to avoid table overflow constraints -->
    <div id="select-dropdown-{{ $unique_id }}"
        class="fixed hidden bg-white border border-gray-200 rounded-lg shadow-lg w-80 mt-1 z-[9999]"
        style="max-width: 320px;" data-select-name="{{ $name }}">

        <!-- Search Input -->
        <div class="p-3 border-b border-gray-200">
            <div class="relative">
                <input type="text" id="search-{{ $unique_id }}"
                    onkeyup="filterSelectOptions('{{ $unique_id }}')"
                    class="block w-full pl-8 pr-4 py-2 text-xs text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="{{ $searchPlaceholder }}">
                <svg class="absolute left-2.5 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Options -->
        <div class="p-2">
            <ul class="max-h-48 overflow-y-auto text-xs">
                @if ($allowClear)
                    <li class="select-option-item" data-search="{{ strtolower($placeholder ?: $clearText) }}">
                        <div class="flex items-center px-2 py-1.5 rounded hover:bg-gray-50 cursor-pointer"
                            onclick="selectOption('{{ $unique_id }}', '', '{{ $placeholder ?: $clearText }}')">
                            <span class="flex-1 text-xs text-gray-900">
                                {{ $placeholder ?: $clearText }}
                            </span>
                        </div>
                    </li>
                @endif

                @forelse ($options as $value => $optionLabel)
                    <li class="select-option-item" data-search="{{ strtolower($optionLabel) }}">
                        <div class="flex items-center px-2 py-1.5 rounded hover:bg-gray-50 cursor-pointer {{ (string) old($clean_name, $selected) === (string) $value ? 'bg-blue-50 text-blue-700' : '' }}"
                            onclick="selectOption('{{ $unique_id }}', '{{ $value }}', '{{ $optionLabel }}')"
                            data-option-value="{{ $value }}">
                            <span class="flex-1 text-xs">
                                {{ $optionLabel }}
                            </span>
                            @if ((string) old($clean_name, $selected) === (string) $value)
                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            @endif
                        </div>
                    </li>
                @empty
                    <li class="px-2 py-1.5 text-gray-500 text-xs">No options available</li>
                @endforelse
            </ul>
        </div>
    </div>

    <script>
        function toggleSelectDropdown(uniqueId) {
            const button = document.querySelector(`button[onclick="toggleSelectDropdown('${uniqueId}')"]`);
            const dropdown = document.getElementById('select-dropdown-' + uniqueId);
            const arrow = button.querySelector('.dropdown-arrow');

            // Close other select dropdowns first
            document.querySelectorAll('[id^="select-dropdown-"]').forEach(function(otherDropdown) {
                if (otherDropdown.id !== 'select-dropdown-' + uniqueId) {
                    otherDropdown.classList.add('hidden');
                    const otherId = otherDropdown.id.replace('select-dropdown-', '');
                    const otherButton = document.querySelector(
                        `button[onclick="toggleSelectDropdown('${otherId}')"]`);
                    if (otherButton) {
                        const otherArrow = otherButton.querySelector('.dropdown-arrow');
                        if (otherArrow) otherArrow.classList.remove('rotate-180');
                    }
                }
            });

            // Toggle current dropdown
            const isHidden = dropdown.classList.contains('hidden');

            if (isHidden) {
                // Position the dropdown relative to the button
                const buttonRect = button.getBoundingClientRect();
                const viewportHeight = window.innerHeight;
                const viewportWidth = window.innerWidth;
                const dropdownHeight = 300;
                const dropdownWidth = 320;

                let top = buttonRect.bottom + window.scrollY;
                let left = buttonRect.left + window.scrollX;

                // Check if dropdown should appear above
                if (buttonRect.bottom + dropdownHeight > viewportHeight) {
                    if (buttonRect.top > dropdownHeight) {
                        top = buttonRect.top + window.scrollY - dropdownHeight;
                    }
                }

                // Check if dropdown should appear more to the left
                if (left + dropdownWidth > viewportWidth) {
                    left = Math.max(10, viewportWidth - dropdownWidth - 10);
                }

                dropdown.style.top = top + 'px';
                dropdown.style.left = left + 'px';
                dropdown.classList.remove('hidden');
                arrow.classList.add('rotate-180');

                // Focus search input
                const searchInput = dropdown.querySelector('input[type="text"]');
                if (searchInput) {
                    setTimeout(() => {
                        searchInput.focus();
                        searchInput.value = '';
                        filterSelectOptions(uniqueId);
                    }, 100);
                }
            } else {
                dropdown.classList.add('hidden');
                arrow.classList.remove('rotate-180');
            }
        }

        function filterSelectOptions(uniqueId) {
            const searchInput = document.getElementById('search-' + uniqueId);
            const filter = searchInput.value.toLowerCase();
            const dropdown = document.getElementById('select-dropdown-' + uniqueId);
            const items = dropdown.querySelectorAll('.select-option-item');

            items.forEach(function(item) {
                const searchText = item.getAttribute('data-search');
                item.style.display = searchText.includes(filter) ? '' : 'none';
            });
        }

        function selectOption(uniqueId, value, text) {
            const hiddenSelect = document.querySelector(`[data-hidden-select="${uniqueId}"]`);
            const selectedText = document.querySelector(`[data-selected-text="${uniqueId}"]`);
            const dropdown = document.getElementById('select-dropdown-' + uniqueId);
            const button = document.querySelector(`button[onclick="toggleSelectDropdown('${uniqueId}')"]`);
            const arrow = button.querySelector('.dropdown-arrow');

            // Update hidden select and display
            hiddenSelect.value = value;
            selectedText.textContent = text;

            // Update visual selection
            dropdown.querySelectorAll('[data-option-value]').forEach(opt => {
                opt.classList.remove('bg-blue-50', 'text-blue-700');
                const checkIcon = opt.querySelector('svg');
                if (checkIcon) checkIcon.remove();
            });

            const selectedOption = dropdown.querySelector(`[data-option-value="${value}"]`);
            if (selectedOption && value !== '') {
                selectedOption.classList.add('bg-blue-50', 'text-blue-700');
                selectedOption.innerHTML += `
                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            `;
            }

            // Trigger change event for form handling
            hiddenSelect.dispatchEvent(new Event('change'));

            // Close dropdown
            dropdown.classList.add('hidden');
            arrow.classList.remove('rotate-180');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('[id^="select-dropdown-"]') &&
                !event.target.closest('button[onclick*="toggleSelectDropdown"]')) {
                document.querySelectorAll('[id^="select-dropdown-"]').forEach(function(dropdown) {
                    dropdown.classList.add('hidden');
                    const dropdownId = dropdown.id.replace('select-dropdown-', '');
                    const button = document.querySelector(
                        `button[onclick="toggleSelectDropdown('${dropdownId}')"]`);
                    if (button) {
                        const arrow = button.querySelector('.dropdown-arrow');
                        if (arrow) arrow.classList.remove('rotate-180');
                    }
                });
            }
        });

        // Close dropdown on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                document.querySelectorAll('[id^="select-dropdown-"]').forEach(function(dropdown) {
                    dropdown.classList.add('hidden');
                    const dropdownId = dropdown.id.replace('select-dropdown-', '');
                    const button = document.querySelector(
                        `button[onclick="toggleSelectDropdown('${dropdownId}')"]`);
                    if (button) {
                        const arrow = button.querySelector('.dropdown-arrow');
                        if (arrow) arrow.classList.remove('rotate-180');
                    }
                });
            }
        });

        // Reposition dropdown on window resize/scroll
        window.addEventListener('resize', function() {
            document.querySelectorAll('[id^="select-dropdown-"]:not(.hidden)').forEach(function(dropdown) {
                const dropdownId = dropdown.id.replace('select-dropdown-', '');
                toggleSelectDropdown(dropdownId);
                toggleSelectDropdown(dropdownId);
            });
        });

        window.addEventListener('scroll', function() {
            document.querySelectorAll('[id^="select-dropdown-"]:not(.hidden)').forEach(function(dropdown) {
                const dropdownId = dropdown.id.replace('select-dropdown-', '');
                const button = document.querySelector(
                    `button[onclick="toggleSelectDropdown('${dropdownId}')"]`);
                if (button) {
                    const buttonRect = button.getBoundingClientRect();
                    dropdown.style.top = (buttonRect.bottom + window.scrollY) + 'px';
                    dropdown.style.left = (buttonRect.left + window.scrollX) + 'px';
                }
            });
        });
    </script>
@endif
