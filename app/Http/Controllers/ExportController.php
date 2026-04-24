<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // ← This import fixes the "Undefined type" error

class ExportController extends Controller
{
    /**
     * Export a note as a plain .txt file.
     * Route: GET /notes/{note}/export/txt
     */
    public function exportTxt(Note $note)
    {
        $this->authorizeNote($note);

        // Build the plain text content
        $content  = "Title: {$note->title}\n";
        $content .= "Date:  {$note->created_at->format('Y-m-d H:i')}\n";
        $content .= str_repeat("-", 40) . "\n\n";
        $content .= strip_tags($note->content); // Remove any HTML tags from the rich editor

        // Create a safe filename (replace special characters with underscores)
        $filename = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $note->title) . '.txt';

        // Return the file as a download response
        return response($content, 200, [
            'Content-Type'        => 'text/plain',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Export a note as a PDF file.
     * Route: GET /notes/{note}/export/pdf
     *
     * IMPORTANT: Run this first → composer require barryvdh/laravel-dompdf
     */
    public function exportPdf(Note $note)
    {
        $this->authorizeNote($note);

        // Load the note data into the PDF view (resources/views/notes/pdf.blade.php)
        $pdf = Pdf::loadView('notes.pdf', compact('note'));

        // Create a safe filename
        $filename = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $note->title) . '.pdf';

        // Stream the PDF as a download
        return $pdf->download($filename);
    }

    /**
     * Helper: Make sure the note belongs to the logged-in user.
     */
    private function authorizeNote(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403, 'You are not allowed to export this note.');
        }
    }
}