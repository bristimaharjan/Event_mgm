@extends('layouts.app')

@section('title', 'Event Bookings')
@php 
$noNavbar = true;
$noFooter = true; 
@endphp

@section('content')
@include('admin.sidebar') 

<div class="max-w-7xl mx-auto mt-10 ml-72 mr-10">
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h2 class="text-3xl font-bold text-[#8d85ec] mb-6">Event Bookings</h2>
        <!-- Date Filter Form -->
        <form method="GET" action="{{ route('admin.reports.admineventbooking') }}" class="mb-4 flex items-center space-x-4">
            <div>
                <label for="from_date" class="block text-sm font-medium text-gray-700">From</label>
                <input type="date" id="from_date" name="from_date" value="{{ request('from_date') }}" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>
            <div>
                <label for="to_date" class="block text-sm font-medium text-gray-700">To</label>
                <input type="date" id="to_date" name="to_date" value="{{ request('to_date') }}" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
            </div>
           <!-- Filter Button -->
                <div class="self-end">
                    <button type="submit" 
                            class="bg-[#8D85EC] hover:bg-[#7b76e4] text-white px-4 py-2 rounded-md text-sm font-medium">
                        Filter
                    </button>
                    <!-- Reset Button -->
    <a href="{{ route('admin.reports.admineventbooking') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded text-sm font-medium">
        Reset
    </a>
                </div>
        </form>


        <!-- Table -->
        <div class="overflow-x-auto mb-4">
            <table class="w-full text-sm text-left border-collapse border border-gray-300">
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
                        <td class="px-6 py-4 border border-gray-300">{{ $booking->id }}</td>
                        <td class="px-6 py-4 border border-gray-300">{{ $booking->user->name }}</td>
                        <td class="px-6 py-4 border border-gray-300">{{ $booking->event->event_name }}</td>
                         <td class="px-6 py-4 border border-gray-300">{{ $booking->booking_date }}</td>
                        <td class="px-6 py-4 border border-gray-300">{{ $booking->tickets }}</td>
                        <td class="px-6 py-4 border border-gray-300">{{ number_format($booking->amount, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No event bookings found.</td>
                    </tr>
                    @endforelse
                </tbody>
                <!-- Footer row for total amount -->
                <tfoot>
                    <tr>
                        <td colspan="5" class="px-6 py-4 font-semibold text-right">Total Amount:</td>
                        <td class="px-6 py-4 font-semibold text-green-600">{{ number_format($eventBookings->sum('amount'), 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Download PDF Button -->
        <div class="mt-4 text-right">
             <a href="{{ route('admin.reports.admineventbooking.pdf', array_merge(request()->query(), [
    'from_date' => request('from_date'),
    'to_date' => request('to_date')
])) }}" class="bg-[#8D85EC] hover:bg-[#7b76e4] text-white font-bold py-2 px-4 rounded">
    Download PDF Report
</a>
        </div>
    </div>
</div>
@endsection