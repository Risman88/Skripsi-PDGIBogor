<x-dashboard-layout>
    @php
        $infoPengajuan = [
            'ID Pengajuan' => $submission->id,
            'Tipe Pengajuan' => $submission->submissionType->name,
            'Tanggal Pengajuan' => $submission->created_at,
            'Status' => $submission->status,
            'Nama' => $submission->user->name,
            'Tempat Lahir' => $submission->user->tempat_lahir,
            'Tanggal Lahir' => \Carbon\Carbon::parse($submission->user->tanggal_lahir)->format('d-F-Y'),
            'Jenis Kelamin' => $submission->user->jenis_kelamin,
            'Alamat' => $submission->user->alamat,
            'Nomor Handphone' => $submission->user->handphone,
            'Agama' => $submission->user->agama,
            'Nomor STR' => $submission->submission_anggota->str,
            'Nomor Serkom' => $submission->submission_anggota->serkom,
            'Mutasi dari Cabang' => $submission->submission_anggota->cabang_mutasi,
        ];
        $scanFiles = [
            'scan_serkom' => 'Scan Serkom',
            'scan_str' => 'Scan STR',
            'scan_mutasi' => 'Scan Surat Mutasi Cabang Asal',
        ];
    @endphp
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pengajuan Anggota') }}
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
                <!-- ... (kode yang sama dengan tampilan anggota) ... -->
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
                                            @if(
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
                                                    class="form-select rounded-md shadow-sm mt-1 block w-full border border-gray-500">
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
                                            @else
                                                @php
                                                    $inputName = '';
                                                    if ($key === 'Mutasi dari Cabang') {
                                                        $inputName = 'cabang_mutasi';
                                                    } elseif ($key === 'Nomor STR') {
                                                        $inputName = 'str';
                                                    } elseif ($key === 'Nomor Serkom') {
                                                        $inputName = 'serkom';
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
                                            @if ($submission->submission_anggota->{$key})
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
