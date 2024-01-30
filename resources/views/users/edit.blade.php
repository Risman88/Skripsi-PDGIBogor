<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Profile Pengguna') }}
        </h2>
    </x-slot>
    <a href="{{ route('users.index') }}" class="text-blue-600 hover:text-blue-800"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
      </svg> Kembali ke daftar pengguna </a>
    <div class="py-4" x-data="{ tab: 'profile' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Tab buttons -->
            <div class="flex border-b mb-4">
                <button :class="{ 'border-b-2 border-blue-500 text-blue-600': tab === 'profile' }" class="px-4 py-2 focus:outline-none border-r border-gray-300" @click="tab = 'profile'">Profile</button>
                <button :class="{ 'border-b-2 border-blue-500 text-blue-600': tab === 'document' }" class="px-4 py-2 focus:outline-none border-r border-gray-300" @click="tab = 'document'">Document</button>
            </div>
            <div class="p-4 sm:p-8 bg-gray-200 shadow sm:rounded-lg" x-show="tab === 'profile'">
                <div class="max-w-xl">
                    @include('users.partials.update-profile-information')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-gray-200 shadow sm:rounded-lg" x-show="tab === 'document'">
                <div class="max-w-xl">
                    @include('users.partials.update-profile-document')
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
