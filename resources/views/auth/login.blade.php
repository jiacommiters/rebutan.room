<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Selamat Datang Kembali</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Silakan masuk ke akun Anda</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
            <input id="email" class="w-full px-4 py-3 glass-input text-gray-900 dark:text-white" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@kampus.ac.id" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-rose-500" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kata Sandi</label>
            <input id="password" class="w-full px-4 py-3 glass-input text-gray-900 dark:text-white" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-rose-500" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 dark:border-gray-600 text-red-600 shadow-sm focus:ring-red-500 dark:focus:ring-red-600 bg-white/50 dark:bg-gray-900/50" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-red-600 hover:text-red-500 dark:text-red-400 dark:hover:text-red-300 transition-colors" href="{{ route('password.request') }}">
                    Lupa sandi?
                </a>
            @endif
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-3 px-4 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-red-600 to-rose-500 hover:from-red-700 hover:to-rose-600 shadow-lg shadow-red-500/30 transition-all hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-900">
                Masuk ke Sistem
            </button>
        </div>
        
        @if (Route::has('register'))
        <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-6">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="font-medium text-red-600 hover:text-red-500 dark:text-red-400 transition-colors">Daftar sekarang</a>
        </p>
        @endif
    </form>
</x-guest-layout>
