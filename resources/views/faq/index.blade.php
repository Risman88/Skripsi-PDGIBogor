<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Susunan Panduan') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="flex justify-between items-center mb-4">
            <form action="{{ route('panduan.index') }}" method="GET">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama..." class="rounded-md px-3 py-2">
                <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded">Cari</button>
            </form>
            <div class="flex items-center space-x-2">
                <!-- Tombol Buat Data -->
                <a href="{{ route('panduan.create') }}" class="px-2 py-1 bg-blue-500 text-white rounded">
                    Buat Panduan Baru
                </a>
            </div>
        </div>
            <div class="py-4">
        @include('faq.partials.table', ['panduan' => $panduans])
    </div>
    </div>
</x-dashboard-layout>
