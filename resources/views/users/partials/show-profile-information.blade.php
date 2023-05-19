<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Informasi Profile') }}
        </h2>
    </header>

    <div class="mt-6 space-y-6">
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <div class="mt-1 text-sm text-gray-600">
                {{ $user->name }}
            </div>
        </div>

        <div>
            <x-input-label for="name" :value="__('Masa berlaku iuran sampai')" />
            <div class="mt-1 text-sm text-gray-600">
                {{ \Carbon\Carbon::parse($user->iuran_until)->format('d F Y') }}
            </div>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <div class="mt-1 text-sm text-gray-600">
                {{ $user->email }}
            </div>
        </div>
        <!-- Tempat Lahir -->
        <div>
            <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
            <div class="mt-1 text-sm text-gray-600">
                {{ $user->tempat_lahir }}
            </div>
        </div>

        <!-- Tanggal Lahir -->
        <div>
            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
            <div class="mt-1 text-sm text-gray-600">
                {{ \Carbon\Carbon::parse($user->tanggal_lahir)->format('d F Y') }}
            </div>
        </div>

        <!-- Jenis Kelamin -->
        <div>
            <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
            <div class="mt-1 text-sm text-gray-600">
                {{ $user->jenis_kelamin }}
            </div>
        </div>
        <!-- Agama -->
        <div>
            <x-input-label for="agama" :value="__('Agama')" />
            <div class="mt-1 text-sm text-gray-600">
                {{ $user->agama }}
            </div>
        </div>
        <!-- Alamat -->
        <div>
            <x-input-label for="alamat" :value="__('Alamat')" />
            <div class="mt-1 text-sm text-gray-600">
                {{ $user->alamat }}
            </div>
        </div>

        <!-- Handphone -->
        <div>
            <x-input-label for="handphone" :value="__('Handphone')" />
            <div class="mt-1 text-sm text-gray-600">
                {{ $user->handphone }}
            </div>
        </div>
    </div>
</section>
