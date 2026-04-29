@extends('layouts.app')
@section('title', 'Tag Details')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">#{{ $tag->name }}</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Notes using this tag: {{ $tag->notes->count() }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('tags.edit', $tag) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Edit</a>
            <a href="{{ route('tags.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">Back</a>
        </div>
    </div>

    @if($tag->notes->count())
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($tag->notes as $note)
        <a href="{{ route('notes.show', $note) }}" class="block bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-4 hover:shadow-md transition">
            <h3 class="font-semibold text-gray-900 dark:text-gray-100">{{ $note->title }}</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ \Illuminate\Support\Str::limit(strip_tags($note->content), 120) }}</p>
        </a>
        @endforeach
    </div>
    @else
    <div class="text-center py-12 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl">
        <p class="text-gray-600 dark:text-gray-400">No notes are using this tag yet.</p>
    </div>
    @endif
</div>
@endsection
