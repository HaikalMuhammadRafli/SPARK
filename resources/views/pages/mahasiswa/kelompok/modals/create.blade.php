<!-- Modal header -->
<div class="flex items-center justify-between px-4 py-3 border-b rounded-t-xl bg-primary border-gray-200">
    <h3 class="text-sm font-semibold text-white">
        <i class="fa-solid fa-file-circle-plus me-1"></i>
        Create Kelompok
    </h3>
    <button type="button" class="text-white bg-transparent text-sm text-center cursor-pointer" data-modal-hide="big-modal">
        <i class="fa-solid fa-xmark"></i>
        <span class="sr-only">Close modal</span>
    </button>
</div>

<!-- Modal body with tabs -->
<div class="p-4">
    <!-- Tab navigation -->
    <div class="w-full mb-4">
        <nav class="grid grid-cols-2">
            <button type="button"
                class="tab-button active bg-primary rounded-l-full text-white py-2 px-1 text-sm font-medium"
                data-tab="kelompok-form">
                <i class="fa-solid fa-file-invoice me-2 text-lg"></i>
                Form Kelompok
            </button>
            <button type="button"
                class="tab-button border border-gray-200 rounded-r-full text-gray-500 hover:text-gray-700 hover:border-gray-300 py-2 px-1 text-sm font-medium"
                data-tab="spk-form">
                <i class="fa-solid fa-ranking-star me-2 text-lg"></i>
                Rekomendasi Peserta
            </button>
        </nav>
    </div>

    <!-- Tab content -->
    <div class="tab-content border border-gray-200 rounded-lg">
        <!-- Kelompok Form Tab -->
        <div id="kelompok-form" class="tab-pane block">
            @include('pages.mahasiswa.kelompok.partials.form', [
                'action' => route('mahasiswa.kelompok.store'),
                'method' => 'POST',
                'buttonText' => 'Tambah',
                'buttonIcon' => 'fa-solid fa-plus',
            ])
        </div>

        <!-- SPK Form Tab -->
        <div id="spk-form" class="tab-pane hidden">
            @include('pages.mahasiswa.kelompok.partials.spk', [
                'action' => route('mahasiswa.kelompok.spk'),
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

        tabButtons.forEach((button, index) => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const targetTab = this.getAttribute('data-tab');

                // Remove active classes from all buttons
                tabButtons.forEach(btn => {
                    btn.classList.remove('bg-primary', 'text-white', 'active');
                    btn.classList.add('border', 'border-gray-200', 'text-gray-500',
                        'hover:text-gray-700', 'hover:border-gray-300');
                });

                // Hide all tab panes
                tabPanes.forEach(pane => {
                    pane.classList.add('hidden');
                    pane.classList.remove('block', 'active');
                });

                // Add active classes to current button
                this.classList.add('bg-primary', 'text-white', 'active');
                this.classList.remove('border', 'border-gray-200', 'text-gray-500',
                    'hover:text-gray-700', 'hover:border-gray-300');

                // Show target pane
                const targetPane = document.getElementById(targetTab);
                if (targetPane) {
                    targetPane.classList.remove('hidden');
                    targetPane.classList.add('block', 'active');
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
</script>
