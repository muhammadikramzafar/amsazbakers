@extends('frontend.layouts.app')
@section('title', 'Our Story — Azmeer Bakery')

@section('content')

  <section class="page-banner">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}" class="breadcrumb__link">Home</a>
      <span class="breadcrumb__sep" aria-hidden="true">/</span>
      <span class="breadcrumb__current">Our Story</span>
    </nav>
    <h1 class="page-banner__title">Our Story</h1>
    <span class="gold-rule gold-rule--center" aria-hidden="true"></span>
  </section>

  <section class="about-section">
    <div class="about-grid">
      <div class="about-text">
        <h2 class="about-text__heading">Crafting Memories Since 2008</h2>
        <p>Founded in the heart of Lahore, Azmeer Bakery began as a humble kitchen experiment and grew into one of the city's most beloved bakeries. We blend traditional South Asian flavours with modern confectionery techniques to create truly unique experiences.</p>
        <p>Every product is handcrafted with the finest local ingredients — from farm-fresh dairy to hand-ground spices — ensuring that each bite carries the warmth of our heritage.</p>
        <a href="{{ route('products.listing') }}" class="btn btn--primary" style="margin-top:24px; display:inline-block;">Explore Our Menu</a>
      </div>
      <div class="about-image">
        <img src="https://placehold.co/600x450/f3e2c7/5a3e2b?text=Our+Bakery" alt="Azmeer Bakery kitchen" loading="lazy" />
      </div>
    </div>
  </section>

@endsection
