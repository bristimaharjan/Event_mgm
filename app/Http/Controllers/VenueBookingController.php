<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\VenueBooking;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use App\Mail\BookingConfirmation;
use Illuminate\Support\Facades\Mail;   
use PDF;

class VenueBookingController extends Controller
{
    public function index(Request $request)
{
    $venues = Venue::all(); // Or your filtered query

    // Optional: only get booked dates for a selected venue if filtering
    $selectedVenueId = $request->venue_id ?? null;

    $bookedDates = [];

    if ($selectedVenueId) {
        $bookedDates = VenueBooking::where('venue_id', $selectedVenueId)
            ->pluck('event_date')
            ->map(fn($date) => Carbon::parse($date)->format('Y-m-d'))
            ->toArray();
    }

    return view('venues.index', compact('venues', 'bookedDates'));
}

public function getBookedDates(Venue $venue)
{
    $dates = VenueBooking::where('venue_id', $venue->id)
                ->pluck('event_date')
                ->map(fn($d) => \Carbon\Carbon::parse($d)->format('Y-m-d'))
                ->toArray();
    return response()->json(['bookedDates' => $dates]);
}

    // Store booking
    public function store(Request $request)
    {
        $request->validate([
            'venue_id' => 'required|exists:venues,id',
            'event_date' => 'required|date|after:today',
            'guests' => 'required|integer|min:1',
        ]);

            try {
        $booking = VenueBooking::create([
            'user_id' => auth()->id(),
            'venue_id' => $request->venue_id,
            'event_date' => $request->event_date,
            'guests' => $request->guests,
            'total_price' =>  $request->input('total_price', 0),
            'status' => 'unpaid',
        ]);

        // Send confirmation email
        Mail::to($booking->user->email)->send(new BookingConfirmation($booking));

    } catch (QueryException $e) {
        return redirect()->back()->with('error', 'This date is already booked for the selected venue.');
    }

    return redirect()->back()->with('success', 'Venue booked successfully! A confirmation email has been sent.');
}
public function markAsPaid($id)
{
    $booking = VenueBooking::findOrFail($id);
    $booking->status = 'paid';
    $booking->save();

    return redirect()->back()->with('success', 'Booking marked as paid.');
}
 public function showVenues()
{
    // Fetch all venue bookings related to logged-in vendor
    $vendorId = auth()->user()->id;

    $venueBookings = VenueBooking::with(['user', 'venue','review'])
        ->whereHas('venue', function ($query) use ($vendorId) {
            $query->where('vendor_id', $vendorId);
        })
        ->get();

    // Pass the bookings to the view
    return view('vendor.venuebooking', compact('venueBookings'));
}
public function bookingReport(Request $request)
{
    $vendorId = auth()->user()->id;
    // Start query with the vendor filter
    $query = VenueBooking::with(['user', 'venue','review'])
        ->whereHas('venue', function ($q) use ($vendorId) {
            $q->where('vendor_id', $vendorId);
        });

    // Apply date filters if provided
    if ($request->filled('from_date')) {
        $query->where('event_date', '>=', $request->input('from_date'));
    }
    if ($request->filled('to_date')) {
        $query->where('event_date', '<=', $request->input('to_date'));
    }

    // Apply status filter if provided
    if ($request->filled('status') && $request->input('status') !== '') {
        $query->where('status', $request->input('status'));
    }

    // Fetch filtered bookings
    $venueBookings = $query->get();

    // Pass the bookings to the view along with the request data for preserving filter inputs
    return view('vendor.reports.booking', [
        'venueBookings' => $venueBookings,
        'request' => $request
    ]);
}
public function downloadBookingPdf(Request $request)
{
    // Assuming you get the vendor ID from the authenticated user
  
    $vendorId = auth()->user()->id;

    // Build the query with filters
    $query = VenueBooking::with(['user', 'venue','review'])
        ->whereHas('venue', function ($q) use ($vendorId) {
            $q->where('vendor_id', $vendorId);
        });
    if ($request->filled('from_date')) {
        $query->where('event_date', '>=', $request->input('from_date'));
    }
    if ($request->filled('to_date')) {
        $query->where('event_date', '<=', $request->input('to_date'));
    }
    if ($request->filled('status') && $request->input('status') !== '') {
        $query->where('status', $request->input('status'));
    }

    // Fetch only vendor-specific bookings
    $venueBookings = $query->get();

    // Generate PDF from the vendor-specific bookings
    $pdf = PDF::loadView('vendor.reports.booking_pdf', compact('venueBookings'));

    // Return the PDF download
    return $pdf->download('booking_report.pdf');
}
public function downloadAdminBookingPdf(Request $request)
{
    // Fetch the same data with filters applied, possibly with additional admin-specific filters
    $query = VenueBooking::with(['user', 'venue','review']);

    if ($request->filled('from_date')) {
        $query->where('event_date', '>=', $request->input('from_date'));
    }
    if ($request->filled('to_date')) {
        $query->where('event_date', '<=', $request->input('to_date'));
    }
    if ($request->filled('status') && $request->input('status') !== '') {
        $query->where('status', $request->input('status'));
    }

    // You might want to add admin-specific filters here if needed
    // e.g., filtering only bookings for certain admin scope

    $venueBookings = $query->get();

    // Generate PDF using a Blade view specific for admin
    $pdf = PDF::loadView('admin.reports.booking_pdf', compact('venueBookings'));

    return $pdf->download('admin_booking_report.pdf');
}
public function showReport(Request $request)
{
    // Start a query on VenueBooking with related user and venue info
    $query = VenueBooking::with(['user', 'venue','review']);

    // Apply date filters if provided
    if ($request->filled('from_date')) {
        $query->where('event_date', '>=', $request->input('from_date'));
    }
    if ($request->filled('to_date')) {
        $query->where('event_date', '<=', $request->input('to_date'));
    }

    // Apply status filter if provided
    if ($request->filled('status') && $request->input('status') !== '') {
        $query->where('status', $request->input('status'));
    }

    // Fetch filtered bookings
    $venueBookings = $query->get();

    // Pass the bookings to the view along with the request data for preserving filter inputs
    return view('admin.reports.adminbooking', [
        'venueBookings' => $venueBookings,
        'request' => $request
    ]);
} 
public function cancel($id)
{
    $booking = VenueBooking::findOrFail($id);

    // Optional: prevent deleting paid bookings
    if($booking->status === 'paid') {
        return redirect()->back()->with('error', 'Paid bookings cannot be cancelled.');
    }

    $booking->delete(); // this removes the booking from the DB

    return redirect()->back()->with('success', 'Booking cancelled successfully.');
}

}
