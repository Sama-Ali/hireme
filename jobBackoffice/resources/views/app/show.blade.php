<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $app->user?->name ?? __('Unknown Applicant') }}
            </h2>
            <a href="{{ route('apps.index') }}" class="text-sm font-medium text-teal-700 hover:text-teal-800">
                {{ __('← Back to applications') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-auth-session-status class="mb-4" :status="session('status')" />

            {{-- Application Details --}}
            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-teal-200/70">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-base font-semibold text-gray-900">{{ __('Application Details') }}</h3>
                </div>

                <div class="px-6 py-6">

                    {{-- Applicant --}}
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Applicant') }}</p>
                    <p class="mt-1 text-sm font-semibold text-gray-900">{{ $app->user?->name ?? '—' }}</p>
                    @if ($app->user?->email)
                        <p class="text-xs text-gray-500">{{ $app->user->email }}</p>
                    @endif

                    <div class="mt-6"></div>

                    {{-- Applied for --}}
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Applied for') }}</p>
                    @if ($app->vacancy)
                        <a href="{{ route('vacancies.show', $app->vacancy) }}" class="mt-1 block text-sm font-semibold text-teal-700 hover:text-teal-800">
                            {{ $app->vacancy->title }}
                        </a>
                        <div class="mt-1 flex flex-wrap items-center gap-2 text-xs text-gray-500 mb-4">
                            @if ($app->vacancy->company)
                                <span>{{ $app->vacancy->company->name }}</span>
                            @endif
                            @if ($app->vacancy->location)
                                <span class="text-gray-300">·</span>
                                <span>{{ $app->vacancy->location }}</span>
                            @endif
                            @if ($app->vacancy->type)
                                <span class="inline-flex items-center rounded-full bg-teal-50 px-2 py-0.5 font-medium text-teal-700 ring-1 ring-teal-600/20">
                                    {{ $app->vacancy->type }}
                                </span>
                            @endif
                        </div>
                    @else
                        <p class="mt-1 text-sm text-gray-400">—</p>
                    @endif

                    <hr class="border-gray-100 my-8">

                    {{-- Status --}}
                    @php
                        $statusStyles = [
                            'pending'  => 'rounded-lg text-center border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800',
                            'accepted' => 'rounded-lg text-center border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800',
                            'rejected' => 'rounded-lg text-center border-red-200 bg-red-50 px-4 py-3 text-red-800',
                        ];
                        $style = $statusStyles[$app->status] ?? 'bg-gray-50 text-gray-600 ring-gray-400/30';
                    @endphp
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mt-4">{{ __('Status') }}</p>
                    <p class="mt-1">
                        <span class="inline-flex items-center justify-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 {{ $style }}">
                            {{ ucfirst($app->status) }}
                        </span>
                    </p>

                    <div class="mt-6"></div>

                    {{-- AI Score --}}
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Score') }}</p>
                    @if ($app->ai_score > 0)
                        <p class="mt-1 flex items-center gap-1.5 text-sm font-bold text-teal-700">
                            <svg class="size-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z" />
                            </svg>
                            {{ $app->ai_score }}
                        </p>
                    @else
                        <p class="mt-1 text-sm text-gray-400">—</p>
                    @endif

                    <div class="mt-6"></div>

                    {{-- Submitted --}}
                    <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Submitted') }}</p>
                    <p class="mt-1 flex items-center gap-3 text-sm text-gray-700 mb-4">
                        <span>{{ $app->created_at->format('M j, Y') }}</span>
                        <span class="text-gray-300">·</span>
                        <span class="text-xs text-gray-400">{{ $app->created_at->diffForHumans() }}</span>
                    </p>

                    {{-- AI Feedback --}}
                    @if ($app->ai_feedback)
                        <hr class="border-gray-100 my-8">
                        <p class="text-xs font-semibold uppercase tracking-widest text-gray-400 mt-4">{{ __('AI Feedback') }}</p>
                        <p class="mt-1 text-sm text-gray-600 leading-relaxed">{{ $app->ai_feedback }}</p>
                    @endif

                    <div class="mt-2"></div>

                </div>
            </div>

            <div class="flex flex-wrap items-center justify-end gap-3">
                <a
                    href="{{ route('apps.edit', $app) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-teal-200 bg-white px-5 py-2.5 text-sm font-semibold text-teal-800 shadow-sm ring-1 ring-teal-600/10 transition hover:border-teal-300 hover:bg-teal-50 hover:text-teal-900 focus:outline-none focus-visible:ring-4 focus-visible:ring-teal-400/70 focus-visible:ring-offset-2"
                >
                    <svg class="size-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                    {{ __('Edit') }}
                </a>
                <form method="POST" action="{{ route('apps.destroy', $app) }}" class="inline-flex">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        data-confirm="{{ __('Are you sure you want to archive') }} &quot;{{ $app->user?->name ?? __('this application') }}&quot;?"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-teal-200 bg-white px-5 py-2.5 text-sm font-semibold text-teal-800 shadow-sm ring-1 ring-teal-600/10 transition hover:border-teal-300 hover:bg-teal-50 hover:text-teal-900 focus:outline-none focus-visible:ring-4 focus-visible:ring-teal-400/70 focus-visible:ring-offset-2"
                    >
                        <svg class="size-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6m16 0v4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-4m16 0h-2.586a1 1 0 0 0-.707.293l-2.414 2.414a1 1 0 0 1-.707.293h-3.172a1 1 0 0 1-.707-.293l-2.414-2.414A1 1 0 0 0 6.586 13H4" />
                        </svg>
                        {{ __('Archive') }}
                    </button>
                </form>
            </div>

            {{-- Resume --}}
            @if ($app->resume)
                <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-teal-200/70">
                    <div class="border-b border-gray-100 px-6 py-4 flex items-center justify-between">
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">{{ __('Resume') }}</h3>
                            @if ($app->resume->name)
                                <p class="mt-0.5 text-sm text-gray-400">{{ $app->resume->name }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @if ($app->resume->summary)
                            <div class="px-6 py-5">
                                <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Summary') }}</p>
                                <p class="mt-1 text-sm text-gray-700 leading-relaxed">{{ $app->resume->summary }}</p>
                            </div>
                        @endif
                        @if ($app->resume->skills)
                            <div class="px-6 py-5">
                                <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Skills') }}</p>
                                <p class="mt-1 text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $app->resume->skills }}</p>
                            </div>
                        @endif
                        @if ($app->resume->experience)
                            <div class="px-6 py-5">
                                <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Experience') }}</p>
                                <p class="mt-1 text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $app->resume->experience }}</p>
                            </div>
                        @endif
                        @if ($app->resume->education)
                            <div class="px-6 py-5">
                                <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Education') }}</p>
                                <p class="mt-1 text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $app->resume->education }}</p>
                            </div>
                        @endif
                        @if ($app->resume->contact)
                            <div class="px-6 py-5">
                                <p class="text-xs font-semibold uppercase tracking-widest text-gray-400">{{ __('Contact') }}</p>
                                <p class="mt-1 text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $app->resume->contact }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

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
