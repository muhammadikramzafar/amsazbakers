<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Award;
use App\Services\ImageService;
use Illuminate\Http\Request;

class AwardController extends Controller
{
    public function __construct(private ImageService $imageService) {}

    public function index()
    {
        $awards = Award::orderBy('sort_order')->paginate(20);
        return view('admin.awards.index', compact('awards'));
    }

    public function create()
    {
        return view('admin.awards.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'         => 'required|string|max:200',
            'description'   => 'nullable|string',
            'image'         => 'nullable|image|max:4096',
            'awarding_body' => 'nullable|string|max:200',
            'year'          => 'nullable|digits:4|integer|min:1900|max:2099',
            'sort_order'    => 'nullable|integer|min:0',
            'is_active'     => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $data['image'] = $this->imageService->uploadCategory($request->file('image'));
        }

        Award::create($data);
        return redirect()->route('admin.awards.index')->with('success', 'Award created.');
    }

    public function edit(Award $award)
    {
        return view('admin.awards.form', compact('award'));
    }

    public function update(Request $request, Award $award)
    {
        $data = $request->validate([
            'title'         => 'required|string|max:200',
            'description'   => 'nullable|string',
            'image'         => 'nullable|image|max:4096',
            'awarding_body' => 'nullable|string|max:200',
            'year'          => 'nullable|digits:4|integer|min:1900|max:2099',
            'sort_order'    => 'nullable|integer|min:0',
            'is_active'     => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', false);

        if ($request->hasFile('image')) {
            if ($award->image) $this->imageService->delete($award->image);
            $data['image'] = $this->imageService->uploadCategory($request->file('image'));
        }

        $award->update($data);
        return redirect()->route('admin.awards.index')->with('success', 'Award updated.');
    }

    public function destroy(Award $award)
    {
        if ($award->image) $this->imageService->delete($award->image);
        $award->delete();
        return back()->with('success', 'Award deleted.');
    }
}
