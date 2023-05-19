<div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-14">
    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <table class="w-full bg-white border-collapse border border-gray-300">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            No
                        </th>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Judul Pertemuan
                        </th>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Tujuan
                        </th>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Jadwal
                        </th>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Durasi
                        </th>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Wawancara untuk
                        </th>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Diwawancarai oleh
                        </th>
                        @if ($show_status)
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Status Kehadiran
                        </th>
                        @endif
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            ID Zoom Meeting
                        </th>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Password Meeting
                        </th>
                        <th scope="col" class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                            Link Pertemuan
                        </th>
                        {{-- <th scope="col" class="relative py-4 pl-3 pr-4 sm:pr-6">
                            <span class="sr-only"></span>
                        </th> --}}
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse ($meetings as $index => $zoomMeeting)
                        <tr class="divide-x divide-gray-200">
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ $loop->iteration + ($meetings->currentPage() - 1) * $meetings->perPage() }}
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                @if (strlen($zoomMeeting->title) > 20)
                                    @php
                                        $description = wordwrap($zoomMeeting->title, 20, '<br>');
                                    @endphp
                                    {!! $description !!}
                                @else
                                    {{ $zoomMeeting->title }}
                                @endif
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                @if (strlen($zoomMeeting->description) > 20)
                                    @php
                                        $description = wordwrap($zoomMeeting->description, 20, '<br>');
                                    @endphp
                                    {!! $description !!}
                                @else
                                    {{ $zoomMeeting->description }}
                                @endif
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ \Carbon\Carbon::parse($zoomMeeting->start_time)->format('d F Y H:i') }}</td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ $zoomMeeting->duration }} Menit</td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ $zoomMeeting->untuk->name }}</td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ $zoomMeeting->oleh->name }}</td>
                            @if ($show_status)
                                <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                    @if ($zoomMeeting->status === 'Hadir')
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Hadir
                                        </span>
                                    @else
                                        <span
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Tidak Hadir
                                        </span>
                                    @endif
                            @endif
                            @php
                                $endTime = \Carbon\Carbon::parse($zoomMeeting->start_time)->addMinutes($zoomMeeting->duration);
                            @endphp
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                @if ($endTime->isPast())

                                @else
                                    {{ $zoomMeeting->zoom_meeting_id }}
                                @endif
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                @if ($endTime->isPast())

                                @else
                                    {{ $zoomMeeting->password }}
                                @endif
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                @if ($endTime->isPast())

                                @else
                                    <a href="{{ $zoomMeeting->link_zoom }}" target="_blank"
                                        class="text-indigo-600 hover:text-indigo-900">Link Zoom</a>
                                @endif
                            </td>
                            {{-- <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                @if ($endTime->isPast())

                                @else
                                    <button x-data=""
                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-delete-{{ $zoomMeeting->id }}')"
                                        type="submit"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Hapus
                                    </button>
                                @endif

                                <x-modal name="confirm-delete-{{ $zoomMeeting->id }}" focusable>
                                    @if (session('zoom_logged_in'))
                                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                            {{ __('Apakah anda yakin untuk menghapus pertemuan?') }}
                                        </h2>

                                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                            {{ __('Menghapus pertemuan dilakukan secara permanen dan tidak dapat dikembalikan') }}
                                        </p>

                                        <div class="mt-6 flex justify-end">
                                            <x-secondary-button x-on:click="$dispatch('close')">
                                                {{ __('Batal') }}
                                            </x-secondary-button>
                                            <form action="{{ route('zoom_meetings.delete', $zoomMeeting->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <x-danger-button class="ml-3">
                                                    {{ __('Hapus Pertemuan') }}
                                                </x-danger-button>
                                            </form>
                                        </div>
                                    @else
                                        <h2 class="p-2 mb-4 text-lg font-medium text-gray-900 dark:text-gray-100">
                                            {{ __('Silahkan login Zoom') }}
                                        </h2>
                                        <div class="p-2 rounded">
                                            <a href="{{ route('zoom.redirect', ['redirect' => route('zoom_meetings.indexall') . '?search=' . request()->query('search')]) }}"
                                                class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">Login
                                                Zoom</a>
                                        </div>
                                        <div class="p-2 mt-4 mb-4 rounded">
                                            <span class="text-gray-500 font-bold text-sm px-1 inline-block">(Anda harus
                                                login Zoom untuk menghapus pertemuan)</span>
                                        </div>
                                    @endif
                                </x-modal>
                            </td> --}}
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11"
                                class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                Tidak ada data wawancara.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
