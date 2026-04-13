<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('reading_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('webtoon_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['reading', 'completed', 'want_to_read'])->default('want_to_read');
            $table->timestamps();

            // Prevent duplicate entries
            $table->unique(['user_id', 'webtoon_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reading_lists');
    }
};