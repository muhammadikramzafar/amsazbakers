<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HeroSlide extends Model
{
    protected $fillable = ['title','subtitle','btn1_text','btn1_url','btn2_text','btn2_url','image','is_active','sort_order'];
    protected $casts    = ['is_active' => 'boolean'];

    public function getImageUrlAttribute(): string
    {
        return $this->image ? Storage::url($this->image) : '';
    }

    public function scopeActive($q) { return $q->where('is_active', true)->orderBy('sort_order'); }
}
