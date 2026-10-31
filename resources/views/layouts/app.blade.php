<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 antialiased dark:bg-slate-950">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'SmartDesk AI' }} - Intelligent IT Service Desk</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-full flex-col font-sans text-slate-800 dark:text-slate-100">

    <!-- Top Announcement / Quick Demo Switcher -->
    @auth
    <header class="sticky top-0 z-40 border-b border-slate-200 bg-white/90 backdrop-blur-md dark:border-slate-800 dark:bg-slate-900/90">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
            <!-- Brand & Navigation -->
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-tr from-indigo-600 via-indigo-500 to-sky-400 text-white shadow-md shadow-indigo-500/20">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-lg font-bold tracking-tight text-slate-900 dark:text-white">SmartDesk<span class="text-indigo-600 dark:text-indigo-400">.AI</span></span>
                        <span class="hidden rounded bg-indigo-50 px-1.5 py-0.5 text-[10px] font-semibold text-indigo-700 sm:inline-block dark:bg-indigo-950/70 dark:text-indigo-300">MVP IT Service</span>
                    </div>
                </a>

                <!-- Nav links -->
                <nav class="hidden md:flex items-center gap-1">
                    <a href="{{ route('dashboard') }}" class="rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/60 dark:text-indigo-300' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('tickets.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('tickets.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/60 dark:text-indigo-300' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                        Tiket IT
                    </a>
                    <a href="{{ route('knowledge.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('knowledge.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/60 dark:text-indigo-300' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                        Basis Pengetahuan
                    </a>
                    @if(Auth::user()->isAdmin())
                    <a href="{{ route('categories.index') }}" class="rounded-lg px-3 py-2 text-sm font-medium transition {{ request()->routeIs('categories.*') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/60 dark:text-indigo-300' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                        Kelola Kategori
                    </a>
                    @endif
                </nav>
            </div>

            <!-- Action & Role Switcher -->
            <div class="flex items-center gap-3">
                <a href="{{ route('tickets.create') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-3.5 py-2 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Buat Tiket</span>
                </a>

                <!-- Quick Switch Persona for Testing -->
                <div class="relative group">
                    <button type="button" class="flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-xs text-slate-700 hover:border-slate-300 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                        <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=6366f1&color=fff' }}" alt="avatar" class="h-6 w-6 rounded-full object-cover">
                        <span class="max-w-[120px] truncate font-medium text-left">
                            <span class="block truncate">{{ Auth::user()->name }}</span>
                            <span class="block text-[10px] text-slate-500 dark:text-slate-400 capitalize">{{ Auth::user()->role->label() }}</span>
                        </span>
                        <svg class="h-3.5 w-3.5 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Dropdown for role switching & logout -->
                    <div class="invisible group-hover:visible group-focus-within:visible absolute right-0 mt-1 w-64 rounded-xl border border-slate-200 bg-white p-2 shadow-xl dark:border-slate-700 dark:bg-slate-800">
                        <div class="px-2 py-1.5 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                            Simulasi Ganti Role (Alur Pengujian)
                        </div>
                        <form method="POST" action="{{ route('quick-login') }}" class="space-y-1">
                            @csrf
                            <button name="user_id" value="1" class="w-full text-left rounded-lg px-2.5 py-1.5 text-xs text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 flex items-center justify-between dark:text-slate-200 dark:hover:bg-slate-700">
                                <span>Budi Santoso</span>
                                <span class="rounded bg-rose-100 px-1.5 py-0.5 text-[10px] font-bold text-rose-700 dark:bg-rose-950 dark:text-rose-300">Admin</span>
                            </button>
                            <button name="user_id" value="2" class="w-full text-left rounded-lg px-2.5 py-1.5 text-xs text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 flex items-center justify-between dark:text-slate-200 dark:hover:bg-slate-700">
                                <span>Rian Pratama</span>
                                <span class="rounded bg-indigo-100 px-1.5 py-0.5 text-[10px] font-bold text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">Teknisi</span>
                            </button>
                            <button name="user_id" value="4" class="w-full text-left rounded-lg px-2.5 py-1.5 text-xs text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 flex items-center justify-between dark:text-slate-200 dark:hover:bg-slate-700">
                                <span>Dimas Anggara</span>
                                <span class="rounded bg-emerald-100 px-1.5 py-0.5 text-[10px] font-bold text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300">Karyawan</span>
                            </button>
                        </form>
                        <hr class="my-2 border-slate-100 dark:border-slate-700" />
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full rounded-lg px-2.5 py-1.5 text-left text-xs font-semibold text-rose-600 hover:bg-rose-50 dark:text-rose-400 dark:hover:bg-rose-950/50">
                                Keluar Sistem (Logout)
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>
    @endauth

    <!-- Flash Messages -->
    <div class="mx-auto w-full max-w-7xl px-4 pt-4 sm:px-6 lg:px-8">
        @if(session('success'))
        <div class="mb-4 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50/90 p-4 text-sm text-emerald-800 shadow-sm dark:border-emerald-900/50 dark:bg-emerald-950/40 dark:text-emerald-300">
            <svg class="h-5 w-5 shrink-0 text-emerald-600 dark:text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
            </svg>
            <div class="font-medium">{{ session('success') }}</div>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-4 rounded-xl border border-rose-200 bg-rose-50/90 p-4 text-sm text-rose-800 shadow-sm dark:border-rose-900/50 dark:bg-rose-950/40 dark:text-rose-300">
            <div class="font-semibold mb-1">Terjadi kesalahan pada input:</div>
            <ul class="list-disc pl-5 space-y-0.5 text-xs">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>

    <!-- Main Content Area -->
    <main class="flex-1 pb-12">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="mt-auto border-t border-slate-200 bg-white py-6 text-center text-xs text-slate-500 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-400">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <span class="font-semibold text-slate-700 dark:text-slate-300">SmartDesk AI</span> — MVP Sistem IT Service Management Berbasis Laravel 13 + LLM Lokal
            </div>
            <div class="flex items-center gap-4 text-slate-400">
                <span>Versi 1.0 (MVP)</span>
                <span>•</span>
                <span>Prinsip: AI Merekomendasikan, Laravel Mengendalikan</span>
            </div>
        </div>
    </footer>

</body>
</html>
