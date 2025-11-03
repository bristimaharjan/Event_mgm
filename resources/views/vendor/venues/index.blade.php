@extends('layouts.app')

@section('title', 'My Venues')
@php 
    $noNavbar = true; 
    $noFooter = true; 
@endphp

@section('content')
@include('vendor.sidebar')

<div class="ml-0 sm:ml-64 p-6 bg-gray-100 dark:bg-gray-900 min-h-screen overflow-x-hidden">

    <!-- Header & Add Venue Button -->
    <div class="mb-6 mt-6 max-w-4xl mx-auto flex justify-between">
        <h2 class="text-3xl font-bold text-[#8d85ec] truncate">My Venues</h2>
        
        <button id="toggleFormBtn"
            class="bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white px-5 py-2 rounded-full shadow-md flex items-center transition transform hover:-translate-y-0.5">
            <span id="toggleIcon" class="inline-block mr-2 transition-transform duration-300">+</span>
            <span id="toggleText">Add Venue</span>
        </button>
    </div>

    <!-- Add Venue Form -->
    <div id="addVenueFormWrapper" class="max-w-xl mx-auto overflow-y-auto transition-all duration-500 max-h-[900px]" style="height:0">
        <div id="addVenueForm" class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-5">
            <h2 class="text-xl font-bold text-[#8d85ec] mb-4 text-center">Add New Venue</h2>

            <form action="{{ route('vendor.venues.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Venue Name</label>
                    <input type="text" name="venue_name" value="{{ old('venue_name') }}"
                        class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm" required>
                </div>

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Location</label>
                    <input type="text" name="location" value="{{ old('location') }}"
                        class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm"
                        placeholder="Enter venue location" required>
                </div>

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Description</label>
                    <textarea name="description" rows="3"
                        class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm" required>{{ old('description') }}</textarea>
                </div>
    
                 <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Pricing Type</label>
                    <select name="price_type" id="priceType" 
                        class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm" required>
                        <option value="per_day">Per Day</option>
                        <option value="per_hour">Per Hour</option>
                        <option value="per_person">Per Person</option>
                        <option value="package">Package</option>
                    </select>
                </div>

                <div id="base_price_input">
                    <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Price</label>
                    <input type="number" name="base_price" 
                        value="{{ old('base_price') }}"
                        class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm"
                        placeholder="Enter price">
                </div>
                
                <!-- Package Price -->
                <div id="package_price_input" class="hidden">
                    <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Package Price</label>
                    <input type="number" name="package_price" 
                        value="{{ old('package_price') }}"
                        class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm"
                        placeholder="Enter package price">
                </div>

                <div id="packageField" class="hidden">
                    <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Package Details</label>
                    <textarea name="package_details" rows="3"
                        class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm"
                        placeholder="Describe what's included in the package"></textarea>
                </div>

                <div class="mt-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="has_catering" id="hasCatering"
                            class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <span class="ml-2 text-gray-700 dark:text-gray-200 text-sm">Include Catering Service</span>
                    </label>
                </div>

                <div id="cateringOptions" class="hidden mt-3 space-y-3">
                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Catering Price (per person)</label>
                        <input type="number" name="catering_price_per_person"
                            class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm"
                            placeholder="e.g. 500" min="0">
                    </div>

                    <div>
                        <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Menu Details</label>
                        <textarea name="catering_menu" rows="3"
                            class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm"
                            placeholder="e.g. Veg & Non-Veg buffet options, drinks included, etc."></textarea>
                    </div>
                </div>

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Venue Image</label>
                    <input type="file" name="image" class="w-full text-gray-700 dark:text-gray-200 text-sm" accept="image/*" required>
                </div>

                <div class="flex justify-center gap-12 mt-8">
                    <button type="submit"
                        class="bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white px-4 py-2 rounded-full font-semibold shadow-md transition text-sm w-40">
                        Add Venue
                    </button>
                    <button type="button" id="cancelFormBtn"
                        class="bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-full font-semibold transition text-sm w-40">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Venues Grid -->
