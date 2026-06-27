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
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('subcategory_id')->nullable()->after('category_id');
            $table->foreign('subcategory_id')->references('id')->on('categories')->nullOnDelete();

            $table->string('sku')->nullable()->unique()->after('slug');
            $table->text('short_description')->nullable()->after('description');
            $table->longText('full_description')->nullable()->after('short_description');
            $table->text('ingredients')->nullable()->after('full_description');
            $table->text('nutritional_info')->nullable()->after('ingredients');
            $table->string('allergens')->nullable()->after('nutritional_info');
            $table->json('gallery')->nullable()->after('image');
            $table->boolean('is_bestseller')->default(false)->after('is_featured');
            $table->boolean('is_seasonal')->default(false)->after('is_bestseller');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['subcategory_id']);
            $table->dropColumn([
                'subcategory_id', 'sku', 'short_description', 'full_description',
                'ingredients', 'nutritional_info', 'allergens', 'gallery',
                'is_bestseller', 'is_seasonal',
            ]);
        });
    }
};
