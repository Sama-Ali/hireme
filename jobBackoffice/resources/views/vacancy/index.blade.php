<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ ($showArchived ?? false) ? __('Archived vacancies') : __('Vacancies') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto space-y-4 sm:px-6 lg:px-8">
            <x-auth-session-status
                class="rounded-lg text-center border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800"
                :status="session('status')"
            />

            <div class="overflow-hidden rounded-xl border border-teal-300 bg-white shadow-sm ring-1 ring-teal-200/40 sm:rounded-xl">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col gap-1">
                        @forelse ($vacancies as $vacancy)
                            <div class="flex items-start justify-between gap-4 py-2.5 first:pt-0 last:pb-0">
                                <div class="min-w-0 flex-1 flex flex-col gap-1.5">
                                    @if ($showArchived ?? false)
                                        <span class="text-sm font-semibold text-black">{{ $vacancy->title }}</span>
                                    @else
                                        <a
                                            href="{{ route('vacancies.show', $vacancy) }}"
                                            class="text-sm font-semibold text-black hover:text-teal-800 hover:underline"
                                        >
                                            {{ $vacancy->title }}
                                        </a>
                                    @endif
                                    <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
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
                                            <span class="inline-flex items-center rounded-full bg-teal-50 px-2 py-0.5 text-xs font-medium text-teal-700 ring-1 ring-teal-600/20">
                                                {{ $vacancy->type }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                @if ($showArchived ?? false)
                                    <form
                                        method="POST"
                                        action="{{ route('vacancies.restore', $vacancy->getKey()) }}"
                                        class="flex shrink-0 items-center"
                                    >
                                        @csrf
                                        <button
                                            type="submit"
                                            class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-xl border-2 border-teal-300 bg-white px-4 py-2.5 text-sm font-semibold text-teal-900 shadow-sm transition hover:border-teal-400 hover:bg-teal-50 hover:text-teal-950 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500/60 focus-visible:ring-offset-2"
                                        >
                                            <svg class="size-4 shrink-0 text-teal-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 4.5-4.5M3 9h12a6 6 0 0 1 0 12h-3" />
                                            </svg>
                                            <span>{{ __('Restore') }}</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @empty
                            <div class="flex items-center justify-center py-6">
                                <span class="text-sm text-gray-500">
                                    {{ ($showArchived ?? false) ? __('No archived vacancies') : __('No vacancies found') }}
                                </span>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="mt-6 flex flex-wrap items-center justify-end gap-3">
                @if ($showArchived ?? false)
                    <a
                        href="{{ route('vacancies.index') }}"
                        class="inline-flex items-center gap-2 rounded-xl border-2 border-teal-300 bg-white px-5 py-2.5 text-sm font-semibold text-black shadow-sm transition hover:border-teal-400 hover:bg-teal-50 focus:outline-none focus-visible:border-teal-600 focus-visible:bg-teal-50 focus-visible:shadow-md focus-visible:shadow-teal-500/25 focus-visible:ring-2 focus-visible:ring-teal-500/70 focus-visible:ring-offset-2"
                    >
                        {{ __('Active vacancies') }}
                    </a>
                @else
                    <a
                        href="{{ route('vacancies.index', ['archived' => true]) }}"
                        aria-label="{{ __('Archived vacancies') }}"
                        class="inline-flex items-center gap-2 rounded-xl border-2 border-teal-300 bg-white px-5 py-2.5 text-sm font-semibold text-black shadow-sm transition hover:border-teal-400 hover:bg-teal-50 focus:outline-none focus-visible:border-teal-600 focus-visible:bg-teal-50 focus-visible:shadow-md focus-visible:shadow-teal-500/25 focus-visible:ring-2 focus-visible:ring-teal-500/70 focus-visible:ring-offset-2"
                    >
                        <svg class="size-4 shrink-0 text-teal-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                        </svg>
                        {{ __('Archived') }}
                    </a>
                @endif
                @unless ($showArchived ?? false)
                    <a
                        href="{{ route('vacancies.create') }}"
                        aria-label="{{ __('Add vacancy') }}"
                        class="group inline-flex items-center gap-2 rounded-xl bg-gradient-to-br from-teal-500 to-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-teal-500/25 ring-1 ring-teal-600/10 transition hover:from-teal-600 hover:to-emerald-700 hover:shadow-lg hover:shadow-teal-500/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500/50 focus-visible:ring-offset-2"
                    >
                        <svg class="size-4 transition-transform duration-200 group-hover:rotate-90" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        {{ __('Add vacancy') }}
                    </a>
                @endunless
            </div>
        </div>
    </div>
</x-app-layout>
