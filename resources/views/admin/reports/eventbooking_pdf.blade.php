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
    <h2> Event Booking Report</h2>
      <!-- Table Container -->
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
</body>
</html>