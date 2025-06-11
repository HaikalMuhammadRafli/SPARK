@props([
    'id' => '',
    'name' => '',
    'label' => '',
    'placeholder' => 'Select an option',
    'options' => [],
    'value' => '',
    'allowClear' => true,
    'clearText' => 'All',
    'searchable' => false,
    'searchPlaceholder' => 'Search options...',
    'multiple' => false,
    'class' => '',
    'disabled' => false,
])

@php
    $uniqueId = $id ?: 'filter_' . uniqid();
@endphp

<fieldset class="filter-select-advanced {{ $class }}" data-filter-select-advanced="{{ $uniqueId }}">
    @if ($label)
        <label for="{{ $uniqueId }}" class="block text-xs font-medium text-gray-700 mb-1">
            {{ $label }}
        </label>
    @endif

    <div class="relative">
        @if ($searchable)
            <!-- Searchable Dropdown Button -->
            <button type="button"
                class="w-full px-3 py-2 text-xs text-left bg-white border border-gray-300 rounded-md hover:border-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 {{ $disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer' }}"
                onclick="toggleFilterDropdown('{{ $uniqueId }}')" {{ $disabled ? 'disabled' : '' }}>
                <span class="block truncate text-xs" data-selected-text="{{ $uniqueId }}">
                    {{ $placeholder }}
                </span>
                <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400 transition-transform dropdown-arrow" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </span>
            </button>

            <!-- Dropdown - positioned absolutely but rendered inline -->
            <div id="filter-dropdown-{{ $uniqueId }}"
                class="absolute hidden bg-white border border-gray-200 rounded-lg shadow-lg z-[9999] min-w-full mt-1"
                data-filter-dropdown="{{ $uniqueId }}" style="top: 100%; left: 0; right: 0;">

                <!-- Search Input -->
                <div class="p-2 border-b border-gray-200">
                    <input type="text"
                        class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                        placeholder="{{ $searchPlaceholder }}" data-search-input="{{ $uniqueId }}"
                        autocomplete="off">
                </div>

                <!-- Options -->
                <div class="max-h-60 overflow-auto p-1" data-options-container="{{ $uniqueId }}">
                    @if ($allowClear)
                        <div class="px-3 py-2 text-xs hover:bg-gray-100 cursor-pointer rounded filter-option"
                            data-option-value="" data-option-text="{{ $clearText }}"
                            onclick="selectFilterOption('{{ $uniqueId }}', '', '{{ $clearText }}')">
                            {{ $clearText }}
                        </div>
                    @endif

                    @foreach ($options as $optionValue => $optionLabel)
                        @php
                            $optVal = is_array($optionLabel) ? $optionLabel['value'] ?? $optionValue : $optionValue;
                            $optText = is_array($optionLabel)
                                ? $optionLabel['label'] ?? ($optionLabel['text'] ?? $optionValue)
                                : $optionLabel;
                        @endphp
                        <div class="px-3 py-2 text-xs hover:bg-gray-100 cursor-pointer rounded filter-option {{ $value == $optVal ? 'bg-blue-50 text-blue-700' : '' }}"
                            data-option-value="{{ $optVal }}" data-option-text="{{ $optText }}"
                            onclick="selectFilterOption('{{ $uniqueId }}', '{{ $optVal }}', '{{ $optText }}')">
                            {{ $optText }}
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Hidden select for form submission -->
            <select id="{{ $uniqueId }}" name="{{ $name ?: $uniqueId }}" class="hidden"
                data-hidden-select="{{ $uniqueId }}" {{ $multiple ? 'multiple' : '' }}>
                @if ($allowClear)
                    <option value="">{{ $clearText }}</option>
                @endif
                @foreach ($options as $optionValue => $optionLabel)
                    <option value="{{ is_array($optionLabel) ? $optionLabel['value'] ?? $optionValue : $optionValue }}"
                        {{ $value == (is_array($optionLabel) ? $optionLabel['value'] ?? $optionValue : $optionValue) ? 'selected' : '' }}>
                        {{ is_array($optionLabel) ? $optionLabel['label'] ?? ($optionLabel['text'] ?? $optionValue) : $optionLabel }}
                    </option>
                @endforeach
            </select>
        @else
            <!-- Regular Select -->
            <select id="{{ $uniqueId }}" name="{{ $name ?: $uniqueId }}"
                class="w-full px-3 py-2 text-xs bg-white border border-gray-300 rounded-md hover:border-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 appearance-none {{ $disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer' }}"
                {{ $multiple ? 'multiple' : '' }} {{ $disabled ? 'disabled' : '' }}>
                @if ($allowClear)
                    <option value="">{{ $clearText }}</option>
                @else
                    <option value="" disabled {{ $value ? '' : 'selected' }}>{{ $placeholder }}</option>
                @endif

                @foreach ($options as $optionValue => $optionLabel)
                    <option value="{{ is_array($optionLabel) ? $optionLabel['value'] ?? $optionValue : $optionValue }}"
                        {{ $value == (is_array($optionLabel) ? $optionLabel['value'] ?? $optionValue : $optionValue) ? 'selected' : '' }}>
                        {{ is_array($optionLabel) ? $optionLabel['label'] ?? ($optionLabel['text'] ?? $optionValue) : $optionLabel }}
                    </option>
                @endforeach
            </select>

            @if (!$multiple && false)
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            @endif
        @endif
    </div>
