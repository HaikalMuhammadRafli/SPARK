{{-- resources/views/mahasiswa-prestasi/modal/create.blade.php --}}
<div class="modal fade" id="createPrestasiModal" tabindex="-1" aria-labelledby="createPrestasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createPrestasiModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Prestasi Baru
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Petunjuk:</strong> Silakan upload semua dokumen pendukung ke cloud storage (Google Drive, Dropbox, dll) 
                    dan masukkan URL publiknya di form ini. Pastikan file dapat diakses publik.
                </div>
                
                @include('mahasiswa-prestasi.partials.form.form')
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const createModal = document.getElementById('createPrestasiModal');
    
    // Reset form when modal is opened
    createModal.addEventListener('show.bs.modal', function() {
        resetForm();
        document.getElementById('submitBtn').innerHTML = '<i class="fas fa-save me-1"></i> Simpan';
    });
    
    // Clear form when modal is closed
    createModal.addEventListener('hidden.bs.modal', function() {
        resetForm();
    });
});

// Function to open create modal
function openCreateModal() {
    const modal = new bootstrap.Modal(document.getElementById('createPrestasiModal'));
    modal.show();
}
</script>