<x-mail::message>
# Halo!
Ini adalah Notifikasi Email bahwa Pengajuan anda telah selesai.

{{ $submission->submissionType->name }} dengan ID Pengajuan "{{ $submission->id }}" telah selesai diproses.

<x-mail::button :url="route('submission.index')">
    Klik untuk melihat pengajuan
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
