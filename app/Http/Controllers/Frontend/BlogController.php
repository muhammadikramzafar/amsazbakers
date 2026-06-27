<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogPost::with(['category', 'tags'])->published()->orderByDesc('published_at');

        if ($search = $request->input('search')) {
            $query->where(fn ($q) => $q->where('title', 'like', "%{$search}%")
                                       ->orWhere('excerpt', 'like', "%{$search}%")
                                       ->orWhere('content', 'like', "%{$search}%"));
        }

        $posts      = $query->paginate(9)->withQueryString();
        $categories = BlogCategory::active()->withCount('publishedPosts')->orderBy('sort_order')->get();
        $featuredPosts = BlogPost::published()->featured()->orderByDesc('published_at')->take(3)->get();
        $popularTags   = BlogTag::withCount(['posts' => fn ($q) => $q->published()])->having('posts_count', '>', 0)->orderByDesc('posts_count')->take(15)->get();
        $recentPosts   = BlogPost::published()->orderByDesc('published_at')->take(5)->get();

        return view('frontend.blog.index', compact('posts', 'categories', 'featuredPosts', 'popularTags', 'recentPosts', 'search'));
    }

    public function show(BlogPost $blogPost)
    {
        abort_if(!$blogPost->is_active || $blogPost->status !== 'published', 404);

        $blogPost->incrementViews();

        $related = BlogPost::published()
            ->where('id', '!=', $blogPost->id)
            ->where('blog_category_id', $blogPost->blog_category_id)
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        $prevPost = BlogPost::published()->where('published_at', '<', $blogPost->published_at)->orderByDesc('published_at')->first();
        $nextPost = BlogPost::published()->where('published_at', '>', $blogPost->published_at)->orderBy('published_at')->first();

        return view('frontend.blog.show', compact('blogPost', 'related', 'prevPost', 'nextPost'));
    }

    public function category(BlogCategory $blogCategory)
    {
        abort_if(!$blogCategory->is_active, 404);

        $posts = BlogPost::with(['category', 'tags'])
            ->published()
            ->where('blog_category_id', $blogCategory->id)
            ->orderByDesc('published_at')
            ->paginate(9);

        $categories  = BlogCategory::active()->withCount('publishedPosts')->orderBy('sort_order')->get();
        $recentPosts = BlogPost::published()->orderByDesc('published_at')->take(5)->get();

        return view('frontend.blog.category', compact('blogCategory', 'posts', 'categories', 'recentPosts'));
    }

    public function tag(BlogTag $blogTag)
    {
        $posts = BlogPost::with(['category', 'tags'])
            ->published()
            ->whereHas('tags', fn ($q) => $q->where('blog_tags.id', $blogTag->id))
            ->orderByDesc('published_at')
            ->paginate(9);

        $categories  = BlogCategory::active()->withCount('publishedPosts')->orderBy('sort_order')->get();
        $recentPosts = BlogPost::published()->orderByDesc('published_at')->take(5)->get();

        return view('frontend.blog.tag', compact('blogTag', 'posts', 'categories', 'recentPosts'));
    }
}
