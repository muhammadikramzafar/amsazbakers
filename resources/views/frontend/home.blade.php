@extends('layouts.frontend')

@section('title', 'Home — Bakers & Sweets')

@section('content')
    {{--
        Paste your existing Home page HTML here.
        Use Blade directives to inject dynamic data:

        Loop over featured products:
        @foreach($featuredProducts as $product)
            <div>{{ $product->name }} — {{ $product->display_price }}</div>
        @endforeach

        Loop over categories:
        @foreach($categories as $category)
            <div>{{ $category->name }}</div>
        @endforeach

        Loop over gallery images:
        @foreach($galleryImages as $image)
            <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $image->title }}">
        @endforeach
    --}}
@endsection
