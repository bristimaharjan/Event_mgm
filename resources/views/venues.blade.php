@extends('layouts.app')

@section('title', 'Venues')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
.flatpickr-day.disabled {
    background: #f87171 !important; 
    color: white !important;
    cursor: not-allowed;
}
</style>

<div class="max-w-7xl mx-auto px-6 py-10">

    <!-- Search Bar -->
    <div class="flex justify-center mb-8">
        <form class="flex items-center w-full max-w-xl" onsubmit="searchVenues(); return false;">
            <div class="relative w-full">
                <!-- <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div> -->
                <input type="text" id="simple-search"
                       class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#8D85EC] focus:border-[#8D85EC] block w-full pl-10 p-3"
                       placeholder="Search venue..."/>
            </div>
            <button type="submit"
                class="p-3 ml-2 text-sm font-medium rounded-lg text-white transition"
                style="background-color:#8D85EC;">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </button>
        </form>
    </div>

    <!-- Section Title -->
    <h2 class="text-2xl font-bold mb-6 text-gray-900">Venues</h2>

    @if($venues->count() > 0)
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 xl:grid-cols-4 gap-8">

        @foreach($venues as $venue)
        <div class="bg-white shadow-md rounded-xl overflow-hidden hover:shadow-lg transition duration-300 w-full">

            <!-- Image -->
            <div class="w-full h-52 overflow-hidden">
                <img src="{{ asset('uploads/' . $venue->image) }}"
                     class="w-full h-48 object-cover transition-transform duration-300 hover:scale-105"
                     alt="{{ $venue->venue_name }}">
            </div>

            <!-- Content -->
            <div class="p-5 flex flex-col gap-2">

                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $venue->venue_name }}</h3>
                <p class="text-gray-600 text-sm leading-snug">{{ Str::limit($venue->description, 80) }}</p>
                <p class="text-gray-700 text-sm">Location: {{ $venue->location }}</p>

                <!-- Pricing -->
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

                <!-- Catering -->
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

                <!-- Buttons -->
                <div class="flex gap-3 mt-4">

                    @guest
                    <a href="{{ route('login') }}"
                        class="bg-[#8D85EC] text-white w-1/2 text-center py-2 rounded-lg hover:bg-[#7b76e4]">
                        Book Now
                    </a>
                    @endguest

                    @auth
                    <button 
                        onclick="openBookingForm({{ $venue->id }}, '{{ $venue->venue_name }}', {{ $venue->price_type === 'package' ? $venue->package_price : $venue->base_price }}, '{{ $venue->price_type }}')"
                        class="bg-[#8D85EC] text-white w-1/2 py-2 rounded-lg hover:bg-[#7b76e4]">
                        Book Now
                    </button>
                    @endauth

                    <button onclick="showReviews({{ $venue->id }})"
                        class="bg-[#8D85EC] text-white w-1/2 py-2 rounded-lg hover:bg-[#7b76e4]">
                        Reviews
                    </button>
                </div>
            </div>
        </div>
        @endforeach

    </div>
    @else
        <p class="text-center text-gray-600 text-lg mt-16">No venues found!</p>
    @endif

  <!-- Booking Modal -->
    <div id="bookingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50"  style="background-color: rgba(0, 0, 0, 0.6) !important;">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-96 p-6 relative">
      <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white" id="venueNameTitle">Book Venue</h2>
      <form id="bookingForm" action="{{ route('venues.book') }}" method="POST">
        @csrf
        <input type="hidden" name="venue_id" id="venueIdInput">
        <input type="hidden" name="total_price" id="totalPriceInput" value="0">

        <div class="mb-3">
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Event Date</label>
          <input type="text" name="event_date" id="eventDate" class="w-full border border-gray-300 rounded px-3 py-2 dark:bg-gray-700 dark:text-white" required>
        </div>

        <div id="dynamicInputWrapper" class="mb-3">
          <label id="dynamicInputLabel" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Guests</label>
          <input type="number" name="guests" id="dynamicInput" min="1" class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-2 dark:bg-gray-800 dark:text-white focus:ring-2 focus:ring-purple-400 focus:outline-none transition" value="1" required>
        </div>

        <div class="mb-3">
          <p class="text-gray-800 dark:text-gray-200 text-sm">
            Total Price: <span id="totalPriceDisplay">Rs 0</span>
          </p>
        </div>

        <div class="flex justify-end gap-3 mt-4">
          <button type="button" onclick="closeBookingForm()" class="px-4 py-2 bg-[#8D85EC] text-white rounded hover:bg-[#7b76e4]">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-[#8D85EC] text-white rounded hover:bg-[#7b76e4]">Confirm</button>
        </div>
      </form>
    </div>
  </div>
<!-- Reviews Modal -->
    <div id="reviewsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50"  style="background-color: rgba(0, 0, 0, 0.6) !important;">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-xl max-h-[85vh] overflow-hidden flex flex-col relative">

        <!-- Close Button -->
        <button class="absolute top-3 right-2 md:right-4 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 text-2xl"
                onclick="closeReviews()">
            &times;
        </button>

        <!-- Header -->
        <div class="px-6 pt-6 pb-3 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white" id="venueReviewsTitle">
                Venue Reviews
            </h2>
        </div>

        <!-- Reviews Content -->
        <div id="reviewsContainer" class="space-y-4 p-6 overflow-y-auto">
            <p class="italic text-center bg-[#8D85EC] text-white p-3 rounded-lg">
                Loading reviews...
            </p>
        </div>

    </div>
</div>


</div>
<script>
  const profilePhotosUrl = "{{ asset('uploads/profile_photos') }}";
</script>
<script>
function searchVenues() {
  const input = document.getElementById('simple-search');
  const venueName = input.value.trim();
  const params = new URLSearchParams(window.location.search);
  if (venueName) {
    params.set('query', venueName);
  } else {
    params.delete('query');
  }
  window.location.search = params.toString();
}
let currentVenuePrice = 0;
let currentPriceType = 'per_person';
let flatpickrInstance = null;

function openBookingForm(venueId, venueName, price, priceType) {
  const venueInput = document.getElementById('venueIdInput');
  const venueTitle = document.getElementById('venueNameTitle');
  const dynamicInput = document.getElementById('dynamicInput');
  const dynamicLabel = document.getElementById('dynamicInputLabel');

  venueInput.value = venueId;
  venueTitle.innerText = "Book Venue: " + venueName;
  document.getElementById('bookingModal').classList.remove('hidden');

  currentVenuePrice = price;
  currentPriceType = priceType;

  // Reset input
  dynamicInput.value = 1;
  dynamicInput.disabled = false;
  dynamicInput.required = true;
  dynamicInput.type = 'number';

  // Configure label and input based on priceType
  switch (priceType) {
    case 'per_person':
      dynamicLabel.innerText = "Number of Guests";
      dynamicInput.placeholder = "Enter number of guests";
      break;
    case 'per_hour':
      dynamicLabel.innerText = "Number of Hours";
      dynamicInput.placeholder = "Enter number of hours";
      break;
    case 'per_day':
      dynamicLabel.innerText = "Number of Days";
      dynamicInput.placeholder = "Enter number of days";
      break;
    case 'package':
      dynamicLabel.innerText = "Package Booking";
      dynamicInput.type = 'hidden';
      dynamicInput.value = 1;
      dynamicInput.required = false;
      break;
    default:
      dynamicLabel.innerText = "Number of Guests";
      dynamicInput.placeholder = "Enter number of guests";
  }

  // Update total price
  updateTotalPrice();

  // Listen for input changes
  dynamicInput.removeEventListener('input', updateTotalPrice);
  dynamicInput.addEventListener('input', updateTotalPrice);

  // Initialize Flatpickr with booked dates
  fetch(`/venues/${venueId}/booked-dates`)
    .then(res => res.json())
    .then(data => {
      const bookedDates = data.bookedDates || [];
      if (flatpickrInstance) flatpickrInstance.destroy();
      flatpickrInstance = flatpickr("#eventDate", {
        minDate: "today",
        dateFormat: "Y-m-d",
        disable: bookedDates,
        defaultDate: "today",
        onDayCreate: function(dObj, dStr, fp, dayElem) {
          const dateStr = fp.formatDate(dayElem.dateObj, "Y-m-d");
          if (bookedDates.includes(dateStr)) {
            dayElem.style.backgroundColor = "#f87171";
            dayElem.style.color = "#fff";
            dayElem.style.cursor = "not-allowed";
          }
        }
      });
    })
    .catch(err => console.error("Failed to fetch booked dates:", err));
}

function updateTotalPrice() {
  const dynamicInput = document.getElementById('dynamicInput');
  const count = parseInt(dynamicInput.value) || 1;
  let total = 0;

  switch (currentPriceType) {
    case 'per_person':
    case 'per_hour':
    case 'per_day':
      total = currentVenuePrice * count;
      break;
    case 'package':
      total = currentVenuePrice;
      break;
    default:
      total = currentVenuePrice;
  }

  document.getElementById('totalPriceDisplay').innerText = "Rs " + total.toLocaleString();
  document.getElementById('totalPriceInput').value = total;
}

function closeBookingForm() {
  document.getElementById('bookingModal').classList.add('hidden');
}

// Ensure total price is correct before submitting
document.getElementById('bookingForm').addEventListener('submit', function(e) {
  updateTotalPrice();
});
// Show reviews
  function showReviews(venueId) {
    document.getElementById('reviewsModal').classList.remove('hidden');
    document.getElementById('reviewsContainer').innerHTML = '<p class="text-gray-600 dark:text-gray-300">Loading reviews...</p>';

    fetch(`/venues/${venueId}/reviews`)
      .then(res => res.json())
      .then(data => {
        const container = document.getElementById('reviewsContainer');
        container.innerHTML = '';
        console.log('Reviews API response:', data);
        

        if(data.reviews.length === 0) {
          container.innerHTML = '<p class="text-gray-600 dark:text-gray-300">No reviews yet.</p>';
          return;
        }

        data.reviews.forEach(review => {
         const reviewDiv = document.createElement('div');
reviewDiv.className = 'border rounded p-5 bg-purple-100';

reviewDiv.innerHTML = `
  <div class="flex items-center space-x-3 mb-2">
<img src="${profilePhotosUrl}/${review.profile_photos}" alt="${review.user_name}" class="w-8 h-8 rounded-full object-cover">      <p class="font-semibold text-gray-900 dark:text-black">${review.user_name}</p>
      <div class="flex items-center space-x-1">
        ${'⭐'.repeat(review.rating)}${'☆'.repeat(5 - review.rating)}
      </div>
    </div>
  </div>
 <p class="break-words whitespace-normal bg-purple-100 text-black p-2 rounded">
  ${review.comment}
</p>
`;
          container.appendChild(reviewDiv);
        });
      })
      .catch(() => {
        document.getElementById('reviewsContainer').innerHTML = '<p class="text-gray-600 dark:text-gray-300">Failed to load reviews.</p>';
      });
  }

  function closeReviews() {
    document.getElementById('reviewsModal').classList.add('hidden');
  }
</script>
@endsection