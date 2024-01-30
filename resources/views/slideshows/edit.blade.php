<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Susunan Organisasi') }}
        </h2>
    </x-slot>
    <a href="{{ route('slideshow.index') }}" class="text-blue-600 hover:text-blue-800"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
      </svg> Kembali ke data banner </a>
            <div class="p-4 sm:p-8 bg-gray-200 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('slideshows.partials.editdata')
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
