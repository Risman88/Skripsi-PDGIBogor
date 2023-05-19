<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pembayaran') }}
        </h2>
    </x-slot>
@can('iuran')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="px-4 py-3 bg-gray-200 shadow sm:rounded-lg">
            <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 mb-4">Pilihan Pembayaran Iuran</h3>
            <form action="{{ route('payments.bayar-iuran') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 dark:text-gray-300 font-medium mb-2" for="duration">
                        Durasi Pembayaran
                    </label>
                    <div class="relative">
                        <select name="bulan" id="duration" class="form-input rounded-md shadow-sm mt-1 block w-full border border-gray-300">
                            <option value="3">3 Bulan (90 hari) : 90.000</option>
                            <option value="6">6 Bulan (180 hari) : 180.000</option>
                            <option value="12">1 Tahun (365 hari) : 350.000</option>
                            <option value="24">2 Tahun (730 hari) : 700.000</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-6">
                    <x-primary-button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md font-semibold">
                        Pilih Durasi
                    </x-primary-button>
                </div>
            </form>
        </div>

        <div class="border-t-2 border-gray-300 my-12"></div>
        @endcan
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Menunggu Pembayaran</h3>
        @include('payments.payment_table', ['payments' => $unpaidAndPendingPayments])
        <div class="border-t-2 border-gray-300 my-12"></div>
        <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mt-12">Histori Pembayaran</h3>
        @include('payments.payment_table', ['payments' => $completedPayments])
    </div>
</x-dashboard-layout>
