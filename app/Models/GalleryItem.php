<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GalleryItem extends Model
{
    protected $fillable = [
        'gallery_album_id', 'type', 'file_path', 'video_url',
        'caption', 'thumb', 'sort_order', 'is_active',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function album() { return $this->belongsTo(GalleryAlbum::class, 'gallery_album_id'); }

    public function scopeActive($q) { return $q->where('is_active', true); }

    public function getFileUrlAttribute(): ?string
    {
        return $this->file_path ? Storage::url($this->file_path) : null;
    }

    public function getThumbUrlAttribute(): ?string
    {
        if ($this->thumb) return Storage::url($this->thumb);
        if ($this->file_path) return Storage::url($this->file_path);
        return null;
    }

    public function getIsVideoAttribute(): bool { return $this->type === 'video'; }
}
