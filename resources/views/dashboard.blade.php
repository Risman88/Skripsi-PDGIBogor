<x-dashboard-layout>
    <x-slot name="header">
        {{ __('Selamat Datang') }}, {{ Auth::user()->name }}
    </x-slot>

    <x-slot name="slot">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <x-dashboard-card-meeting title="Wawancara mendatang untuk anda" :meetings="$WawancaraMendatangUser" />
            <x-dashboard-card title="Pembayaran yang harus anda bayar" :count="$PembayaranBelumdibayarUser . ' belum di bayar' " />
            <x-dashboard-card title="Pengajuan anda yang masih dalam proses" :count="$PengajuanDiprosesUser . ' diproses'" />

            @can('view pengajuan')
            <x-dashboard-card title="Total Seluruh Pengajuan" :count="$totalPengajuan . ' pengajuan'" :count2="$TotalPengajuanSedangdiproses . ' diproses'" />
            @endcan
            @can('edit pembayaran')
                <x-dashboard-card title="Total Pembayaran Menunggu Konfirmasi" :count="$TotalPembayaranMenungguKonfirmasi . ' pembayaran'" />
            @endcan
            @can('edit meeting')
                <x-dashboard-card-meeting title="Wawancara mendatang oleh anda" :meetings="$WawancaraMendatangAdmin" />
            @endcan
        </div>
    </x-slot>
</x-dashboard-layout>
