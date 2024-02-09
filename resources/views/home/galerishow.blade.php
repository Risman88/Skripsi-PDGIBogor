<x-home-layout>
    <x-slot name="slot">
        <div class="mx-auto max-w-7xl px-6 pb-32 pt-36 sm:pt-60 lg:px-8 lg:pt-32">
            <div class="mx-auto max-w-2xl gap-x-14 lg:mx-0 lg:flex lg:max-w-none lg:items-center">
                <div class="w-full max-w-xl lg:shrink-0 xl:max-w-2xl">
                    <h2 class="text-2xl font-bold leading-10 tracking-tight text-gray-900">Galeri {{ $gallery->title }}</h2>
                </div>
            </div>
            <div class="mt-8">
            <div class="grid grid-cols-1 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
                @foreach ($images as $image)
                    <div class="bg-white p-4 shadow-md rounded-md">
                        <a href="{{ route('show.galleries', $image->id) }}" target="_blank">
                        <img src="{{ route('show.galleries', $image->id) }}"
                        alt="{{ $gallery->title }}" class="w-full h-full object-cover mb-2">
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
        <div class="mt-4">
        {{ $images->links() }}
        </div>
        </div>
    </x-slot>
</x-home-layout>
