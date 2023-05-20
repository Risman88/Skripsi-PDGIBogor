<x-dashboard-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Pengguna') }}
        </h2>
    </x-slot>

        <div class="py-4">
            <form action="{{ route('users.index') }}" method="GET">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pengguna..." class="rounded-md px-3 py-2">
                <select name="role" class="rounded-md px-3 py-2">
                    <option value="">Semua Peran</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>{{ $role->name }}</option>
                    @endforeach
                </select>
                <button type="submit"
                class="bg-indigo-600 hover:bg-indigo-800 text-white font-bold py-2 px-4 rounded">Cari</button>
            </form>
            <div class="py-4">
        @include('users.partials.table', ['users' => $users])
    </div>
    </div>
</x-dashboard-layout>
