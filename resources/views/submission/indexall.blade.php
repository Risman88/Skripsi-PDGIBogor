<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pengelolaan Pengajuan') }}
        </h2>
    </x-slot>

    <x-slot name="slot">
        <div class="py-4">
            <div class="flex justify-between items-center mb-4">
                <form action="{{ route('submission.indexall') }}" method="GET" class="mb-4">
                    <input type="text" name="search" id="search" placeholder="Cari berdasarkan nama" value="{{ old('search', $search) }}" class="border px-3 py-2 focus:outline-none focus:border-indigo-500">
                    <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded">Cari</button>
                </form>
            </div>

            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Pengajuan Diproses</h3>
            @include('submission.partials.table_admin', ['submissions' => $submissionsDiproses, 'show_surat' => false])
            <div class="mt-4">
            {{ $submissionsDiproses->withQueryString()->appends(['ditolak' => $submissionsDitolak->currentPage(), 'selesai' => $submissionsSelesai->currentPage()])->links() }}
            </div>
            <div class="border-t-2 border-gray-300 my-12"></div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mt-12">Pengajuan Selesai</h3>
            @include('submission.partials.table_admin', ['submissions' => $submissionsSelesai, 'show_surat' => true])
            <div class="mt-4">
            {{ $submissionsSelesai->withQueryString()->appends(['diproses' => $submissionsDiproses->currentPage(), 'ditolak' => $submissionsDitolak->currentPage()])->links() }}
            </div>
            <div class="border-t-2 border-gray-300 my-12"></div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mt-12">Pengajuan Ditolak</h3>
            @include('submission.partials.table_admin', ['submissions' => $submissionsDitolak, 'show_surat' => false])
            <div class="mt-4">
            {{ $submissionsDitolak->withQueryString()->appends(['diproses' => $submissionsDiproses->currentPage(), 'selesai' => $submissionsSelesai->currentPage()])->links() }}
            </div>
        </div>
    </x-slot>
</x-dashboard-layout>
