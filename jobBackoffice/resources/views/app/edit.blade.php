<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Application') }}
            </h2>
            <a
                href="{{ route('apps.show', $app) }}"
                class="text-sm font-medium text-teal-700 hover:text-teal-800"
            >
                {{ __('← Back to application') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-teal-200/70">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('apps.update', $app) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Read-only: Applicant --}}
                        <div>
                            <x-input-label :value="__('Applicant')" />
                            <p class="mt-1 text-sm text-gray-700">{{ $app->user?->name ?? '—' }}</p>
                        </div>

                        {{-- Read-only: Vacancy --}}
                        <div>
                            <x-input-label :value="__('Applied for')" />
                            <p class="mt-1 text-sm text-gray-700">{{ $app->vacancy?->title ?? '—' }}</p>
                        </div>

                        <hr class="border-gray-100">

                        {{-- Status --}}
                        <div>
                            <x-input-label for="status" :value="__('Status')" />
                            <select
                                id="status"
                                name="status"
                                class="mt-1 block w-48 rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm"
                            >
                                @foreach (['pending', 'accepted', 'rejected'] as $statusOption)
                                    <option value="{{ $statusOption }}" {{ old('status', $app->status) === $statusOption ? 'selected' : '' }}>
                                        {{ ucfirst($statusOption) }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('status')" />
                        </div>

                        <div class="flex items-center gap-3">
                            <button
                                type="submit"
                                class="group inline-flex items-center gap-2 rounded-xl bg-gradient-to-br from-teal-500 to-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-teal-500/25 ring-1 ring-teal-600/10 transition hover:from-teal-600 hover:to-emerald-700 hover:shadow-lg hover:shadow-teal-500/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500/50 focus-visible:ring-offset-2"
                            >
                                {{ __('Save changes') }}
                            </button>
                            <a
                                href="{{ route('apps.show', $app) }}"
                                class="text-sm font-medium text-gray-600 hover:text-gray-900"
                            >
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
