<x-main-layout>
    {{-- Hero --}}
    <section class="mx-auto max-w-7xl px-4 pb-16 pt-12 sm:px-6 sm:pt-16 lg:px-8 lg:pt-20"
        x-data="{ show: false }"
        x-init="setTimeout(() => show = true, 150)">

        <div class="mx-auto max-w-3xl text-center" x-cloak x-show="show"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0">

            <span class="inline-flex items-center gap-2 rounded-full border border-teal-200 bg-teal-50 px-4 py-1.5 text-xs font-semibold uppercase tracking-wide text-teal-800">
                <svg class="size-3.5 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09Z" />
                </svg>
                {{ __('Your job search, organized') }}
            </span>

            <h1 class="mt-6 text-4xl font-bold tracking-tight text-slate-900 sm:text-5xl lg:text-6xl">
                {{ __('Land next role with') }}
                <span class="bg-gradient-to-r from-teal-600 to-emerald-600 bg-clip-text text-transparent">{{ __('Hire Me') }}</span>
            </h1>

            <p class="mt-6 text-lg leading-relaxed text-slate-600 sm:text-xl">
                {{ __('Track every application, follow up on time, and see your progress—all in one simple dashboard built for job seekers.') }}
            </p>

        </div>
    </section>
</x-main-layout>