</fieldset>

@if ($searchable)
    <script>
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeFilterDropdown('{{ $uniqueId }}');
        });

        function initializeFilterDropdown(uniqueId) {
            const searchInput = document.querySelector(`[data-search-input="${uniqueId}"]`);
            const hiddenSelect = document.querySelector(`[data-hidden-select="${uniqueId}"]`);
            const selectedText = document.querySelector(`[data-selected-text="${uniqueId}"]`);

            // Set initial text if value exists
            if (hiddenSelect && hiddenSelect.value) {
                const initialOption = document.querySelector(`[data-option-value="${hiddenSelect.value}"]`);
                if (initialOption) {
                    selectedText.textContent = initialOption.getAttribute('data-option-text');
                }
            }

            // Set up search input listener
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    filterOptions(uniqueId);
                });

                // Keyboard navigation
                searchInput.addEventListener('keydown', function(e) {
                    handleKeyNavigation(e, uniqueId);
                });
            }
        }

        function toggleFilterDropdown(uniqueId) {
            const button = document.querySelector(`button[onclick="toggleFilterDropdown('${uniqueId}')"]`);
            const dropdown = document.getElementById('filter-dropdown-' + uniqueId);
            const arrow = button.querySelector('.dropdown-arrow');
            const searchInput = dropdown.querySelector('[data-search-input]');

            // Close other filter dropdowns first
            document.querySelectorAll('[id^="filter-dropdown-"]').forEach(function(otherDropdown) {
                if (otherDropdown.id !== 'filter-dropdown-' + uniqueId) {
                    otherDropdown.classList.add('hidden');
                    const otherId = otherDropdown.id.replace('filter-dropdown-', '');
                    const otherButton = document.querySelector(
                        `button[onclick="toggleFilterDropdown('${otherId}')"]`);
                    if (otherButton) {
                        const otherArrow = otherButton.querySelector('.dropdown-arrow');
                        if (otherArrow) otherArrow.classList.remove('rotate-180');
                    }
                }
            });

            // Toggle current dropdown
            const isHidden = dropdown.classList.contains('hidden');

            if (isHidden) {
                // Check if dropdown should appear above or below
                const buttonRect = button.getBoundingClientRect();
                const viewportHeight = window.innerHeight;
                const dropdownHeight = 300; // estimated

                if (buttonRect.bottom + dropdownHeight > viewportHeight && buttonRect.top > dropdownHeight) {
                    // Show above
                    dropdown.style.top = 'auto';
                    dropdown.style.bottom = '100%';
                    dropdown.style.marginBottom = '4px';
                    dropdown.style.marginTop = '0';
                } else {
                    // Show below (default)
                    dropdown.style.top = '100%';
                    dropdown.style.bottom = 'auto';
                    dropdown.style.marginTop = '4px';
                    dropdown.style.marginBottom = '0';
                }

                dropdown.classList.remove('hidden');
                arrow.classList.add('rotate-180');

                // Focus search input and reset filter
                setTimeout(() => {
                    if (searchInput) {
                        searchInput.focus();
                        searchInput.value = '';
                        filterOptions(uniqueId);
                    }
                }, 100);
            } else {
                dropdown.classList.add('hidden');
                arrow.classList.remove('rotate-180');
            }
        }

        function filterOptions(uniqueId) {
            const searchInput = document.querySelector(`[data-search-input="${uniqueId}"]`);
            const filter = searchInput.value.toLowerCase();
            const dropdown = document.getElementById('filter-dropdown-' + uniqueId);
            const options = dropdown.querySelectorAll('.filter-option');

            options.forEach(function(option) {
                const optionText = option.getAttribute('data-option-text').toLowerCase();
                option.style.display = optionText.includes(filter) ? '' : 'none';
            });
        }

        function selectFilterOption(uniqueId, value, text) {
            const hiddenSelect = document.querySelector(`[data-hidden-select="${uniqueId}"]`);
            const selectedText = document.querySelector(`[data-selected-text="${uniqueId}"]`);
            const dropdown = document.getElementById('filter-dropdown-' + uniqueId);
            const button = document.querySelector(`button[onclick="toggleFilterDropdown('${uniqueId}')"]`);
            const arrow = button.querySelector('.dropdown-arrow');

            // Update hidden select and display
            hiddenSelect.value = value;
            selectedText.textContent = text;

            // Update visual selection
            dropdown.querySelectorAll('.filter-option').forEach(opt => {
                opt.classList.remove('bg-blue-50', 'text-blue-700');
            });
            const selectedOption = dropdown.querySelector(`[data-option-value="${value}"]`);
            if (selectedOption) {
                selectedOption.classList.add('bg-blue-50', 'text-blue-700');
            }

            // Trigger change event for form handling
            hiddenSelect.dispatchEvent(new Event('change'));

            // Close dropdown
            dropdown.classList.add('hidden');
            arrow.classList.remove('rotate-180');
        }

        function handleKeyNavigation(e, uniqueId) {
            const dropdown = document.getElementById('filter-dropdown-' + uniqueId);
            const visibleOptions = dropdown.querySelectorAll(
                '.filter-option[style=""], .filter-option:not([style*="display: none"])');
            const currentFocus = dropdown.querySelector('.filter-option.bg-gray-200');

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                if (currentFocus) {
                    currentFocus.classList.remove('bg-gray-200');
                    const currentIndex = Array.from(visibleOptions).indexOf(currentFocus);
                    const nextOption = visibleOptions[currentIndex + 1];
                    if (nextOption) {
                        nextOption.classList.add('bg-gray-200');
                        nextOption.scrollIntoView({
                            block: 'nearest'
                        });
                    }
                } else if (visibleOptions.length > 0) {
                    visibleOptions[0].classList.add('bg-gray-200');
                }
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                if (currentFocus) {
                    currentFocus.classList.remove('bg-gray-200');
                    const currentIndex = Array.from(visibleOptions).indexOf(currentFocus);
                    const prevOption = visibleOptions[currentIndex - 1];
                    if (prevOption) {
                        prevOption.classList.add('bg-gray-200');
                        prevOption.scrollIntoView({
                            block: 'nearest'
                        });
                    }
                }
            } else if (e.key === 'Enter') {
                e.preventDefault();
                if (currentFocus) {
                    currentFocus.click();
                }
            } else if (e.key === 'Escape') {
                e.preventDefault();
                toggleFilterDropdown(uniqueId);
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('[data-filter-select-advanced]') &&
                !event.target.closest('[data-filter-dropdown]')) {
                document.querySelectorAll('[id^="filter-dropdown-"]').forEach(function(dropdown) {
                    dropdown.classList.add('hidden');
                    const dropdownId = dropdown.id.replace('filter-dropdown-', '');
                    const button = document.querySelector(
                        `button[onclick="toggleFilterDropdown('${dropdownId}')"]`);
                    if (button) {
                        const arrow = button.querySelector('.dropdown-arrow');
                        if (arrow) arrow.classList.remove('rotate-180');
                    }
                });
            }
        });

        // Clear keyboard focus on mouse hover
        document.addEventListener('mouseover', function(e) {
            if (e.target.classList.contains('filter-option')) {
                document.querySelectorAll('.filter-option.bg-gray-200').forEach(opt => {
                    opt.classList.remove('bg-gray-200');
                });
            }
        });
    </script>
@endif
