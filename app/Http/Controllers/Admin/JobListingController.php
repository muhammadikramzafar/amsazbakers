<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobListingController extends Controller
{
    public function index()
    {
        $listings = JobListing::withCount('applications')->orderBy('sort_order')->paginate(20);
        return view('admin.careers.listings.index', compact('listings'));
    }

    public function create()
    {
        return view('admin.careers.listings.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'                => 'required|string|max:200',
            'slug'                 => 'nullable|string|max:255|unique:job_listings,slug',
            'department'           => 'nullable|string|max:100',
            'location'             => 'nullable|string|max:150',
            'type'                 => 'required|in:full-time,part-time,contract,internship',
            'description'          => 'required|string',
            'requirements'         => 'nullable|string',
            'benefits'             => 'nullable|string',
            'salary_range'         => 'nullable|string|max:100',
            'application_deadline' => 'nullable|date',
            'sort_order'           => 'nullable|integer|min:0',
            'is_active'            => 'nullable|boolean',
        ]);
        $data['slug']      = $data['slug'] ?: Str::slug($data['title']);
        $data['is_active'] = $request->boolean('is_active', true);

        JobListing::create($data);
        return redirect()->route('admin.careers.listings.index')->with('success', 'Job listing created.');
    }

    public function edit(JobListing $jobListing)
    {
        return view('admin.careers.listings.form', compact('jobListing'));
    }

    public function update(Request $request, JobListing $jobListing)
    {
        $data = $request->validate([
            'title'                => 'required|string|max:200',
            'slug'                 => 'nullable|string|max:255|unique:job_listings,slug,'.$jobListing->id,
            'department'           => 'nullable|string|max:100',
            'location'             => 'nullable|string|max:150',
            'type'                 => 'required|in:full-time,part-time,contract,internship',
            'description'          => 'required|string',
            'requirements'         => 'nullable|string',
            'benefits'             => 'nullable|string',
            'salary_range'         => 'nullable|string|max:100',
            'application_deadline' => 'nullable|date',
            'sort_order'           => 'nullable|integer|min:0',
            'is_active'            => 'nullable|boolean',
        ]);
        $data['slug']      = $data['slug'] ?: Str::slug($data['title']);
        $data['is_active'] = $request->boolean('is_active', false);

        $jobListing->update($data);
        return redirect()->route('admin.careers.listings.index')->with('success', 'Job listing updated.');
    }

    public function destroy(JobListing $jobListing)
    {
        $jobListing->delete();
        return back()->with('success', 'Job listing deleted.');
    }
}
