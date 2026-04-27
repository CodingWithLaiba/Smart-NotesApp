<!-- reusable note card component -->
 {{-- Reusable note card component --}}
{{-- Usage: @include('partials.note-card', ['note' => $note]) --}}

<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 flex flex-col gap-2 border border-gray-200 dark:border-gray-700">

    {{-- Title + pin/fav icons --}}
    <div class="flex justify-between items-start">
        <h3 class="font-semibold text-gray-800 dark:text-gray-100 truncate">
            {{ $note->title }}
        </h3>
        <div class="flex gap-2 text-sm">
            @if($note->is_pinned)
                <span title="Pinned">📌</span>
            @endif
            @if($note->is_favorite)
                <span title="Favorite">⭐</span>
            @endif
        </div>
    </div>

    {{-- Content preview --}}
    <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-3">
        {{ strip_tags($note->content) }}
    </p>

    {{-- Tags --}}
    @if($note->tags->count())
        <div class="flex flex-wrap gap-1">
            @foreach($note->tags as $tag)
                <span class="bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 text-xs px-2 py-0.5 rounded">
                    #{{ $tag->name }}
                </span>
            @endforeach
        </div>
    @endif

    {{-- Footer: date + actions --}}
    <div class="flex justify-between items-center mt-auto text-xs text-gray-400">
        <span>{{ $note->updated_at->diffForHumans() }}</span>
        <div class="flex gap-2">
            <a href="{{ route('notes.show', $note) }}" class="hover:text-blue-500">View</a>
            <a href="{{ route('notes.edit', $note) }}" class="hover:text-yellow-500">Edit</a>
            <form method="POST" action="{{ route('notes.destroy', $note) }}" onsubmit="return confirm('Move to trash?')">
                @csrf @method('DELETE')
                <button class="hover:text-red-500">Delete</button>
            </form>
        </div>
    </div>

</div>