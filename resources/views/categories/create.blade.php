<!-- Create New Category -->
@extends('layouts.app')
@section('title', 'New Category')

@section('content')
<div class="max-w-2xl mx-auto">
    {{-- Header --}}
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-4">
            <a href="{{ route('categories.index') }}" 
               class="p-2 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                    New Category
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">
                    Create a new category to organize your notes
                </p>
            </div>
        </div>
    </div>

    {{-- Main Form Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
        <div class="p-6 lg:p-8">
            <form method="POST" action="{{ route('categories.store') }}" class="space-y-6" x-data="{ submitting: false }" @submit="submitting = true">
                @csrf
                
                {{-- Category Name Field --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Category Name
                    </label>
                    <div class="relative">
                        <input type="text" 
                               id="name" 
                               name="name" 
                               required 
                               autofocus
                               class="w-full px-4 py-3 text-lg border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors"
                               placeholder="e.g., Work, Personal, Projects">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                            </svg>
                        </div>
                    </div>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Choose a descriptive name for your category
                    </p>
                </div>

                {{-- Color Selection --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                        Category Color (Optional)
                    </label>
                    <div class="grid grid-cols-6 sm:grid-cols-8 gap-2">
                        <button type="button" 
                                onclick="selectColor('white')"
                                class="color-option w-10 h-10 rounded-lg border-2 border-gray-300 dark:border-gray-600 bg-white hover:border-blue-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-all">
                        </button>
                        <button type="button" 
                                onclick="selectColor('yellow')"
                                class="color-option w-10 h-10 rounded-lg border-2 border-gray-300 dark:border-gray-600 bg-yellow-100 hover:border-blue-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-all">
                        </button>
                        <button type="button" 
                                onclick="selectColor('blue')"
                                class="color-option w-10 h-10 rounded-lg border-2 border-gray-300 dark:border-gray-600 bg-blue-100 hover:border-blue-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-all">
                        </button>
                        <button type="button" 
                                onclick="selectColor('green')"
                                class="color-option w-10 h-10 rounded-lg border-2 border-gray-300 dark:border-gray-600 bg-green-100 hover:border-blue-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-all">
                        </button>
                        <button type="button" 
                                onclick="selectColor('pink')"
                                class="color-option w-10 h-10 rounded-lg border-2 border-gray-300 dark:border-gray-600 bg-pink-100 hover:border-blue-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-all">
                        </button>
                        <button type="button" 
                                onclick="selectColor('purple')"
                                class="color-option w-10 h-10 rounded-lg border-2 border-gray-300 dark:border-gray-600 bg-purple-100 hover:border-blue-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-all">
                        </button>
                        <button type="button" 
                                onclick="selectColor('red')"
                                class="color-option w-10 h-10 rounded-lg border-2 border-gray-300 dark:border-gray-600 bg-red-100 hover:border-blue-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-all">
                        </button>
                        <button type="button" 
                                onclick="selectColor('indigo')"
                                class="color-option w-10 h-10 rounded-lg border-2 border-gray-300 dark:border-gray-600 bg-indigo-100 hover:border-blue-500 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 transition-all">
                        </button>
                    </div>
                    <input type="hidden" name="color" id="selectedColor" value="white">
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Choose a color to visually distinguish your categories
                    </p>
                </div>

                {{-- Description Field --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Description (Optional)
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 dark:placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-400 dark:focus:border-blue-400 transition-colors resize-none"
                              placeholder="Add a brief description to help you remember the purpose of this category..."></textarea>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Describe what types of notes you'll store in this category
                    </p>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="submit" 
                            :disabled="submitting"
                            class="flex-1 flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg x-show="!submitting" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <svg x-show="submitting" class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span x-text="submitting ? 'Creating...' : 'Create Category'"></span>
                    </button>
                    
                    <a href="{{ route('categories.index') }}" 
                       class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Tips Section --}}
    <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800 p-6">
        <div class="flex gap-3">
            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Tips for Great Categories</h3>
                <ul class="space-y-1 text-sm text-blue-800 dark:text-blue-200">
                    <li>• Use clear, descriptive names that make sense at a glance</li>
                    <li>• Keep categories broad enough to hold multiple related notes</li>
                    <li>• Use colors to create visual organization and quick recognition</li>
                    <li>• Consider your workflow and how you'll search for notes later</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
function selectColor(color) {
    document.getElementById('selectedColor').value = color;
    
    // Update visual selection
    document.querySelectorAll('.color-option').forEach(btn => {
        btn.classList.remove('ring-2', 'ring-blue-500', 'ring-offset-2');
    });
    
    event.target.classList.add('ring-2', 'ring-blue-500', 'ring-offset-2');
}

// Initialize Alpine.js for this component
document.addEventListener('alpine:init', () => {
    Alpine.data('categoryForm', () => ({
        submitting: false,
        submit() {
            this.submitting = true;
        }
    }));
});
</script>

@endsection
