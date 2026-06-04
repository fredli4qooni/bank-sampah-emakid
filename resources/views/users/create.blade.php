<x-app-layout>
    <x-slot name="header"><h2 class="font-bold text-xl text-green-800">Tambah Pengguna Baru</h2></x-slot>

    <div class="py-8"><div class="max-w-2xl mx-auto sm:px-6 lg:px-8"><div class="bg-white p-6 shadow-sm rounded-xl">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                <input type="text" name="name" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-200" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-200" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-200" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-200" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Hak Akses (Role)</label>
                <select name="role" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-200" required>
                    <option value="penimbang">Penimbang (Lapangan)</option>
                    <option value="pengelola">Pengelola (View Only)</option>
                    <option value="admin">Admin (Akses Penuh)</option>
                </select>
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('users.index') }}" class="px-4 py-2 text-gray-600">Batal</a>
                <button type="submit" class="bg-green-600 text-white font-bold py-2 px-6 rounded-lg">Simpan</button>
            </div>
        </form>
    </div></div></div>
</x-app-layout>