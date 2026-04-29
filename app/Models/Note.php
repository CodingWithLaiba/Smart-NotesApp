<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Note extends Model
{
    use HasFactory, SoftDeletes;  // SoftDeletes enables trash/restore feature

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'title',
        'content',
        'color',
        'image_path',
        'is_pinned',
        'is_favorite',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'is_pinned' => 'boolean',
            'is_favorite' => 'boolean',
            'deleted_at' => 'datetime',  // for soft deletes
        ];
    }

    // ──────────────────────────────────────────────────────────
    // RELATIONSHIPS
    // ──────────────────────────────────────────────────────────

    /**
     * A note belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A note can have many categories (Many-to-Many).
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'note_category');
    }

    /**
     * A note can have many tags (Many-to-Many).
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'note_tag');
    }

    // ──────────────────────────────────────────────────────────
    // SCOPES (for filtering notes)
    // ──────────────────────────────────────────────────────────

    /**
     * Scope to get only pinned notes.
     */
    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    /**
     * Scope to get only favorite notes.
     */
    public function scopeFavorite($query)
    {
        return $query->where('is_favorite', true);
    }

    /**
     * Scope to search notes by title or content.
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
              ->orWhere('content', 'like', "%{$term}%");
        });
    }
}