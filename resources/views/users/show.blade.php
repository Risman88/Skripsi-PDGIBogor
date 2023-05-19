<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profil Pengguna') }}
        </h2>
    </x-slot>

<a href="{{ route('users.index') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
  </svg> Kembali ke daftar pengguna </a>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-gray-200 dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('users.partials.show-profile-information')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-gray-200 dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('users.partials.show-profile-document')
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
