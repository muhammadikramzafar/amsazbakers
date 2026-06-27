<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index(Request $request)
    {
        $query = BlogPost::with('category')->latest('published_at');

        if ($search = $request->input('search')) {
            $query->where(fn ($q) => $q->where('title', 'like', "%{$search}%")
                                       ->orWhere('excerpt', 'like', "%{$search}%"));
        }
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        if ($cat = $request->input('category_id')) {
            $query->where('blog_category_id', $cat);
        }

        $posts      = $query->paginate(20)->withQueryString();
        $categories = BlogCategory::active()->orderBy('name')->get();
        return view('admin.blog.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = BlogCategory::active()->orderBy('name')->get();
        $tags       = BlogTag::orderBy('name')->get();
        return view('admin.blog.posts.form', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $data = $this->validate($request);

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $this->imageService->uploadProduct($request->file('featured_image'));
        }

        $gallery = [];
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $gallery[] = $this->imageService->uploadGallery($file);
            }
        }
        $data['gallery'] = $gallery ?: null;

        if (empty($data['published_at']) && $data['status'] === 'published') {
            $data['published_at'] = now();
        }

        $post = BlogPost::create($data);
        $post->tags()->sync($request->input('tag_ids', []));

        return redirect()->route('admin.blog.posts.index')->with('success', 'Post created.');
    }

    public function edit(BlogPost $blogPost)
    {
        $categories = BlogCategory::active()->orderBy('name')->get();
        $tags       = BlogTag::orderBy('name')->get();
        return view('admin.blog.posts.form', ['post' => $blogPost, 'categories' => $categories, 'tags' => $tags]);
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        $data = $this->validate($request, $blogPost->id);

        if ($request->hasFile('featured_image')) {
            if ($blogPost->featured_image) $this->imageService->delete($blogPost->featured_image);
            $data['featured_image'] = $this->imageService->uploadProduct($request->file('featured_image'));
        }

        $gallery = $blogPost->gallery ?? [];
        foreach ($request->input('gallery_remove', []) as $path) {
            $this->imageService->delete($path);
            $gallery = array_filter($gallery, fn ($g) => $g !== $path);
        }
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $gallery[] = $this->imageService->uploadGallery($file);
            }
        }
        $data['gallery'] = array_values($gallery) ?: null;

        if (empty($data['published_at']) && $data['status'] === 'published' && !$blogPost->published_at) {
            $data['published_at'] = now();
        }

        $blogPost->update($data);
        $blogPost->tags()->sync($request->input('tag_ids', []));

        return redirect()->route('admin.blog.posts.index')->with('success', 'Post updated.');
    }

    public function destroy(BlogPost $blogPost)
    {
        if ($blogPost->featured_image) $this->imageService->delete($blogPost->featured_image);
        foreach ($blogPost->gallery ?? [] as $path) $this->imageService->delete($path);
        $blogPost->delete();
        return back()->with('success', 'Post deleted.');
    }

    private function validate(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'title'            => 'required|string|max:255',
            'slug'             => 'nullable|string|max:255|unique:blog_posts,slug'.($ignoreId ? ','.$ignoreId : ''),
            'excerpt'          => 'nullable|string|max:500',
            'content'          => 'nullable|string',
            'featured_image'   => 'nullable|image|max:5120',
            'gallery_images'   => 'nullable|array',
            'gallery_images.*' => 'image|max:5120',
            'status'           => 'required|in:draft,published,scheduled',
            'published_at'     => 'nullable|date',
            'is_featured'      => 'nullable|boolean',
            'seo_title'        => 'nullable|string|max:255',
            'seo_description'  => 'nullable|string|max:320',
            'seo_keywords'     => 'nullable|string|max:255',
            'sort_order'       => 'nullable|integer|min:0',
            'is_active'        => 'nullable|boolean',
        ]) + [
            'slug'        => $request->input('slug') ?: Str::slug($request->input('title')),
            'is_featured' => $request->boolean('is_featured', false),
            'is_active'   => $request->boolean('is_active', true),
        ];
    }
}
