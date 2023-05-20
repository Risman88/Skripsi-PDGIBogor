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
            'NPA' => $submission->submission_ppdgs->npa,
            'Nama Universitas' => $submission->submission_ppdgs->nama_univ,
        ];
    @endphp
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pengajuan Surat Rekomendasi PPDGS') }}
            </h2>
        </x-slot>

        <a href="{{ url()->previous() }}" class="text-blue-600 hover:text-blue-800">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
            </svg> Kembali ke halaman sebelumnya
        </a>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                            <div class="py-1 text-center text-lg font-bold" >
                                    Informasi Pengajuan
                            </div>
                        </div>
                    <div class="border-t border-gray-200">
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
                    </div>
            </div>
        </div>
      </x-dashboard-layout>
