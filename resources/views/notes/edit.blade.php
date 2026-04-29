@extends('layouts.app')
@section('title', 'Edit Note')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold bg-linear-to-r from-amber-500 to-orange-600 bg-clip-text text-transparent">Edit Note</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Update your note details and organization.</p>
    </div>

    @if($errors->any())
    <div class="mb-6 p-4 rounded-lg border border-red-200 bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-300 dark:border-red-800 text-sm">
        @foreach($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('notes.update', $note) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-6">
            <div class="space-y-5">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title</label>
                    <input id="title" type="text" name="title" value="{{ old('title', $note->title) }}" required
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content</label>
                    <textarea id="content" name="content" rows="10"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:ring-2 focus:ring-amber-500 focus:border-amber-500">{{ old('content', $note->content) }}</textarea>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Words: <span id="word-count">0</span></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-6 space-y-5">
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Note Color</label>
                    <select id="color" name="color" class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700">
                        @foreach(['white','yellow','blue','green','pink'] as $color)
                        <option value="{{ $color }}" {{ old('color', $note->color) === $color ? 'selected' : '' }}>{{ ucfirst($color) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Replace Image (Optional)</label>
                    <input id="image" type="file" name="image" accept="image/*"
                        class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-amber-500 file:text-white hover:file:bg-amber-600">
                    @if($note->image_path)
                    <div class="mt-3">
                        <img src="{{ asset('storage/' . $note->image_path) }}" alt="Current note image" class="h-28 w-full object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                        <label class="mt-2 inline-flex items-center gap-2 text-sm">
                            <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300 text-amber-600">
                            <span>Remove current image</span>
                        </label>
                    </div>
                    @endif
                </div>

                <div>
                    <p class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Options</p>
                    <div class="space-y-2 text-sm">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="is_pinned" value="1" {{ old('is_pinned', $note->is_pinned) ? 'checked' : '' }} class="rounded border-gray-300 text-amber-600">
                            <span>Pin this note</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="is_favorite" value="1" {{ old('is_favorite', $note->is_favorite) ? 'checked' : '' }} class="rounded border-gray-300 text-amber-600">
                            <span>Mark as favorite</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-6 space-y-5">
                <div>
                    <p class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Categories</p>
                    <div class="flex flex-wrap gap-2">
                        @forelse($categories as $category)
                        <label class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-gray-300 dark:border-gray-600 text-sm cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                {{ in_array($category->id, old('categories', $note->categories->pluck('id')->toArray())) ? 'checked' : '' }} class="rounded border-gray-300 text-amber-600">
                            <span>{{ $category->name }}</span>
                        </label>
                        @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">No categories yet.</p>
                        @endforelse
                    </div>
                </div>

                <div>
                    <p class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tags</p>
                    <div class="flex flex-wrap gap-2">
                        @forelse($tags as $tag)
                        <label class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-amber-200 dark:border-amber-700 text-sm cursor-pointer hover:bg-amber-50 dark:hover:bg-amber-900/20">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                {{ in_array($tag->id, old('tags', $note->tags->pluck('id')->toArray())) ? 'checked' : '' }} class="rounded border-gray-300 text-amber-600">
                            <span>#{{ $tag->name }}</span>
                        </label>
                        @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400">No tags yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <button type="submit" class="px-6 py-3 bg-linear-to-r from-amber-500 to-orange-600 text-white font-medium rounded-lg hover:from-amber-600 hover:to-orange-700 transition">
                Update Note
            </button>
            <a href="{{ route('notes.show', $note) }}" class="px-6 py-3 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 text-center">
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
    updateCount();
</script>
@endsection