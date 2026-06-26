<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ImageService
{
    /**
     * Upload and resize an image, returning the storage path.
     *
     * @param  UploadedFile  $file
     * @param  string        $folder   e.g. 'products', 'categories'
     * @param  int|null      $width
     * @param  int|null      $height
     * @param  string|null   $oldPath  previous image to delete
     */
    public function upload(
        UploadedFile $file,
        string $folder,
        ?int $width = null,
        ?int $height = null,
        ?string $oldPath = null
    ): string {
        if ($oldPath) {
            $this->delete($oldPath);
        }

        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path     = $folder . '/' . $filename;

        $image = Image::read($file);

        if ($width && $height) {
            $image->cover($width, $height);
        } elseif ($width) {
            $image->scale(width: $width);
        } elseif ($height) {
            $image->scale(height: $height);
        }

        Storage::disk('public')->put($path, $image->toJpeg(90));

        return $path;
    }

    /**
     * Upload a product image (600×600).
     */
    public function uploadProduct(UploadedFile $file, ?string $oldPath = null): string
    {
        $sizes = config('image.thumbnails.product');
        return $this->upload($file, config('image.paths.products'), $sizes['width'], $sizes['height'], $oldPath);
    }

    /**
     * Upload a category image (400×300).
     */
    public function uploadCategory(UploadedFile $file, ?string $oldPath = null): string
    {
        $sizes = config('image.thumbnails.category');
        return $this->upload($file, config('image.paths.categories'), $sizes['width'], $sizes['height'], $oldPath);
    }

    /**
     * Upload a gallery image (800×600).
     */
    public function uploadGallery(UploadedFile $file, ?string $oldPath = null): string
    {
        $sizes = config('image.thumbnails.gallery');
        return $this->upload($file, config('image.paths.gallery'), $sizes['width'], $sizes['height'], $oldPath);
    }

    /**
     * Upload a slider image (1920×700).
     */
    public function uploadSlider(UploadedFile $file, ?string $oldPath = null): string
    {
        $sizes = config('image.thumbnails.slider');
        return $this->upload($file, config('image.paths.sliders'), $sizes['width'], $sizes['height'], $oldPath);
    }

    /**
     * Delete an image from public storage.
     */
    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