@if($venues->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-10 max-w-6xl mx-auto">
        @foreach($venues as $venue)
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl overflow-hidden hover:shadow-2xl transition transform hover:-translate-y-1 hover:scale-105 w-full">
                <div class="w-full h-64 overflow-hidden">
                    <img src="{{ asset('uploads/' . $venue->image) }}" 
                         alt="{{ $venue->venue_name }}" 
                         class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                </div>

                <div class="p-5 flex flex-col gap-2">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white truncate">{{ $venue->venue_name }}</h3>
                    <p class="text-gray-900 font-medium dark:text-gray-200 text-sm line-clamp-2">{{ $venue->description }}</p>
                    <p class="text-gray-600 dark:text-gray-300 text-sm truncate">Location: {{ $venue->location }}</p>
    

                    @if($venue->price_type === 'package')
                        <div class="mt-2 p-3 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <p class="text-sm text-gray-700 dark:text-gray-200">
                                🎁 <span class="font-semibold text-[#8d85ec]">Package Price:</span> 
                                Rs {{ number_format($venue->package_price ?? 0, 2) }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                Package Includes: {{ $venue->package_details ?? '-' }}
                            </p>
                        </div>
                    @else
                        <p class="text-[#8d85ec] font-semibold text-sm mt-1">
                            Price: Rs {{ number_format($venue->base_price ?? 0, 2) }} / 
                            {{ $venue->price_type === 'per_person' ? 'person' : ($venue->price_type === 'per_day' ? 'day' : 'hour') }}
                        </p>
                    @endif

                    @if($venue->has_catering)
                        <div class="mt-2 p-3 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <p class="text-sm text-gray-700 dark:text-gray-200">
                                🍽️ <span class="font-semibold text-[#8d85ec]">Catering Available</span><br>
                                Rs {{ number_format($venue->catering_price_per_person ?? 0, 2) }} per person
                            </p>
                            @if($venue->catering_menu)
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Menu: {{ $venue->catering_menu }}</p>
                            @endif
                        </div>
                    @endif

                    <div class="flex justify-between mt-3 gap-2">
                            <a href="{{ route('vendor.venues.edit', $venue->id) }}"
                            class="flex-1 bg-gradient-to-r from-green-400 to-green-600 hover:from-green-500 hover:to-green-700 text-white font-semibold text-sm py-2 rounded-lg text-center transition">Edit</a>

                            <form action="{{ route('vendor.venues.destroy', $venue->id) }}" method="POST"
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
        <p class="text-gray-700 dark:text-gray-200 text-lg font-semibold">No venues found. Start by adding a new venue!</p>
    </div>
@endif

</div>


<!-- Form Toggle Script -->
<script>
const toggleBtn = document.getElementById('toggleFormBtn');
const formWrapper = document.getElementById('addVenueFormWrapper');
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
        toggleText.textContent = 'Add Venue';
    }
});

cancelBtn.addEventListener('click', () => {
    formWrapper.style.height = '0';
    toggleIcon.style.transform = 'rotate(0deg)';
    toggleText.textContent = 'Add Venue';
});

document.getElementById('priceType').addEventListener('change', function() {
    const basePriceInput = document.getElementById('base_price_input');
    const packageDetailsInput = document.getElementById('packageField'); // corrected ID
    const packagePriceInput = document.getElementById('package_price_input');

    if(this.value === 'package') {
        basePriceInput.classList.add('hidden');
        packageDetailsInput.classList.remove('hidden'); // now it works
        packagePriceInput.classList.remove('hidden');
    } else {
        basePriceInput.classList.remove('hidden');
        packageDetailsInput.classList.add('hidden');
        packagePriceInput.classList.add('hidden');
    }
});

document.getElementById('hasCatering').addEventListener('change', function() {
                    const options = document.getElementById('cateringOptions');
                    if (this.checked) {
                        options.classList.remove('hidden');
                    } else {
                        options.classList.add('hidden');
                    }
                });

</script>
@endsection
