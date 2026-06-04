<x-app-layout>
    <x-slot name="header"><h2 class="font-bold text-xl text-green-800">Edit Pengguna</h2></x-slot>

    <div class="py-8"><div class="max-w-2xl mx-auto sm:px-6 lg:px-8"><div class="bg-white p-6 shadow-sm rounded-xl">
        <form action="{{ route('users.update', $user->id_user) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ $user->name }}" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-200" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-200" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" name="password" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-200">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-200">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Hak Akses (Role)</label>
                <select name="role" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-200" required>
                    <option value="penimbang" {{ $user->role == 'penimbang' ? 'selected' : '' }}>Penimbang</option>
                    <option value="pengelola" {{ $user->role == 'pengelola' ? 'selected' : '' }}>Pengelola</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('users.index') }}" class="px-4 py-2 text-gray-600">Batal</a>
                <button type="submit" class="bg-green-600 text-white font-bold py-2 px-6 rounded-lg">Perbarui</button>
            </div>
        </form>
    </div></div></div>
</x-app-layout>