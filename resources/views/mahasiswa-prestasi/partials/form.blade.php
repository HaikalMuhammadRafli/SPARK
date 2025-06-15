{{-- resources/views/mahasiswa-prestasi/partials/form/form.blade.php --}}
<form id="prestasiForm" enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="prestasi_id" name="prestasi_id">
    <input type="hidden" id="form_method" name="_method" value="">
    
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="kelompok_id" class="form-label">Kelompok <span class="text-danger">*</span></label>
            <select class="form-select" id="kelompok_id" name="kelompok_id" required>
                <option value="">Pilih Kelompok</option>
            </select>
            <div class="invalid-feedback" id="kelompok_id_error"></div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="prestasi_juara" class="form-label">Prestasi/Juara <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="prestasi_juara" name="prestasi_juara" 
                   placeholder="Contoh: Juara 1 Lomba Web Design Nasional" required>
            <div class="invalid-feedback" id="prestasi_juara_error"></div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="prestasi_surat_tugas_url" class="form-label">URL Surat Tugas <span class="text-danger">*</span></label>
            <input type="url" class="form-control" id="prestasi_surat_tugas_url" name="prestasi_surat_tugas_url" 
                   placeholder="https://example.com/surat-tugas.pdf" required>
            <div class="invalid-feedback" id="prestasi_surat_tugas_url_error"></div>
            <small class="form-text text-muted">Upload file ke cloud storage dan masukkan URL-nya</small>
        </div>
        
        <div class="col-md-6 mb-3">
            <label for="prestasi_poster_url" class="form-label">URL Poster <span class="text-danger">*</span></label>
            <input type="url" class="form-control" id="prestasi_poster_url" name="prestasi_poster_url" 
                   placeholder="https://example.com/poster.jpg" required>
            <div class="invalid-feedback" id="prestasi_poster_url_error"></div>
            <small class="form-text text-muted">Upload poster lomba dan masukkan URL-nya</small>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="prestasi_foto_juara_url" class="form-label">URL Foto Juara <span class="text-danger">*</span></label>
            <input type="url" class="form-control" id="prestasi_foto_juara_url" name="prestasi_foto_juara_url" 
                   placeholder="https://example.com/foto-juara.jpg" required>
            <div class="invalid-feedback" id="prestasi_foto_juara_url_error"></div>
            <small class="form-text text-muted">Upload foto dokumentasi saat menerima penghargaan</small>
        </div>
        
        <div class="col-md-6 mb-3">
            <label for="prestasi_proposal_url" class="form-label">URL Proposal <span class="text-danger">*</span></label>
            <input type="url" class="form-control" id="prestasi_proposal_url" name="prestasi_proposal_url" 
                   placeholder="https://example.com/proposal.pdf" required>
            <div class="invalid-feedback" id="prestasi_proposal_url_error"></div>
            <small class="form-text text-muted">Upload proposal lomba yang digunakan</small>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="prestasi_sertifikat_url" class="form-label">URL Sertifikat <span class="text-danger">*</span></label>
            <input type="url" class="form-control" id="prestasi_sertifikat_url" name="prestasi_sertifikat_url" 
                   placeholder="https://example.com/sertifikat.pdf" required>
            <div class="invalid-feedback" id="prestasi_sertifikat_url_error"></div>
            <small class="form-text text-muted">Upload sertifikat penghargaan yang diterima</small>
        </div>
    </div>
    
    <!-- Status dan Catatan hanya untuk tampilan, tidak bisa diedit mahasiswa -->
    <div id="status_section" class="row" style="display: none;">
        <div class="col-md-6 mb-3">
            <label for="prestasi_status" class="form-label">Status</label>
            <select class="form-select" id="prestasi_status" name="prestasi_status" disabled>
                <option value="Pending">Pending</option>
                <option value="Disetujui">Disetujui</option>
                <option value="Ditolak">Ditolak</option>
            </select>
        </div>
        
        <div class="col-md-6 mb-3">
            <label for="prestasi_catatan" class="form-label">Catatan</label>
            <textarea class="form-control" id="prestasi_catatan" name="prestasi_catatan" rows="3" 
                      placeholder="Catatan dari admin..." disabled></textarea>
        </div>
    </div>
    
    <div class="d-flex justify-content-between">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            <i class="fas fa-times me-1"></i> Batal
        </button>
        <button type="submit" class="btn btn-primary" id="submitBtn">
            <i class="fas fa-save me-1"></i> Simpan
        </button>
    </div>
</form>

