<x-layouts.app title="Daftar Tiket Layanan - SmartDesk AI">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-6 space-y-6">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Tiket Layanan IT</h1>
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Kelola, pantau, dan selesaikan kendala teknis dengan bantuan asistensi AI.
                </p>
            </div>
            <a href="{{ route('tickets.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>+ Buat Tiket Baru</span>
            </a>
        </div>

        <!-- Filter Bar -->
        <form method="GET" action="{{ route('tickets.index') }}" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3">
                <!-- Search -->
                <div class="md:col-span-2">
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Cari Tiket / Judul</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode tiket atau kata kunci..."
                            class="w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-1.5 text-xs text-slate-900 placeholder:text-slate-400 focus:bg-white focus:border-indigo-500 focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Status</label>
                    <select name="status" class="w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-1.5 text-xs text-slate-900 focus:bg-white focus:border-indigo-500 focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                        <option value="">Semua Status</option>
                        @foreach(App\Enums\TicketStatus::cases() as $st)
                            <option value="{{ $st->value }}" {{ request('status') === $st->value ? 'selected' : '' }}>
                                {{ $st->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Priority Filter -->
                <div>
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Prioritas</label>
                    <select name="priority" class="w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-1.5 text-xs text-slate-900 focus:bg-white focus:border-indigo-500 focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                        <option value="">Semua Prioritas</option>
                        @foreach(App\Enums\TicketPriority::cases() as $pr)
                            <option value="{{ $pr->value }}" {{ request('priority') === $pr->value ? 'selected' : '' }}>
                                {{ $pr->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Category Filter & Submit -->
                <div class="flex items-end gap-2">
                    <div class="flex-1">
                        <label class="block text-[11px] font-semibold text-slate-500 mb-1">Kategori</label>
                        <select name="category_id" class="w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-1.5 text-xs text-slate-900 focus:bg-white focus:border-indigo-500 focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="rounded-lg bg-slate-900 px-3 py-2 text-xs font-semibold text-white hover:bg-slate-800 dark:bg-indigo-600 dark:hover:bg-indigo-500 transition">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'status', 'priority', 'category_id', 'scope']))
                    <a href="{{ route('tickets.index') }}" class="rounded-lg border border-slate-200 p-2 text-xs text-slate-600 hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                        Reset
                    </a>
                    @endif
                </div>
            </div>
        </form>

        <!-- Table List -->
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-slate-600 dark:text-slate-300">
                    <thead class="border-b border-slate-200 bg-slate-50 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:border-slate-800 dark:bg-slate-800/60 dark:text-slate-400">
                        <tr>
                            <th class="px-5 py-3.5">Kode & Tanggal</th>
                            <th class="px-5 py-3.5">Judul & Ringkasan AI</th>
                            <th class="px-5 py-3.5">Status</th>
                            <th class="px-5 py-3.5">Prioritas</th>
                            <th class="px-5 py-3.5">Pelapor</th>
                            <th class="px-5 py-3.5">Teknisi Bertugas</th>
                            <th class="px-5 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($tickets as $ticket)
                        <tr class="hover:bg-slate-50/70 transition dark:hover:bg-slate-800/40">
                            <!-- Code -->
                            <td class="whitespace-nowrap px-5 py-4 font-mono font-semibold text-indigo-600 dark:text-indigo-400">
                                <div>{{ $ticket->ticket_number }}</div>
                                <div class="text-[10px] font-sans font-normal text-slate-400">{{ $ticket->created_at->format('d M Y, H:i') }}</div>
                            </td>

                            <!-- Title & AI Preview -->
                            <td class="px-5 py-4 max-w-sm">
                                <a href="{{ route('tickets.show', $ticket) }}" class="font-semibold text-slate-900 hover:text-indigo-600 dark:text-white dark:hover:text-indigo-400">
                                    {{ $ticket->title }}
                                </a>
                                @if($ticket->category)
                                <div class="mt-0.5">
                                    <span class="inline-block rounded bg-slate-100 px-1.5 py-0.5 text-[10px] text-slate-600 dark:bg-slate-800 dark:text-slate-400">
                                        {{ $ticket->category->name }}
                                    </span>
                                </div>
                                @endif
                                @if($ticket->ai_summary)
                                <div class="mt-1 flex items-center gap-1 text-[11px] text-purple-700 dark:text-purple-300">
                                    <svg class="h-3 w-3 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    <span class="truncate">{{ $ticket->ai_summary }}</span>
                                </div>
                                @endif
                            </td>

                            <!-- Status -->
                            <td class="whitespace-nowrap px-5 py-4">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset {{ $ticket->status->badgeClasses() }}">
                                    {{ $ticket->status->label() }}
                                </span>
                            </td>

                            <!-- Priority -->
                            <td class="whitespace-nowrap px-5 py-4">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset {{ $ticket->priority->badgeClasses() }}">
                                    {{ $ticket->priority->label() }}
                                </span>
                            </td>

                            <!-- Creator -->
                            <td class="whitespace-nowrap px-5 py-4 text-slate-800 dark:text-slate-200">
                                <div class="font-medium">{{ $ticket->creator->name }}</div>
                                <div class="text-[10px] text-slate-400">{{ $ticket->creator->department ?? 'Staff' }}</div>
                            </td>

                            <!-- Assignee -->
                            <td class="whitespace-nowrap px-5 py-4">
                                @if($ticket->assignee)
                                    <div class="flex items-center gap-1.5">
                                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                        <span class="font-medium text-slate-800 dark:text-slate-200">{{ $ticket->assignee->name }}</span>
                                    </div>
                                @else
                                    <span class="italic text-slate-400">Belum Ditugaskan</span>
                                @endif
                            </td>

                            <!-- Action -->
                            <td class="whitespace-nowrap px-5 py-4 text-right">
                                <a href="{{ route('tickets.show', $ticket) }}" class="inline-flex items-center gap-1 rounded-lg border border-slate-200 px-2.5 py-1 text-xs font-medium text-slate-700 hover:bg-slate-100 hover:text-indigo-600 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800 transition">
                                    <span>Detail</span>
                                    <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-slate-400">
                                Tidak ada tiket yang sesuai dengan kriteria filter.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($tickets->hasPages())
            <div class="border-t border-slate-200 px-5 py-3 dark:border-slate-800">
                {{ $tickets->links() }}
            </div>
            @endif
        </div>

    </div>
</x-layouts.app>
