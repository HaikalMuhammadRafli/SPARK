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
])

@php
    $clean_name = str_replace(['[', ']'], '', $name);
    $unique_id = $clean_name . '_' . uniqid();
@endphp

<fieldset class="form-group w-full">
    @if ($label)
        <label for="{{ $clean_name }}" class="block mb-1 text-xs font-medium text-gray-600">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        @if ($searchable)
            <!-- Searchable Select -->
            <div class="relative" data-searchable-select="{{ $unique_id }}">
                @if ($icon)
                    <span
                        class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 pointer-events-none z-10">
                        <i class="{{ $icon }}" aria-hidden="true"></i>
                    </span>
                @endif

                <button type="button"
                    class="w-full rounded-md bg-gray-50 border border-gray-300 text-xs text-gray-900 px-3 py-2 transition-all duration-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 focus:bg-white focus:outline-none {{ $disabled ? 'opacity-50 cursor-not-allowed bg-gray-100' : 'hover:border-gray-400 cursor-pointer' }} {{ $icon ? 'pl-10' : 'pl-3' }} text-left"
                    data-toggle-button="{{ $unique_id }}" {{ $disabled ? 'disabled' : '' }}>
                    <span class="block truncate" data-selected-text="{{ $unique_id }}">
                        @if ($selected && isset($options[$selected]))
                            {{ $options[$selected] }}
                        @elseif($placeholder)
                            {{ $placeholder }}
                        @else
                            {{ $clearText }}
                        @endif
                    </span>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-200 dropdown-arrow"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </span>
                </button>

                <!-- Dropdown -->
                <div id="{{ $unique_id }}-dropdown"
                    class="absolute hidden z-50 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg"
                    data-dropdown="{{ $unique_id }}">
                    <!-- Search Input -->
                    <div class="p-2 border-b border-gray-200">
                        <div class="relative">
                            <input type="text"
                                class="w-full px-2 py-1 text-xs border border-gray-300 rounded focus:border-blue-500 focus:ring-1 focus:ring-blue-500 pl-7"
                                placeholder="{{ $searchPlaceholder }}" data-search-input="{{ $unique_id }}"
                                autocomplete="off">
                            <svg class="absolute left-2 top-1.5 w-3 h-3 text-gray-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Options -->
                    <div class="overflow-auto max-h-48" data-options-container="{{ $unique_id }}">
                        @if ($allowClear)
                            <div class="px-3 py-2 hover:bg-gray-100 cursor-pointer text-xs select-option"
                                data-option-value="" data-option-text="{{ $placeholder ?: $clearText }}">
                                {{ $placeholder ?: $clearText }}
                            </div>
                        @endif

                        @forelse ($options as $value => $optionLabel)
                            <div class="px-3 py-2 hover:bg-gray-100 cursor-pointer text-xs select-option {{ (string) old($clean_name, $selected) === (string) $value ? 'bg-blue-50 text-blue-700' : '' }}"
                                data-option-value="{{ $value }}" data-option-text="{{ $optionLabel }}">
                                {{ $optionLabel }}
                            </div>
                        @empty
                            <div class="px-3 py-2 text-gray-500 text-xs">No options available</div>
                        @endforelse
                    </div>
                </div>
            </div>

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
    @push('js')
        <script>
            $(document).ready(function() {
                // Initialize all searchable selects
                $('[data-searchable-select]').each(function() {
                    const uniqueId = $(this).data('searchable-select');
                    initSearchableSelect(uniqueId);
                });

                function initSearchableSelect(uniqueId) {
                    const container = $(`[data-searchable-select="${uniqueId}"]`);
                    const button = container.find(`[data-toggle-button="${uniqueId}"]`);
                    const dropdown = $(`#${uniqueId}-dropdown`);
                    const searchInput = $(`[data-search-input="${uniqueId}"]`);
                    const optionsContainer = $(`[data-options-container="${uniqueId}"]`);
                    const hiddenSelect = $(`[data-hidden-select="${uniqueId}"]`);
                    const selectedText = $(`[data-selected-text="${uniqueId}"]`);
                    const arrow = button.find('.dropdown-arrow');

                    // Toggle dropdown on button click
                    button.on('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        // Close other dropdowns
                        $('[data-dropdown]').not(dropdown).addClass('hidden');
                        $('[data-toggle-button] .dropdown-arrow').not(arrow).removeClass('rotate-180');

                        // Toggle current dropdown
                        const isHidden = dropdown.hasClass('hidden');

                        if (isHidden) {
                            // Position dropdown
                            const buttonRect = button[0].getBoundingClientRect();
                            const viewportHeight = window.innerHeight;
                            const dropdownHeight = 300;

                            if (buttonRect.bottom + dropdownHeight > viewportHeight && buttonRect.top >
                                dropdownHeight) {
                                dropdown.css({
                                    'top': 'auto',
                                    'bottom': '100%',
                                    'margin-bottom': '4px',
                                    'margin-top': '0'
                                });
                            } else {
                                dropdown.css({
                                    'top': '100%',
                                    'bottom': 'auto',
                                    'margin-top': '4px',
                                    'margin-bottom': '0'
                                });
                            }

                            dropdown.removeClass('hidden');
                            arrow.addClass('rotate-180');

                            // Focus search and reset
                            setTimeout(() => {
                                searchInput.focus();
                                searchInput.val('');
                                filterOptions();
                            }, 100);
                        } else {
                            dropdown.addClass('hidden');
                            arrow.removeClass('rotate-180');
                        }
                    });

                    // Search functionality
                    searchInput.on('input', filterOptions);

                    function filterOptions() {
                        const filter = searchInput.val().toLowerCase();
                        optionsContainer.find('.select-option').each(function() {
                            const text = $(this).data('option-text').toString().toLowerCase();
                            $(this).toggle(text.includes(filter));
                        });
                    }

                    // Option selection
                    optionsContainer.on('click', '.select-option', function(e) {
                        e.preventDefault();
                        const value = $(this).data('option-value');
                        const text = $(this).data('option-text');

                        // Update values
                        hiddenSelect.val(value).trigger('change');
                        selectedText.text(text);

                        // Update visual selection
                        optionsContainer.find('.select-option').removeClass('bg-blue-50 text-blue-700');
                        $(this).addClass('bg-blue-50 text-blue-700');

                        // Close dropdown
                        dropdown.addClass('hidden');
                        arrow.removeClass('rotate-180');
                    });

                    // Keyboard navigation
                    searchInput.on('keydown', function(e) {
                        const visibleOptions = optionsContainer.find('.select-option:visible');
                        const currentFocus = optionsContainer.find('.select-option.keyboard-focus');

                        if (e.key === 'ArrowDown') {
                            e.preventDefault();
                            if (currentFocus.length) {
                                currentFocus.removeClass('keyboard-focus');
                                const currentIndex = visibleOptions.index(currentFocus);
                                const nextOption = visibleOptions.eq(currentIndex + 1);
                                if (nextOption.length) {
                                    nextOption.addClass('keyboard-focus');
                                    nextOption[0].scrollIntoView({
                                        block: 'nearest'
                                    });
                                }
                            } else if (visibleOptions.length > 0) {
                                visibleOptions.first().addClass('keyboard-focus');
                            }
                        } else if (e.key === 'ArrowUp') {
                            e.preventDefault();
                            if (currentFocus.length) {
                                currentFocus.removeClass('keyboard-focus');
                                const currentIndex = visibleOptions.index(currentFocus);
                                const prevOption = visibleOptions.eq(currentIndex - 1);
                                if (prevOption.length) {
                                    prevOption.addClass('keyboard-focus');
                                    prevOption[0].scrollIntoView({
                                        block: 'nearest'
                                    });
                                }
                            }
                        } else if (e.key === 'Enter') {
                            e.preventDefault();
                            if (currentFocus.length) {
                                currentFocus.click();
                            }
                        } else if (e.key === 'Escape') {
                            e.preventDefault();
                            dropdown.addClass('hidden');
                            arrow.removeClass('rotate-180');
                            button.focus();
                        }
                    });

                    // Clear keyboard focus on mouse hover
                    optionsContainer.on('mouseenter', '.select-option', function() {
                        optionsContainer.find('.select-option').removeClass('keyboard-focus');
                    });
                }

                // Click outside to close all dropdowns
                $(document).on('click', function(e) {
                    if (!$(e.target).closest('[data-searchable-select], [data-dropdown]').length) {
                        $('[data-dropdown]').addClass('hidden');
                        $('[data-toggle-button] .dropdown-arrow').removeClass('rotate-180');
                    }
                });
            });
        </script>
    @endpush

    @push('css')
        <style>
            .select-option.keyboard-focus {
                @apply bg-gray-200;
            }
        </style>
    @endpush
@endif
