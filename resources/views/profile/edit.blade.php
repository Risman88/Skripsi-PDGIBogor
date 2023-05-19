<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-4" x-data="{ tab: 'profile' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Tab buttons -->
            <div class="flex border-b mb-4">
                <button :class="{ 'border-b-2 border-blue-500 text-blue-600': tab === 'profile' }" class="px-4 py-2 focus:outline-none border-r border-gray-300" @click="tab = 'profile'">Profile</button>
                <button :class="{ 'border-b-2 border-blue-500 text-blue-600': tab === 'document' }" class="px-4 py-2 focus:outline-none border-r border-gray-300" @click="tab = 'document'">Document</button>
                <button :class="{ 'border-b-2 border-blue-500 text-blue-600': tab === 'email' }" class="px-4 py-2 focus:outline-none border-r border-gray-300" @click="tab = 'email'">Email</button>
                <button :class="{ 'border-b-2 border-blue-500 text-blue-600': tab === 'password' }" class="px-4 py-2 focus:outline-none" @click="tab = 'password'">Password</button>
            </div>

            <!-- Tab content -->
            <div class="p-4 sm:p-8 bg-gray-200 dark:bg-gray-800 shadow sm:rounded-lg" x-show="tab === 'profile'">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-gray-200 dark:bg-gray-800 shadow sm:rounded-lg" x-show="tab === 'document'">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-document')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-gray-200 dark:bg-gray-800 shadow sm:rounded-lg" x-show="tab === 'email'">
                <div class="max-w-xl">
                    @include('profile.partials.update-email-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-gray-200 dark:bg-gray-800 shadow sm:rounded-lg" x-show="tab === 'password'">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- <div class="p-4 sm:p-8 bg-gray-200 dark:bg-gray-800 shadow sm:rounded-lg" x-show="tab === 'delete'">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div> --}}

        </div>
    </div>
</x-dashboard-layout>
