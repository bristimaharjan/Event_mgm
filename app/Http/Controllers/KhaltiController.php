<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use App\Mail\TicketMail;
use Illuminate\Support\Facades\Mail;


class KhaltiController extends Controller
{
//    public function verify(Request $request)
// {
//       dd($request->all());
//     $request->validate([
//         'payload' => 'required',
//         'tickets' => 'required|integer|min:1',
//     ]);
    
//     $payload = $request->payload;
//     $event_id = $payload['product_identity'] ?? null;
//     $khalti_token = $payload['token'] ?? null;

//     if (!$event_id || !$khalti_token) {
//         return response()->json(['success' => false, 'message' => 'Invalid payload'], 400);
//     }
    
//     $event = Event::find($event_id);
//     if (!$event) {
//         return response()->json(['success' => false, 'message' => 'Event not found'], 404);
//     }

//     $amount = $payload['amount']; // amount in paisa from Khalti

//     // Log the amount and payload for debugging
//     \Log::info('Khalti verification payload:', [
//         'amount' => $amount,
//         'payload' => $payload,
//         'tickets' => $request->tickets,
//     ]);

//     // Verify payment with Khalti API
//     $response = Http::withHeaders([
//         'Authorization' => 'Key ' . env('KHALTI_SECRET_KEY')
//     ])->post('https://dev.khalti.com/api/v2/payment/verify/', [
//         'token' => $khalti_token,
//         'amount' => $amount,
//     ]);

//     // Log response body for debugging
//     \Log::info('Khalti verification response:', ['body' => $response->body()]);

//     if (!$response->successful()) {
//         \Log::error('Khalti API error', ['status' => $response->status(), 'body' => $response->body()]);
//         return response()->json(['success' => false, 'message' => 'Payment verification failed'], 400);
//     }

//     $responseData = $response->json();

//     if (!isset($responseData['idx'])) {
//         \Log::error('Invalid verification response', ['response' => $responseData]);
//         return response()->json(['success' => false, 'message' => 'Invalid verification response'], 400);
//     }

//     // Payment verified, save booking
//     $booking = Booking::create([
//         'user_id' => auth()->id(),
//         'event_id' => $request->event_id,
//         'tickets' => $request->tickets,
//         'amount' => $request->amount,
//         'payment_id' => $verified_payment_id, // from Khalti API response
//     ]);

//     // Reduce available seats
//     $event->available_seats -= $request->tickets;
//     $event->save();

// // Send ticket email
// $user = auth()->user();
// Mail::to($user->email)->send(new TicketMail($user, $event, $request->tickets));

// return response()->json(['success' => true, 'message' => 'Payment verified, booking successful, and ticket emailed']);
// }
public function saveBooking(Request $request)
{
    // Decode JSON data manually
    $data = $request->json()->all();
    $request->merge($data);

    // Validation
    $request->validate([
        'event_id' => 'required|exists:events,id',
        'tickets' => 'required|integer|min:1',
        'total_amount' => 'required|numeric|min:0',
    ]);

    // Create booking
    $booking = new Booking();
    $booking->user_id = auth()->id();
    $booking->event_id = $request->event_id;
    $booking->tickets = $request->tickets;
    $booking->amount = $request->total_amount;
    $booking->booking_date = now();
    $booking->payment_id = 'manual_' . uniqid();
    $booking->save();

    // Reduce available seats
    $event = Event::find($request->event_id);
    if ($event) {
        $event->available_seats -= $request->tickets;
        $event->save();
    }

    // Send email confirmation
    $user = auth()->user();
    if ($user) {
        \Mail::to($user->email)->send(new \App\Mail\TicketMail($user, $event, $request->tickets));
    }

    return response()->json(['success' => true, 'message' => 'Booking saved successfully and ticket emailed']);
}


}