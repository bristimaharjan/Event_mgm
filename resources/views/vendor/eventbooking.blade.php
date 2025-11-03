@extends('layouts.app')

@section('title', 'Event Bookings')
@php 
$noNavbar = true;
$noFooter = true; 
@endphp

@section('content')
@include('vendor.sidebar') 

<div class="max-w-7xl mx-auto mt-10 ml-72 mr-10">
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h2 class="text-3xl font-bold text-[#8d85ec] mb-6">Event Bookings</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead class="bg-[#8D85EC] text-white">
                    <tr>
                        <th class="px-6 py-4">Booking ID</th>
                        <th class="px-6 py-4">User</th>
                        <th class="px-6 py-4">Event</th>
                           <th class="px-6 py-4">Booking Date</th>
                        <th class="px-6 py-4">Tickets</th>
                        <th class="px-6 py-4">Amount (Rs)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($eventBookings as $booking)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">{{ $booking->id }}</td>
                        <td class="px-6 py-4">{{ $booking->user->name }}</td>
                        <td class="px-6 py-4">{{ $booking->event->event_name }}</td>
                         <td class="px-6 py-4 ">{{ $booking->booking_date }}</td>
                        <td class="px-6 py-4">{{ $booking->tickets }}</td>
                        <td class="px-6 py-4">{{ number_format($booking->amount, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No event bookings found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection