<!DOCTYPE html>
<html>
<head>
    <title>Booking Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background-color: #6a4c93;
            color: white;
            padding: 8px;
        }
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .status-unpaid {
            background-color: #f8d7da;
            color: #721c24;
            padding: 4px 8px;
            border-radius: 4px;
            display: inline-block;
        }
        .total {
            font-weight: bold;
        }
        .total-amount {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Booking Report</h2>
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
</body>
</html>