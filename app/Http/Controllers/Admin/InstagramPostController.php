<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstagramPost;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class InstagramPostController extends Controller
{
    public function index()
    {
        $posts = InstagramPost::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.homepage.instagram.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.homepage.instagram.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'image'      => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'caption'    => 'nullable|string|max:500',
            'post_url'   => 'nullable|url|max:500',
            'is_active'  => 'nullable|boolean',
            'sort_order' => 'required|integer|min:0',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $data['image']     = $this->uploadImage($request);
        InstagramPost::create($data);
        return redirect()->route('admin.homepage.instagram.index')->with('success', 'Post created.');
    }

    public function edit(InstagramPost $instagramPost)
    {
        return view('admin.homepage.instagram.form', ['post' => $instagramPost]);
    }

    public function update(Request $request, InstagramPost $instagramPost): RedirectResponse
    {
        $data = $request->validate([
            'image'      => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'caption'    => 'nullable|string|max:500',
            'post_url'   => 'nullable|url|max:500',
            'is_active'  => 'nullable|boolean',
            'sort_order' => 'required|integer|min:0',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            if ($instagramPost->image) Storage::disk('public')->delete($instagramPost->image);
            $data['image'] = $this->uploadImage($request);
        } else {
            unset($data['image']);
        }
        $instagramPost->update($data);
        return redirect()->route('admin.homepage.instagram.index')->with('success', 'Post updated.');
    }

    public function destroy(InstagramPost $instagramPost): RedirectResponse
    {
        if ($instagramPost->image) Storage::disk('public')->delete($instagramPost->image);
        $instagramPost->delete();
        return back()->with('success', 'Post deleted.');
    }

    private function uploadImage(Request $request): ?string
    {
        if (! $request->hasFile('image')) return null;
        $file = $request->file('image');
        $name = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = "instagram/{$name}";
        $img  = Image::read($file->getPathname())->scaleDown(600, 600);
        Storage::disk('public')->put($path, (string) $img->encode());
        return $path;
    }
}
