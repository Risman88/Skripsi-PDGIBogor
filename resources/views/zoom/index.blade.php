<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jadwal Wawancara') }}
        </h2>
    </x-slot>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <h3 class="text-lg font-semibold text-gray-800">Wawancara Mendatang</h3>
            @include('zoom.partials.table', ['meetings' => $zoomMeetingsUpcoming, 'show_status' => false, 'show_detail' => true])
            <div class="border-t-2 border-gray-300 my-12"></div>
            <h3 class="text-lg font-semibold text-gray-800 mt-12">Histori Wawancara</h3>
            @include('zoom.partials.table', ['meetings' => $zoomMeetingsPast, 'show_status' => true, 'show_detail' => false])
        </div>
</x-dashboard-layout>
