@extends('frontend.layouts.app')
@section('title', 'Gallery — ' . config('app.name'))
@section('meta_description', 'Browse our photo gallery — cakes, pastries, sweets and our beautiful bakery.')

@section('content')
<section class="page-hero">
  <div class="container">
    <h1 class="page-hero__title">Gallery</h1>
    <p class="page-hero__sub">A glimpse of what we craft with love every day.</p>
  </div>
</section>

<section class="coming-soon-section">
  <div class="container">
    <p class="coming-soon-section__note">
      Our photo gallery is coming soon. Follow us on social media for the latest.
    </p>
  </div>
</section>
@endsection

@push('styles')
<style>
  .page-hero { padding: 80px 0 60px; text-align: center; background: var(--clr-cream, #fff6e5); }
  .page-hero__title { font-size: 42px; color: var(--clr-brown, #5a3e2b); }
  .page-hero__sub   { font-size: 16px; margin: 12px 0 24px; color: #777; }
  .coming-soon-section { padding: 60px 0; text-align: center; }
  .coming-soon-section__note { font-size: 15px; color: #777; }
</style>
@endpush
