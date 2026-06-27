<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'website_name', 'tagline', 'logo', 'footer_logo', 'favicon',
        'address', 'city', 'province', 'country', 'phone', 'whatsapp', 'email',
        'facebook_url', 'instagram_url', 'youtube_url', 'tiktok_url',
        'map_embed', 'opening_time', 'closing_time', 'weekly_holidays',
        'footer_description', 'copyright_text',
    ];

    protected $casts = [
        'weekly_holidays' => 'array',
    ];

    /** Return the one settings row, creating it with defaults if absent. */
    public static function get(): static
    {
        return static::firstOrCreate(
            ['id' => 1],
            [
                'website_name'   => config('app.name', 'Azmeer Bakery'),
                'country'        => 'Pakistan',
                'copyright_text' => '© ' . date('Y') . ' Azmeer Bakery. All rights reserved.',
            ]
        );
    }

    /** Convenience: format hours range. */
    public function getHoursAttribute(): string
    {
        if ($this->opening_time && $this->closing_time) {
            return $this->opening_time . ' – ' . $this->closing_time;
        }
        return '';
    }
}
