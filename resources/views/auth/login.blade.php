<x-layouts.app title="Masuk ke Sistem - SmartDesk AI">
    <div class="flex min-h-[calc(100vh-4rem)] flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center">
            <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-tr from-indigo-600 to-sky-400 text-white shadow-lg shadow-indigo-500/30">
                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <h2 class="mt-4 text-2xl font-bold tracking-tight text-slate-900 dark:text-white">
                SmartDesk AI
            </h2>
            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                Intelligent IT Service Management System
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-lg">
            <div class="rounded-2xl border border-slate-200 bg-white p-8 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                
                <!-- Quick Demo Login Switcher -->
                <div class="mb-6 rounded-xl border border-indigo-100 bg-indigo-50/70 p-4 dark:border-indigo-950 dark:bg-indigo-950/40">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="inline-flex h-2 w-2 rounded-full bg-indigo-600 animate-pulse"></span>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-indigo-900 dark:text-indigo-300">
                            Masuk Cepat Demo (Sesuai Hak Akses Aktor MVP)
                        </h3>
                    </div>
                    <p class="text-xs text-indigo-700/90 dark:text-indigo-400 mb-3">
                        Pilih peran yang ingin Anda uji coba untuk langsung merasakan antarmuka & alur kerja:
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                        @foreach($demoUsers as $demo)
                            <form method="POST" action="{{ route('quick-login') }}">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ $demo->id }}">
                                <button type="submit" class="w-full text-left p-2.5 rounded-lg border border-white bg-white hover:border-indigo-300 hover:shadow-sm transition dark:border-slate-800 dark:bg-slate-800 dark:hover:border-indigo-600">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $demo->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($demo->name) }}" class="h-7 w-7 rounded-full object-cover">
                                        <div class="min-w-0">
                                            <div class="text-xs font-semibold text-slate-900 dark:text-white truncate">{{ Str::before($demo->name, ' ') }}</div>
                                            <span class="inline-block text-[10px] font-medium px-1.5 py-0.2 rounded 
                                                {{ $demo->role->value === 'admin' ? 'bg-rose-100 text-rose-700 dark:bg-rose-950 dark:text-rose-300' : '' }}
                                                {{ $demo->role->value === 'technician' ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300' : '' }}
                                                {{ $demo->role->value === 'employee' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300' : '' }}
                                            ">
                                                {{ $demo->role->label() }}
                                            </span>
                                        </div>
                                    </div>
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>

                <div class="relative my-6 text-center text-xs text-slate-400">
                    <span class="bg-white px-2 dark:bg-slate-900">Atau login dengan kredensial</span>
                    <hr class="absolute inset-0 my-auto -z-10 border-slate-200 dark:border-slate-800" />
                </div>

                <!-- Standard Login Form -->
                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="email" class="block text-xs font-semibold text-slate-700 dark:text-slate-300">
                            Email Kantor
                        </label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" required
                                value="{{ old('email', 'admin@smartdesk.local') }}"
                                class="block w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white"
                                placeholder="nama@smartdesk.local">
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-xs font-semibold text-slate-700 dark:text-slate-300">
                                Kata Sandi
                            </label>
                            <span class="text-xs text-slate-400">Default: password</span>
                        </div>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" required value="password"
                                class="block w-full rounded-lg border border-slate-300 bg-white px-3.5 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-800">
                            <span class="text-xs text-slate-600 dark:text-slate-400">Ingat perangkat ini</span>
                        </label>
                    </div>

                    <div>
                        <button type="submit" class="flex w-full justify-center rounded-lg bg-indigo-600 px-3 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition">
                            Masuk ke Dashboard
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-layouts.app>
