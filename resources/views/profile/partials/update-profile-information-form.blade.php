<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Profile') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Untuk mengganti informasi profile anda, hubungi Pengurus") }}
        </p>
    </header>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <div class="mt-1 text-sm text-gray-600">{{ $user->name }}</div>
        </div>
        @can('iuran')
        <div>
            <x-input-label for="iuran_until" :value="__('Masa berlaku iuran sampai')" />
            <div class="mt-1 text-sm text-gray-600">{{ \Carbon\Carbon::parse($user->iuran_until)->format('d F Y') }}</div>
        </div>
        @endcan

        <!-- Tempat Lahir -->
        <div>
            <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
            <div class="mt-1 text-sm text-gray-600">{{ $user->tempat_lahir }}</div>
        </div>

        <!-- Tanggal Lahir -->
        <div>
            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
            <div class="mt-1 text-sm text-gray-600">{{ \Carbon\Carbon::parse($user->tanggal_lahir)->format('d F Y') }}</div>
        </div>

        <!-- Jenis Kelamin -->
        <div>
            <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
            <div class="mt-1 text-sm text-gray-600">{{ $user->jenis_kelamin }}</div>
        </div>
        <!-- Agama -->
        <div>
            <x-input-label for="agama" :value="__('Agama')" />
            <div class="mt-1 text-sm text-gray-600">{{ $user->agama }}</div>
        </div>
        <!-- Alamat -->
        <div>
            <x-input-label for="alamat" :value="__('Alamat')" />
            <div class="mt-1 text-sm text-gray-600">{{ $user->alamat }}</div>
        </div>

        <!-- Handphone -->
        <div>
            <x-input-label for="handphone" :value="__('Handphone')" />
            <div class="mt-1 text-sm text-gray-600">{{ $user->handphone }}</div>
        </div>
</section>
