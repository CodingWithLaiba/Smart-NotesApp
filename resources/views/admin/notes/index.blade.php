<!-- all notes (view/delete) -->
 @extends('layouts.admin')
@section('title', $user ? "Notes by {$user->name}" : 'All Notes')
@section('content')
@unless($user)
    <form method="GET" class="mb-4 flex gap-2">
        <input name="search" value="{{ request('search') }}" placeholder="Search notes..." class="input max-w-sm">
        <button class="btn-secondary">Search</button>
    </form>
@endunless

<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr><th class="p-3">Title</th>@unless($user)<th>Author</th>@endunless<th>Created</th><th></th></tr>
        </thead>
        <tbody class="divide-y">
            @foreach($notes as $note)
                <tr>
                    <td class="p-3 font-medium">{{ $note->title }}</td>
                    @unless($user)<td>{{ $note->user->name ?? '—' }}</td>@endunless
                    <td>{{ $note->created_at->diffForHumans() }}</td>
                    <td class="p-3 text-right">
                        <form method="POST" action="{{ route('admin.notes.destroy', $note) }}" onsubmit="return confirm('Delete this note?')">@csrf @method('DELETE')
                            <button class="text-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $notes->links() }}</div>
@endsection
