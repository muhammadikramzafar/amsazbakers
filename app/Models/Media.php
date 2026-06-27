<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    protected $fillable = [
        'name', 'original_name', 'path', 'disk', 'mime_type',
        'extension', 'size', 'folder', 'width', 'height',
    ];

    protected $appends = ['url', 'size_formatted', 'is_image'];

    /** Full public URL. */
    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    /** Human-readable file size. */
    public function getSizeFormattedAttribute(): string
    {
        $b = $this->size;
        if ($b >= 1_048_576) return round($b / 1_048_576, 1) . ' MB';
        if ($b >= 1_024)     return round($b / 1_024, 1) . ' KB';
        return $b . ' B';
    }

    /** Whether the file is a raster image. */
    public function getIsImageAttribute(): bool
    {
        return in_array(strtolower($this->extension), ['jpg', 'jpeg', 'png', 'webp']);
    }

    /** Delete the physical file when the record is deleted. */
    protected static function booted(): void
    {
        static::deleting(function (self $media) {
            Storage::disk($media->disk)->delete($media->path);
        });
    }
}
