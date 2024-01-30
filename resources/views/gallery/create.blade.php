<x-dashboard-layout>
    <x-slot name="header">
        {{ __('Penambahan Data Galeri') }}
    </x-slot>
    <div class="w-full max-w-md mx-auto">
        <div class="bg-indigo-300 p-2 text-black text-2xl font-bold text-center mb-4 rounded">
            <span>Data Galeri</span>
        </div>
        <form action="{{ route('gallery.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div>
                <x-input-label for="title" :value="__('Judul')" :required=true />
                <x-text-input type="text" name="title" id="title" value="{{ old('title') }}"
                    class="w-full px-4 py-2 border" required />
            </div>

            <div>
                <x-input-label for="description" :value="__('Deskripsi')" />
                <x-text-input type="text" name="description" id="description" value="{{ old('description') }}"
                    class="w-full px-4 py-2 border" />
            </div>

            <div class="mb-4">
                <label for="images" class="block text-sm font-semibold text-gray-600">Images</label>
                <input type="file" id="images" name="images[]" class="form-input mt-1 block w-full" multiple accept="image/*" required>
            </div>
            <button type="submit" class="w-full py-2 bg-gray-800 text-white font-bold rounded mt-4">
                Tambah Data Galeri Baru
            </button>
        </form>
</x-dashboard-layout>
