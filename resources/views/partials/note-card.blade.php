{{-- Reusable note card with modern design --}}
{{-- Usage: @include('partials.note-card', ['note' => $note]) --}}

@php
$colorClasses = [
'white' => 'bg-white dark:bg-gray-800 border-gray-200',
'yellow' => 'bg-yellow-50 dark:bg-yellow-900/20 border-yellow-200',
'blue' => 'bg-blue-50 dark:bg-blue-900/20 border-blue-200',
'green' => 'bg-green-50 dark:bg-green-900/20 border-green-200',
'pink' => 'bg-pink-50 dark:bg-pink-900/20 border-pink-200',
];
$colorClass = $colorClasses[$note->color] ?? $colorClasses['white'];
@endphp

<div class="card-hover {{ $colorClass }} rounded-xl shadow-sm border dark:border-gray-700 p-5 flex flex-col gap-3 h-full relative overflow-hidden group">

    {{-- Pinned/Favorite badges --}}
    @if($note->is_pinned || $note->is_favorite)
    <div class="absolute top-3 right-3 flex gap-1.5">
        @if($note->is_pinned)
        <span class="w-7 h-7 bg-yellow-400 rounded-full flex items-center justify-center shadow-sm" title="Pinned"> 📌 </span>
        @endif
        @if($note->is_favorite)
        <span class="w-7 h-7 bg-yellow-200 rounded-full flex items-center justify-center shadow-sm" title="Favorite">
            ⭐
        </span>
        @endif
    </div>
    @endif

    {{-- Title --}}
    <h3 class="font-bold text-lg text-gray-800 dark:text-gray-100 truncate pr-16">
        {{ $note->title }}
    </h3>

    @if($note->image_path)
    <img src="{{ asset('storage/' . $note->image_path) }}" alt="Note image" class="w-full h-36 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
    @endif

    {{-- Content preview --}}
    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-4 grow">
        {{ strip_tags($note->content) }}
    </p>

    {{-- Tags --}}
    @if($note->tags->count())
    <div class="flex flex-wrap gap-1.5">
        @foreach($note->tags->take(3) as $tag)
        <span class="bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 text-xs px-2 py-0.5 rounded-full">
            🏷️ {{ $tag->name }}
        </span>
        @endforeach
        @if($note->tags->count() > 3)
        <span class="text-xs text-gray-500 dark:text-gray-400 px-1">+{{ $note->tags->count() - 3 }}</span>
        @endif
    </div>
    @endif
    {{-- Catagories --}}
    @if($note->categories->count())
    <div class="flex flex-wrap gap-1.5">
        @foreach($note->categories->take(3) as $category)
        <span class="bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300 text-xs px-2 py-0.5 rounded-full">
        🎯 {{ $category->name }}
        </span>
        @endforeach
        @if($note->categories->count() > 3)
        <span class="text-xs text-gray-500 dark:text-gray-400 px-1">+{{ $note->categories->count() - 3 }}</span>
        @endif
    </div>
    @endif

    

    {{-- Footer --}}
    <div class="flex justify-between items-center mt-2 pt-3 border-t border-gray-200 dark:border-gray-700">
        <span class="text-xs text-gray-500 dark:text-gray-400">{{ $note->updated_at->diffForHumans() }}</span>

        {{-- Action buttons (show on hover) --}}
        <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
            <a href="{{ route('notes.show', $note) }}"
                class="p-1.5 hover:bg-blue-100 dark:hover:bg-blue-900/30 rounded transition" title="View">
                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </a>
            <a href="{{ route('notes.edit', $note) }}"
                class="p-1.5 hover:bg-yellow-100 dark:hover:bg-yellow-900/30 rounded transition" title="Edit">
                <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </a>
            <form method="POST" action="{{ route('notes.destroy', $note) }}" onsubmit="return confirm('Move to trash?')" class="inline">
                @csrf @method('DELETE')
                <button class="p-1.5 hover:bg-red-100 dark:hover:bg-red-900/30 rounded transition" title="Delete">
                    <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

</div>