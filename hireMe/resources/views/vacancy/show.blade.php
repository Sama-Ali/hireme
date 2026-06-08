<x-app-layout>
  

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
            <x-auth-session-status class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-center text-sm text-emerald-800" :status="session('status')" />

            <div class="overflow-hidden rounded-xl border border-teal-300 bg-white shadow-sm ring-1 ring-teal-200/40">
                <div class="border-b border-teal-100/80 bg-gradient-to-r from-teal-50/50 to-white px-6 py-5">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">{{ $vacancy->title }}</h2>
                    <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500">
                        @if ($vacancy->company)
                            <span class="flex items-center gap-1.5">
                                <svg class="size-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                </svg>
                                {{ $vacancy->company->name }}
                            </span>
                        @endif
                        @if ($vacancy->category)
                            <span class="flex items-center gap-1.5">
                                <svg class="size-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                                </svg>
                                {{ $vacancy->category->name }}
                            </span>
                        @endif
                        @if ($vacancy->location)
                            <span class="flex items-center gap-1.5">
                                <svg class="size-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>
                                {{ $vacancy->location }}
                            </span>
                        @endif
                        @if ($vacancy->salary)
                            <span class="flex items-center gap-1.5">
                                <svg class="size-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33" />
                                </svg>
                                {{ $vacancy->salary }}
                            </span>
                        @endif                       
                        <span class="flex items-center gap-1.5">
                            <svg class="size-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                            {{ $vacancy->created_at?->timezone(config('app.timezone'))->format('M j, Y g:i A') ?? '—' }}
                        </span>
                        @if ($vacancy->type)
                            <span class="inline-flex items-center rounded-full bg-teal-50 px-2.5 py-0.5 text-xs font-medium text-teal-700 ring-1 ring-teal-600/20">
                                {{ $vacancy->type }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="p-6">
                    @if ($vacancy->description)
                        <div class="prose prose-sm max-w-none text-slate-700">
                            <h3 class="mb-3 text-base font-semibold text-slate-900">{{ __('Job description') }}</h3>
                            <p class="whitespace-pre-line leading-relaxed">{{ $vacancy->description }}</p>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">{{ __('No description provided.') }}</p>
                    @endif
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-end gap-3">
                <a
                    href="{{ route('dashboard') }}"
                    class="inline-flex items-center justify-center rounded-xl border-2 border-teal-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-teal-400 hover:bg-teal-50 hover:text-teal-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500/60 focus-visible:ring-offset-2"
                >
                    {{ __('Back to vacancies') }}
                </a>
                @if ($hasApplied ?? false)
                    <a
                        href="{{ route('apps.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border-2 border-teal-300 bg-white px-5 py-2.5 text-sm font-semibold text-teal-900 shadow-sm transition hover:border-teal-400 hover:bg-teal-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500/60 focus-visible:ring-offset-2"
                    >
                        {{ __('View application') }}
                    </a>
                @else
                    <a
                        href="{{ route('vacancies.apply', $vacancy) }}"
                        class="inline-flex items-center justify-center rounded-xl bg-gradient-to-br from-teal-500 to-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-teal-500/25 ring-1 ring-teal-600/10 transition hover:from-teal-600 hover:to-emerald-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500/60 focus-visible:ring-offset-2"
                    >
                        {{ __('Apply now') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
