<!-- Modal header -->
<div class="flex items-center justify-between px-4 py-3 border-b rounded-t-xl bg-red-600 border-gray-200">
    <h3 class="text-sm font-semibold text-white">
        <i class="fa-solid fa-exclamation-triangle me-1"></i>
        Konfirmasi Hapus Lomba
    </h3>
    <button type="button" class="text-white bg-transparent text-sm text-center cursor-pointer" data-modal-hide="modal">
        <i class="fa-solid fa-xmark"></i>
        <span class="sr-only">Close modal</span>
    </button>
</div>

<!-- Modal body -->
<div class="p-4 md:p-5">
    <div class="flex items-center mb-4">
        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-red-100 flex items-center justify-center mr-3">
            <i class="fa-solid fa-exclamation-triangle text-red-600"></i>
        </div>
        <div>
            <h4 class="text-lg font-medium text-gray-900">Hapus Lomba</h4>
            <p class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan</p>
        </div>
    </div>

    <div class="bg-gray-50 rounded-lg p-4 mb-4">
        <div class="space-y-2">
            <div class="flex justify-between">
                <span class="text-sm font-medium text-gray-600">Nama Lomba:</span>
                <span class="text-sm text-gray-900">{{ $lomba->lomba_nama }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm font-medium text-gray-600">Penyelenggara:</span>
                <span class="text-sm text-gray-900">{{ $lomba->lomba_penyelenggara }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm font-medium text-gray-600">Kategori:</span>
                <span class="text-sm text-gray-900">{{ $lomba->lomba_kategori }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm font-medium text-gray-600">Status:</span>
                <span class="text-sm">
                    @if($lomba->lomba_status == 'menunggu_verifikasi')
                        <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Menunggu Verifikasi</span>
                    @elseif($lomba->lomba_status == 'buka')
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Buka</span>
                    @elseif($lomba->lomba_status == 'tutup')
                        <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Tutup</span>
                    @elseif($lomba->lomba_status == 'selesai')
                        <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full">Selesai</span>
                    @endif
                </span>
            </div>
        </div>
    </div>

    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fa-solid fa-exclamation text-red-400"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Perhatian!</h3>
                <div class="mt-2 text-sm text-red-700">
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Data lomba akan dihapus secara permanen</li>
                        <li>Semua kelompok yang terdaftar akan kehilangan akses</li>
                        <li>Data riwayat dan hasil lomba akan hilang</li>
                        <li>Tindakan ini tidak dapat dibatalkan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Warning for active lomba -->
    @if(in_array($lomba->lomba_status, ['buka', 'tutup']))
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fa-solid fa-exclamation-triangle text-yellow-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Lomba Masih Aktif!</h3>
                    <div class="mt-1 text-sm text-yellow-700">
                        Lomba ini masih dalam status aktif. Pastikan tidak ada peserta yang masih terdaftar atau sedang mengikuti lomba.
                    </div>
                </div>
            </div>
        </div>
    @endif

    <form id="deleteForm" method="POST" action="{{ route(auth()->user()->user_role . '.data-lomba.destroy', $lomba->lomba_id) }}">
        @csrf
        @method('DELETE')
        
        <div class="mb-4">
            <label for="confirmText" class="block text-sm font-medium text-gray-700 mb-2">
                Ketik <strong>"{{ $lomba->lomba_nama }}"</strong> untuk mengonfirmasi penghapusan:
            </label>
            <x-forms.input name="confirmText" id="confirmText" placeholder="Ketik nama lomba untuk konfirmasi" required />
        </div>

        <div class="flex justify-end space-x-3">
            <x-buttons.default type="button" title="Batal" color="secondary" data-modal-hide="modal" />
            <x-buttons.default type="submit" title="Hapus Lomba" color="danger" icon="fa-solid fa-trash" id="deleteBtn" disabled />
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
    const confirmText = $('#confirmText');
    const deleteBtn = $('#deleteBtn');
    const expectedText = '{{ $lomba->lomba_nama }}';

    // Enable/disable delete button based on confirmation text
    confirmText.on('input', function() {
        if ($(this).val().trim() === expectedText) {
            deleteBtn.prop('disabled', false).removeClass('opacity-50 cursor-not-allowed');
        } else {
            deleteBtn.prop('disabled', true).addClass('opacity-50 cursor-not-allowed');
        }
    });

    // Handle form submission
    $('#deleteForm').on('submit', function(e) {
        e.preventDefault();
        
        if (confirmText.val().trim() !== expectedText) {
            Swal.fire({
                icon: 'warning',
                title: 'Konfirmasi Tidak Sesuai',
                text: 'Ketik nama lomba dengan benar untuk melanjutkan penghapusan.'
            });
            return;
        }

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data lomba akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData(this);
                
                $.ajax({
                    url: this.action,
                    type: 'POST',
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
    });
});