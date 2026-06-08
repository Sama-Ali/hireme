<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit category') }}
            </h2>
            <a
                href="{{ route('categories.index') }}"
                class="text-sm font-medium text-teal-700 hover:text-teal-800"
            >
                {{ __('← Back to categories') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('categories.update', $category) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('Category name')" />
                            <x-text-input
                                id="name"
                                name="name"
                                type="text"
                                class="mt-1 block w-full"
                                :value="old('name', $category->name)"
                                required
                                autofocus
                                autocomplete="off"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="flex items-center gap-3">
                            <button
                                type="submit"
                                class="group inline-flex items-center gap-2 rounded-xl bg-gradient-to-br from-teal-500 to-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-teal-500/25 ring-1 ring-teal-600/10 transition hover:from-teal-600 hover:to-emerald-700 hover:shadow-lg hover:shadow-teal-500/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500/50 focus-visible:ring-offset-2"
                            >
                                {{ __('Save changes') }}
                            </button>
                            <a
                                href="{{ route('categories.show', $category) }}"
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
