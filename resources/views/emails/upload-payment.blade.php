<x-mail::message>
# Halo!
Ini adalah Notifikasi email bahwa salah satu pengguna menunggu konfirmasi pembayaran.

Bukti pembayaran baru telah diunggah oleh {{ $payment->user->name }} dengan ID Pembayaran {{ $payment->id }}.

<x-mail::button :url="route('payments.indexall')">
    Klik untuk melihat pembayaran
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
