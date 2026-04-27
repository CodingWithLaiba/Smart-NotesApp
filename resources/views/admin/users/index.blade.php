<!-- all users table (block/delete) -->
@extends('layouts.admin')
@section('title', 'Users')
@section('content')
<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 text-left">
            <tr><th class="p-3">Name</th><th>Email</th><th>Notes</th><th>Status</th><th>Joined</th><th></th></tr>
        </thead>
        <tbody class="divide-y">
            @foreach($users as $u)
                <tr>
                    <td class="p-3 font-medium">{{ $u->name }} @if($u->is_admin)<span class="text-xs text-amber-600">(admin)</span>@endif</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->notes_count }}</td>
                    <td>
                        @if($u->is_blocked)<span class="text-red-600">Blocked</span>@else<span class="text-green-600">Active</span>@endif
                    </td>
                    <td>{{ $u->created_at->diffForHumans() }}</td>
                    <td class="p-3 text-right whitespace-nowrap">
                        <a href="{{ route('admin.users.notes', $u) }}" class="text-indigo-600 mr-2">View notes</a>
                        @unless($u->is_admin)
                            <form method="POST" action="{{ route('admin.users.block', $u) }}" class="inline">@csrf
                                <button class="text-amber-600 mr-2">{{ $u->is_blocked ? 'Unblock' : 'Block' }}</button>
                            </form>
                            <form method="POST" action="{{ route('admin.users.destroy', $u) }}" class="inline" onsubmit="return confirm('Delete user?')">@csrf @method('DELETE')
                                <button class="text-red-600">Delete</button>
                            </form>
                        @endunless
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $users->links() }}</div>
@endsection
