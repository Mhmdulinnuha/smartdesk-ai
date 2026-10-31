<x-layouts.app :title="$ticket->ticket_number . ' - ' . $ticket->title">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-6 space-y-6">

        <!-- Top Breadcrumb & Status Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 pb-4 dark:border-slate-800">
            <div>
                <nav class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                    <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
                    <span>/</span>
                    <a href="{{ route('tickets.index') }}" class="hover:underline">Tiket</a>
                    <span>/</span>
                    <span class="font-mono font-semibold text-indigo-600 dark:text-indigo-400">{{ $ticket->ticket_number }}</span>
                </nav>
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-xl sm:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                        {{ $ticket->title }}
                    </h1>
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset {{ $ticket->status->badgeClasses() }}">
                        {{ $ticket->status->label() }}
                    </span>
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset {{ $ticket->priority->badgeClasses() }}">
                        {{ $ticket->priority->label() }}
                    </span>
                </div>
            </div>

            <!-- Header Actions -->
            <div class="flex items-center gap-2">
                <a href="{{ route('tickets.index') }}" class="rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                    &larr; Kembali
                </a>
            </div>
        </div>

        <!-- Main 2-Column Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Left 2 Cols: Details, AI Card, Conversation, Resolution -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Ticket Description Box -->
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 space-y-4">
                    <div class="flex items-center justify-between text-xs text-slate-500">
                        <div class="flex items-center gap-2">
                            <img src="{{ $ticket->creator->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($ticket->creator->name) }}" class="h-6 w-6 rounded-full object-cover">
                            <span>Dilaporkan oleh <strong class="text-slate-800 dark:text-slate-200">{{ $ticket->creator->name }}</strong> ({{ $ticket->creator->department ?? 'Staff' }})</span>
                        </div>
                        <time>{{ $ticket->created_at->format('d M Y, H:i') }}</time>
                    </div>

                    <div class="text-xs sm:text-sm text-slate-800 dark:text-slate-200 whitespace-pre-line leading-relaxed border-t border-slate-100 pt-3 dark:border-slate-800">
                        {{ $ticket->description }}
                    </div>
                </div>

                <!-- AI Insight & Troubleshooting Recommendations Card (MVP Core Feature) -->
                @if($ticket->ai_summary || $ticket->ai_suggestion)
                <div class="rounded-2xl border border-purple-200 bg-gradient-to-br from-purple-50/90 via-indigo-50/50 to-white p-6 shadow-sm dark:border-purple-900/60 dark:from-purple-950/40 dark:via-indigo-950/20 dark:to-slate-900 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex items-center gap-2.5">
                            <div class="flex h-8 w-8 items-center justify-center rounded-xl bg-purple-600 text-white shadow-md shadow-purple-500/20">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                    SmartDesk AI - Analisis & Rekomendasi
                                    <span class="rounded bg-purple-200/80 px-1.5 py-0.5 text-[10px] font-bold text-purple-800 dark:bg-purple-900 dark:text-purple-300">
                                        {{ $ticket->ai_confidence['source'] ?? 'AI Assisted' }}
                                    </span>
                                </h3>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400">
                                    Hasil klasifikasi awal dan saran troubleshooting untuk ditinjau teknisi.
                                </p>
                            </div>
                        </div>

                        <!-- Apply Suggestion Button for Technician / Admin -->
                        @if(!Auth::user()->isEmployee() && ($ticket->ai_suggested_priority !== $ticket->priority->value || ($ticket->ai_suggested_category && $ticket->category?->name !== $ticket->ai_suggested_category)))
                        <form method="POST" action="{{ route('tickets.apply-ai', $ticket) }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-purple-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm hover:bg-purple-500 transition">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>Terapkan Rekomendasi AI</span>
                            </button>
                        </form>
                        @endif
                    </div>

                    <!-- AI Summary -->
                    @if($ticket->ai_summary)
                    <div class="rounded-xl border border-purple-200/80 bg-white/80 p-3.5 text-xs text-slate-800 dark:border-purple-900/40 dark:bg-slate-900/70 dark:text-slate-200">
                        <strong class="font-semibold text-purple-900 dark:text-purple-300">Ringkasan Inti:</strong>
                        <p class="mt-0.5 leading-relaxed">{{ $ticket->ai_summary }}</p>
                    </div>
                    @endif

                    <!-- Suggested Metrics -->
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="rounded-xl border border-slate-200 bg-white/70 p-3 dark:border-slate-800 dark:bg-slate-900/60">
                            <span class="text-[10px] font-medium text-slate-400 block uppercase">Saran Kategori</span>
                            <span class="font-bold text-slate-800 dark:text-white">{{ $ticket->ai_suggested_category ?? '-' }}</span>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-white/70 p-3 dark:border-slate-800 dark:bg-slate-900/60">
                            <span class="text-[10px] font-medium text-slate-400 block uppercase">Saran Prioritas</span>
                            <span class="font-bold uppercase text-purple-700 dark:text-purple-300">{{ $ticket->ai_suggested_priority ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- AI Troubleshooting Steps -->
                    @if($ticket->ai_suggestion)
                    <div class="rounded-xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900 space-y-1.5">
                        <div class="flex items-center gap-1.5 text-xs font-bold text-slate-800 dark:text-slate-200">
                            <svg class="h-4 w-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            <span>Langkah Troubleshooting yang Disarankan:</span>
                        </div>
                        <pre class="font-sans text-xs text-slate-600 dark:text-slate-300 whitespace-pre-wrap leading-relaxed">{{ $ticket->ai_suggestion }}</pre>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Resolution Note (if Resolved / Closed) -->
                @if($ticket->resolution_notes)
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50/80 p-5 dark:border-emerald-900/50 dark:bg-emerald-950/30 space-y-2">
                    <div class="flex items-center gap-2 text-xs font-bold text-emerald-900 dark:text-emerald-300">
                        <svg class="h-5 w-5 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                        <span>Catatan Penyelesaian Masalah (Resolution Note):</span>
                    </div>
                    <p class="text-xs text-emerald-800 dark:text-emerald-200 leading-relaxed pl-7">
                        {{ $ticket->resolution_notes }}
                    </p>
                    <div class="text-[11px] text-emerald-600 dark:text-emerald-400 pl-7">
                        Diselesaikan pada: {{ $ticket->resolved_at?->format('d M Y, H:i') }}
                    </div>
                </div>
                @endif

                <!-- Comments & Timeline Section -->
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 space-y-6">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center justify-between">
                        <span>Percakapan & Catatan Tiket</span>
                        <span class="text-xs font-normal text-slate-400">{{ $ticket->comments->count() }} pesan</span>
                    </h3>

                    <!-- Message Feed -->
                    <div class="space-y-4">
                        @forelse($ticket->comments as $comment)
                            @if(!$comment->is_internal || !Auth::user()->isEmployee())
                            <div class="rounded-xl border p-4 text-xs space-y-2 
                                {{ $comment->is_internal 
                                    ? 'border-amber-200 bg-amber-50/70 dark:border-amber-900/60 dark:bg-amber-950/30' 
                                    : 'border-slate-200 bg-slate-50/50 dark:border-slate-800 dark:bg-slate-800/40' 
                                }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $comment->user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($comment->user->name) }}" class="h-5 w-5 rounded-full object-cover">
                                        <strong class="text-slate-800 dark:text-slate-200">{{ $comment->user->name }}</strong>
                                        <span class="rounded bg-slate-200/80 px-1.5 py-0.2 text-[10px] text-slate-600 dark:bg-slate-700 dark:text-slate-300">
                                            {{ $comment->user->role->label() }}
                                        </span>
                                        @if($comment->is_internal)
                                        <span class="rounded bg-amber-200 px-1.5 py-0.2 text-[10px] font-bold text-amber-900 dark:bg-amber-900 dark:text-amber-200">
                                            🔒 Catatan Internal Teknisi
                                        </span>
                                        @endif
                                    </div>
                                    <time class="text-[11px] text-slate-400">{{ $comment->created_at->diffForHumans() }}</time>
                                </div>
                                <p class="text-slate-700 dark:text-slate-300 whitespace-pre-wrap leading-relaxed">{{ $comment->message }}</p>
                            </div>
                            @endif
                        @empty
                            <p class="text-xs text-slate-400 italic py-2 text-center">Belum ada percakapan pada tiket ini.</p>
                        @endforelse
                    </div>

                    <!-- New Comment Form -->
                    <form action="{{ route('tickets.comments.store', $ticket) }}" method="POST" class="pt-4 border-t border-slate-100 dark:border-slate-800 space-y-3">
                        @csrf
                        <div>
                            <label for="message" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Tambah Komentar / Catatan
                            </label>
                            <textarea name="message" id="message" rows="3" required placeholder="Tuliskan pesan balasan atau informasi tambahan..."
                                class="w-full rounded-xl border border-slate-300 bg-slate-50 p-3 text-xs text-slate-900 focus:bg-white focus:border-indigo-500 focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-white"></textarea>
                        </div>

                        <div class="flex items-center justify-between">
                            @if(!Auth::user()->isEmployee())
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="is_internal" value="1" class="h-4 w-4 rounded border-slate-300 text-amber-600 focus:ring-amber-500">
                                <span class="text-xs text-slate-600 dark:text-slate-400">Jadikan Catatan Internal (Hanya Teknisi/Admin yang melihat)</span>
                            </label>
                            @else
                            <div></div>
                            @endif

                            <button type="submit" class="rounded-xl bg-indigo-600 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 transition">
                                Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>

            </div>

            <!-- Right 1 Col: Management Sidebar (Status, Assignee, Activities) -->
            <div class="space-y-6">

                <!-- Workflow Action Card -->
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 space-y-5">
                    <h3 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                        Kontrol Workflow & Status
                    </h3>

                    <!-- Status Update Form -->
                    <form action="{{ route('tickets.status', $ticket) }}" method="POST" class="space-y-3" id="statusForm">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="status" class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">
                                Ubah Status Tiket
                            </label>
                            <select name="status" id="statusSelect" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2 text-xs text-slate-900 focus:bg-white focus:border-indigo-500 focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                @foreach(App\Enums\TicketStatus::cases() as $st)
                                    @if(Auth::user()->isEmployee() && !in_array($st->value, ['closed']))
                                        @continue
                                    @endif
                                    <option value="{{ $st->value }}" {{ $ticket->status->value === $st->value ? 'selected' : '' }}>
                                        {{ $st->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Resolution Notes required if Resolved -->
                        <div id="resolutionField" class="{{ $ticket->status->value === 'resolved' ? '' : 'hidden' }} space-y-1">
                            <label for="resolution_notes" class="block text-xs font-semibold text-emerald-700 dark:text-emerald-400">
                                Catatan Solusi / Penyelesaian <span class="text-rose-500">*</span>
                            </label>
                            <textarea name="resolution_notes" id="resolution_notes" rows="3" placeholder="Jelaskan tindakan yang telah diambil untuk menyelesaikan masalah..."
                                class="w-full rounded-xl border border-slate-300 bg-slate-50 p-2 text-xs text-slate-900 focus:bg-white focus:border-emerald-500 focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-white">{{ $ticket->resolution_notes }}</textarea>
                        </div>

                        <button type="submit" class="w-full rounded-xl bg-slate-900 py-2 text-xs font-semibold text-white hover:bg-slate-800 dark:bg-indigo-600 dark:hover:bg-indigo-500 transition">
                            Simpan Perubahan Status
                        </button>
                    </form>

                    <!-- Technician Assignment Form (Admin / Technician only) -->
                    @if(!Auth::user()->isEmployee())
                    <hr class="border-slate-100 dark:border-slate-800" />
                    <form action="{{ route('tickets.assign', $ticket) }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="assigned_to" class="block text-xs font-medium text-slate-600 dark:text-slate-400 mb-1">
                                Teknisi yang Ditugaskan
                            </label>
                            <select name="assigned_to" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2 text-xs text-slate-900 focus:bg-white focus:border-indigo-500 focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                <option value="">-- Belum Ditugaskan --</option>
                                @foreach($technicians as $tech)
                                    <option value="{{ $tech->id }}" {{ $ticket->assigned_to == $tech->id ? 'selected' : '' }}>
                                        {{ $tech->name }} ({{ $tech->department ?? 'Support' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="w-full rounded-xl border border-slate-300 bg-white py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 transition">
                            Perbarui Penugasan
                        </button>
                    </form>
                    @endif
                </div>

                <!-- Ticket Metadata Summary -->
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 space-y-3 text-xs">
                    <h3 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                        Informasi Tiket
                    </h3>
                    <div class="divide-y divide-slate-100 dark:divide-slate-800">
                        <div class="py-2 flex justify-between">
                            <span class="text-slate-400">Nomor Tiket</span>
                            <span class="font-mono font-bold text-indigo-600 dark:text-indigo-400">{{ $ticket->ticket_number }}</span>
                        </div>
                        <div class="py-2 flex justify-between">
                            <span class="text-slate-400">Kategori</span>
                            <span class="font-semibold text-slate-800 dark:text-white">{{ $ticket->category->name ?? 'Belum ditentukan' }}</span>
                        </div>
                        <div class="py-2 flex justify-between">
                            <span class="text-slate-400">Prioritas</span>
                            <span class="font-semibold capitalize text-slate-800 dark:text-white">{{ $ticket->priority->label() }}</span>
                        </div>
                        <div class="py-2 flex justify-between">
                            <span class="text-slate-400">Dibuat</span>
                            <span class="text-slate-800 dark:text-slate-200">{{ $ticket->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        @if($ticket->resolved_at)
                        <div class="py-2 flex justify-between">
                            <span class="text-slate-400">Diselesaikan</span>
                            <span class="text-slate-800 dark:text-slate-200">{{ $ticket->resolved_at->format('d M Y, H:i') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Audit Trail (ticket_activities) -->
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 space-y-3">
                    <h3 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider flex items-center justify-between">
                        <span>Audit Trail Perubahan</span>
                        <span class="text-[10px] text-slate-400 font-normal">ticket_activities</span>
                    </h3>

                    <div class="space-y-3 border-l-2 border-slate-200 pl-3 dark:border-slate-800">
                        @forelse($ticket->activities as $act)
                            <div class="text-[11px] space-y-0.5">
                                <div class="font-semibold text-slate-800 dark:text-slate-200">
                                    {{ $act->user->name ?? 'Sistem' }}
                                    <span class="font-normal text-slate-400">({{ $act->action }})</span>
                                </div>
                                <div class="text-slate-600 dark:text-slate-400">
                                    @if($act->old_value)
                                        <span class="line-through text-slate-400">{{ $act->old_value }}</span> &rarr;
                                    @endif
                                    <span class="font-medium text-indigo-600 dark:text-indigo-400">{{ $act->new_value }}</span>
                                </div>
                                <div class="text-[10px] text-slate-400">{{ $act->created_at->diffForHumans() }}</div>
                            </div>
                        @empty
                            <p class="text-xs text-slate-400">Belum ada riwayat aktivitas.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

    </div>

    <script>
        const statusSelect = document.getElementById('statusSelect');
        const resField = document.getElementById('resolutionField');

        if (statusSelect && resField) {
            statusSelect.addEventListener('change', function() {
                if (this.value === 'resolved') {
                    resField.classList.remove('hidden');
                    document.getElementById('resolution_notes').focus();
                } else {
                    resField.classList.add('hidden');
                }
            });
        }
    </script>
</x-layouts.app>
