@props([
    'name' => 'selected_items',
    'title' => 'Select Options',
    'options' => [],
    'selected' => [],
    'searchable' => true,
    'placeholder' => 'Search...',
    'required' => false,
])

@php
    $selectedValues = is_array($selected) ? $selected : [];
    $selectedCount = count(array_intersect($selectedValues, array_keys($options)));
    $uniqueId = 'dropdown_' . uniqid();
@endphp

<fieldset class="relative w-full">
    <button type="button" onclick="toggleDropdown('{{ $uniqueId }}')"
        class="w-full text-left bg-white border border-gray-300 hover:border-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-medium rounded-lg text-xs px-4 py-2 flex items-center justify-between {{ $required ? 'required' : '' }}"
        data-title="{{ $title }}">
        <span class="truncate">
            @if ($selectedCount == 0)
                {{ $title }}
            @elseif($selectedCount == 1)
                @php
                    $firstSelected = array_intersect($selectedValues, array_keys($options));
                    $selectedKey = !empty($firstSelected) ? array_values($firstSelected)[0] : array_keys($options)[0];
                    $selectedOption = $options[$selectedKey] ?? 'Selected';
                @endphp
                {{ $selectedOption }}
            @else
                {{ $selectedCount }} selected
            @endif
        </span>
        <svg class="w-2 h-2 transition-transform dropdown-arrow" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 4 4 4-4" />
        </svg>
    </button>
    @error($name)
        <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
    @enderror
</fieldset>

