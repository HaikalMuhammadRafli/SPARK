{{-- checkbox-dropdown.blade.php --}}
@props([
    'name' => 'selected_items',
    'title' => 'Select Options',
    'options' => [],
    'selected' => [],
    'searchable' => true,
])

<fieldset class="relative w-full">
    <button type="button" onclick="toggleDropdown('{{ $name }}')"
        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center flex items-center justify-between">
        {{ $title }}
        <svg class="w-2.5 h-2.5" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
        </svg>
    </button>

    <div id="dropdown-{{ $name }}"
        class="absolute top-full left-0 z-50 hidden bg-white rounded-lg shadow-lg w-full mt-1">
        @if ($searchable)
            <div class="p-3">
                <input type="text" id="search-{{ $name }}" onkeyup="filterDropdown('{{ $name }}')"
                    class="block w-full p-2 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Search...">
            </div>
        @endif

        <ul class="max-h-48 px-3 pb-3 overflow-y-auto text-sm text-gray-700">
            @foreach ($options as $option)
                <li class="dropdown-item" data-search="{{ strtolower($option['label']) }}">
                    <div class="flex items-center ps-2 rounded hover:bg-gray-100">
                        <input type="checkbox" name="{{ $name }}[]" value="{{ $option['value'] }}"
                            id="checkbox-{{ $name }}-{{ $option['value'] }}"
                            {{ in_array($option['value'], $selected) ? 'checked' : '' }}
                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                        <label for="checkbox-{{ $name }}-{{ $option['value'] }}"
                            class="w-full py-2 ms-2 text-sm font-medium text-gray-900">
                            {{ $option['label'] }}
                        </label>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <span id="error-{{ $name }}" class="error-text text-red-500 text-sm mt-1 block"></span>
</fieldset>

<script>
    function toggleDropdown(name) {
        const dropdown = document.getElementById('dropdown-' + name);
        dropdown.classList.toggle('hidden');

        // Close other dropdowns
        document.querySelectorAll('[id^="dropdown-"]').forEach(function(otherDropdown) {
            if (otherDropdown.id !== 'dropdown-' + name) {
                otherDropdown.classList.add('hidden');
            }
        });
    }

    function filterDropdown(name) {
        const searchInput = document.getElementById('search-' + name);
        const filter = searchInput.value.toLowerCase();
        const dropdown = document.getElementById('dropdown-' + name);
        const items = dropdown.querySelectorAll('.dropdown-item');

        items.forEach(function(item) {
            const searchText = item.getAttribute('data-search');
            if (searchText.includes(filter)) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('[id^="dropdown-"]') && !event.target.closest(
                'button[onclick*="toggleDropdown"]')) {
            document.querySelectorAll('[id^="dropdown-"]').forEach(function(dropdown) {
                dropdown.classList.add('hidden');
            });
        }
    });
</script>
