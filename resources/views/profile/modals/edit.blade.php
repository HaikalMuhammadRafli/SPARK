<!-- Modal header -->
<div class="flex items-center justify-between px-4 py-3 border-b rounded-t-xl bg-primary border-gray-200">
    <h3 class="text-sm font-semibold text-white">
        <i class="fa-solid fa-file-circle-plus me-1"></i>
        Edit Profil
    </h3>
    <button type="button" class="text-white bg-transparent text-sm text-center cursor-pointer"
        data-modal-hide="edit_modal">
        <i class="fa-solid fa-xmark"></i>
        <span class="sr-only">Close modal</span>
    </button>
</div>

<!-- Modal body -->
@if (auth()->user()->role == 'mahasiswa')
    @include('profile.partials.edit-form-mahasiswa', [
        'action' => route('profile.update.mahasiswa', auth()->user()->user_id),
        'method' => 'PUT',
        'buttonText' => 'Update',
        'buttonIcon' => 'fa-solid fa-edit',
    ])
@else
    @include('profile.partials.edit-form-staff', [
        'action' => route('profile.update.staff', auth()->user()->user_id),
        'method' => 'PUT',
        'buttonText' => 'Update',
        'buttonIcon' => 'fa-solid fa-edit',
    ])
@endif
