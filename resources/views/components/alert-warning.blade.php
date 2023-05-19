<div class="rounded-md bg-yellow-50 p-4 {{ $attributes->get('class') }}">
    <div class="flex">
        <div class="flex-shrink-0">
            <!-- Heroicon name: solid/exclamation -->
            <svg class="h-5 w-5 text-yellow-400 {{ $iconClass ?? '' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-2a6 6 0 100-12 6 6 0 000 12zM9 9a1 1 0 012 0v4a1 1 0 01-2 0V9zm1-4a1 1 0 00-1 1v1a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-yellow-800 {{ $titleClass ?? '' }}">{{ $title }}</h3>
            <div class="mt-2 text-sm text-yellow-700">
                <p>{{ $slot }}</p>
            </div>
        </div>
    </div>
</div>
