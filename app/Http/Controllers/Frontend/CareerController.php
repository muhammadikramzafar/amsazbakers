<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\JobApplicationRequest;
use App\Mail\JobApplicationReceivedMail;
use App\Models\JobApplication;
use App\Models\JobListing;
use Illuminate\Support\Facades\Mail;

class CareerController extends Controller
{
    public function index()
    {
        $listings = JobListing::active()->orderBy('sort_order')->get();
        return view('frontend.careers.index', compact('listings'));
    }

    public function show(JobListing $jobListing)
    {
        abort_if(!$jobListing->is_active, 404);
        return view('frontend.careers.show', compact('jobListing'));
    }

    public function apply(JobApplicationRequest $request, JobListing $jobListing)
    {
        abort_if(!$jobListing->is_active, 404);

        $data = $request->validated();
        $data['resume'] = $request->file('resume')->store('resumes', 'public');
        $data['job_listing_id'] = $jobListing->id;

        $application = JobApplication::create($data);

        Mail::to(config('mail.from.address'))
            ->queue(new JobApplicationReceivedMail($application->load('job')));

        return redirect()->route('careers.show', $jobListing->slug)
            ->with('success', 'Your application has been submitted successfully! We will get back to you shortly.');
    }
}
