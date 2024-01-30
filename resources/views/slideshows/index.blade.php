<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Banner Halaman Utama') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="flex justify-between items-center mb-4">
            <p>Maksimal penggunaan banner adalah 5 banner.<br>Silahkan edit banner yang ingin diganti.</p>
        </div>
            <div class="py-4">
        @include('slideshows.partials.table')
    </div>
    </div>
</x-dashboard-layout>
