<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function respond(Request $request)
    {
        $message = strtolower(trim($request->input('message')));
        $reply = "I'm here to help with your event bookings!";

        if (str_contains($message, 'event')&& str_contains($message, 'book')) {
            $reply = "To book an event, click 'Book Now' on your chosen event after logging in.";
        } elseif (str_contains($message, 'event')) {
            $reply = "You can view all available events on the Events page.";
        } elseif (str_contains($message, 'payment') || str_contains($message, 'khalti')) {
            $reply = "We support secure payments via Khalti. 💳";
        } elseif (str_contains($message, 'contact')) {
            $reply = "You can reach our support team via the Contact page.";
        } elseif (str_contains($message, 'hello') || str_contains($message, 'hi')) {
            $reply = "Hi there 👋! How can I assist you today?";
        } elseif (str_contains($message, 'venue') && str_contains($message, 'book')) {
            $reply = "To book venue, click 'Book Now' on your chosen venue after logging in.";
        } elseif (str_contains($message, 'venue') ){
            $reply = "You can view all available venues on the Venues page.";
        }
        return response()->json(['reply' => $reply]);
    }
}
