<!-- all notes (view/delete) -->
 @extends('layouts.admin')
@section('title', $user ? "Notes by {$user->name}" : 'All Notes')
@section('content')
<div class="card p-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-lg font-semibold text-gray-900 dark:text-white">
                {{ $user ? "Notes by {$user->name}" : 'All Notes' }}
            </h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $user ? 'Review notes created by this user' : 'Review, search, and moderate notes across the system' }}
            </p>
        </div>

        <div class="flex items-center gap-2 w-full md:w-auto">
            @if($user)
                <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i>
                    Back to users
                </a>
            @else
                <form method="GET" class="flex gap-2 w-full md:w-auto">
                    <div class="relative flex-1 md:w-80">
                        <div class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                            <i data-lucide="search" class="w-4 h-4 text-gray-400"></i>
                        </div>
                        <input name="search" value="{{ request('search') }}" placeholder="Search by title..." class="input pl-10">
                    </div>
                    <button class="btn-secondary">Search</button>
                </form>
            @endif
        </div>
    </div>

    <div class="mt-6 overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="text-left text-gray-500 dark:text-gray-400">
                <tr class="border-b border-gray-200 dark:border-gray-800">
                    <th class="py-3 pr-4">Title</th>
                    @unless($user)<th class="py-3 pr-4">Author</th>@endunless
                    <th class="py-3 pr-4">Created</th>
                    <th class="py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach($notes as $note)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                        <td class="py-4 pr-4">
                            <div class="min-w-[260px]">
                                <p class="font-medium text-gray-900 dark:text-white truncate">{{ $note->title }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                                    ID: {{ $note->id }}
                                </p>
                            </div>
                        </td>
                        @unless($user)
                            <td class="py-4 pr-4">
                                <span class="text-gray-900 dark:text-white">{{ $note->user->name ?? '—' }}</span>
                                <span class="text-xs text-gray-500 dark:text-gray-400">({{ $note->user->email ?? '—' }})</span>
                            </td>
                        @endunless
                        <td class="py-4 pr-4 text-gray-500 dark:text-gray-400 whitespace-nowrap">
                            {{ $note->created_at->diffForHumans() }}
                        </td>
                        <td class="py-4 text-right whitespace-nowrap">
                            <a href="{{ route('admin.notes.show', $note) }}"
                                class="inline-flex items-center gap-1.5 text-xs px-2 py-1 rounded-lg bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                                View
                            </a>
                            <form method="POST" action="{{ route('admin.notes.destroy', $note) }}" class="inline" onsubmit="return confirm('Delete this note?')">
                                @csrf @method('DELETE')
                                <button class="inline-flex items-center gap-1.5 text-xs px-2 py-1 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 hover:bg-red-100 dark:hover:bg-red-900/30 ml-1.5">
                                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">{{ $notes->links() }}</div>
@endsection
