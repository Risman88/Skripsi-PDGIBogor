<x-mail::message>
# Halo!
Ini adalah Notifikasi email bahwa Anda telah mendapatkan jadwal wawancara baru.

Detail wawancara baru sebagai berikut:

- Nama: {{$zoomMeeting->title}}
- Deskripsi: {{$zoomMeeting->description}}
- Waktu Mulai: {{\Carbon\Carbon::parse($zoomMeeting->start_time)->format('d F Y H:i')}}
- Durasi: {{$zoomMeeting->duration}} menit
- Tautan Zoom: [Tautan Zoom]({{$zoomMeeting->link_zoom}})

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
