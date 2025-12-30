@php
    $setting = \App\Models\Setting::first();
@endphp

<nav x-data="{ open: false }" class="border-b border-gray-200 dark:border-gray-700">
    <!-- BARIS 1: Logo + Search + Profil -->
    <div class="w-full bg-[#20C896] px-4 py-3 sm:px-6 lg:px-8">
        <div class="mx-auto flex h-12 max-w-7xl items-center justify-between">
            <!-- Logo -->
            <div class="flex shrink-0 items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 text-white">
                    <x-application-logo :logo-path="$setting?->logo" :site-name="$setting?->site_name" class="block w-auto fill-current" />

                </a>
            </div>

            <!-- Search Bar -->
            <div class="mx-4 hidden w-full max-w-md md:block">
                <form method="GET" action="{{ route('listkursus') }}" class="relative">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kursus..." class="w-full rounded-full border border-gray-300 bg-white/90 px-4 py-2 pl-10 text-sm text-gray-800 placeholder-gray-500 shadow-sm transition focus:border-white focus:outline-none focus:ring-2 focus:ring-white/50" />
                        <button type="submit" class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#20C896]">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Profil Dropdown -->
            <div class="flex items-center">
                @if (Route::has('login'))
                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="ml-2 inline-flex items-center rounded-full border-2 border-white/30 transition hover:scale-105 focus:outline-none">
                                    @if (Auth::user()->avatar_url)
                                        <img src="{{ asset('storage/' . Auth::user()->avatar_url) }}" alt="{{ Auth::user()->name }}" class="h-8 w-8 rounded-full object-cover">
                                    @else
                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white/20 font-bold text-white">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </button>
                            </x-slot>

                            <x-slot name="content" class="rounded-lg bg-white shadow-lg dark:bg-gray-800">
                                <div class="px-4 py-3">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-200">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</p>
                                </div>
                                <x-dropdown-link :href="route('profile.edit')">
                                    <div class="flex items-center gap-2">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                        </svg>
                                        {{ __('Profil') }}
                                    </div>
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('listkelas')">
                                    <div class="flex items-center gap-2">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        {{ __('Kelas Saya') }}
                                    </div>
                                </x-dropdown-link>
                                <div class="my-1 border-t border-gray-200 dark:border-gray-700"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                        <div class="flex items-center gap-2 text-red-600 hover:text-red-800">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            {{ __('Keluar') }}
                                        </div>
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <a href="{{ route('login') }}" class="font-medium text-gray-800 hover:text-gray-600">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-medium text-gray-800 hover:text-gray-600">Daftar</a>
                        @endif
                    @endauth
                @endif

                <!-- Hamburger -->
                <button @click="open = !open" class="ml-4 inline-flex items-center justify-center rounded-md p-2 text-gray-700 hover:bg-gray-100 focus:outline-none sm:hidden dark:text-gray-200 dark:hover:bg-gray-700">
                    <svg :class="{ 'hidden': open, 'block': !open }" class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg :class="{ 'block': open, 'hidden': !open }" class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- BARIS 2: Menu Navigasi Utama -->
    <div class="w-full bg-white px-4 py-2 sm:px-6 lg:px-8">
        <div class="mx-auto flex h-10 max-w-7xl items-center justify-center">
            <div class="hidden space-x-6 sm:flex">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="rounded-lg px-3 py-1.5 text-sm font-medium transition hover:bg-green-50 hover:text-green-700">
                    {{ __('Beranda') }}
                </x-nav-link>
                <x-nav-link :href="route('listkursus')" :active="request()->routeIs('listkursus')" class="rounded-lg px-3 py-1.5 text-sm font-medium transition hover:bg-green-50 hover:text-green-700">
                    {{ __('Kursus') }}
                </x-nav-link>
            </div>

            <!-- Responsif: dropdown di mobile -->
            <div :class="{ 'block': open, 'hidden': !open }" class="w-full sm:hidden">
                <div class="space-y-1 px-4 py-2">
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Beranda') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('listkursus')" :active="request()->routeIs('listkursus')">
                        {{ __('Kursus') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('listkelas')" :active="request()->routeIs('listkelas')">
                        {{ __('Kelas Saya') }}
                    </x-responsive-nav-link>
                </div>
            </div>
        </div>
    </div>
</nav>
