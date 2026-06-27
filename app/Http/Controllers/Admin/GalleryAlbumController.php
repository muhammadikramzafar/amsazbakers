<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryAlbumController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index()
    {
        $albums = GalleryAlbum::withCount('items')->orderBy('sort_order')->paginate(20);
        return view('admin.gallery.albums.index', compact('albums'));
    }

    public function create()
    {
        return view('admin.gallery.albums.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:120',
            'slug'        => 'nullable|string|max:150|unique:gallery_albums,slug',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:4096',
            'type'        => 'required|in:photos,videos,mixed',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'nullable|boolean',
        ]);
        $data['slug']      = $data['slug'] ?: Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $this->imageService->uploadCategory($request->file('cover_image'));
        }

        GalleryAlbum::create($data);
        return redirect()->route('admin.gallery.albums.index')->with('success', 'Album created.');
    }

    public function edit(GalleryAlbum $galleryAlbum)
    {
        return view('admin.gallery.albums.form', ['album' => $galleryAlbum]);
    }

    public function update(Request $request, GalleryAlbum $galleryAlbum)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:120',
            'slug'        => 'nullable|string|max:150|unique:gallery_albums,slug,'.$galleryAlbum->id,
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:4096',
            'type'        => 'required|in:photos,videos,mixed',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'nullable|boolean',
        ]);
        $data['slug']      = $data['slug'] ?: Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active', false);

        if ($request->hasFile('cover_image')) {
            if ($galleryAlbum->cover_image) $this->imageService->delete($galleryAlbum->cover_image);
            $data['cover_image'] = $this->imageService->uploadCategory($request->file('cover_image'));
        }

        $galleryAlbum->update($data);
        return redirect()->route('admin.gallery.albums.index')->with('success', 'Album updated.');
    }

    public function destroy(GalleryAlbum $galleryAlbum)
    {
        if ($galleryAlbum->cover_image) $this->imageService->delete($galleryAlbum->cover_image);
        $galleryAlbum->delete();
        return back()->with('success', 'Album deleted.');
    }
}
