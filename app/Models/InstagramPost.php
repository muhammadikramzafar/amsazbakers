<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class InstagramPost extends Model
{
    protected $fillable = ['image','caption','post_url','is_active','sort_order'];
    protected $casts    = ['is_active' => 'boolean'];

    public function getImageUrlAttribute(): string
    {
        return $this->image ? Storage::url($this->image) : '';
    }

    public function scopeActive($q) { return $q->where('is_active', true)->orderBy('sort_order'); }
}
