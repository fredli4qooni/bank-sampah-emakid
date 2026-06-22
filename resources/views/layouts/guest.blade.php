<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Bank Sampah Emak.id') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-white">
        <div class="min-h-screen flex">
            
            <!-- Bagian Kiri: Form -->
            <div class="w-full lg:w-1/2 flex flex-col justify-center items-center p-8 relative z-10 bg-white">
                
                <div class="w-full max-w-md border border-gray-200 rounded-[2rem] p-8 shadow-sm">
                    {{ $slot }}
                </div>
                
                <p class="mt-16 text-xs text-gray-400 font-medium">&copy; {{ date('Y') }} Sistem Informasi Bank Sampah</p>
            </div>

            <!-- Bagian Kanan: Ilustrasi & Tagline -->
            <div class="hidden lg:flex w-1/2 bg-green-50 flex-col justify-center items-center relative overflow-hidden p-12">
                <!-- Overlay Gradient -->
                <div class="absolute inset-0 bg-gradient-to-br from-green-100/50 to-white/20"></div>
                
                <!-- Hiasan Blob Blur -->
                <div class="absolute top-[-10%] right-[-10%] w-96 h-96 bg-green-300 rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-pulse"></div>
                <div class="absolute bottom-[-10%] left-[-10%] w-96 h-96 bg-blue-200 rounded-full mix-blend-multiply filter blur-3xl opacity-40"></div>
                
                <!-- Gambar Ilustrasi -->
                <img src="{{ asset('images/ilustrasi-hero.png') }}" alt="Ilustrasi Bank Sampah" class="relative z-10 w-4/5 max-w-lg object-contain drop-shadow-2xl transform transition-transform duration-700 hover:scale-105 mb-8">
                
                <!-- Tagline Text -->
                <div class="relative z-10 text-center max-w-md">
                    <h3 class="text-3xl font-black text-green-800 mb-4 tracking-tight">Ubah Sampah Jadi Berkah</h3>
                    <p class="text-green-700 font-medium leading-relaxed">
                        Kelola tabungan sampah dengan mudah, transparan, dan menguntungkan. Bersama Bank Sampah Emak.id, mari wujudkan lingkungan yang lebih bersih dan hijau.
                    </p>
                </div>
            </div>

        </div>
    </body>
</html>