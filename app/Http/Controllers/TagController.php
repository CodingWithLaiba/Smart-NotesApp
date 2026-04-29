<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $tags = $request->user()
            ->tags()
            ->withCount('notes')
            ->orderBy('name')
            ->get();

        return view('tags.index', compact('tags'));
    }

    public function create()
    {
        return view('tags.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:80',
        ]);

        $exists = $request->user()
            ->tags()
            ->where('name', $validated['name'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'You already have a tag with this name.'])->withInput();
        }

        $request->user()->tags()->create([
            'name' => $validated['name'],
        ]);

        return redirect()->route('tags.index')->with('success', 'Tag created successfully.');
    }

    public function show(Request $request, Tag $tag)
    {
        $this->authorizeTag($request, $tag);

        $tag->load(['notes' => function ($query) use ($request) {
            $query->where('user_id', $request->user()->id)->latest();
        }]);

        return view('tags.show', compact('tag'));
    }

    public function edit(Request $request, Tag $tag)
    {
        $this->authorizeTag($request, $tag);

        return view('tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $this->authorizeTag($request, $tag);

        $validated = $request->validate([
            'name' => 'required|string|max:80',
        ]);

        $exists = $request->user()
            ->tags()
            ->where('name', $validated['name'])
            ->where('id', '!=', $tag->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'You already have a tag with this name.'])->withInput();
        }

        $tag->update([
            'name' => $validated['name'],
        ]);

        return redirect()->route('tags.index')->with('success', 'Tag updated successfully.');
    }

    public function destroy(Request $request, Tag $tag)
    {
        $this->authorizeTag($request, $tag);

        $tag->notes()->detach();
        $tag->delete();

        return back()->with('success', 'Tag deleted successfully.');
    }

    private function authorizeTag(Request $request, Tag $tag): void
    {
        abort_unless($tag->user_id === $request->user()->id, 403);
    }
}