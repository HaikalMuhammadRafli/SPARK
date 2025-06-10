<!-- Modal header -->
<div class="flex items-center justify-between px-4 py-3 border-b rounded-t-xl bg-primary border-gray-200">
    <h3 class="text-sm font-semibold text-white">
        <i class="fa-solid fa-plus me-1"></i>
        Tambah Lomba
    </h3>
    <button type="button" class="text-white bg-transparent text-sm text-center" data-modal-hide="modal">
        <i class="fa-solid fa-xmark"></i>
        <span class="sr-only">Close modal</span>
    </button>
</div>

<!-- Modal body -->
@include('lomba.partials.form', [
    'action' => route('admin.manajemen.lomba.store'),
    'method' => 'POST',
    'buttonText' => 'Simpan',
    'buttonIcon' => 'fa-solid fa-save',
])