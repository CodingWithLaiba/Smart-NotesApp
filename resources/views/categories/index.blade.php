<!-- List all category -->
 @extends('layouts.app')
@section('title', 'Categories')
@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-2xl font-bold">Categories</h1>
    <a href="{{ route('categories.create') }}" class="btn-primary">+ New Category</a>
</div>

<div class="space-y-2">
    @forelse($categories as $cat)
        <div class="card p-3 flex items-center justify-between">
            <form method="POST" action="{{ route('categories.update', $cat) }}" class="flex gap-2 items-center flex-1">@csrf @method('PUT')
                <input name="name" value="{{ $cat->name }}" class="input max-w-xs">
                <span class="text-xs text-gray-500">{{ $cat->notes_count }} notes</span>
                <button class="btn-secondary text-sm">Save</button>
            </form>
            <form method="POST" action="{{ route('categories.destroy', $cat) }}" onsubmit="return confirm('Delete category?')">@csrf @method('DELETE')
                <button class="btn-danger text-sm ml-2">Delete</button>
            </form>
        </div>
    @empty
        <p class="text-gray-500">No categories yet.</p>
    @endforelse
</div>
@endsection
