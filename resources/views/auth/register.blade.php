<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-black text-gray-800">Daftar Akun Baru</h2>
        <p class="text-sm text-gray-500 mt-1">Bergabunglah dengan Bank Sampah Emak.id</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label for="name" class="block font-bold text-sm text-gray-700">Nama Lengkap</label>
            <input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
                class="block mt-2 w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 shadow-sm transition-colors" placeholder="Masukkan nama Anda" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500" />
        </div>

        <div class="mt-5">
            <label for="email" class="block font-bold text-sm text-gray-700">Email Address</label>
            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                class="block mt-2 w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 shadow-sm transition-colors" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>

        <div class="mt-5">
            <label for="password" class="block font-bold text-sm text-gray-700">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="block mt-2 w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 shadow-sm transition-colors" placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
        </div>

        <div class="mt-5">
            <label for="password_confirmation" class="block font-bold text-sm text-gray-700">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="block mt-2 w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 shadow-sm transition-colors" placeholder="Ulangi password Anda" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
        </div>

        <div class="mt-8">
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-black text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform transition-transform hover:-translate-y-0.5 uppercase tracking-wider">
                Daftar Sekarang
            </button>
        </div>

        <div class="mt-6 text-center border-t border-gray-100 pt-6">
            <p class="text-sm text-gray-600">
                Sudah memiliki akun? 
                <a href="{{ route('login') }}" class="font-black text-green-600 hover:text-green-800 hover:underline transition-colors">Masuk disini</a>
            </p>
        </div>
    </form>
</x-guest-layout>