<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        $pages = Page::latest()->paginate(20);
        return view('admin.pages.index', compact('pages'));
    }

    public function create(): View
    {
        return view('admin.pages.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePage($request);

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')
                ->store('pages/banners', 'public');
        }

        Page::create($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', "Page \"{$validated['title']}\" created.");
    }

    public function edit(Page $page): View
    {
        return view('admin.pages.form', compact('page'));
    }

    public function update(Request $request, Page $page): RedirectResponse
    {
        $validated = $this->validatePage($request, $page);

        if ($request->hasFile('banner_image')) {
            if ($page->banner_image) {
                Storage::disk('public')->delete($page->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')
                ->store('pages/banners', 'public');
        } else {
            unset($validated['banner_image']);
        }

        $page->update($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', "Page \"{$page->title}\" updated.");
    }

    public function destroy(Page $page): RedirectResponse
    {
        if ($page->banner_image) {
            Storage::disk('public')->delete($page->banner_image);
        }

        $title = $page->title;
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', "Page \"{$title}\" deleted.");
    }

    private function validatePage(Request $request, ?Page $page = null): array
    {
        $slugRule = 'required|string|max:120|unique:pages,slug' . ($page ? ",{$page->id}" : '');

        return $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'slug'             => [$slugRule],
            'banner_image'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'short_description'=> ['nullable', 'string', 'max:500'],
            'description'      => ['nullable', 'string'],
            'seo_title'        => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords'    => ['nullable', 'string', 'max:255'],
            'status'           => ['required', 'in:published,draft'],
        ]);
    }
}
