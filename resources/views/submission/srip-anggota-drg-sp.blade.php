<x-dashboard-layout>
    <x-slot name="header">
        {{ __('Pengajuan Surat Rekomendasi Izin Praktik Dokter Gigi Spesialis untuk Anggota PDGI Kota Bogor') }}
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
                        <x-input-label for="praktik_ke" :value="__('Praktik Ke')" :required="true" />
                        <select name="praktik_ke" class="w-full px-4 py-2 border border-gray-300 rounded" required>
                            <option value="">Pilih Praktik Ke</option>
                            <option value="1" {{ old('praktik_ke') == '1' ? 'selected' : '' }}>1</option>
                            <option value="2" {{ old('praktik_ke') == '2' ? 'selected' : '' }}>2</option>
                            <option value="3" {{ old('praktik_ke') == '3' ? 'selected' : '' }}>3</option>
                        </select>
                        <x-input-error :messages="$errors->get('praktik_ke')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div>
                        <x-input-label for="tujuan_surat" :value="__('Tujuan Surat')" :required="true" />
                        <select name="tujuan_surat" class="w-full px-4 py-2 border border-gray-300 rounded" required>
                            <option value="">Pilih Tujuan Surat</option>
                            <option value="Pembuatan SIP" {{ old('tujuan_surat') == 'Pembuatan SIP' ? 'selected' : '' }}>Pembuatan SIP</option>
                            <option value="Perpanjangan SIP" {{ old('tujuan_surat') == 'Perpanjangan SIP' ? 'selected' : '' }}>Perpanjangan SIP</option>
                            <option value="Pindah Alamat SIP" {{ old('tujuan_surat') == 'Pindah Alamat SIP' ? 'selected' : '' }}>Pindah Alamat SIP</option>
                        </select>
                        <x-input-error :messages="$errors->get('tujuan_surat')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div>
                        <x-input-label for="alumni_drg" :value="__('Alumni Dokter Gigi')" :required="true" />
                        <x-text-input type="text" name="alumni_drg" :value="old('alumni_drg')" class="w-full px-4 py-2 border border-gray-300 rounded" required />
                        <x-input-error :messages="$errors->get('alumni_drg')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div>
                        <x-input-label for="tahun_lulus" :value="__('Tahun Lulus')" :required="true" />
                        <x-text-input type="number" name="tahun_lulus" :value="old('tahun_lulus')" class="w-full px-4 py-2 border border-gray-300 rounded" required />
                        <x-input-error :messages="$errors->get('tahun_lulus')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div>
                        <x-input-label for="str" :value="__('Nomor STR')" :required="true" />
                        <x-text-input type="text" name="str" :value="old('str')" class="w-full px-4 py-2 border border-gray-300 rounded" required />
                        <x-input-error :messages="$errors->get('str')" class="mt-2 text-sm text-red-600" />
                    </div>
                    <div>
                        <x-input-label for="valid_str" :value="__('Valid STR')" :required="!old('seumur_hidup')" />
                        <span class="text-gray-500 text-sm px-1 inline-block">Apabila STR sudah seumur hidup tidak perlu
                            mengisi tanggal hanya ceklis checkbox</span>
                        <x-text-input type="date" name="valid_str" :value="old('valid_str')"
                            class="w-full px-4 py-2 border border-gray-300 rounded" required
                            :disabled="old('seumur_hidup') ? 'checked' : ''" />
                            <label class="flex items-center mt-2">
                                <span class="px-2 text-sm font-bold text-gray-600">STR Seumur Hidup</span>
                                <input type="hidden" name="seumur_hidup" value="0">
                                <input type="checkbox" name="seumur_hidup" class="form-checkbox" id="seumur_hidup"
                                    {{ old('seumur_hidup', false) ? 'checked' : '' }} value="1">
                            </label>
                        <x-input-error :messages="$errors->get('valid_str')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <script>
                        document.getElementById('seumur_hidup').addEventListener('change', function() {
                            var validStrInput = document.getElementsByName('valid_str')[0];
                            validStrInput.disabled = this.checked;
                            validStrInput.required = !this.checked;
                        });
                    </script>
                    <div>
                        <x-input-label for="scan_str" :value="__('Scan STR')" :required=true />
                        <input type="file" name="scan_str" class="w-full px-4 py-2 border border-gray-300 rounded" required>
                        <span class= "text-gray-500 text-sm px-1 inline-block">(maksimal ukuran file: 1024 KB, format file: png, jpg, jpeg, atau pdf)</span>
                        <x-input-error :messages="$errors->get('scan_str')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="serkom" :value="__('Nomor Serkom')" :required="true" />
                        <x-text-input type="text" name="serkom" :value="old('serkom')" class="w-full px-4 py-2 border border-gray-300 rounded" required />
                        <x-input-error :messages="$errors->get('serkom')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div>
                        <x-input-label for="scan_serkom" :value="__('Scan Serkom')" :required=true />
                        <input type="file" name="scan_serkom" class="w-full px-4 py-2 border border-gray-300 rounded" required>
                        <span class= "text-gray-500 text-sm px-1 inline-block">(maksimal ukuran file: 1024 KB, format file: png, jpg, jpeg, atau pdf)</span>
                        <x-input-error :messages="$errors->get('scan_serkom')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="npa" :value="__('Nomor NPA')" :required="true" />
                        <x-text-input type="text" name="npa" :value="old('npa')" class="w-full px-4 py-2 border border-gray-300 rounded" required />
                        <x-input-error :messages="$errors->get('npa')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div>
                        <x-input-label for="cabang_pdgi" :value="__('Cabang PDGI')" :required="true" />
                        <x-text-input type="text" name="cabang_pdgi" :value="old('cabang_pdgi')" class="w-full px-4 py-2 border border-gray-300 rounded" required />
                        <x-input-error :messages="$errors->get('cabang_pdgi')" class="mt-2 text-sm text-red-600" />
                    </div>
                    <div>
                        <x-input-label for="alamat_fakes1" :value="__('Alamat Fakes 1')" />
                        <textarea name="alamat_fakes1" class="w-full px-4 py-2 border border-gray-300 rounded">{{ old('alamat_fakes1') }}</textarea>
                        <x-input-error :messages="$errors->get('alamat_fakes1')" class="mt-2 text-sm text-red-600" />
                    </div>
                    <div>
                        <x-input-label for="jadwal_praktik1" :value="__('Jadwal Praktik 1')" />
                        <textarea name="jadwal_praktik1" class="w-full px-4 py-2 border border-gray-300 rounded">{{ old('jadwal_praktik1') }}</textarea>
                        <x-input-error :messages="$errors->get('jadwal_praktik1')" class="mt-2 text-sm text-red-600" />
                    </div>
                    <div>
                        <x-input-label for="surat_praktik1" :value="__('SIP / Surat Izin / Surat Keterangan 1')" />
                        <input type="file" name="surat_praktik1" class="w-full px-4 py-2 border border-gray-300 rounded" accept=".png,.jpg,.jpeg,.pdf">
                        <span class= "text-gray-500 text-sm px-1 inline-block">(maksimal ukuran file: 1024 KB, format file: png, jpg, jpeg, atau pdf)</span>
                        <x-input-error :messages="$errors->get('surat_praktik1')" class="mt-2 text-sm text-red-600" />
                    </div>
                    <div>
                        <x-input-label for="alamat_fakes2" :value="__('Alamat Fakes 2')" />
                        <textarea name="alamat_fakes2" class="w-full px-4 py-2 border border-gray-300 rounded">{{ old('alamat_fakes2') }}</textarea>
                        <x-input-error :messages="$errors->get('alamat_fakes2')" class="mt-2 text-sm text-red-600" />
                    </div>
                    <div>
                        <x-input-label for="jadwal_praktik2" :value="__('Jadwal Praktik 2')" />
                        <textarea name="jadwal_praktik2" class="w-full px-4 py-2 border border-gray-300 rounded">{{ old('jadwal_praktik2') }}</textarea>
                        <x-input-error :messages="$errors->get('jadwal_praktik2')" class="mt-2 text-sm text-red-600" />
                    </div>
                    <div>
                        <x-input-label for="surat_praktik2" :value="__('SIP / Surat Izin / Surat Keterangan Praktik 2')" />
                        <input type="file" name="surat_praktik2" class="w-full px-4 py-2 border border-gray-300 rounded" accept=".png,.jpg,.jpeg,.pdf">
                        <span class= "text-gray-500 text-sm px-1 inline-block">(maksimal ukuran file: 1024 KB, format file: png, jpg, jpeg, atau pdf)</span>
                        <x-input-error :messages="$errors->get('surat_praktik2')" class="mt-2 text-sm text-red-600" />
                    </div>
                    <div>
                        <x-input-label for="alamat_fakes3" :value="__('Alamat Fakes 3')" />
                        <textarea name="alamat_fakes3" class="w-full px-4 py-2 border border-gray-300 rounded">{{ old('alamat_fakes3') }}</textarea>
                        <x-input-error :messages="$errors->get('alamat_fakes3')" class="mt-2 text-sm text-red-600" />
                    </div>
                    <div>
                        <x-input-label for="jadwal_praktik3" :value="__('Jadwal Praktik 3')" />
                        <textarea name="jadwal_praktik3" class="w-full px-4 py-2 border border-gray-300 rounded">{{ old('jadwal_praktik3') }}</textarea>
                        <x-input-error :messages="$errors->get('jadwal_praktik3')" class="mt-2 text-sm text-red-600" />
                    </div>
                    <div>
                        <x-input-label for="surat_praktik3" :value="__('SIP / Surat Izin / Surat Keterangan Praktik 3')" />
                        <input type="file" name="surat_praktik3" class="w-full px-4 py-2 border border-gray-300 rounded" accept=".png,.jpg,.jpeg,.pdf">
                        <span class= "text-gray-500 text-sm px-1 inline-block">(maksimal ukuran file: 1024 KB, format file: png, jpg, jpeg, atau pdf)</span>
                        <x-input-error :messages="$errors->get('surat_praktik3')" class="mt-2 text-sm text-red-600" />
                    </div>

                    <div>
                        <x-input-label for="scan_surat_sehat" :value="__('Scan Surat Sehat')" :required=true />
                        <input type="file" name="scan_surat_sehat" class="w-full px-4 py-2 border border-gray-300 rounded" required>
                        <span class= "text-gray-500 text-sm px-1 inline-block">(maksimal ukuran file: 1024 KB, format file: png, jpg, jpeg, atau pdf)</span>
                        <x-input-error :messages="$errors->get('scan_surat_sehat')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="scan_surat_kolegium" :value="__('Scan Surat Kolegium')"  :required=true />
                        <input type="file" name="scan_surat_kolegium" class="w-full px-4 py-2 border border-gray-300 rounded">
                        <span class= "text-gray-500 text-sm px-1 inline-block">(maksimal ukuran file: 1024 KB, format file: png, jpg, jpeg, atau pdf)</span>
                        <x-input-error :messages="$errors->get('scan_surat_kolegium')" class="mt-2" />
                    </div>

                    <button type="submit" class="w-full py-2 bg-gray-800 text-white font-bold rounded mt-4">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
</x-dashboard-layout>
