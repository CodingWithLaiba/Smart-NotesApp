<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    // -------------------------------------------------------
    // Show all notes for the logged-in user
    // Route: GET /notes
    // Features: search, filter by category/tag/pinned/favorite, sort
    // -------------------------------------------------------
    public function index(Request $request)
    {
        // Start a query for notes belonging to the current user
        // withTrashed() is NOT here — trash is handled by TrashController
        $query = Note::where('user_id', Auth::id());

        // --- SEARCH by title or content ---
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // --- FILTER by pinned ---
        if ($request->filled('pinned')) {
            $query->where('is_pinned', true);
        }

        // --- FILTER by favorites ---
        if ($request->filled('favorite')) {
            $query->where('is_favorite', true);
        }

        // --- FILTER by category ---
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        // --- FILTER by tag ---
        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->tag);
            });
        }

        // --- SORT options ---
        $sort = $request->get('sort', 'newest'); // default sort: newest first
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort === 'alphabetical') {
            $query->orderBy('title', 'asc');
        } else {
            // newest (default)
            $query->orderBy('created_at', 'desc');
        }

        // Pinned notes always come first, regardless of sort
        $query->orderBy('is_pinned', 'desc');

        // Get the results
        $notes = $query->get();

        // Get all categories and tags for the filter sidebar
        $categories = Category::where('user_id', Auth::id())->get();
        $tags        = Tag::where('user_id', Auth::id())->get();

        return view('notes.index', compact('notes', 'categories', 'tags'));
    }

    // -------------------------------------------------------
    // Show the "create note" form
    // Route: GET /notes/create
    // -------------------------------------------------------
    public function create()
    {
        // Pass categories and tags so user can assign them while creating
        $categories = Category::where('user_id', Auth::id())->get();
        $tags        = Tag::where('user_id', Auth::id())->get();

        return view('notes.create', compact('categories', 'tags'));
    }

    // -------------------------------------------------------
    // Save the new note to the database
    // Route: POST /notes
    // -------------------------------------------------------
    public function store(Request $request)
    {
        // Validate inputs
        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'nullable|string',
            'color'   => 'nullable|string|max:20',  // e.g. "#ffeb3b" or "yellow"
        ]);

        // Create the note
        $note = Note::create([
            'user_id'     => Auth::id(),
            'title'       => $request->title,
            'content'     => $request->content,
            'color'       => $request->color ?? '#ffffff', // default white
            'is_pinned'   => false,
            'is_favorite' => false,
        ]);

        // Attach categories if any were selected (many-to-many)
        if ($request->filled('categories')) {
            $note->categories()->sync($request->categories);
        }

        // Attach tags if any were selected (many-to-many)
        if ($request->filled('tags')) {
            $note->tags()->sync($request->tags);
        }

        return redirect()->route('notes.index')->with('success', 'Note created successfully! ✏️');
    }

    // -------------------------------------------------------
    // Show a single note
    // Route: GET /notes/{id}
    // -------------------------------------------------------
    public function show($id)
    {
        // Find the note — make sure it belongs to the logged-in user
        $note = Note::where('user_id', Auth::id())->findOrFail($id);

        return view('notes.show', compact('note'));
    }

    // -------------------------------------------------------
    // Show the "edit note" form
    // Route: GET /notes/{id}/edit
    // -------------------------------------------------------
    public function edit($id)
    {
        $note       = Note::where('user_id', Auth::id())->findOrFail($id);
        $categories = Category::where('user_id', Auth::id())->get();
        $tags        = Tag::where('user_id', Auth::id())->get();

        return view('notes.edit', compact('note', 'categories', 'tags'));
    }

    // -------------------------------------------------------
    // Update an existing note
    // Route: PUT /notes/{id}
    // -------------------------------------------------------
    public function update(Request $request, $id)
    {
        $note = Note::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'title'   => 'required|string|max:255',
            'content' => 'nullable|string',
            'color'   => 'nullable|string|max:20',
        ]);

        // Update the note fields
        $note->update([
            'title'   => $request->title,
            'content' => $request->content,
            'color'   => $request->color ?? $note->color,
        ]);

        // Sync categories — sync() will add new and remove old ones
        $note->categories()->sync($request->categories ?? []);

        // Sync tags
        $note->tags()->sync($request->tags ?? []);

        return redirect()->route('notes.index')->with('success', 'Note updated successfully! ✅');
    }

    // -------------------------------------------------------
    // Soft delete a note (sends to Trash, NOT permanently deleted)
    // Route: DELETE /notes/{id}
    // -------------------------------------------------------
    public function destroy($id)
    {
        $note = Note::where('user_id', Auth::id())->findOrFail($id);

        $note->delete(); // This is a soft delete because the Note model uses SoftDeletes trait

        return redirect()->route('notes.index')->with('success', 'Note moved to Trash 🗑️');
    }

    // -------------------------------------------------------
    // Toggle pin status on/off
    // Route: POST /notes/{id}/pin
    // -------------------------------------------------------
    public function togglePin($id)
    {
        $note = Note::where('user_id', Auth::id())->findOrFail($id);

        // Flip the boolean value
        $note->update(['is_pinned' => !$note->is_pinned]);

        $message = $note->is_pinned ? 'Note pinned 📌' : 'Note unpinned';
        return back()->with('success', $message);
    }

    // -------------------------------------------------------
    // Toggle favorite status on/off
    // Route: POST /notes/{id}/favorite
    // -------------------------------------------------------
    public function toggleFavorite($id)
    {
        $note = Note::where('user_id', Auth::id())->findOrFail($id);

        $note->update(['is_favorite' => !$note->is_favorite]);

        $message = $note->is_favorite ? 'Added to favorites ⭐' : 'Removed from favorites';
        return back()->with('success', $message);
    }
}