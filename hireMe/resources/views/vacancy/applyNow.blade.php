<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-3xl space-y-6 sm:px-6 lg:px-8">
            <x-auth-session-status class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-center text-sm text-emerald-800" :status="session('status')" />

            <div class="rounded-xl border border-teal-300 bg-white shadow-sm ring-1 ring-teal-200/40">
                <div class="border-b border-teal-100/80 bg-gradient-to-r from-teal-50/50 to-white px-6 py-4">
                    <h3 class="text-base font-semibold text-slate-900">{{ $vacancy->title }}</h3>
                    @if ($vacancy->company)
                        <p class="mt-1 text-sm text-gray-500">{{ $vacancy->company->name }}</p>
                    @endif
                </div> 
                <div class="p-6">
                    @if ($hasApplied)
                        <p class="text-sm text-slate-600">
                            {{ __('You have already applied for this position.') }}
                        </p>
                        <div class="mt-6 flex justify-end">
                            <a
                                href="{{ route('vacancies.show', $vacancy) }}"
                                class="inline-flex items-center justify-center rounded-xl border-2 border-teal-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-teal-400 hover:bg-teal-50 hover:text-teal-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500/60 focus-visible:ring-offset-2"
                            >
                                {{ __('Back to job') }}
                            </a>
                        </div>
                    @else
                        <form
                            method="POST"
                            action="{{ route('vacancies.apply.store', $vacancy) }}"
                            enctype="multipart/form-data"
                            class="space-y-6"
                            novalidate
                        >
                            @csrf
                            <div>
                                <x-input-label for="name" :value="__('Your name')" class="text-slate-700" />
                                <x-text-input
                                    id="name"
                                    name="name"
                                    type="text"
                                    class="mt-2 block w-full rounded-xl border-2 border-teal-200 !shadow-sm focus:!border-teal-400 focus:!ring-teal-500/25"
                                    :value="old('name', $user->name)"
                                    autocomplete="name"
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            @php
                                $resumeOptions = $resumes->map(fn ($r) => ['id' => $r->id, 'name' => $r->name])->values();
                                $defaultResumeId = old('resume_id', $resumes->isNotEmpty() ? $resumes->first()->id : 'new');
                                $fallbackResumeId = $resumes->isNotEmpty() ? $resumes->first()->id : 'new';
                                $uploadNewLabel = __('Upload new CV');
                                $chooseFileLabel = __('Choose CV file');
                                $defaultLabel = $defaultResumeId === 'new'
                                    ? $uploadNewLabel
                                    : ($resumes->firstWhere('id', $defaultResumeId)?->name ?? $resumes->first()?->name ?? $uploadNewLabel);
                            @endphp

                            <div
                                x-data="applyCvPicker(@js([
                                    'resumeChoice' => $defaultResumeId,
                                    'previousChoice' => $fallbackResumeId,
                                    'selectedLabel' => $defaultLabel,
                                    'uploadNewLabel' => $uploadNewLabel,
                                    'chooseFileLabel' => $chooseFileLabel,
                                    'resumes' => $resumeOptions,
                                ]))"
                                class="relative"
                            >
                                <x-input-label for="resume_id" :value="__('CV / Resume')" class="text-slate-700" />

                                @if ($resumes->isEmpty())
                                    <input type="hidden" name="resume_id" value="new" />
                                    <button
                                        type="button"
                                        @click="openNewCv()"
                                        class="mt-2 flex w-full items-center justify-between gap-3 rounded-xl border-2 border-teal-200 bg-white px-4 py-2.5 text-left text-sm text-slate-900 shadow-sm transition hover:border-teal-400 focus:border-teal-400 focus:outline-none focus:ring-2 focus:ring-teal-500/25"
                                    >
                                        <span class="truncate" x-text="newFileName || chooseFileLabel"></span>
                                        <svg class="size-4 shrink-0 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                                        </svg>
                                    </button>
                                @else
                                    <input type="hidden" name="resume_id" x-model="resumeChoice" />
                                    <button
                                        type="button"
                                        id="resume_id"
                                        @click="menuOpen = !menuOpen"
                                        @keydown.escape.window="menuOpen = false"
                                        class="mt-2 flex w-full items-center justify-between gap-3 rounded-xl border-2 border-teal-200 bg-white px-4 py-2.5 text-left text-sm text-slate-900 shadow-sm transition hover:border-teal-400 focus:border-teal-400 focus:outline-none focus:ring-2 focus:ring-teal-500/25"
                                        :aria-expanded="menuOpen"
                                    >
                                        <span class="truncate" x-text="resumeChoice === 'new' && newFileName ? newFileName : selectedLabel"></span>
                                        <svg class="size-4 shrink-0 text-slate-500 transition" :class="menuOpen && 'rotate-180'" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                        </svg>
                                    </button>

                                    <div
                                        x-show="menuOpen"
                                        x-cloak
                                        @click.outside="menuOpen = false"
                                        class="absolute left-0 right-0 z-50 mt-1 max-h-60 overflow-auto rounded-xl border border-teal-200 bg-white py-1 shadow-lg ring-1 ring-teal-200/40"
                                    >
                                        <template x-for="resume in resumes" :key="resume.id">
                                            <button
                                                type="button"
                                                @click="selectExisting(resume.id, resume.name)"
                                                class="flex w-full items-center px-4 py-2.5 text-left text-sm text-slate-800 transition hover:bg-teal-50"
                                                :class="resumeChoice === resume.id && 'bg-teal-50 font-medium text-teal-900'"
                                            >
                                                <span class="truncate" x-text="resume.name"></span>
                                            </button>
                                        </template>
                                        <button
                                            type="button"
                                            @click.stop="selectNew()"
                                            class="flex w-full items-center border-t border-teal-100 px-4 py-2.5 text-left text-sm text-teal-900 transition hover:bg-teal-50"
                                            :class="resumeChoice === 'new' && 'bg-teal-50 font-medium'"
                                        >
                                            {{ __('Upload new CV') }}
                                        </button>
                                    </div>
                                @endif

                                <input
                                    x-ref="cvInput"
                                    id="cv"
                                    name="cv"
                                    type="file"
                                    accept=".pdf,application/pdf"
                                    class="hidden"
                                    @if ($resumes->isNotEmpty())
                                        :disabled="resumeChoice !== 'new'"
                                    @endif
                                    @change="onFileChosen($event)"
                                />
                                <p class="mt-2 text-xs text-slate-500">{{ __('PDF only — max 5 MB') }}</p>
                                <x-input-error class="mt-2" :messages="$errors->get('resume_id')" />
                                <x-input-error class="mt-2" :messages="$errors->get('cv')" />
                            </div>

                            <div class="flex flex-wrap items-center justify-end gap-3 border-t border-teal-100/80 pt-6">
                                <a
                                    href="{{ route('vacancies.show', $vacancy) }}"
                                    class="inline-flex items-center justify-center rounded-xl border-2 border-teal-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-teal-400 hover:bg-teal-50 hover:text-teal-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500/60 focus-visible:ring-offset-2"
                                >
                                    {{ __('Cancel') }}
                                </a>
                                <button
                                    type="submit"
                                    class="inline-flex items-center justify-center rounded-xl bg-gradient-to-br from-teal-500 to-emerald-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-teal-500/25 ring-1 ring-teal-600/10 transition hover:from-teal-600 hover:to-emerald-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-500/60 focus-visible:ring-offset-2"
                                >
                                    {{ __('Apply now') }}
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
