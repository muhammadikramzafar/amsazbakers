<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhyChooseFeature;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class WhyChooseFeatureController extends Controller
{
    public function index()
    {
        $features = WhyChooseFeature::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.homepage.why-choose.index', compact('features'));
    }

    public function create()
    {
        return view('admin.homepage.why-choose.form', ['icons' => WhyChooseFeature::$icons]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'icon_name'   => 'required|string|max:50',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'is_active'   => 'nullable|boolean',
            'sort_order'  => 'required|integer|min:0',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        WhyChooseFeature::create($data);
        return redirect()->route('admin.homepage.why-choose.index')->with('success', 'Feature created.');
    }

    public function edit(WhyChooseFeature $whyChooseFeature)
    {
        return view('admin.homepage.why-choose.form', [
            'feature' => $whyChooseFeature,
            'icons'   => WhyChooseFeature::$icons,
        ]);
    }

    public function update(Request $request, WhyChooseFeature $whyChooseFeature): RedirectResponse
    {
        $data = $request->validate([
            'icon_name'   => 'required|string|max:50',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'is_active'   => 'nullable|boolean',
            'sort_order'  => 'required|integer|min:0',
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $whyChooseFeature->update($data);
        return redirect()->route('admin.homepage.why-choose.index')->with('success', 'Feature updated.');
    }

    public function destroy(WhyChooseFeature $whyChooseFeature): RedirectResponse
    {
        $whyChooseFeature->delete();
        return back()->with('success', 'Feature deleted.');
    }
}
