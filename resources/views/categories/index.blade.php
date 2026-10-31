<x-layouts.app title="Kelola Kategori Masalah IT - SmartDesk AI">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pt-6 space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <nav class="flex items-center gap-2 text-xs text-slate-500 mb-1">
                    <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
                    <span>/</span>
                    <span class="text-slate-800 dark:text-slate-200 font-semibold">Kategori Masalah</span>
                </nav>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                    Kelola Kategori Tiket IT
                </h1>
                <p class="text-xs text-slate-500 dark:text-slate-400">
                    Pengaturan kelompok masalah IT untuk pengelompokan penanganan dan klasifikasi model AI.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- List of Categories (2 Cols) -->
            <div class="lg:col-span-2 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($categories as $category)
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="rounded-lg bg-indigo-50 p-2 text-indigo-600 dark:bg-indigo-950 dark:text-indigo-400">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                    </svg>
                                </span>
                                <span class="text-[11px] font-mono text-slate-400">slug: {{ $category->slug }}</span>
                            </div>
                            <h3 class="text-sm font-bold text-slate-900 dark:text-white mb-1">
                                {{ $category->name }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed mb-4">
                                {{ $category->description ?? 'Tidak ada deskripsi rinci.' }}
                            </p>
                        </div>

                        <div class="flex items-center justify-between pt-3 border-t border-slate-100 dark:border-slate-800 text-xs text-slate-500">
                            <span>{{ $category->tickets_count }} Tiket Tercatat</span>
                            <span>{{ $category->articles_count }} Artikel SOP</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Create New Category (1 Col) -->
            <div>
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                        Tambah Kategori Baru
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Kategori yang baru ditambahkan akan langsung dimasukkan ke opsi klasifikasi AI.
                    </p>

                    <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="name" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Nama Kategori <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" required placeholder="Contoh: Database & Backup"
                                class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 py-2 text-xs text-slate-900 placeholder:text-slate-400 focus:bg-white focus:border-indigo-500 focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                        </div>

                        <div>
                            <label for="description" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                                Deskripsi Masalah
                            </label>
                            <textarea name="description" id="description" rows="3" placeholder="Jelaskan jenis gangguan atau permintaan yang termasuk dalam kategori ini..."
                                class="w-full rounded-xl border border-slate-300 bg-slate-50 p-2.5 text-xs text-slate-900 focus:bg-white focus:border-indigo-500 focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-white"></textarea>
                        </div>

                        <button type="submit" class="w-full rounded-xl bg-indigo-600 py-2.5 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 transition">
                            Simpan Kategori Baru
                        </button>
                    </form>
                </div>
            </div>

        </div>

    </div>
</x-layouts.app>
