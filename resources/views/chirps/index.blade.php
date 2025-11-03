@extends('layouts.app')

@section('title', 'My Events')
@php $noNavbar = true;$showFooter = false; @endphp

@section('content')
@include('vendor.sidebar')

<div class="w-full mx-auto ml-0 sm:ml-64 p-6 bg-gray-100 dark:bg-gray-900 min-h-screen">

    <!-- Header & Add Event Button -->
    <div class="mb-6 flex justify-between items-center max-w-2xl mx-auto">
        <h2 class="text-3xl font-bold text-[#8d85ec]">My Events</h2>
        <button id="toggleFormBtn"
                class="bg-[#8d85ec] hover:bg-[#7a72d6] text-white px-5 py-2 rounded-full shadow-md flex items-center transition transform hover:-translate-y-0.5">
            <span id="toggleIcon" class="inline-block mr-2 transition-transform duration-300">+</span>
            <span id="toggleText">Add Event</span>
        </button>
    </div>

    <!-- Add Event Form (Initially Hidden) -->
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

                <div class="text-center">
                    <button type="submit"
                            class="bg-[#8d85ec] text-white px-4 py-2 rounded-full font-semibold hover:bg-[#7a72d6] shadow-md transition text-sm">
                        Add Event
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Events Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5 mt-6 max-w-6xl mx-auto">
        @foreach($events as $event)
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1">
          
          @if ($event->image)
              {{-- Debug: dump the image path --}}
              {{-- Uncomment below for debugging; remove in production --}}
              {{ dd($event->image) }} 
              
              {{-- Display image --}}
              <img src="{{ asset($event->image) }}" alt="{{ $event->event_name }}" class="h-40 w-full object-cover">
          @endif
          
          {{-- Removed misplaced class line --}}
          
          <div class="p-4 flex flex-col gap-1">
              <h3 class="text-lg font-bold text-gray-900 dark:text-white truncate">{{ $event->event_name }}</h3>
              <p class="text-gray-600 dark:text-gray-300 text-sm truncate">{{ $event->venue }}</p>
              <p class="text-gray-700 dark:text-gray-200 text-sm line-clamp-2">{{ $event->description }}</p>
              <p class="text-[#8d85ec] font-semibold text-sm mt-1">Price: ${{ number_format($event->price, 2) }}</p>
              <p class="text-gray-700 dark:text-gray-200 text-sm">Seats: {{ $event->available_seats }}</p>
              <p class="text-gray-700 dark:text-gray-200 text-sm">
                  Date: 
                  {{ $event->event_date ? \Carbon\Carbon::parse($event->event_date)->format('d M, Y') : 'N/A' }}
              </p>

              <div class="flex justify-between mt-2">
                  <a href="{{ route('vendor.events.edit', $event->id) }}"
                     class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition text-sm">Edit</a>
                  <form action="{{ route('vendor.events.destroy', $event->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure?');">
                      @csrf @method('DELETE')
                      <button type="submit"
                              class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition text-sm">Delete</button>
                  </form>
              </div>
          </div>
        </div>
        @endforeach
    </div>
</div>

<script>
const toggleBtn = document.getElementById('toggleFormBtn');
const formWrapper = document.getElementById('addEventFormWrapper');
const toggleIcon = document.getElementById('toggleIcon');
const toggleText = document.getElementById('toggleText');

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
</script>
@endsection