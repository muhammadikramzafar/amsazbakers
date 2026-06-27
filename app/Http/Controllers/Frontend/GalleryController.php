<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Award;
use App\Models\GalleryAlbum;
use App\Models\Testimonial;

class GalleryController extends Controller
{
    public function index()
    {
        $albums = GalleryAlbum::active()
            ->withCount('activeItems')
            ->orderBy('sort_order')
            ->get();

        return view('frontend.gallery.index', compact('albums'));
    }

    public function show(GalleryAlbum $galleryAlbum)
    {
        abort_if(!$galleryAlbum->is_active, 404);

        $items = $galleryAlbum->activeItems()->paginate(24);
        $otherAlbums = GalleryAlbum::active()->where('id', '!=', $galleryAlbum->id)->orderBy('sort_order')->get();

        return view('frontend.gallery.show', compact('galleryAlbum', 'items', 'otherAlbums'));
    }

    public function testimonials()
    {
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order')->get();
        return view('frontend.gallery.testimonials', compact('testimonials'));
    }

    public function awards()
    {
        $awards = Award::active()->orderBy('sort_order')->get();
        return view('frontend.gallery.awards', compact('awards'));
    }
}
