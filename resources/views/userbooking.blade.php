@extends('layouts.app')

@section('title', 'Venues')
@php 
$noFooter = true; 
@endphp

@section('content')

<div class="max-w-7xl mx-auto mt-10 px-4">
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h2 class="text-3xl font-bold text-[#8d85ec] mb-6"> Venue Bookings</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead class="bg-[#8D85EC] text-white">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Booking ID</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">User</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Venue</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Booking Date</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Total Price (Rs)</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Action</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Review</th>

                    </tr>
                </thead>
                <tbody>
                    @forelse($venueBookings as $booking)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm">{{ $booking->id }}</td>
                        <td class="px-6 py-4 text-sm">{{ $booking->user->name }}</td>
                        <td class="px-6 py-4 text-sm">{{ $booking->venue->venue_name }}</td>
                        <td class="px-6 py-4 text-sm">{{ \Carbon\Carbon::parse($booking->event_date)->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 text-sm">{{ number_format($booking->total_price, 2) }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($booking->status === 'paid')
                            <span class="bg-green-200 text-green-800 px-3 py-1 rounded-md text-xs font-semibold">Paid</span>
                            @else
                            <span class="bg-red-200 text-red-800 px-3 py-1 rounded-md text-xs font-semibold">Unpaid</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($booking->status !== 'cancelled')
                            <form action="{{ route('venueBooking.cancel', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                @csrf
                                @method('DELETE') <!-- use DELETE instead of PATCH -->
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-md text-xs font-semibold hover:bg-red-600 transition">
                                    Cancel
                                </button>
                            </form>

                            @else
                            <span class="text-gray-500 text-xs font-semibold">Cancelled</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($booking->status === 'paid')
                            @if(!$booking->review)
                                <!-- Review Button -->
                                <button onclick="openReviewModal({{ $booking->id }}, '{{ $booking->venue->venue_name }}')"
                                    class="bg-[#8D85EC] text-white px-3 py-1 rounded-md text-xs font-semibold hover:bg-[#7b76e4] transition">
                                    Review
                                </button>
                            @else
                                <span class="bg-green-200 text-green-800 px-3 py-1 rounded-md text-xs font-semibold">
                                    Reviewed
                                </span>
                            @endif
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">No bookings found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Review Modal -->
<div id="reviewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
     style="background-color: rgba(0, 0, 0, 0.6)">

    <div class="bg-white rounded-lg p-4 w-full max-w-sm shadow-lg">
        <h3 class="text-lg font-bold mb-3" id="modalVenueName"></h3>

        <form action="{{ route('venueReview.store') }}" method="POST">
            @csrf
            <input type="hidden" name="booking_id" id="reviewBookingId">

            <label class="block font-semibold mb-1 text-sm">Rating</label>
            <select name="rating" class="w-full p-1 border rounded mb-2 text-sm">
                <option value="5">⭐️⭐️⭐️⭐️⭐️</option>
                <option value="4">⭐️⭐️⭐️⭐️</option>
                <option value="3">⭐️⭐️⭐️</option>
                <option value="2">⭐️⭐️</option>
                <option value="1">⭐️</option>
            </select>

            <label class="block font-semibold mb-1 text-sm">Comment (optional)</label>
            <textarea name="comment" class="w-full p-1 border rounded mb-3 text-sm" rows="2"></textarea>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="closeReviewModal()" class="px-2 py-1 bg-gray-300 rounded text-sm">
                    Cancel
                </button>
                <button class="bg-[#8D85EC] text-white px-2 py-1 rounded text-sm">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>


<script>
// Open modal function
function openReviewModal(id, venueName) {
    const modal = document.getElementById('reviewModal');
    modal.classList.remove('hidden');
    document.getElementById('reviewBookingId').value = id;
    document.getElementById('modalVenueName').innerText = "Review: " + venueName;
}

// Close modal function
function closeReviewModal() {
    const modal = document.getElementById('reviewModal');
    modal.classList.add('hidden');
}



</script>


@endsection
