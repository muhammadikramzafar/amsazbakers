<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AboutSection extends Model
{
    protected $table    = 'about_section';
    protected $fillable = [
        'heading','subheading','description','image','btn_text','btn_url',
        'stat1_number','stat1_label','stat2_number','stat2_label','stat3_number','stat3_label',
    ];

    public function getImageUrlAttribute(): string
    {
        return $this->image ? Storage::url($this->image) : '';
    }

    public static function get(): static
    {
        return static::firstOrCreate(['id' => 1], ['heading' => 'Our Story']);
    }
}
