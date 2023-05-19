<x-mail::message>
# Halo!
Ini adalah notifikasi email untuk pembayaran anda

Pembayaran anda dengan ID Pembayaran {{ $payment->id }} ditolak, dapat dikarenakan kesalahan bukti pembayaran atau pembayaran belum di terima.
Apabila anda merasa sudah membayar dan tidak mengunggah bukti pembayaran yang salah, segera hubungi Bendahara PDGI Kota Bogor

<x-mail::button :url="route('payments.index')">
    Klik untuk melihat pembayaran
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
