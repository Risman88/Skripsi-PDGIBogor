<section>
    @vite([ 'resources/js/tinyMCE.js' ])
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Edit Data Panduan') }}
        </h2>
    </header>

    <form action="{{ route('panduan.update', $panduan->id) }}" method="POST" class="mt-6 space-y-6">
        @csrf
        @method('PUT')
        <div class="mt-6 space-y-6">
            <div>
                <div class="mt-6 space-y-6">
                    <div>
                        <x-input-label for="judul" :value="__('Judul')" />
                        <x-text-input id="judul" name="judul" type="text" class="mt-1 block w-full" :value="old('judul', $panduan->judul)"/>
                        <x-input-error class="mt-2" :messages="$errors->get('judul')" />
                    </div>
                    <div>
                        <x-input-label for="isi" :value="__('Isi')" />
                        <textarea id="isi" name="isi" type="text" class="mt-1 block w-full">{{ old('isi', $panduan->isi) }} </textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('isi')" />
                    </div>
                <x-primary-button class="mt-2">
                    {{ __('Perbarui') }}
                </x-primary-button>
    </form>
</section>
