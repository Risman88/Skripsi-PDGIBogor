<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false" class="relative ml-3">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>


<div x-show="open"
        x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95">

        <div class="rounded-md ring-1 ring-black ring-opacity-5">
            {{ $content }}
        </div>
    </div>
</div>
