<div>
    <div class="p-6">
        <h3 class="text-xl font-semibold mb-4">Edit Your Answers</h3>
        
        @foreach ($questions as $questionNumber => $questionText)
            <div class="mb-6">
                <h4 class="text-lg font-medium mb-3">{{ $questionText }}</h4>
                <div class="flex flex-wrap gap-2">
                    @foreach ($allAnswers[$questionNumber] as $answer)
                        <button
                            class="btn btn-sm {{ in_array($answer->id, $checkedAnswers) ? 'btn-primary' : 'btn-outline' }}"
                            wire:click="toggleCheck({{ $answer->id }})"
                            type="button">
                            {{ $answer->answer }}
                        </button>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="flex justify-end gap-3 mt-6">
            <button 
                class="btn btn-ghost" 
                onclick="edit_answers_modal.close()">
                Cancel
            </button>
            <button 
                class="btn btn-primary" 
                wire:click="saveAnswers"
                onclick="edit_answers_modal.close()">
                Save Changes
            </button>
        </div>
    </div>
</div> 