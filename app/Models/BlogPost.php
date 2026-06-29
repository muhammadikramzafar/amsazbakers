<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BlogPost extends Model
{
    protected $fillable = [
        'blog_category_id', 'user_id', 'title', 'slug', 'excerpt', 'content',
        'featured_image', 'gallery', 'status', 'published_at', 'is_featured',
        'views_count', 'seo_title', 'seo_description', 'seo_keywords',
        'sort_order', 'is_active',
    ];

    protected $casts = [
        'gallery'      => 'array',
        'published_at' => 'datetime',
        'is_featured'  => 'boolean',
        'is_active'    => 'boolean',
    ];

    public function category() { return $this->belongsTo(BlogCategory::class, 'blog_category_id'); }
    public function author()   { return $this->belongsTo(\App\Models\User::class, 'user_id'); }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'blog_post_tag');
    }

    public function scopePublished($q)
    {
        return $q->where('status', 'published')->where('is_active', true);
    }

    public function scopeFeatured($q) { return $q->where('is_featured', true); }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->featured_image) return null;
        if (str_starts_with($this->featured_image, 'http')) return $this->featured_image;
        return Storage::url($this->featured_image);
    }

    public function getGalleryUrlsAttribute(): array
    {
        return collect($this->gallery ?? [])->map(fn ($p) => Storage::url($p))->all();
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }
}
