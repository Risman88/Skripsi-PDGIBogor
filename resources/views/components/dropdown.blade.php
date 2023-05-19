@props(['dropdownTitle'])

<div class="relative inline-block text-left" x-data="{ open: false }">
    <!-- Tombol dropdown -->
    <button @click="open = !open"
        class="text-white px-3 py-2 rounded-md text-sm font-medium focus:outline-none hover:bg-purple-700">
        <span class="flex items-center">
            {{ __($dropdownTitle) }}
            <svg class="fill-current h-4 w-4 ml-2"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                    clip-rule="evenodd" />
            </svg>
        </span>
    </button>

    <!-- Dropdown menu -->
    <div x-show="open" @click.away="open = true"
        class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
        role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
        <div class="py-1">
            {{ $slot }}
        </div>
    </div>
</div>
