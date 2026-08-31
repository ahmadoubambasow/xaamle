<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            // Auteurde la publication
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Informations principales
            $table->string('title');
            $table->string('slug')->unique();

            // Résumé facultatif
            $table->text('excerpt')->nullable();

            // Contenu de la publication
            $table->longText('content');

            // Image de couverture facultative
            $table->string('cover_image')->nullable();

            // Etat de la publication
            $table->enum('status', [
                'draft', 'published',
            ])->default('draft');

            // Date de publication
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
