<x-layouts.app title="Basis Pengetahuan & Troubleshooting - SmartDesk AI">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-6 space-y-6">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                    Basis Pengetahuan IT (Knowledge Base)
                </h1>
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Kumpulan panduan mandiri, SOP, dan solusi gangguan IT yang sering terjadi di perusahaan.
                </p>
            </div>
            @if(!Auth::user()->isEmployee())
            <a href="{{ route('knowledge.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 transition">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>+ Buat Artikel SOP Baru</span>
            </a>
            @endif
        </div>

        <!-- Search Bar -->
        <form method="GET" action="{{ route('knowledge.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari solusi kendala (misal: Wi-Fi, printer, email, password)..."
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-xs text-slate-900 placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-white">
            </div>
            <div class="sm:w-56">
                <select name="category_id" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-xs text-slate-900 focus:border-indigo-500 focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="rounded-xl bg-slate-900 px-5 py-2.5 text-xs font-semibold text-white hover:bg-slate-800 dark:bg-indigo-600 dark:hover:bg-indigo-500 transition">
                Cari Panduan
            </button>
        </form>

        <!-- Articles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($articles as $art)
            <div class="flex flex-col rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:shadow-md hover:border-indigo-300 transition dark:border-slate-800 dark:bg-slate-900 dark:hover:border-slate-700">
                <div class="flex items-center justify-between text-[11px] text-slate-400 mb-2">
                    <span class="rounded bg-indigo-50 px-2 py-0.5 font-medium text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">
                        {{ $art->category->name ?? 'Umum' }}
                    </span>
                    <span>{{ $art->views_count }} views</span>
                </div>

                <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-2 line-clamp-2">
                    <a href="{{ route('knowledge.show', $art) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                        {{ $art->title }}
                    </a>
                </h3>

                <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-3 leading-relaxed mb-4 flex-1">
                    {{ Str::limit(strip_tags($art->content), 120) }}
                </p>

                <div class="flex items-center justify-between pt-3 border-t border-slate-100 dark:border-slate-800 text-[11px] text-slate-400">
                    <span>Oleh {{ $art->author->name }}</span>
                    <a href="{{ route('knowledge.show', $art) }}" class="font-semibold text-indigo-600 hover:underline dark:text-indigo-400">
                        Baca Selengkapnya &rarr;
                    </a>
                </div>
            </div>
            @empty
            <div class="col-span-3 rounded-2xl border border-slate-200 bg-white p-12 text-center text-slate-400 dark:border-slate-800 dark:bg-slate-900">
                <p class="text-sm">Tidak ditemukan artikel knowledge base yang cocok dengan pencarian.</p>
            </div>
            @endforelse
        </div>

        @if($articles->hasPages())
        <div class="pt-4">
            {{ $articles->links() }}
        </div>
        @endif

    </div>
</x-layouts.app>
