<div class="bg-gray-800 rounded-lg shadow-lg p-6 mt-6 mb-6">
    <h3 class="text-xl font-semibold text-gray-100 mb-4 flex items-center">
        <span class="mr-2">Ratings</span>
        @if($count > 0)
            <span class="ml-2 text-yellow-400">&#9733; {{ number_format($average, 1) }} / 5</span>
            <span class="ml-2 text-gray-400">({{ $count }} {{ Str::plural('review', $count) }})</span>
        @else
            <span class="ml-2 text-gray-400">No ratings yet</span>
        @endif
    </h3>
    <div class="divide-y divide-gray-700">
        @forelse($ratings as $rating)
            <div class="py-4">
                <div class="flex items-center mb-1">
                    <span class="text-yellow-400 mr-2">&#9733; {{ $rating->rating }}</span>
                    <span class="text-gray-300 font-semibold">{{ $rating->student->name ?? 'Unknown' }}</span>
                    <span class="ml-2 text-gray-500 text-xs">{{ $rating->created_at->diffForHumans() }}</span>
                </div>
                @if($rating->comment)
                    <div class="text-gray-200 italic">"{{ $rating->comment }}"</div>
                @endif
            </div>
        @empty
            <div class="py-4 text-gray-400">No ratings to display.</div>
        @endforelse
    </div>
</div> 