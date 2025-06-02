
<div id="modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div id="modal-content" class="relative bg-white rounded-xl shadow-sm">
            {{-- Loaded content here --}}
        </div>
    </div>
</div>

@push('css')
    <style>
        #modal.show {
            display: flex !important;
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            const modal = document.getElementById('modal');
            let modalInstance = null;

            window.modalAction = function(url) {
                if (modalInstance) {
                    disposeModal();
                }

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        modalInstance = new Modal(modal);
                        $('#modal-content').html(response);
                        modalInstance.show();
                    },
                    error: function(xhr) {
                        console.error('Error loading modal content:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal memuat form. Silakan coba lagi.'
                        });
                    }
                });
            };

            $(document).off('click', '[data-modal-hide="modal"]').on('click', '[data-modal-hide="modal"]',
                function() {
                    disposeModal();
                });

            window.disposeModal = function() {
                if (modalInstance) {
                    if (typeof modalInstance.hide === 'function') {
                        modalInstance.hide();
                    }
                    if (typeof modalInstance.dispose === 'function') {
                        modalInstance.dispose();
                    }
                    $('#modal-content').empty();
                    modalInstance = null;
                }
            }
        });
    </script>
@endpush
