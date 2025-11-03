<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;



class VendorVenueController extends Controller
{
    // Show all venues for logged-in vendor
    public function index()
    {
        $venues = Venue::where('vendor_id', auth()->id())
            ->orderBy('id', 'desc')
            ->get();

        // Ensure $venues is always a collection
        if (!is_iterable($venues)) {
            $venues = collect();
        }

        return view('vendor.venues.index', compact('venues'));
    }

    // Store new venue
    public function store(Request $request)
    {
        $request->validate([
            'venue_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'price_type' => 'required|string',
            'base_price' => 'nullable|numeric',
            'package_price' => 'nullable|numeric',
            'package_details' => 'nullable|string',
            'image' => 'required|image|max:2048',
            'has_catering' => 'nullable',
            'catering_price_per_person' => 'nullable|numeric',
            'catering_menu' => 'nullable|string',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads'), $imageName);

        $venue = new Venue();
        $venue->venue_name = $request->venue_name;
        $venue->location = $request->location;
        $venue->description = $request->description;
        $venue->price_type = $request->price_type;

        if ($request->price_type === 'package') {
            $venue->package_price = $request->package_price ?? 0;
            $venue->package_details = $request->package_details;
            $venue->base_price = 0;
        } else {
            $venue->base_price = $request->base_price ?? 0;
            $venue->package_price = 0;
            $venue->package_details = null;
        }

        // Catering
        $venue->has_catering = $request->has('has_catering') ? 1 : 0;
        $venue->catering_price_per_person = $request->catering_price_per_person ?? 0;
        $venue->catering_menu = $request->catering_menu ?? null;

        $venue->image = $imageName;
        $venue->vendor_id = auth()->id();
        $venue->save();

        return redirect()->route('vendor.venues.index')
            ->with('success', 'Venue added successfully!');
    }

    // Edit venue
    public function edit(Venue $venue)
    {
        return view('vendor.venues.edit', compact('venue'));
    }

    // Update venue
    public function update(Request $request, Venue $venue)
    {
        $request->validate([
            'venue_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'price_type' => 'required|string',
            'base_price' => 'nullable|numeric',
            'package_price' => 'nullable|numeric',
            'package_details' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'has_catering' => 'nullable',
            'catering_price_per_person' => 'nullable|numeric',
            'catering_menu' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            if ($venue->image && file_exists(public_path('uploads/' . $venue->image))) {
                unlink(public_path('uploads/' . $venue->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads'), $imageName);
            $venue->image = $imageName;
        }

        $venue->venue_name = $request->venue_name;
        $venue->location = $request->location;
        $venue->description = $request->description;
        $venue->price_type = $request->price_type;

        if ($request->price_type === 'package') {
            $venue->package_price = $request->package_price ?? 0;
            $venue->package_details = $request->package_details;
            $venue->base_price = 0;
        } else {
            $venue->base_price = $request->base_price ?? 0;
            $venue->package_price = 0;
            $venue->package_details = null;
        }

        $venue->has_catering = $request->has('has_catering') ? 1 : 0;
        $venue->catering_price_per_person = $request->catering_price_per_person ?? 0;
        $venue->catering_menu = $request->catering_menu ?? null;

        $venue->save();

        return redirect()->route('vendor.venues.index')
            ->with('success', 'Venue updated successfully!');
    }

    // Delete venue
    public function destroy(Venue $venue)
    {
        if ($venue->image && file_exists(public_path('uploads/' . $venue->image))) {
            unlink(public_path('uploads/' . $venue->image));
        }

        $venue->delete();

        return redirect()->route('vendor.venues.index')
            ->with('success', 'Venue deleted successfully!');
    }
  

}
