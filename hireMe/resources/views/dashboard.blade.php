<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto space-y-4 sm:px-6 lg:px-8">
            {{-- Search & filters (UI only) --}}
            @php
                $filterActive = 'inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-teal-600 to-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-md shadow-teal-500/25 transition hover:from-teal-500 hover:to-emerald-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500/60 focus-visible:ring-offset-2';
                $filterInactive = 'inline-flex items-center justify-center rounded-xl border-2 border-teal-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-teal-400 hover:bg-teal-50 hover:text-teal-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500/60 focus-visible:ring-offset-2';
            @endphp
            <form
                action="{{ route('dashboard') }}"
                method="GET"
                class="flex flex-col gap-4 rounded-xl border border-teal-300 bg-white p-4 shadow-sm ring-1 ring-teal-200/40 sm:flex-row sm:items-center sm:justify-between sm:gap-6 sm:p-5"
            >
                @if (request('filter'))
                    <input type="hidden" name="filter" id="active-filter" value="{{ request('filter') }}">
                @endif
                <div class="flex min-w-0 flex-1 items-center gap-2 sm:max-w-lg">
                    <div class="relative min-w-0 flex-1">
                        <label for="job-search" class="sr-only">{{ __('Search jobs') }}</label>
                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-teal-600/70">
                            <svg class="size-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </span>
                        <input
                            id="job-search"
                            name="search"
                            value="{{ request('search') }}"
                            type="text"
                            autocomplete="off"
                            placeholder="{{ __('Search jobs...') }}"
                            class="block w-full rounded-xl border-2 border-teal-200 bg-slate-50/80 py-2.5 pl-11 pr-4 text-sm text-slate-900 placeholder:text-slate-400 transition focus:border-teal-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-teal-500/25"
                        />
                    </div>
                    <button
                        type="submit"
                        class="inline-flex shrink-0 items-center justify-center rounded-xl border-2 border-teal-300 bg-white px-4 py-2.5 text-sm font-semibold text-teal-900 shadow-sm transition hover:border-teal-400 hover:bg-teal-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500/60 focus-visible:ring-offset-2"
                    >
                        {{ __('Search') }}
                    </button>
                </div>

                <div class="flex flex-wrap items-center gap-2 sm:shrink-0">
                    <button type="submit" onclick="document.getElementById('active-filter')?.remove()" class="{{ request('filter') ? $filterInactive : $filterActive }}">
                        {{ __('All') }}
                    </button>
                    <button type="submit" name="filter" value="Full-Time" onclick="document.getElementById('active-filter')?.remove()" class="{{ request('filter') === 'Full-Time' ? $filterActive : $filterInactive }}">
                        {{ __('Full Time') }}
                    </button>
                    <button type="submit" name="filter" value="Hybrid" onclick="document.getElementById('active-filter')?.remove()" class="{{ request('filter') === 'Hybrid' ? $filterActive : $filterInactive }}">
                        {{ __('Hybrid') }}
                    </button>
                    <button type="submit" name="filter" value="Remote" onclick="document.getElementById('active-filter')?.remove()" class="{{ request('filter') === 'Remote' ? $filterActive : $filterInactive }}">
                        {{ __('Remote') }}
                    </button>
                    <button type="submit" name="filter" value="Contract" onclick="document.getElementById('active-filter')?.remove()" class="{{ request('filter') === 'Contract' ? $filterActive : $filterInactive }}">
                        {{ __('Contract') }}
                    </button>
                </div>
            </form>

            <div class="overflow-hidden rounded-xl border border-teal-300 bg-white shadow-sm ring-1 ring-teal-200/40 sm:rounded-xl">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col gap-1">
                        @forelse ($vacancies as $vacancy)
                            <a
                                href="{{ route('vacancies.show', $vacancy) }}"
                                class="group -mx-2 block rounded-xl border border-transparent px-3 py-2.5 transition hover:border-teal-200/80 hover:bg-teal-50/70 hover:shadow-sm focus:outline-none focus-visible:border-teal-300 focus-visible:bg-teal-50 focus-visible:ring-2 focus-visible:ring-teal-500/40"
                            >
                                <div class="min-w-0 flex-1 flex flex-col gap-1.5">
                                    <span class="text-sm font-semibold text-black transition group-hover:text-teal-900">{{ $vacancy->title }}</span>
                                    <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500 transition group-hover:text-slate-600">
                                        @if ($vacancy->company)
                                            <span class="flex items-center gap-1">
                                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" class="shrink-0">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                                </svg>
                                                {{ $vacancy->company->name }}
                                            </span>
                                        @endif
                                        @if ($vacancy->location)
                                            <span class="flex items-center gap-1">
                                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" class="shrink-0">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                                </svg>
                                                {{ $vacancy->location }}
                                            </span>
                                        @endif
                                        @if ($vacancy->type)
                                            <span class="inline-flex items-center rounded-full bg-teal-50 px-2 py-0.5 text-xs font-medium text-teal-700 ring-1 ring-teal-600/20 transition group-hover:bg-teal-100/80">
                                                {{ $vacancy->type }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="flex items-center justify-center py-6">
                                <span class="text-sm text-gray-500">{{ __('No vacancies found') }}</span>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            @if ($vacancies->hasPages())
                <div class="flex justify-center px-4 pb-6 pt-2">
                    {{ $vacancies->links('vendor.pagination.teal') }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
