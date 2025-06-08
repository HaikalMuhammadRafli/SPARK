@props([
    'id' => 'modal',
    'size' => 'md',
])

@php
    $sizeClasses = [
        'xs' => 'max-w-xs',
        'sm' => 'max-w-sm',
        'md' => 'max-w-md',
        'lg' => 'max-w-lg',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        '3xl' => 'max-w-3xl',
        '4xl' => 'max-w-4xl',
        '5xl' => 'max-w-5xl',
        'full' => 'max-w-full',
    ];
@endphp

<div id="{{ $id }}" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full {{ $sizeClasses[$size] ?? 'max-w-md' }} max-h-full">
        <div id="{{ $id }}-content" class="relative bg-white rounded-xl shadow-sm">
            {{-- Loaded content here --}}
        </div>
    </div>
</div>

@once
    @push('css')
        <style>
            .modal.show {
                display: flex !important;
            }
        </style>
    @endpush

    @push('js')
        <script>
            $(document).ready(function() {
                // Store modal instances globally
                if (!window.modalInstances) {
                    window.modalInstances = {};
                }

                // Initialize modal action function
                window.modalAction = function(url, modalId = 'modal') {
                    const modal = document.getElementById(modalId);
                    if (!modal) {
                        console.error('Modal with ID "' + modalId + '" not found');
                        return;
                    }

                    // Dispose existing modal instance if exists
                    if (window.modalInstances[modalId]) {
                        disposeModal(modalId);
                    }

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(response) {
                            try {
                                // Create new modal instance
                                window.modalInstances[modalId] = new Modal(modal);

                                // Load content
                                $('#' + modalId + '-content').html(response);

                                // Show modal
                                modal.classList.add('show');
                                window.modalInstances[modalId].show();
                            } catch (error) {
                                console.error('Error creating modal instance:', error);
                                // Fallback: show modal without Modal class
                                $('#' + modalId + '-content').html(response);
                                modal.classList.add('show');
                            }
                        },
                        error: function(xhr) {
                            console.error('Error loading modal content:', xhr);
                            if (typeof Swal !== 'undefined') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: 'Gagal memuat form. Silakan coba lagi.'
                                });
                            } else {
                                alert('Gagal memuat form. Silakan coba lagi.');
                            }
                        }
                    });
                };

                // Handle close button clicks
                $(document).off('click', '[data-modal-hide]').on('click', '[data-modal-hide]', function() {
                    const modalId = $(this).data('modal-hide');
                    disposeModal(modalId);
                });

                // Dispose modal function
                window.disposeModal = function(modalId = 'modal') {
                    const modal = document.getElementById(modalId);
                    if (!modal) return;

                    const modalInstance = window.modalInstances[modalId];

                    if (modalInstance) {
                        try {
                            if (typeof modalInstance.hide === 'function') {
                                modalInstance.hide();
                            }
                            if (typeof modalInstance.dispose === 'function') {
                                modalInstance.dispose();
                            }
                        } catch (error) {
                            console.error('Error disposing modal instance:', error);
                        }

                        // Clean up
                        delete window.modalInstances[modalId];
                    }

                    // Fallback: hide modal manually
                    modal.classList.remove('show');
                    $('#' + modalId + '-content').empty();
                }

                // Handle escape key
                $(document).on('keydown', function(e) {
                    if (e.key === 'Escape') {
                        const visibleModals = $('.modal.show');
                        if (visibleModals.length > 0) {
                            const modalId = visibleModals.last().attr('id');
                            disposeModal(modalId);
                        }
                    }
                });

                // Handle click outside modal
                $(document).on('click', '.modal', function(e) {
                    if (e.target === this) {
                        const modalId = $(this).attr('id');
                        disposeModal(modalId);
                    }
                });
            });
        </script>
    @endpush
@endonce
