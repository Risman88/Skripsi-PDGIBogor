<div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-14">
    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <table class="w-full bg-white border-collapse border border-gray-300">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Nomor
                        </th>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Nama
                        </th>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Banner
                        </th>
                        <th scope="col" class="relative py-4 pl-3 pr-4 sm:pr-6">
                            <span class="sr-only"></span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse ($slideshows as $slideshow)
                        <tr class="divide-x divide-gray-200">
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ $slideshow->id }}
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ $slideshow->caption }}</td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                <a href="{{ route('slideshow.banner', $slideshow->id) }}" target="_blank">
                                    <img src="{{ route('slideshow.banner', $slideshow->id) }}" alt="Image_URL"
                                        class="w-8 h-auto border border-gray-300 rounded">
                                </a>
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 text-sm font-medium text-gray-900 sm:pl-6">
                                <div class="flex space-x-2">
                                    <a href="{{ route('slideshow.edit', ['slideshow' => $slideshow->id]) }}"
                                        class="text-white bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded">
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5"
                                class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                Tidak ada data banner
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
