<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add company') }}
            </h2>
            <a
                href="{{ route('companies.index') }}"
                class="text-sm font-medium text-teal-700 hover:text-teal-800"
            >
                {{ __('← Back to companies') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-teal-200/70">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('companies.store') }}" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Company name')" />
                            <x-text-input
                                id="name"
                                name="name"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('name')"
                                autofocus
                                autocomplete="off"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div>
                            <x-input-label for="location" :value="__('Location')" />
                            <x-text-input
                                id="location"
                                name="location"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('location')"
                                autocomplete="off"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('location')" />
                        </div>

                        <div>
                            <x-input-label for="industry" :value="__('Industry')" />
                            <x-text-input
                                id="industry"
                                name="industry"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('industry')"
                                autocomplete="off"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('industry')" />
                        </div>

                        <div>
                            <x-input-label for="website" :value="__('Website')" />
                            <x-text-input
                                id="website"
                                name="website"
                                type="url"
                                class="mt-1 block w-full"
                                :value="old('website')"
                                autocomplete="off"
                                placeholder="https://"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('website')" />
                        </div>

                        <div>
                            <x-input-label for="owner_id" :value="__('Owner')" />
                            <select
                                id="owner_id"
                                name="owner_id"
                                class="mt-1 block w-64 rounded-md border-gray-300 shadow-sm focus:border-teal-500 focus:ring-teal-500 text-sm"
                            >
                                <option value="">{{ __('— None —') }}</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('owner_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('owner_id')" />
                        </div>

                        <div class="flex items-center gap-3">
                            <button
                                type="submit"
                                class="group inline-flex items-center gap-2 rounded-xl bg-gradient-to-br from-teal-500 to-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-teal-500/25 ring-1 ring-teal-600/10 transition hover:from-teal-600 hover:to-emerald-700 hover:shadow-lg hover:shadow-teal-500/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500/50 focus-visible:ring-offset-2"
                            >
                                {{ __('Create company') }}
                            </button>
                            <a
                                href="{{ route('companies.index') }}"
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
