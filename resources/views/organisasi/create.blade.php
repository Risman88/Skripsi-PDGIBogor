<x-dashboard-layout>
    <x-slot name="header">
        {{ __('Penambahan Susunan Organisasi') }}
    </x-slot>
    <div class="w-full max-w-md mx-auto">
        <div class="bg-indigo-300 p-2 text-black text-2xl font-bold text-center mb-4 rounded">
            <span>Susunan Organisasi</span>
        </div>
        <form action="{{ route('organisasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div>
                <x-input-label for="nama" :value="__('Nama')" :required=true />
                <x-text-input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                    class="w-full px-4 py-2 border" required />
            </div>
            <div>
                <x-input-label for="jabatan" :value="__('Jabatan')" :required=true />
                <textarea name="jabatan" id="jabatan" class="w-full px-4 py-2 border border-gray-300 rounded">{{ old('jabatan') }}</textarea>
            </div>
            <div>
                <x-input-label for="photo_url" :value="__('Foto')"  :required=true />
                <input type="file" name="photo_url" class="w-full px-4 py-2 border border-gray-300 rounded">
                <span class= "text-gray-500 text-sm px-1 inline-block">(maksimal ukuran file: 1024 KB, format file: png, jpg, atau jpeg)</span>
                <x-input-error :messages="$errors->get('photo_url')" class="mt-2" />
            </div>
            <button type="submit" class="w-full py-2 bg-gray-800 text-white font-bold rounded mt-4">
                Tambah Data Organisasi Baru
            </button>
        </form>
</x-dashboard-layout>
