<div class="flex flex-wrap justify-center items-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg relative overflow-hidden w-1/3">
        <h2 class="text-xl font-bold mb-4 text-center">Card Title</h2>

        <!-- Container for sliding content with dynamic height -->
        <div class="relative overflow-hidden">
            <div class="flex transition-transform duration-500 ease-in-out"
                 style="transform: translateX(-{{ $currentStep * 100 }}%);">
                @foreach ($allAnswers as $index => $answers)
                    <div class="flex-shrink-0 w-full px-4 flex items-center">
                        <div class="flex flex-wrap justify-center gap-2">
                            @foreach ($answers as $answer)
                                <button
                                    class="btn btn-ghost btn-sm
                                    {{ in_array($answer->id, $checkedAnswers) ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800' }}"
                                    wire:click="toggleCheck({{ $answer->id }})"
                                    type="button">
                                    {{ $answer->answer }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-between w-full mt-4">
            @if ($currentStep > 0)
                <button wire:click="previousStep" class="btn btn-primary">
                    Previous
                </button>
            @endif
            @if ($currentStep < count($allAnswers) - 1)
                <button wire:click="nextStep" class="btn btn-primary ml-auto">
                    Next
                </button>
            @endif

            @if ($currentStep === count($allAnswers) - 1)
                <button wire:click="submitAnswers" class="btn btn-primary ml-auto">
                    Submit
                </button>
            @endif
        </div>
    </div>
</div>
