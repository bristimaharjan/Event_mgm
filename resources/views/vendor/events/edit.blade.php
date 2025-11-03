@extends('layouts.app')

@section('title', 'Edit Event')
@php 
    $noNavbar = true; 
    $noFooter = true; 
@endphp
@include('vendor.sidebar')

@section('content')
<div class="ml-0 sm:ml-64 p-6 bg-gray-100 dark:bg-gray-900 min-h-screen overflow-x-hidden">

    <div class="max-w-xl mx-auto bg-white dark:bg-gray-800 shadow-lg rounded-xl p-5">

        <h2 class="text-2xl font-bold text-[#8d85ec] mb-6 text-center">Edit Event</h2>

        <form action="{{ route('vendor.events.update', $event->id) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
            @csrf
            @method('PUT')

            <!-- Event Name -->
            <div>
                <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Event Name</label>
                <input type="text" name="event_name" value="{{ old('event_name', $event->event_name) }}"
                       class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm" required>
            </div>

            <!-- Event Date -->
            <div>
                <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Event Date</label>
                <input type="date" name="event_date" 
                    value="{{ old('event_date', $event->event_date ? $event->event_date->format('Y-m-d') : '') }}"
                    class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm" required>
            </div>

            <!-- Venue / Location -->
            <div>
                <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Venue / Location</label>
                <input type="text" name="venue" value="{{ old('venue', $event->venue) }}"
                       class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm" required>
            </div>

            <!-- Category -->
            <div>
                <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Category</label>
                <select name="category" 
                        class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm" 
                        required>
                    <option value="" disabled>Select a category</option>
                    <option value="Concert" {{ old('category', $event->category) == 'Concert' ? 'selected' : '' }}>Concert</option>
                    <option value="Art" {{ old('category', $event->category) == 'Exhibition' ? 'selected' : '' }}>Exhibition</option>
                    <option value="Food & Drink" {{ old('category', $event->category) == 'Food & Drink' ? 'selected' : '' }}>Food & Drink</option>
                    <option value="Technology" {{ old('category', $event->category) == 'Technology' ? 'selected' : '' }}>Technology</option>
                    <option value="Sports" {{ old('category', $event->category) == 'Sports' ? 'selected' : '' }}>Sports</option>
                    <option value="Wellness" {{ old('category', $event->category) == 'Workshop' ? 'selected' : '' }}>Workshop</option>
                </select>
            </div>

            <!-- Description -->
            <div>
                <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Description</label>
                <textarea name="description" rows="3"
                          class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm" required>{{ old('description', $event->description) }}</textarea>
            </div>

            <!-- Price & Seats -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Price</label>
                    <input type="number" name="price" value="{{ old('price', $event->price) }}"
                           class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm" required>
                </div>
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Available Seats</label>
                    <input type="number" name="available_seats" value="{{ old('available_seats', $event->available_seats) }}"
                           class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm" required>
                </div>
            </div>

            <!-- Current Image (Optional) -->
            @if($event->image)
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Current Image</label>
                    <img src="{{ asset('uploads/' . $event->image) }}" alt="Event Image" class="w-32 h-32 mt-2 object-cover rounded">
                </div>
            @endif

            <!-- Image Upload (Optional) -->
            <div>
                <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Change Image (optional)</label>
                <input type="file" name="image" class="w-full text-gray-700 dark:text-gray-200 text-sm" accept="image/*">
            </div>

            <!-- Buttons -->
            <div class="flex justify-center gap-12 mt-8">
                <button type="submit"
                    class="bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white px-4 py-2 rounded-full font-semibold shadow-md transition text-sm w-40 text-center">
                    Update Event
                </button>

                <a href="{{ route('vendor.events.index') }}"
                    class="bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-full font-semibold transition text-sm w-40 text-center inline-flex items-center justify-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script src="//unpkg.com/alpinejs" defer></script>
@endsection
