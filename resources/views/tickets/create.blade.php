<x-layouts.app title="Buat Laporan Gangguan IT - SmartDesk AI">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 pt-6 space-y-6">

        <!-- Breadcrumb & Title -->
        <div>
            <nav class="flex items-center gap-2 text-xs text-slate-500 mb-2">
                <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
                <span>/</span>
                <a href="{{ route('tickets.index') }}" class="hover:underline">Tiket</a>
                <span>/</span>
                <span class="text-slate-800 dark:text-slate-200 font-semibold">Buat Tiket Baru</span>
            </nav>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                Buat Laporan Masalah IT
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400">
                Sampaikan kendala teknis Anda. AI SmartDesk akan menganalisis prioritas dan langkah awal penanganannya secara otomatis.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Form Column (2 Cols) -->
            <div class="md:col-span-2">
                <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <form action="{{ route('tickets.store') }}" method="POST" class="space-y-5" id="ticketForm">
                        @csrf

                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-xs font-semibold text-slate-700 dark:text-slate-300">
                                Judul Masalah <span class="text-rose-500">*</span>
                            </label>
                            <p class="text-[11px] text-slate-400 mb-1">Tuliskan kendala secara ringkas dan jelas.</p>
                            <input type="text" name="title" id="title" required value="{{ old('title') }}"
                                placeholder="Contoh: Laptop tidak bisa connect ke Wi-Fi SmartDesk-Corp"
                                class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-900 placeholder:text-slate-400 focus:bg-white focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                        </div>

                        <!-- Category & Priority Row -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="category_id" class="block text-xs font-semibold text-slate-700 dark:text-slate-300">
                                    Kategori Perkiraan
                                </label>
                                <p class="text-[11px] text-slate-400 mb-1">Opsional, AI dapat menyarankan ulang.</p>
                                <select name="category_id" id="category_id" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2 text-xs text-slate-900 focus:bg-white focus:border-indigo-500 focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                    <option value="">-- Pilih jika Anda tahu --</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="priority" class="block text-xs font-semibold text-slate-700 dark:text-slate-300">
                                    Dampak / Prioritas <span class="text-rose-500">*</span>
                                </label>
                                <p class="text-[11px] text-slate-400 mb-1">Dampak terhadap pekerjaan Anda.</p>
                                <select name="priority" id="priority" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2 text-xs text-slate-900 focus:bg-white focus:border-indigo-500 focus:outline-none dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                                    @foreach(App\Enums\TicketPriority::cases() as $priority)
                                        <option value="{{ $priority->value }}" {{ old('priority', 'medium') === $priority->value ? 'selected' : '' }}>
                                            {{ $priority->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label for="description" class="block text-xs font-semibold text-slate-700 dark:text-slate-300">
                                    Deskripsi Detail Gangguan <span class="text-rose-500">*</span>
                                </label>
                                <span class="text-[11px] text-indigo-600 font-medium">Bahan analisis SmartDesk AI</span>
                            </div>
                            <p class="text-[11px] text-slate-400 mb-1">
                                Sebutkan waktu kejadian, pesan error yang tampil, dan langkah yang sudah dicoba. (Jangan sertakan password/PIN).
                            </p>
                            <textarea name="description" id="description" rows="5" required
                                placeholder="Contoh: Sejak pagi pukul 09:00 WIB, muncul error 'No Internet, Secured' saat memilih Wi-Fi SmartDesk-Corp. Laptop Lenovo ThinkPad T14. Sudah dicoba airplane mode tetap tidak mau terhubung..."
                                class="w-full rounded-xl border border-slate-300 bg-slate-50 p-3.5 text-xs leading-relaxed text-slate-900 placeholder:text-slate-400 focus:bg-white focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white">{{ old('description') }}</textarea>
                        </div>

                        <!-- Submit Button & Live Test -->
                        <div class="pt-2 flex flex-col sm:flex-row items-center gap-3">
                            <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-6 py-2.5 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 transition">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                                <span>Kirim Laporan Tiket</span>
                            </button>
                            <button type="button" id="previewAiBtn" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl border border-indigo-200 bg-indigo-50/70 px-4 py-2.5 text-xs font-semibold text-indigo-700 hover:bg-indigo-100 transition dark:border-indigo-900 dark:bg-indigo-950/40 dark:text-indigo-300">
                                <svg class="h-4 w-4 text-indigo-600 animate-spin hidden" id="spinnerAi" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                </svg>
                                <svg class="h-4 w-4" id="sparkleAi" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                <span>Cek Saran AI Sekarang</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column: AI Assistant Preview Simulation -->
            <div class="space-y-4">
                <div class="rounded-2xl border border-indigo-100 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-center gap-2 mb-3">
                        <div class="flex h-7 w-7 items-center justify-center rounded-lg bg-indigo-600 text-white">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xs font-bold text-slate-900 dark:text-white uppercase tracking-wider">
                            Live AI Assistant
                        </h3>
                    </div>

                    <div id="aiPreviewBox" class="rounded-xl border border-dashed border-slate-200 bg-slate-50/50 p-4 text-xs text-slate-500 text-center dark:border-slate-800 dark:bg-slate-800/40 dark:text-slate-400">
                        Isi judul dan deskripsi masalah, lalu klik tombol <strong>"Cek Saran AI Sekarang"</strong> untuk melihat preview analisis Ollama / Engine SmartDesk.
                    </div>

                    <div id="aiResultBox" class="hidden space-y-3">
                        <div class="rounded-xl border border-purple-200 bg-purple-50/60 p-3.5 dark:border-purple-900/50 dark:bg-purple-950/30">
                            <span class="block text-[10px] font-bold uppercase text-purple-700 dark:text-purple-300">Ringkasan AI</span>
                            <p class="mt-1 text-xs text-slate-700 dark:text-slate-200 font-medium" id="resSummary">-</p>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div class="rounded-lg border border-slate-200 bg-white p-2.5 dark:border-slate-700 dark:bg-slate-800">
                                <span class="text-[10px] text-slate-400 block">Saran Kategori</span>
                                <span class="font-semibold text-slate-800 dark:text-white" id="resCat">-</span>
                            </div>
                            <div class="rounded-lg border border-slate-200 bg-white p-2.5 dark:border-slate-700 dark:bg-slate-800">
                                <span class="text-[10px] text-slate-400 block">Saran Prioritas</span>
                                <span class="font-semibold uppercase text-indigo-600 dark:text-indigo-400" id="resPriority">-</span>
                            </div>
                        </div>
                        <div class="rounded-xl border border-slate-200 bg-white p-3.5 dark:border-slate-700 dark:bg-slate-800">
                            <span class="block text-[10px] font-bold uppercase text-slate-500 mb-1">Langkah Troubleshooting</span>
                            <pre class="text-xs text-slate-600 dark:text-slate-300 font-sans whitespace-pre-wrap leading-relaxed" id="resSteps">-</pre>
                        </div>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-[11px] text-slate-500 dark:border-slate-800 dark:bg-slate-900/60 dark:text-slate-400">
                    <strong class="text-slate-700 dark:text-slate-300 block mb-1">💡 Catatan Alur Kerja:</strong>
                    Saran AI ini akan otomatis tersimpan bersama tiket saat Anda mengklik "Kirim Laporan Tiket". Teknisi dapat meninjau rekomendasi tersebut sebelum mulai mengambil tindakan.
                </div>
            </div>
        </div>

    </div>

    <script>
        document.getElementById('previewAiBtn').addEventListener('click', async function() {
            const title = document.getElementById('title').value;
            const description = document.getElementById('description').value;

            if (!title || !description) {
                alert('Silakan isi judul dan deskripsi tiket terlebih dahulu.');
                return;
            }

            const spinner = document.getElementById('spinnerAi');
            const sparkle = document.getElementById('sparkleAi');
            spinner.classList.remove('hidden');
            sparkle.classList.add('hidden');

            try {
                const response = await fetch("{{ route('tickets.preview-ai') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ title, description })
                });

                if (response.ok) {
                    const data = await response.json();
                    document.getElementById('aiPreviewBox').classList.add('hidden');
                    const resBox = document.getElementById('aiResultBox');
                    resBox.classList.remove('hidden');

                    document.getElementById('resSummary').innerText = data.summary || '-';
                    document.getElementById('resCat').innerText = data.suggested_category || '-';
                    document.getElementById('resPriority').innerText = data.suggested_priority || '-';
                    document.getElementById('resSteps').innerText = data.suggestion || '-';
                } else {
                    alert('Gagal mengambil analisis AI. Periksa kembali isian form.');
                }
            } catch (err) {
                alert('Koneksi terputus ke endpoint AI.');
            } finally {
                spinner.classList.add('hidden');
                sparkle.classList.remove('hidden');
            }
        });
    </script>
</x-layouts.app>
