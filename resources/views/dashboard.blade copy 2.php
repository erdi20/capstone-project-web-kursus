<x-app-layout>
    <div class="mx-auto max-w-[1200px] px-4 py-7" role="main">
        <!-- Carousel Slider -->
        @if ($sliders->count())
            <div class="relative mx-auto my-8 w-full max-w-7xl overflow-hidden rounded-xl shadow-lg">
                <!-- Slide Container -->
                <div id="slide-container" class="relative h-96 transition-transform duration-500 ease-in-out md:h-[500px]">
                    @foreach ($sliders as $index => $slider)
                        <div class="absolute inset-0 h-full w-full transition-opacity duration-500" style="transform: translateX({{ $index * 100 }}%); opacity: {{ $loop->first ? 1 : 0 }};" id="slide-{{ $index }}">
                            <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title ?? 'Slider ' . ($index + 1) }}" class="h-full w-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                            <div class="absolute bottom-8 left-8 max-w-2xl text-white">
                                @if ($slider->title)
                                    <h2 class="mb-2 text-3xl font-bold md:text-4xl">{{ $slider->title }}</h2>
                                @endif
                                @if ($slider->description)
                                    <p class="text-lg">{{ $slider->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Navigation Arrows -->
                <button id="prev-btn" class="absolute left-4 top-1/2 z-10 -translate-y-1/2 rounded-full bg-white/80 p-2 shadow-md hover:bg-white">
                    <svg class="h-6 w-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button id="next-btn" class="absolute right-4 top-1/2 z-10 -translate-y-1/2 rounded-full bg-white/80 p-2 shadow-md hover:bg-white">
                    <svg class="h-6 w-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Indicators -->
                <div class="absolute bottom-4 left-1/2 z-10 flex -translate-x-1/2 transform space-x-2">
                    @foreach ($sliders as $index => $slider)
                        <button class="h-3 w-3 rounded-full bg-white/50 transition hover:bg-white" data-slide="{{ $index }}" id="indicator-{{ $index }}">
                        </button>
                    @endforeach
                </div>
            </div>


        @endif
        <!-- SESSION BANNER / SLIDE BANNER -->
        <section class="mb-8 overflow-hidden rounded-xl bg-green-50">
            <div class="flex flex-col items-center gap-6 p-6 md:flex-row md:p-10">
                <div class="md:w-1/2">
                    <h2 class="mb-3 text-2xl font-bold text-gray-800">Tempat Terbaik untuk Mulai Perjalanan Belajarmu</h2>
                    <p class="mb-5 text-gray-600">Belajar jadi lebih seru dan terasa melejit. Materi terstruktur, latihan interaktif, dan Kursus live yang membantu kamu berkembang.</p>
                    <a href="{{ route('listkelas') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-green-600 px-6 py-3 font-semibold text-white transition hover:bg-green-700">
                        Jelajahi Kelas
                    </a>
                </div>
                <div class="md:w-1/2">
                    <img src="{{ asset('img/satu.jpg') }}" alt="Ilustrasi belajar" class="h-auto w-full rounded-lg object-contain shadow-md">
                </div>
            </div>
        </section>

        <!-- HERO UTAMA -->
        <section class="flex flex-wrap items-center justify-between gap-4 rounded-[14px] bg-gradient-to-r from-[#ffd89b] to-[#ffe0c7] p-9 shadow-[0_6px_20px_rgba(15,23,42,0.06)]" aria-labelledby="home-hero-title">
            <div class="min-w-[260px] flex-1 flex-shrink-0">
                <h1 id="home-hero-title" class="m-0 mb-3 text-[clamp(1.6rem,3.2vw,2.4rem)] font-bold leading-[1.05] text-[#072033]">Tempat Terbaik untuk Mulai Perjalanan Belajarmu</h1>
                <p class="mb-5 text-[#6c757d]">Belajar jadi lebih seru dan terasa melejit. Materi terstruktur, latihan interaktif, dan Kursus live yang membantu kamu berkembang.</p>

                <div class="flex flex-wrap gap-3">
                    <a href="#" class="inline-flex min-w-[140px] flex-1 items-center justify-center gap-2 rounded-[10px] bg-gradient-to-r from-[#ffd89b] to-[#19547b] px-4 py-2.5 font-bold text-[#072033] shadow-[0_8px_20px_rgba(25,84,123,0.08)] transition-transform duration-100 ease-[cubic-bezier(0.25,0.1,0.25,1)] active:translate-y-0.5">Jelajahi Kursus</a>
                    <a href="#" class="inline-flex min-w-[140px] flex-1 items-center justify-center gap-2 rounded-[10px] border border-[rgba(7,32,51,0.08)] bg-transparent px-4 py-2.5 font-bold text-[#072033] transition-transform duration-100 ease-[cubic-bezier(0.25,0.1,0.25,1)] active:translate-y-0.5">Mulai Latihan Soal</a>
                </div>

                <div class="mt-3.5 text-sm text-[#6c757d]">
                    <span class="mr-4.5">• Kurikulum terstruktur</span>
                    <span class="mr-4.5">• Sertifikat kelulusan</span>
                    <span>• Komunitas & jadwal live</span>
                </div>
            </div>

            <div>
                <img src="{{ asset('asset/2324550.png') }}" alt="Ilustrasi hero" class="h-auto w-full max-w-[420px] flex-shrink-0 rounded-[12px] object-contain shadow-[0_6px_20px_rgba(15,23,42,0.06)]">
            </div>
        </section>

        <!-- Kursus POPULER -->
        <!-- Kursus POPULER -->
        <section class="mt-8.5" aria-labelledby="popular-classes">
            <div class="mb-3 flex flex-wrap items-center justify-between gap-3">
                <h3 id="popular-classes" class="text-base font-medium">Kursus Populer</h3>
                <a href="{{ route('listkursus') }}" class="inline-flex items-center justify-center gap-2 rounded-[10px] border-none bg-transparent px-4 py-2.5 font-bold text-[#19547b] transition-transform duration-100 ease-[cubic-bezier(0.25,0.1,0.25,1)] active:translate-y-0.5">Lihat semua</a>
            </div>

            <div class="grid grid-cols-3 gap-4" role="list">
                @forelse($popularCourses as $course)
                    <article class="flex flex-col overflow-hidden rounded-[12px] bg-white shadow-[0_6px_20px_rgba(15,23,42,0.06)] transition-transform duration-100 ease-[cubic-bezier(0.25,0.1,0.25,1)] hover:translate-y-[-6px] hover:shadow-[0_12px_40px_rgba(15,23,42,0.09)]" role="listitem" aria-label="{{ $course->name }}">
                        <img src="{{ asset('storage/' . ($course->thumbnail ?? 'default-course.jpg')) }}" alt="{{ $course->name }}" class="block h-40 w-full object-cover">
                        <div class="flex flex-1 flex-col gap-2 p-3.5">
                            <h4 class="m-0 text-base font-bold">{{ $course->name }}</h4>
                            <div class="text-sm text-[#6c757d]">Mentor: {{ $course->user?->name ?? '—' }}</div>
                            <div class="mt-auto flex items-center justify-between gap-3">
                                <div class="text-sm text-[#6c757d]">
                                    {{ $course->enrollment_count ?? 0 }} pendaftar
                                </div>
                                <a href="{{ route('detailkursus', $course->slug) }}" class="inline-block rounded-[8px] bg-[#0f5132] px-3 py-2 font-bold text-white no-underline">Detail</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-3 py-4 text-center text-gray-500">
                        Belum ada kursus populer.
                    </div>
                @endforelse
            </div>

            <div class="mt-3.5 text-center">
                <a href="{{ route('listkursus') }}" class="mt-3.5 inline-block rounded-[10px] bg-black px-4 py-2.5 font-bold text-white no-underline">Lihat Kursus Lainnya</a>
            </div>
        </section>

        <!-- KATEGORI POPULER -->
        {{-- Kursus Terbaik Berdasarkan Ulasan --}}
        <section class="mt-12" aria-labelledby="top-courses">
            <div class="mb-5 flex items-center justify-between">
                <h3 id="top-courses" class="text-2xl font-bold text-gray-900">Kursus Terbaik</h3>
                <a href="{{ route('listkursus') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                    Lihat Semua →
                </a>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($topRatedCourses as $course)
                    @php
                        $avgRating = $course->avg_rating ?? 0;
                        $reviewCount = $course->review_count ?? 0;
                    @endphp

                    <a href="{{ route('detailkursus', $course->slug) }}" class="group block rounded-2xl border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:shadow-md">
                        <div class="relative">
                            <img src="{{ asset('storage/' . ($course->thumbnail ?? 'default-course.jpg')) }}" alt="{{ $course->name }}" class="h-48 w-full rounded-t-2xl object-cover">
                            @if ($reviewCount > 0)
                                <div class="absolute right-3 top-3 flex items-center gap-1 rounded-full bg-white/90 px-2 py-1 shadow-sm">
                                    <svg class="h-4 w-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <span class="text-sm font-bold text-gray-800">{{ number_format($avgRating, 1) }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="p-4">
                            <h4 class="line-clamp-2 text-lg font-bold text-gray-900 group-hover:text-indigo-700">
                                {{ $course->name }}
                            </h4>

                            @if ($reviewCount > 0)
                                <div class="mt-2 flex items-center justify-between">
                                    <div class="flex">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="{{ $i <= floor($avgRating) ? 'text-amber-500' : ($i - 0.5 <= $avgRating ? 'text-amber-400' : 'text-gray-300') }} h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <span class="text-sm text-gray-500">({{ $reviewCount }} ulasan)</span>
                                </div>
                            @else
                                <p class="mt-2 text-sm italic text-gray-500">Belum ada ulasan</p>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-8 text-center">
                        <p class="text-gray-500">Belum ada kursus dengan ulasan.</p>
                    </div>
                @endforelse
            </div>
        </section>

        {{-- Kursus Pilihan Acak --}}
        <section class="mt-12" aria-labelledby="random-courses">
            <div class="mb-5 flex items-center justify-between">
                <h3 id="random-courses" class="text-2xl font-bold text-gray-900">Kursus Pilihan</h3>
                <a href="{{ route('listkursus') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                    Lihat Semua →
                </a>
            </div>

            <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 lg:grid-cols-5">
                @forelse($randomCourses as $course)
                    <a href="{{ route('detailkursus', $course->slug) }}" class="group block rounded-xl border border-gray-200 bg-white p-3 shadow-sm transition-all duration-200 hover:shadow-md">
                        <div class="relative h-32 w-full overflow-hidden rounded-lg">
                            <img src="{{ asset('storage/' . ($course->thumbnail ?? 'default-course.jpg')) }}" alt="{{ $course->name }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                        </div>
                        <div class="mt-3">
                            <h4 class="line-clamp-2 text-sm font-bold text-gray-900 group-hover:text-indigo-700">
                                {{ $course->name }}
                            </h4>
                            <p class="mt-1 text-xs text-gray-600">
                                {{ $course->user?->name ?? 'Mentor' }}
                            </p>
                            @if ($course->price || $course->discount_price)
                                <div class="mt-2">
                                    @php
                                        $isDiscount = $course->discount_price !== null && ($course->discount_end_date === null || now()->lessThan($course->discount_end_date));
                                        $finalPrice = $isDiscount ? $course->discount_price : $course->price;
                                    @endphp
                                    <span class="text-sm font-bold text-green-700">
                                        Rp {{ number_format($finalPrice, 0, ',', '.') }}
                                    </span>
                                    @if ($isDiscount && $course->price)
                                        <span class="ml-1 text-xs text-gray-500 line-through">
                                            Rp {{ number_format($course->price, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-8 text-center">
                        <p class="text-gray-500">Belum ada kursus lainnya.</p>
                    </div>
                @endforelse
            </div>
        </section>


        <!-- ULASAN -->
        <!-- ULASAN -->
        <section class="mt-8.5" aria-labelledby="reviews">
            <div class="mb-3 flex flex-wrap items-center justify-between gap-3">
                <h3 id="reviews" class="text-base font-medium">Ulasan Mereka</h3>
                <small class="text-sm text-[#6c757d]">Dari siswa yang sudah mencoba</small>
            </div>

            <div class="mt-3 grid grid-cols-2 gap-4">
                @forelse($testimonials as $testimonial)
                    <div class="rounded-[12px] bg-gradient-to-b from-white to-[#f8fbff] p-4 shadow-[0_6px_20px_rgba(15,23,42,0.06)]">
                        <p class="m-0 mb-3">“{{ $testimonial->review }}”</p>
                        <div class="flex items-center gap-3">
                            <div class="flex h-11 w-11 items-center justify-center rounded-full bg-[#0f5132] font-bold text-white">
                                {{ strtoupper(substr($testimonial->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <strong>{{ $testimonial->user->name }}</strong>
                                <div class="text-sm text-[#6c757d]">Siswa</div>
                            </div>
                            <div class="ml-auto flex">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= $testimonial->rating ? 'text-amber-500' : 'text-gray-300' }} text-sm">
                                        ⭐
                                    </span>
                                @endfor
                            </div>
                        </div>
                        @if ($testimonial->courseClass?->course)
                            <div class="mt-2 text-xs text-[#6c757d]">
                                Kursus: {{ $testimonial->courseClass->course->name }}
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-span-2 py-6 text-center text-gray-500">
                        Belum ada ulasan dari siswa.
                    </div>
                @endforelse
            </div>
        </section>

        <!-- FAQ -->
        <section class="mt-12" aria-labelledby="faq-section">
            <div class="mb-5">
                <h3 id="faq-section" class="text-2xl font-bold text-gray-900">Pertanyaan Umum</h3>
                <p class="mt-2 text-gray-600">Temukan jawaban atas pertanyaan yang sering diajukan.</p>
            </div>

            <div class="space-y-3">
                @forelse($faqs as $faq)
                    <div class="rounded-lg border border-gray-200 bg-white p-4">
                        <details class="group">
                            <summary class="cursor-pointer list-none font-semibold text-gray-800 transition group-open:text-indigo-600">
                                {{ $faq->question }}
                                <span class="float-right transition group-open:rotate-180">
                                    <svg class="h-5 w-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </summary>
                            <div class="mt-3 text-gray-600">
                                {!! $faq->answer !!}
                            </div>
                        </details>
                    </div>
                @empty
                    <p class="rounded-lg bg-gray-50 p-4 text-gray-500">Belum ada pertanyaan umum.</p>
                @endforelse
            </div>
        </section>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sliders = @json($sliders);
            const totalSlides = sliders.length;
            let currentSlide = 0;
            const slideContainer = document.getElementById('slide-container');
            const indicators = document.querySelectorAll('[data-slide]');

            // Update slide
            function updateSlide() {
                // Update position
                slideContainer.style.transform = `translateX(-${currentSlide * 100}%)`;

                // Update opacity for smooth transition
                document.querySelectorAll('#slide-container > div').forEach((slide, index) => {
                    slide.style.opacity = index === currentSlide ? '1' : '0';
                });

                // Update indicators
                indicators.forEach((indicator, index) => {
                    indicator.classList.toggle('bg-white', index === currentSlide);
                    indicator.classList.toggle('bg-white/50', index !== currentSlide);
                });
            }

            // Next slide
            document.getElementById('next-btn').addEventListener('click', () => {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateSlide();
            });

            // Prev slide
            document.getElementById('prev-btn').addEventListener('click', () => {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                updateSlide();
            });

            // Indicator click
            indicators.forEach(button => {
                button.addEventListener('click', () => {
                    currentSlide = parseInt(button.dataset.slide);
                    updateSlide();
                });
            });

            // Auto slide every 5 seconds
            setInterval(() => {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateSlide();
            }, 5000);
        });
    </script>
</x-app-layout>
