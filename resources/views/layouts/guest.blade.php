<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-[Inter] text-gray-900 dark:text-gray-100 antialiased overflow-x-hidden selection:bg-red-500 selection:text-white bg-gray-50 dark:bg-gray-950">
        
        <!-- Animated Background Orbs -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute top-[-10%] -left-10 w-96 h-96 bg-red-600 rounded-full mix-blend-multiply filter blur-[100px] opacity-40 animate-blob dark:opacity-30"></div>
            <div class="absolute top-[20%] -right-10 w-96 h-96 bg-rose-500 rounded-full mix-blend-multiply filter blur-[100px] opacity-40 animate-blob animation-delay-2000 dark:opacity-30"></div>
            <div class="absolute -bottom-20 left-[20%] w-96 h-96 bg-red-800 rounded-full mix-blend-multiply filter blur-[100px] opacity-40 animate-blob animation-delay-4000 dark:opacity-30"></div>
        </div>

        <div class="relative z-10 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            
            <div class="mb-8">
                <a href="/" class="flex flex-col items-center gap-3 group">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-600 to-rose-400 rounded-2xl flex items-center justify-center shadow-lg shadow-red-500/30 group-hover:scale-105 transition-transform duration-300">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <span class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-white">Rebutan Room</span>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 glass-card shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-600 to-rose-400"></div>
                {{ $slot }}
            </div>
            
            <p class="mt-8 text-sm text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} Sistem Rebutan Room.
            </p>
        </div>
    </body>
</html>
