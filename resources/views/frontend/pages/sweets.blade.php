@extends('frontend.layouts.app')
@section('title', 'Sweets — ' . config('app.name'))
@section('meta_description', 'Traditional Pakistani mithai and modern desserts handcrafted at Azmeer Bakery.')

@section('content')
<section class="page-hero">
  <div class="container">
    <h1 class="page-hero__title">Sweets</h1>
    <p class="page-hero__sub">Traditional mithai & modern desserts — made with the finest ingredients.</p>
    <a href="{{ route('products.category', 'sweets') }}" class="btn btn--primary">Shop Sweets</a>
  </div>
</section>

<section class="coming-soon-section">
  <div class="container">
    <p class="coming-soon-section__note">
      Full sweets catalogue is coming soon. Browse all products in the meantime.
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
