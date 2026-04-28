<!-- new note form with rich editor -->
@extends('layouts.app')
@section('title', 'New Note')

@section('content')
<div class="max-w-3xl mx-auto">

    <h1 class="text-2xl font-bold mb-6">Create New Note</h1>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('notes.store') }}" class="flex flex-col gap-4">
        @csrf

        {{-- Title --}}
        <div>
            <label class="block text-sm mb-1">Title</label>
            <input type="text" name="title" value="{{ old('title') }}" required
                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600" />
        </div>

        {{-- Content (rich text editor will attach here) --}}
        <div>
            <label class="block text-sm mb-1">Content</label>
            <textarea id="content" name="content" rows="10"
                class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600">{{ old('content') }}</textarea>
            <p class="text-xs text-gray-400 mt-1">Words: <span id="word-count">0</span></p>
        </div>

        {{-- Color picker --}}
        <div>
            <label class="block text-sm mb-1">Note Color</label>
            <select name="color" class="border rounded px-3 py-2 dark:bg-gray-700 dark:border-gray-600">
                <option value="white">White</option>
                <option value="yellow">Yellow</option>
                <option value="blue">Blue</option>
                <option value="green">Green</option>
                <option value="pink">Pink</option>
            </select>
        </div>

        {{-- Categories --}}
        <div>
            <label class="block text-sm mb-1">Categories</label>
            <div class="flex flex-wrap gap-2">
                @foreach($categories as $category)
                    <label class="flex items-center gap-1 text-sm">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                            {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }} />
                        {{ $category->name }}
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Tags --}}
        <div>
            <label class="block text-sm mb-1">Tags</label>
            <div class="flex flex-wrap gap-2">
                @foreach($tags as $tag)
                    <label class="flex items-center gap-1 text-sm">
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                            {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }} />
                        #{{ $tag->name }}
                    </label>
                @endforeach
            </div>
        </div>

        {{-- Options --}}
        <div class="flex gap-4 text-sm">
            <label class="flex items-center gap-1">
                <input type="checkbox" name="is_pinned" value="1" {{ old('is_pinned') ? 'checked' : '' }} />
                Pin this note
            </label>
            <label class="flex items-center gap-1">
                <input type="checkbox" name="is_favorite" value="1" {{ old('is_favorite') ? 'checked' : '' }} />
                Mark as favorite
            </label>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Save Note
            </button>
            <a href="{{ route('notes.index') }}" class="px-6 py-2 rounded border hover:bg-gray-100 dark:hover:bg-gray-700">
                Cancel
            </a>
        </div>

    </form>
</div>

{{-- Simple word count script --}}
<script>
    const textarea = document.getElementById('content');
    const counter = document.getElementById('word-count');
    textarea.addEventListener('input', function() {
        const words = this.value.trim().split(/\s+/).filter(w => w.length > 0);
        counter.textContent = words.length;
    });
</script>

@endsection