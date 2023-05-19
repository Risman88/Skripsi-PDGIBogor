<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Wawancara') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="flex justify-between items-center mb-4">
            <form action="{{ route('zoom_meetings.indexall') }}" method="GET" class="mb-4">
                <input type="text" name="search" id="search" placeholder="Cari untuk.."
                    value="{{ old('search', $search) }}"
                    class="rounded-md border px-3 py-2 focus:outline-none focus:border-indigo-500">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded">Cari</button>
            </form>
            <div class="flex items-center space-x-2">
                <!-- Tombol Konfirmasi Kehadiran -->
                <a href="{{ route('zoom.kehadiran') }}" class="px-2 py-1 bg-blue-500 text-white rounded">
                    Konfirmasi Kehadiran
                </a>

                <!-- Tombol Buat Wawancara -->
                <a href="{{ route('zoom_meetings.create') }}" class="px-2 py-1 bg-blue-500 text-white rounded">
                    Buat Wawancara
                </a>
            </div>
        </div>

        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Wawancara Mendatang</h3>
        @include('zoom.partials.table_admin', [
            'meetings' => $zoomMeetingsUpcoming,
            'show_status' => false,
        ])
        <div class="mt-4">
            {{ $zoomMeetingsUpcoming->appends(['search' => request()->query('search'), 'pastPage' => request()->query('pastPage')])->links() }}
        </div>
        <div class="border-t-2 border-gray-300 my-12"></div>
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mt-12">Histori Wawancara</h3>
        @include('zoom.partials.table_admin', ['meetings' => $zoomMeetingsPast, 'show_status' => true])
        <div class="mt-4">
            {{ $zoomMeetingsPast->appends(['search' => request()->query('search'), 'upcomingPage' => request()->query('upcomingPage')])->links() }}
        </div>
    </div>
</x-dashboard-layout>
