<?php
// ══════════════════════════════════════════════════════════════
//  AdminNoteController.php
//  app/Http/Controllers/Admin/AdminNoteController.php
// ══════════════════════════════════════════════════════════════
namespace App\Http\Controllers\Admin;
 
use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
 
class AdminNoteController extends Controller
{
    /**
     * List ALL notes across the entire system.
     * Route: GET /admin/notes
     */
    public function index(Request $request)
    {
        $query = Note::with('user'); // Load the user who owns each note
 
        // Allow admin to search notes by title
        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }
 
        // Filter by user if admin clicks on a specific user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
 
        $notes = $query->latest()->paginate(20);
 
        return view('admin.notes.index', compact('notes'));
    }
 
    /**
     * View a single note (read only for admin).
     * Route: GET /admin/notes/{note}
     */
    public function show(Note $note)
    {
        $note->load(['user', 'categories', 'tags']);
 
        return view('notes.show', compact('note')); // Reuse the existing show view
    }
 
    /**
     * Permanently delete any note (admin moderation).
     * Route: DELETE /admin/notes/{note}
     */
    public function destroy(Note $note)
    {
        // forceDelete removes it completely, even if soft-deleted
        $note->forceDelete();
 
        return redirect()->route('admin.notes.index')->with('success', 'Note deleted by admin.');
    }
}
 