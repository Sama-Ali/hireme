<nav x-data="{ open: false }" class="fixed inset-x-0 top-0 z-50 border-b border-slate-200/80 bg-white/95 backdrop-blur-md lg:relative lg:z-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-14 justify-between lg:h-16">
            <div class="flex min-w-0 flex-1 items-center gap-6">
                {{-- Brand --}}
                <a href="{{ route('dashboard') }}" class="group flex shrink-0 items-center gap-2.5 rounded-2xl outline-none ring-teal-500/0 transition focus-visible:ring-2 focus-visible:ring-teal-500/50">
                    <span class="flex size-9 items-center justify-center rounded-xl bg-gradient-to-br from-teal-500 to-emerald-600 shadow-md shadow-teal-500/25 ring-1 ring-teal-600/10">
                        <svg class="size-5 text-white" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2m-9 4h10l1 10H7L8 11z" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span class="hidden truncate text-lg font-bold tracking-tight text-slate-900 group-hover:text-teal-800 transition-colors sm:block">{{ __('Hire Me') }}</span>
                </a>

                {{-- Desktop nav --}}
                <div class="hidden space-x-1 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="!border-0 !px-3 !py-2 rounded-xl {{ request()->routeIs('dashboard') ? '!text-teal-900 !bg-teal-50 ring-1 ring-teal-200/70' : '!text-slate-600 hover:!bg-slate-50 hover:!text-slate-900' }}">
                        {{ __('Vacancies') }}
                    </x-nav-link>
                    <x-nav-link :href="route('apps.index')" :active="request()->routeIs('apps.*')"
                        class="!border-0 !px-3 !py-2 rounded-xl {{ request()->routeIs('apps.*') ? '!text-teal-900 !bg-teal-50 ring-1 ring-teal-200/70' : '!text-slate-600 hover:!bg-slate-50 hover:!text-slate-900' }}">
                        {{ __('My Applications') }}
                    </x-nav-link>
                </div>
            </div>

            {{-- User dropdown --}}
            <div class="relative z-50 hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:border-teal-300 hover:bg-teal-50 hover:text-teal-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500/60">
                            <span class="flex size-7 items-center justify-center rounded-lg bg-teal-100 text-xs font-semibold text-teal-800">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                            <span class="max-w-[8rem] truncate">{{ Auth::user()->name }}</span>
                            <svg class="size-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Mobile menu button --}}
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex size-10 items-center justify-center rounded-xl border border-slate-200 text-slate-600 transition hover:border-teal-300 hover:text-teal-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500/60"
                    aria-label="{{ __('Toggle navigation menu') }}">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <path :class="{ 'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div :class="{ 'block': open, 'hidden': ! open }" class="hidden border-t border-slate-200 bg-white sm:hidden" x-cloak>
        <div class="space-y-1 px-4 py-3">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('apps.index')" :active="request()->routeIs('apps.*')">
                {{ __('My Applications') }}
            </x-responsive-nav-link>
        </div>

        <div class="border-t border-slate-200 px-4 py-4">
            <div class="text-base font-medium text-slate-900">{{ Auth::user()->name }}</div>
            <div class="text-sm text-slate-500">{{ Auth::user()->email }}</div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
