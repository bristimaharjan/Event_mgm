<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Booking Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f7;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            padding: 20px;
        }
        .header {
            background-color: #8D85EC;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
        }
        .content {
            margin-top: 20px;
        }
        .details {
            list-style-type: none;
            padding: 0;
            margin: 20px 0;
        }
        .details li {
            margin-bottom: 10px;
            padding: 8px 12px;
            background-color: #f1f1f1;
            border-radius: 6px;
        }
        .footer {
            font-size: 12px;
            color: #777;
            text-align: center;
            margin-top: 20px;
        }
        .highlight {
            color: #8D85EC;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Booking Confirmation</h1>
        </div>
        <div class="content">
            <p>Hello <span class="highlight">{{ $booking->user->name }}</span>,</p>

            <p>Thank you for booking a venue with us. Here are your booking details:</p>

            <ul class="details">
                <li><strong>Venue:</strong> {{ $booking->venue->venue_name }}</li>
                <li><strong>Date:</strong> {{ $booking->event_date }}</li>
                <li><strong>Total Price:</strong> Rs {{ number_format($booking->total_price, 2) }}</li>
            </ul>

            <p>We look forward to hosting your event!</p>
        </div>
        <div class="footer">
<p>&copy; <?php echo date('Y'); ?> Venue Booking. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
