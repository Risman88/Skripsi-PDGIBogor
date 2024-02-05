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
                        <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Misi Kami</h1>
                        <p class="relative mt-6 text-lg leading-8 text-gray-600 sm:max-w-md lg:max-w-none">Cupidatat
                            minim id magna ipsum sint dolor qui. Sunt sit in quis cupidatat mollit aute velit. Et labore
                            commodo nulla aliqua proident mollit ullamco exercitation tempor. Sint aliqua anim nulla
                            sunt mollit id pariatur in voluptate cillum. Eu voluptate tempor esse minim amet fugiat
                            veniam occaecat aliqua.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Values section -->
        <div class="mx-auto mt-32 max-w-7xl px-6 sm:mt-40 lg:px-8">
            <div class="mx-auto max-w-2xl lg:mx-0">
                <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Visi Kami</h1>
            </div>
            <dl
                class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 text-base leading-7 sm:grid-cols-2 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                <div>
                    <dt class="font-semibold text-gray-900">Be world-class</dt>
                    <dd class="mt-1 text-gray-600"></dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-900">Share everything you know</dt>
                    <dd class="mt-1 text-gray-600"></dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-900">Always learning</dt>
                    <dd class="mt-1 text-gray-600"></dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-900">Be supportive</dt>
                    <dd class="mt-1 text-gray-600"></dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-900">Take responsibility</dt>
                    <dd class="mt-1 text-gray-600"></dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-900">Enjoy downtime</dt>
                    <dd class="mt-1 text-gray-600"></dd>
                </div>

            </dl>
        </div>
        <!-- People section -->
        <div class="py-24 sm:py-32">
            <div class="mx-auto grid max-w-7xl gap-x-8 gap-y-20 px-6 lg:px-8 xl:grid-cols-3">
                <div class="max-w-2xl">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Susunan Organisasi</h1>
                </div>
                <ul role="list" class="grid gap-x-8 gap-y-12 sm:grid-cols-3 sm:gap-y-16 xl:col-span-3">
                    @foreach ($organisasi as $anggota)
                        <li>
                            <div class="flex items-center gap-x-6">
                                <img src="{{ route('organisasi.photo', $anggota->id) }}" alt="Photo_URL"
                                    class="w-64 h-64 border border-gray-300 rounded" loading="lazy">
                                <div>
                                    <h3 class="text-base font-semibold leading-7 tracking-tight text-gray-900">
                                        {{ $anggota->nama }}</h3>
                                    <p class="text-sm font-semibold leading-6 text-indigo-600">{{ $anggota->jabatan }}
                                    </p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </x-slot>
</x-home-layout>
