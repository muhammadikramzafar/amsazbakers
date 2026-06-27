<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    public function index(): View
    {
        $settings = SiteSetting::get();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'website_name'       => ['required', 'string', 'max:120'],
            'tagline'            => ['nullable', 'string', 'max:255'],
            'logo'               => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'footer_logo'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'favicon'            => ['nullable', 'file', 'mimes:ico,png', 'max:256'],
            'address'            => ['nullable', 'string', 'max:500'],
            'city'               => ['nullable', 'string', 'max:100'],
            'province'           => ['nullable', 'string', 'max:100'],
            'country'            => ['nullable', 'string', 'max:100'],
            'phone'              => ['nullable', 'string', 'max:30'],
            'whatsapp'           => ['nullable', 'string', 'max:30'],
            'email'              => ['nullable', 'email', 'max:120'],
            'facebook_url'       => ['nullable', 'url', 'max:255'],
            'instagram_url'      => ['nullable', 'url', 'max:255'],
            'youtube_url'        => ['nullable', 'url', 'max:255'],
            'tiktok_url'         => ['nullable', 'url', 'max:255'],
            'map_embed'          => ['nullable', 'string'],
            'opening_time'       => ['nullable', 'date_format:H:i'],
            'closing_time'       => ['nullable', 'date_format:H:i'],
            'weekly_holidays'    => ['nullable', 'array'],
            'weekly_holidays.*'  => ['string', 'in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'],
            'footer_description' => ['nullable', 'string', 'max:1000'],
            'copyright_text'     => ['nullable', 'string', 'max:255'],
        ]);

        $settings = SiteSetting::get();

        // Handle file uploads
        foreach (['logo', 'footer_logo', 'favicon'] as $field) {
            if ($request->hasFile($field)) {
                if ($settings->$field) {
                    Storage::disk('public')->delete($settings->$field);
                }
                $path = $request->file($field)->store("settings/{$field}", 'public');
                $validated[$field] = $path;
            } else {
                unset($validated[$field]);
            }
        }

        $settings->update($validated);

        return back()->with('success', 'Site settings saved successfully.');
    }
}
