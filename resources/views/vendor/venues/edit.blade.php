@extends('layouts.app')

@section('title', 'Edit Venue')
@php 
    $noNavbar = true; 
    $noFooter = true; 
@endphp
@include('vendor.sidebar')

@section('content')
<div class="ml-0 sm:ml-64 p-6 bg-gray-100 dark:bg-gray-900 min-h-screen overflow-x-hidden">

    <div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-6">

        <h2 class="text-2xl font-bold text-[#8d85ec] mb-6 text-center">Edit Venue</h2>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('vendor.venues.update', $venue->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Venue Name -->
            <div>
                <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Venue Name</label>
                <input type="text" name="venue_name" value="{{ old('venue_name', $venue->venue_name) }}"
                       class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm" required>
            </div>

            <!-- Location -->
            <div>
                <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Location</label>
                <input type="text" name="location" value="{{ old('location', $venue->location) }}"
                       class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm" required>
            </div>

            <!-- Description -->
            <div>
                <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Description</label>
                <textarea name="description" rows="3"
                          class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm" required>{{ old('description', $venue->description) }}</textarea>
            </div>

            <!-- Price Type -->
            <div>
                <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Price Type</label>
                <select name="price_type" id="price_type"
                        class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm">
                    <option value="per_person" {{ $venue->price_type == 'per_person' ? 'selected' : '' }}>Per Person</option>
                    <option value="per_day" {{ $venue->price_type == 'per_day' ? 'selected' : '' }}>Per Day</option>
                    <option value="per_hour" {{ $venue->price_type == 'per_hour' ? 'selected' : '' }}>Per Hour</option>
                    <option value="package" {{ $venue->price_type == 'package' ? 'selected' : '' }}>Package</option>
                </select>
            </div>

            <!-- Base Price -->
            <div id="price_input" class="{{ $venue->price_type == 'package' ? 'hidden' : '' }}">
                <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Price</label>
                <input type="number" name="base_price" value="{{ old('base_price', $venue->base_price) }}"
                       class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm">
            </div>

            <!-- Package Price -->
            <div id="package_price_input" class="{{ $venue->price_type == 'package' ? '' : 'hidden' }}">
                <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Package Price</label>
                <input type="number" name="package_price" value="{{ old('package_price', $venue->package_price) }}"
                       class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm">
            </div>

            <!-- Package Details -->
            <div id="package_input" class="{{ $venue->price_type != 'package' ? 'hidden' : '' }}">
                <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Package Details</label>
                <textarea name="package_details" rows="3"
                          class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm">{{ old('package_details', $venue->package_details) }}</textarea>
            </div>

            <!-- Catering Checkbox -->
            <div class="mt-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="has_catering" id="hasCatering"
                        class="rounded border-gray-300 text-purple-600 focus:ring-purple-500"
                        {{ $venue->has_catering ? 'checked' : '' }}>
                    <span class="ml-2 text-gray-700 dark:text-gray-200 text-sm">Include Catering Service</span>
                </label>
            </div>

            <!-- Catering Options -->
            <div id="cateringOptions" class="mt-3 space-y-3 {{ $venue->has_catering ? '' : 'hidden' }}">
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Catering Price (per person)</label>
                    <input type="number" name="catering_price_per_person" 
                           value="{{ old('catering_price_per_person', $venue->catering_price_per_person) }}"
                           class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm"
                           placeholder="e.g. 500" min="0">
                </div>

                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Menu Details</label>
                    <textarea name="catering_menu" rows="3"
                        class="w-full p-2 rounded-md border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 text-sm"
                        placeholder="e.g. Veg & Non-Veg buffet options, drinks included, etc.">{{ old('catering_menu', $venue->catering_menu) }}</textarea>
                </div>
            </div>

            <!-- Current Image -->
            @if($venue->image)
                <div>
                    <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Current Image</label>
                    <img src="{{ asset('uploads/' . $venue->image) }}" alt="Venue Image" class="w-32 h-32 mt-2 object-cover rounded">
                </div>
            @endif

            <!-- Image Upload -->
            <div>
                <label class="block mb-1 text-gray-700 dark:text-gray-200 text-sm">Change Image (optional)</label>
                <input type="file" name="image" class="w-full text-gray-700 dark:text-gray-200 text-sm" accept="image/*">
            </div>

            <!-- Buttons -->
            <div class="flex justify-center gap-8 mt-6">
                <button type="submit"
                        class="bg-gradient-to-r from-purple-500 to-purple-700 hover:from-purple-600 hover:to-purple-800 text-white px-4 py-2 rounded-full font-semibold shadow-md transition text-sm w-40 text-center">
                    Update Venue
                </button>

                <a href="{{ route('vendor.venues.index') }}"
                   class="bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-full font-semibold transition text-sm w-40 text-center inline-flex items-center justify-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    // Toggle base price vs package inputs dynamically
    document.getElementById('price_type').addEventListener('change', function() {
        const priceInput = document.getElementById('price_input');
        const packagePriceInput = document.getElementById('package_price_input');
        const packageInput = document.getElementById('package_input');

        if (this.value === 'package') {
            priceInput.classList.add('hidden');
            packagePriceInput.classList.remove('hidden');
            packageInput.classList.remove('hidden');
        } else {
            priceInput.classList.remove('hidden');
            packagePriceInput.classList.add('hidden');
            packageInput.classList.add('hidden');
        }
    });

    // Toggle catering fields
    document.getElementById('hasCatering').addEventListener('change', function() {
        const options = document.getElementById('cateringOptions');
        options.classList.toggle('hidden', !this.checked);
    });
</script>
@endsection
