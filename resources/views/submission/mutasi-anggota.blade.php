<x-dashboard-layout>
    <x-slot name="header">
        {{ __('Pengajuan Surat Mutasi untuk Anggota PDGI Kota Bogor') }}
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
                        <x-input-label for="mutasi_ke" :value="__('Mutasi Ke Cabang')" :required="true" />
                        <x-text-input type="text" name="mutasi_ke" :value="old('mutasi_ke')" class="w-full px-4 py-2 border border-gray-300 rounded" required />
                        <x-input-error :messages="$errors->get('mutasi_ke')" class="mt-2 text-sm text-red-600" />
                    </div>
                    <div>
                        <x-input-label for="alasan_mutasi" :value="__('Alasan Mutasi')" :required="true" />
                        <textarea name="alasan_mutasi" class="w-full px-4 py-2 border border-gray-300 rounded">{{ old('alasan_mutasi') }}</textarea>
                        <x-input-error :messages="$errors->get('alasan_mutasi')" class="mt-2 text-sm text-red-600" />
                    </div>
                    <button type="submit" class="w-full py-2 bg-gray-800 text-white font-bold rounded mt-4">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
</x-dashboard-layout>
