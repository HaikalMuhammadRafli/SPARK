@if($lombas->count() > 0)
    <x-data-table :headers="[
        ['title' => 'No', 'key' => 'no', 'sortable' => true],
        ['title' => 'Nama Lomba', 'key' => 'nama', 'sortable' => true],
        ['title' => 'Kategori', 'key' => 'kategori', 'sortable' => true],
        ['title' => 'Penyelenggara', 'key' => 'penyelenggara', 'sortable' => true],
        ['title' => 'Tingkat', 'key' => 'tingkat', 'sortable' => true],
        ['title' => 'Status', 'key' => 'status', 'sortable' => true],
        ['title' => 'Aksi', 'key' => 'actions', 'sortable' => false],
    ]">
        <tbody>
            @foreach($lombas as $lomba)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-1 whitespace-nowrap">{{ $loop->iteration }}</td>
                    <td class="px-4 py-1">
                        <div>
                            <div class="font-medium text-gray-900">{{ $lomba->lomba_nama }}</div>
                            <div class="text-sm text-gray-500">{{ $lomba->periode->periode_nama ?? '-' }}</div>
                        </div>
                    </td>
                    <td class="px-4 py-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $lomba->lomba_kategori }}
                        </span>
                    </td>
                    <td class="px-4 py-1">
                        {{ $lomba->lomba_penyelenggara }}
                    </td>
                    <td class="px-4 py-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            @if($lomba->lomba_tingkat == 'Internasional') bg-purple-100 text-purple-800
                            @elseif($lomba->lomba_tingkat == 'Nasional') bg-green-100 text-green-800
                            @elseif($lomba->lomba_tingkat == 'Provinsi') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ $lomba->lomba_tingkat }}
                        </span>
                    </td>
                    <td class="px-4 py-1">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            @if($lomba->lomba_status == 'Sedang berlangsung') bg-green-100 text-green-800
                            @elseif($lomba->lomba_status == 'Akan datang') bg-blue-100 text-blue-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ $lomba->lomba_status }}
                        </span>
                    </td>
                    <td class="px-4 py-1 text-right">
                        <x-buttons.action route_prefix="admin.manajemen.lomba" id="{{ $lomba->lomba_id }}" />
                    </td>
                </tr>
            @endforeach
        </tbody>
    </x-data-table>
@else
    <div class="text-center py-8">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data lomba</h3>
        <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan lomba baru atau ubah filter pencarian.</p>
        <div class="mt-6">
            <button type="button" 
                    onclick="modalAction('{{ route('admin.manajemen.lomba.create') }}')"
                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Lomba
            </button>
        </div>
    </div>
@endif