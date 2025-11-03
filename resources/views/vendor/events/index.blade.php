@extends('layouts.app')

@section('title', 'My Events')
@php 
    $noNavbar = true; 
    $noFooter = true; 
@endphp

@section('content')
@include('vendor.sidebar')

<div class="ml-0 sm:ml-64 p-6 bg-gray-100 dark:bg-gray-900 min-h-screen overflow-x-hidden">

    <!-- Header & Add Event Button -->
    <div class="mb-6 mt-6 max-w-4xl mx-auto flex justify-between">
        <!-- Title on the left -->
        <h2 class="text-3xl font-bold text-[#8d85ec] truncate">My Events</h2>
        
        <!-- Add Event Button on the right -->
        <button id="toggleFormBtn"
                class="bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white px-5 py-2 rounded-full shadow-md flex items-center transition transform hover:-translate-y-0.5">
            <span id="toggleIcon" class="inline-block mr-2 transition-transform duration-300">+</span>
            <span id="toggleText">Add Event</span>
        </button>
    </div>

    <!-- Add Event Form -->
    <div id="addEventFormWrapper" class="max-w-xl mx-auto overflow-hidden transition-all duration-500" style="height:0">
        <div id="addEventForm" class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-5">
            <h2 class="text-xl font-bold text-[#8d85ec] mb-4 text-center">Add New Event</h2>

            <form action="{{ route('vendor.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Event Name</label>
                    <input type="text" name="event_name" value="{{ old('event_name') }}"
                           class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm" required>
                </div>

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Event Date</label>
                    <input type="date" name="event_date" value="{{ old('event_date') }}"
                           class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm" required>
                </div>

                <!-- Updated Category Dropdown -->
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Category</label>
                    <select name="category"
                            class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm" required>
                        <option value="" disabled selected>Select Category</option>
                        <option value="Concert" {{ old('category') == 'Concert' ? 'selected' : '' }}>Concert</option>
                        <option value="Art" {{ old('category') == 'Exhibition' ? 'selected' : '' }}>Exhibition</option>
                        <option value="Food & Drink" {{ old('category') == 'Food & Drink' ? 'selected' : '' }}>Food & Drink</option>
                        <option value="Technology" {{ old('category') == 'Technology' ? 'selected' : '' }}>Technology</option>
                        <option value="Sports" {{ old('category') == 'Sports' ? 'selected' : '' }}>Sports</option>
                        <option value="Wellness" {{ old('category') == 'Workshop' ? 'selected' : '' }}>Workshop</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Venue / Location</label>
                    <input type="text" name="venue" value="{{ old('venue') }}"
                           class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm" required>
                </div>

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Description</label>
                    <textarea name="description" rows="3"
                              class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm" required>{{ old('description') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Price</label>
                        <input type="number" name="price" value="{{ old('price') }}"
                               class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm" required>
                    </div>
                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Available Seats</label>
                        <input type="number" name="available_seats" value="{{ old('available_seats') }}"
                               class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm" required>
                    </div>
                </div>

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Event Photo</label>
                    <input type="file" name="image"
                           class="w-full text-gray-700 dark:text-gray-200 text-sm" accept="image/*" required>
                </div>

                <div class="flex justify-center gap-12 mt-8">
                    <button type="submit"
                            class="bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white px-4 py-2 rounded-full font-semibold shadow-md transition text-sm w-40">
                        Add Event
                    </button>
                    <button type="button" id="cancelFormBtn"
                            class="bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-full font-semibold transition text-sm w-40">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Events Grid -->
    @if($events->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-10 max-w-6xl mx-auto">
            @foreach($events as $event)
                <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1 hover:scale-105 w-full">
                    <div class="w-full h-64 overflow-hidden rounded-t-2xl">
                        <img src="{{ asset('uploads/' . $event->image) }}" 
                            alt="{{ $event->event_name }}" 
                            class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                    </div>

                    <div class="p-5 flex flex-col gap-2">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white truncate">{{ $event->event_name }}</h3>
                        <p class="text-gray-900 font-medium dark:text-gray-200 text-sm line-clamp-2">{{ $event->description }}</p>
                        <p class="text-gray-600 dark:text-gray-300 text-sm truncate">Category: {{ $event->category }}</p>
                        <p class="text-gray-600 dark:text-gray-300 text-sm truncate">Location: {{ $event->venue }}</p>
                        <p class="text-[#8d85ec] font-semibold text-sm mt-1">Price: Rs {{ number_format($event->price, 2) }}</p>
                        <p class="text-gray-700 dark:text-gray-200 text-sm">Seats: {{ $event->available_seats }}</p>
                        <p class="text-gray-700 dark:text-gray-200 text-sm">Date: {{ \Carbon\Carbon::parse($event->event_date)->format('d M, Y') }}</p>

                        <div class="flex justify-between mt-3 gap-2">
                            <a href="{{ route('vendor.events.edit', $event->id) }}"
                            class="flex-1 bg-gradient-to-r from-green-400 to-green-600 hover:from-green-500 hover:to-green-700 text-white font-semibold text-sm py-2 rounded-lg text-center transition">Edit</a>

                            <form action="{{ route('vendor.events.destroy', $event->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure?');" class="flex-1">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="w-full bg-gradient-to-r from-red-400 to-red-600 hover:from-red-500 hover:to-red-700 text-white font-semibold text-sm py-2 rounded-lg transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center mt-20">
            <p class="text-gray-700 dark:text-gray-200 text-lg font-semibold">No events found. Start by adding a new event!</p>
        </div>
    @endif

</div>

<script>
const toggleBtn = document.getElementById('toggleFormBtn');
const formWrapper = document.getElementById('addEventFormWrapper');
const toggleIcon = document.getElementById('toggleIcon');
const toggleText = document.getElementById('toggleText');
const cancelBtn = document.getElementById('cancelFormBtn');

toggleBtn.addEventListener('click', () => {
    if(formWrapper.style.height === '0px' || formWrapper.style.height === ''){
        formWrapper.style.height = formWrapper.scrollHeight + 'px';
        toggleIcon.style.transform = 'rotate(45deg)';
        toggleText.textContent = 'Close Form';
    } else {
        formWrapper.style.height = '0';
        toggleIcon.style.transform = 'rotate(0deg)';
        toggleText.textContent = 'Add Event';
    }
});

cancelBtn.addEventListener('click', () => {
    formWrapper.style.height = '0';
    toggleIcon.style.transform = 'rotate(0deg)';
    toggleText.textContent = 'Add Event';
});
</script>
@endsection
