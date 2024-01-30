<x-dashboard-layout>
    @php
    $infoPengajuan = [
        'ID Pengajuan' => $submission->id,
        'Tipe Pengajuan' => $submission->submissionType->name,
        'Tanggal Pengajuan' => $submission->created_at->format('d-F-Y H:i:s'),
        'Status' => $submission->status === 'Selesai' ? '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>' : ($submission->status === 'Diproses' ? '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Diproses</span>' : '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>'),
        'Hasil Surat' => $submission->surat_keluar
                ? (($ext = pathinfo($submission->surat_keluar, PATHINFO_EXTENSION)) === 'pdf'
                ? '<div class="flex items-center mb-4">
                    <a href="' .route('submission.surat_keluar', $submission->id) .'" target="_blank" class="ml-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5 2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7.414a1 1 0 0 0-.293-.707l-4.586-4.586A1 1 0 0 0 11.586 2H5zm5 2.5a1.5 1.5 0 0 1 1.5 1.5v3.793l1.146 1.147a.5.5 0 0 0 .708-.708L12.5 9.793V7a1.5 1.5 0 0 1 1.5-1.5h1.5a.5.5 0 0 0 0-1H5a.5.5 0 0 0-.5.5v12a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V7.414l-2.146-2.147a.5.5 0 0 0-.708 0l-2.147 2.147z" clip-rule="evenodd" />
                    </svg>
                    <span class="ml-2 text-blue-500 font-medium">Lihat PDF</span></a></div>'
                : '<a href="' . route('submission.surat_keluar', $submission->id) . '" target="_blank"><img src="' . route('submission.surat_keluar', $submission->id) . '" alt="Surat Keluar" class="w-40 h-auto border border-gray-300 rounded"></a>')
                : '-',
        'Nama' => $submission->user->name,
        'Tempat Lahir' => $submission->user->tempat_lahir,
        'Tanggal Lahir' => \Carbon\Carbon::parse($submission->user->tanggal_lahir)->format('d-F-Y'),
        'Jenis Kelamin' => $submission->user->jenis_kelamin,
        'Alamat' => $submission->user->alamat,
        'Nomor Handphone' => $submission->user->handphone,
        'Agama' => $submission->user->agama,
        'Praktik Ke' => $submission->submission_izin_praktik->praktik_ke,
        'Tujuan Surat' => $submission->submission_izin_praktik->tujuan_surat,
        'Alumni' => $submission->submission_izin_praktik->alumni_drg,
        'Tahun Lulus' => $submission->submission_izin_praktik->tahun_lulus,
        'Nomor STR' => $submission->submission_izin_praktik->str,
        'Masa Berlaku STR' => $submission->submission_izin_praktik->seumur_hidup
                        ? 'Seumur Hidup'
                        : \Carbon\Carbon::parse($submission->submission_izin_praktik->valid_str)->format('d-F-Y'),
        'Nomor Serkom' => $submission->submission_izin_praktik->serkom,
        'NPA' => $submission->submission_izin_praktik->npa,
        'Cabang PDGI' => $submission->submission_izin_praktik->cabang_pdgi,
        'Alamat Praktik Fakes Pertama' => $submission->submission_izin_praktik->alamat_fakes1 ?? '-',
        'Jadwal Praktik Fakes Pertama' => $submission->submission_izin_praktik->jadwal_praktik1 ?? '-',
        'Alamat Praktik Fakes Kedua' => $submission->submission_izin_praktik->alamat_fakes2 ?? '-',
        'Jadwal Praktik Fakes Kedua' => $submission->submission_izin_praktik->jadwal_praktik2 ?? '-',
        'Alamat Praktik Fakes Ketiga' => $submission->submission_izin_praktik->alamat_fakes3 ?? '-',
        'Jadwal Praktik Fakes Ketiga' => $submission->submission_izin_praktik->jadwal_praktik3 ?? '-',
    ];
@endphp
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Detail Pengajuan Surat Rekomendasi atau Pengantar Izin Praktik') }}
    </h2>
</x-slot>

<a href="{{ url()->previous() }}" class="text-blue-600 hover:text-blue-800">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
    </svg> Kembali ke halaman sebelumnya
