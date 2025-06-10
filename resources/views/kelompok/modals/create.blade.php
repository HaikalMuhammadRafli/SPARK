<!-- Modal header -->
<div class="flex items-center justify-between px-4 py-3 border-b rounded-t-xl bg-primary border-gray-200">
    <h3 class="text-sm font-semibold text-white">
        <i class="fa-solid fa-file-circle-plus me-1"></i>
        Create Kelompok
    </h3>
    <button type="button" class="text-white bg-transparent text-sm text-center cursor-pointer" data-modal-hide="modal">
        <i class="fa-solid fa-xmark"></i>
        <span class="sr-only">Close modal</span>
    </button>
</div>

<!-- Modal body with tabs -->
<div class="p-4 md:p-5">
    <!-- Tab navigation -->
    <div class="border-b border-gray-200 mb-4">
        <nav class="-mb-px flex space-x-8">
            <button type="button"
                    class="tab-button active border-b-2 border-primary text-primary py-2 px-1 text-sm font-medium"
                    data-tab="kelompok-form">
                Form Kelompok
            </button>
            <button type="button"
                    class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-2 px-1 text-sm font-medium"
                    data-tab="spk-form">
                SPK Rekomendasi
            </button>
        </nav>
    </div>

    <!-- Tab content -->
    <div class="tab-content">
        <!-- Kelompok Form Tab -->
        <div id="kelompok-form" class="tab-pane block">
            @include('kelompok.partials.form', [
                'action' => route('admin.manajemen.kelompok.store'),
                'method' => 'POST',
                'buttonText' => 'Tambah',
                'buttonIcon' => 'fa-solid fa-plus',
            ])
        </div>

        <!-- SPK Form Tab -->
        <div id="spk-form" class="tab-pane hidden">
            @include('kelompok.partials.spk', [
                'action' => route('admin.manajemen.kelompok.spk'),
                'method' => 'POST',
            ])
        </div>
    </div>
</div>

<script>
// Function to initialize tabs
function initializeTabs() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabPanes = document.querySelectorAll('.tab-pane');

    console.log('Tab buttons found:', tabButtons.length);
    console.log('Tab panes found:', tabPanes.length);

    tabButtons.forEach((button, index) => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Tab clicked:', this.getAttribute('data-tab'));

            const targetTab = this.getAttribute('data-tab');

            // Remove active classes from all buttons
            tabButtons.forEach(btn => {
                btn.classList.remove('border-primary', 'text-primary', 'active');
                btn.classList.add('border-transparent', 'text-gray-500');
            });

            // Hide all tab panes
            tabPanes.forEach(pane => {
                pane.classList.add('hidden');
                pane.classList.remove('block', 'active');
            });

            // Add active classes to current button
            this.classList.add('border-primary', 'text-primary', 'active');
            this.classList.remove('border-transparent', 'text-gray-500');

            // Show target pane
            const targetPane = document.getElementById(targetTab);
            if (targetPane) {
                targetPane.classList.remove('hidden');
                targetPane.classList.add('block', 'active');
                console.log('Switched to tab:', targetTab);
            } else {
                console.error('Target pane not found:', targetTab);
            }
        });
    });
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeTabs);
} else {
    initializeTabs();
}

// Also initialize when modal is shown (if using a modal library)
document.addEventListener('shown.bs.modal', initializeTabs); // Bootstrap
// Or for other modal libraries, use their respective events
</script>
