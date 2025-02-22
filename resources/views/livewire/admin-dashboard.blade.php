<div>
    <h1 class="text-center text-3xl">Admin Dashboard</h1>
    <hr class="my-4">
    <h2 class="text-2xl mb-4">Answers to profile creation questions</h2>
    <div class="flex flex-col mx-10">
        @foreach ($questions as $questionNumber)
            <div>
                <h1>Answers for Question {{ $questionNumber }}:
                    @switch($questionNumber)
                        @case(1)
                            (Ce fel de cont?)
                            @break
                        @case(2)
                            (Ce materii cauti?)
                            @break
                        @case(3)
                            (Ce stil de invatare crezi ca ti se potriveste?)
                            @break
                        @case(4)
                            (Ce nivel de invatamant te intereseaza?)
                            @break
                    @endswitch
                </h1>

                @foreach ($possibleAnswers->get($questionNumber) as $answer)
                    <div>
                        <p>{{ $answer->answer }}</p>
                    </div>
                @endforeach

                <x-form wire:submit.prevent="addAnswer({{ $questionNumber }})" class="col-span-3">
                    <x-input label="Answer" wire:model="answers.{{ $questionNumber }}" />
                    <x-slot name="actions">
                        <x-button label="Add Answer" class="btn-primary" type="submit" />
                    </x-slot>
                </x-form>
            </div>
        @endforeach
    </div>
</div>
