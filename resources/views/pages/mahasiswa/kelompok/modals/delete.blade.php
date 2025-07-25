<!-- Modal header -->
<div class="flex items-center justify-between px-4 py-3 border-b rounded-t-xl bg-primary border-gray-200">
    <h3 class="text-sm font-semibold text-white">
        <i class="fa-solid fa-triangle-exclamation me-1"></i>
        Hapus Kelompok
    </h3>
    <button type="button" class="text-white bg-transparent text-sm text-center cursor-pointer"
        data-modal-hide="small-modal">
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
            <p class="font-normal text-xs">Apakah Anda yakin ingin menghapus kelompok ini?</p>
        </div>
    </div>

    <div class="grid grid-cols-2 rounded-lg">
        <div class="text-center border border-gray-200 py-2 rounded-l-lg">
            <h6 class="text-sm text-gray-600">
                Nama Kelompok
            </h6>
        </div>
        <div class="text-center border border-gray-200 py-2 rounded-r-lg">
            <p class="text-sm text-gray-600">
                {{ $kelompok->kelompok_nama }}
            </p>
        </div>
        <div class="text-center border border-gray-200 py-2 rounded-l-lg">
            <h6 class="text-sm text-gray-600">
                Nama Lomba
            </h6>
        </div>
        <div class="text-center border border-gray-200 py-2 rounded-r-lg">
            <p class="text-sm text-gray-600">
                {{ $kelompok->lomba->lomba_nama }}
            </p>
        </div>
    </div>
    <div class="mt-4">
        <form id="form" action="{{ route('mahasiswa.kelompok.destroy', $kelompok->kelompok_id) }}" method="POST">
            @csrf
            @method('DELETE')
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
                var formData = new FormData(form);
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status) {
                            disposeModal('small-modal');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            }).then(() => {
                                disposeModal('small-modal');
                                window.location.reload();
                            });
                        } else {
                            disposeModal();
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            }).then(() => {
                                disposeModal();
                                window.location.reload();
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
                return false;
            },
        });
    });
</script>
