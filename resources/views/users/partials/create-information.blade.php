<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile') }}
        </h2>
    </header>

    <div class="mt-6 space-y-6">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            @if ($errors->any())
                <x-alert-danger title="There were {{ $errors->count() }} errors with your submission"
                    :messages="$errors->all()" />
            @endif
            <div>
                <x-input-label for="name" :value="__('Name')" :required="true" />
                <x-text-input type="text" name="name" :value="old('name')"
                    class="w-full px-4 py-2 border border-gray-300 rounded" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
            </div>

            <div>
                <x-input-label for="email" :value="__('Email')" :required="true" />
                <x-text-input type="text" name="email" :value="old('email')"
                    class="w-full px-4 py-2 border border-gray-300 rounded" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
            </div>

            <div>
                <x-input-label for="password" :value="__('Password')" :required="true" />
                <x-text-input type="password" name="password" :value="old('password')"
                    class="w-full px-4 py-2 border border-gray-300 rounded" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
            </div>

            <div>
                <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" :required="true" />
                <x-text-input type="text" name="tempat_lahir" :value="old('tempat_lahir')"
                    class="w-full px-4 py-2 border border-gray-300 rounded" required />
                <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2 text-sm text-red-600" />
            </div>

            <div>
                <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                <x-text-input type="date" name="tanggal_lahir" :value="old('tanggal_lahir')"
                    class="w-full px-4 py-2 border border-gray-300 rounded" required />
                <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2 text-sm text-red-600" />
            </div>

            <div>
                <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" :required="true" />
                <select id="jenis_kelamin" name="jenis_kelamin" class="w-full px-4 py-2 border border-gray-300 rounded">
                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                    </option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                    </option>
                </select>
                <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="agama" :value="__('Agama')" :required="true" />
                <x-text-input type="text" name="agama" :value="old('agama')"
                    class="w-full px-4 py-2 border border-gray-300 rounded" required />
                <x-input-error :messages="$errors->get('agama')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="alamat" :value="__('Alamat')" />
                <x-text-input id="alamat" name="alamat" type="text"
                    class="w-full px-4 py-2 border border-gray-300 rounded" :value="old('alamat')" required />
                <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
            </div>

            <div>
                <x-input-label for="handphone" :value="__('Nomor Handphone')" />
                <x-text-input id="handphone" name="handphone" type="text"
                    class="w-full px-4 py-2 border border-gray-300 rounded" :value="old('alamat')" required />
                <x-input-error class="mt-2" :messages="$errors->get('handphone')" />
            </div>

            <div>
                <x-input-label for="iuran_at" :value="__('Tanggal menjadi Anggota')" :required="true" />
                <x-text-input type="date" name="iuran_at" :value="old('iuran_at')"
                    class="w-full px-4 py-2 border border-gray-300 rounded" required />
                <x-input-error :messages="$errors->get('iuran_at')" class="mt-2 text-sm text-red-600" />
            </div>

            <div>
                <x-input-label for="iuran_until" :value="__('Pembayaran Iuran Sampai')" :required="true" />
                <x-text-input type="date" name="iuran_until" :value="old('iuran_until')"
                    class="w-full px-4 py-2 border border-gray-300 rounded" required />
                <x-input-error :messages="$errors->get('iuran_until')" class="mt-2 text-sm text-red-600" />
            </div>

            <x-primary-button class="mt-2">
                {{ __('Buat Akun') }}
            </x-primary-button>
        </form>
    </div>
</section>
