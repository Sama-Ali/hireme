<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ ($showArchived ?? false) ? __('Archived users') : __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto space-y-8 sm:px-6 lg:px-8">
            <x-auth-session-status
                class="rounded-lg text-center border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800"
                :status="session('status')"
            />

            {{-- Job Seekers --}}
            <div>
                <div class="mb-3 flex items-center gap-2">
                    <div class="flex size-8 shrink-0 items-center justify-center rounded-full bg-teal-50 ring-1 ring-teal-600/20">
                        <svg class="size-4 text-teal-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700">{{ __('Job Seekers') }}</span>
                    <span class="text-xs text-gray-400">{{ $jobSeekers->count() }}</span>
                </div>

                <div class="overflow-hidden rounded-xl border border-teal-300 bg-white shadow-sm ring-1 ring-teal-200/40 divide-y divide-gray-100 sm:rounded-xl">
                    @forelse ($jobSeekers as $user)
                        <div class="flex items-center justify-between gap-4 px-6 py-4">
                            <div class="flex min-w-0 items-center gap-3">
                                <div class="flex size-9 aspect-square shrink-0 items-center justify-center rounded-full bg-teal-50 text-sm font-semibold text-teal-700 ring-1 ring-teal-200">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                                    <p class="truncate text-xs text-gray-400">{{ $user->email }}</p>
                                </div>
                            </div>

                            <div class="flex shrink-0 flex-wrap items-center justify-end gap-3 text-xs text-gray-400">
                                @if ($user->email_verified_at)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700 ring-1 ring-emerald-500/30">
                                        <svg class="size-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                        </svg>
                                        {{ __('Verified') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-yellow-50 px-2 py-0.5 text-xs font-medium text-yellow-700 ring-1 ring-yellow-500/30">
                                        {{ __('Unverified') }}
                                    </span>
                                @endif

                                @if ($showArchived ?? false)
                                    <form
                                        method="POST"
                                        action="{{ route('users.restore', $user->getKey()) }}"
                                        class="flex shrink-0 items-center"
                                    >
                                        @csrf
                                        <button
                                            type="submit"
                                            title="{{ __('Restore') }}"
                                            class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-xl border-2 border-teal-300 bg-white px-3 py-2 text-xs font-semibold text-teal-900 shadow-sm transition hover:border-teal-400 hover:bg-teal-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500/60 focus-visible:ring-offset-2"
                                        >
                                            <svg class="size-3.5 shrink-0 text-teal-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 4.5-4.5M3 9h12a6 6 0 0 1 0 12h-3" />
                                            </svg>
                                            {{ __('Restore') }}
                                        </button>
                                    </form>
                                @else
                                    <a
                                        href="{{ route('users.edit', $user) }}"
                                        title="{{ __('Edit') }}"
                                        class="text-gray-400 transition hover:text-teal-600"
                                    >
                                        <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                                        </svg>
                                    </a>

                                    <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('{{ __('Archive this user?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            title="{{ __('Archive') }}"
                                            class="text-gray-400 transition hover:text-red-500"
                                        >
                                            <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25v6M14 11.25v6M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="flex items-center justify-center py-10 text-sm text-gray-400">
                            {{ ($showArchived ?? false) ? __('No archived job seekers') : __('No job seekers found') }}
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Company Owners --}}
            <div>
                <div class="mb-3 mt-4 flex items-center gap-2">
                    <div class="flex size-8 shrink-0 items-center justify-center rounded-full bg-indigo-50 ring-1 ring-indigo-600/20">
                        <svg class="size-4 text-indigo-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700">{{ __('Company Owners') }}</span>
                    <span class="text-xs text-gray-400">{{ $companyOwners->count() }}</span>
                </div>

                <div class="overflow-hidden rounded-xl border border-indigo-200 bg-white shadow-sm ring-1 ring-indigo-200/40 divide-y divide-gray-100 sm:rounded-xl">
                    @forelse ($companyOwners as $user)
                        <div class="flex items-center justify-between gap-4 px-6 py-4">
                            <div class="flex min-w-0 items-center gap-3">
                                <div class="flex size-9 aspect-square shrink-0 items-center justify-center rounded-full bg-indigo-50 text-sm font-semibold text-indigo-700 ring-1 ring-indigo-200">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="mb-2 truncate text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                                    <p class="mb-1 truncate text-xs text-gray-400">{{ $user->email }}</p>
                                    @if ($user->companies)
                                        <p class="mt-0.5 truncate text-xs text-indigo-500">{{ $user->companies->name }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex shrink-0 flex-wrap items-center justify-end gap-3 text-xs text-gray-400">
                                @if ($user->email_verified_at)
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700 ring-1 ring-emerald-500/30">
                                        <svg class="size-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                        </svg>
                                        {{ __('Verified') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-yellow-50 px-2 py-0.5 text-xs font-medium text-yellow-700 ring-1 ring-yellow-500/30">
                                        {{ __('Unverified') }}
                                    </span>
                                @endif

                                @if ($showArchived ?? false)
                                    <form
                                        method="POST"
                                        action="{{ route('users.restore', $user->getKey()) }}"
                                        class="flex shrink-0 items-center"
                                    >
                                        @csrf
                                        <button
                                            type="submit"
                                            title="{{ __('Restore') }}"
                                            class="inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-xl border-2 border-teal-300 bg-white px-3 py-2 text-xs font-semibold text-teal-900 shadow-sm transition hover:border-teal-400 hover:bg-teal-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500/60 focus-visible:ring-offset-2"
                                        >
                                            <svg class="size-3.5 shrink-0 text-teal-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 4.5-4.5M3 9h12a6 6 0 0 1 0 12h-3" />
                                            </svg>
                                            {{ __('Restore') }}
                                        </button>
                                    </form>
                                @else
                                    <a
                                        href="{{ route('users.edit', $user) }}"
                                        title="{{ __('Edit') }}"
                                        class="text-gray-400 transition hover:text-teal-600"
                                    >
                                        <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
                                        </svg>
                                    </a>

                                    <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('{{ __('Archive this user?') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            title="{{ __('Archive') }}"
                                            class="text-gray-400 transition hover:text-red-500"
                                        >
                                            <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25v6M14 11.25v6M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="flex items-center justify-center py-10 text-sm text-gray-400">
                            {{ ($showArchived ?? false) ? __('No archived company owners') : __('No company owners found') }}
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-6 flex flex-wrap items-center justify-end gap-3">
                @if ($showArchived ?? false)
                    <a
                        href="{{ route('users.index') }}"
                        class="inline-flex items-center gap-2 rounded-xl border-2 border-teal-300 bg-white px-5 py-2.5 text-sm font-semibold text-black shadow-sm transition hover:border-teal-400 hover:bg-teal-50 focus:outline-none focus-visible:border-teal-600 focus-visible:bg-teal-50 focus-visible:shadow-md focus-visible:shadow-teal-500/25 focus-visible:ring-2 focus-visible:ring-teal-500/70 focus-visible:ring-offset-2"
                    >
                        {{ __('Active users') }}
                    </a>
                @else
                    <a
                        href="{{ route('users.index', ['archived' => true]) }}"
                        aria-label="{{ __('Archived users') }}"
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
