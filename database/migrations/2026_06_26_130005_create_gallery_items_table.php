<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gallery_album_id');
            $table->enum('type', ['image', 'video'])->default('image');
            $table->string('file_path')->nullable();
            $table->string('video_url')->nullable();
            $table->string('caption')->nullable();
            $table->string('thumb')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('gallery_album_id')->references('id')->on('gallery_albums')->cascadeOnDelete();
            $table->index(['gallery_album_id', 'is_active', 'sort_order']);
        });
    }

    public function down(): void { Schema::dropIfExists('gallery_items'); }
};
