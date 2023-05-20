<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Profile Pengguna') }}
        </h2>
    </x-slot>

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
