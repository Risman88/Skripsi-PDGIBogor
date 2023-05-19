<div x-data="{ openDropdown: false }">
    <button @click="openDropdown = !openDropdown"
            class="w-full flex items-center justify-between px-3 py-2 text-base font-medium text-white hover:bg-purple-500 hover:bg-opacity-75"
            :class="{ 'bg-purple-500 bg-opacity-75': openDropdown }">
        <span>{{ $title }}</span>
        <svg class="h-5 w-5 text-purple-400" :class="{ 'rotate-180': openDropdown }"
             xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
             aria-hidden="true">
            <path fill-rule="evenodd" d="M10 14l6-6H4l6 6z" />
        </svg>
    </button>
    <div x-show="openDropdown" @click.away="openDropdown = false">
        {{ $slot }}
    </div>
</div>
