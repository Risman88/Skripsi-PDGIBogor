<x-dashboard-layout>
    <x-slot name="header">
        {{ __('Pengajuan Menjadi Anggota PDGI Kota Bogor') }}
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
                <!-- Step 1 -->
                <div class="space-y-4">
                    <!-- Fields -->
                    <div>
                        <x-input-label for="str" :value="__('Nomor STR')" :required=true />
                        <x-text-input type="text" name="str" value="{{ old('str') }}" class="w-full px-4 py-2 border" />
                        <x-input-error :messages="$errors->get('str')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="serkom" :value="__('Nomor Serkom')" :required=true />
                        <x-text-input type="text" name="serkom" value="{{ old('serkom') }}" class="w-full px-4 py-2 border" required/>
                        <x-input-error :messages="$errors->get('serkom')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="scan_str" :value="__('Scan STR')" :required=true />
                        <input type="file" name="scan_str" class="w-full px-4 py-2 border border-gray-300 rounded" required>
                        <span class= "text-gray-500 text-sm px-1 inline-block">(maksimal ukuran file: 1024 KB, format file: png, jpg, jpeg, atau pdf)</span>
                        <x-input-error :messages="$errors->get('scan_str')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="scan_serkom" :value="__('Scan Serkom')" :required=true />
                        <input type="file" name="scan_serkom" class="w-full px-4 py-2 border border-gray-300 rounded" required>
                        <span class= "text-gray-500 text-sm px-1 inline-block">(maksimal ukuran file: 1024 KB, format file: png, jpg, jpeg, atau pdf)</span>
                        <x-input-error :messages="$errors->get('scan_serkom')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="cabang_mutasi" :value="__('Pindahan dari Cabang')" />
                        <x-text-input type="text" name="cabang_mutasi" value="{{ old('cabang_mutasi') }}" class="w-full px-4 py-2 border"/>
                        <x-input-error :messages="$errors->get('cabang_mutasi')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="scan_mutasi" :value="__('Scan Surat Mutasi')"  />
                        <input type="file" name="scan_mutasi" class="w-full px-4 py-2 border border-gray-300 rounded">
                        <span class= "text-gray-500 text-sm px-1 inline-block">(maksimal ukuran file: 1024 KB, format file: png, jpg, jpeg, atau pdf)</span>
                        <x-input-error :messages="$errors->get('scan_mutasi')" class="mt-2" />
                    </div>
                </div>
                    <button type="submit" class="w-full py-2 bg-gray-800 text-white font-bold rounded mt-4">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
</x-dashboard-layout>
