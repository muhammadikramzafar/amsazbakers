@extends('layouts.frontend')

@section('title', 'Contact Us — Bakers & Sweets')

@section('content')
    {{--
        Paste your existing Contact page HTML here.
        Wrap the form with:

        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST">
            @csrf
            ... your existing form fields ...
        </form>
    --}}
@endsection
