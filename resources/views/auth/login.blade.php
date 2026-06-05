<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8 text-center">
        <h2 class="text-2xl font-black text-gray-800">Selamat Datang!</h2>
        <p class="text-sm text-gray-500 mt-1">Masuk ke sistem Bank Sampah Emak.id</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email" class="block font-bold text-sm text-gray-700">Email Address</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                class="block mt-2 w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 shadow-sm transition-colors" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
        </div>

        <div class="mt-6">
            <label for="password" class="block font-bold text-sm text-gray-700">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="block mt-2 w-full rounded-xl border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 shadow-sm transition-colors" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500">
                <span class="ms-2 text-sm text-gray-600 font-medium">Ingat Saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-bold text-green-600 hover:text-green-800 transition-colors" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif
        </div>

        <div class="mt-8">
            <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-sm font-black text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transform transition-transform hover:-translate-y-0.5 uppercase tracking-wider">
                Masuk Sekarang
            </button>
        </div>

        <div class="mt-8 text-center border-t border-gray-100 pt-6">
            <p class="text-sm text-gray-600">
                Belum memiliki akun? 
                <a href="{{ route('register') }}" class="font-black text-green-600 hover:text-green-800 hover:underline transition-colors">Daftar disini</a>
            </p>
        </div>
    </form>
</x-guest-layout>