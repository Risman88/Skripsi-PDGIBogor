<x-dashboard-layout>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/tinymce.js'])
    <x-slot name="header">
        {{ __('Penambahan Data Panduan') }}
    </x-slot>
    <div class="w-full max-w-md mx-auto">
        <div class="bg-indigo-300 p-2 text-black text-2xl font-bold text-center mb-4 rounded">
            <span>Data Panduan</span>
        </div>
        <form action="{{ route('panduan.store') }}" method="POST" >
            @csrf
            <div>
                <x-input-label for="judul" :value="__('Judul')" :required=true />
                <x-text-input type="text" name="judul" id="judul" value="{{ old('judul') }}"
                    class="w-full px-4 py-2 border" required />
            </div>
            <div>
                <x-input-label for="isi" :value="__('Isi')" :required=true />
                <textarea name="isi" id="isi" class="w-full px-4 py-2 border border-gray-300 rounded">{{ old('isi') }}</textarea>
            </div>
            <button type="submit" class="w-full py-2 bg-gray-800 text-white font-bold rounded mt-4">
                Tambah Data Panduan Baru
            </button>
        </form>
</x-dashboard-layout>
