<x-layouts.app :title="$article->title . ' - Knowledge Base'">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 pt-6 space-y-6">

        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs text-slate-500">
            <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
            <span>/</span>
            <a href="{{ route('knowledge.index') }}" class="hover:underline">Basis Pengetahuan</a>
            <span>/</span>
            <span class="truncate max-w-xs text-slate-800 dark:text-slate-200 font-semibold">{{ $article->title }}</span>
        </nav>

        <!-- Article Container -->
        <article class="rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm dark:border-slate-800 dark:bg-slate-900 space-y-6">
            <header class="space-y-3 border-b border-slate-100 pb-6 dark:border-slate-800">
                <div class="flex items-center gap-2">
                    <span class="rounded bg-indigo-50 px-2.5 py-1 text-xs font-semibold text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">
                        {{ $article->category->name ?? 'Umum' }}
                    </span>
                    <span class="text-xs text-slate-400">•</span>
                    <span class="text-xs text-slate-400">{{ $article->views_count }} kali dibaca</span>
                </div>

                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                    {{ $article->title }}
                </h1>

                <div class="flex items-center gap-2 text-xs text-slate-500">
                    <img src="{{ $article->author->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($article->author->name) }}" class="h-5 w-5 rounded-full object-cover">
                    <span>Ditulis oleh <strong class="text-slate-800 dark:text-slate-200">{{ $article->author->name }}</strong></span>
                    <span>•</span>
                    <span>Diperbarui {{ $article->updated_at->format('d M Y') }}</span>
                </div>
            </header>

            <!-- Article Body -->
            <div class="prose prose-slate max-w-none text-xs sm:text-sm leading-relaxed text-slate-700 dark:text-slate-300 whitespace-pre-line">
                {{ $article->content }}
            </div>

            <!-- Helpful Feedback banner -->
            <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 text-center dark:border-slate-800 dark:bg-slate-800/40">
                <span class="text-xs text-slate-600 dark:text-slate-400">Apakah panduan ini membantu menyelesaikan kendala Anda?</span>
                <div class="mt-2 flex justify-center gap-3">
                    <button type="button" onclick="alert('Terima kasih atas tanggapan Anda!')" class="rounded-lg border border-slate-200 bg-white px-3 py-1 text-xs font-semibold text-slate-700 hover:bg-slate-50 shadow-xs dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                        👍 Ya, Membantu
                    </button>
                    <a href="{{ route('tickets.create') }}" class="rounded-lg bg-indigo-600 px-3 py-1 text-xs font-semibold text-white hover:bg-indigo-500">
                        👎 Masih Butuh Bantuan IT
                    </a>
                </div>
            </div>
        </article>

        <!-- Related articles -->
        @if($relatedArticles->count() > 0)
        <div class="space-y-3 pt-4">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Artikel Terkait dalam Kategori Sama</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                @foreach($relatedArticles as $rel)
                <a href="{{ route('knowledge.show', $rel) }}" class="rounded-xl border border-slate-200 bg-white p-3 hover:border-indigo-300 transition dark:border-slate-800 dark:bg-slate-900">
                    <h4 class="text-xs font-semibold text-slate-800 dark:text-slate-200 line-clamp-2">{{ $rel->title }}</h4>
                    <span class="text-[10px] text-slate-400 mt-2 block">{{ $rel->views_count }} views</span>
                </a>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</x-layouts.app>
