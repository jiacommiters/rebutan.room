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
    <body class="font-[Inter] antialiased text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-950 selection:bg-red-500 selection:text-white">
        
        <!-- Animated Background Orbs for Dashboard -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute top-[-20%] -left-20 w-[500px] h-[500px] bg-red-600 rounded-full mix-blend-multiply filter blur-[150px] opacity-20 animate-blob dark:opacity-10"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[400px] h-[400px] bg-rose-500 rounded-full mix-blend-multiply filter blur-[120px] opacity-20 animate-blob animation-delay-4000 dark:opacity-10"></div>
        </div>

        <div class="min-h-screen relative z-10 flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="glass border-b border-gray-200/50 dark:border-gray-800/50 sticky top-0 z-40">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-grow w-full">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
