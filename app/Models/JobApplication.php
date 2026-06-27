<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class JobApplication extends Model
{
    protected $fillable = [
        'job_listing_id', 'full_name', 'email', 'phone',
        'cover_letter', 'resume', 'status', 'notes',
    ];

    public function job() { return $this->belongsTo(JobListing::class, 'job_listing_id'); }

    public function getResumeUrlAttribute(): ?string
    {
        return $this->resume ? Storage::url($this->resume) : null;
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'     => 'Pending',
            'reviewing'   => 'Under Review',
            'shortlisted' => 'Shortlisted',
            'rejected'    => 'Rejected',
            default       => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending'     => '#999',
            'reviewing'   => '#f59e0b',
            'shortlisted' => '#22c55e',
            'rejected'    => '#ef4444',
            default       => '#999',
        };
    }
}
