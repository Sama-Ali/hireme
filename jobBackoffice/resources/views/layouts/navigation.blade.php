<div x-data="{ sidebarOpen: false }" @keydown.window.escape="sidebarOpen = false">
    {{-- Mobile top bar --}}
    <header
        class="fixed inset-x-0 top-0 z-30 flex h-14 items-center gap-3 border-b border-slate-200/80 bg-white/95 px-4 backdrop-blur-md lg:hidden"
    >
        <button
            type="button"
            class="inline-flex size-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:border-teal-300 hover:text-teal-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500/60"
            @click="sidebarOpen = true"
            aria-label="{{ __('Open navigation menu') }}"
        >
            <svg class="size-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
        <div class="flex min-w-0 flex-1 items-center gap-2">
            <span class="flex size-9 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-teal-500 to-emerald-600 shadow-md shadow-teal-500/25">
                <svg class="size-5 text-white" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2m-9 4h10l1 10H7L8 11z" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </span>
            <span class="truncate font-semibold tracking-tight text-slate-900">{{ __('Hire me') }}</span>
        </div>
    </header>

    {{-- Backdrop --}}
    <div
        x-show="sidebarOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-40 bg-slate-950/60 backdrop-blur-sm lg:hidden"
        x-cloak
        @click="sidebarOpen = false"
        aria-hidden="true"
    ></div>

    {{-- Sidebar --}}
    <aside
        class="fixed inset-y-0 left-0 z-50 flex w-[min(18rem,100vw)] flex-col border-r border-slate-200/90 bg-white shadow-2xl shadow-slate-300/40 transition-transform duration-300 ease-out lg:static lg:z-auto lg:h-screen lg:w-72 lg:shrink-0 lg:translate-x-0 lg:shadow-sm"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        aria-label="{{ __('Main navigation') }}"
    >
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_85%_55%_at_50%_-15%,rgba(45,212,191,0.09),transparent)]"></div>

        <div class="relative flex h-full flex-col">
            {{-- Brand --}}
            <div class="flex items-center justify-between gap-3 border-b border-slate-200 bg-white/80 px-5 py-6 backdrop-blur-sm">
                <a href="{{ route('dashboard') }}" class="group flex min-w-0 items-center gap-3 rounded-2xl outline-none ring-teal-500/0 transition focus-visible:ring-2 focus-visible:ring-teal-500/50" @click="sidebarOpen = false">
                    <span class="relative flex size-11 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-teal-500 via-teal-500 to-emerald-600 shadow-md shadow-teal-500/25 ring-1 ring-teal-600/10">
                        <svg class="relative size-6 text-white drop-shadow-sm" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2m-9 4h10l1 10H7L8 11z" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <div class="min-w-0">
                        <p class="truncate text-lg font-bold tracking-tight text-slate-900">{{ __('Hire me') }}</p>
                        <p class="truncate text-xs font-medium text-teal-700">{{ __('Dashboard') }}</p>
                    </div>
                </a>
                <button
                    type="button"
                    class="inline-flex size-9 items-center justify-center rounded-xl text-slate-500 transition hover:bg-slate-100 hover:text-slate-900 lg:hidden"
                    @click="sidebarOpen = false"
                    aria-label="{{ __('Close navigation menu') }}"
                >
                    <svg class="size-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Nav links --}}
            <nav class="relative flex-1 overflow-y-auto px-3 py-5">
                <p class="mb-3 px-3 text-[0.65rem] font-semibold uppercase tracking-wider text-slate-400">{{ __('Menu') }}</p>
                <ul class="flex flex-col gap-1">
                    <li>
                        <a
                            href="{{ route('dashboard') }}"
                            @click="sidebarOpen = false"
                            @class([
                                'group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition outline-none focus-visible:ring-2 focus-visible:ring-teal-500/40',
                                'bg-teal-50 text-teal-900 shadow-sm ring-1 ring-teal-200/70' => request()->routeIs('dashboard'),
                                'text-slate-600 hover:bg-slate-50 hover:text-slate-900' => ! request()->routeIs('dashboard'),
                            ])
                        >
                            <span @class([
                                'flex size-9 shrink-0 items-center justify-center rounded-lg transition',
                                'bg-teal-100 text-teal-700' => request()->routeIs('dashboard'),
                                'bg-slate-100 text-slate-500 group-hover:bg-slate-200 group-hover:text-slate-700' => ! request()->routeIs('dashboard'),
                            ])>
                                <svg class="size-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                            </span>
                            <span class="truncate">{{ __('Dashboard') }}</span>
                        </a>
                    </li>
                    @if (auth()->user()->role == 'admin') 
                    <li>
                        <a
                            href="{{ route('companies.index') }}"
                            @click="sidebarOpen = false"
                            @class([
                                'group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition outline-none focus-visible:ring-2 focus-visible:ring-teal-500/40',
                                'bg-teal-50 text-teal-900 shadow-sm ring-1 ring-teal-200/70' => request()->routeIs('companies.*'),
                                'text-slate-600 hover:bg-slate-50 hover:text-slate-900' => ! request()->routeIs('companies.*'),
                            ])
                        >
                            <span @class([
                                'flex size-9 shrink-0 items-center justify-center rounded-lg transition',
                                'bg-teal-100 text-teal-700' => request()->routeIs('companies.*'),
                                'bg-slate-100 text-slate-500 group-hover:bg-slate-200 group-hover:text-slate-700' => ! request()->routeIs('companies.*'),
                            ])>
                                <svg class="size-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                                </svg>
                            </span>
                            <span class="truncate">{{ __('Companies') }}</span>
                        </a>
                    </li>
                    @endif

                    @if (auth()->user()->role == 'company_owner') 
                    <li>
                        <a
                            href="{{ route('my-company.show') }}"
                            @click="sidebarOpen = false"
                            @class([
                                'group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition outline-none focus-visible:ring-2 focus-visible:ring-teal-500/40',
                                'bg-teal-50 text-teal-900 shadow-sm ring-1 ring-teal-200/70' => request()->routeIs('my-company.*'),
                                'text-slate-600 hover:bg-slate-50 hover:text-slate-900' => ! request()->routeIs('my-company.*'),
                            ])
                        >
                            <span @class([
                                'flex size-9 shrink-0 items-center justify-center rounded-lg transition',
                                'bg-teal-100 text-teal-700' => request()->routeIs('my-company.*'),
                                'bg-slate-100 text-slate-500 group-hover:bg-slate-200 group-hover:text-slate-700' => ! request()->routeIs('my-company.*'),
                            ])>
                                <svg class="size-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                                </svg>
                            </span>
                            <span class="truncate">{{ __('My company') }}</span>
                        </a>
                    </li>
                    @endif

                    <li>
                        <a
                            href="{{ route('apps.index') }}"
                            @click="sidebarOpen = false"
                            @class([
                                'group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition outline-none focus-visible:ring-2 focus-visible:ring-teal-500/40',
                                'bg-teal-50 text-teal-900 shadow-sm ring-1 ring-teal-200/70' => request()->routeIs('apps.*'),
                                'text-slate-600 hover:bg-slate-50 hover:text-slate-900' => ! request()->routeIs('apps.*'),
                            ])
                        >
                            <span @class([
                                'flex size-9 shrink-0 items-center justify-center rounded-lg transition',
                                'bg-teal-100 text-teal-700' => request()->routeIs('apps.*'),
                                'bg-slate-100 text-slate-500 group-hover:bg-slate-200 group-hover:text-slate-700' => ! request()->routeIs('apps.*'),
                            ])>
                                <svg class="size-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                </svg>
                            </span>
                            <span class="truncate">{{ __('Job applications') }}</span>
                        </a>
                    </li>

                    @if (auth()->user()->role == 'admin') 
                    <li>
                        <a
                            href="{{ route('categories.index') }}"
                            @click="sidebarOpen = false"
                            @class([
                                'group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition outline-none focus-visible:ring-2 focus-visible:ring-teal-500/40',
                                'bg-teal-50 text-teal-900 shadow-sm ring-1 ring-teal-200/70' => request()->routeIs('categories.*'),
                                'text-slate-600 hover:bg-slate-50 hover:text-slate-900' => ! request()->routeIs('categories.*'),
                            ])
                        >
                            <span @class([
                                'flex size-9 shrink-0 items-center justify-center rounded-lg transition',
                                'bg-teal-100 text-teal-700' => request()->routeIs('categories.*'),
                                'bg-slate-100 text-slate-500 group-hover:bg-slate-200 group-hover:text-slate-700' => ! request()->routeIs('categories.*'),
                            ])>
                                <svg class="size-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                </svg>
                            </span>
                            <span class="truncate">{{ __('Job categories') }}</span>
                        </a>
                    </li>
                    @endif
                    <li>
                        <a
                            href="{{ route('vacancies.index') }}"
                            @click="sidebarOpen = false"
                            @class([
                                'group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition outline-none focus-visible:ring-2 focus-visible:ring-teal-500/40',
                                'bg-teal-50 text-teal-900 shadow-sm ring-1 ring-teal-200/70' => request()->routeIs('vacancies.*'),
                                'text-slate-600 hover:bg-slate-50 hover:text-slate-900' => ! request()->routeIs('vacancies.*'),
                            ])
                        >
                            <span @class([
                                'flex size-9 shrink-0 items-center justify-center rounded-lg transition',
                                'bg-teal-100 text-teal-700' => request()->routeIs('vacancies.*'),
                                'bg-slate-100 text-slate-500 group-hover:bg-slate-200 group-hover:text-slate-700' => ! request()->routeIs('vacancies.*'),
                            ])>
                                <svg class="size-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.125c0 1.087-.985 1.964-2.204 1.964h-6.75v-6.75h6.75c1.219 0 2.204.877 2.204 1.964zM12 12.75v6.75H5.204c-1.219 0-2.204-.877-2.204-1.964v-4.125c0-1.087.985-1.964 2.204-1.964h6.75zm0 0V9.375c0-1.087-.985-1.964-2.204-1.964H5.204c-1.219 0-2.204.877-2.204 1.964v2.625m12 0V9.375c0-1.087-.985-1.964-2.204-1.964h-6.75c-1.219 0-2.204.877-2.204 1.964v3.375m12 0h.008v.008H24v-.008z" />
                                </svg>
                            </span>
                            <span class="truncate">{{ __('Job vacancies') }}</span>
                        </a>
                    </li>

                    @if (auth()->user()->role == 'admin') 
                    <li>
                        <a
                            href="{{ route('users.index') }}"
                            @click="sidebarOpen = false"
                            @class([
                                'group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition outline-none focus-visible:ring-2 focus-visible:ring-teal-500/40',
                                'bg-teal-50 text-teal-900 shadow-sm ring-1 ring-teal-200/70' => request()->routeIs('users.*'),
                                'text-slate-600 hover:bg-slate-50 hover:text-slate-900' => ! request()->routeIs('users.*'),
                            ])
                        >
                            <span @class([
                                'flex size-9 shrink-0 items-center justify-center rounded-lg transition',
                                'bg-teal-100 text-teal-700' => request()->routeIs('users.*'),
                                'bg-slate-100 text-slate-500 group-hover:bg-slate-200 group-hover:text-slate-700' => ! request()->routeIs('users.*'),
                            ])>
                                <svg class="size-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                            </span>
                            <span class="truncate">{{ __('Users') }}</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>

            {{-- Account --}}
            <div class="relative mt-auto border-t border-slate-200 bg-slate-50/80 p-4 backdrop-blur-sm">
                <x-dropdown align="right" width="56" direction="up" contentClasses="py-1 bg-white">
                    <x-slot name="trigger">
                        <button
                            type="button"
                            class="flex w-full items-center gap-3 rounded-xl px-2 py-2 text-left transition hover:bg-white focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500/40"
                        >
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-teal-500 to-emerald-600 text-sm font-semibold text-white shadow-sm shadow-teal-500/20">
                                {{ Str::upper(Str::substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <span class="min-w-0 flex-1">
                                <span class="block truncate text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</span>
                                <span class="block truncate text-xs text-slate-500">{{ Auth::user()->email }}</span>
                            </span>
                            <svg class="size-4 shrink-0 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if (Route::has('profile.edit'))
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
                        @endif

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </aside>
</div>
