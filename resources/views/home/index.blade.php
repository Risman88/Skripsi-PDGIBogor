<x-home-layout>
    <x-slot name="slot">
        <!-- main section -->
        <div class="absolute left-1/2 right-0 top-0 -z-10 -ml-24 transform-gpu overflow-hidden blur-3xl lg:ml-24 xl:ml-48"
            aria-hidden="true">
            <div class="aspect-[801/1036] w-[50.0625rem] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30"
                style="clip-path: polygon(63.1% 29.5%, 100% 17.1%, 76.6% 3%, 48.4% 0%, 44.6% 4.7%, 54.5% 25.3%, 59.8% 49%, 55.2% 57.8%, 44.4% 57.2%, 27.8% 47.9%, 35.1% 81.5%, 0% 97.7%, 39.2% 100%, 35.2% 81.4%, 97.2% 52.8%, 63.1% 29.5%)">
            </div>
        </div>
        <div class="overflow-hidden">
            <div class="mx-auto max-w-7xl px-6 pb-32 pt-36 sm:pt-60 lg:px-8 lg:pt-32">
                <div class="mx-auto max-w-2xl gap-x-14 lg:mx-0 lg:flex lg:max-w-none lg:items-center">
                    <div class="w-full max-w-xl lg:shrink-0 xl:max-w-2xl">
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Selamat Datang di PDGI
                            Cabang Kota Bogor</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image section -->
        <script src="https://unpkg.com/smoothscroll-polyfill@0.4.4/dist/smoothscroll.js"></script>

        <div class="relative">

            <div x-data="{
                currentSlide: 0,
                skip: 1,
                atBeginning: false,
                atEnd: false,
                autoSlideInterval: null,
                startAutoSlide() {
                    this.autoSlideInterval = setInterval(() => {
                        this.next();
                    }, 2500);
                },
                stopAutoSlide() {
                    clearInterval(this.autoSlideInterval);
                },
                goToSlide(index) {
                    let slider = this.$refs.slider;
                    let offset = slider.firstElementChild.getBoundingClientRect().width;
                    slider.scrollTo({ left: offset * index, behavior: 'smooth' });
                },
                next() {
                    let slider = this.$refs.slider;
                    let current = slider.scrollLeft;
                    let offset = slider.firstElementChild.getBoundingClientRect().width;
                    let maxScroll = offset * (slider.children.length - 1);

                    current + offset >= maxScroll ? slider.scrollTo({ left: 0, behavior: 'smooth' }) : slider.scrollBy({ left: offset * this.skip, behavior: 'smooth' });
                },
                prev() {
                    let slider = this.$refs.slider;
                    let current = slider.scrollLeft;
                    let offset = slider.firstElementChild.getBoundingClientRect().width;
                    let maxScroll = offset * (slider.children.length - 1);

                    current <= 0 ? slider.scrollTo({ left: maxScroll, behavior: 'smooth' }) : slider.scrollBy({ left: -offset * this.skip, behavior: 'smooth' });
                },
                updateButtonStates() {
                    let slideEls = this.$el.parentElement.children;
                    this.atBeginning = slideEls[0] === this.$el;
                    this.atEnd = slideEls[slideEls.length - 1] === this.$el;
                },
                focusableWhenVisible: {
                    'x-intersect:enter'() { this.$el.removeAttribute('tabindex'); },
                    'x-intersect:leave'() { this.$el.setAttribute('tabindex', '-1'); }
                },
                disableNextAndPreviousButtons: {
                    'x-intersect:enter.threshold.05'() { this.updateButtonStates(); },
                    'x-intersect:leave.threshold.05'() { this.updateButtonStates(); }
                },
                updateCurrentSlide() {
                    let slider = this.$refs.slider;
                    let offset = slider.firstElementChild.getBoundingClientRect().width;
                    this.currentSlide = Math.round(slider.scrollLeft / offset);
                }
            }" x-init="startAutoSlide()" @mouseover="stopAutoSlide()"
                @mouseout="startAutoSlide()" class="flex flex-col w-full">

                <div x-on:keydown.right="next" x-on:keydown.left="prev" tabindex="0" role="region"
                    aria-labelledby="carousel-label" class="flex space-x-6">
                    <h2 id="carousel-label" class="sr-only" hidden>Carousel</h2>
                    <span id="carousel-content-label" class="sr-only" hidden>Carousel</span>
                    <ul x-ref="slider" @scroll="updateCurrentSlide" tabindex="0" role="listbox"
                        aria-labelledby="carousel-content-label"
                        class="flex w-full overflow-x-hidden snap-x snap-mandatory">
                        @foreach ($slideshows as $slideshow)
                            <li x-bind="disableNextAndPreviousButtons"
                                class="flex flex-col items-center justify-center w-full p-0 shrink-0 snap-start"
                                role="option">
                                <img class="mx-auto" src={{ route('slideshow.banner', $slideshow->id) }} loading="lazy">
                                <!-- Indicator buttons -->
                                <div class="flex justify-center space-x-2">
                                    <template x-for="(slide, index) in Array.from($refs.slider.children)"
                                        :key="index">
                                        <button @click="goToSlide(index)"
                                            :class="{ 'bg-gray-500': currentSlide === index, 'bg-gray-300': currentSlide !==
                                                    index }"
                                            class="w-3 h-1 rounded-full lg:w-5 hover:bg-gray-400 focus:outline-none focus:bg-gray-400"></button>
                                    </template>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- Prev / Next Buttons -->
                <div class="absolute z-10 flex justify-between w-full h-full px-4">
                    <!-- Prev Button -->
                    <button x-on:click="prev" class="text-6xl" :aria-disabled="atBeginning" :tabindex="atEnd ? -1 : 0">
                        <span aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-auto h-5 text-gray-300 lg:h-8 hover:text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </span>
                        <span class="sr-only">Skip to previous slide page</span>
                    </button>


                    <!-- Next Button -->
                    <button x-on:click="next" class="text-6xl" :aria-disabled="atEnd" :tabindex="atEnd ? -1 : 0">
                        <span aria-hidden="true">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="w-auto h-5 text-gray-300 lg:h-8 hover:text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                        <span class="sr-only">Skip to next slide page</span>
                    </button>
                </div>
            </div>
        </div>
        <!-- Register section -->
        <div class="px-6 py-24 sm:px-6 sm:py-32 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Mari lakukan registrasi akun
                </h2>
                <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-gray-600">Untuk anggota dan non-anggota untuk
                    melakukan proses pengajuan surat rekomendasi pada PDGI Cabang Kota Bogor.</p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href={{ route('register') }}
                        class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Registrasi
                        Akun</a>
                </div>
            </div>
        </div>

    </x-slot>
</x-home-layout>
