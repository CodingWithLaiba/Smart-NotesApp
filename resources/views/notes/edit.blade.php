<!-- edit existing note -->
 @extends('layouts.app')
@section('title', 'Edit Note')

@section('content')
<div class="max-w-3xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">Edit Note</h1>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('notes.update', $note) }}" class="flex flex-col gap-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title', $note->title) }}" required
                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600" />
        </div>

        <div>
            <label class="block text-sm mb-1">Content</label>
            <textarea id="content" name="content" rows="10"
                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600">{{ old('content', $note->content) }}</textarea>
            <p class="text-xs text-gray-400 mt-1">Words: <span id="word-count">0</span></p>
        </div>

        <div>
            <label class="block text-sm mb-1">Note Color</label>
            <select name="color" class="border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600">
                @foreach(['white','yellow','blue','green','pink'] as $color)
                    <option value="{{ $color }}" {{ $note->color === $color ? 'selected' : '' }}>
                        {{ ucfirst($color) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm mb-1">Categories</label>
            <div class="flex flex-wrap gap-2">
                @foreach($categories as $category)
                    <label class="flex items-center gap-1 text-sm">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                            {{ $note->categories->contains($category->id) ? 'checked' : '' }} />
                        {{ $category->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <div>
            <label class="block text-sm mb-1">Tags</label>
            <div class="flex flex-wrap gap-2">
                @foreach($tags as $tag)
                    <label class="flex items-center gap-1 text-sm">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                            {{ $note->tags->contains($tag->id) ? 'checked' : '' }} />
                        #{{ $tag->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex gap-4 text-sm">
            <label class="flex items-center gap-1">
                <input type="checkbox" name="is_pinned" value="1" {{ $note->is_pinned ? 'checked' : '' }} />
                Pin this note
            </label>
            <label class="flex items-center gap-1">
                <input type="checkbox" name="is_favorite" value="1" {{ $note->is_favorite ? 'checked' : '' }} />
                Mark as favorite
            </label>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600">
                Update Note
            </button>
            <a href="{{ route('notes.show', $note) }}" class="px-6 py-2 rounded border hover:bg-gray-100 dark:hover:bg-gray-700">
                Cancel
            </a>
        </div>

    </form>
</div>

<script>
    const textarea = document.getElementById('content');
    const counter = document.getElementById('word-count');
    function updateCount() {
        const words = textarea.value.trim().split(/\s+/).filter(w => w.length > 0);
        counter.textContent = words.length;
    }
    textarea.addEventListener('input', updateCount);
    updateCount(); // run on page load too
</script>

@endsection