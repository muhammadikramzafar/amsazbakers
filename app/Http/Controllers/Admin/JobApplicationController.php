<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobListing;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = JobApplication::with('job')->latest();

        if ($jobId = $request->input('job_id')) {
            $query->where('job_listing_id', $jobId);
        }
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        $applications = $query->paginate(25)->withQueryString();
        $listings     = JobListing::orderBy('title')->get();
        return view('admin.careers.applications.index', compact('applications', 'listings'));
    }

    public function show(JobApplication $jobApplication)
    {
        return view('admin.careers.applications.show', ['application' => $jobApplication->load('job')]);
    }

    public function update(Request $request, JobApplication $jobApplication)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,reviewing,shortlisted,rejected',
            'notes'  => 'nullable|string|max:2000',
        ]);
        $jobApplication->update($data);
        return back()->with('success', 'Application status updated.');
    }

    public function destroy(JobApplication $jobApplication)
    {
        $jobApplication->delete();
        return back()->with('success', 'Application deleted.');
    }
}
