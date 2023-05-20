<x-dashboard-layout>
    @php
        $infoPengajuan = [
            'ID Pengajuan' => $submission->id,
            'Tipe Pengajuan' => $submission->submissionType->name,
            'Tanggal Pengajuan' => $submission->created_at->format('d-F-Y H:i:s'),
            'Status' => $submission->status === 'Selesai' ? '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>' : ($submission->status === 'Diproses' ? '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Diproses</span>' : '<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>'),
            'Nama' => $submission->user->name,
            'Tempat Lahir' => $submission->user->tempat_lahir,
            'Tanggal Lahir' => \Carbon\Carbon::parse($submission->user->tanggal_lahir)->format('d-F-Y'),
            'Jenis Kelamin' => $submission->user->jenis_kelamin,
            'Alamat' => $submission->user->alamat,
            'Nomor Handphone' => $submission->user->handphone,
            'Agama' => $submission->user->agama,
            'Nomor STR' => $submission->submission_anggota->str,
            'Nomor Serkom' => $submission->submission_anggota->serkom,
            'Mutasi dari cabang' => $submission->submission_anggota->cabang_mutasi ?? '-',
        ];
    @endphp
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pengajuan Anggota') }}
        </h2>
    </x-slot>

    <a href="{{ redirect()->back() }}" class="text-blue-600 hover:text-blue-800">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
        </svg> Kembali ke halaman sebelumnya
    </a>
    <div x-data="{ tab: 'infoPengajuan', dropdownOpen: false }" class="bg-white shadow sm:rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <div class="relative inline-block text-left">
                <button x-on:click="dropdownOpen = !dropdownOpen" type="button"
                    class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    id="options-menu" aria-haspopup="true" x-bind:aria-expanded="dropdownOpen">
                    <span x-text="tab === 'infoPengajuan' ? 'Informasi Pengajuan' : 'Kumpulan Berkas'"></span>
                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M10 12a1 1 0 01-.707-.293l-3-3a1 1 0 111.414-1.414L10 9.586l2.293-2.293a1 1 0 011.414 1.414l-3 3A1 1 0 0110 12z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                    class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                    role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                    <div class="py-1" role="none">
                        <button @click="tab = 'infoPengajuan'; dropdownOpen = false"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none"
                            role="menuitem">
                            Informasi Pengajuan
                        </button>
                        <button @click="tab = 'kumpulanBerkas'; dropdownOpen = false"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none"
                            role="menuitem">
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
                                <div
                                    class="{{ $loop->iteration % 2 === 0 ? 'bg-white' : 'bg-gray-200' }} px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
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
                                'scan_drgsp' => ['label' => 'Ijazah Spesialis', 'type' => 'user_document'],
                                'scan_ktp' => ['label' => 'KTP', 'type' => 'user_document'],
                                'scan_foto' => ['label' => 'Foto Diri', 'type' => 'user_document'],
                                'scan_serkom' => ['label' => 'Serkom', 'type' => 'submission_anggota'],
                                'scan_str' => ['label' => 'STR', 'type' => 'submission_anggota'],
                                'scan_mutasi' => ['label' => 'Surat Mutasi Cabang Asal', 'type' => 'submission_anggota'],
                            ];
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
                                            {{-- Tampilkan gambar dari tabel submission_anggota --}}
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
