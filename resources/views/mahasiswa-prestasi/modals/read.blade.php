{{-- resources/views/mahasiswa-prestasi/modal/read.blade.php --}}
<div class="modal fade" id="readPrestasiModal" tabindex="-1" aria-labelledby="readPrestasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="readPrestasiModalLabel">
                    <i class="fas fa-eye me-2"></i>Detail Prestasi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-trophy me-2"></i>Informasi Prestasi
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Kelompok:</label>
                                        <p id="detail_kelompok" class="form-control-plaintext">-</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Status:</label>
                                        <p id="detail_status" class="form-control-plaintext">
                                            <span class="badge" id="status_badge">-</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold">Prestasi/Juara:</label>
                                        <p id="detail_juara" class="form-control-plaintext">-</p>
                                    </div>
                                </div>
                                <div class="row" id="catatan_section" style="display: none;">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold">Catatan:</label>
                                        <div class="alert alert-warning" id="detail_catatan">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-file-alt me-2"></i>Dokumen Pendukung
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Surat Tugas:</label>
                                        <div>
                                            <a href="#" id="link_surat_tugas" class="btn btn-outline-primary btn-sm" target="_blank">
                                                <i class="fas fa-external-link-alt me-1"></i>Lihat Dokumen
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Poster:</label>
                                        <div>
                                            <a href="#" id="link_poster" class="btn btn-outline-primary btn-sm" target="_blank">
                                                <i class="fas fa-external-link-alt me-1"></i>Lihat Poster
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Foto Juara:</label>
                                        <div>
                                            <a href="#" id="link_foto_juara" class="btn btn-outline-primary btn-sm" target="_blank">
                                                <i class="fas fa-external-link-alt me-1"></i>Lihat Foto
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Proposal:</label>
                                        <div>
                                            <a href="#" id="link_proposal" class="btn btn-outline-primary btn-sm" target="_blank">
                                                <i class="fas fa-external-link-alt me-1"></i>Lihat Proposal
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label fw-bold">Sertifikat:</label>
                                        <div>
                                            <a href="#" id="link_sertifikat" class="btn btn-outline-primary btn-sm" target="_blank">
                                                <i class="fas fa-external-link-alt me-1"></i>Lihat Sertifikat
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Informasi Tambahan
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">Dibuat pada:</small>
                                        <p id="detail_created_at" class="mb-0">-</p>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <small class="text-muted">Diperbarui pada:</small>
                                        <p id="detail_updated_at" class="mb-0">-</p>
                                    </div>
                                </div>
                                <div class="row" id="validated_section" style="display: none;">
                                    <div class="col-md-12 mb-2">
                                        <small class="text-muted">Divalidasi pada:</small>
                                        <p id="detail_validated_at" class="mb-0">-</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Function to open read modal and populate data
function openReadModal(prestasiId) {
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
            populateReadModal(data.data);
            const modal = new bootstrap.Modal(document.getElementById('readPrestasiModal'));
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

function populateReadModal(prestasi) {
    // Basic information
    document.getElementById('detail_kelompok').textContent = prestasi.kelompok ? 
        (prestasi.kelompok.kelompok_nama || `Kelompok ${prestasi.kelompok.kelompok_id}`) : '-';
    document.getElementById('detail_juara').textContent = prestasi.prestasi_juara || '-';
    
    // Status with badge styling
    const statusBadge = document.getElementById('status_badge');
    statusBadge.textContent = prestasi.prestasi_status || 'Pending';
    statusBadge.className = 'badge ';
    
    switch(prestasi.prestasi_status) {
        case 'Disetujui':
            statusBadge.className += 'bg-success';
            break;
        case 'Ditolak':
            statusBadge.className += 'bg-danger';
            break;
        case 'Pending':
        default:
            statusBadge.className += 'bg-warning text-dark';
            break;
    }
    
    // Show/hide catatan section
    const catatanSection = document.getElementById('catatan_section');
    if (prestasi.prestasi_catatan && prestasi.prestasi_catatan.trim() !== '') {
        document.getElementById('detail_catatan').textContent = prestasi.prestasi_catatan;
        catatanSection.style.display = 'block';
    } else {
        catatanSection.style.display = 'none';
    }
    
    // Document links
    document.getElementById('link_surat_tugas').href = prestasi.prestasi_surat_tugas_url || '#';
    document.getElementById('link_poster').href = prestasi.prestasi_poster_url || '#';
    document.getElementById('link_foto_juara').href = prestasi.prestasi_foto_juara_url || '#';
    document.getElementById('link_proposal').href = prestasi.prestasi_proposal_url || '#';
    document.getElementById('link_sertifikat').href = prestasi.prestasi_sertifikat_url || '#';
    
    // Timestamps
    document.getElementById('detail_created_at').textContent = formatDateTime(prestasi.created_at);
    document.getElementById('detail_updated_at').textContent = formatDateTime(prestasi.updated_at);
    
    // Validated timestamp
    const validatedSection = document.getElementById('validated_section');
    if (prestasi.validated_at) {
        document.getElementById('detail_validated_at').textContent = formatDateTime(prestasi.validated_at);
        validatedSection.style.display = 'block';
    } else {
        validatedSection.style.display = 'none';
    }
}

function formatDateTime(dateTimeString) {
    if (!dateTimeString) return '-';
    
    const date = new Date(dateTimeString);
    const options = {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        timeZone: 'Asia/Jakarta'
    };
    
    return date.toLocaleDateString('id-ID', options);
}
</script>