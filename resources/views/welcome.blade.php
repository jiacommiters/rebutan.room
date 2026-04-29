<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rebutan Room</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,600,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-[Inter] bg-gray-50 dark:bg-gray-950 text-gray-900 dark:text-gray-100 antialiased overflow-x-hidden selection:bg-red-500 selection:text-white">

    <!-- Background glowing orbs -->
    <div class="fixed inset-0 min-h-screen overflow-hidden pointer-events-none z-0">
        <div class="absolute top-0 -left-4 w-72 h-72 bg-red-600 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob dark:opacity-20"></div>
        <div class="absolute top-0 -right-4 w-72 h-72 bg-rose-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000 dark:opacity-20"></div>
        <div class="absolute -bottom-8 left-20 w-72 h-72 bg-red-800 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000 dark:opacity-20"></div>
    </div>

    <!-- Navigation -->
    <nav class="relative z-10 w-full glass sticky top-0 px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-red-600 to-rose-400 rounded-xl flex items-center justify-center shadow-lg shadow-red-500/30">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <span class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">Rebutan Room</span>
        </div>
        <div>
            @if (Route::has('login'))
                <div class="flex gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2 rounded-full font-medium transition-all hover:bg-gray-100 dark:hover:bg-gray-800">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2 rounded-full font-medium transition-all hover:bg-gray-100 dark:hover:bg-gray-800">Masuk</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2 rounded-full font-medium text-white bg-gradient-to-r from-red-600 to-rose-500 hover:from-red-700 hover:to-rose-600 shadow-lg shadow-red-500/30 transition-all hover:-translate-y-0.5">Daftar</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </nav>

    <!-- Main Content -->
    <main class="relative z-10 flex flex-col items-center justify-center min-h-[calc(100vh-80px)] px-4">
        <div class="text-center max-w-3xl glass-card p-12 mt-10">
            <span class="px-4 py-1.5 rounded-full text-sm font-semibold bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400 border border-red-200 dark:border-red-500/20 shadow-sm mb-6 inline-block">Sistem Manajemen Presensi Ruangan</span>
            
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight mb-6 leading-tight">
                Pesan Ruangan dengan <br>
                <span class="text-gradient">Super Cepat</span>
            </h1>
            
            <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 mb-10 max-w-2xl mx-auto">
                Platform terintegrasi untuk melihat ketersediaan ruangan, melakukan pengajuan, dan mendapatkan persetujuan admin secara instan.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-3.5 rounded-full font-bold text-white bg-gradient-to-r from-red-600 to-rose-500 hover:from-red-700 hover:to-rose-600 shadow-xl shadow-red-500/20 transition-all hover:scale-105">
                    Mulai Sekarang
                </a>
                <a href="#features" class="w-full sm:w-auto px-8 py-3.5 rounded-full font-bold text-gray-700 dark:text-gray-200 bg-white/50 dark:bg-gray-800/50 hover:bg-white dark:hover:bg-gray-800 border border-gray-200 dark:border-gray-700 transition-all hover:scale-105 backdrop-blur-sm">
                    Pelajari Mode
                </a>
            </div>
        </div>

        <!-- Features Grid -->
        <div id="features" class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl w-full mt-24 mb-10">
            <!-- Feature 1 -->
            <div class="glass-card p-8 group hover:-translate-y-2 transition-all duration-300">
                <div class="w-12 h-12 bg-red-100 dark:bg-red-500/20 rounded-2xl flex items-center justify-center mb-6 text-red-600 dark:text-red-400 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold mb-3">Real-time Sinkronisasi</h3>
                <p class="text-gray-600 dark:text-gray-400">Jadwal yang selalu up-to-date memastikan tidak ada lagi bentrok pemakaian ruangan di kampus anda.</p>
            </div>
            
            <!-- Feature 2 -->
            <div class="glass-card p-8 group hover:-translate-y-2 transition-all duration-300">
                <div class="w-12 h-12 bg-rose-100 dark:bg-rose-500/20 rounded-2xl flex items-center justify-center mb-6 text-rose-600 dark:text-rose-400 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold mb-3">Persetujuan Instan</h3>
                <p class="text-gray-600 dark:text-gray-400">Sistem persetujuan berjenjang yang rapi memungkinkan admin menyetujui request dalam 1 klik.</p>
            </div>

            <!-- Feature 3 -->
            <div class="glass-card p-8 group hover:-translate-y-2 transition-all duration-300">
                <div class="w-12 h-12 bg-red-100 dark:bg-red-500/20 rounded-2xl flex items-center justify-center mb-6 text-red-600 dark:text-red-400 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                </div>
                <h3 class="text-xl font-bold mb-3">Antarmuka Modern</h3>
                <p class="text-gray-600 dark:text-gray-400">Pengalaman pengguna kelas dunia dengan performa cepat berkat integrasi Laravel dan Vite.</p>
            </div>
        </div>

        <!-- Bento Room Gallery -->
        <div class="w-full max-w-6xl mt-8 mb-16">
            <div class="flex items-end justify-between gap-4 mb-6">
                <div>
                    <span class="px-4 py-1.5 rounded-full text-sm font-semibold bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400 border border-red-200 dark:border-red-500/20 shadow-sm inline-flex items-center gap-2">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17l4 4 7-7"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9h4l1-3h8l1 3h4"></path></svg>
                        Pilihan Ruangan
                    </span>
                    <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight mt-3">
                        Booking Lebih Cepat dengan Tampilan Bento
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300 mt-2 max-w-2xl">
                        Lihat contoh ruangan berdasarkan tipe: kelas, laboratorium, seminar/sidang, dan auditorium.
                    </p>
                </div>

                <div class="hidden md:block glass-card px-5 py-3">
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        Tip: pilih ruangan untuk langsung memulai pengajuan.
                    </p>
                </div>
            </div>

            <div class="mt-8">
                <div class="flex flex-wrap items-center gap-2">
                    @php
                        $filters = [
                            'semua' => 'Semua',
                            'kelas' => 'Kelas',
                            'laboratorium' => 'Laboratorium',
                            'seminar' => 'Seminar',
                            'auditorium' => 'Auditorium',
                        ];
                    @endphp
                    @foreach($filters as $key => $label)
                        <button
                            type="button"
                            data-filter="{{ $key }}"
                            class="px-4 py-2 rounded-full text-sm font-semibold transition-all border border-gray-200/60 dark:border-gray-700/60 bg-white/50 dark:bg-gray-900/30 text-gray-800 dark:text-gray-100 hover:bg-white dark:hover:bg-gray-800 room-filter-btn @if($loop->first) active @endif"
                        >
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-12 gap-4 mt-4">
                @foreach($ruangan as $r)
                    @php
                        $mod = $loop->index % 6;
                        $bentoClass = [
                            0 => 'col-span-5 row-span-2',
                            1 => 'col-span-4 row-span-2',
                            2 => 'col-span-3 row-span-2',
                            3 => 'col-span-3 row-span-2',
                            4 => 'col-span-4 row-span-2',
                            5 => 'col-span-6 row-span-1',
                        ][$mod];

                        $type = $r->tipe_ruangan;
                        $theme = match($type) {
                            'kelas' => ['from' => 'from-red-600/20', 'to' => 'to-rose-500/20', 'icon' => 'M12 8v4l3 3'],
                            'laboratorium' => ['from' => 'from-emerald-500/20', 'to' => 'to-teal-500/20', 'icon' => 'M9 12l2 2 4-4'],
                            'seminar' => ['from' => 'from-amber-500/20', 'to' => 'to-orange-500/20', 'icon' => 'M12 6v12'],
                            'auditorium' => ['from' => 'from-violet-500/20', 'to' => 'to-fuchsia-500/20', 'icon' => 'M5 13l4 4L19 7'],
                            default => ['from' => 'from-gray-500/20', 'to' => 'to-gray-700/20', 'icon' => 'M9 12h6'],
                        };

                        $isBorrower = auth()->check() && !auth()->user()->isAdmin();
                        $href = $isBorrower ? route('peminjaman.create') : (auth()->check() ? route('dashboard') : route('login'));
                        $ctaText = $isBorrower ? 'Ajukan' : 'Lihat Dashboard';
                    @endphp

                    <a
                        href="{{ $href }}"
                        data-type="{{ $type }}"
                        class="room-card group relative {{ $bentoClass }} rounded-3xl glass-card overflow-hidden transition-all duration-300 hover:-translate-y-1"
                    >
                        <div class="absolute inset-0 bg-gradient-to-br {{ $theme['from'] }} {{ $theme['to'] }} opacity-100"></div>
                        <div class="relative p-5 h-full flex flex-col">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <div class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-white/60 dark:bg-gray-900/40 border border-white/70 dark:border-gray-700/50">
                                        {{ $r->tipe_ruangan }}
                                    </div>
                                    <h3 class="text-lg font-extrabold text-gray-900 dark:text-white mt-3 leading-tight truncate">
                                        {{ $r->nama_ruangan }}
                                    </h3>
                                    <p class="text-sm text-gray-700 dark:text-gray-200 mt-1">
                                        {{ $r->gedung->nama_gedung ?? '-' }}
                                        @if($r->lantai !== null)
                                            <span class="text-gray-500 dark:text-gray-400"> • Lt. {{ $r->lantai }}</span>
                                        @endif
                                    </p>
                                </div>

                                <div class="w-12 h-12 rounded-2xl bg-white/60 dark:bg-gray-900/40 border border-white/70 dark:border-gray-700/50 flex items-center justify-center flex-shrink-0">
                                    @if($r->tipe_ruangan === 'kelas')
                                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9h4l1-3h8l1 3h4"/>
                                        </svg>
                                    @elseif($r->tipe_ruangan === 'laboratorium')
                                        <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7v10a5 5 0 0010 0V7"/>
                                        </svg>
                                    @elseif($r->tipe_ruangan === 'seminar')
                                        <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9l3-3 3 3"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18h12"/>
                                        </svg>
                                    @elseif($r->tipe_ruangan === 'auditorium')
                                        <svg class="w-6 h-6 text-violet-600 dark:text-violet-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18"/>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6"/>
                                        </svg>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-auto pt-4 flex items-end justify-between gap-3">
                                <div>
                                    <p class="text-xs text-gray-600 dark:text-gray-300">Kapasitas</p>
                                    <p class="text-sm font-bold text-gray-900 dark:text-white">{{ $r->kapasitas }} orang</p>
                                </div>
                                <span class="inline-flex items-center gap-2 text-xs font-bold text-gray-900 dark:text-white px-3 py-2 rounded-xl bg-white/50 dark:bg-gray-900/30 border border-white/60 dark:border-gray-700/50">
                                    {{ $ctaText }}
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            @if($ruangan->isEmpty())
                <div class="mt-8 text-center glass-card p-10">
                    <p class="text-gray-600 dark:text-gray-300">Belum ada data ruangan.</p>
                </div>
            @endif
        </div>
    </main>

    <script>
        (function () {
            const buttons = document.querySelectorAll('.room-filter-btn');
            const cards = document.querySelectorAll('.room-card');

            function applyFilter(filter) {
                cards.forEach(card => {
                    const type = card.getAttribute('data-type');
                    const show = filter === 'semua' || type === filter;
                    card.style.display = show ? '' : 'none';
                });
            }

            buttons.forEach(btn => {
                btn.addEventListener('click', () => {
                    buttons.forEach(b => b.classList.remove('active', 'bg-red-50', 'border-red-500/60', 'text-red-700'));
                    btn.classList.add('active', 'bg-red-50', 'border-red-500/60', 'text-red-700');
                    applyFilter(btn.getAttribute('data-filter'));
                });
            });
        })();
    </script>

</body>
</html>
