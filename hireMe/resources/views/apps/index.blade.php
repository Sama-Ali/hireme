<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
        <p class=" text-sm text-slate-600">{{ __('Track the jobs you have applied to and review your AI match scores.') }}</p>

        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-xl border border-teal-300 bg-white p-5 shadow-sm ring-1 ring-teal-200/40">
                <p class="text-sm font-medium text-slate-500">{{ __('Total applications') }}</p>
                <p class="mt-1 text-2xl font-semibold text-slate-900">{{ $stats['total'] }}</p>
            </div>
            <div class="rounded-xl border border-teal-300 bg-white p-5 shadow-sm ring-1 ring-teal-200/40">
                <p class="text-sm font-medium text-slate-500">{{ __('Pending') }}</p>
                <p class="mt-1 text-2xl font-semibold text-amber-600">{{ $stats['pending'] }}</p>
            </div>
            <div class="rounded-xl border border-teal-300 bg-white p-5 shadow-sm ring-1 ring-teal-200/40">
                <p class="text-sm font-medium text-slate-500">{{ __('Accepted') }}</p>
                <p class="mt-1 text-2xl font-semibold text-teal-600">{{ $stats['accepted'] }}</p>
            </div>
            <div class="rounded-xl border border-teal-300 bg-white p-5 shadow-sm ring-1 ring-teal-200/40">
                <p class="text-sm font-medium text-slate-500">{{ __('Rejected') }}</p>
                <p class="mt-1 text-2xl font-semibold text-rose-600">{{ $stats['rejected'] }}</p>
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-teal-300 bg-white shadow-sm ring-1 ring-teal-200/40">
            @forelse ($applications as $application)
                <div class="border-b border-teal-100/80 p-6 last:border-b-0">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div class="min-w-0 flex-1 space-y-3">
                            <div class="flex flex-wrap items-start justify-between gap-3">
                                <div class="min-w-0">
                                    @if ($application->vacancy)
                                        <a
                                            href="{{ route('vacancies.show', $application->vacancy) }}"
                                            class="text-lg font-semibold text-slate-900 transition hover:text-teal-800"
                                        >
                                            {{ $application->vacancy->title }}
                                        </a>
                                    @else
                                        <h3 class="text-lg font-semibold text-slate-900">{{ __('Unknown role') }}</h3>
                                    @endif

                                    <div class="mt-2 flex flex-wrap items-center gap-3 text-sm text-slate-500">
                                        @if ($application->vacancy?->company)
                                            <span class="flex items-center gap-1.5">
                                                <svg class="size-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                                </svg>
                                                {{ $application->vacancy->company->name }}
                                            </span>
                                        @endif
                                        @if ($application->vacancy?->location)
                                            <span class="flex items-center gap-1.5">
                                                <svg class="size-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                                </svg>
                                                {{ $application->vacancy->location }}
                                            </span>
                                        @endif
                                        @if ($application->vacancy?->type)
                                            <span class="inline-flex items-center rounded-full bg-teal-50 px-2.5 py-0.5 text-xs font-medium text-teal-700 ring-1 ring-teal-600/20">
                                                {{ $application->vacancy->type }}
                                            </span>
                                        @endif
                                        <span class="flex items-center gap-1.5">
                                            <svg class="size-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                            </svg>
                                            {{ $application->created_at?->timezone(config('app.timezone'))->format('M j, Y') ?? '—' }}
                                        </span>
                                    </div>
                                </div>

                                <span @class([
                                    'inline-flex shrink-0 rounded-full px-3 py-1 text-xs font-semibold capitalize',
                                    'bg-amber-50 text-amber-700 ring-1 ring-amber-200/80' => $application->status === 'pending',
                                    'bg-teal-50 text-teal-700 ring-1 ring-teal-200/80' => $application->status === 'accepted',
                                    'bg-rose-50 text-rose-700 ring-1 ring-rose-200/80' => $application->status === 'rejected',
                                    'bg-slate-50 text-slate-700 ring-1 ring-slate-200/80' => ! in_array($application->status, ['pending', 'accepted', 'rejected']),
                                ])>
                                    {{ $application->status }}
                                </span>
                            </div>

                            @if ($application->ai_feedback)
                                <div class="rounded-xl border border-slate-200 bg-slate-50/80 p-4">
                                    <div class="flex flex-wrap items-center justify-between gap-2">
                                        <p class="text-sm font-semibold text-slate-900">{{ __('Match feedback') }}</p>
                                        @if (! is_null($application->ai_score))
                                            <span @class([
                                                'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold ring-1',
                                                'bg-emerald-50 text-emerald-700 ring-emerald-200/80' => $application->ai_score >= 70,
                                                'bg-amber-50 text-amber-700 ring-amber-200/80' => $application->ai_score >= 40 && $application->ai_score < 70,
                                                'bg-rose-50 text-rose-700 ring-rose-200/80' => $application->ai_score < 40,
                                            ])>
                                                {{ __('Score: :score', ['score' => $application->ai_score]) }}
                                            </span>
                                        @endif
                                    </div>
                                    <p class="mt-2 text-sm leading-relaxed text-slate-600">{{ $application->ai_feedback }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center">
                    <p class="text-sm text-slate-600">{{ __('You have not applied to any jobs yet.') }}</p>
                    <a
                        href="{{ route('dashboard') }}"
                        class="mt-4 inline-flex items-center justify-center rounded-xl bg-gradient-to-br from-teal-500 to-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-teal-500/25 ring-1 ring-teal-600/10 transition hover:from-teal-600 hover:to-emerald-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500/60 focus-visible:ring-offset-2"
                    >
                        {{ __('Find jobs to apply') }}
                    </a>
                </div>
            @endforelse

            @if ($applications->hasPages())
                <div class="border-t border-teal-100/80 px-6 py-4">
                    {{ $applications->links('vendor.pagination.teal') }}
                </div>
            @endif
        </div>
        </div>
    </div>
</x-app-layout>
