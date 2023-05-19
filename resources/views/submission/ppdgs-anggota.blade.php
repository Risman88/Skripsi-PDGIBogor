<x-dashboard-layout>
    <x-slot name="header">
        {{ __('Pengajuan Surat PPDGS untuk Anggota PDGI Kota Bogor') }}
    </x-slot>

        <div class="w-full max-w-md mx-auto">
            <div class="bg-indigo-300 p-2 text-black text-2xl font-bold text-center mb-4 rounded">
                <span>Data Pengajuan</span>
            </div>
            <form action="{{ route('submission.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="submission_type" value="{{ $submissionType }}">
                @if ($errors->any())
                <x-alert-danger title="There were {{ $errors->count() }} errors with your submission" :messages="$errors->all()" />
                @endif
                <div class="space-y-4">
                    <div>
                        <x-input-label for="npa" :value="__('Nomor NPA')" :required="true" />
                        <x-text-input type="text" name="npa" :value="old('npa')" class="w-full px-4 py-2 border border-gray-300 rounded" required />
                        <x-input-error :messages="$errors->get('npa')" class="mt-2 text-sm text-red-600" />
                    </div>
                    <div>
                        <x-input-label for="nama_univ" :value="__('Nama Universitas')" :required="true" />
                        <x-text-input type="text" name="nama_univ" :value="old('nama_univ')" class="w-full px-4 py-2 border border-gray-300 rounded" required />
                        <x-input-error :messages="$errors->get('nama_univ')" class="mt-2 text-sm text-red-600" />
                    </div>
                    <button type="submit" class="w-full py-2 bg-gray-800 text-white font-bold rounded mt-4">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
</x-dashboard-layout>
