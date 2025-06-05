@props([
    'headers' => [],
    'searchPlaceholder' => 'Search...',
    'dataRoute' => '',
])

<table id="table" class="table-auto w-full text-left border-collapse border border-gray-200">
    <thead class="bg-gray-100 text-gray-700 uppercase text-sm font-medium">
        <tr>
            @foreach ($headers as $header)
                <th class="px-4 py-3">
                    @if ($header['sortable'] ?? true)
                        <span class="flex items-center gap-1">
                            {{ $header['title'] }}
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4" />
                            </svg>
                        </span>
                    @else
                        {{ $header['title'] }}
                    @endif
                </th>
            @endforeach
        </tr>
    </thead>
    <tbody class="text-gray-800">
        {{ $slot }}
    </tbody>
</table>


@push('js')
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                initializeDataTable();
            }, 100);

            function initializeDataTable() {
                console.log("Checking for table and DataTable...");

                const tableElement = document.getElementById("table");

                if (!tableElement) {
                    console.error("Table element not found!");
                    return;
                }

                if (typeof simpleDatatables === 'undefined' || typeof simpleDatatables.DataTable === 'undefined') {
                    console.error("Simple-DataTables library not loaded!");
                    return;
                }

                // Destroy existing instance if it exists
                if (window.dataTable) {
                    try {
                        window.dataTable.destroy();
                    } catch (e) {
                        console.log("No existing DataTable to destroy");
                    }
                }

                console.log("Initializing DataTable...");

                try {
                    // Check if table has rows
                    const rows = tableElement.querySelectorAll('tbody tr');
                    if (rows.length === 0) {
                        console.warn("Table has no data rows");
                    }

                    window.dataTable = new simpleDatatables.DataTable("#table", {
                        searchable: false,
                        perPage: 10,
                        perPageSelect: false,
                        nextPrev: true,
                        sortable: true,
                        columns: [
                            @foreach ($headers as $index => $header)
                                {
                                    select: {{ $index }},
                                    sortable: {{ $header['sortable'] ?? true ? 'true' : 'false' }}
                                }
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        ],
                        labels: {
                            placeholder: "Cari...",
                            perPage: "entri per halaman",
                            noRows: "Tidak ada entri ditemukan",
                            info: "Menampilkan {start} sampai {end} dari {rows} entri",
                            noResults: "Tidak ada hasil yang cocok dengan pencarian Anda"
                        }
                    });

                    console.log("DataTable initialized successfully");

                    // Setup search functionality
                    $('#datatable-search').off('input').on('input', function() {
                        if (window.dataTable && typeof window.dataTable.search === 'function') {
                            window.dataTable.search($(this).val());
                        }
                    });

                } catch (error) {
                    console.error("DataTable initialization failed:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Gagal menginisialisasi tabel. Silakan coba lagi.'
                    });
                }
            }

            // Define reloadDataTable function
            window.reloadDataTable = function() {
                console.log("Reloading DataTable...");

                @if ($dataRoute)
                    const url = '{{ $dataRoute }}';

                    const isApi = url.includes('/api');
                    const ajaxOptions = {
                        url: url,
                        type: 'GET',
                        headers: {
                            'Accept': 'application/json'
                        },
                        success: function(response) {
                            console.log("AJAX Response:", response);

                            if (response.status && response.data) {
                                location.reload(); // or custom row update logic
                            }
                        },
                        error: function(xhr) {
                            console.error('Error refreshing table:', xhr);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Gagal memuat ulang data tabel.'
                            });
                        }
                    };

                    if (isApi) {
                        const token = localStorage.getItem('api_token');
                        if (token) {
                            ajaxOptions.headers['Authorization'] = 'Bearer ' + token;
                        } else {
                            console.warn('API token not found in localStorage.');
                        }
                    }

                    $.ajax(ajaxOptions);
                @else
                    location.reload();
                @endif
            };

        });
    </script>
@endpush
