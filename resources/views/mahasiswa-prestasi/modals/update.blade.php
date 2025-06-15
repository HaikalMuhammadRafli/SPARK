{{-- resources/views/mahasiswa-prestasi/modal/update.blade.php --}}
<div class="modal fade" id="updatePrestasiModal" tabindex="-1" aria-labelledby="updatePrestasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="updatePrestasiModalLabel">
                    <i class="fas fa-edit me-2"></i>Edit Prestasi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Catatan:</strong> Anda hanya dapat mengedit prestasi yang masih berstatus <span class="badge bg-warning text-dark">Pending</span>. 
                    Prestasi yang sudah disetujui atau ditolak tidak dapat diubah.
                </div>
                
                @include('mahasiswa-prestasi.partials.form.form')
            </div>
        </div>
    </div>
</div>

<script>
// Function to open update modal and populate data
function openUpdateModal(prestasiId) {
    fetch(`/api/prestasi/mahasiswa/${prestasiId}`, {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`,
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            const prestasi = data.data;
            
            // Check if prestasi can be edited
            if (prestasi.prestasi_status !== 'Pending') {
                showAlert('Prestasi yang sudah disetujui atau ditolak tidak dapat diubah', 'warning');
                return;
            }
            
            // Populate form with prestasi data
            populateUpdateForm(prestasi);
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('updatePrestasiModal'));
            modal.show();
        } else {
            showAlert(data.message || 'Gagal mengambil data prestasi', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('Terjadi kesalahan saat mengambil data', 'error');
    });
}

function populateUpdateForm(prestasi) {
    // Use the same form as create, but populate with existing data
    resetForm(); // Clear any previous data
    
    // Set form data
    document.getElementById('prestasi_id').value = prestasi.prestasi_id;
    document.getElementById('kelompok_id').value = prestasi.kelompok_id;
    document.getElementById('prestasi_juara').value = prestasi.prestasi_juara;
    document.getElementById('prestasi_surat_tugas_url').value = prestasi.prestasi_surat_tugas_url;
    document.getElementById('prestasi_poster_url').value = prestasi.prestasi_poster_url;
    document.getElementById('prestasi_foto_juara_url').value = prestasi.prestasi_foto_juara_url;
    document.getElementById('prestasi_proposal_url').value = prestasi.prestasi_proposal_url;
    document.getElementById('prestasi_sertifikat_url').value = prestasi.prestasi_sertifikat_url;
    
    // Show status section
    document.getElementById('status_section').style.display = 'block';
    document.getElementById('prestasi_status').value = prestasi.prestasi_status;
    document.getElementById('prestasi_catatan').value = prestasi.prestasi_catatan || '';
    
    // Update submit button text
    document.getElementById('submitBtn').innerHTML = '<i class="fas fa-save me-1"></i> Perbarui';
}

document.addEventListener('DOMContentLoaded', function() {
    const updateModal = document.getElementById('updatePrestasiModal');
    
    // Reset form when modal is closed
    updateModal.addEventListener('hidden.bs.modal', function() {
        resetForm();
    });
    
    // Set up form submission for update
    updateModal.addEventListener('show.bs.modal', function() {
        // Form submission is already handled in the form component
        // Just make sure the submit button shows correct text
        document.getElementById('submitBtn').innerHTML = '<i class="fas fa-save me-1"></i> Perbarui';
    });
});
</script>