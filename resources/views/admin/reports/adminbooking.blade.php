@extends('layouts.app')

@section('title', 'Venues')
@php 
$noNavbar = true;
$noFooter = true; 
@endphp

@section('content')
@include('admin.sidebar') 

<div class="max-w-7xl mx-auto mt-10 ml-72 mr-10">
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <!-- Header -->
        <h2 class="text-3xl font-bold text-[#8d85ec] mb-6">Venues Booking Report</h2>
        
        <!-- Wrap filter and table in a single card container -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <!-- Filter Section -->
            <form method="GET" action="{{ route('admin.reports.adminbooking') }}" class="flex flex-wrap items-end gap-4">
                <!-- From Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">From</label>
                    <input type="date" 
                           name="from_date" 
                           value="{{ request('from_date') }}" 
                           class="mt-1 block w-40 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>

                <!-- To Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">To</label>
                    <input type="date" 
                           name="to_date" 
                           value="{{ request('to_date') }}" 
                           class="mt-1 block w-40 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
                </div>

                <!-- Status Dropdown -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" 
                            class="mt-1 block w-32 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="" {{ request('status') == '' ? 'selected' : '' }}>All</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    </select>
                </div>

                <!-- Filter Button -->
                <div class="self-end">
                    <button type="submit" 
                            class="bg-[#8D85EC] hover:bg-[#7b76e4] text-white px-4 py-2 rounded-md text-sm font-medium">
                        Filter
                    </button>
                    <!-- Reset Button -->
    <a href="{{ route('admin.reports.adminbooking') }}" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded text-sm font-medium">
        Reset
    </a>
                </div>
            </form>
        </div>

        <!-- Table Container -->
        <div class="overflow-x-auto bg-white rounded-lg shadow-md p-4">
            <table class="w-full text-sm border border-black border-collapse">
                <thead class="bg-[#8D85EC] text-white">
                    <tr>
                        <th class="border border-black px-6 py-4 text-left font-semibold">Booking ID</th>
                        <th class="border border-black px-6 py-4 text-left font-semibold">User</th>
                        <th class="border border-black px-6 py-4 text-left font-semibold">Venue</th>
                        <th class="border border-black px-6 py-4 text-left font-semibold">Booking Date</th>
                        <th class="border border-black px-6 py-4 text-left font-semibold">Guests</th>
                        <th class="border border-black px-6 py-4 text-left font-semibold">Status</th>
                        <th class="border border-black px-6 py-4 text-left font-semibold">Total Price (Rs)</th>
                    </tr>
                </thead>
                @php
                $totalAmount = 0;
                @endphp
                <tbody>
                    @forelse($venueBookings as $booking)
                    @php
                        $totalAmount += $booking->total_price;
                    @endphp
                    <tr class="hover:bg-gray-50 transition">
                        <td class="border border-black px-6 py-4 text-sm">{{ $booking->id }}</td>
                        <td class="border border-black px-6 py-4 text-sm">{{ $booking->user->name}}</td>
                        <td class="border border-black px-6 py-4 text-sm">{{ $booking->venue->venue_name }}</td>
                        <td class="border border-black px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($booking->event_date)->format('Y-m-d') }}</td>
                        <td class="border border-black px-6 py-4 text-sm">{{ $booking->guests }}</td>
                        <td class="border border-black px-6 py-4 text-sm">
                            @if($booking->status === 'paid')
                            <span class="bg-green-200 text-green-800 px-3 py-1 rounded-md text-xs font-semibold">Paid</span>
                            @else
                            <span class="bg-red-200 text-red-800 px-3 py-1 rounded-md text-xs font-semibold">Unpaid</span>
                            @endif
                        </td>
                        <td class="border border-black px-6 py-4 text-sm">{{ number_format($booking->total_price, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="border border-black px-6 py-4 text-center text-gray-500">No bookings found.</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" class="border border-black px-6 py-4 font-semibold text-right">Total Amount:</td>
                        <td class="border border-black px-6 py-4 font-semibold text-green-600">{{ number_format($totalAmount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Download Button -->
        <div class="mt-4 flex justify-end">
<a href="{{ route('admin.reports.adminbooking.pdf', request()->query()) }}" class="bg-[#8D85EC] hover:bg-[#7b76e4] text-white px-4 py-2 text-sm rounded-md transition duration-200">
    Download PDF Report
</a>
 </div>
    </div>
</div>
@endsection