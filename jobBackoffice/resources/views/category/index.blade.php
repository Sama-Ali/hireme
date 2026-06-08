<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ ($showArchived ?? false) ? __('Archived categories') : __('Categories') }}
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
                    @forelse ($categories as $category)
                        <div class="flex items-center justify-between gap-4 py-2.5 first:pt-0 last:pb-0">
                            @if ($showArchived ?? false)
                                <span class="min-w-0 flex-1 text-sm font-medium text-black">{{ $category->name }}</span>
                                <form
                                    method="POST"
                                    action="{{ route('categories.restore', $category->getKey()) }}"
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
                            @else
                                <a
                                    href="{{ route('categories.show', $category) }}"
                                    class="min-w-0 flex-1 text-sm font-medium text-black hover:text-teal-800 hover:underline"
                                >
                                    {{ $category->name }}
                                </a>
                            @endif
                        </div>
                    @empty
                        <div class="flex items-center justify-center">
                            <span class="text-sm text-gray-500">
                                {{ ($showArchived ?? false) ? __('No archived categories') : __('No categories found') }}
                            </span>
                        </div>
                    @endforelse
                    </div>
                </div>
            </div>
            <div class="mt-6 flex flex-wrap items-center justify-end gap-3">
                @if ($showArchived ?? false)
                    <a
                        href="{{ route('categories.index') }}"
                        class="inline-flex items-center gap-2 rounded-xl border-2 border-teal-300 bg-white px-5 py-2.5 text-sm font-semibold text-black shadow-sm transition hover:border-teal-400 hover:bg-teal-50 focus:outline-none focus-visible:border-teal-600 focus-visible:bg-teal-50 focus-visible:shadow-md focus-visible:shadow-teal-500/25 focus-visible:ring-2 focus-visible:ring-teal-500/70 focus-visible:ring-offset-2"
                    >
                        {{ __('Active categories') }}
                    </a>
                @else
                    <a
                        href="{{ route('categories.index', ['archived' => true]) }}"
                        aria-label="{{ __('Archived categories') }}"
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
                        href="{{ route('categories.create') }}"
                        aria-label="{{ __('Add category') }}"
                        class="group inline-flex items-center gap-2 rounded-xl bg-gradient-to-br from-teal-500 to-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-teal-500/25 ring-1 ring-teal-600/10 transition hover:from-teal-600 hover:to-emerald-700 hover:shadow-lg hover:shadow-teal-500/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500/50 focus-visible:ring-offset-2"
                    >
                        <svg class="size-4 transition-transform duration-200 group-hover:rotate-90" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        {{ __('Add category') }}
                    </a>
                @endunless
            </div>
        </div>
    </div>

    
</x-app-layout>
