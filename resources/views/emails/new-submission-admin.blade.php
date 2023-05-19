<x-mail::message>
# Halo!
Ini adalah Notifikasi Email untuk Pengajuan Baru

Ada pengajuan baru dari {{ $submission->user->name }}, dengan Tipe Pengajuan: {{ $submission->submissionType->name }}.

Mohon login aplikasi untuk segera meninjau pengajuan tersebut.

<x-mail::button :url="route('submission.indexall')">
    Klik untuk melihat pengajuan
</x-mail::button>


Terimakasih,<br>
{{ config('app.name') }}
</x-mail::message>
