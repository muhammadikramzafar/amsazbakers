@extends('frontend.layouts.app')
@section('title', ($page->seo_title ?: $page->title) . ' — ' . config('app.name'))
@section('meta_description', $page->meta_description ?: $page->short_description)

@section('content')

{{-- Banner --}}
@if($page->banner_image)
  <section class="page-banner" style="background-image:url('{{ Storage::url($page->banner_image) }}')">
    <div class="page-banner__overlay">
      <div class="container">
        <h1 class="page-banner__title">{{ $page->title }}</h1>
        @if($page->short_description)
          <p class="page-banner__sub">{{ $page->short_description }}</p>
        @endif
      </div>
    </div>
  </section>
@else
  <section class="page-hero">
    <div class="container">
      <h1 class="page-hero__title">{{ $page->title }}</h1>
      @if($page->short_description)
        <p class="page-hero__sub">{{ $page->short_description }}</p>
      @endif
    </div>
  </section>
@endif

{{-- Page content --}}
<section class="page-content-section">
  <div class="container">
    <div class="page-content">
      {!! $page->description !!}
    </div>
  </div>
</section>

@endsection

@push('styles')
<style>
  /* Banner with image */
  .page-banner {
    min-height: 280px;
    background-size: cover;
    background-position: center;
    position: relative;
  }
  .page-banner__overlay {
    position: absolute; inset: 0;
    background: rgba(90,62,43,.55);
    display: flex; align-items: center;
  }
  .page-banner__title { font-size: 42px; color: #fff; }
  .page-banner__sub   { font-size: 16px; color: rgba(255,255,255,.85); margin-top: 10px; }

  /* No-image hero */
  .page-hero { padding: 64px 0 48px; text-align: center; background: var(--clr-cream, #fff6e5); }
  .page-hero__title { font-size: 40px; color: var(--clr-brown, #5a3e2b); }
  .page-hero__sub   { font-size: 16px; color: #777; margin-top: 10px; }

  /* Content body */
  .page-content-section { padding: 60px 0 80px; }
  .page-content {
    max-width: 760px; margin: 0 auto;
    font-size: 15px; line-height: 1.8; color: #333;
  }
  .page-content h2 { font-size: 24px; color: var(--clr-brown, #5a3e2b); margin: 32px 0 12px; }
  .page-content h3 { font-size: 20px; color: var(--clr-brown, #5a3e2b); margin: 24px 0 10px; }
  .page-content p  { margin-bottom: 16px; }
  .page-content ul, .page-content ol { padding-left: 24px; margin-bottom: 16px; }
  .page-content li { margin-bottom: 6px; }
  .page-content a  { color: var(--clr-gold, #c8a24a); }
</style>
@endpush

@if($page->meta_keywords)
@push('styles')
<meta name="keywords" content="{{ $page->meta_keywords }}">
@endpush
@endif
