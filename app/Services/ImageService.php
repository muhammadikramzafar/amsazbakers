<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ImageService
{
    private const MAX_DIMENSION = 2000;
    private const JPEG_QUALITY  = 85;
    private const WEBP_QUALITY  = 82;

    /**
     * Upload, resize, and optimise an image. Returns the stored path.
     *
     * @param  string|null $oldPath  Previous image to delete before uploading
     * @param  bool        $webp     Convert to WebP (saves ~25-35% over JPEG)
     */
    public function upload(
        UploadedFile $file,
        string $folder,
        ?int $width = null,
        ?int $height = null,
        ?string $oldPath = null,
        bool $webp = false
    ): string {
        if ($oldPath) {
            $this->delete($oldPath);
        }

        $ext      = $webp ? 'webp' : 'jpg';
        $filename = Str::uuid() . '.' . $ext;
        $path     = $folder . '/' . $filename;

        $image = Image::read($file);

        // Hard cap to avoid storing huge originals
        $w = $image->width();
        $h = $image->height();
        if ($w > self::MAX_DIMENSION || $h > self::MAX_DIMENSION) {
            $image->scaleDown(self::MAX_DIMENSION, self::MAX_DIMENSION);
        }

        if ($width && $height) {
            $image->cover($width, $height);
        } elseif ($width) {
            $image->scale(width: $width);
        } elseif ($height) {
            $image->scale(height: $height);
        }

        $encoded = $webp
            ? $image->toWebp(self::WEBP_QUALITY)
            : $image->toJpeg(self::JPEG_QUALITY);

        Storage::disk('public')->put($path, $encoded);

        return $path;
    }

    public function uploadProduct(UploadedFile $file, ?string $oldPath = null): string
    {
        $sizes = config('image.thumbnails.product');
        return $this->upload($file, config('image.paths.products'), $sizes['width'], $sizes['height'], $oldPath);
    }

    public function uploadCategory(UploadedFile $file, ?string $oldPath = null): string
    {
        $sizes = config('image.thumbnails.category');
        return $this->upload($file, config('image.paths.categories'), $sizes['width'], $sizes['height'], $oldPath);
    }

    public function uploadGallery(UploadedFile $file, ?string $oldPath = null): string
    {
        $sizes = config('image.thumbnails.gallery');
        return $this->upload($file, config('image.paths.gallery'), $sizes['width'], $sizes['height'], $oldPath);
    }

    public function uploadSlider(UploadedFile $file, ?string $oldPath = null): string
    {
        $sizes = config('image.thumbnails.slider');
        return $this->upload($file, config('image.paths.sliders'), $sizes['width'], $sizes['height'], $oldPath);
    }

    /**
     * Generate a WebP thumbnail alongside an existing JPEG path.
     * Returns the WebP path, or null if source not found.
     */
    public function generateWebpVariant(string $jpegPath): ?string
    {
        if (!Storage::disk('public')->exists($jpegPath)) {
            return null;
        }

        $webpPath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $jpegPath);

        if (Storage::disk('public')->exists($webpPath)) {
            return $webpPath;
        }

        $contents = Storage::disk('public')->get($jpegPath);
        $image    = Image::read($contents);
        Storage::disk('public')->put($webpPath, $image->toWebp(self::WEBP_QUALITY));

        return $webpPath;
    }

    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
