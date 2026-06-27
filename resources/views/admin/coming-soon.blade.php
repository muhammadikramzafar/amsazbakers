@extends('admin.layouts.app')
@section('title', $module)
@section('breadcrumb', $module)

@section('content')
<div class="admin-page-header">
  <h1 class="admin-page-title">{{ $module }}</h1>
</div>

<div class="admin-card coming-soon-card">
  <div class="coming-soon">
    <div class="coming-soon__icon" aria-hidden="true">
      <svg viewBox="0 0 48 48" fill="none" stroke="currentColor" stroke-width="1.5" width="48" height="48">
        <circle cx="24" cy="24" r="20"/>
        <path d="M24 14v10l6 6"/>
      </svg>
    </div>
    <h2 class="coming-soon__heading">{{ $module }} — Coming Soon</h2>
    <p class="coming-soon__body">
      This module is part of the planned feature set and will be built in a future sprint.
      The route and navigation are already wired — only the CRUD interface remains.
    </p>
    <a href="{{ route('admin.dashboard') }}" class="btn btn--outline" style="margin-top:8px;">
      &larr; Back to Dashboard
    </a>
  </div>
</div>
@endsection

@push('styles')
<style>
  .coming-soon-card { text-align: center; padding: 60px 32px; }
  .coming-soon__icon { color: var(--clr-muted); margin-bottom: 20px; opacity:.5; }
  .coming-soon__heading { font-size: 20px; font-weight: 700; margin-bottom: 10px; }
  .coming-soon__body { font-size: 14px; color: var(--clr-muted); max-width: 440px; margin: 0 auto; line-height: 1.7; }
</style>
@endpush
