<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Dokumen Pengguna') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Unggah dokumen yang diperlukan. Anda tidak dapat mengubah dokumen setelah diunggah. Apabila ada kesalahan unggah dokumen hubungi Pengurus') }}
        </p>
    </header>

    <form method="post" action="{{ route('user_document.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <div>
            <x-input-label for="scan_ktp" :value="__('Scan KTP')" />
            @if ($user->userDocument && $user->userDocument->scan_ktp)
                <img src="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_ktp']) }}"
                    alt="Scan KTP" class="w-32 h-32 object-cover border-2 border-gray-300" />
            @else
                <input type="file" id="scan_ktp" name="scan_ktp" class="mt-1 block w-full border border-gray-300">
                <x-input-error class="mt-2" :messages="$errors->get('scan_ktp')" />
            @endif
        </div>
        <!-- Scan S1 -->
        <div>
            <x-input-label for="scan_s1" :value="__('Scan Ijazah S1')" />
            @if ($user->userDocument && $user->userDocument->scan_s1)
                <img src="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_s1']) }}"
                    alt="Scan S1" class="w-32 h-32 object-cover border-2 border-gray-300" />
            @else
                <input type="file" id="scan_s1" name="scan_s1" class="mt-1 block w-full border border-gray-300">
                <x-input-error class="mt-2" :messages="$errors->get('scan_s1')" />
            @endif
        </div>

        <!-- Scan S2 -->
        <div>
            <x-input-label for="scan_s2" :value="__('Scan Ijazah S2 (Optional)')" />
            @if ($user->userDocument && $user->userDocument->scan_s2)
                <img src="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_s2']) }}"
                    alt="Scan S2" class="w-32 h-32 object-cover border-2 border-gray-300" />
            @else
                <input type="file" id="scan_s2" name="scan_s2" class="mt-1 block w-full border border-gray-300">
                <x-input-error class="mt-2" :messages="$errors->get('scan_s2')" />
            @endif
        </div>

        <!-- Scan DRG -->
        <div>
            <x-input-label for="scan_drg" :value="__('Scan Ijazah Dokter Gigi')" />
            @if ($user->userDocument && $user->userDocument->scan_drg)
                <img src="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_drg']) }}"
                    alt="Scan Drg" class="w-32 h-32 object-cover border-2 border-gray-300" />
            @else
                <input type="file" id="scan_drg" name="scan_drg" class="mt-1 block w-full border border-gray-300">
                <x-input-error class="mt-2" :messages="$errors->get('scan_drg')" />
            @endif
        </div>

        <!-- Scan DRGSP -->
        <div>
            <x-input-label for="scan_drgsp" :value="__('Scan Ijazah Dokter Gigi Spesialis')" />
            @if ($user->userDocument && $user->userDocument->scan_drgsp)
                <img src="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_drgsp']) }}"
                    alt="Scan DrgSp" class="w-32 h-32 object-cover border-2 border-gray-300" />
            @else
                <input type="file" id="scan_drgsp" name="scan_drgsp"
                    class="mt-1 block w-full border border-gray-300">
                <x-input-error class="mt-2" :messages="$errors->get('scan_drgsp')" />
            @endif
        </div>

        <!-- Scan Foto -->
        <div>
            <x-input-label for="scan_foto" :value="__('Scan Foto')" />
            @if ($user->userDocument && $user->userDocument->scan_foto)
                <img src="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_foto']) }}"
                    alt="Scan Foto" class="w-32 h-32 object-cover border-2 border-gray-300" />
            @else
                <input type="file" id="scan_foto" name="scan_foto" class="mt-1 block w-full border border-gray-300">
                <x-input-error class="mt-2" :messages="$errors->get('scan_foto')" />
            @endif
        </div>
        <div>
            <x-input-label for="scan_kta" :value="__('Scan KTA')" />
            @if ($user->userDocument && $user->userDocument->scan_kta)
                <img src="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_kta']) }}"
                    alt="Scan KTA" class="w-32 h-32 object-cover border-2 border-gray-300" />
            @else
                <input type="file" id="scan_kta" name="scan_kta" class="mt-1 block w-full border border-gray-300">
                <x-input-error class="mt-2" :messages="$errors->get('scan_kta')" />
            @endif
        </div>
        <div class="flex items-center gap-4">
            @if (
                !$user->userDocument ||
                    (!$user->userDocument->scan_s1 ||
                        !$user->userDocument->scan_drg ||
                        !$user->userDocument->scan_foto ||
                        !$user->userDocument->scan_drgsp ||
                        !$user->userDocument->scan_s2 ||
                        !$user->userDocument->scan_ktp ||
                        !$user->userDocument->scan_kta))
                <x-primary-button>{{ __('Save') }}</x-primary-button>
            @endif
        </div>
    </form>
</section>
