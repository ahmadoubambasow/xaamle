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
        Schema::create('author_follows', function (Blueprint $table) {
            $table->id();

            // L'utilisateur qui suit
            $table->foreignId('follower_id')->constrained()->cascadeOnDelete();

            // L'auteur suivi
            $table->foreignId('author_id')->constrained()->cascadeOnDelete();

            $table->timestamps();

            // Un utilisateur ne peut suivre qu'un seule fois le meme auteur
            $table->unique([
                'follower_id',
                'author_id',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('author_follows');
    }
};
