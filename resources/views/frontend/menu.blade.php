@extends('layouts.frontend')

@section('title', 'Menu — Bakers & Sweets')

@section('content')
    {{--
        Paste your existing Menu page HTML here.

        Categories filter example:
        @foreach($categories as $category)
            <a href="{{ route('menu', ['category' => $category->slug]) }}">{{ $category->name }}</a>
        @endforeach

        Product cards loop:
        @foreach($products as $product)
            <div class="menu-item">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                <h3>{{ $product->name }}</h3>
                <p>{{ $product->description }}</p>
                <span>{{ $product->display_price }}</span>
                @if($product->badge)
                    <span class="badge">{{ $product->badge }}</span>
                @endif
            </div>
        @endforeach

        Pagination:
        {{ $products->links() }}
    --}}
@endsection
