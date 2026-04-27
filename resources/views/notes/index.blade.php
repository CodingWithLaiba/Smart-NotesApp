<!-- all notes grid/list view -->
 @extends('layouts.app')
@section('title', 'My Notes')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold">My Notes</h1>
    <a href="{{ route('notes.create') }}"
        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
        + New Note
    </a>
</div>

{{-- Filter buttons --}}
<div class="flex gap-2 mb-4 text-sm flex-wrap">
    <a href="{{ route('notes.index') }}"
        class="px-3 py-1 rounded {{ !request('filter') ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700' }}">
        All
    </a>
    <a href="{{ route('notes.index', ['filter' => 'pinned']) }}"
        class="px-3 py-1 rounded {{ request('filter') === 'pinned' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700' }}">
        📌 Pinned
    </a>
    <a href="{{ route('notes.index', ['filter' => 'favorites']) }}"
        class="px-3 py-1 rounded {{ request('filter') === 'favorites' ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-gray-700' }}">
        ⭐ Favorites
    </a>
</div>

{{-- Notes grid --}}
@if($notes->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($notes as $note)
            @include('partials.note-card', ['note' => $note])
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $notes->withQueryString()->links() }}
    </div>
@else
    <p class="text-gray-400 mt-10 text-center">No notes found. Create your first note!</p>
@endif

@endsection