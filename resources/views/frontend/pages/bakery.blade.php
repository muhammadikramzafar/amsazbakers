@extends('frontend.layouts.app')
@section('title', 'Bakery — ' . config('app.name'))
@section('meta_description', 'Fresh-baked breads, pastries, and artisan cakes crafted daily at Azmeer Bakery.')

@section('content')
<section class="page-hero">
  <div class="container">
    <h1 class="page-hero__title">Bakery</h1>
    <p class="page-hero__sub">Artisan breads, pastries & cakes — baked fresh every morning.</p>
    <a href="{{ route('products.category', 'bakery') }}" class="btn btn--primary">Shop Bakery Items</a>
  </div>
</section>

<section class="coming-soon-section">
  <div class="container">
    <p class="coming-soon-section__note">
      Full bakery catalogue is coming soon. In the meantime, browse all products below.
    </p>
    <a href="{{ route('products.listing') }}" class="btn btn--outline">Browse All Products</a>
  </div>
</section>
@endsection

@push('styles')
<style>
  .page-hero { padding: 80px 0 60px; text-align: center; background: var(--clr-cream, #fff6e5); }
  .page-hero__title { font-size: 42px; color: var(--clr-brown, #5a3e2b); }
  .page-hero__sub   { font-size: 16px; margin: 12px 0 24px; color: #777; }
  .coming-soon-section { padding: 60px 0; text-align: center; }
  .coming-soon-section__note { font-size: 15px; color: #777; margin-bottom: 20px; }
</style>
@endpush
