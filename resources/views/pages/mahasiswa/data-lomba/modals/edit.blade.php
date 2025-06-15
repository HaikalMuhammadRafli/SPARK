<!-- Modal header -->
<div class="flex items-center justify-between px-4 py-3 border-b rounded-t-xl bg-primary border-gray-200">
    <h3 class="text-sm font-semibold text-white">
        <i class="fa-solid fa-edit me-1"></i>
        Edit Lomba
    </h3>
    <button type="button" class="text-white bg-transparent text-sm text-center cursor-pointer" data-modal-hide="modal">
        <i class="fa-solid fa-xmark"></i>
        <span class="sr-only">Close modal</span>
    </button>
</div>

<!-- Modal body -->
@include('pages.mahasiswa.data-lomba.partials.form', [
    'action' => route(auth()->user()->user_role . '.data-lomba.update', $lomba->lomba_id),
    'method' => 'PUT',
    'buttonText' => 'Update Lomba',
    'buttonIcon' => 'fa-solid fa-save',
])