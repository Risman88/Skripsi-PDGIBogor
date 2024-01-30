<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Galeri') }}
        </h2>
    </x-slot>
    <style>
        /* Ganti warna checkbox yang dicentang menjadi merah */
        input[type="checkbox"]:checked {
            filter: hue-rotate(90deg);
        }
    </style>
    <a href="{{ route('gallery.index') }}" class="text-blue-600 hover:text-blue-800"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
      </svg> Kembali ke daftar galeri </a>
      <div class="container mx-auto my-8">
        <h2 class="text-2xl font-bold mb-4">Edit Gallery - {{ $gallery->title }}</h2>

        <form action="{{ route('gallery.update', $gallery->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="title" class="block text-sm font-semibold text-gray-600">Judul</label>
                <input type="text" id="title" name="title" class="form-input mt-1 block w-full" value="{{ old('title', $gallery->title) }}" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-semibold text-gray-600">Deskripsi</label>
                <textarea id="description" name="description" class="form-textarea mt-1 block w-full">{{ old('description', $gallery->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="images" class="block text-sm font-semibold text-gray-600">Tambah Gambar</label>
                <input type="file" id="images" name="images[]" class="form-input mt-1 block w-full" multiple accept="image/*">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-600">Gambar sekarang</label>
                <div class="flex flex-wrap gap-4">
                    @foreach ($gallery->images as $image)
                    <div>
                        <img src="{{ route('show.galleries', $image->id) }}" alt="{{ $gallery->title }}" class="w-32 h-32 object-cover">
                        <input type="checkbox" name="remove_images[]" value="{{ $image->id }}"> Hapus
                        <input type="radio" name="thumbnail_id" value="{{ $image->id }}" {{ $image->is_thumbnail ? 'checked' : '' }}> Thumbnail
                    </div>
                @endforeach
                </div>
            </div>
            <button type="submit"
                class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Update') }}
            </button>
        </form>
    </div>
</x-dashboard-layout>
