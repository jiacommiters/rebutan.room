<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rebutan Room</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .glass-nav {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
        .dark .glass-nav {
            background: rgba(17, 24, 39, 0.7);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        .hero-pattern {
            background-color: transparent;
            background-image: radial-gradient(rgba(225, 29, 72, 0.1) 2px, transparent 2px);
            background-size: 30px 30px;
        }
        .dark .hero-pattern {
            background-image: radial-gradient(rgba(225, 29, 72, 0.15) 2px, transparent 2px);
        }
        /* Custom scrollbar for horizontal scroll areas */
        .hide-scroll::-webkit-scrollbar {
            display: none;
        }
        .hide-scroll {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>
<body class="font-[Inter] bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 antialiased overflow-x-hidden selection:bg-rose-500 selection:text-white">

    <!-- Background glowing orbs -->
    <div class="fixed inset-0 min-h-screen overflow-hidden pointer-events-none z-0">
        <div class="absolute top-0 -left-4 w-72 h-72 bg-red-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob dark:opacity-10"></div>
        <div class="absolute top-0 -right-4 w-72 h-72 bg-rose-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000 dark:opacity-10"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-rose-800 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000 dark:opacity-10"></div>
    </div>

    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass-nav transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-red-600 to-rose-500 rounded-xl flex items-center justify-center shadow-lg shadow-red-500/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">Rebutan Room</span>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="#koleksi" class="text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-rose-600 dark:hover:text-rose-400 transition-colors">Eksplor Ruangan</a>
                    <a href="#cara-pesan" class="text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-rose-600 dark:hover:text-rose-400 transition-colors">Cara Pesan</a>
                    
                    <div class="flex items-center gap-4 ml-4 pl-8 border-l border-gray-200 dark:border-gray-700">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ Auth::user()->isAdmin() ? route('dashboard') : route('peminjaman.index') }}" class="text-sm font-semibold text-gray-700 dark:text-gray-200 hover:text-rose-600 transition-colors">
                                    {{ Auth::user()->name }}
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="px-5 py-2.5 rounded-full text-sm font-bold text-white bg-gray-900 dark:bg-white dark:text-gray-900 hover:bg-gray-800 dark:hover:bg-gray-100 transition-all shadow-lg">
                                        Keluar
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-bold text-gray-700 dark:text-gray-200 hover:text-rose-600 transition-colors">Masuk</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-full text-sm font-bold text-white bg-gradient-to-r from-red-600 to-rose-500 hover:from-red-700 hover:to-rose-600 shadow-lg shadow-rose-500/30 transition-all hover:-translate-y-0.5">Daftar Sekarang</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="p-2 rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Panel -->
        <div id="mobile-menu" class="hidden md:hidden bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 shadow-xl absolute w-full left-0 top-20">
            <div class="px-4 py-6 space-y-4 flex flex-col">
                <a href="#koleksi" class="px-4 py-3 rounded-xl font-semibold text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-800 hover:bg-rose-50 dark:hover:bg-rose-900/20 hover:text-rose-600 transition-colors">Eksplor Ruangan</a>
                <a href="#cara-pesan" class="px-4 py-3 rounded-xl font-semibold text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-800 hover:bg-rose-50 dark:hover:bg-rose-900/20 hover:text-rose-600 transition-colors">Cara Pesan</a>
                
                <hr class="border-gray-200 dark:border-gray-700 my-4">
                
                @if (Route::has('login'))
                    @auth
                        <a href="{{ Auth::user()->isAdmin() ? route('dashboard') : route('peminjaman.index') }}" class="px-4 py-3 rounded-xl font-semibold text-center text-white bg-gradient-to-r from-red-600 to-rose-500">
                            Masuk ke Profil
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-3 rounded-xl font-semibold text-center border-2 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-3 rounded-xl font-semibold text-center text-white bg-gradient-to-r from-red-600 to-rose-500 shadow-lg shadow-rose-500/30">Daftar Sekarang</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <main class="relative z-10 pt-20">
        <!-- Hero Section dengan Background Pattern -->
        <div class="relative py-16 lg:py-24 hero-pattern">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-300 border border-rose-200 dark:border-rose-500/30 shadow-sm mb-8 animate-bounce">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                    </span>
                    Tersedia 100+ Ruangan Siap Pakai
                </span>
                
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-extrabold tracking-tight mb-6 text-gray-900 dark:text-white leading-tight">
                    Booking Ruangan Kampus <br class="hidden md:block">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-rose-500">Lebih Mudah & Cepat</span>
                </h1>
                
                <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400 max-w-2xl mx-auto mb-12">
                    Platform reservasi pintar. Cek ketersediaan real-time, pilih ruangan favoritmu, dan dapatkan persetujuan instan dari admin.
                </p>

                <!-- Traveloka-style Search/Action Box -->
                <div class="max-w-4xl mx-auto bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl rounded-3xl p-3 md:p-4 shadow-2xl border border-gray-100 dark:border-gray-800">
                    <div class="flex flex-col md:flex-row gap-3">
                        <div class="flex-1 relative group">
                            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-rose-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <select id="quick-tipe" class="w-full h-14 pl-12 pr-4 bg-gray-50 dark:bg-gray-800/50 border-0 rounded-2xl text-gray-900 dark:text-white font-medium focus:ring-2 focus:ring-rose-500 focus:bg-white dark:focus:bg-gray-800 transition-all cursor-pointer appearance-none">
                                <option value="semua">Semua Tipe Ruangan</option>
                                <option value="kelas">Kelas Interaktif</option>
                                <option value="laboratorium">Laboratorium Praktikum</option>
                                <option value="seminar">Ruang Seminar / Sidang</option>
                                <option value="auditorium">Auditorium / Aula</option>
                            </select>
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>

                        <div class="flex-1 relative group">
                            <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-gray-400 group-focus-within:text-rose-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <select id="quick-kapasitas" class="w-full h-14 pl-12 pr-4 bg-gray-50 dark:bg-gray-800/50 border-0 rounded-2xl text-gray-900 dark:text-white font-medium focus:ring-2 focus:ring-rose-500 focus:bg-white dark:focus:bg-gray-800 transition-all cursor-pointer appearance-none">
                                <option value="semua">Kapasitas Apapun</option>
                                <option value="kecil">< 30 Orang</option>
                                <option value="sedang">30 - 60 Orang</option>
                                <option value="besar">> 60 Orang</option>
                            </select>
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>

                        <button id="btn-quick-search" class="h-14 px-8 bg-gradient-to-r from-red-600 to-rose-500 hover:from-red-700 hover:to-rose-600 text-white font-bold rounded-2xl shadow-lg shadow-rose-500/30 flex items-center justify-center gap-2 transition-all hover:scale-[1.02] active:scale-95">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            Cari Ruangan
                        </button>
                    </div>
                </div>

                <!-- Trusted By / Features Quick -->
                <div class="mt-12 flex flex-wrap justify-center gap-6 md:gap-12 text-sm font-medium text-gray-500 dark:text-gray-400">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Konfirmasi Instan
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Tersedia 24/7
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        E-Surat Otomatis
                    </div>
                </div>
            </div>
        </div>

        <!-- Bagaimana Cara Pesan? -->
        <section id="cara-pesan" class="py-16 bg-white/50 dark:bg-gray-900/30 backdrop-blur-sm border-y border-gray-100 dark:border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white">Bagaimana Cara Kerjanya?</h2>
                    <p class="mt-4 text-gray-600 dark:text-gray-400">Proses peminjaman ruangan yang sangat mudah dan transparan</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Step 1 -->
                    <div class="relative p-6 bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                        <div class="absolute -top-6 left-6 w-12 h-12 bg-gradient-to-br from-red-600 to-rose-500 rounded-2xl text-white font-bold text-xl flex items-center justify-center shadow-lg shadow-rose-500/30">1</div>
                        <div class="mt-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Pilih Ruangan</h3>
                            <p class="text-gray-600 dark:text-gray-400">Cari ruangan yang sesuai dengan kebutuhan Anda. Filter berdasarkan kapasitas, fasilitas, atau gedung.</p>
                        </div>
                    </div>
                    
                    <!-- Step 2 -->
                    <div class="relative p-6 bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 delay-100">
                        <div class="absolute -top-6 left-6 w-12 h-12 bg-gradient-to-br from-red-600 to-rose-500 rounded-2xl text-white font-bold text-xl flex items-center justify-center shadow-lg shadow-rose-500/30">2</div>
                        <div class="mt-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Isi Form & Jadwal</h3>
                            <p class="text-gray-600 dark:text-gray-400">Tentukan waktu mulai dan selesai kegiatan. Lampirkan surat persetujuan dari pihak terkait jika diperlukan.</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative p-6 bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 delay-200">
                        <div class="absolute -top-6 left-6 w-12 h-12 bg-gradient-to-br from-red-600 to-rose-500 rounded-2xl text-white font-bold text-xl flex items-center justify-center shadow-lg shadow-rose-500/30">3</div>
                        <div class="mt-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Tunggu Approval</h3>
                            <p class="text-gray-600 dark:text-gray-400">Admin akan mereview pengajuan Anda dalam waktu singkat. Anda akan menerima notifikasi status pengajuan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bento Room Gallery -->
        <section id="koleksi" class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
                <div>
                    <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white">
                        Koleksi Ruangan
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-3 max-w-2xl">
                        Temukan ruang ideal untuk setiap aktivitas. Klik pada ruangan untuk mulai membuat pengajuan jadwal.
                    </p>
                </div>

                <!-- Horizontal scrollable filter -->
                <div class="flex overflow-x-auto hide-scroll pb-2 -mx-4 px-4 md:mx-0 md:px-0 md:pb-0 gap-2">
                    @php
                        $filters = [
                            'semua' => 'Semua',
                            'kelas' => 'Kelas',
                            'laboratorium' => 'Lab',
                            'seminar' => 'Seminar',
                            'auditorium' => 'Auditorium',
                        ];
                    @endphp
                    @foreach($filters as $key => $label)
                        <button
                            type="button"
                            data-filter="{{ $key }}"
                            class="whitespace-nowrap px-5 py-2.5 rounded-full text-sm font-bold transition-all border {{ $loop->first ? 'border-rose-500 bg-rose-50 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400 shadow-sm' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700' }} room-filter-btn"
                        >
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Grid Layout Premium -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="room-grid">
                @forelse($ruangan as $r)
                    @php
                        $type = $r->tipe_ruangan;
                        $theme = match($type) {
                            'kelas' => ['bg' => 'from-rose-500/10 to-red-600/5', 'icon_bg' => 'bg-rose-100 dark:bg-rose-900/30', 'icon_text' => 'text-rose-600 dark:text-rose-400'],
                            'laboratorium' => ['bg' => 'from-emerald-500/10 to-teal-600/5', 'icon_bg' => 'bg-emerald-100 dark:bg-emerald-900/30', 'icon_text' => 'text-emerald-600 dark:text-emerald-400'],
                            'seminar' => ['bg' => 'from-amber-500/10 to-orange-600/5', 'icon_bg' => 'bg-amber-100 dark:bg-amber-900/30', 'icon_text' => 'text-amber-600 dark:text-amber-400'],
                            'auditorium' => ['bg' => 'from-violet-500/10 to-fuchsia-600/5', 'icon_bg' => 'bg-violet-100 dark:bg-violet-900/30', 'icon_text' => 'text-violet-600 dark:text-violet-400'],
                            default => ['bg' => 'from-gray-500/10 to-gray-600/5', 'icon_bg' => 'bg-gray-100 dark:bg-gray-800', 'icon_text' => 'text-gray-600 dark:text-gray-400'],
                        };

                        $isBorrower = auth()->check() && !auth()->user()->isAdmin();
                        $href = $isBorrower ? route('peminjaman.create', ['ruangan' => $r->id_ruangan]) : (auth()->check() ? route('dashboard') : route('login'));
                    @endphp

                    <a href="{{ $href }}" 
                       data-type="{{ $type }}"
                       data-capacity="{{ $r->kapasitas }}"
                       class="room-card group flex flex-col bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-2xl hover:shadow-rose-500/10 transition-all duration-300 hover:-translate-y-1">
                        
                        <!-- Visual Header Gradient -->
                        <div class="h-32 bg-gradient-to-br {{ $theme['bg'] }} relative p-5 flex items-start justify-between">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-white/80 dark:bg-gray-900/80 text-gray-900 dark:text-white backdrop-blur-sm shadow-sm">
                                {{ $type }}
                            </span>
                            
                            <div class="w-10 h-10 rounded-2xl {{ $theme['icon_bg'] }} {{ $theme['icon_text'] }} flex items-center justify-center shadow-sm">
                                @if($type === 'kelas')
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9h4l1-3h8l1 3h4"/></svg>
                                @elseif($type === 'laboratorium')
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7v10a5 5 0 0010 0V7"/></svg>
                                @elseif($type === 'seminar')
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9l3-3 3 3"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18h12"/></svg>
                                @elseif($type === 'auditorium')
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18"/></svg>
                                @else
                                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6"/></svg>
                                @endif
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-5 flex-1 flex flex-col">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1 group-hover:text-rose-600 dark:group-hover:text-rose-400 transition-colors line-clamp-1">
                                {{ $r->nama_ruangan }}
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4 line-clamp-1">
                                {{ $r->gedung->nama_gedung ?? '-' }}
                            </p>

                            <div class="mt-auto grid grid-cols-2 gap-3 mb-5">
                                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-3 border border-gray-100 dark:border-gray-700">
                                    <div class="text-[10px] uppercase font-bold text-gray-400 dark:text-gray-500 mb-1">Kapasitas</div>
                                    <div class="font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-1">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        {{ $r->kapasitas }} <span class="text-xs font-normal">org</span>
                                    </div>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-3 border border-gray-100 dark:border-gray-700">
                                    <div class="text-[10px] uppercase font-bold text-gray-400 dark:text-gray-500 mb-1">Lantai</div>
                                    <div class="font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-1">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                        {{ $r->lantai ?? '-' }}
                                    </div>
                                </div>
                            </div>

                            <button class="w-full py-2.5 rounded-xl text-sm font-bold bg-gray-900 text-white dark:bg-white dark:text-gray-900 group-hover:bg-rose-500 dark:group-hover:bg-rose-500 group-hover:text-white transition-colors">
                                Pilih Ruangan
                            </button>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full py-12 text-center bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700">
                        <p class="text-gray-500 dark:text-gray-400">Belum ada data ruangan yang tersedia.</p>
                    </div>
                @endforelse
            </div>
            
            <!-- Empty state for search -->
            <div id="empty-search" class="hidden py-12 text-center bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 mt-6">
                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Tidak ditemukan</h3>
                <p class="text-gray-500 dark:text-gray-400">Coba ubah kriteria pencarian Anda.</p>
                <button id="reset-search" class="mt-4 px-4 py-2 text-sm font-semibold text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-xl transition-colors">Reset Pencarian</button>
            </div>
        </section>
    </main>

    <!-- Footer Simple -->
    <footer class="bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 py-10 mt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-gradient-to-br from-red-600 to-rose-500 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <span class="font-bold text-gray-900 dark:text-white">Rebutan Room</span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} Sistem Peminjaman Ruangan Kampus. All rights reserved.
            </p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile Menu Toggle
            const mobileBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            
            mobileBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });

            // Filter logic
            const filterBtns = document.querySelectorAll('.room-filter-btn');
            const cards = document.querySelectorAll('.room-card');
            const emptySearch = document.getElementById('empty-search');
            
            // Quick Search elements
            const quickTipe = document.getElementById('quick-tipe');
            const quickKapasitas = document.getElementById('quick-kapasitas');
            const btnQuickSearch = document.getElementById('btn-quick-search');
            const resetSearchBtn = document.getElementById('reset-search');

            function applyFilter(tipe, kapasitas) {
                let visibleCount = 0;

                cards.forEach(card => {
                    const cardType = card.getAttribute('data-type');
                    const cardCap = parseInt(card.getAttribute('data-capacity') || 0);
                    
                    let matchTipe = (tipe === 'semua' || cardType === tipe);
                    let matchCap = true;
                    
                    if (kapasitas === 'kecil') matchCap = cardCap < 30;
                    else if (kapasitas === 'sedang') matchCap = (cardCap >= 30 && cardCap <= 60);
                    else if (kapasitas === 'besar') matchCap = cardCap > 60;

                    if (matchTipe && matchCap) {
                        card.style.display = '';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (visibleCount === 0 && cards.length > 0) {
                    emptySearch.classList.remove('hidden');
                } else {
                    emptySearch.classList.add('hidden');
                }
            }

            // Category buttons filter
            filterBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    // Update active state
                    filterBtns.forEach(b => {
                        b.classList.remove('border-rose-500', 'bg-rose-50', 'text-rose-700', 'dark:bg-rose-900/30', 'dark:text-rose-400', 'shadow-sm');
                        b.classList.add('border-gray-200', 'dark:border-gray-700', 'bg-white', 'dark:bg-gray-800', 'text-gray-600', 'dark:text-gray-300');
                    });
                    btn.classList.add('border-rose-500', 'bg-rose-50', 'text-rose-700', 'dark:bg-rose-900/30', 'dark:text-rose-400', 'shadow-sm');
                    btn.classList.remove('border-gray-200', 'dark:border-gray-700', 'bg-white', 'dark:bg-gray-800', 'text-gray-600', 'dark:text-gray-300');
                    
                    // Sync with select dropdown
                    const filterVal = btn.getAttribute('data-filter');
                    quickTipe.value = filterVal;
                    
                    applyFilter(filterVal, quickKapasitas.value);
                });
            });

            // Quick Search Button
            btnQuickSearch.addEventListener('click', () => {
                const tipe = quickTipe.value;
                const kapasitas = quickKapasitas.value;
                
                // Sync Category buttons if possible
                filterBtns.forEach(b => {
                    if(b.getAttribute('data-filter') === tipe) {
                        b.click(); // This will trigger the style change and applyFilter
                    } else if (tipe !== 'semua' && b.getAttribute('data-filter') === 'semua') {
                         b.classList.remove('border-rose-500', 'bg-rose-50', 'text-rose-700', 'dark:bg-rose-900/30', 'dark:text-rose-400', 'shadow-sm');
                         b.classList.add('border-gray-200', 'dark:border-gray-700', 'bg-white', 'dark:bg-gray-800', 'text-gray-600', 'dark:text-gray-300');
                    }
                });
                
                applyFilter(tipe, kapasitas);
                
                // Scroll to results
                document.getElementById('koleksi').scrollIntoView({ behavior: 'smooth' });
            });

            // Reset
            resetSearchBtn.addEventListener('click', () => {
                quickTipe.value = 'semua';
                quickKapasitas.value = 'semua';
                document.querySelector('.room-filter-btn[data-filter="semua"]').click();
            });
        });
    </script>
</body>
</html>
