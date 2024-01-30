<x-home-layout>
    <x-slot name="slot">
        <div class="absolute left-1/2 right-0 top-0 -z-10 -ml-24 transform-gpu overflow-hidden blur-3xl lg:ml-24 xl:ml-48"
            aria-hidden="true">
            <div class="aspect-[801/1036] w-[50.0625rem] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30"
                style="clip-path: polygon(63.1% 29.5%, 100% 17.1%, 76.6% 3%, 48.4% 0%, 44.6% 4.7%, 54.5% 25.3%, 59.8% 49%, 55.2% 57.8%, 44.4% 57.2%, 27.8% 47.9%, 35.1% 81.5%, 0% 97.7%, 39.2% 100%, 35.2% 81.4%, 97.2% 52.8%, 63.1% 29.5%)">
            </div>
        </div>
        <div class="overflow-hidden">
            <div class="mx-auto max-w-7xl px-6 pb-32 pt-36 sm:pt-60 lg:px-8 lg:pt-32">
                <div class="mx-auto max-w-2xl gap-x-14 lg:mx-0 lg:flex lg:max-w-none lg:items-center">
                    <div class="w-full max-w-xl lg:shrink-0 xl:max-w-2xl">
                        <h2 class="text-6xl font-bold leading-10 tracking-tight text-gray-900">Panduan</h2>
                    </div>
                </div>
                <dl class="mt-10 space-y-6 divide-y divide-gray-900/10">
                    @foreach ($panduans as $panduan)
                        <div x-data="{ open: false }" class="pt-6 no-tailwindcss-base">
                            <dt>
                                <button type="button" x-description="Expand/collapse question button"
                                    class="flex w-full items-start justify-between text-left text-gray-900"
                                    aria-controls="faq-{{ $loop->index }}" @click="open = !open" aria-expanded="false"
                                    x-bind:aria-expanded="open.toString()">
                                    <span class="text-base font-semibold leading-7">{{ $panduan->judul }}</span>
                                    <span class="ml-6 flex h-7 items-center">
                                        <svg x-description="Icon when question is collapsed." x-state:on="Item expanded"
                                            x-state:off="Item collapsed" class="h-6 w-6" :class="{ 'hidden': open }"
                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                            aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6">
                                            </path>
                                        </svg>
                                        <svg x-description="Icon when question is expanded." x-state:on="Item expanded"
                                            x-state:off="Item collapsed" class="hidden h-6 w-6"
                                            :class="{ 'hidden': !(open) }" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6"></path>
                                        </svg>
                                    </span>
                                </button>
                            </dt>
                            <dd class="mt-2 pr-12" id="faq-{{ $loop->index }}" x-show="open">
                                <p class="text-base leading-7 text-gray-600">{!! $panduan->isi !!}</p>
                            </dd>
                        </div>
                    @endforeach
                </dl>
                <div class="mt-6">
                    {{ $panduans->links() }}
                </div>
            </div>
        </div>
        </div>
    </x-slot>
</x-home-layout>
