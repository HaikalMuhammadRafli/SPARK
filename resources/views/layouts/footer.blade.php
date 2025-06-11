<footer>
    <div class="bg-white rounded-xl w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <a href="/" class="flex items-center mb-4 sm:mb-0 space-x-1 rtl:space-x-reverse">
                <img src="{{ asset('spark/spark-logo.png') }}" class="h-8" alt="Spark Logo" />
                <span
                    class="self-center text-transparent bg-clip-text bg-gradient-to-bl from-secondary to-primary text-2xl font-bold whitespace-nowrap">{{ config('app.name') }}</span>
            </a>
            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0">
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">About</a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a>
                </li>
                <li>
                    <a href="#" class="hover:underline me-4 md:me-6">Licensing</a>
                </li>
                <li>
                    <a href="#" class="hover:underline">Contact</a>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
        <span class="block text-sm text-gray-500 sm:text-center">© 2023 <a href="https://flowbite.com/"
                class="hover:underline">{{ config('app.name') }}™</a>. All Rights Reserved.</span>
    </div>
</footer>
