<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ ($showArchived ?? false) ? __('Archived applications') : __('Applications') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto space-y-4 sm:px-6 lg:px-8">
            <x-auth-session-status
                class="rounded-lg text-center border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800"
                :status="session('status')"
            />

            <div class="overflow-hidden rounded-xl border border-teal-300 bg-white shadow-sm ring-1 ring-teal-200/40 divide-y divide-gray-100 sm:rounded-xl">
                @forelse ($apps as $app)
                    @php
                        $statusStyles = [
                            'pending'  => 'bg-yellow-50 text-yellow-700 ring-yellow-500/30',
                            'accepted' => 'bg-emerald-50 text-emerald-700 ring-emerald-500/30',
                            'rejected' => 'bg-red-50 text-red-600 ring-red-500/30',
                        ];
                        $style = $statusStyles[$app->status] ?? 'bg-gray-50 text-gray-600 ring-gray-400/30';
                    @endphp

                    <div class="flex items-start justify-between gap-6 px-6 py-5">
                        {{-- Left: applicant + vacancy --}}
                        <div class="flex min-w-0 flex-1 flex-col gap-2">
                            <div class="flex flex-wrap items-center gap-2">
                                @if ($showArchived ?? false)
                                    <span class="text-sm font-semibold text-black">
                                        {{ $app->user?->name ?? __('Unknown Applicant') }}
                                    </span>
                                @else
                                    <a href="{{ route('apps.show', $app) }}" class="text-sm font-semibold text-black hover:text-teal-800 hover:underline">
                                        {{ $app->user?->name ?? __('Unknown Applicant') }}
                                    </a>
                                @endif
                                <span class="text-xs text-gray-300">→</span>
                                <span class="text-sm text-gray-500">
                                    {{ $app->vacancy?->title ?? __('Unknown Vacancy') }}
                                </span>
                            </div>

                            @if ($app->ai_feedback)
                                <p class="line-clamp-2 max-w-xl text-xs leading-relaxed text-gray-400">
                                    {{ $app->ai_feedback }}
                                </p>
                            @endif
                        </div>

                        {{-- Right: status + score + date [+ restore] --}}
                        <div class="flex shrink-0 flex-col items-end gap-2">
                            <span class="inline-flex items-center justify-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 {{ $style }}">
                                {{ ucfirst($app->status) }}
                            </span>

                            <div class="flex items-center gap-3 text-xs text-gray-400">
                                @if ($app->ai_score > 0)
                                    <span class="flex items-center gap-1 font-medium text-teal-600">
                                        <svg class="size-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z" />
                                        </svg>
                                        {{ __('Score:') }} {{ $app->ai_score }}
                                    </span>
                                    <span class="text-gray-200">|</span>
                                @endif
                                <span>{{ $app->created_at?->diffForHumans() ?? '—' }}</span>
                            </div>

                            @if ($showArchived ?? false)
                                <form
                                    method="POST"
                                    action="{{ route('apps.restore', $app->getKey()) }}"
                                    class="mt-1 flex shrink-0 items-center"
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
                    </div>
                @empty
                    <div class="flex items-center justify-center py-12 text-sm text-gray-400">
                        {{ ($showArchived ?? false) ? __('No archived applications') : __('No applications found') }}
                    </div>
                @endforelse
            </div>

            <div class="mt-6 flex flex-wrap items-center justify-end gap-3">
                @if ($showArchived ?? false)
                    <a
                        href="{{ route('apps.index') }}"
                        class="inline-flex items-center gap-2 rounded-xl border-2 border-teal-300 bg-white px-5 py-2.5 text-sm font-semibold text-black shadow-sm transition hover:border-teal-400 hover:bg-teal-50 focus:outline-none focus-visible:border-teal-600 focus-visible:bg-teal-50 focus-visible:shadow-md focus-visible:shadow-teal-500/25 focus-visible:ring-2 focus-visible:ring-teal-500/70 focus-visible:ring-offset-2"
                    >
                        {{ __('Active applications') }}
                    </a>
                @else
                    <a
                        href="{{ route('apps.index', ['archived' => true]) }}"
                        aria-label="{{ __('Archived applications') }}"
                        class="inline-flex items-center gap-2 rounded-xl border-2 border-teal-300 bg-white px-5 py-2.5 text-sm font-semibold text-black shadow-sm transition hover:border-teal-400 hover:bg-teal-50 focus:outline-none focus-visible:border-teal-600 focus-visible:bg-teal-50 focus-visible:shadow-md focus-visible:shadow-teal-500/25 focus-visible:ring-2 focus-visible:ring-teal-500/70 focus-visible:ring-offset-2"
                    >
                        <svg class="size-4 shrink-0 text-teal-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                        </svg>
                        {{ __('Archived') }}
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
