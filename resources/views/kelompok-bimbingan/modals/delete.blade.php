<!-- Modal header -->
<div class="flex items-center justify-between px-4 py-3 border-b rounded-t-xl bg-primary border-gray-200">
    <h3 class="text-sm font-semibold text-white">
        <i class="fa-solid fa-triangle-exclamation me-1"></i>
        Hapus Peran
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
            <p class="font-normal text-xs">Apakah Anda yakin ingin menghapus data peran ini?</p>
        </div>
    </div>

    <div class="grid grid-cols-2 rounded-lg">
        <div class="text-center border border-gray-200 py-2 rounded-tl-lg">
            <h6 class="text-sm text-gray-600">ID Peran</h6>
        </div>
        <div class="text-center border border-gray-200 py-2 rounded-tr-lg">
            <p class="text-sm text-gray-600">{{ $dosenPembimbingPeran->peran_id }}</p>
        </div>
    </div>
    <div class="grid grid-cols-2 rounded-lg">
        <div class="text-center border border-gray-200 py-2 rounded-bl-lg">
            <h6 class="text-sm text-gray-600">ID Kelompok</h6>
        </div>
        <div class="text-center border border-gray-200 py-2 rounded-br-lg">
            <p class="text-sm text-gray-600">{{ $dosenPembimbingPeran->kelompok_id }}</p>
        </div>
    </div>
    <div class="grid grid-cols-2 rounded-lg">
        <div class="text-center border border-gray-200 py-2 rounded-bl-lg">
            <h6 class="text-sm text-gray-600">Nama Peran</h6>
        </div>
        <div class="text-center border border-gray-200 py-2 rounded-br-lg">
            <p class="text-sm text-gray-600">{{ $dosenPembimbingPeran->peran_nama }}</p>
        </div>
    </div>

    <div class="mt-4">
        <form id="form" data-nip="{{ $dosenPembimbingPeran->peran_id }}">
            <div class="flex justify-end">
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

                const peranId = $(form).data('nip');
                const token = localStorage.getItem('api_token');

                if (!token) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Token Hilang',
                        text: 'Token tidak ditemukan di localStorage.'
                    });
                    return;
                }

                $.ajax({
                    url: `/api/dosen-pembimbing-peran/${peranId}`,
                    method: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        if (response.success || response.status) {
                            disposeModal();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            }).then(() => {
                                reloadDataTable();
                            });
                        } else {
                            disposeModal();
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message ||
                                    'Gagal menghapus data peran.'
                            });
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        disposeModal();
                        Swal.fire({
                            icon: 'error',
                            title: 'Server Error',
                            text: 'Terjadi kesalahan saat menghapus data peran.'
                        });
                    }
                });

                return false;
            }
        });
    });
</script>
