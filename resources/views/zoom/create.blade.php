<x-dashboard-layout>
    <x-slot name="header">
        {{ __('Pembuatan Jadwal Zoom') }}
    </x-slot>
    @if (session('zoom_logged_in'))
    <div class="w-full max-w-md mx-auto">
        <div class="bg-indigo-300 p-2 text-black text-2xl font-bold text-center mb-4 rounded">
            <span>Data Jadwal Zoom</span>
        </div>
    <form action="{{ route('zoom_meetings.store') }}" method="POST">
    @csrf
    <div>
        <x-input-label for="title" :value="__('Judul Meeting')"  :required=true />
        <x-text-input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full px-4 py-2 border" required/>
    </div>
    <div>
        <x-input-label for="description" :value="__('Deksripsi Meeting')" :opsional=true />
        <textarea name="description" id="description" class="w-full px-4 py-2 border border-gray-300 rounded">{{ old('description') }}</textarea>
    </div>
    <div>
        <x-input-label for="untuk_id" :value="__('Meeting untuk')"  />
        <div x-data="dropdownSearch()" class="relative">
            <div @click="open = !open" class="w-full px-4 py-2 border border-gray-400 rounded bg-white text-left cursor-pointer">
                <span x-text="selectedUser ? selectedUser.name : 'Pilih user'"></span>
                <span class="float-right">&#x25BC;</span>
            </div>

            <div x-show="open" @click.away="open = false" class="absolute z-10 mt-2 w-full bg-white rounded shadow border border-gray-400">
                <input x-model="search" type="text" placeholder="Cari pengguna..." class="w-full px-4 py-2 border-b border-gray-400" />

                <div class="max-h-48 overflow-y-auto">
                    <template x-for="user in filteredUsers()">
                        <a href="#" @click.prevent="selectedUser = user; open = false" class="w-full px-4 py-2 block hover:bg-gray-200" x-text="user.name"></a>
                    </template>
                </div>
            </div>

            <input type="hidden" name="untuk_id" id="untuk_id" x-model="selectedUser.id" required>
        </div>
    </div>
    <div>
        <x-input-label for="start_time" :value="__('Waktu Mulai')"  />
        <x-text-input type="datetime-local" name="start_time" id="start_time" value="{{ old('start_time') }}" class="w-full px-4 py-2 border" required/>
    </div>
    <div>
        <x-input-label for="duration" :value="__('Durasi Meeting')"  />
        <x-text-input type="number" name="duration" id="duration" value="{{ old('duration') }}" class="w-full px-4 py-2 border" required/>
        <span class= "text-gray-500 text-sm px-1 inline-block">(maksimal durasi untuk satu meeting adalah 45 menit)</span>
    </div>
    <button type="submit" class="w-full py-2 bg-gray-800 text-white font-bold rounded mt-4">
        Buat Zoom Meeting
    </button>
</form>
    @else
    <div class="w-full max-w-md mx-auto">
        <a href="{{ route('zoom.redirect') }}" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">Login dengan Zoom</a>
        <div class="p-2 mb-4 rounded">
        <span class= "text-gray-500 font-bold text-sm px-1 inline-block">(Sebelum membuat zoom meeting baru, silahkan login terlebih dahulu ke akun zoom yang sudah terautetikansi dengan aplikasi)</span>
        </div>
    </div>
    @endif

<script>
    function getUsers() {
        return [
            @foreach ($users as $user)
                {id: {{ $user->id }}, name: '{{ addslashes($user->name) }}'},
            @endforeach
        ];
    }

    function dropdownSearch() {
    return {
        open: false,
        search: '',
        selectedUser: null,
        users: getUsers(),
        filteredUsers() {
            if (!this.search) {
                return this.users;
            }

            const search = this.search.toLowerCase();
            return this.users.filter(user => user.name.toLowerCase().includes(search));
            }
        };
    }
</script>
</x-dashboard-layout>
