<div>
    @if (session()->has('message'))
        <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="submitRating" class="space-y-4">
        <div>
            <div class="flex space-x-1" @if ($checkStudent) wire:mouseleave="resetHoverRating"   onclick="leave_comment_modal.showModal()" @endif>
                @for ($i = 1; $i <= 5; $i++)
                    <svg @if ($checkStudent) 
                        wire:click.prevent="$set('rating', {{ $i }})"
                        wire:mouseover="setHoverRating({{ $i }})" 
                        @endif 
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 @if ($checkStudent) cursor-pointer @endif
                           {{ ($hoverRating !== null ? $hoverRating : $rating) >= $i ? 'text-yellow-400' : 'text-gray-300' }}
                           {{ (($hoverRating === null && $rating === 0) ? $avgRating : 0) >= $i ? 'text-yellow-400' : 'text-gray-300' }}"

                            title="Rate {{ $i }} star{{ $i > 1 ? 's' : '' }}"
                           fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.967a1 1 0 00.95.69h4.174c.969 0 1.371 1.24.588 1.81l-3.38 2.455a1 1 0 00-.364 1.118l1.287 3.966c.3.92-.755 1.688-1.54 1.118l-3.38-2.455a1 1 0 00-1.176 0l-3.38 2.455c-.784.57-1.838-.197-1.539-1.118l1.286-3.966a1 1 0 00-.364-1.118L2.03 9.394c-.783-.57-.38-1.81.588-1.81h4.174a1 1 0 00.95-.69l1.286-3.967z" />
                    </svg>
                @endfor
            </div>
            @error('rating')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
        </div>
        <dialog id="leave_comment_modal" class="modal modal-bottom sm:modal-middle" wire:ignore.self>
          <div class="modal-box">
            <h2 for="comment" class="modal-title text-2xl mb-3">Comment (optional)</h2>
            <hr class="my-3 border-t-1 border-gray-200 opacity-30">
            <textarea wire:model.defer="comment" id="comment" rows="4" class="textarea textarea-bordered w-full"
                placeholder="Write a comment..."></textarea>
            @error('comment')
                <span class="text-red-600 text-sm">{{ $message }}</span>
            @enderror
            <div class="w-full flex justify-end">
              <x-button type="submit" class="btn-primary mt-4" onclick="leave_comment_modal.close()">
                  Submit Rating
              </x-button>
            </div>
          </div>
        </dialog>
    </form>

</div>
