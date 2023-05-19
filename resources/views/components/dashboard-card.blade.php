@props(['title', 'count', 'count2'])

<div class="relative w-full h-52 bg-cover bg-center group rounded-lg overflow-hidden mt-4 shadow-lg transition duration-300 ease-in-out">
    <div class="absolute inset-0 bg-black bg-opacity-50 transition duration-300 ease-in-out"></div>
    <div class="relative w-full h-full px-4 sm:px-6 lg:px-4 flex items-center">
        <div>
            <div class="text-white text-lg flex space-x-2 items-center">
                <div class="bg-white rounded-md p-2 flex items-center">
                    <i class="fas fa-toggle-off fa-sm text-yellow-300"></i>
                </div>
                <p>{{ $title }}</p>
            </div>
            <h3 class="text-white text-3xl mt-2 font-bold">
                {{ $count }}
            </h3>
            @isset($count2)
                <h3 class="text-lg mt-2 text-yellow-100">
                    {{ $count2 }}
                </h3>
            @endisset
        </div>
    </div>
</div>
