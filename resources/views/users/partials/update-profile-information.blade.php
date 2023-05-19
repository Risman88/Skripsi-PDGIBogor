<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Edit Informasi Pengguna') }}
        </h2>
    </header>
    <form action="{{ route('users.updateProfile', $user->id) }}" method="POST" enctype="multipart/form-data"
        class="mt-6 space-y-6">
        @csrf
        @method('PUT')
        <div class="mt-6 space-y-6">
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                    required autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="iuran_until" :value="__('Masa berlaku iuran sampai')" />
                <div class="mt-1 text-sm text-gray-600">
                    {{ \Carbon\Carbon::parse($user->iuran_until)->format('d F Y') }}
                </div>
            </div>
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">{{ __('Peran') }}</label>
                <select name="role" id="role" required
                    class="mt-1 block w-full py-2 px-3 border border-black bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @foreach ($roles as $role)
                        <option value="{{ $role->name }}"
                            {{ $user->roles->first()->name === $role->name ? 'selected' : '' }}>{{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="text" class="mt-1 block w-full"
                :value="old('email', $user->email)" required autocomplete="email" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>
            <!-- Tempat Lahir -->
            <div>
                <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                <x-text-input id="tempat_lahir" name="tempat_lahir" type="text" class="mt-1 block w-full"
                    :value="old('tempat_lahir', $user->tempat_lahir)" required autocomplete="tempat_lahir" />
                <x-input-error class="mt-2" :messages="$errors->get('tempat_lahir')" />
            </div>

            <!-- Tanggal Lahir -->
            <div>
                <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                <x-text-input type="date" name="tanggal_lahir" :value="old('tanggal_lahir', $user->tanggal_lahir)"
                    class="w-full px-4 py-2 border border-gray-300 rounded" required autocomplete="tanggal_lahir" />
                <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Jenis Kelamin -->
            <div>
                <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                <select id="jenis_kelamin" name="jenis_kelamin" class="block mt-1 w-full border border-black">
                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                    </option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                    </option>
                </select>
            </div>
            <!-- Agama -->
            <div>
                <x-input-label for="agama" :value="__('Agama')" />
                <x-text-input id="agama" name="agama" type="text" class="mt-1 block w-full" :value="old('agama', $user->agama)"
                    required autocomplete="agama" />
                <x-input-error class="mt-2" :messages="$errors->get('agama')" />
            </div>
            <!-- Alamat -->
            <div>
                <x-input-label for="alamat" :value="__('Alamat')" />
                <x-text-input id="alamat" name="alamat" type="text" class="mt-1 block w-full" :value="old('alamat', $user->alamat)"
                    required autocomplete="alamat" />
                <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
            </div>

            <!-- Handphone -->
            <div>
                <x-input-label for="handphone" :value="__('Handphone')" />
                <x-text-input id="handphone" name="handphone" type="text" class="mt-1 block w-full"
                    :value="old('handphone', $user->handphone)" required autocomplete="handphone" />
                <x-input-error class="mt-2" :messages="$errors->get('handphone')" />
            </div>
        </div>
        <x-primary-button class="mt-2">
            {{ __('Perbarui') }}
        </x-primary-button>
    </form>
</section>
