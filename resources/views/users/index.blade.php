<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-green-800 leading-tight">Manajemen Pengguna</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">{{ session('error') }}</div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                <div class="mb-6">
                    <a href="{{ route('users.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-5 rounded-lg shadow inline-flex items-center gap-2">
                        + Tambah Pengguna
                    </a>
                </div>

                <div class="overflow-x-auto rounded-lg border border-gray-200">
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-green-800 uppercase bg-green-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-4 font-bold">Nama Lengkap</th>
                                <th class="px-6 py-4 font-bold">Email</th>
                                <th class="px-6 py-4 font-bold">Hak Akses (Role)</th>
                                <th class="px-6 py-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-bold text-gray-800">{{ $user->name }}</td>
                                    <td class="px-6 py-4">{{ $user->email }}</td>
                                    <td class="px-6 py-4 uppercase font-bold text-xs text-blue-600">{{ $user->role }}</td>
                                    <td class="px-6 py-4 flex justify-center gap-3">
                                        <a href="{{ route('users.edit', $user->id_user) }}" class="text-green-600 font-medium hover:underline">Edit</a>
                                        
                                        @if(Auth::id() !== $user->id_user)
                                        <form action="{{ route('users.destroy', $user->id_user) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 font-medium hover:underline">Hapus</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>