<div class="rounded-md bg-green-50 p-4 {{ $attributes->get('class') }}">
    <div class="flex">
        <div class="flex-shrink-0">
            <!-- Heroicon name: solid/check-circle -->
            <svg class="h-5 w-5 text-green-400 {{ $iconClass ?? '' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M7.293 10.707a1 1 0 000 1.414l3 3a1 1 0 001.414 0l6-6a1 1 0 10-1.414-1.414L10 12.586l-2.293-2.293a1 1 0 00-1.414 0z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-green-800 {{ $titleClass ?? '' }}">{{ $title }}</h3>
            <div class="mt-2 text-sm text-green-700">
                <p>{{ $slot }}</p>
            </div>
        </div>
    </div>
</div>
