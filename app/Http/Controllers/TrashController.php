<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TrashController extends Controller
{
    /**
     * Show all soft-deleted (trashed) notes.
     * Route: GET /trash
     */
    public function index()
{
    /** @var User $user */
    $user = Auth::user();

    $notes = $user->notes()
        ->onlyTrashed()
        ->latest('deleted_at')
        ->paginate(10)   // ✅ instead of get()
        ->withQueryString();

    return view('notes.trash', compact('notes'));
}

    /**
     * Restore a trashed note back to normal.
     * Route: POST /trash/{id}/restore
     */
    public function restore($id)
    {
        /** @var User $user */
        $user = Auth::user();

        $note = $user->notes()->onlyTrashed()->findOrFail($id);

        $note->restore(); // Sets deleted_at back to NULL

        return redirect()->route('trash.index')->with('success', 'Note restored!');
    }

    /**
     * Permanently delete a trashed note (cannot be undone).
     * Route: DELETE /trash/{id}
     */
    public function forceDelete($id)
    {
        /** @var User $user */
        $user = Auth::user();

        $note = $user->notes()->onlyTrashed()->findOrFail($id);

        if ($note->image_path) {
            Storage::disk('public')->delete($note->image_path);
        }
        $note->forceDelete(); // Removes completely from the database

        return redirect()->route('trash.index')->with('success', 'Note permanently deleted.');
    }

    /**
     * Empty the entire trash (permanently delete all trashed notes).
     * Route: DELETE /trash/empty
     */
    public function emptyTrash()
    {
        /** @var User $user */
        $user = Auth::user();

        $trashedNotes = $user->notes()->onlyTrashed()->get(['id', 'image_path']);
        foreach ($trashedNotes as $note) {
            if ($note->image_path) {
                Storage::disk('public')->delete($note->image_path);
            }
        }
        $user->notes()->onlyTrashed()->forceDelete();

        return redirect()->route('trash.index')->with('success', 'Trash emptied successfully.');
    }
}