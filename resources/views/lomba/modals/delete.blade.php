<!-- Modal header -->
<div class="flex items-center justify-between px-4 py-3 border-b rounded-t-xl bg-primary border-gray-200">
    <h3 class="text-sm font-semibold text-white">
        <i class="fa-solid fa-triangle-exclamation me-1"></i>
        Hapus Lomba
    </h3>
    <button type="button" class="text-white bg-transparent text-sm text-center" data-modal-hide="modal">
        <i class="fa-solid fa-xmark"></i>
        <span class="sr-only">Close modal</span>
    </button>
</div>

<!-- Modal body -->
<div class="p-4">
    <div class="flex items-center p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50" role="alert">
        <i class="fa-solid fa-triangle-exclamation text-xl me-4"></i>
        <span class="sr-only">Info</span>
        <div>
            <h6 class="font-medium text-sm">Konfirmasi Penghapusan!</h6>
            <p class="font-normal text-xs">Apakah Anda yakin ingin menghapus data lomba ini? Data yang dihapus tidak dapat dikembalikan.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-2 rounded-lg mb-4">
        <!-- Nama Lomba -->
        <div class="grid grid-cols-2">
            <div class="text-left border border-gray-200 py-2 px-3 bg-gray-50 rounded-l-lg">
                <h6 class="text-sm font-medium text-gray-700">
                    Nama Lomba
                </h6>
            </div>
            <div class="text-left border border-gray-200 py-2 px-3 rounded-r-lg">
                <p class="text-sm text-gray-600">
                    {{ $lomba->lomba_nama }}
                </p>
            </div>
        </div>

        <!-- Kategori -->
        <div class="grid grid-cols-2">
            <div class="text-left border border-gray-200 py-2 px-3 bg-gray-50 rounded-l-lg">
                <h6 class="text-sm font-medium text-gray-700">
                    Kategori
                </h6>
            </div>
            <div class="text-left border border-gray-200 py-2 px-3 rounded-r-lg">
                <p class="text-sm text-gray-600">
                    {{ $lomba->lomba_kategori }}
                </p>
            </div>
        </div>

        <!-- Penyelenggara -->
        <div class="grid grid-cols-2">
            <div class="text-left border border-gray-200 py-2 px-3 bg-gray-50 rounded-l-lg">
                <h6 class="text-sm font-medium text-gray-700">
                    Penyelenggara
                </h6>
            </div>
            <div class="text-left border border-gray-200 py-2 px-3 rounded-r-lg">
                <p class="text-sm text-gray-600">
                    {{ $lomba->lomba_penyelenggara }}
                </p>
            </div>
        </div>

        <!-- Tingkat -->
        <div class="grid grid-cols-2">
            <div class="text-left border border-gray-200 py-2 px-3 bg-gray-50 rounded-l-lg">
                <h6 class="text-sm font-medium text-gray-700">
                    Tingkat
                </h6>
            </div>
            <div class="text-left border border-gray-200 py-2 px-3 rounded-r-lg">
                <span class="px-2 py-1 text-xs rounded-full 
                    @if($lomba->lomba_tingkat == 'Internasional') bg-red-100 text-red-800
                    @elseif($lomba->lomba_tingkat == 'Nasional') bg-blue-100 text-blue-800
                    @else bg-green-100 text-green-800 @endif">
                    {{ $lomba->lomba_tingkat }}
                </span>
            </div>
        </div>

        <!-- Status -->
        <div class="grid grid-cols-2">
            <div class="text-left border border-gray-200 py-2 px-3 bg-gray-50 rounded-l-lg">
                <h6 class="text-sm font-medium text-gray-700">
                    Status
                </h6>
            </div>
            <div class="text-left border border-gray-200 py-2 px-3 rounded-r-lg">
                <span class="px-2 py-1 text-xs rounded-full 
                    @if($lomba->lomba_status == 'buka') bg-green-100 text-green-800
                    @elseif($lomba->lomba_status == 'tutup') bg-gray-100 text-gray-800
                    @else bg-red-100 text-red-800 @endif">
                    {{ ucfirst($lomba->lomba_status) }}
                </span>
            </div>
        </div>

        <!-- Poster Preview (if exists) - PERBAIKAN: Menggunakan lomba_poster_url -->
        @if($lomba->lomba_poster_url)
        <div class="grid grid-cols-2">
            <div class="text-left border border-gray-200 py-2 px-3 bg-gray-50 rounded-l-lg">
                <h6 class="text-sm font-medium text-gray-700">
                    Poster
                </h6>
            </div>
            <div class="text-left border border-gray-200 py-2 px-3 rounded-r-lg">
                <img src="{{ asset('storage/' . $lomba->lomba_poster_url) }}" alt="Poster" class="w-16 h-16 object-cover rounded border">
            </div>
        </div>
        @endif
    </div>

    <div class="mt-4">
        <form id="form" action="{{ route('admin.manajemen.lomba.destroy', $lomba->lomba_id) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end gap-2">
                <button type="button" class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200" data-modal-hide="modal">
                    <i class="fa-solid fa-times me-1"></i>
                    Batal
                </button>
                <x-buttons.default type="submit" title="Hapus" color="primary" icon="fa-solid fa-trash-can" />
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#form").validate({
            submitHandler: function(form, event) {
                event.preventDefault();
                
                // Show confirmation before delete
                Swal.fire({
                    title: 'Konfirmasi Penghapusan',
                    text: 'Data lomba akan dihapus permanen. Apakah Anda yakin?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var formData = new FormData(form);
                        $.ajax({
                            url: form.action,
                            type: form.method,
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                if (response.status) {
                                    disposeModal();
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.message
                                    }).then(() => {
                                        disposeModal();
                                        reloadDataTable();
                                    });
                                } else {
                                    disposeModal();
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal',
                                        text: response.message
                                    }).then(() => {
                                        disposeModal();
                                        reloadDataTable();
                                    });
                                }
                            },
                            error: function(xhr) {
                                console.log(xhr);
                                disposeModal();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Internal Server Error',
                                    text: 'Terjadi kesalahan saat menghapus data. Silakan coba lagi.'
                                });
                            }
                        });
                    }
                });
                
                return false;
            },
        });
    });
</script>