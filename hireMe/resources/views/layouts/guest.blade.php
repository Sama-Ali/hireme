<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', __('Hire Me')) }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    <style>
        [x-cloak] { display: none !important; }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-900">
    <div class="relative flex min-h-screen flex-col bg-slate-50">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_80%_50%_at_50%_-20%,rgba(45,212,191,0.12),transparent)]"></div>

        {{-- Header --}}
        <header class="relative z-20 border-b border-slate-200/80 bg-white/90 backdrop-blur-md">
            <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
                <a href="{{ url('/') }}" class="group flex min-w-0 items-center gap-3 rounded-2xl outline-none ring-teal-500/0 transition focus-visible:ring-2 focus-visible:ring-teal-500/50">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-gradient-to-br from-teal-500 via-teal-500 to-emerald-600 shadow-md shadow-teal-500/25 ring-1 ring-teal-600/10">
                        <svg class="size-5 text-white" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M8 7V5a2 2 0 012-2h4a2 2 0 012 2v2m-9 4h10l1 10H7L8 11z" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </span>
                    <span class="truncate text-lg font-bold tracking-tight text-slate-900 group-hover:text-teal-800 transition-colors">{{ __('Hire Me') }}</span>
                </a>
            </div>
        </header>

        {{-- Auth card --}}
        <div class="relative z-10 flex flex-1 flex-col items-center justify-center px-4 py-12 sm:px-6"
            x-data="{ show: false }"
            x-init="setTimeout(() => show = true, 200)">

            <div x-cloak x-show="show"
                x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="w-full max-w-md rounded-xl border border-teal-200 bg-white p-6 shadow-sm ring-1 ring-teal-200/40 sm:p-8">
                {{ $slot }}
            </div>
        </div>

        <footer class="relative z-10 border-t border-slate-200/80 bg-white/80 py-6 backdrop-blur-sm">
            <div class="mx-auto max-w-7xl px-4 text-center text-sm text-slate-500 sm:px-6 lg:px-8">
                &copy; {{ date('Y') }} {{ __('Hire Me') }}
            </div>
        </footer>
    </div>
</body>
</html>
