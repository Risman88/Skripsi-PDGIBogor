<x-mail::message>
# Halo!
Ini adalah notifikasi email untuk pembayaran anda

Pembayaran anda dengan ID Pembayaran {{ $payment->id }}, sudah dinyatakan lunas oleh bendahara PDGI Kota Bogor.

<x-mail::button :url="route('payments.index')">
    Klik untuk melihat pembayaran
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
