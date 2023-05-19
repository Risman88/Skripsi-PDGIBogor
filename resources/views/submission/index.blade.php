<x-dashboard-layout>
    <x-slot name="header">
        {{ __('Histori Pengajuan') }}
    </x-slot>

    <x-slot name="slot">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Pengajuan Diproses</h3>
            @include('submission.partials.table', [
                'submissions' => $submissionsDiproses,
                'show_surat' => false,
            ])
            <div class="mt-4">
                {{ $submissionsDiproses->links() }}
            </div>
            <div class="border-t-2 border-gray-300 my-12"></div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mt-12">Pengajuan Selesai</h3>
            @include('submission.partials.table', [
                'submissions' => $submissionsSelesai,
                'show_surat' => true,
            ])
            <div class="mt-4">
                {{ $submissionsSelesai->links() }}
            </div>
            <div class="border-t-2 border-gray-300 my-12"></div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mt-12">Pengajuan Ditolak</h3>
            @include('submission.partials.table', [
                'submissions' => $submissionsDitolak,
                'show_surat' => false,
            ])
            <div class="mt-4">
                {{ $submissionsDitolak->links() }}
            </div>
        </div>
    </x-slot>
</x-dashboard-layout>
