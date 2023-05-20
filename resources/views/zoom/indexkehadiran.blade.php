<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Konfirmasi Kehadiran Wawancara') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <h3 class="text-lg font-semibold text-gray-800">Kehadiran Wawancara</h3>

        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-14">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <table class="w-full bg-white border-collapse border border-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    No
                                </th>
                                <th scope="col"
                                    class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    Judul Pertemuan
                                </th>
                                <th scope="col"
                                    class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    Tujuan
                                </th>
                                <th scope="col"
                                    class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    Jadwal
                                </th>
                                <th scope="col"
                                    class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    Durasi
                                </th>
                                <th scope="col"
                                    class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    Wawancara untuk
                                </th>
                                <th scope="col"
                                    class="py-4 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                    Status Kehadiran
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @forelse ($zoomMeetings as $index => $zoomMeeting)
                                <tr class="divide-x divide-gray-200">
                                    <td
                                        class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                        {{ $index + 1 }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                        @if (strlen($zoomMeeting->title) > 20)
                                            @php
                                                $description = wordwrap($zoomMeeting->title, 20, '<br>');
                                            @endphp
                                            {!! $description !!}
                                        @else
                                            {{ $zoomMeeting->title }}
                                        @endif
                                    </td>
                                    <td
                                        class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                        @if (strlen($zoomMeeting->description) > 20)
                                            @php
                                                $description = wordwrap($zoomMeeting->description, 20, '<br>');
                                            @endphp
                                            {!! $description !!}
                                        @else
                                            {{ $zoomMeeting->description }}
                                        @endif
                                    </td>
                                    <td
                                        class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                        {{ \Carbon\Carbon::parse($zoomMeeting->start_time)->format('d F Y H:i') }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                        {{ $zoomMeeting->duration }} Menit
                                    </td>
                                    <td
                                        class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                        {{ $zoomMeeting->untuk->name }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                        <form action="{{ route('zoom_meetings.status', $zoomMeeting) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select class="border border-gray-300" name="status"
                                                onchange="this.form.submit()">
                                                <option value="Hadir"
                                                    {{ $zoomMeeting->status === 'Hadir' ? 'selected' : '' }}>Hadir
                                                </option>
                                                <option value="Tidak Hadir"
                                                    {{ $zoomMeeting->status === 'Tidak Hadir' ? 'selected' : '' }}>Tidak
                                                    Hadir</option>
                                            </select>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="11"
                                            class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-6">
                                            Tidak ada data kehadiran yang dapat diubah.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
</x-dashboard-layout>
