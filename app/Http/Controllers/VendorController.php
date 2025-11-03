<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Event;

use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public function dashboard()
    {
        $vendor = Auth::user();
        
        return view('vendor.dashboard', compact('vendor'));
    }

    public function bookings()
    {
        $vendor = Auth::user();

        $bookings = $vendor->bookings; 

        return view('vendor.bookings', compact('bookings'));
    }
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.form');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $photoPath = $request->file('photo')->store('events', 'public');

    Event::create([
        'name' => $request->name,
        'location' => $request->location,
        'description' => $request->description,
        'price' => $request->price,
        'photo' => $photoPath,
        'vendor_id' => auth()->id(),
    ]);

    return back()->with('success', 'Event added successfully!');
    }

}