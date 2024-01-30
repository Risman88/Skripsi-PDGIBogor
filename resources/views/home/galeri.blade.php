<x-home-layout>
    <x-slot name="slot">
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
                        <h2 class="text-2xl font-bold leading-10 tracking-tight text-gray-900">Galeri PDGI Kota Bogor
                        </h2>
                    </div>
                </div>
                <div class="mt-4">
                    <div
                        class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                        @foreach ($galleries as $gallery)
                            <div class="bg-white p-4 shadow-md rounded-md">
                                @if ($gallery->thumbnail()->exists())
                                    <a href="{{ route('galeri.show', $gallery) }}">
                                        <img src="{{ route('show.galleries', $gallery->thumbnail->first()->id) }}"
                                            alt="{{ $gallery->title }}" class="w-64 h-64 object-cover mb-2">
                                    </a>
                                @endif
                                <h3 class="text-lg font-semibold">{{ $gallery->title }}</h3>
                                <p class="text-gray-600">{{ $gallery->description }}</p>
                            </div>
                        @endforeach
                    </div>
                    {{ $galleries->links() }}
                </div>
            </div>
        </div>
    </x-slot>
</x-home-layout>
