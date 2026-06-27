<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    protected $fillable = [
        'title', 'slug', 'department', 'location', 'type',
        'description', 'requirements', 'benefits', 'salary_range',
        'application_deadline', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active'            => 'boolean',
        'application_deadline' => 'date',
    ];

    public function applications() { return $this->hasMany(JobApplication::class); }

    public function scopeActive($q) { return $q->where('is_active', true); }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'full-time'  => 'Full-Time',
            'part-time'  => 'Part-Time',
            'contract'   => 'Contract',
            'internship' => 'Internship',
            default      => $this->type,
        };
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->application_deadline && $this->application_deadline->isPast();
    }
}
