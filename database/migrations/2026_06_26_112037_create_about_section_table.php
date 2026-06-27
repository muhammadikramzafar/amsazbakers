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
        Schema::create('about_section', function (Blueprint $table) {
            $table->id();
            $table->string('heading')->default('Our Story');
            $table->string('subheading')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('btn_text')->nullable();
            $table->string('btn_url')->nullable();
            $table->string('stat1_number')->nullable();
            $table->string('stat1_label')->nullable();
            $table->string('stat2_number')->nullable();
            $table->string('stat2_label')->nullable();
            $table->string('stat3_number')->nullable();
            $table->string('stat3_label')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_section');
    }
};
