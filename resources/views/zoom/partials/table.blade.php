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
                        @if ($show_status)
                            <th scope="col"
                                class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
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
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse ($meetings as $zoomMeeting)
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
                                {{ \Carbon\Carbon::parse($zoomMeeting->start_time)->format('d F Y H:i') }}
                            </td>
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                {{ $zoomMeeting->duration }} Menit</td>
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
                                </td>
                            @endif
                            @php
                                $endTime = \Carbon\Carbon::parse($zoomMeeting->start_time)->addMinutes($zoomMeeting->duration);
                            @endphp
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                @if ($endTime->isPast())
                                    -
                                @else
                                    {{ $zoomMeeting->zoom_meeting_id }}
                                @endif
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                @if ($endTime->isPast())
                                    -
                                @else
                                    {{ $zoomMeeting->password }}
                                @endif
                            <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                @if ($endTime->isPast())
                                    -
                                @else
                                    <a href="{{ $zoomMeeting->link_zoom }}" target="_blank"
                                        class="text-indigo-600 hover:text-indigo-900">Link Zoom</a>
                                @endif
                            </td>
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
<div class="mt-4">
    {{ $meetings->appends(request()->except('page'))->links() }}
</div>
