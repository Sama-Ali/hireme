<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $company->name }}
            </h2>
            @if (request()->routeIs('my-company.*'))
                <a
                    href="{{ route('dashboard') }}"
                    class="text-sm font-medium text-teal-700 hover:text-teal-800"
                >
                    {{ __('← Back to dashboard') }}
                </a>
            @else
                <a
                    href="{{ route('companies.index') }}"
                    class="text-sm font-medium text-teal-700 hover:text-teal-800"
                >
                    {{ __('← Back to companies') }}
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Company details card -->
            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-teal-200/70">
                <div class="p-6">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex flex-col gap-2">
                            <p class="text-base font-bold text-gray-900">{{ $company->name }}</p>
                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                                @if ($company->location)
                                    <span class="flex items-center gap-1.5">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" style="flex-shrink:0">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                        </svg>
                                        {{ $company->location }}
                                    </span>
                                @endif
                                @if ($company->industry)
                                    <span class="flex items-center gap-1.5">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" style="flex-shrink:0">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                        </svg>
                                        {{ $company->industry }}
                                    </span>
                                @endif
                                @if ($company->owner)
                                    <span class="flex items-center gap-1.5">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" style="flex-shrink:0">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                        {{ $company->owner->name }}
                                    </span>
                                @endif
                                <span class="flex items-center gap-1.5">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" style="flex-shrink:0">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                    </svg>
                                    {{ $company->created_at?->format('M j, Y') ?? '—' }}
                                </span>
                            </div>
                        </div>
                        @if ($company->website)
                            <a
                                href="{{ $company->website }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="shrink-0 text-xs text-teal-600 hover:text-teal-700 hover:underline"
                            >
                                {{ __('Visit website') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Vacancies -->
            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-teal-200/70">
                <div class="border-b border-gray-200/80 bg-gradient-to-r from-slate-50 to-gray-50/80 px-6 py-4">
                    <h3 class="text-base font-semibold text-gray-900">{{ __('Vacancies') }}</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ $company->vacancies->count() }}
                        {{ $company->vacancies->count() === 1 ? __('vacancy') : __('vacancies') }}
                    </p>
                </div>
                <div class="p-6">
                    @forelse ($company->vacancies as $vacancy)
                        <div class="{{ !$loop->last ? 'border-b border-gray-100 pb-4 mb-4' : '' }}">
                            <p class="text-sm font-semibold text-gray-900">{{ $vacancy->title }}</p>
                            <div class="mt-1 flex flex-wrap gap-x-4 gap-y-1 text-xs text-gray-600">
                                @if ($vacancy->location)
                                    <span>{{ $vacancy->location }}</span>
                                @endif
                                @if ($vacancy->type)
                                    <span>{{ $vacancy->type }}</span>
                                @endif
                                @if ($vacancy->salary)
                                    <span>{{ $vacancy->salary }}</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">{{ __('No vacancies linked to this company yet.') }}</p>
                    @endforelse
                </div>
            </div>
            <div class="flex flex-wrap items-center justify-end gap-3">
                <a
                    href="{{ request()->routeIs('my-company.*') ? route('my-company.edit') : route('companies.edit', $company) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-teal-200 bg-white px-5 py-2.5 text-sm font-semibold text-teal-800 shadow-sm ring-1 ring-teal-600/10 transition hover:border-teal-300 hover:bg-teal-50 hover:text-teal-900 focus:outline-none focus-visible:ring-4 focus-visible:ring-teal-400/70 focus-visible:ring-offset-2"
                >
                    <svg class="size-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                    {{ __('Edit') }}
                </a>
                @unless (request()->routeIs('my-company.*'))
                <form method="POST" action="{{ route('companies.destroy', $company) }}" class="inline-flex">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        data-confirm="{{ __('Are you sure you want to archive') }} &quot;{{ $company->name }}&quot;?"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-teal-200 bg-white px-5 py-2.5 text-sm font-semibold text-teal-800 shadow-sm ring-1 ring-teal-600/10 transition hover:border-teal-300 hover:bg-teal-50 hover:text-teal-900 focus:outline-none focus-visible:ring-4 focus-visible:ring-teal-400/70 focus-visible:ring-offset-2"
                    >
                        <svg class="size-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6m16 0v4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-4m16 0h-2.586a1 1 0 0 0-.707.293l-2.414 2.414a1 1 0 0 1-.707.293h-3.172a1 1 0 0 1-.707-.293l-2.414-2.414A1 1 0 0 0 6.586 13H4" />
                        </svg>
                        {{ __('Archive') }}
                    </button>
                </form>
                @endunless
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('[data-confirm]').forEach(btn => {
            btn.addEventListener('click', e => {
                if (!confirm(btn.dataset.confirm)) {
                    e.preventDefault();
                }
            });
        });
    </script>
</x-app-layout>
