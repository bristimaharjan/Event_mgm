<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Models\Contact;
use App\Models\User;
use App\Models\Event;
use App\Models\Venue;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ChirpController extends Controller
{
    public function index() {
        
        $user = Auth::user();
        $chirps = $user->chirps()->orderBy('created_at', 'desc')->get();
        return view('chirps.index', compact('chirps', 'user'));
    } 

    public function adminIndex() {
        $chirps = Chirp::latest()->get();
        $user = Auth::user();
        $totalCount = User::count();
        $userCount = User::where('role', 'user')->count();
        $adminCount = User::where('role', 'admin')->count();
        $vendorCount = User::where('role', 'vendor')->count();
        return view('chirps.adminIndex', compact('chirps', 'user', 'userCount', 'adminCount','vendorCount', 'totalCount'));
    }

    public function store(Request $request){
        // validation
        $request->validate([
            'chirp' => 'required|string|max:255',
        ]);

        // save
        Chirp::create([
            'chirp' => $request->chirp,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('chirps.index');
    }

    public function edit(string $id) {
        $chirp = Chirp::findOrFail($id);

        return view('chirps.edit', compact('chirp'));
    }

    public function update(Request $request, string $id) {
        // validation
        $request->validate([
            'chirp' => 'required|string|max:255',
        ]);

        // update
        $chirp = Chirp::findOrFail($id);
        // $chirp->chirp = $request->chirp;
        // $chirp->save();

        $chirp->update([
            'chirp' => $request->chirp,
        ]);

        return redirect()->route('chirps.index');
    }

    public function destroy(string $id) {
        $chirp = Chirp::findOrFail($id);
        $chirp->delete();

        return redirect()->route('chirps.index');
    }

public function showWelcomePage()
{
    $reviews = Review::with('user')->get();
    $upcomingEvents = Event::orderBy('event_date', 'asc')->take(10)->get();

    return view('welcome', compact('reviews', 'upcomingEvents'));
}
    public function about(){
        return view('about');
    }
    
//     public function events(Request $request){
//     // Fetch the query parameter 'category' from URL
//     $category = $request->query('category');

//     // If category filter is present, filter events
//     if ($category && $category != '') {
//         $events = Event::where('category', $category)->get();
//     } else {
//         $events = Event::all();
//     }

//     return view('events', compact('events', 'category'));
// }
public function events(Request $request){
    // Fetch query parameters
    $category = $request->query('category');
    $venue = $request->query('venue');
    $startDate = $request->query('start_date');
    $endDate = $request->query('end_date');
    $minPrice = $request->query('min_price');
    $maxPrice = $request->query('max_price');

    // Start building the query
    $query = Event::query();

    // Filter by category if provided
    if ($category && $category != '') {
        $query->where('category', $category);
    }

    // Filter by venue if provided
    if ($venue && $venue != '') {
        $query->where('venue', $venue);
    }

    // Filter by date range if provided
    if ($startDate && $startDate != '') {
        $query->where('event_date', '>=', $startDate);
    }
    if ($endDate && $endDate != '') {
        $query->where('event_date', '<=', $endDate);
    }

    // Filter by price range if provided
    if ($minPrice && $minPrice != '') {
        $query->where('price', '>=', $minPrice);
    }
    if ($maxPrice && $maxPrice != '') {
        $query->where('price', '<=', $maxPrice);
    }

    // Order by event_date descending (latest first)
    $events = $query->orderBy('created_at', 'desc')->get();

    return view('events', compact('events', 'category', 'venue', 'startDate', 'endDate', 'minPrice', 'maxPrice'));
}
      // Show contact form
    
    public function contact()
{
  $vendors = User::where('role', 'vendor')->get();
 $events = Event::all(); // Fetch all events
$venues = Venue::all(); // Fetch all venues
 return view('contact', compact('vendors', 'events', 'venues'));
}
// public function storeContact(Request $request)
// {
//     // Validate input
//     $validated = $request->validate([
//         'name' => 'required|string|max:255',
//         'email' => 'required|email|max:255',
//         'phone' => 'nullable|string|max:20',
//         'message' => 'required|string',
//         'type' => 'required|string|in:general,vendor,event',
//         'vendor_id' => 'nullable|exists:users,id',
//     ]);

//     // Handle vendor_id validation
//     if ($validated['type'] === 'vendor' && empty($validated['vendor_id'])) {
//         return redirect()->back()->withErrors(['vendor_id' => 'Please select a vendor.'])->withInput();
//     }

//     // Save contact info in database
//     Contact::create($validated);

//     // Determine email recipient based on inquiry type
//     if ($validated['type'] === 'general') {
//         $recipientEmail = 'mah.bristiofficial@gmail.com'; // Your admin/support email
//     } 
//       elseif ($validated['type'] === 'vendor') {
//     // Find user with id equal to vendor_id and role 'vendor'
//     $vendorUser = User::where('id', $validated['vendor_id'])
//                       ->where('role', 'vendor') // adjust role as needed
//                       ->first();

//     $recipientEmail = $vendorUser ? $vendorUser->email : 'support@yourdomain.com';
// }  elseif ($validated['type'] === 'event') {
//     // Fetch the event and get the related vendor's email
//     $event = Event::find($request->input('event_id'));
//     if ($event && $event->vendor_id) {
//         $vendor = User::where('id', $event->vendor_id)->where('role', 'vendor')->first();
//         $recipientEmail = $vendor ? $vendor->email : 'support@yourdomain.com';
//     } else {
//         $recipientEmail = 'support@yourdomain.com'; // fallback if no vendor linked
//     }
// } elseif ($validated['type'] === 'venue') {
//     // Fetch the venue and get the related vendor's email
//     $venue = Venue::find($request->input('venue_id'));
//     if ($venue && $venue->vendor_id) {
//         $vendor = User::where('id', $venue->vendor_id)->where('role', 'vendor')->first();
//         $recipientEmail = $vendor ? $vendor->email : 'support@yourdomain.com';
//     } else {
//         $recipientEmail = 'support@yourdomain.com'; // fallback if no vendor linked
//     }
// } else {
//     $recipientEmail = 'support@yourdomain.com';
// }

//     // Prepare email data
//     $emailData = [
//         'name' => $validated['name'],
//         'email' => $validated['email'],
//         'phone' => $validated['phone'],
//         'bodymessage' => $validated['message'],
//         'type' => $validated['type'],
//     ];

//     // Send email
//     Mail::send('emails.contact', $emailData, function ($message) use ($recipientEmail, $validated) {
//         $message->to($recipientEmail)
//                 ->subject('New Contact Inquiry');
//         $message->replyTo($validated['email'], $validated['name']);
//     });

//     $message = 'Message sent successfully!';
// return redirect()->route('contact')->with('success', $message);
// }
public function storeContact(Request $request)
{
    // Validate input
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'message' => 'required|string',
        'type' => 'required|string|in:general,vendor,event,venue',
        'vendor_id' => 'nullable|exists:users,id',
        'event_id' => 'nullable|exists:events,id',
        'venue_id' => 'nullable|exists:venues,id',
    ]);

    // Handle vendor_id validation
    if ($validated['type'] === 'vendor' && empty($validated['vendor_id'])) {
        return redirect()->back()->withErrors(['vendor_id' => 'Please select a vendor.'])->withInput();
    }

    // Save contact info in database
    Contact::create($validated);

    // Determine email recipient based on inquiry type
    if ($validated['type'] === 'general') {
        $recipientEmail = 'mah.bristiofficial@gmail.com'; // Your admin/support email
    } elseif ($validated['type'] === 'vendor') {
        // Find user with id equal to vendor_id and role 'vendor'
        $vendorUser = User::where('id', $validated['vendor_id'])->where('role', 'vendor')->first();
        $recipientEmail = $vendorUser ? $vendorUser->email : 'support@yourdomain.com';
        \Log::info('Vendor type: Vendor, Email: ' . $recipientEmail);
    } elseif ($validated['type'] === 'event') {
        // Fetch the event and get the related vendor's email
        $event = Event::find($request->input('event_id'));
        if ($event && $event->vendor_id) {
            $vendor = User::where('id', $event->vendor_id)->where('role', 'vendor')->first();
            $recipientEmail = $vendor ? $vendor->email : 'support@yourdomain.com';
            \Log::info('Event type: Event, Vendor email: ' . $recipientEmail);
        } else {
            $recipientEmail = 'mah.bristiofficial@gmail.com'; // fallback if no vendor linked
            \Log::info('Event type: Event, No vendor linked');
        }
    } elseif ($validated['type'] === 'venue') {
        // Fetch the venue and get the related vendor's email
        $venue = Venue::find($request->input('venue_id'));
        \Log::info('Venue ID: ' . ($request->input('venue_id') ?? 'null'));
        if ($venue && $venue->vendor_id) {
            $vendor = User::where('id', $venue->vendor_id)->where('role', 'vendor')->first();
            $recipientEmail = $vendor ? $vendor->email : 'support@yourdomain.com';
            \Log::info('Venue type: Venue, Vendor email: ' . $recipientEmail);
        } else {
            $recipientEmail = 'mah.bristiofficial@gmail.com'; // fallback if no vendor linked
            \Log::info('Venue type: Venue, No vendor linked');
        }
    } else {
        $recipientEmail = 'support@yourdomain.com';
        \Log::info('Default fallback email');
    }

    // Prepare email data
    $emailData = [
        'name' => $validated['name'],
        'email' => $validated['email'],
        'phone' => $validated['phone'],
        'bodymessage' => $validated['message'],
        'type' => $validated['type'],
    ];

    // Send email with error handling
    try {
        \Log::info('Attempting to send email to: ' . $recipientEmail);
        Mail::send('emails.contact', $emailData, function ($message) use ($recipientEmail, $validated) {
            $message->to($recipientEmail)
                ->subject('New Contact Inquiry');
            $message->replyTo($validated['email'], $validated['name']);
        });
        \Log::info('Email sent successfully to: ' . $recipientEmail);
    } catch (\Exception $e) {
        \Log::error('Mail send error: ' . $e->getMessage());
    }

    $message = 'Message sent successfully!';
    return redirect()->route('contact')->with('success', $message);
}

    public function book(Request $request, $eventId)
    {
        $request->validate([
            'tickets' => 'required|integer|min:1',
        ]);

        $event = Event::findOrFail($eventId); // Make sure you have Event model

        if ($request->tickets > $event->available_seats) {
            return back()->with('error', 'Not enough seats available.');
        }

        $event->available_seats -= $request->tickets;
        $event->save();

        // Optionally, save booking to a separate Booking table

        return back()->with('success', 'Booking confirmed!');
    }
//     public function venues(Request $request)
// {
//     // Fetch query parameters
//     $venueName = $request->query('venue_name');
//     $startDate = $request->query('start_date');
//     $endDate = $request->query('end_date');
//     $minPrice = $request->query('min_price');
//     $maxPrice = $request->query('max_price');

//     // Start building the query
//     $query = Venue::query();

//     // Filter by venue name if provided
//     if ($venueName && $venueName != '') {
//         $query->where('venue_name', 'like', '%' . $venueName . '%');
//     }

//     // Filter by date range if applicable
//     if ($startDate && $startDate != '') {
//         $query->where('available_from', '>=', $startDate);
//     }
//     if ($endDate && $endDate != '') {
//         $query->where('available_to', '<=', $endDate);
//     }

//     // Filter by price if applicable
//     if ($minPrice && $minPrice != '') {
//         $query->where('base_price', '>=', $minPrice);
//     }
//     if ($maxPrice && $maxPrice != '') {
//         $query->where('base_price', '<=', $maxPrice);
//     }

// //     // Add ordering by 'available_from' in descending order
//    $venues = $query->orderBy('created_at', 'desc')->get();

//     return view('venues', compact('venues','venueName', 'startDate', 'endDate', 'minPrice', 'maxPrice'));
// }

public function venues(Request $request)
{
    // Fetch query parameters
    $searchTerm = $request->query('query'); // Assuming 'query' is the search input name

    $query = Venue::query();

    // If a search term is provided, filter by venue_name
    if ($searchTerm && $searchTerm != '') {
        $query->where('venue_name', 'like', '%' . $searchTerm . '%');
    }

    // You can keep other filters if needed, or remove them for simplicity

    // Fetch venues ordered by creation date
    $venues = $query->orderBy('created_at', 'desc')->get();

    // Check if the request expects JSON (AJAX) or a full page load
    if ($request->ajax() || $request->wantsJson()) {
        return response()->json($venues);
    }

    // Otherwise, return the view with venues
    return view('venues', compact('venues'));
}
}