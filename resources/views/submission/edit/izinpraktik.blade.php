<x-dashboard-layout>
    @php
        $infoPengajuan = [
            'ID Pengajuan' => $submission->id,
            'Tipe Pengajuan' => $submission->submissionType->name,
            'Tanggal Pengajuan' => $submission->created_at,
            'Status' => $submission->status,
            'Hasil Surat' => $submission->surat_keluar,
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
            'Masa Berlaku STR' => $submission->submission_izin_praktik->valid_str,
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
        $scanFiles = [
            'surat_praktik1' => 'SIP / Surat Izin / Surat Keterangan Praktik 1',
            'surat_praktik2' => 'SIP / Surat Izin / Surat Keterangan Praktik 2',
            'surat_praktik3' => 'SIP / Surat Izin / Surat Keterangan Praktik 3',
            'scan_serkom' => 'Scan Serkom',
            'scan_str' => 'Scan STR',
            'scan_surat_sehat' => 'Scan Surat Sehat',
            'surat_mkekg' => 'Surat MKEKG',
        ];
                    $conditionalElements = [
                        ($submission->submission_type_id == 2) ? ['scan_surat_pengantar' => 'Scan Surat Pengantar'] : null,
                        ($submission->submission_type_id == 2 || $submission->submission_type_id == 4 || $submission->submission_type_id == 6) ? ['scan_surat_kolegium' => 'Surat Kolegium'] : null,
                    ];

                    $filteredConditionalElements = array_filter($conditionalElements);
                    $scanFiles = array_merge($scanFiles, ...$filteredConditionalElements);
    @endphp
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pengajuan Surat Izin Praktik') }}
        </h2>
    </x-slot>

    <a href="{{ url()->previous() }}" class="text-blue-600 hover:text-blue-800">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
        </svg> Kembali ke halaman sebelumnya
    </a>
    <form method="POST"
        action="{{ route('submission.update', ['type_id' => $submission->submission_type_id, 'id' => $submission->id]) }}"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @if ($errors->any())
            <x-alert-danger title="There were {{ $errors->count() }} errors with your submission" :messages="$errors->all()" />
        @endif
        <div class="bg-white shadow sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="py-1">
                    <div class="border-t border-gray-200">
                        <div x-show="tab === 'infoPengajuan'">
                            <dl>
                                @foreach ($infoPengajuan as $key => $value)
                                    <div
                                        class="{{ $loop->iteration % 2 === 0 ? 'bg-white' : 'bg-gray-200' }} px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt>
                                            {{ $key }}
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            @if ($key === 'Hasil Surat')
                                                @if ($submission->surat_keluar)
                                                    @if (pathinfo($submission->surat_keluar, PATHINFO_EXTENSION) === 'pdf')
                                                        <div class="flex items-center mb-4">
                                                            <a href="{{ route('submission.surat_keluar', $submission->id) }}"
                                                                target="_blank" class="ml-4 flex items-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-6 w-6 text-red-500" viewBox="0 0 20 20"
                                                                    fill="currentColor">
                                                                    <path fill-rule="evenodd"
                                                                        d="M5 2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7.414a1 1 0 0 0-.293-.707l-4.586-4.586A1 1 0 0 0 11.586 2H5zm5 2.5a1.5 1.5 0 0 1 1.5 1.5v3.793l1.146 1.147a.5.5 0 0 0 .708-.708L12.5 9.793V7a1.5 1.5 0 0 1 1.5-1.5h1.5a.5.5 0 0 0 0-1H5a.5.5 0 0 0-.5.5v12a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V7.414l-2.146-2.147a.5.5 0 0 0-.708 0l-2.147 2.147z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                                <span class="ml-2 text-blue-500 font-medium">Lihat
                                                                    PDF</span>
                                                            </a>
                                                        </div>
                                                    @else
                                                        <a href="{{ route('submission.surat_keluar', $submission->id) }}"
                                                            target="_blank">
                                                            <img src="{{ route('submission.surat_keluar', $submission->id) }}"
                                                                alt="Surat Keluar"
                                                                class="w-40 h-auto border border-gray-300 rounded">
                                                        </a>
                                                    @endif
                                                @else
                                                    <span>-</span>
                                                @endif
                                                <input type="file" name="surat_keluar" id="surat_keluar"
                                                    class="form-input rounded-md shadow-sm mt-1 block w-full border border-gray-300">
                                            @elseif(
                                                $key === 'ID Pengajuan' ||
                                                $key === 'Tipe Pengajuan' ||
                                                    $key === 'Tanggal Pengajuan' ||
                                                    $key === 'Nama' ||
                                                    $key === 'Tempat Lahir' ||
                                                    $key === 'Tanggal Lahir' ||
                                                    $key === 'Alamat' ||
                                                    $key === 'Nomor Handphone' ||
                                                    $key === 'Agama' ||
                                                    $key === 'Jenis Kelamin')
                                                {{ strip_tags($value) }}
                                            @elseif ($key === 'Status')
                                                {{-- Tambahkan kondisi ini --}}
                                                <select name="status"
                                                    class="form-select rounded-md shadow-sm mt-1 block w-full border border-gray-300">
                                                    <option value="Diproses"
                                                        {{ $submission->status == 'Diproses' ? 'selected' : '' }}>
                                                        Diproses
                                                    </option>
                                                    <option value="Selesai"
                                                        {{ $submission->status == 'Selesai' ? 'selected' : '' }}>
                                                        Selesai</option>
                                                    <option value="Ditolak"
                                                        {{ $submission->status == 'Ditolak' ? 'selected' : '' }}>
                                                        Ditolak</option>
                                                </select>
                                            @elseif ($key === 'Praktik Ke')
                                                <select name="praktik_ke"
                                                    class="form-select rounded-md shadow-sm mt-1 block w-full border border-gray-300">
                                                    <option value="1"
                                                        {{ $submission->submission_izin_praktik->praktik_ke == 1 ? 'selected' : '' }}>
                                                        1</option>
                                                    <option value="2"
                                                        {{ $submission->submission_izin_praktik->praktik_ke == 2 ? 'selected' : '' }}>
                                                        2</option>
                                                    <option value="3"
                                                        {{ $submission->submission_izin_praktik->praktik_ke == 3 ? 'selected' : '' }}>
                                                        3</option>
                                                </select>
                                            @elseif ($key === 'Tujuan Surat')
                                                <select name="tujuan_surat"
                                                    class="form-select rounded-md shadow-sm mt-1 block w-full border border-gray-300">
                                                    <option value="Pembuatan SIP"
                                                        {{ $submission->submission_izin_praktik->tujuan_surat == 'Pembuatan SIP' ? 'selected' : '' }}>
                                                        Pembuatan SIP</option>
                                                    <option value="Perpanjangan SIP"
                                                        {{ $submission->submission_izin_praktik->tujuan_surat == 'Perpanjangan SIP' ? 'selected' : '' }}>
                                                        Perpanjangan SIP</option>
                                                    <option value="Pindah Alamat SIP"
                                                        {{ $submission->submission_izin_praktik->tujuan_surat == 'Pindah Alamat SIP' ? 'selected' : ''}}>Pindah Alamat SIP</option>
                                                    </select>
                                            @else
                                                @php
                                                    $inputName = '';
                                                    if  ($key === 'Alumni') {
                                                        $inputName = 'alumni_drg';
                                                    } elseif ($key === 'Tahun Lulus') {
                                                        $inputName = 'tahun_lulus';
                                                    } elseif ($key === 'Nomor STR') {
                                                        $inputName = 'str';
                                                    } elseif ($key === 'Masa Berlaku STR') {
                                                        $inputName = 'valid_str';
                                                    } elseif ($key === 'Nomor Serkom') {
                                                        $inputName = 'serkom';
                                                    } elseif ($key === 'NPA') {
                                                        $inputName = 'npa';
                                                    } elseif ($key === 'Cabang PDGI') {
                                                        $inputName = 'cabang_pdgi';
                                                    } elseif ($key === 'Alamat Praktik Fakes Pertama') {
                                                        $inputName = 'alamat_fakes1';
                                                    } elseif ($key === 'Jadwal Praktik Fakes Pertama') {
                                                        $inputName = 'jadwal_praktik1';
                                                    } elseif ($key === 'Alamat Praktik Fakes Kedua') {
                                                        $inputName = 'alamat_fakes2';
                                                    } elseif ($key === 'Jadwal Praktik Fakes Kedua') {
                                                        $inputName = 'jadwal_praktik2';
                                                    } elseif ($key === 'Alamat Praktik Fakes Ketiga') {
                                                        $inputName = 'alamat_fakes3';
                                                    } elseif ($key === 'Jadwal Praktik Fakes Ketiga') {
                                                        $inputName = 'jadwal_praktik3';
                                                    }
                                                @endphp
                                                <input type="text" name="{{ $inputName }}"
                                                    value="{{ strip_tags($value) }}"
                                                    class="form-input rounded-md shadow-sm mt-1 block w-full border border-gray-300">
                                            @endif
                                        </dd>
                                    </div>
                                @endforeach
                                @foreach ($scanFiles as $key => $label)
                                    <div
                                        class="{{ $loop->iteration % 2 === 0 ? 'bg-white' : 'bg-gray-200' }} px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt>
                                            {{ $label }}
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            @if ($submission->submission_izin_praktik->{$key})
                                                <a href="{{ route('images.scan', ['type_id' => $submission->submission_type_id, 'scanFile' => $key, 'userId' => $submission->user_id, 'submissionId' => $submission->id]) }}"
                                                    target="_blank">
                                                    <img src="{{ route('images.scan', ['type_id' => $submission->submission_type_id, 'scanFile' => $key, 'userId' => $submission->user_id, 'submissionId' => $submission->id]) }}"
                                                        alt="{{ $label }}"
                                                        class="w-40 h-auto border border-gray-300 rounded">
                                                </a>
                                            @else
                                                <span>-</span>
                                            @endif
                                            <input type="file" name="{{ $key }}" id="{{ $key }}"
                                                class="form-input rounded-md shadow-sm mt-1 block w-full border border-gray-300">
                                        </dd>
                                    </div>
                                @endforeach
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <button type="submit"
                class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Update') }}
            </button>
        </div>
    </form>
</x-dashboard-layout>
