<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryAlbum;
use App\Models\GalleryItem;
use App\Services\ImageService;
use Illuminate\Http\Request;

class GalleryItemController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index(GalleryAlbum $galleryAlbum)
    {
        $items = $galleryAlbum->items()->orderBy('sort_order')->paginate(30);
        return view('admin.gallery.items.index', compact('galleryAlbum', 'items'));
    }

    public function create(GalleryAlbum $galleryAlbum)
    {
        return view('admin.gallery.items.form', compact('galleryAlbum'));
    }

    public function store(Request $request, GalleryAlbum $galleryAlbum)
    {
        $data = $request->validate([
            'type'        => 'required|in:image,video',
            'file_path'   => 'nullable|image|max:5120',
            'video_url'   => 'nullable|url|max:500',
            'caption'     => 'nullable|string|max:255',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'nullable|boolean',
        ]);
        $data['gallery_album_id'] = $galleryAlbum->id;
        $data['is_active']        = $request->boolean('is_active', true);

        if ($request->hasFile('file_path')) {
            $data['file_path'] = $this->imageService->uploadGallery($request->file('file_path'));
        }

        GalleryItem::create($data);
        return redirect()->route('admin.gallery.items.index', $galleryAlbum)->with('success', 'Item added.');
    }

    public function edit(GalleryAlbum $galleryAlbum, GalleryItem $galleryItem)
    {
        return view('admin.gallery.items.form', compact('galleryAlbum', 'galleryItem'));
    }

    public function update(Request $request, GalleryAlbum $galleryAlbum, GalleryItem $galleryItem)
    {
        $data = $request->validate([
            'type'       => 'required|in:image,video',
            'file_path'  => 'nullable|image|max:5120',
            'video_url'  => 'nullable|url|max:500',
            'caption'    => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active'  => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', false);

        if ($request->hasFile('file_path')) {
            if ($galleryItem->file_path) $this->imageService->delete($galleryItem->file_path);
            $data['file_path'] = $this->imageService->uploadGallery($request->file('file_path'));
        }

        $galleryItem->update($data);
        return redirect()->route('admin.gallery.items.index', $galleryAlbum)->with('success', 'Item updated.');
    }

    public function destroy(GalleryAlbum $galleryAlbum, GalleryItem $galleryItem)
    {
        if ($galleryItem->file_path) $this->imageService->delete($galleryItem->file_path);
        $galleryItem->delete();
        return back()->with('success', 'Item deleted.');
    }
}
