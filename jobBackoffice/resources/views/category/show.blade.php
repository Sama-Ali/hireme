<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $category->name }}
            </h2>
            <a
                href="{{ $category->trashed() ? route('categories.index', ['archived' => true]) : route('categories.index') }}"
                class="text-sm font-medium text-teal-700 hover:text-teal-800"
            >
                {{ $category->trashed() ? __('← Back to archived categories') : __('← Back to categories') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <x-auth-session-status class="mb-4" :status="session('status')" />

            @if ($category->trashed())
                <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
                    {{ __('This category is archived and is hidden from normal lists.') }}
                </div>
            @endif

            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-teal-200/70 sm:rounded-xl">
                <div class="p-6 text-gray-900 space-y-4">
                    <dl class="grid gap-4 sm:grid-cols-2">
                        <div class="mb-2">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Name') }}</dt>
                            <dd class="mt-1 mb-4 text-sm font-medium text-gray-900">{{ $category->name }}</dd>
                        </div>
                        <div class="mb-2">
                            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Created') }}</dt>
                            <dd class="mt-1 mb-4 text-sm text-gray-700">{{ $category->created_at?->timezone(config('app.timezone'))->format('M j, Y g:i A') ?? '—' }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Last update') }}</dt>
                            <dd class="mt-1 text-sm text-gray-700">{{ $category->updated_at?->timezone(config('app.timezone'))->format('M j, Y g:i A') ?? '—' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            @unless ($category->trashed())
                <div class="mt-6 flex flex-wrap items-center justify-end gap-3">
                    <a
                        href="{{ route('categories.edit', $category) }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-teal-200 bg-white px-5 py-2.5 text-sm font-semibold text-teal-800 shadow-sm ring-1 ring-teal-600/10 transition hover:border-teal-300 hover:bg-teal-50 hover:text-teal-900 focus:outline-none focus-visible:ring-4 focus-visible:ring-teal-400/70 focus-visible:ring-offset-2 focus-visible:ring-offset-gray-100 focus-visible:border-teal-400 focus-visible:bg-teal-50/60 focus-visible:shadow-md focus-visible:shadow-teal-500/20"
                    >
                        <svg class="size-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                        {{ __('Edit') }}
                    </a>
                    <form
                        method="POST"
                        action="{{ route('categories.destroy', $category) }}"
                        class="inline-flex"
                    >
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            data-confirm="{{ __('Are you sure you want to archive') }} &quot;{{ $category->name }}&quot;?"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-teal-200 bg-white px-5 py-2.5 text-sm font-semibold text-teal-800 shadow-sm ring-1 ring-teal-600/10 transition hover:border-teal-300 hover:bg-teal-50 hover:text-teal-900 focus:outline-none focus-visible:ring-4 focus-visible:ring-teal-400/70 focus-visible:ring-offset-2 focus-visible:ring-offset-gray-100 focus-visible:border-teal-400 focus-visible:bg-teal-50/60 focus-visible:shadow-md focus-visible:shadow-teal-500/20"
                        >
                            <svg class="size-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6m16 0v4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-4m16 0h-2.586a1 1 0 0 0-.707.293l-2.414 2.414a1 1 0 0 1-.707.293h-3.172a1 1 0 0 1-.707-.293l-2.414-2.414A1 1 0 0 0 6.586 13H4" />
                            </svg>
                            {{ __('Archive') }}
                        </button>
                    </form>
                </div>
            @endunless
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
