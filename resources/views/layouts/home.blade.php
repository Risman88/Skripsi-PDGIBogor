<!DOCTYPE html>
<html class="h-full" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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
<body class="flex flex-col h-screen">
<div>
    <!-- Header -->
    <header style="background-color:rgb(139, 49, 180);" x-data="{ open: false }" @keydown.window.escape="open = false" class="absolute inset-x-0 top-0 z-50">
      <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
          <a href="#" class="-m-1.5 p-1.5">
            <span class="sr-only">PDGI Cabang Kota Bogor</span>
            <x-dashboard-logo class="h-8 w-8" />
          </a>
        </div>
        <div class="flex lg:hidden">
          <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700" @click="open = true">
            <span class="sr-only">Buka Menu</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
</svg>
          </button>
        </div>
        <div class="hidden lg:flex lg:gap-x-12">
          <a href={{ route('home') }} class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-200">Beranda</a>
          <a href={{ route('tentangkami') }} class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-200">Tentang Kami</a>
          <a href={{ route('galeri') }} class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-200">Galeri</a>
          <a href={{ route('faq') }} class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-200">Panduan</a>
          <a href={{ route('kontak') }} class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-200">Kontak</a>
        </div>
        <div class="hidden lg:flex lg:flex-1 lg:justify-end">
          <a href={{ route('login') }} class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-200">Masuk Aplikasi<span aria-hidden="true">→</span></a>
        </div>
      </nav>
      <div x-description="Mobile menu, show/hide based on menu open state." class="lg:hidden" x-ref="dialog" x-show="open" aria-modal="true">
        <div x-description="Background backdrop, show/hide based on slide-over state." class="fixed inset-0 z-50"></div>
        <div class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10" @click.away="open = false">
          <div class="flex items-center justify-between">
            <a href="#" class="-m-1.5 p-1.5">
              <span class="sr-only">PDGI Cabang Kota Bogor</span>
              <x-dashboard-logo class="h-8 w-8" />
            </a>
            <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700" @click="open = false">
              <span class="sr-only">Tutup menu</span>
              <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
</svg>
            </button>
          </div>
          <div class="mt-6 flow-root">
            <div class="-my-6 divide-y divide-gray-500/10">
              <div class="space-y-2 py-6">
                <a href={{ route('home') }} class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-100">Beranda</a>
                <a href={{ route('tentangkami') }} class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-100">Tentang Kami</a>
                <a href={{ route('galeri') }} class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-100">Galeri</a>
                <a href={{ route('faq') }} class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-100">Panduan</a>
                <a href={{ route('kontak') }} class="-mx-3 block rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-100">Hubungi Kami</a>

              </div>
              <div class="py-6">
                <a href={{ route('login') }} class="-mx-3 block rounded-lg px-3 py-2.5 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-100">Masuk Aplikasi</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>

    <main class="flex-grow">
      <div class="mb-10">
        {{ $slot }}
      </div>
    </main>


  </div>
      <!-- Footer -->
      <footer class="bg-gray-800 mt-auto">
        <div class="mx-auto max-w-7xl px-6 py-12 md:flex md:items-center md:justify-between lg:px-8">
          <div class="flex justify-center space-x-6 md:order-2">
            <a href="https://www.instagram.com/pdgikotabogor/" class="text-gray-400 hover:text-gray-500" target="_blank" style="position: relative; z-index: 1;">
                <span class="sr-only">Instagram</span>
                <svg class="h-10 w-10" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
              </svg>
            </a>
          </div>
          <div class="mt-8 md:order-1 md:mt-0">
            <p class="text-center text-xs leading-5 text-gray-500">&copy; 2023 PDGI Cabang Kota Bogor</p>
          </div>
        </div>
      </footer>
</body>
</html>
