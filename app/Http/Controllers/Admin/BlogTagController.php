<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogTagController extends Controller
{
    public function index()
    {
        $tags = BlogTag::withCount('posts')->orderBy('name')->paginate(30);
        return view('admin.blog.tags.index', compact('tags'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(['name' => 'required|string|max:80|unique:blog_tags,name']);
        $data['slug'] = Str::slug($data['name']);
        BlogTag::create($data);
        return back()->with('success', 'Tag created.');
    }

    public function update(Request $request, BlogTag $blogTag)
    {
        $data = $request->validate(['name' => 'required|string|max:80|unique:blog_tags,name,'.$blogTag->id]);
        $data['slug'] = Str::slug($data['name']);
        $blogTag->update($data);
        return back()->with('success', 'Tag updated.');
    }

    public function destroy(BlogTag $blogTag)
    {
        $blogTag->delete();
        return back()->with('success', 'Tag deleted.');
    }
}