<script>
// Form validation and submission logic
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('prestasiForm');
    const submitBtn = document.getElementById('submitBtn');
    
    // Load kelompok options
    loadKelompokOptions();
    
    // Form submission handler
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        handleFormSubmit();
    });
    
    function loadKelompokOptions() {
        fetch('/api/prestasi/mahasiswa/kelompok', {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            const kelompokSelect = document.getElementById('kelompok_id');
            kelompokSelect.innerHTML = '<option value="">Pilih Kelompok</option>';
            
            if (data.status === 'success' && data.data) {
                data.data.forEach(kelompok => {
                    const option = document.createElement('option');
                    option.value = kelompok.kelompok_id;
                    option.textContent = kelompok.kelompok_nama || `Kelompok ${kelompok.kelompok_id}`;
                    kelompokSelect.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error loading kelompok:', error);
            showAlert('Gagal memuat data kelompok', 'error');
        });
    }
    
    function handleFormSubmit() {
        clearValidationErrors();
        setLoading(true);
        
        const formData = new FormData(form);
        const prestasiId = document.getElementById('prestasi_id').value;
        const method = prestasiId ? 'PUT' : 'POST';
        const url = prestasiId 
            ? `/api/prestasi/mahasiswa/${prestasiId}` 
            : '/api/prestasi/mahasiswa';
        
        // Convert FormData to JSON for API
        const data = {};
        for (let [key, value] of formData.entries()) {
            if (key !== '_token' && key !== '_method' && key !== 'prestasi_id') {
                data[key] = value;
            }
        }
        
        fetch(url, {
            method: method,
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showAlert(data.message, 'success');
                
                // Close modal and refresh table
                const modal = bootstrap.Modal.getInstance(document.getElementById('prestasiModal'));
                if (modal) modal.hide();
                
                // Refresh the prestasi table
                if (typeof refreshPrestasiTable === 'function') {
                    refreshPrestasiTable();
                }
                
                // Reset form
                form.reset();
                document.getElementById('prestasi_id').value = '';
                document.getElementById('status_section').style.display = 'none';
            } else {
                if (data.errors) {
                    showValidationErrors(data.errors);
                } else {
                    showAlert(data.message || 'Terjadi kesalahan', 'error');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('Terjadi kesalahan saat menyimpan data', 'error');
        })
        .finally(() => {
            setLoading(false);
        });
    }
    
    function clearValidationErrors() {
        const errorElements = document.querySelectorAll('.invalid-feedback');
        errorElements.forEach(element => {
            element.textContent = '';
        });
        
        const inputElements = document.querySelectorAll('.form-control, .form-select');
        inputElements.forEach(element => {
            element.classList.remove('is-invalid');
        });
    }
    
    function showValidationErrors(errors) {
        Object.keys(errors).forEach(field => {
            const errorElement = document.getElementById(`${field}_error`);
            const inputElement = document.getElementById(field);
            
            if (errorElement && inputElement) {
                errorElement.textContent = errors[field][0];
                inputElement.classList.add('is-invalid');
            }
        });
    }
    
    function setLoading(loading) {
        submitBtn.disabled = loading;
        if (loading) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Menyimpan...';
        } else {
            submitBtn.innerHTML = '<i class="fas fa-save me-1"></i> Simpan';
        }
    }
});

// Function to populate form for editing
function populateForm(prestasi) {
    document.getElementById('prestasi_id').value = prestasi.prestasi_id;
    document.getElementById('kelompok_id').value = prestasi.kelompok_id;
    document.getElementById('prestasi_juara').value = prestasi.prestasi_juara;
    document.getElementById('prestasi_surat_tugas_url').value = prestasi.prestasi_surat_tugas_url;
    document.getElementById('prestasi_poster_url').value = prestasi.prestasi_poster_url;
    document.getElementById('prestasi_foto_juara_url').value = prestasi.prestasi_foto_juara_url;
    document.getElementById('prestasi_proposal_url').value = prestasi.prestasi_proposal_url;
    document.getElementById('prestasi_sertifikat_url').value = prestasi.prestasi_sertifikat_url;
    
    // Show status section for existing prestasi
    if (prestasi.prestasi_id) {
        document.getElementById('status_section').style.display = 'block';
        document.getElementById('prestasi_status').value = prestasi.prestasi_status;
        document.getElementById('prestasi_catatan').value = prestasi.prestasi_catatan || '';
    }
}

// Function to reset form
function resetForm() {
    document.getElementById('prestasiForm').reset();
    document.getElementById('prestasi_id').value = '';
    document.getElementById('status_section').style.display = 'none';
    clearValidationErrors();
}