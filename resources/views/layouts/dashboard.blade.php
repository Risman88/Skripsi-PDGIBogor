<!DOCTYPE html>
<html class="h-full bg-gray-100" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="/favicon.ico">
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full">
    <div class="bg-gray-100">
        <div class="min-h-screen">
            <nav x-data="{ open: false }" class="bg-purple-600">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 items-center justify-between">
                        <div class="flex items-center">
                            <a href="{{ route('home') }}">
                                <div class="flex-shrink-0">
                                    <x-dashboard-logo class="h-8 w-8" />
                                </div>
                            </a>
                            <div class="hidden md:block">
                                <div class="ml-10 flex items-baseline space-x-4">

                                    <x-dashboard-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                        {{ __('Dashboard') }}
                                    </x-dashboard-nav-link>

                                    <x-dropdown dropdownTitle="Pengajuan">
                                                @can('submission nonanggota')
                                                    <x-dashboard-dropdown-nav-link :href="route('submission.create', ['type_id' => 1])" :active="request()->routeIs('submission.create') &&
                                                        request()->route('type_id') == 1">
                                                        {{ __('Pengajuan Anggota') }}
                                                    </x-dashboard-dropdown-nav-link>
                                                    <x-dashboard-dropdown-nav-link :href="route('submission.create', ['type_id' => 2])" :active="request()->routeIs('submission.create') &&
                                                        request()->route('type_id') == 2">
                                                        {{ __('Pengajuan SRIP Non-Anggota') }}
                                                    </x-dashboard-dropdown-nav-link>
                                                @endcan
                                                @can('submission anggota')
                                                    <x-dashboard-dropdown-nav-link :href="route('submission.create', ['type_id' => 4])" :active="request()->routeIs('submission.create') &&
                                                        request()->route('type_id') == 4">
                                                        {{ __('Pengajuan SRIP Dokter Gigi Spesialis') }}
                                                    </x-dashboard-dropdown-nav-link>
                                                    <x-dashboard-dropdown-nav-link :href="route('submission.create', ['type_id' => 3])" :active="request()->routeIs('submission.create') &&
                                                        request()->route('type_id') == 3">
                                                        {{ __('Pengajuan SRIP Dokter Gigi') }}
                                                    </x-dashboard-dropdown-nav-link>
                                                    <x-dashboard-dropdown-nav-link :href="route('submission.create', ['type_id' => 6])" :active="request()->routeIs('submission.create') &&
                                                        request()->route('type_id') == 6">
                                                        {{ __('Pengajuan SPIP Dokter Gigi Spesialis') }}
                                                    </x-dashboard-dropdown-nav-link>
                                                    <x-dashboard-dropdown-nav-link :href="route('submission.create', ['type_id' => 5])" :active="request()->routeIs('submission.create') &&
                                                        request()->route('type_id') == 5">
                                                        {{ __('Pengajuan SPIP Dokter Gigi') }}
                                                    </x-dashboard-dropdown-nav-link>
                                                    <x-dashboard-dropdown-nav-link :href="route('submission.create', ['type_id' => 7])" :active="request()->routeIs('submission.create') &&
                                                        request()->route('type_id') == 7">
                                                        {{ __('Pengajuan Surat Rekomendasi Mutasi') }}
                                                    </x-dashboard-dropdown-nav-link>
                                                    <x-dashboard-dropdown-nav-link :href="route('submission.create', ['type_id' => 8])" :active="request()->routeIs('submission.create') &&
                                                        request()->route('type_id') == 8">
                                                        {{ __('Pengajuan Surat Rekomendasi PPDGS') }}
                                                    </x-dashboard-dropdown-nav-link>
                                                @endcan
                                                <x-dashboard-dropdown-nav-link :href="route('submission.index')" :active="request()->routeIs('submission.index')">
                                                    {{ __('Histori Pengajuan') }}
                                                </x-dashboard-dropdown-nav-link>
                                    </x-dropdown>


                                    <x-dashboard-nav-link :href="route('payments.index')" :active="request()->routeIs('payments.index')">
                                        {{ __('Pembayaran') }}
                                    </x-dashboard-nav-link>
                                    <x-dashboard-nav-link :href="route('zoom_meetings.index')" :active="request()->routeIs('zoom_meetings.index')">
                                        {{ __('Wawancara') }}
                                    </x-dashboard-nav-link>

                                    @can('view menu')
                                    <x-dropdown dropdownTitle="Pengelolaan">
                                                    @can('view meeting')
                                                        <x-dashboard-dropdown-nav-link :href="route('zoom_meetings.indexall')" :active="request()->routeIs('zoom_meetings.indexall')">
                                                            {{ __('Data Wawancara') }}
                                                        </x-dashboard-dropdown-nav-link>
                                                    @endcan
                                                    @can('view user')
                                                        <x-dashboard-dropdown-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                                                            {{ __('Data Pengguna') }}
                                                        </x-dashboard-dropdown-nav-link>
                                                    @endcan
                                                    @can('view pembayaran')
                                                        <x-dashboard-dropdown-nav-link :href="route('payments.indexall')" :active="request()->routeIs('payments.indexall')">
                                                            {{ __('Data Pembayaran') }}
                                                        </x-dashboard-dropdown-nav-link>
                                                    @endcan
                                                    @can('edit pembayaran')
                                                        <x-dashboard-dropdown-nav-link :href="route('payments.indexall')" :active="request()->routeIs('payments.indexall')">
                                                            {{ __('Data Pembayaran') }}
                                                        </x-dashboard-dropdown-nav-link>
                                                    @endcan
                                                    @can('view pengajuan')
                                                        <x-dashboard-dropdown-nav-link :href="route('submission.indexall')" :active="request()->routeIs('submission.indexall')">
                                                            {{ __('Data Pengajuan') }}
                                                        </x-dashboard-dropdown-nav-link>
                                                    @endcan
                                                    @can('edit susunan')
                                                    <x-dashboard-dropdown-nav-link :href="route('panduan.index')" :active="request()->routeIs('panduan.index')">
                                                        {{ __('Data Panduan') }}
                                                    </x-dashboard-dropdown-nav-link>
                                                    <x-dashboard-dropdown-nav-link :href="route('slideshow.index')" :active="request()->routeIs('slideshow.index')">
                                                        {{ __('Data Banner') }}
                                                    </x-dashboard-dropdown-nav-link>
                                                    <x-dashboard-dropdown-nav-link :href="route('gallery.index')" :active="request()->routeIs('gallery.index')">
                                                        {{ __('Data Galeri') }}
                                                    </x-dashboard-dropdown-nav-link>
                                                    <x-dashboard-dropdown-nav-link :href="route('organisasi.index')" :active="request()->routeIs('organisasi.index')">
                                                        {{ __('Susunan Organisasi') }}
                                                    </x-dashboard-dropdown-nav-link>
                                                    @endcan
                                    </x-dropdown>
                                    @endcan
                                </div>
                            </div>
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-4 flex items-center md:ml-6">
                                <!-- Profile dropdown -->
                                <x-dropdown dropdownTitle="{{ Auth::user()->name }}">
                                        <x-dashboard-dropdown-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                                            {{ __('Profile') }}
                                        </x-dashboard-dropdown-nav-link>

                                        <!-- Authentication -->
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf

                                            <x-dashboard-dropdown-nav-link :href="route('logout')"
                                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                                {{ __('Log Out') }}
                                            </x-dashboard-dropdown-nav-link>
                                        </form>
                                </x-dropdown>
                            </div>
                        </div>
                        <div class="-mr-2 flex md:hidden">
                            <!-- Mobile menu button -->
                            <button type="button"
                                class="inline-flex items-center justify-center rounded-md bg-purple-600 p-2 text-purple-200 hover:bg-purple-500 hover:bg-opacity-75 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-purple-600"
                                aria-controls="mobile-menu" @click="open = !open" aria-expanded="false">
                                <span class="sr-only">Open main menu</span>
                                <svg x-state:on="Menu open" x-state:off="Menu closed" class="block h-6 w-6"
                                    :class="{ 'hidden': open, 'block': !(open) }"
                                    x-description="Heroicon name: outline/bars-3" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                                </svg>
                                <svg x-state:on="Menu open" x-state:off="Menu closed" class="hidden h-6 w-6"
                                    :class="{ 'block': open, 'hidden': !(open) }"
                                    x-description="Heroicon name: outline/x-mark" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12">
                                    </path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div x-description="Mobile menu, show/hide based on menu state." class="md:hidden" id="mobile-menu"
                    x-show="open">
                    <div class="space-y-1 px-2 pt-2 pb-3 sm:px-3">

                        <x-responsive-dashboard-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-responsive-dashboard-nav-link>
                        <!-- Dropdown section for Pengajuan -->
                        <x-responsive-dropdown title="Pengajuan">
                            <div x-show="openDropdown" @click.away="openDropdown = false">
                                @can('submission nonanggota')
                                    <x-responsive-dashboard-nav-link :href="route('submission.create', ['type_id' => 1])" :active="request()->routeIs('submission.create') &&
                                        request()->route('type_id') == 1" class="ml-3">
                                        {{ __('Pengajuan Anggota') }}
                                    </x-responsive-dashboard-nav-link>
                                    <x-responsive-dashboard-nav-link :href="route('submission.create', ['type_id' => 2])" :active="request()->routeIs('submission.create') &&
                                        request()->route('type_id') == 2" class="ml-3">
                                        {{ __('Pengajuan SRIP Non-Anggota') }}
                                    </x-responsive-dashboard-nav-link>
                                @endcan
                                @can('submission anggota')
                                    <x-responsive-dashboard-nav-link :href="route('submission.create', ['type_id' => 4])" :active="request()->routeIs('submission.create') &&
                                        request()->route('type_id') == 4" class="ml-3">
                                        {{ __('Pengajuan SRIP Dokter Gigi Spesialis') }}
                                    </x-responsive-dashboard-nav-link>
                                    <x-responsive-dashboard-nav-link :href="route('submission.create', ['type_id' => 3])" :active="request()->routeIs('submission.create') &&
                                        request()->route('type_id') == 3" class="ml-3">
                                        {{ __('Pengajuan SRIP Dokter Gigi') }}
                                    </x-responsive-dashboard-nav-link>
                                    <x-responsive-dashboard-nav-link :href="route('submission.create', ['type_id' => 6])" :active="request()->routeIs('submission.create') &&
                                        request()->route('type_id') == 6" class="ml-3">
                                        {{ __('Pengajuan SPIP Dokter Gigi Spesialis') }}
                                    </x-responsive-dashboard-nav-link>
                                    <x-responsive-dashboard-nav-link :href="route('submission.create', ['type_id' => 5])" :active="request()->routeIs('submission.create') &&
                                        request()->route('type_id') == 5" class="ml-3">
                                        {{ __('Pengajuan SPIP Dokter Gigi') }}
                                    </x-responsive-dashboard-nav-link>
                                    <x-responsive-dashboard-nav-link :href="route('submission.create', ['type_id' => 7])" :active="request()->routeIs('submission.create') &&
                                        request()->route('type_id') == 7" class="ml-3">
                                        {{ __('Pengajuan Surat Rekomendasi Mutasi') }}
                                    </x-responsive-dashboard-nav-link>
                                    <x-responsive-dashboard-nav-link :href="route('submission.create', ['type_id' => 8])" :active="request()->routeIs('submission.create') &&
                                        request()->route('type_id') == 8" class="ml-3">
                                        {{ __('Pengajuan Surat Rekomendasi PPDGS') }}
                                    </x-responsive-dashboard-nav-link>
                                @endcan
                                <x-responsive-dashboard-nav-link :href="route('submission.index')" :active="request()->routeIs('submission.index')" class="ml-3">
                                    {{ __('Riwayat Pengajuan') }}
                                </x-responsive-dashboard-nav-link>
                        </x-responsive-dropdown>
                        <x-responsive-dashboard-nav-link :href="route('payments.index')" :active="request()->routeIs('payments.index')">
                            {{ __('Pembayaran') }}
                        </x-responsive-dashboard-nav-link>
                        <x-responsive-dashboard-nav-link :href="route('zoom_meetings.index')" :active="request()->routeIs('zoom_meetings.index')">
                            {{ __('Wawancara') }}
                        </x-responsive-dashboard-nav-link>
                        <!-- Dropdown section for Pengelolaan -->
                        @can('view menu')
                            <x-responsive-dropdown title="Pengelolaan">
                                    @can('view meeting')
                                        <x-responsive-dashboard-nav-link :href="route('zoom_meetings.indexall')" :active="request()->routeIs('zoom_meetings.indexall')" class="ml-3">
                                            {{ __('Data Wawancara') }}
                                        </x-responsive-dashboard-nav-link>
                                    @endcan
                                    @can('view user')
                                        <x-responsive-dashboard-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')" class="ml-3">
                                            {{ __('Data Pengguna') }}
                                        </x-responsive-dashboard-nav-link>
                                    @endcan
                                    @can('view pembayaran')
                                        <x-responsive-dashboard-nav-link :href="route('payments.indexall')" :active="request()->routeIs('payments.indexall')" class="ml-3">
                                            {{ __('Data Pembayaran') }}
                                        </x-responsive-dashboard-nav-link>
                                    @endcan
                                    @can('edit pembayaran')
                                        <x-responsive-dashboard-nav-link :href="route('payments.indexall')" :active="request()->routeIs('payments.indexall')" class="ml-3">
                                            {{ __('Data Pembayaran') }}
                                        </x-responsive-dashboard-nav-link>
                                    @endcan
                                    @can('view pengajuan')
                                        <x-responsive-dashboard-nav-link :href="route('submission.indexall')" :active="request()->routeIs('submission.indexall')" class="ml-3">
                                            {{ __('Data Pengajuan') }}
                                        </x-responsive-dashboard-nav-link>
                                    @endcan
                                    @can('edit susunan')
                                    <x-responsive-dashboard-nav-link :href="route('panduan.index')" :active="request()->routeIs('panduan.index')" class="ml-3">
                                        {{ __('Data Panduan') }}
                                    </x-responsive-dashboard-nav-link>
                                    <x-responsive-dashboard-nav-link :href="route('slideshow.index')" :active="request()->routeIs('slideshow.index')" class="ml-3">
                                        {{ __('Data Banner') }}
                                    </x-responsive-dashboard-nav-link>
                                    <x-responsive-dashboard-nav-link :href="route('gallery.index')" :active="request()->routeIs('gallery.index')" class="ml-3">
                                        {{ __('Data Galeri') }}
                                    </x-responsive-dashboard-nav-link>
                                    <x-responsive-dashboard-nav-link :href="route('organisasi.index')" :active="request()->routeIs('organisasi.index')" class="ml-3">
                                        {{ __('Susunan Organisasi') }}
                                    </x-responsive-dashboard-nav-link>
                                    @endcan
                            </x-responsive-dropdown>
                        @endcan
                        <div class="border-t border-purple-700 pt-4 pb-3">
                            <div class="flex items-center px-5">
                                <div class="ml-1">
                                    <div class="text-base font-medium text-white">{{ Auth::user()->name }}
                                    </div>
                                    <div div class="text-base font-medium text-white">{{ Auth::user()->email }}
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3 space-y-1 px-2">

                                <x-responsive-dashboard-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                                    {{ __('Profile') }}
                                </x-responsive-dashboard-nav-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}"
                                        class="block rounded-md px-3 py-2 text-base font-medium text-white hover:bg-purple-500 hover:bg-opacity-75"
                                        onclick="event.preventDefault(); this.closest('form').submit();">Log out</a>
                                </form>
                            </div>
                        </div>
                    </div>
            </nav>

            @if (isset($header))
                <header class="bg-white shadow-sm">
                    <div class="mx-auto max-w-7xl py-4 px-4 sm:px-6 lg:px-8">
                        <h1 class="text-lg font-semibold leading-6 text-gray-900">{{ $header }}</h1>
                    </div>
                </header>
            @endif
            <main>
                <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
                    <div class="px-4 py-4 sm:px-0">
                        <div class="container">
                            @if (session('success'))
                                <x-alert-success title="Success">
                                    {{ session('success') }}
                                </x-alert-success>
                            @endif
                            @if (session('warning'))
                                <x-alert-warning title="Warning">
                                    {!! session('warning') !!}
                                </x-alert-warning>
                            @endif
                            @if (session('error'))
                                <x-alert-danger title="Error">
                                    {{ session('error') }}
                                </x-alert-danger>
                            @endif
                            @if (session('info'))
                                <x-alert-info type="info" title="Info">
                                    {{ session('info') }}
                                </x-alert-info>
                            @endif
                        </div>
                        {{ $slot }}
                    </div>
                </div>
            </main>
        </div>
    </div>
    <footer class="bg-purple-700 py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-center">
            <p class="text-white">Copyrights © 2023 PDGI Kota Bogor</p>
        </div>
    </footer>
</body>


</html>
