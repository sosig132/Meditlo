<div>
    <h1>Admin Dashboard</h1>
    <h1>Answers for Question 1: (Ce fel de cont?)</h1>

    @foreach ($question_1_answers as $answer)
        <div>
            <p>{{ $answer->answer }}</p>
        </div>
    @endforeach

    <x-form wire:submit.prevent="addAnswer(1)">
        <x-input label="Answer" wire:model="answer1" />
        <x-slot name="actions">
            <x-button label="Add Answer" class="btn-primary" type="submit" />
        </x-slot>
    </x-form>

    <h1>Answers for Question 2: (Ce materii cauti?)</h1>

    @foreach ($question_2_answers as $answer)
        <div>
            <p>{{ $answer->answer }}</p>
        </div>
    @endforeach

    <x-form wire:submit.prevent="addAnswer(2)">
        <x-input label="Answer" wire:model="answer2" />
        <x-slot name="actions">
            <x-button label="Add Answer" class="btn-primary" type="submit" />
        </x-slot>
    </x-form>

    <h1>Answers for Question 3: (Ce stil de invatare crezi ca ti se potriveste?)</h1>

    @foreach ($question_3_answers as $answer)
        <div>
            <p>{{ $answer->answer }}</p>
        </div>
    @endforeach

    <x-form wire:submit.prevent="addAnswer(3)">
        <x-input label="Answer" wire:model="answer3" />
        <x-slot name="actions">
            <x-button label="Add Answer" class="btn-primary" type="submit" />
        </x-slot>
    </x-form>
</div>
