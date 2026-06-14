<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Bank Sampah Emak.id') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,900&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    <body class="font-sans antialiased text-gray-900 bg-gray-100" x-data="{ sidebarOpen: false }">
        
        <div class="flex h-screen overflow-hidden">
            
            <div x-show="sidebarOpen" class="fixed inset-0 z-20 transition-opacity bg-black bg-opacity-50 lg:hidden" @click="sidebarOpen = false" x-cloak></div>
            
            @include('layouts.navigation')

            <div class="flex flex-col flex-1 overflow-hidden">
                
                <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-gray-200 shadow-sm">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden hover:text-green-600 transition-colors">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        
                        @if (isset($header))
                            <div class="ml-4 lg:ml-0">
                                {{ $header }}
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center px-3 py-2 text-sm font-bold text-gray-600 transition duration-150 ease-in-out border border-transparent rounded-md hover:text-green-700 hover:bg-green-50 focus:outline-none">
                                    <div>{{ Auth::user()->name }}</div>
                                    <div class="ml-1">
                                        <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profil Saya') }}
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600">
                                        {{ __('Keluar (Log Out)') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </header>

                <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 pb-12">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @if (isset($scripts))
            {{ $scripts }}
        @endif
    </body>
</html>