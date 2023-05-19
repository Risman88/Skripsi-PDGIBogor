<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Edit Dokumen Pengguna') }}
        </h2>
    </header>

    <form action="{{ route('users.updateDocument', $user->id) }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('PUT')
    <!-- Scan KTP -->
    <div>
        <x-input-label for="scan_ktp" :value="__('Scan KTP')" />
        @if ($user->userDocument && $user->userDocument->scan_ktp)
            @if (pathinfo($user->userDocument->scan_ktp, PATHINFO_EXTENSION) === 'pdf')
                <div class="flex items-center mb-4">
                    <a href="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_ktp']) }}"
                        target="_blank" class="ml-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5 2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7.414a1 1 0 0 0-.293-.707l-4.586-4.586A1 1 0 0 0 11.586 2H5zm5 2.5a1.5 1.5 0 0 1 1.5 1.5v3.793l1.146 1.147a.5.5 0 0 0 .708-.708L12.5 9.793V7a1.5 1.5 0 0 1 1.5-1.5h1.5a.5.5 0 0 0 0-1H5a.5.5 0 0 0-.5.5v12a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V7.414l-2.146-2.147a.5.5 0 0 0-.708 0l-2.147 2.147z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="ml-2 text-blue-500 font-medium">
                            Lihat PDF
                        </span>
                    </a>
                </div>
            @else
                <a href="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_ktp']) }}"
                    target="_blank">
                    <img src="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_ktp']) }}"
                        alt="Scan KTP" class="w-32 h-32 object-cover border-2 border-gray-300" />
                </a>
            @endif
        @else
            <span>-</span>
        @endif
        <input type="file" name="scan_ktp" id="scan_ktp"
        class="form-input rounded-md shadow-sm mt-1 block w-full border border-gray-300">
    </div>
    <!-- Scan S1 -->
    <div>
        <x-input-label for="scan_s1" :value="__('Scan Ijazah S1')" />
        @if ($user->userDocument && $user->userDocument->scan_s1)
            @if (pathinfo($user->userDocument->scan_s1, PATHINFO_EXTENSION) === 'pdf')
                <div class="flex items-center mb-4">
                    <a href="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_s1']) }}"
                        target="_blank" class="ml-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5 2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7.414a1 1 0 0 0-.293-.707l-4.586-4.586A1 1 0 0 0 11.586 2H5zm5 2.5a1.5 1.5 0 0 1 1.5 1.5v3.793l1.146 1.147a.5.5 0 0 0 .708-.708L12.5 9.793V7a1.5 1.5 0 0 1 1.5-1.5h1.5a.5.5 0 0 0 0-1H5a.5.5 0 0 0-.5.5v12a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V7.414l-2.146-2.147a.5.5 0 0 0-.708 0l-2.147 2.147z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="ml-2 text-blue-500 font-medium">
                            Lihat PDF
                        </span>
                    </a>
                </div>
            @else
                <a href="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_s1']) }}"
                    target="_blank">
                    <img src="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_s1']) }}"
                        alt="Scan S1" class="w-32 h-32 object-cover border-2 border-gray-300" />
                </a>
            @endif
        @else
            <span>-</span>
        @endif
        <input type="file" name="scan_s1" id="scan_s1"
        class="form-input rounded-md shadow-sm mt-1 block w-full border border-gray-300">
    </div>

    <!-- Scan S2 -->
    <div>
        <x-input-label for="scan_s2" :value="__('Scan Ijazah S2 (Optional)')" />
        @if ($user->userDocument && $user->userDocument->scan_s2)
            @if (pathinfo($user->userDocument->scan_s2, PATHINFO_EXTENSION) === 'pdf')
                <div class="flex items-center mb-4">
                    <a href="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_s2']) }}"
                        target="_blank" class="ml-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5 2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7.414a1 1 0 0 0-.293-.707l-4.586-4.586A1 1 0 0 0 11.586 2H5zm5 2.5a1.5 1.5 0 0 1 1.5 1.5v3.793l1.146 1.147a.5.5 0 0 0 .708-.708L12.5 9.793V7a1.5 1.5 0 0 1 1.5-1.5h1.5a.5.5 0 0 0 0-1H5a.5.5 0 0 0-.5.5v12a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V7.414l-2.146-2.147a.5.5 0 0 0-.708 0l-2.147 2.147z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="ml-2 text-blue-500 font-medium">
                            Lihat PDF
                        </span>
                    </a>
                </div>
            @else
                <a href="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_s2']) }}"
                    target="_blank">
                    <img src="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_s2']) }}"
                        alt="Scan S2" class="w-32 h-32 object-cover border-2 border-gray-300" />
                </a>
            @endif
        @else
            <span>-</span>
        @endif
        <input type="file" name="scan_s2" id="scan_s2"
        class="form-input rounded-md shadow-sm mt-1 block w-full border border-gray-300">
    </div>

    <!-- Scan DRG -->
    <div>
        <x-input-label for="scan_drg" :value="__('Scan Ijazah Dokter Gigi')" />
        @if ($user->userDocument && $user->userDocument->scan_drg)
            @if (pathinfo($user->userDocument->scan_drg, PATHINFO_EXTENSION) === 'pdf')
                <div class="flex items-center mb-4">
                    <a href="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_drg']) }}"
                        target="_blank" class="ml-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5 2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7.414a1 1 0 0 0-.293-.707l-4.586-4.586A1 1 0 0 0 11.586 2H5zm5 2.5a1.5 1.5 0 0 1 1.5 1.5v3.793l1.146 1.147a.5.5 0 0 0 .708-.708L12.5 9.793V7a1.5 1.5 0 0 1 1.5-1.5h1.5a.5.5 0 0 0 0-1H5a.5.5 0 0 0-.5.5v12a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V7.414l-2.146-2.147a.5.5 0 0 0-.708 0l-2.147 2.147z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="ml-2 text-blue-500 font-medium">
                            Lihat PDF
                        </span>
                    </a>
                </div>
            @else
                <a href="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_drg']) }}"
                    target="_blank">
                    <img src="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_drg']) }}"
                        alt="Scan DRG" class="w-32 h-32 object-cover border-2 border-gray-300" />
                </a>
            @endif
        @else
            <span>-</span>
        @endif
        <input type="file" name="scan_drg" id="scan_drg"
        class="form-input rounded-md shadow-sm mt-1 block w-full border border-gray-300">
    </div>

    <!-- Scan DRGSP -->
    <div>
        <x-input-label for="scan_drgsp" :value="__('Scan Ijazah Dokter Gigi Spesialis')" />
        @if ($user->userDocument && $user->userDocument->scan_drgsp)
            @if (pathinfo($user->userDocument->scan_drgsp, PATHINFO_EXTENSION) === 'pdf')
                <div class="flex items-center mb-4">
                    <a href="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_drgsp']) }}"
                        target="_blank" class="ml-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5 2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7.414a1 1 0 0 0-.293-.707l-4.586-4.586A1 1 0 0 0 11.586 2H5zm5 2.5a1.5 1.5 0 0 1 1.5 1.5v3.793l1.146 1.147a.5.5 0 0 0 .708-.708L12.5 9.793V7a1.5 1.5 0 0 1 1.5-1.5h1.5a.5.5 0 0 0 0-1H5a.5.5 0 0 0-.5.5v12a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V7.414l-2.146-2.147a.5.5 0 0 0-.708 0l-2.147 2.147z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="ml-2 text-blue-500 font-medium">
                            Lihat PDF
                        </span>
                    </a>
                </div>
            @else
                <a href="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_drgsp']) }}"
                    target="_blank">
                    <img src="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_drgsp']) }}"
                        alt="Scan DrgSp" class="w-32 h-32 object-cover border-2 border-gray-300" />
                </a>
            @endif
        @else
            <span>-</span>
        @endif
        <input type="file" name="scan_drgsp" id="scan_drgsp"
        class="form-input rounded-md shadow-sm mt-1 block w-full border border-gray-300">
    </div>
    <!-- Scan Foto -->
    <div>
        <x-input-label for="scan_foto" :value="__('Scan Foto')" />
        @if ($user->userDocument && $user->userDocument->scan_foto)
            @if (pathinfo($user->userDocument->scan_foto, PATHINFO_EXTENSION) === 'pdf')
                <div class="flex items-center mb-4">
                    <a href="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_foto']) }}"
                        target="_blank" class="ml-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5 2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7.414a1 1 0 0 0-.293-.707l-4.586-4.586A1 1 0 0 0 11.586 2H5zm5 2.5a1.5 1.5 0 0 1 1.5 1.5v3.793l1.146 1.147a.5.5 0 0 0 .708-.708L12.5 9.793V7a1.5 1.5 0 0 1 1.5-1.5h1.5a.5.5 0 0 0 0-1H5a.5.5 0 0 0-.5.5v12a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V7.414l-2.146-2.147a.5.5 0 0 0-.708 0l-2.147 2.147z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="ml-2 text-blue-500 font-medium">
                            Lihat PDF
                        </span>
                    </a>
                </div>
            @else
                <a href="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_foto']) }}"
                    target="_blank">
                    <img src="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_foto']) }}"
                        alt="Scan Foto" class="w-32 h-32 object-cover border-2 border-gray-300" />
                </a>
            @endif
        @else
            <span>-</span>
        @endif
        <input type="file" name="scan_foto" id="scan_foto"
        class="form-input rounded-md shadow-sm mt-1 block w-full border border-gray-300">
    </div>
    <!-- Scan KTA -->
    <div>
        <x-input-label for="scan_kta" :value="__('Scan KTA')" />
        @if ($user->userDocument && $user->userDocument->scan_kta)
            @if (pathinfo($user->userDocument->scan_kta, PATHINFO_EXTENSION) === 'pdf')
                <div class="flex items-center mb-4">
                    <a href="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_kta']) }}"
                        target="_blank" class="ml-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5 2a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7.414a1 1 0 0 0-.293-.707l-4.586-4.586A1 1 0 0 0 11.586 2H5zm5 2.5a1.5 1.5 0 0 1 1.5 1.5v3.793l1.146 1.147a.5.5 0 0 0 .708-.708L12.5 9.793V7a1.5 1.5 0 0 1 1.5-1.5h1.5a.5.5 0 0 0 0-1H5a.5.5 0 0 0-.5.5v12a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V7.414l-2.146-2.147a.5.5 0 0 0-.708 0l-2.147 2.147z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="ml-2 text-blue-500 font-medium">
                            Lihat PDF
                        </span>
                    </a>
                </div>
            @else
                <a href="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_kta']) }}"
                    target="_blank">
                    <img src="{{ route('user_document.show', ['userId' => $user->id, 'scanFile' => 'scan_kta']) }}"
                        alt="Scan KTA" class="w-32 h-32 object-cover border-2 border-gray-300" />
                </a>
            @endif
        @else
            <span>-</span>
        @endif
        <input type="file" name="scan_kta" id="scan_kta"
        class="form-input rounded-md shadow-sm mt-1 block w-full border border-gray-300">
    </div>
    <x-primary-button class="mt-2">
        {{ __('Perbarui') }}
    </x-primary-button>
</form>
</section>
