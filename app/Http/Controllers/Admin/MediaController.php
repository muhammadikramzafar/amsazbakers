<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\Laravel\Facades\Image;

class MediaController extends Controller
{
    private const FOLDERS  = ['general', 'products', 'categories', 'pages', 'gallery'];
    private const IMG_EXTS = ['jpg', 'jpeg', 'png', 'webp'];
    private const MAX_PX   = 2400;

    public function index(Request $request): View
    {
        $query = Media::latest();

        if ($folder = $request->query('folder')) {
            $query->where('folder', $folder);
        }

        if ($search = $request->query('search')) {
            $query->where('original_name', 'like', '%' . $search . '%');
        }

        $media   = $query->paginate(40)->withQueryString();
        $folders = self::FOLDERS;

        return view('admin.media.index', compact('media', 'folders'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'file'   => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
            'folder' => ['nullable', 'in:' . implode(',', self::FOLDERS)],
        ]);

        $file   = $request->file('file');
        $folder = $request->input('folder', 'general');
        $ext    = strtolower($file->getClientOriginalExtension());
        $base   = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $name   = $base . '-' . Str::random(8) . '.' . $ext;
        $path   = "media/{$folder}/{$name}";

        $width = $height = null;

        if (in_array($ext, self::IMG_EXTS)) {
            $img = Image::read($file->getPathname());
            $img->scaleDown(self::MAX_PX, self::MAX_PX);
            Storage::disk('public')->put($path, (string) $img->encode());
            $width  = $img->width();
            $height = $img->height();
        } else {
            Storage::disk('public')->put($path, file_get_contents($file->getRealPath()));
        }

        $media = Media::create([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
            'path'          => $path,
            'disk'          => 'public',
            'mime_type'     => $file->getMimeType(),
            'extension'     => $ext,
            'size'          => Storage::disk('public')->size($path),
            'folder'        => $folder,
            'width'         => $width,
            'height'        => $height,
        ]);

        return response()->json([
            'success'        => true,
            'id'             => $media->id,
            'url'            => $media->url,
            'name'           => $media->original_name,
            'size_formatted' => $media->size_formatted,
            'is_image'       => $media->is_image,
            'extension'      => $media->extension,
        ]);
    }

    public function destroy(Media $media): RedirectResponse
    {
        $media->delete();

        return back()->with('success', "\"{$media->original_name}\" deleted.");
    }
}