</a>
<div x-data="{ tab: 'infoPengajuan', dropdownOpen: false }" class="bg-white shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:p-6">
            <div class="relative inline-block text-left">
                <button x-on:click="dropdownOpen = !dropdownOpen" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="options-menu" aria-haspopup="true" x-bind:aria-expanded="dropdownOpen">
                    <span x-text="tab === 'infoPengajuan' ? 'Informasi Pengajuan' : 'Kumpulan Berkas'"></span>
                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 12a1 1 0 01-.707-.293l-3-3a1 1 0 111.414-1.414L10 9.586l2.293-2.293a1 1 0 011.414 1.414l-3 3A1 1 0 0110 12z" clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                    <div class="py-1" role="none">
                        <button @click="tab = 'infoPengajuan'; dropdownOpen = false" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none" role="menuitem">
                            Informasi Pengajuan
                        </button>
                        <button @click="tab = 'kumpulanBerkas'; dropdownOpen = false" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none" role="menuitem">
                            Kumpulan Berkas
                        </button>
                    </div>
                </div>
            </div>
            <div class="py-1">
            <div class="border-t border-gray-200">
                <div x-show="tab === 'infoPengajuan'">
                    <dl>
                        @foreach ($infoPengajuan as $key => $value)
                            <div class="{{ $loop->iteration % 2 === 0 ? 'bg-white' : 'bg-gray-200' }} px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt>
                                    {{ $key }}
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {!! $value !!}
                                </dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
                <div x-show="tab === 'kumpulanBerkas'">
                    @php
                    $scanFiles = [
                        'scan_s1' => ['label' => 'Ijazah S1', 'type' => 'user_document'],
                        'scan_drg' => ['label' => 'Ijazah Profesi', 'type' => 'user_document'],
                        'scan_s2' => ['label' => 'Ijazah S2', 'type' => 'user_document'],
                        'scan_ktp' => ['label' => 'KTP', 'type' => 'user_document'],
                        'scan_foto' => ['label' => 'Foto Diri', 'type' => 'user_document'],
                        'surat_praktik1' => ['label' => 'SIP / Surat Izin / Surat Keterangan Praktik 1', 'type' => 'submission_izin_praktik'],
                        'surat_praktik2' => ['label' => 'SIP / Surat Izin / Surat Keterangan Praktik 2', 'type' => 'submission_izin_praktik'],
                        'surat_praktik3' => ['label' => 'SIP / Surat Izin / Surat Keterangan Praktik 3', 'type' => 'submission_izin_praktik'],
                        'scan_str' => ['label' => 'Scan STR', 'type' => 'submission_izin_praktik'],
                        'scan_serkom' => ['label' => 'Scan Serkom', 'type' => 'submission_izin_praktik'],
                        'scan_surat_sehat' => ['label' => 'Scan Surat Sehat', 'type' => 'submission_izin_praktik'],
                        'surat_mkekg' => ['label' => 'Surat MKEKG', 'type' => 'submission_izin_praktik'],
                    ];

                    $conditionalElements = [
                        ($submission->submission_type_id == 2) ? ['scan_surat_pengantar' => ['label' => 'Scan Surat Pengantar', 'type' => 'submission_izin_praktik']] : null,
                        ($submission->submission_type_id == 2 || $submission->submission_type_id == 4 || $submission->submission_type_id == 6) ? ['scan_drgsp' => ['label' => 'Ijazah Spesialis', 'type' => 'user_document']] : null,
                        ($submission->submission_type_id == 2 || $submission->submission_type_id == 4 || $submission->submission_type_id == 6) ? ['scan_surat_kolegium' => ['label' => 'Surat Kolegium', 'type' => 'submission_izin_praktik']] : null,
                    ];

                    $filteredConditionalElements = array_filter($conditionalElements);
                    $scanFiles = array_merge($scanFiles, ...$filteredConditionalElements);
                    @endphp
                    <dl>
                        @foreach ($scanFiles as $key => $data)
                        <div
                            class="{{ $loop->iteration % 2 === 0 ? 'bg-white' : 'bg-gray-200' }} px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt>
                                {{ $data['label'] }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if ($data['type'] === 'user_document')
                                    @if ($submission->user->userDocument->{$key})
                                        <a href="{{ route('user_document.show', ['userId' => $submission->user->id, 'scanFile' => $key]) }}"
                                            target="_blank">
                                            <img src="{{ route('user_document.show', ['userId' => $submission->user->id, 'scanFile' => $key]) }}"
                                                alt="{{ $data['label'] }}"
                                                class="w-40 h-auto border border-gray-300 rounded">
                                        </a>
                                    @else
                                        <span>-</span>
                                    @endif
                                @else
                                    {{-- Tampilkan gambar dari tabel submission_izinpraktik --}}
                                    @if ($submission->{$data['type']}->{$key})
                                        <a href="{{ route('images.scan', ['type_id' => $submission->submission_type_id, 'scanFile' => $key, 'userId' => $submission->user_id, 'submissionId' => $submission->id]) }}"
                                            target="_blank">
                                            <img src="{{ route('images.scan', ['type_id' => $submission->submission_type_id, 'scanFile' => $key, 'userId' => $submission->user_id, 'submissionId' => $submission->id]) }}"
                                                alt="{{ $data['label'] }}"
                                                class="w-40 h-auto border border-gray-300 rounded">
                                        </a>
                                    @else
                                        <span>-</span>
                                    @endif
                                @endif
                            </dd>
                        </div>
                    @endforeach
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
</x-dashboard-layout>
