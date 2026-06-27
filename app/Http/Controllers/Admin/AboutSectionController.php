<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class AboutSectionController extends Controller
{
    public function edit()
    {
        $about = AboutSection::get();
        return view('admin.homepage.about.edit', compact('about'));
    }

    public function update(Request $request): RedirectResponse
    {
        $about = AboutSection::get();

        $data = $request->validate([
            'heading'     => 'required|string|max:255',
            'subheading'  => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'btn_text'    => 'nullable|string|max:100',
            'btn_url'     => 'nullable|string|max:500',
            'stat1_number'=> 'nullable|string|max:50',
            'stat1_label' => 'nullable|string|max:100',
            'stat2_number'=> 'nullable|string|max:50',
            'stat2_label' => 'nullable|string|max:100',
            'stat3_number'=> 'nullable|string|max:50',
            'stat3_label' => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('image')) {
            if ($about->image) Storage::disk('public')->delete($about->image);
            $file = $request->file('image');
            $name = uniqid() . '.' . $file->getClientOriginalExtension();
            $path = "about/{$name}";
            $img  = Image::read($file->getPathname())->scaleDown(1200, 900);
            Storage::disk('public')->put($path, (string) $img->encode());
            $data['image'] = $path;
        } else {
            unset($data['image']);
        }

        $about->update($data);
        return back()->with('success', 'About section updated.');
    }
}
