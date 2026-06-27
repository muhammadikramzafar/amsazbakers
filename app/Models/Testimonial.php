<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Testimonial extends Model
{
    protected $fillable = ['customer_name','customer_role','quote','rating','avatar','is_active','sort_order'];
    protected $casts    = ['is_active' => 'boolean', 'rating' => 'integer'];

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar ? Storage::url($this->avatar) : '';
    }

    public function scopeActive($q) { return $q->where('is_active', true)->orderBy('sort_order'); }
}
