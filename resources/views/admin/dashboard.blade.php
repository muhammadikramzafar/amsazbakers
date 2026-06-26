@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="py-8 px-4">
    <h1 class="text-2xl font-bold mb-6">Dashboard</h1>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded shadow p-4 text-center">
            <div class="text-3xl font-bold text-amber-600">{{ $stats['products'] }}</div>
            <div class="text-gray-500 mt-1">Products</div>
        </div>
        <div class="bg-white rounded shadow p-4 text-center">
            <div class="text-3xl font-bold text-amber-600">{{ $stats['categories'] }}</div>
            <div class="text-gray-500 mt-1">Categories</div>
        </div>
        <div class="bg-white rounded shadow p-4 text-center">
            <div class="text-3xl font-bold text-amber-600">{{ $stats['reservations'] }}</div>
            <div class="text-gray-500 mt-1">Reservations</div>
        </div>
        <div class="bg-white rounded shadow p-4 text-center">
            <div class="text-3xl font-bold text-red-600">{{ $stats['messages'] }}</div>
            <div class="text-gray-500 mt-1">Unread Messages</div>
        </div>
    </div>

    {{-- Recent Reservations --}}
    <div class="bg-white rounded shadow mb-8">
        <div class="px-4 py-3 border-b font-semibold">Recent Reservations</div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Date</th>
                    <th class="px-4 py-2 text-left">Guests</th>
                    <th class="px-4 py-2 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentReservations as $reservation)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $reservation->name }}</td>
                    <td class="px-4 py-2">{{ $reservation->date->format('d M Y') }} at {{ $reservation->time }}</td>
                    <td class="px-4 py-2">{{ $reservation->guests }}</td>
                    <td class="px-4 py-2 capitalize">{{ $reservation->status }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-4 py-3 text-gray-400 text-center">No reservations yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Recent Messages --}}
    <div class="bg-white rounded shadow">
        <div class="px-4 py-3 border-b font-semibold">Recent Messages</div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Subject</th>
                    <th class="px-4 py-2 text-left">Date</th>
                    <th class="px-4 py-2 text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentMessages as $msg)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $msg->name }}</td>
                    <td class="px-4 py-2">{{ $msg->subject }}</td>
                    <td class="px-4 py-2">{{ $msg->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-2">{{ $msg->is_read ? 'Read' : 'Unread' }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-4 py-3 text-gray-400 text-center">No messages yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
