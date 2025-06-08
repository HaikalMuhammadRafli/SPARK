<div class="bg-white flex flex-row justify-between items-center rounded-xl px-4 py-4">
    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button"
        class="inline-flex items-center text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path clip-rule="evenodd" fill-rule="evenodd"
                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
            </path>
        </svg>
    </button>
    <div class="flex items-center space-x-3">
        <button type="button"
            class="text-primary bg-gray-100 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-lg p-2.5 text-center inline-flex items-center ">
            <i class="fa-solid fa-envelope"></i>
            <span class="sr-only">Icon description</span>
        </button>
        <button type="button"
            class="text-primary bg-gray-100 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-lg p-2.5 text-center inline-flex items-center ">
            <i class="fa-solid fa-bell"></i>
            <span class="sr-only">Icon description</span>
        </button>
        <div class="flex items-center gap-2">
            <img src="{{ Storage::url(auth()->user()->foto_profil_url) ?? asset('images/default-profile.svg') }}"
                alt="Foto Profil" class="w-10 h-10 rounded-full object-cover">
            <div>
                <div class="font-bold text-sm">{{ auth()->user()->getCurrentData()->nama }}</div>
                <div class="text-xs text-gray-500">{{ auth()->user()->email }}</div>
            </div>
        </div>
    </div>
</div>
