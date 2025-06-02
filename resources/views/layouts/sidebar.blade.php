<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-68 h-screen transition-transform -translate-x-full sm:translate-x-0 p-3"
    aria-label="Sidebar">
    <div class="h-full px-3 py-3 overflow-y-auto bg-gray-100 rounded-xl">
        <a route="https://flowbite.com/" class="bg-white flex items-center justify-center rounded-xl px-3 py-4 mb-8">
            <img src="https://flowbite.com/docs/images/logo.svg" class="h-6 me-3 sm:h-7" alt="Flowbite Logo" />
            <span class="self-center text-xl font-semibold whitespace-nowrap ">{{ config('app.name') }}
            </span>
        </a>
        <ul class="space-y-2 font-medium bg-white rounded-xl p-2 mb-2">
            <h6 class="text-xs text-gray-400 ms-5 mt-2 mb-4">MENU</h6>
            <div class="mt-3"></div>
            <x-sidebar.menu-item route="admin.dashboard" icon='fa-solid fa-house' title="Dashboard" />
        </ul>

        <ul class="space-y-2 font-medium bg-white rounded-xl px-2 py-3 mb-3">
            <h6 class="text-xs text-gray-400 ms-5 mt-2 mb-4">MANAJEMEN PENGGUNA</h6>
            <x-sidebar.menu-item route="" icon='fa-solid fa-user-graduate' title="Kelola Mahasiswa" />
            <x-sidebar.menu-item route="" icon='fa-solid fa-chalkboard-teacher' title="Kelola Dosen" />
            <x-sidebar.menu-item route="" icon='fa-solid fa-user-shield' title="Kelola Admin" />
        </ul>

        <ul class="space-y-2 font-medium bg-white rounded-xl p-2 mb-3">
            <h6 class="text-xs text-gray-400 ms-5 mt-2 mb-4">MANAJEMEN LOMBA</h6>
            <x-sidebar.menu-item route="" icon='fa-solid fa-users' title="Kelola Kelompok" />
            <x-sidebar.menu-item route="" icon='fa-solid fa-trophy' title="Kelola Lomba" />
            <x-sidebar.menu-item route="" icon='fa-solid fa-medal' title="Kelola Prestasi" />
        </ul>

        <ul class="space-y-2 font-medium bg-white rounded-xl p-2 mb-3">
            <h6 class="text-xs text-gray-400 ms-5 mt-2 mb-4">MASTER DATA</h6>
            <x-sidebar.menu-item route="" icon='fa-solid fa-calendar-days' title="Kelola Periode" />
            <x-sidebar.menu-item route="admin.master.periode.index" icon='fa-solid fa-building-columns' title="Kelola Program Studi" />
            <x-sidebar.menu-item route="" icon='fa-solid fa-layer-group' title="Kelola Kompetensi" />
            <x-sidebar.menu-item route="admin.master.bidang-keahlian.index" icon='fa-solid fa-briefcase'
                title="Kelola Keahlian" />
            <x-sidebar.menu-item route="" icon='fa-solid fa-heart' title="Kelola Minat" />
        </ul>

        <ul class="space-y-2 font-medium bg-white rounded-xl p-2 mb-3">
            <h6 class="text-xs text-gray-400 ms-5 mt-2 mb-4">PENGATURAN</h6>
            <x-sidebar.menu-item route="profile.index" icon='fa-solid fa-user-cog' title="Profil" />
            <x-sidebar.menu-item onclick="logout()" icon='fa-solid fa-right-from-bracket' title="Log out" />
        </ul>
    </div>
</aside>

<script>
    function logout(event) {
        Swal.fire({
            title: "KONFIRMASI",
            text: "Apakah anda yakin untuk keluar?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            confirmButtonText: "Log out",
            cancelButtonText: "Kembali"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Logged out!",
                    text: "Anda berhasil keluar!",
                    icon: "success"
                }).then(() => {
                    window.location.href = '{{ route('logout') }}';
                });
            }
        });
    }
</script>
