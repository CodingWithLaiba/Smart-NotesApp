<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    // -------------------------------------------------------
    // Show all tags for the logged-in user
    // Route: GET /tags
    // -------------------------------------------------------
    public function index()
    {
        $tags = Tag::where('user_id', Auth::id())
                   ->withCount('notes') // shows how many notes use this tag
                   ->get();

        return view('tags.index', compact('tags'));
    }

    // -------------------------------------------------------
    // Save a new tag (created inline — no separate create page needed)
    // Route: POST /tags
    // -------------------------------------------------------
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);

        // Avoid duplicate tags for the same user
        $exists = Tag::where('user_id', Auth::id())
                     ->where('name', $request->name)
                     ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'You already have a tag with this name.']);
        }

        Tag::create([
            'user_id' => Auth::id(),
            'name'    => $request->name,
        ]);

        return back()->with('success', 'Tag created! 🏷️');
    }

    // -------------------------------------------------------
    // Delete a tag
    // Route: DELETE /tags/{id}
    // -------------------------------------------------------
    public function destroy($id)
    {
        $tag = Tag::where('user_id', Auth::id())->findOrFail($id);

        // This also removes the tag from all notes via pivot table
        $tag->notes()->detach();
        $tag->delete();

        return back()->with('success', 'Tag deleted.');
    }
}