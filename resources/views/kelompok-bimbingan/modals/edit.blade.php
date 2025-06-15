<!-- Modal header -->
<div class="flex items-center justify-between px-4 py-3 border-b rounded-t-xl bg-primary border-gray-200">
    <h3 class="text-sm font-semibold text-white">
        <i class="fa-solid fa-file-circle-plus me-1"></i>
        Edit Dosen Pembimbing
    </h3>
    <button type="button" class="text-white bg-transparent text-sm text-center" data-modal-hide="modal">
        <i class="fa-solid fa-xmark"></i>
        <span class="sr-only">Close modal</span>
    </button>
</div>
<!-- Modal body -->
@include('kelompok-bimbingan.partials.form', [
    'action' =>  'http://127.0.0.1:8000/api/dosen-pembimbing-peran'.$dosenPembimbingPeran->peran_id,
    'method' => 'PUT',
    'buttonText' => 'Update',
    'buttonIcon' => 'fa-solid fa-plus',
])