<!-- Dropdown rendered at body level to avoid table overflow constraints -->
<div id="dropdown-{{ $uniqueId }}"
    class="fixed hidden bg-white border border-gray-200 rounded-lg shadow-lg w-80 mt-1 z-[9999]"
    style="max-width: 320px;" data-name="{{ $name }}">

    @if ($searchable)
        <div class="p-3 border-b border-gray-200">
            <div class="relative">
                <input type="text" id="search-{{ $uniqueId }}" onkeyup="filterDropdown('{{ $uniqueId }}')"
                    class="block w-full pl-8 pr-4 py-2 text-xs text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="{{ $placeholder }}">
                <svg class="absolute left-2.5 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>
    @endif

    <div class="p-2">
        <div class="flex justify-between items-center px-2 py-1 text-xs border-b border-gray-100 mb-2">
            <button type="button" onclick="selectAll('{{ $uniqueId }}')"
                class="text-blue-600 hover:text-blue-800">
                Select All
            </button>
            <button type="button" onclick="clearAll('{{ $uniqueId }}')" class="text-gray-600 hover:text-gray-800">
                Clear All
            </button>
        </div>

        <ul class="max-h-48 overflow-y-auto text-sm">
            @foreach ($options as $value => $label)
                <li class="dropdown-item" data-search="{{ strtolower($label) }}">
                    <div class="flex items-center px-2 py-1.5 rounded hover:bg-gray-50">
                        <input type="checkbox" name="{{ $name }}" value="{{ $value }}"
                            id="checkbox-{{ $uniqueId }}-{{ $value }}"
                            {{ in_array($value, $selectedValues) ? 'checked' : '' }}
                            onchange="updateDropdownTitle('{{ $uniqueId }}')"
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 {{ $required ? 'required' : '' }}">
                        <label for="checkbox-{{ $uniqueId }}-{{ $value }}"
                            class="flex-1 ml-2 text-sm font-medium text-gray-900 cursor-pointer">
                            {{ $label }}
                        </label>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<script>
    function toggleDropdown(uniqueId) {
        const button = document.querySelector(`button[onclick="toggleDropdown('${uniqueId}')"]`);
        const dropdown = document.getElementById('dropdown-' + uniqueId);
        const arrow = button.querySelector('.dropdown-arrow');

        // Close other dropdowns first
        document.querySelectorAll('[id^="dropdown-"]').forEach(function(otherDropdown) {
            if (otherDropdown.id !== 'dropdown-' + uniqueId) {
                otherDropdown.classList.add('hidden');
                const otherId = otherDropdown.id.replace('dropdown-', '');
                const otherButton = document.querySelector(`button[onclick="toggleDropdown('${otherId}')"]`);
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

            if (buttonRect.bottom + dropdownHeight > viewportHeight) {
                if (buttonRect.top > dropdownHeight) {
                    top = buttonRect.top + window.scrollY - dropdownHeight;
                }
            }

            if (left + dropdownWidth > viewportWidth) {
                left = Math.max(10, viewportWidth - dropdownWidth - 10);
            }

            dropdown.style.top = top + 'px';
            dropdown.style.left = left + 'px';
            dropdown.classList.remove('hidden');
            arrow.classList.add('rotate-180');

            const searchInput = dropdown.querySelector('input[type="text"]');
            if (searchInput) {
                setTimeout(() => searchInput.focus(), 100);
            }
        } else {
            dropdown.classList.add('hidden');
            arrow.classList.remove('rotate-180');
        }
    }

    function filterDropdown(uniqueId) {
        const searchInput = document.getElementById('search-' + uniqueId);
        const filter = searchInput.value.toLowerCase();
        const dropdown = document.getElementById('dropdown-' + uniqueId);
        const items = dropdown.querySelectorAll('.dropdown-item');

        items.forEach(function(item) {
            const searchText = item.getAttribute('data-search');
            item.style.display = searchText.includes(filter) ? '' : 'none';
        });
    }

    function updateDropdownTitle(uniqueId) {
        const button = document.querySelector(`button[onclick="toggleDropdown('${uniqueId}')"]`);
        const dropdown = document.getElementById('dropdown-' + uniqueId);
        const nameAttr = dropdown.getAttribute('data-name');
        const checkboxes = dropdown.querySelectorAll(`input[name="${nameAttr}"]:checked`);
        const span = button.querySelector('span');

        if (checkboxes.length === 0) {
            span.textContent = button.getAttribute('data-title') || 'Select Options';
        } else if (checkboxes.length === 1) {
            const label = dropdown.querySelector(`label[for="${checkboxes[0].id}"]`);
            span.textContent = label.textContent.trim();
        } else {
            span.textContent = `${checkboxes.length} selected`;
        }

        if (typeof validator !== 'undefined' && validator && checkboxes.length > 0) {
            validator.element(checkboxes[0]);
        }
    }

    function selectAll(uniqueId) {
        const dropdown = document.getElementById('dropdown-' + uniqueId);
        const visibleItems = dropdown.querySelectorAll('.dropdown-item:not([style*="display: none"])');

        visibleItems.forEach(item => {
            const checkbox = item.querySelector('input[type="checkbox"]');
            if (checkbox) checkbox.checked = true;
        });
        updateDropdownTitle(uniqueId);
    }

    function clearAll(uniqueId) {
        const dropdown = document.getElementById('dropdown-' + uniqueId);
        const nameAttr = dropdown.getAttribute('data-name');
        const checkboxes = dropdown.querySelectorAll(`input[name="${nameAttr}"]`);
        checkboxes.forEach(checkbox => checkbox.checked = false);
        updateDropdownTitle(uniqueId);
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('[id^="dropdown-"]') &&
            !event.target.closest('button[onclick*="toggleDropdown"]')) {
            document.querySelectorAll('[id^="dropdown-"]').forEach(function(dropdown) {
                dropdown.classList.add('hidden');
                const dropdownId = dropdown.id.replace('dropdown-', '');
                const button = document.querySelector(
                    `button[onclick="toggleDropdown('${dropdownId}')"]`);
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
            document.querySelectorAll('[id^="dropdown-"]').forEach(function(dropdown) {
                dropdown.classList.add('hidden');
                const dropdownId = dropdown.id.replace('dropdown-', '');
                const button = document.querySelector(
                    `button[onclick="toggleDropdown('${dropdownId}')"]`);
                if (button) {
                    const arrow = button.querySelector('.dropdown-arrow');
                    if (arrow) arrow.classList.remove('rotate-180');
                }
            });
        }
    });

    // Reposition dropdown on window resize/scroll
    window.addEventListener('resize', function() {
        document.querySelectorAll('[id^="dropdown-"]:not(.hidden)').forEach(function(dropdown) {
            const dropdownId = dropdown.id.replace('dropdown-', '');
            toggleDropdown(dropdownId);
            toggleDropdown(dropdownId);
        });
    });

    window.addEventListener('scroll', function() {
        document.querySelectorAll('[id^="dropdown-"]:not(.hidden)').forEach(function(dropdown) {
            const dropdownId = dropdown.id.replace('dropdown-', '');
            const button = document.querySelector(`button[onclick="toggleDropdown('${dropdownId}')"]`);
            if (button) {
                const buttonRect = button.getBoundingClientRect();
                dropdown.style.top = (buttonRect.bottom + window.scrollY) + 'px';
                dropdown.style.left = (buttonRect.left + window.scrollX) + 'px';
            }
        });
    });
</script>
