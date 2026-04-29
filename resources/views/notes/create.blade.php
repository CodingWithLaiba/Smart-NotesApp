@extends('layouts.app')
@section('title', 'Create Note')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold bg-linear-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Create New Note</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-1">Write your thoughts and organize them with categories and tags.</p>
    </div>

    @if($errors->any())
    <div class="mb-6 p-4 rounded-lg border border-red-200 bg-red-50 text-red-700 dark:bg-red-900/20 dark:text-red-300 dark:border-red-800 text-sm">
        @foreach($errors->all() as $error)
        <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <form method="POST" action="{{ route('notes.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm p-6">
            <div class="space-y-5">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title</label>
                    <input id="title" type="text" name="title" value="{{ old('title') }}" required
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter note title">
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content</label>
                    <textarea id="content" name="content" rows="10"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Write your note here...">{{ old('content') }}</textarea>
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
                        <option value="{{ $color }}" {{ old('color', 'white') === $color ? 'selected' : '' }}>{{ ucfirst($color) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Attach Image (Optional)</label>
                    <input id="image" type="file" name="image" accept="image/*"
                        class="w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-600 file:text-white hover:file:bg-blue-700">
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Supported: JPG, PNG, WEBP, GIF (max 5MB).</p>
                </div>

                <div>
                    <p class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Options</p>
                    <div class="space-y-2 text-sm">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="is_pinned" value="1" {{ old('is_pinned') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600">
                            <span>Pin this note</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="is_favorite" value="1" {{ old('is_favorite') ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600">
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
                                {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600">
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
                        <label class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-blue-200 dark:border-blue-700 text-sm cursor-pointer hover:bg-blue-50 dark:hover:bg-blue-900/20">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600">
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
            <button type="submit" class="px-6 py-3 bg-linear-to-r from-blue-600 to-purple-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-purple-700 transition">
                Save Note
            </button>
            <a href="{{ route('notes.index') }}" class="px-6 py-3 rounded-lg border border-gray-300 dark:border-gray-600 hover:bg-gray-100 dark:hover:bg-gray-700 text-center">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
    const textarea = document.getElementById('content');
    const counter = document.getElementById('word-count');
    function updateWordCount() {
        const words = textarea.value.trim().split(/\s+/).filter(w => w.length > 0);
        counter.textContent = words.length;
    }
    textarea.addEventListener('input', updateWordCount);
    updateWordCount();
</script>
@endsection