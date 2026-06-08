<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl space-y-16 sm:px-6 lg:px-8">
            {{-- KPIs --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
                <div class="rounded-xl border border-teal-200 bg-white p-5 shadow-sm ring-1 ring-teal-200/40">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                        {{ __('Active job seekers (last 30 days)') }}
                    </p>
                    <p class="mt-2 text-3xl font-bold tabular-nums text-gray-900">{{ number_format($activeJobSeekersCount) }}</p>
                    @if(auth()->user()->role == 'admin')
                    <a href="{{ route('users.index') }}" class="mt-3 inline-flex text-xs font-semibold text-teal-700 hover:text-teal-900">
                        {{ __('View users') }}
                        <span aria-hidden="true" class="ml-0.5">→</span>
                    </a>
                    @endif
                </div>

                <div class="rounded-xl border border-teal-200 bg-white p-5 shadow-sm ring-1 ring-teal-200/40">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                        {{ __('Active vacancies') }}
                    </p>
                    <p class="mt-2 text-3xl font-bold tabular-nums text-gray-900">{{ number_format($activeVacanciesCount) }}</p>
                    <a href="{{ route('vacancies.index') }}" class="mt-3 inline-flex text-xs font-semibold text-teal-700 hover:text-teal-900">
                        {{ __('View vacancies') }}
                        <span aria-hidden="true" class="ml-0.5">→</span>
                    </a>
                </div>

                <div class="rounded-xl border border-teal-200 bg-white p-5 shadow-sm ring-1 ring-teal-200/40">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                        {{ __('Total applications') }}
                    </p>
                    <p class="mt-2 text-3xl font-bold tabular-nums text-gray-900">{{ number_format($applicationsCount) }}</p>
                    <a href="{{ route('apps.index') }}" class="mt-3 inline-flex text-xs font-semibold text-teal-700 hover:text-teal-900">
                        {{ __('View applications') }}
                        <span aria-hidden="true" class="ml-0.5">→</span>
                    </a>
                </div>

                @if(auth()->user()->role == 'admin')
                <div class="rounded-xl border border-teal-200 bg-white p-5 shadow-sm ring-1 ring-teal-200/40">
                    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">
                        {{ __('Companies') }}
                    </p>
                    <p class="mt-2 text-3xl font-bold tabular-nums text-gray-900">{{ number_format($companiesCount) }}</p>
                    <a href="{{ route('companies.index') }}" class="mt-3 inline-flex text-xs font-semibold text-teal-700 hover:text-teal-900">
                        {{ __('View companies') }}
                        <span aria-hidden="true" class="ml-0.5">→</span>
                    </a>
                </div>
                @endif
            </div>

            {{-- Most applied jobs --}}
            <div class="space-y-5">
                <h3 class="text-sm font-semibold text-gray-900">{{ __('Most applied jobs') }}</h3>
                <div class="overflow-hidden rounded-xl border border-teal-200 bg-white shadow-sm ring-1 ring-teal-200/40">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 font-semibold text-gray-700">{{ __('Job title') }}</th>
                                    @if(auth()->user()->role=='admin')
                                    <th scope="col" class="px-4 py-3 font-semibold text-gray-700">{{ __('Company') }}</th>
                                    @endif
                                    <th scope="col" class="px-4 py-3 font-semibold text-gray-700">{{ __('Category') }}</th>
                                    <th scope="col" class="px-4 py-3 text-right font-semibold text-gray-700">{{ __('Applications') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse ($mostAppliedVacancies as $vacancy)
                                    <tr class="hover:bg-gray-50/80">
                                        <td class="px-4 py-3 font-medium text-gray-900">
                                            <a href="{{ route('vacancies.show', $vacancy) }}" class="text-teal-700 hover:text-teal-900 hover:underline">
                                                {{ $vacancy->title }}
                                            </a>
                                        </td>
                                        @if(auth()->user()->role=='admin')
                                        <td class="px-4 py-3 text-gray-700">
                                            {{ $vacancy->company?->name ?? '—' }}
                                        </td>
                                        @endif
                                        <td class="px-4 py-3 text-gray-700">
                                            {{ $vacancy->category?->name ?? '—' }}
                                        </td>
                                        <td class="px-4 py-3 text-right tabular-nums text-gray-900">
                                            {{ number_format($vacancy->apps_count) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">
                                            {{ __('No applications yet.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Top converting job posts --}}
            <div class="space-y-5">
                <h3 class="text-sm font-semibold text-gray-900">{{ __('Top converting job posts') }}</h3>
                <div class="overflow-hidden rounded-xl border border-teal-200 bg-white shadow-sm ring-1 ring-teal-200/40">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 font-semibold text-gray-700">{{ __('Job title') }}</th>
                                    <th scope="col" class="px-4 py-3 text-right font-semibold text-gray-700">{{ __('Views') }}</th>
                                    <th scope="col" class="px-4 py-3 text-right font-semibold text-gray-700">{{ __('Applications') }}</th>
                                    <th scope="col" class="px-4 py-3 text-right font-semibold text-gray-700">{{ __('Conversion rate') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse ($convertingJobPost as $row)
                                    <tr class="hover:bg-gray-50/80">
                                        <td class="px-4 py-3 font-medium text-gray-900">
                                            <a href="{{ route('vacancies.show', $row['vacancy']) }}" class="text-teal-700 hover:text-teal-900 hover:underline">
                                                {{ $row['vacancy']->title }}
                                            </a>
                                        </td>
                                        <td class="px-4 py-3 text-right tabular-nums text-gray-900">
                                            {{ number_format($row['vacancy']->views) }}
                                        </td>
                                        <td class="px-4 py-3 text-right tabular-nums text-gray-900">
                                            {{ number_format($row['vacancy']->apps_count) }}
                                        </td>
                                        <td class="px-4 py-3 text-right tabular-nums text-gray-900">
                                            @if ($row['conversion_rate_percent'] !== null)
                                                {{ number_format($row['conversion_rate_percent'], 1) }}%
                                            @else
                                                <span class="text-gray-400" title="{{ __('Views are zero; rate is undefined.') }}">{{ __('N/A') }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">
                                            {{ __('No job posts with applications yet.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if(auth()->user()->role == 'admin')
            {{-- Top companies by vacancies --}}
            <div class="space-y-5">
                <h3 class="text-sm font-semibold text-gray-900">{{ __('Top 3 companies by vacancies') }}</h3>
                <div class="overflow-hidden rounded-xl border border-teal-200 bg-white shadow-sm ring-1 ring-teal-200/40">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 font-semibold text-gray-700">{{ __('Company') }}</th>
                                    <th scope="col" class="px-4 py-3 font-semibold text-gray-700">{{ __('Industry') }}</th>
                                    <th scope="col" class="px-4 py-3 font-semibold text-gray-700">{{ __('Website') }}</th>
                                    <th scope="col" class="px-4 py-3 text-right font-semibold text-gray-700">{{ __('Vacancies') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse ($topCompanies as $company)
                                    <tr class="hover:bg-gray-50/80">
                                        <td class="px-4 py-3 font-medium text-gray-900">
                                            <a href="{{ route('companies.show', $company) }}" class="text-teal-700 hover:text-teal-900 hover:underline">
                                                {{ $company->name }}
                                            </a>
                                        </td>
                                        <td class="px-4 py-3 text-gray-700">
                                            {{ $company->industry ?? '—' }}
                                        </td>
                                        <td class="px-4 py-3 text-gray-700">
                                            @if ($company->website)
                                                @php
                                                    $href = \Illuminate\Support\Str::startsWith($company->website, ['http://', 'https://'])
                                                        ? $company->website
                                                        : 'https://'.$company->website;
                                                @endphp
                                                <a href="{{ $href }}" target="_blank" rel="noopener noreferrer" class="max-w-xs truncate text-teal-700 hover:text-teal-900 hover:underline">
                                                    {{ $company->website }}
                                                </a>
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 text-right tabular-nums text-gray-900">
                                            {{ number_format($company->vacancies_count) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">
                                            {{ __('No companies yet.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
