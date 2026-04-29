<!-- single note view -->
@extends('layouts.app')
@section('title', $note->title)

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- Header --}}
    <div class="flex justify-between items-start mb-4">
        <div>
            <h1 class="text-2xl font-bold">{{ $note->title }}</h1>
            <p class="text-sm text-gray-400 mt-1">Last updated {{ $note->updated_at->diffForHumans() }}</p>
        </div>

        <div class="flex gap-2 text-sm flex-wrap">
            {{-- Pin toggle --}}
            <form method="POST" action="{{ route('notes.pin', $note) }}">
                @csrf @method('PATCH')
                <button class="px-3 py-1 rounded border hover:bg-gray-100 dark:hover:bg-gray-700">
                    {{ $note->is_pinned ? '📌 Unpin' : '📌 Pin' }}
                </button>
            </form>

            {{-- Favorite toggle --}}
            <form method="POST" action="{{ route('notes.favorite', $note) }}">
                @csrf @method('PATCH')
                <button class="px-3 py-1 rounded border hover:bg-gray-100 dark:hover:bg-gray-700">
                    {{ $note->is_favorite ? '⭐ Unfavorite' : '⭐ Favorite' }}
                </button>
            </form>

            <a href="{{ route('notes.edit', $note) }}"
                class="px-3 py-1 rounded border hover:bg-yellow-50 dark:hover:bg-gray-700">
                Edit
            </a>

            {{-- Export --}}
            <a href="{{ route('export.pdf', $note) }}"
                class="px-3 py-1 rounded border hover:bg-blue-50 dark:hover:bg-gray-700">
                Export PDF
            </a>

            <form method="POST" action="{{ route('notes.destroy', $note) }}"
                onsubmit="return confirm('Move to trash?')">
                @csrf @method('DELETE')
                <button class="px-3 py-1 rounded border text-red-500 hover:bg-red-50">Delete</button>
            </form>
        </div>
    </div>

    @if($note->image_path)
    <div class="mb-4">
        <img src="{{ asset('storage/' . $note->image_path) }}" alt="Note image" class="w-full max-h-96 object-contain rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800">
    </div>
    @endif

    {{-- Note content --}}
    <div class="bg-white dark:bg-gray-800 rounded shadow p-6 prose dark:prose-invert max-w-none">
        {!! $note->content !!}
    </div>

    {{-- Categories + Tags --}}
    <div class="mt-4 flex flex-wrap gap-2 text-sm">
        @foreach($note->categories as $cat)
            <span class="bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 px-2 py-0.5 rounded">
                {{ $cat->name }}
            </span>
        @endforeach
        @foreach($note->tags as $tag)
            <span class="bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 px-2 py-0.5 rounded">
                #{{ $tag->name }}
            </span>
        @endforeach
    </div>

    <div class="mt-4">
        <a href="{{ route('notes.index') }}" class="text-sm text-blue-500 hover:underline">← Back to notes</a>
    </div>

</div>
@endsection