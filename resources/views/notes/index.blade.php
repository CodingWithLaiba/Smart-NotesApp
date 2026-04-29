@extends('layouts.app')
@section('title', 'My Notes')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold bg-linear-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">My Notes</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Create, pin, and organize all your notes.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('notes.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-linear-to-r from-blue-600 to-purple-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Note
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $notes->total() }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-400">Total Notes</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $notes->where('is_pinned', true)->count() }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-400">Pinned Notes</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $notes->where('is_favorite', true)->count() }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-400">Favorite Notes</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-4 shadow-sm">
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ request('filter') ? ucfirst(request('filter')) : 'All' }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-400">Current Filter</p>
        </div>
    </div>

    <div class="flex gap-2 mb-6 text-sm flex-wrap">
        <a href="{{ route('notes.index') }}"
            class="px-3 py-1.5 rounded-lg border {{ !request('filter') ? 'bg-blue-600 text-white border-blue-600' : 'bg-gray-100 border-gray-200 dark:bg-gray-800 dark:border-gray-700' }}">
            All
        </a>
        <a href="{{ route('notes.index', ['filter' => 'pinned']) }}"
            class="px-3 py-1.5 rounded-lg border {{ request('filter') === 'pinned' ? 'bg-blue-600 text-white border-blue-600' : 'bg-gray-100 border-gray-200 dark:bg-gray-800 dark:border-gray-700' }}">
            📌 Pinned
        </a>
        <a href="{{ route('notes.index', ['filter' => 'favorites']) }}"
            class="px-3 py-1.5 rounded-lg border {{ request('filter') === 'favorites' ? 'bg-blue-600 text-white border-blue-600' : 'bg-gray-100 border-gray-200 dark:bg-gray-800 dark:border-gray-700' }}">
            ⭐ Favorites
        </a>
    </div>

    @if($notes->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($notes as $note)
        @include('partials.note-card', ['note' => $note])
        @endforeach
    </div>
    <div class="mt-6">
        {{ $notes->withQueryString()->links() }}
    </div>
    @else
    <div class="text-center py-16">
        <div class="w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </div>
        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">No notes yet</h3>
        <p class="text-gray-600 dark:text-gray-400 mb-6">Start by creating your first note.</p>
        <a href="{{ route('notes.create') }}"
            class="inline-flex items-center gap-2 px-5 py-3 bg-linear-to-r from-blue-600 to-purple-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-purple-700 transition-all duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Create Note
        </a>
    </div>
    @endif
</div>
@endsection