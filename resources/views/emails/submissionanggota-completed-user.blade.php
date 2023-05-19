<x-mail::message>
# Halo!
Ini adalah Notifikasi Email bahwa Pengajuan Anggota anda telah selesai.

{{ $submission->submissionType->name }} dengan ID Pengajuan {{ $submission->id }} telah selesai diproses.

Silahkan login kedalam aplikasi, apabila membutuhkan kepengurusan surat untuk anggota.

<x-mail::button :url="route('login')">
    Klik untuk login
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
