<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // delete notes when user deleted
            $table->string('title');
            $table->longText('content')->nullable();                          // rich text content
            $table->string('color', 20)->default('white');                    // note background color
            $table->boolean('is_pinned')->default(false);                     // pinned notes show on top
            $table->boolean('is_favorite')->default(false);                   // user can favorite a note
            $table->softDeletes();                                            // deleted_at — goes to trash instead of real delete
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};