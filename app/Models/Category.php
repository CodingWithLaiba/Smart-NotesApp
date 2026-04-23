<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'name',
        'color',
    ];

    // ──────────────────────────────────────────────────────────
    // RELATIONSHIPS
    // ──────────────────────────────────────────────────────────

    /**
     * A category belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A category can have many notes (Many-to-Many).
     */
    public function notes()
    {
        return $this->belongsToMany(Note::class, 'note_category');
    }
}