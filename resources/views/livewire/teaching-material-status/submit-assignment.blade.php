<div>
    @if(!empty($data['obtained_marks']))
        <section
            class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="fi-section-content-ctn">
                <div class="fi-section-content p-6">
                    <div class="flex items-center gap-x-3 justify-between ">
                        <label class="fi-fo-field-wrp-label inline-flex items-center gap-x-3" for="data.week">
                                    <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                                        Obtained Marks
                                    </span>
                        </label>
                    </div>
                    <div class="grid auto-cols-fr gap-y-2">
                        <div class="fi-fo-placeholder text-sm leading-6">
                            {{ $data['obtained_marks'] }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <form wire:submit="create">
            {{ $this->form }}

            {{--{{ dd($data) }}--}}
            <div class="flex justify-end pt-4">
                @if(empty($data['id']))

                    <span>Click here to submit assignment ></span>
                    <button type="submit"
                            style="--c-400:var(--primary-400);--c-500:var(--primary-500);--c-600:var(--primary-600);"
                            class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75
                             focus-visible:ring-2 rounded-lg fi-color-custom fi-btn-color-primary fi-color-primary fi-size-md fi-btn-size-md
                              gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-custom-600 text-white hover:bg-custom-500 focus-visible:ring-custom-500/50
                               dark:bg-custom-500 dark:hover:bg-custom-400 dark:focus-visible:ring-custom-400/50 fi-ac-action fi-ac-btn-action">
                        Submit Assignment
                    </button>

                @elseif(!empty($data['obtained_marks']))

                @endif
            </div>
        </form>

        @if(empty($data['id']))

        @elseif(!empty($data['obtained_marks']))

        @else
            <button wire:click="delete({{ $this->data['id'] ?? 0 }}, {{ $this->data['batch_id'] ?? 0 }})"
                    style="--c-400:var(--primary-400);--c-500:var(--primary-500);--c-600:var(--primary-600);"
                    class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75
                             focus-visible:ring-2 rounded-lg fi-color-custom fi-btn-color-primary fi-color-primary fi-size-md fi-btn-size-md
                              gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-custom-600 text-white hover:bg-custom-500 focus-visible:ring-custom-500/50
                               dark:bg-custom-500 dark:hover:bg-custom-400 dark:focus-visible:ring-custom-400/50 fi-ac-action fi-ac-btn-action"
            >Delete Assignment
            </button>
        @endif
    @endif

    <x-filament-actions::modals/>
</div>
