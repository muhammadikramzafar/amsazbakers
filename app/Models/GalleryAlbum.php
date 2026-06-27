<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GalleryAlbum extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'cover_image', 'type', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function items()       { return $this->hasMany(GalleryItem::class)->orderBy('sort_order'); }
    public function activeItems() { return $this->hasMany(GalleryItem::class)->where('is_active', true)->orderBy('sort_order'); }

    public function scopeActive($q) { return $q->where('is_active', true); }

    public function getCoverImageUrlAttribute(): ?string
    {
        return $this->cover_image ? Storage::url($this->cover_image) : null;
    }
}
