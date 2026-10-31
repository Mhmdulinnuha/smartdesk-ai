<x-layouts.app title="Tulis Artikel Pengetahuan Baru - SmartDesk AI">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8 pt-6 space-y-6">

        <div>
            <nav class="flex items-center gap-2 text-xs text-slate-500 mb-2">
                <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
                <span>/</span>
                <a href="{{ route('knowledge.index') }}" class="hover:underline">Basis Pengetahuan</a>
                <span>/</span>
                <span class="text-slate-800 dark:text-slate-200 font-semibold">Tulis Artikel Baru</span>
            </nav>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                Buat Panduan Troubleshooting (SOP)
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400">
                Dokumentasikan langkah-langkah solusi agar karyawan dapat mengatasi kendala secara mandiri.
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <form action="{{ route('knowledge.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="title" class="block text-xs font-semibold text-slate-700 dark:text-slate-300">
                        Judul Panduan / SOP <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" required value="{{ old('title') }}"
                        placeholder="Contoh: Cara Konfigurasi VPN Kantor Pada Windows 11"
                        class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:border-indigo-500 focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                </div>

                <div>
                    <label for="category_id" class="block text-xs font-semibold text-slate-700 dark:text-slate-300">
                        Kategori Terkait <span class="text-rose-500">*</span>
                    </label>
                    <select name="category_id" id="category_id" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2 text-xs text-slate-900 focus:bg-white focus:border-indigo-500 focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="content" class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">
                        Isi Panduan Troubleshooting <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-[11px] text-slate-400 mb-1">Dukung format langkah terstruktur dengan nomor urut 1, 2, 3.</p>
                    <textarea name="content" id="content" rows="10" required
                        placeholder="Tuliskan petunjuk langkah demi langkah, prasyarat, dan solusi kendala umum..."
                        class="w-full rounded-xl border border-slate-300 bg-slate-50 p-3.5 text-xs text-slate-900 focus:bg-white focus:border-indigo-500 focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-white leading-relaxed">{{ old('content') }}</textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('knowledge.index') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300">
                        Batal
                    </a>
                    <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-2 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 transition">
                        Terbitkan Artikel SOP
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-layouts.app>
