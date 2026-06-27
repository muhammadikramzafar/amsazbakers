<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Recipe extends Model
{
    protected $fillable = [
        'recipe_category_id', 'title', 'slug',
        'featured_image', 'gallery',
        'short_description', 'description',
        'prep_time', 'cook_time', 'total_time',
        'servings', 'difficulty',
        'ingredients', 'instructions',
        'chef_notes', 'tips', 'video_url',
        'nutritional_info',
        'is_featured',
        'seo_title', 'seo_description', 'seo_keywords',
        'is_published', 'sort_order',
    ];

    protected $casts = [
        'gallery'      => 'array',
        'is_featured'  => 'boolean',
        'is_published' => 'boolean',
        'servings'     => 'integer',
        'sort_order'   => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(RecipeCategory::class, 'recipe_category_id');
    }

    public function getImageUrlAttribute(): string
    {
        return $this->featured_image ? Storage::url($this->featured_image) : '';
    }

    public function getGalleryUrlsAttribute(): array
    {
        if (empty($this->gallery)) {
            return [];
        }
        return array_map(fn($path) => Storage::url($path), $this->gallery);
    }

    public function getAllImagesAttribute(): array
    {
        $images = [];
        if ($this->featured_image) {
            $images[] = Storage::url($this->featured_image);
        }
        foreach ($this->gallery_urls as $url) {
            $images[] = $url;
        }
        return $images;
    }

    public function getIngredientsListAttribute(): array
    {
        if (!$this->ingredients) {
            return [];
        }
        return array_values(array_filter(array_map('trim', explode("\n", $this->ingredients))));
    }

    public function getInstructionsListAttribute(): array
    {
        if (!$this->instructions) {
            return [];
        }
        return array_values(array_filter(array_map('trim', explode("\n", $this->instructions))));
    }

    public function getDifficultyLabelAttribute(): string
    {
        return match ($this->difficulty) {
            'easy'   => 'Easy',
            'hard'   => 'Hard',
            default  => 'Medium',
        };
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
