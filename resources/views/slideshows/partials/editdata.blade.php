<section>

    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Edit Data Susunan Organisasi') }}
        </h2>
    </header>

    <form action="{{ route('slideshow.update', $slideshow->id) }}" method="POST" enctype="multipart/form-data"
        class="mt-6 space-y-6">
        @csrf
        @method('PUT')
        <div class="mt-6 space-y-6">
            <div>
                <x-input-label for="caption" :value="__('Nama')" />
                <x-text-input id="caption" name="caption" type="text" class="mt-1 block w-full" :value="old('caption', $slideshow->caption)"
                    required autocomplete="caption" />
                <x-input-error class="mt-2" :messages="$errors->get('caption')" />
            </div>
            <div>
                <x-input-label for="image_url" :value="__('Gambar')" />
                <a href="{{ route('slideshow.banner', $slideshow->id) }}" target="_blank">
                    <img src="{{ route('slideshow.banner', $slideshow->id) }}" alt="image_url"
                        class="w-16 h-16 border-gray-300 rounded">
                </a>
            </div>
            <input type="file" name="image_url" id="image_url"
                class="form-input rounded-md shadow-sm mt-1 block w-full border border-gray-300">
                <span class= "text-gray-500 text-sm px-1 inline-block">(maksimal ukuran file: 1024 KB, format file: png, jpg, atau jpeg)</span>
        </div>
        <x-primary-button class="mt-2">
            {{ __('Perbarui') }}
        </x-primary-button>
    </form>
</section>
