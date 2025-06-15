@extends('layouts.app')

@section('content')
    <section class="max-w-7xl justify-center items-center mx-auto">
        <nav class="flex justify-between px-12 mt-6 items-center p-6">
            <a href="#" class="text-xl font-bold text-black italic">SiPresma</a>
            <div class="space-x-8">
                <a href="#" class="text-gray-700 hover:text-black">About us</a>
                <a href="#" class="text-gray-700 hover:text-black">Services</a>
                <a href="#" class="text-gray-700 hover:text-black">Use Cases</a>
                <a href="#" class="text-gray-700 hover:text-black">Team</a>
                <a href="#" class="text-gray-700 hover:text-black">Blog</a>
                <a href="{{ route('login') }}"
                    class=" text-black border-1 border-gray-600 px-8 py-4 rounded-2xl hover:bg-gray-700">Request
                    a
                    Login</a>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="flex items-center justify-between h-screen px-12 py-16">
            <div class="flex flex-col justify-center items-start max-w-lg">
                <h1 class="text-6xl font-bold text-black leading-tight">
                    System Pendukung Mahasiswa Prestasi <br> <span class="italic bg-lime-300 px-2"> SiPresma </span>
                </h1>
                <p class="mt-10 text-xl text-gray-700">
                    System Pendukung Mahasiswa Prestasi adalah sebuah system yang dimana untuk membantu mahasiswa
                    prestasi,
                    dalam rangka untuk melanjutkan innovasi - innovasi mereka di bidang yang sudah di tekuni,
                    SiPresma adalah Wadah bagi mahasiswa prestasi untuk mendapatkan dukungan dari para petinggi maupun
                    investor
                </p>
                <a href="#"
                    class="mt-4 text-white font-mono border-slate-500 border-b-4 hover:text-slate-400 rounded-lg bg-black py-2 px-4">Book
                    a
                    consultation</a>
            </div>
            <div class="relative">
                <img src="{{ asset('images/terompet.png') }}" alt="illustration" class="scale-100">
            </div>
        </section>

        <!-- Services Section -->
        <section class=" py-16 px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-green-600">Services</h2>
                <p class="mt-4 text-xl font-serif text-gray-600">
                    At our digital marketing agency, we offer a range of services to help businesses grow and succeed
                    online.
                    These
                    services include:
                </p>
            </div>

            <!-- Services Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-6 px-40">

                <!-- Card 1: Search Engine Optimization -->
                <div class="bg-gray-200 p-8 rounded-3xl border-b-8 border-black shadow-xl border-1 hover:shadow-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-semibold text-black">Lomba International</h3>
                        <img src="{{ asset('images/fixedbug.png') }}" alt="SEO" class="w-40 h-32">
                    </div>
                    <p class="text-gray-600 mt-4">
                        Improve your website’s ranking and drive more organic traffic with our SEO strategies.
                    </p>
                    <a href="#" class="mt-6 inline-flex items-center text-black hover:text-green-600">
                        Learn more
                        <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                </div>

                <!-- Card 2: Pay-per-click Advertising -->
                <div class="bg-lime-400 p-8 rounded-3xl border-b-8 border-black shadow-xl border-1 hover:shadow-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-semibold text-green-600">Lomba Nasional</h3>
                        <img src="{{ asset('images/fixedbug.png') }}" alt="PPC" class="w-40 h-32">
                    </div>
                    <p class="text-gray-600 mt-4">
                        Maximize your ad spend with targeted campaigns designed to bring measurable results.
                    </p>
                    <a href="#" class="mt-6 inline-flex items-center text-black hover:text-green-600">
                        Learn more
                        <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                </div>

                <!-- Card 3: Social Media Marketing -->
                <div class="bg-gray-800 p-8 rounded-3xl border-b-8 border-black shadow-xl border-1 hover:shadow-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-semibold text-white">Project Portofolio</h3>
                        <img src="{{ asset('images/social-media-icon.svg') }}" alt="Social Media" class="w-12 h-12">
                    </div>
                    <p class="text-gray-100 mt-4">
                        Engage with your audience and build your brand presence across social media platforms.
                    </p>
                    <a href="#" class="mt-6 inline-flex items-center text-white hover:text-green-600">
                        Learn more
                        <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                </div>

                <!-- Card 4: Email Marketing -->
                <div class="bg-white p-8 rounded-3xl border-b-8 border-black shadow-xl border-1 hover:shadow-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-semibold text-green-600">Innovasi </h3>
                        <img src="{{ asset('images/email-marketing-icon.svg') }}" alt="Email Marketing" class="w-12 h-12">
                    </div>
                    <p class="text-gray-600 mt-4">
                        Reach your customers directly with engaging email campaigns that drive conversions.
                    </p>
                    <a href="#" class="mt-6 inline-flex items-center text-green-500 hover:text-green-600">
                        Learn more
                        <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                </div>

                <!-- Card 5: Content Creation -->
                <div class="bg-lime-400 p-8 rounded-3xl border-b-8 border-black shadow-xl border-1 hover:shadow-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-semibold text-black">Content Creation</h3>
                        <img src="{{ asset('images/content-creation-icon.svg') }}" alt="Content Creation"
                            class="w-12 h-12">
                    </div>
                    <p class="text-gray-600 mt-4">
                        Create high-quality, engaging content that resonates with your target audience.
                    </p>
                    <a href="#" class="mt-6 inline-flex items-center text-black hover:text-green-600">
                        Learn more
                        <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                </div>

                <!-- Card 6: Analytics and Tracking -->
                <div class="bg-gray-800 p-8 rounded-3xl border-b-8 border-black shadow-xl border-1 hover:shadow-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-semibold text-white">Analytics and Tracking</h3>
                        <img src="{{ asset('images/analytics-icon.svg') }}" alt="Analytics" class="w-12 h-12">
                    </div>
                    <p class="text-gray-100 mt-4">
                        Gain insights into your business performance with detailed analytics and tracking.
                    </p>
                    <a href="#" class="mt-6 inline-flex items-center text-white hover:text-green-600">
                        Learn more
                        <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                </div>

            </div>
        </section>


        <section class="py-16 px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-semibold text-green-600">Our Working Process</h2>
                <p class="text-xl text-gray-600 mt-4">Step-by-Step Guide to Achieving Your Prestasi</p>
            </div>

            <div class="space-y-6">
                <!-- Step 1 -->
                <div id="step1" class="bg-lime-300 p-6 rounded-xl shadow-2xl border border-b-8 border-gray-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-black text-2xl font-semibold">01 Consultation</h3>
                        <span class="text-black text-xl cursor-pointer" onclick="toggleContent(1)">-</span>
                    </div>
                    <div id="step1-content" class="border-t border-black p-4 mt-4">
                        <p class="text-black mt-4">
                            During the initial consultation, we will discuss your business goals and objectives, target
                            audience, and
                            current marketing efforts. This will allow us to understand your needs and tailor our
                            services to best fit
                            your requirements.
                        </p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div id="step2" class="bg-gray-200 p-6 rounded-xl shadow-xl border border-b-4 border-gray-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-black text-2xl font-semibold">02 Research and Strategy Development</h3>
                        <span class="text-black text-xl cursor-pointer" onclick="toggleContent(2)">+</span>
                    </div>
                    <div id="step2-content" class="hidden p-4">
                        <p class="text-black">
                            In this step, we perform an in-depth research on your market and competition to develop a
                            strategy that
                            aligns
                            with your business objectives and target audience.
                        </p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div id="step3" class="bg-gray-200 p-6 rounded-xl shadow-xl border border-b-4 border-gray-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-black text-2xl font-semibold">03 Implementation</h3>
                        <span class="text-black text-xl cursor-pointer" onclick="toggleContent(3)">+</span>
                    </div>
                    <div id="step3-content" class="hidden p-4">
                        <p class="text-black">
                            We implement the strategies we’ve developed, ensuring that everything is executed
                            efficiently, while
                            monitoring the progress and making adjustments as necessary.
                        </p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div id="step4" class="bg-gray-200 p-6 rounded-xl shadow-xl border border-b-4 border-gray-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-black text-2xl font-semibold">04 Monitoring and Optimization</h3>
                        <span class="text-black text-xl cursor-pointer" onclick="toggleContent(4)">+</span>
                    </div>
                    <div id="step4-content" class="hidden p-4">
                        <p class="text-black">
                            In this phase, we continuously monitor the results of our efforts and optimize campaigns to
                            ensure maximum
                            performance and return on investment.
                        </p>
                    </div>
                </div>

                <!-- Step 5 -->
                <div id="step5" class="bg-gray-200 p-6 rounded-xl shadow-xl border border-b-4 border-gray-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-black text-2xl font-semibold">05 Reporting and Communication</h3>
                        <span class="text-black text-xl cursor-pointer" onclick="toggleContent(5)">+</span>
                    </div>
                    <div id="step5-content" class="hidden p-4">
                        <p class="text-black">
                            We provide you with detailed reports on the progress of your campaigns, explaining the data
                            and our
                            strategies
                            in a way that is easy to understand.
                        </p>
                    </div>
                </div>

                <!-- Step 6 -->
                <div id="step6" class="bg-gray-200 p-6 rounded-xl shadow-xl border border-b-4 border-gray-700">
                    <div class="flex items-center justify-between">
                        <h3 class="text-black text-2xl font-semibold">06 Continual Improvement</h3>
                        <span class="text-black text-xl cursor-pointer" onclick="toggleContent(6)">+</span>
                    </div>
                    <div id="step6-content" class="hidden p-4">
                        <p class="text-black">
                            We focus on continuous improvement by analyzing results, making adjustments, and adapting to
                            changing
                            market
                            conditions to ensure ongoing success.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-16 px-6">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-semibold text-green-600">Team</h2>
                <p class="text-xl text-gray-600 mt-4">Meet the skilled and experienced team behind our successful
                    digital
                    marketing
                    strategies</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-6 px-40">

                <!-- Card 1: Search Engine Optimization -->
                <div class="bg-gray-200 p-8 rounded-3xl border-b-8 border-black shadow-xl border-1 hover:shadow-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-semibold text-black">
                            Muhammad Kevin
                        </h3>
                        <div class="relative w-24 h-24 mx-auto rounded-full overflow-hidden mb-4">
                            <img src="{{ asset('images/fixedbug.png') }}" alt="SEO" class="w-full h-full cover">
                        </div>
                    </div>
                    <p class="text-gray-600 mt-4">
                        Improve your website’s ranking and drive more organic traffic with our SEO strategies.
                    </p>
                    <a href="#" class="mt-6 inline-flex items-center text-green-500 hover:text-green-600">
                        LinkedIn
                        <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                </div>

                <!-- Card 2: Pay-per-click Advertising -->
                <div class="bg-white p-8 rounded-3xl border-b-8 border-black shadow-xl border-1 hover:shadow-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-semibold text-green-600">Muhammad Haikal</h3>
                        <div class="relative w-24 h-24 mx-auto rounded-full overflow-hidden mb-4">
                            <img src="{{ asset('images/fixedbug.png') }}" alt="PPC" class="w-full h-full cover">
                        </div>
                    </div>
                    <p class="text-gray-600 mt-4">
                        Maximize your ad spend with targeted campaigns designed to bring measurable results.
                    </p>
                    <a href="#" class="mt-6 inline-flex items-center text-green-500 hover:text-green-600">
                        LinkedIn
                        <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                </div>

                <!-- Card 3: Social Media Marketing -->
                <div class="bg-white p-8 rounded-3xl border-b-8 border-black shadow-xl border-1 hover:shadow-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-semibold text-green-600">Muhammad Fawwaz</h3>
                        <img src="{{ asset('images/social-media-icon.svg') }}" alt="Social Media" class="w-12 h-12">
                    </div>
                    <p class="text-gray-600 mt-4">
                        Engage with your audience and build your brand presence across social media platforms.
                    </p>
                    <a href="#" class="mt-6 inline-flex items-center text-green-500 hover:text-green-600">
                        LinkedIn
                        <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                </div>

                <!-- Card 4: Email Marketing -->
                <div class="bg-white p-8 rounded-3xl border-b-8 border-black shadow-xl border-1 hover:shadow-2xl">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-semibold text-green-600">Muhammad Dina </h3>
                        <img src="{{ asset('images/email-marketing-icon.svg') }}" alt="Email Marketing"
                            class="w-12 h-12">
                    </div>
                    <p class="text-gray-600 mt-4">
                        Reach your customers directly with engaging email campaigns that drive conversions.
                    </p>
                    <a href="#" class="mt-6 inline-flex items-center text-green-500 hover:text-green-600">
                        LinkedIn
                        <svg class="w-5 h-5 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <script>
            let openStep = null;

            function toggleContent(stepNumber) {
                const content = document.getElementById(`step${stepNumber}-content`);
                const icon = content.previousElementSibling.querySelector('span');
                const step = document.getElementById(`step${stepNumber}`);

                // Jika langkah sebelumnya terbuka, tutupkan
                if (openStep && openStep !== stepNumber) {
                    const previousContent = document.getElementById(`step${openStep}-content`);
                    const previousStep = document.getElementById(`step${openStep}`);
                    const previousIcon = previousContent.previousElementSibling.querySelector('span');

                    // Menutup langkah yang sedang terbuka
                    previousContent.classList.add('hidden');
                    previousIcon.textContent = '+';
                    previousStep.classList.add('bg-gray-200');
                    previousStep.classList.remove('bg-lime-300');
                    previousStep.classList.remove('border-b-8', 'border-black');
                }

                if (content.classList.contains('hidden')) {
                    content.classList.remove('hidden');
                    icon.textContent = '-';
                    step.classList.add('bg-lime-300');
                    step.classList.remove('bg-gray-200');
                    step.classList.add('border-b-8', 'border-black');
                    openStep = stepNumber;
                } else {
                    content.classList.add('hidden');
                    icon.textContent = '+';
                    step.classList.add('bg-gray-200');
                    step.classList.remove('bg-lime-300');
                    step.classList.remove('border-b-8', 'border-black');
                    openStep = null;
                }
            }
        </script>
    </section>
@endsection
