<!-- Modal header -->
<div class="flex items-center justify-between px-4 py-3 border-b rounded-t-xl bg-primary border-gray-200">
    <h3 class="text-sm font-semibold text-white">
        <i class="fa-solid fa-file-circle-plus me-1"></i>
        Tambahkan Bidang Keahlian ke Profil
    </h3>
    <button type="button" class="text-white bg-transparent text-sm text-center cursor-pointer"
        data-modal-hide="criteria_modal">
        <i class="fa-solid fa-xmark"></i>
        <span class="sr-only">Close modal</span>
    </button>
</div>
<!-- Modal body -->
@include('profile.partials.criteria-form', [
    'action' => route('profile.add.bidang-keahlian'),
    'method' => 'POST',
    'title' => 'Pilih Bidang Keahlian',
    'nama' => 'bidang_keahlian',
    'datas' => $bidang_keahlians ?? collect(),
    'buttonText' => 'Tambah',
    'buttonIcon' => 'fa-solid fa-plus',
])
