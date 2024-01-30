<section>

    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Edit Data Susunan Organisasi') }}
        </h2>
    </header>

    <form action="{{ route('organisasi.update', $organisasi->id) }}" method="POST" enctype="multipart/form-data"
        class="mt-6 space-y-6">
        @csrf
        @method('PUT')
        <div class="mt-6 space-y-6">
            <div>
                <x-input-label for="posisi" :value="__('Posisi')" />
                <x-text-input id="posisi" name="posisi" type="text" class="mt-1 block w-full" :value="old('posisi', $organisasi->posisi)"
                    required autocomplete="posisi" />
                <x-input-error class="mt-2" :messages="$errors->get('posisi')" />
            </div>
            <div>
                <x-input-label for="nama" :value="__('Nama')" />
                <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" :value="old('nama', $organisasi->nama)"
                    required autocomplete="nama" />
                <x-input-error class="mt-2" :messages="$errors->get('nama')" />
            </div>
            <div>
                <x-input-label for="jabatan" :value="__('Jabatan')" />
                <x-text-input id="jabatan" name="jabatan" type="text" class="mt-1 block w-full" :value="old('jabatan', $organisasi->jabatan)"
                    required autocomplete="jabatan" />
                <x-input-error class="mt-2" :messages="$errors->get('jabatan')" />
            </div>
            <div>
                <x-input-label for="photo_url" :value="__('Foto')" />
                <a href="{{ route('organisasi.photo', $organisasi->id) }}" target="_blank">
                    <img src="{{ route('organisasi.photo', $organisasi->id) }}" alt="Photo_URL"
                        class="w-16 h-16 border-gray-300 rounded">
                </a>
            </div>
            <input type="file" name="photo_url" id="photo_url"
                class="form-input rounded-md shadow-sm mt-1 block w-full border border-gray-300">
        </div>
        <x-primary-button class="mt-2">
            {{ __('Perbarui') }}
        </x-primary-button>
    </form>
</section>
