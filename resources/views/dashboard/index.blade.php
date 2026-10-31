<x-layouts.app title="Dashboard Layanan IT - SmartDesk AI">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-6 space-y-8">

        <!-- Welcome Banner & Role Badge -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 p-6 sm:p-8 text-white shadow-xl">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1 text-xs font-semibold backdrop-blur-md mb-3 text-indigo-200">
                        <span class="inline-block h-2 w-2 rounded-full bg-emerald-400 animate-ping"></span>
                        Aktor Aktif: <strong class="text-white">{{ Auth::user()->role->label() }}</strong> ({{ Auth::user()->department ?? 'Operasional' }})
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
                        Selamat Datang, {{ Auth::user()->name }}
                    </h1>
                    <p class="mt-2 text-sm sm:text-base text-slate-300 max-w-2xl">
                        SmartDesk AI siap membantu klasifikasi cerdas, ringkasan masalah, dan rekomendasi langkah perbaikan IT Service Management.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('tickets.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-indigo-500 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-indigo-500/30 hover:bg-indigo-400 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Buat Laporan Baru</span>
                    </a>
                    <a href="{{ route('knowledge.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-white/10 px-4 py-2.5 text-sm font-semibold text-white backdrop-blur-md hover:bg-white/20 transition">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <span>Cari Solusi Mandiri</span>
                    </a>
                </div>
            </div>
            <!-- Decorative circle gradient background -->
            <div class="absolute -right-10 -bottom-10 h-64 w-64 rounded-full bg-indigo-500/20 blur-3xl pointer-events-none"></div>
        </div>

        <!-- Metric Cards -->
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
            <!-- Total -->
            <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Total Tiket</span>
                <div class="mt-2 flex items-baseline justify-between">
                    <span class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">{{ $stats['total'] }}</span>
                    <span class="text-xs text-slate-400">semua status</span>
                </div>
            </div>

            <!-- Open -->
            <div class="rounded-2xl border border-sky-100 bg-sky-50/50 p-4 shadow-sm dark:border-sky-950 dark:bg-sky-950/20">
                <span class="text-xs font-semibold text-sky-700 dark:text-sky-300">Open (Baru)</span>
                <div class="mt-2 flex items-baseline justify-between">
                    <span class="text-2xl font-bold tracking-tight text-sky-900 dark:text-sky-200">{{ $stats['open'] }}</span>
                    <span class="h-2 w-2 rounded-full bg-sky-500"></span>
                </div>
            </div>

            <!-- In Progress -->
            <div class="rounded-2xl border border-indigo-100 bg-indigo-50/50 p-4 shadow-sm dark:border-indigo-950 dark:bg-indigo-950/20">
                <span class="text-xs font-semibold text-indigo-700 dark:text-indigo-300">In Progress</span>
                <div class="mt-2 flex items-baseline justify-between">
                    <span class="text-2xl font-bold tracking-tight text-indigo-900 dark:text-indigo-200">{{ $stats['in_progress'] }}</span>
                    <span class="h-2 w-2 rounded-full bg-indigo-500 animate-pulse"></span>
                </div>
            </div>

            <!-- Waiting -->
            <div class="rounded-2xl border border-amber-100 bg-amber-50/50 p-4 shadow-sm dark:border-amber-950 dark:bg-amber-950/20">
                <span class="text-xs font-semibold text-amber-700 dark:text-amber-300">Waiting User</span>
                <div class="mt-2 flex items-baseline justify-between">
                    <span class="text-2xl font-bold tracking-tight text-amber-900 dark:text-amber-200">{{ $stats['waiting'] }}</span>
                    <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                </div>
            </div>

            <!-- Resolved -->
            <div class="rounded-2xl border border-emerald-100 bg-emerald-50/50 p-4 shadow-sm dark:border-emerald-950 dark:bg-emerald-950/20">
                <span class="text-xs font-semibold text-emerald-700 dark:text-emerald-300">Resolved</span>
                <div class="mt-2 flex items-baseline justify-between">
                    <span class="text-2xl font-bold tracking-tight text-emerald-900 dark:text-emerald-200">{{ $stats['resolved'] }}</span>
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                </div>
            </div>

            <!-- AI Analyzed -->
            <div class="rounded-2xl border border-purple-100 bg-purple-50/50 p-4 shadow-sm dark:border-purple-950 dark:bg-purple-950/20">
                <span class="text-xs font-semibold text-purple-700 dark:text-purple-300 flex items-center gap-1">
                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    AI Assisted
                </span>
                <div class="mt-2 flex items-baseline justify-between">
                    <span class="text-2xl font-bold tracking-tight text-purple-900 dark:text-purple-200">{{ $stats['ai_assisted'] }}</span>
                    <span class="text-[10px] text-purple-600 font-medium">Auto-analyzed</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            
            <!-- Left 2 Cols: Recent Tickets -->
            <div class="lg:col-span-2 space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white">Daftar Tiket Terbaru</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            {{ Auth::user()->isEmployee() ? 'Tiket yang Anda laporkan ke tim IT' : 'Antrean tiket layanan masuk' }}
                        </p>
                    </div>
                    <a href="{{ route('tickets.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
                        Lihat Semua &rarr;
                    </a>
                </div>

                <div class="divide-y divide-slate-100 rounded-2xl border border-slate-200 bg-white shadow-sm dark:divide-slate-800 dark:border-slate-800 dark:bg-slate-900 overflow-hidden">
                    @forelse($recentTickets as $ticket)
                    <div class="p-4 sm:p-5 hover:bg-slate-50/70 dark:hover:bg-slate-800/50 transition">
                        <div class="flex items-start justify-between gap-4">
                            <div class="space-y-1.5 flex-1 min-w-0">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="text-xs font-mono font-bold text-indigo-600 dark:text-indigo-400">
                                        {{ $ticket->ticket_number }}
                                    </span>
                                    
                                    <!-- Status Badge -->
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs font-medium ring-1 ring-inset {{ $ticket->status->badgeClasses() }}">
                                        {{ $ticket->status->label() }}
                                    </span>

                                    <!-- Priority Badge -->
                                    <span class="inline-flex items-center rounded-full px-2 py-0.5 text-[11px] font-medium ring-1 ring-inset {{ $ticket->priority->badgeClasses() }}">
                                        {{ $ticket->priority->label() }}
                                    </span>

                                    <!-- Category -->
                                    @if($ticket->category)
                                    <span class="rounded bg-slate-100 px-2 py-0.5 text-[11px] text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                        {{ $ticket->category->name }}
                                    </span>
                                    @endif
                                </div>

                                <h3 class="text-sm font-semibold text-slate-900 dark:text-white truncate">
                                    <a href="{{ route('tickets.show', $ticket) }}" class="hover:underline">
                                        {{ $ticket->title }}
                                    </a>
                                </h3>

                                <!-- AI Summary Preview -->
                                @if($ticket->ai_summary)
                                <div class="flex items-start gap-1.5 text-xs text-purple-700 bg-purple-50/80 rounded-lg p-2 dark:bg-purple-950/40 dark:text-purple-300">
                                    <svg class="h-3.5 w-3.5 shrink-0 mt-0.5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    <span class="truncate"><strong class="font-semibold">AI Summary:</strong> {{ $ticket->ai_summary }}</span>
                                </div>
                                @endif

                                <div class="flex items-center gap-4 text-xs text-slate-500 dark:text-slate-400 pt-1">
                                    <span>Pelapor: <strong class="text-slate-700 dark:text-slate-300">{{ $ticket->creator->name }}</strong></span>
                                    <span>•</span>
                                    <span>Teknisi: <strong class="text-slate-700 dark:text-slate-300">{{ $ticket->assignee ? $ticket->assignee->name : 'Belum ditugaskan' }}</strong></span>
                                    <span>•</span>
                                    <span>{{ $ticket->created_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            <a href="{{ route('tickets.show', $ticket) }}" class="rounded-lg border border-slate-200 bg-white p-2 text-slate-500 hover:border-indigo-400 hover:text-indigo-600 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-400 dark:hover:text-white transition">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center">
                        <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada tiket laporan yang terdaftar.</p>
                        <a href="{{ route('tickets.create') }}" class="mt-3 inline-block text-xs font-semibold text-indigo-600 hover:underline">
                            + Buat Tiket Pertama
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Right 1 Col: AI Assistant Info & Knowledge Base -->
            <div class="space-y-6">
                <!-- AI Engine Card -->
                <div class="rounded-2xl border border-indigo-100 bg-gradient-to-br from-indigo-50/70 to-purple-50/70 p-5 shadow-sm dark:border-indigo-950 dark:from-indigo-950/40 dark:to-purple-950/30">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-indigo-600 text-white shadow-md shadow-indigo-500/20">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white">SmartDesk AI Engine</h3>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">Prinsip Asisten Cerdas</p>
                        </div>
                    </div>
                    <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed mb-3">
                        Setiap tiket secara otomatis dianalisis untuk menyarankan:
                    </p>
                    <ul class="text-xs text-slate-700 dark:text-slate-300 space-y-2 mb-4">
                        <li class="flex items-center gap-2">
                            <span class="flex h-4 w-4 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300 text-[10px]">✓</span>
                            <span>Kategori IT yang relevan</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="flex h-4 w-4 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300 text-[10px]">✓</span>
                            <span>Tingkat urgensi / prioritas awal</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="flex h-4 w-4 items-center justify-center rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300 text-[10px]">✓</span>
                            <span>Langkah troubleshooting awal bagi teknisi</span>
                        </li>
                    </ul>
                    <div class="rounded-xl border border-indigo-200/60 bg-white/80 p-3 text-[11px] text-indigo-900 dark:border-indigo-900/50 dark:bg-slate-900/80 dark:text-indigo-300">
                        <span class="font-bold">🛡️ Aturan Keamanan:</span> AI tidak pernah mengubah status secara sepihak. Teknisi dan Laravel memegang kendali penuh.
                    </div>
                </div>

                <!-- Knowledge Base Articles -->
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-bold text-slate-900 dark:text-white">Panduan Solusi Mandiri</h3>
                        <a href="{{ route('knowledge.index') }}" class="text-xs text-indigo-600 hover:underline">Semua</a>
                    </div>
                    <div class="space-y-3">
                        @foreach($popularArticles as $article)
                        <a href="{{ route('knowledge.show', $article) }}" class="block rounded-xl border border-slate-100 p-3 hover:border-indigo-300 hover:bg-indigo-50/30 transition dark:border-slate-800 dark:hover:border-slate-700">
                            <div class="text-xs font-semibold text-slate-800 dark:text-slate-200 line-clamp-1">
                                {{ $article->title }}
                            </div>
                            <div class="mt-1 flex items-center justify-between text-[11px] text-slate-400">
                                <span>{{ $article->category->name ?? 'Umum' }}</span>
                                <span>{{ $article->views_count }}x dibaca</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

    </div>
</x-layouts.app>
