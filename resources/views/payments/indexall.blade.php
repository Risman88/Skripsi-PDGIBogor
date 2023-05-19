<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Data Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="flex justify-between items-center mb-4">
            <form action="{{ route('payments.indexall') }}" method="GET" class="mb-4">
                <input type="text" name="search" id="search" placeholder="Cari berdasarkan nama" value="{{ old('search', $search) }}" class="border px-3 py-2 focus:outline-none focus:border-indigo-500">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded">Cari</button>
            </form>
            {{-- @can('edit pembayaran')
            <a href="{{ route('payments.indexall') }}" class="px-4 py-2 bg-blue-500 text-white rounded">
                Tambah Pembayaran Baru
            </a>
            @endcan --}}
        </div>



        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Menunggu Konfirmasi</h3>
        @include('payments.payment_table_admin', ['payments' => $pendingPayments, 'paginationName' => 'pending_page', 'show_bukti' => true, 'show_by' => false])

        <div class="border-t-2 border-gray-300 my-12"></div>

        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Belum Dibayar</h3>
        @include('payments.payment_table_admin', ['payments' => $unpaidPayments, 'paginationName' => 'unpaid_page', 'show_bukti' => false, 'show_by' => false])

        <div class="border-t-2 border-gray-300 my-12"></div>

        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Lunas</h3>
        @include('payments.payment_table_admin', ['payments' => $completedPayments, 'paginationName' => 'completed_page', 'show_bukti' => true, 'show_by' => true])
    </div>
</x-dashboard-layout>
