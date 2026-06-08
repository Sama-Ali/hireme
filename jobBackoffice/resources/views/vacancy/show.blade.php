<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $vacancy->title }}
            </h2>
            <a
                href="{{ route('vacancies.index') }}"
                class="text-sm font-medium text-teal-700 hover:text-teal-800"
            >
                {{ __('← Back to vacancies') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Vacancy details card -->
            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-teal-200/70">
                <div class="p-6">
                    <div class="flex flex-col gap-4">
                        @if ($vacancy->description)
                            <p class="text-sm font-medium text-gray-900 leading-relaxed whitespace-pre-line">{{ $vacancy->description }}</p>
                        @endif
                        <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500">
                            @if ($vacancy->company)
                                <span class="flex items-center gap-1.5">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" style="flex-shrink:0">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                    </svg>
                                    {{ $vacancy->company->name }}
                                </span>
                            @endif
                            @if ($vacancy->category)
                                <span class="flex items-center gap-1.5">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" style="flex-shrink:0">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                                    </svg>
                                    {{ $vacancy->category->name }}
                                </span>
                            @endif
                            @if ($vacancy->location)
                                <span class="flex items-center gap-1.5">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" style="flex-shrink:0">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                    {{ $vacancy->location }}
                                </span>
                            @endif
                            @if ($vacancy->salary)
                                <span class="flex items-center gap-1.5">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" style="flex-shrink:0">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33" />
                                    </svg>
                                    {{ $vacancy->salary }}
                                </span>
                            @endif
                            @if ($vacancy->type)
                                <span class="inline-flex items-center rounded-full bg-teal-50 px-2.5 py-0.5 text-xs font-medium text-teal-700 ring-1 ring-teal-600/20">
                                    {{ $vacancy->type }}
                                </span>
                            @endif
                            <span class="flex items-center gap-1.5">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true" style="flex-shrink:0">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg>
                                {{ $vacancy->created_at?->format('M j, Y') ?? '—' }}
                            </span>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Applications -->
            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-teal-200/70">
                <div class="border-b border-gray-200/80 bg-gradient-to-r from-slate-50 to-gray-50/80 px-6 py-4">
                    <h3 class="text-base font-semibold text-gray-900">{{ __('Applications') }}</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        {{ $vacancy->apps->count() }}
                        {{ $vacancy->apps->count() === 1 ? __('application') : __('applications') }}
                    </p>
                </div>
                <div class="p-6">
                    @forelse ($vacancy->apps as $app)
                        <div class="{{ !$loop->last ? 'border-b border-gray-100 pb-4 mb-4' : '' }} flex items-center justify-between">
                            <div class="flex flex-col gap-1">
                                <span class="text-sm font-medium text-gray-800">{{ $app->user?->name ?? '—' }}</span>
                                <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500">
                                    @if ($app->ai_score)
                                        <span>{{ __('AI Score') }}: {{ $app->ai_score }}</span>
                                    @endif
                                    <span>{{ $app->created_at?->format('M j, Y') }}</span>
                                </div>
                            </div>
                            <span @class([
                                'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1',
                                'bg-yellow-50 text-yellow-700 ring-yellow-600/20' => $app->status === 'pending',
                                'bg-emerald-50 text-emerald-700 ring-emerald-600/20' => $app->status === 'accepted',
                                'bg-red-50 text-red-700 ring-red-600/20' => $app->status === 'rejected',
                            ])>
                                {{ ucfirst($app->status) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">{{ __('No applications yet.') }}</p>
                    @endforelse
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-wrap items-center justify-end gap-3">
                <a
                    href="{{ route('vacancies.edit', $vacancy) }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-teal-200 bg-white px-5 py-2.5 text-sm font-semibold text-teal-800 shadow-sm ring-1 ring-teal-600/10 transition hover:border-teal-300 hover:bg-teal-50 hover:text-teal-900 focus:outline-none focus-visible:ring-4 focus-visible:ring-teal-400/70 focus-visible:ring-offset-2"
                >
                    <svg class="size-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                    {{ __('Edit') }}
                </a>
                <form method="POST" action="{{ route('vacancies.destroy', $vacancy) }}" class="inline-flex">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        data-confirm="{{ __('Are you sure you want to archive') }} &quot;{{ $vacancy->title }}&quot;?"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-teal-200 bg-white px-5 py-2.5 text-sm font-semibold text-teal-800 shadow-sm ring-1 ring-teal-600/10 transition hover:border-teal-300 hover:bg-teal-50 hover:text-teal-900 focus:outline-none focus-visible:ring-4 focus-visible:ring-teal-400/70 focus-visible:ring-offset-2"
                    >
                        <svg class="size-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6m16 0v4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-4m16 0h-2.586a1 1 0 0 0-.707.293l-2.414 2.414a1 1 0 0 1-.707.293h-3.172a1 1 0 0 1-.707-.293l-2.414-2.414A1 1 0 0 0 6.586 13H4" />
                        </svg>
                        {{ __('Archive') }}
                    </button>
                </form>
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
