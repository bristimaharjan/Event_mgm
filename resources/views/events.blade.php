@extends('layouts.app')

@section('title', 'Events')

@section('content')

<div class="max-w-7xl mx-auto flex gap-4 p-4 dark:bg-gray-800">
  
  <!-- Sidebar Filters -->
  <div class="w-60 bg-white p-3 rounded-lg shadow-lg sticky top-4 z-10 h-[80vh] overflow-y-auto dark:bg-gray-700">
    <h2 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Filters</h2>
    
    <!-- Date Filter -->
    <div class="mb-4">
      <button class="flex items-center justify-between w-full text-left" onclick="toggleSection('dateFilter')">
        <span class="font-semibold text-gray-700 dark:text-gray-200">Date</span>
        <svg id="icon-dateFilter" class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <div id="dateFilter" class="mt-2 hidden">
        <button class="block w-full text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white mb-2">Today</button>
        <button class="block w-full text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white mb-2">Tomorrow</button>
        <button class="block w-full text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white mb-2">This Weekend</button>
        <div class="mt-2">
          <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">From - To</label>
          <div class="flex space-x-2">
            <input type="date" class="border border-gray-300 dark:border-gray-600 rounded px-2 py-1 w-1/2" />
            <input type="date" class="border border-gray-300 dark:border-gray-600 rounded px-2 py-1 w-1/2" />
          </div>
        </div>
      </div>
    </div>
    
    <!-- Categories Filter -->
    <div class="mb-4">
      <button class="flex items-center justify-between w-full text-left" onclick="toggleSection('categoriesFilter')">
        <span class="font-semibold text-gray-700 dark:text-gray-200">Categories</span>
        <svg id="icon-categoriesFilter" class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <div id="categoriesFilter" class="mt-2 hidden">
        @php $activeCategory = request('category'); @endphp

        <a href="{{ route('events', ['category' => 'Concert']) }}"
           class="block w-full text-sm mb-2 {{ $activeCategory == 'Concert' ? 'font-bold text-blue-600' : 'text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white' }}">Concert</a>
        <a href="{{ route('events', ['category' => 'Art']) }}"
           class="block w-full text-sm mb-2 {{ $activeCategory == 'Art' ? 'font-bold text-blue-600' : 'text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white' }}">Exhibition</a>
        <a href="{{ route('events', ['category' => 'Food and Drink']) }}"
           class="block w-full text-sm mb-2 {{ $activeCategory == 'Food and Drink' ? 'font-bold text-blue-600' : 'text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white' }}">Food and Drink</a>
        <a href="{{ route('events', ['category' => 'Technology']) }}"
           class="block w-full text-sm mb-2 {{ $activeCategory == 'Technology' ? 'font-bold text-blue-600' : 'text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white' }}">Technology</a>
        <a href="{{ route('events', ['category' => 'Sports']) }}"
           class="block w-full text-sm mb-2 {{ $activeCategory == 'Sports' ? 'font-bold text-blue-600' : 'text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white' }}">Sports</a>
        <a href="{{ route('events', ['category' => 'Wellness']) }}"
           class="block w-full text-sm mb-2 {{ $activeCategory == 'Wellness' ? 'font-bold text-blue-600' : 'text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white' }}">Workshop</a>
        <a href="{{ route('events') }}"
           class="block w-full text-sm mb-2 {{ !$activeCategory ? 'font-bold text-blue-600' : 'text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white' }}">All</a>
      </div>
    </div>
    
    <!-- More Filters -->
    <div class="mb-4">
      <button class="flex items-center justify-between w-full text-left" onclick="toggleSection('moreFilters')">
        <span class="font-semibold text-gray-700 dark:text-gray-200">More Filters</span>
        <svg id="icon-moreFilters" class="w-4 h-4 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </button>
      <div id="moreFilters" class="mt-2 hidden">
        <button class="block w-full text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white mb-2">Filter 1</button>
        <button class="block w-full text-sm text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white mb-2">Filter 2</button>
      </div>
    </div>
    
    <!-- Price / Browse -->
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price</label>
      <button class="w-full bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-200 py-2 px-4 rounded mb-2">Browse by Venues</button>
    </div>
  </div>

  <!-- Events Listing with Booking Modal -->
  <div x-data="{ openBookingId: null, selectedEvent: null }" class="flex-1">
    <h2 class="text-3xl font-bold mb-4 mt-8 text-gray-900 dark:text-white">Upcoming Events</h2>

    @if($events->count() > 0)
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-8 mt-8">
        @foreach($events as $event)
          <div class="rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1 hover:scale-105 w-full bg-white dark:bg-gray-700">
              <img src="{{ asset('uploads/' . $event->image) }}" alt="{{ $event->event_name }}" class="h-60 w-full object-cover" />

              <div class="p-5 flex flex-col gap-2 text-gray-900 dark:text-gray-200">
                  <h3 class="text-lg font-bold truncate">{{ $event->event_name }}</h3>
                  <p class="text-sm truncate">{{ $event->venue }}</p>
                  <p class="text-sm line-clamp-2">{{ $event->description }}</p>
                  <p class="text-[#8d85ec] font-semibold text-sm mt-1">Price: Rs {{ number_format($event->price, 2) }}</p>
                  <p class="text-sm">Seats: <span id="seats-{{ $event->id }}">{{ $event->available_seats }}</span></p>
                  <p class="text-sm">Date: {{ \Carbon\Carbon::parse($event->event_date)->format('d M, Y') }}</p>

                  <div class="flex justify-center mt-4">
                  @guest
                      <a href="{{ route('login') }}"
                        class="bg-[#8D85EC] hover:bg-[#7b76e4] text-white font-semibold text-sm py-2 px-4 rounded-lg transition">
                          Book Now
                      </a>
                  @endguest

                  @auth
                  <button 
                    @click="openBookingId = {{ $event->id }}; selectedEvent = {{ $event->toJson() }}; showPaymentForm = false"
                    class="bg-[#8D85EC] hover:bg-[#7b76e4] text-white font-semibold text-sm py-2 px-4 rounded-lg transition">
                    Book Now
                  </button>
                  @endauth
                  </div>
              </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="text-center mt-20">
          <p class="text-gray-700 dark:text-gray-200 text-lg font-semibold">No events found.</p>
      </div>
    @endif
<!-- Booking Modal -->
<div 
    x-show="openBookingId !== null" 
    x-transition.opacity
    x-cloak
    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
    style="background-color: rgba(0, 0, 0, 0.6)"
>
    <!-- Modal Content Box -->
    <div 
        @click.away="openBookingId = null; selectedEvent = null" 
        class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-full max-w-lg border border-gray-300 dark:border-gray-700 transform transition-all duration-300"
    >
        <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white border-b border-gray-300 dark:border-gray-700 pb-2 text-center">
            Book Event: <span x-text="selectedEvent ? selectedEvent.event_name : ''"></span>
        </h2>

        <!-- Your existing modal content starts here -->
        <div x-data="{ tickets: 1, showKhaltiPopup: false, phone: '', mpin: '', paymentError: '' }">

            <!-- Tickets and Price Info -->
            <label class="block text-gray-700 dark:text-gray-200 mb-1 font-semibold">Number of Tickets</label>
            <input type="number" x-model="tickets" min="1" :max="selectedEvent ? selectedEvent.available_seats : 1"
                class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 text-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-[#8D85EC] focus:outline-none mb-4">

            <div class="bg-white dark:bg-gray-800 p-3 rounded-lg mb-4 shadow-sm border border-gray-200 dark:border-gray-700">
                <p class="text-gray-800 dark:text-gray-200 text-sm">
                    Price per ticket: Rs<span x-text="selectedEvent ? Number(selectedEvent.price).toFixed(2) : '0.00'"></span>
                </p>
                <p class="text-gray-800 dark:text-gray-200 text-sm mt-1">
                    Total amount: 
                    <span class="font-bold text-[#8D85EC] text-lg">Rs<span x-text="selectedEvent ? (tickets * Number(selectedEvent.price)).toFixed(2) : '0.00'"></span></span>
                </p>
            </div>

            <!-- Pay with Khalti Button -->
            <div class="flex justify-end gap-2 mb-4">
                <button type="button" @click="openBookingId = null; selectedEvent = null" 
                    class="px-4 py-2 rounded-lg bg-gray-300 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-400 dark:hover:bg-gray-600 transition">
                    Cancel
                </button>

                <button
                    @click="showKhaltiPopup = true"
                    class="px-4 py-2 rounded-lg text-white font-semibold transition transform hover:scale-105 active:scale-95"
                    style="background: linear-gradient(90deg, #8D85EC 0%, #A28DEC 100%); box-shadow: 0 4px 15px rgba(141, 133, 236, 0.4);">
                    Pay with Khalti
                </button>
            </div>

            <!-- Khalti Popup -->
            <div x-show="showKhaltiPopup" x-transition.opacity
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4 "
                style="background-color: rgba(0, 0, 0, 0.6)">
                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl max-w-4xl w-full overflow-hidden flex flex-col md:flex-row">

                    <!-- Left Section: Payment Summary -->
                    <div class="w-full md:w-2/3 bg-[#FAF9FC] dark:bg-gray-800 p-6 relative flex flex-col gap-6">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Payment Details</h2>
                        <p class="text-gray-600 dark:text-gray-300 text-sm">Complete your payment within <strong>30 minutes</strong></p>

                        <!-- User Info -->
                        <div class="bg-white dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm">
                            <p class="text-gray-800 dark:text-gray-200 font-semibold">Billed To:</p>
                            @auth
                                <p class="text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                                <p class="text-gray-600 dark:text-gray-300">{{ Auth::user()->email }}</p>
                            @else
                                <p class="text-gray-900 dark:text-white">Guest</p>
                                <p class="text-gray-600 dark:text-gray-300">Please log in to continue</p>
                            @endauth
                        </div>

                        <!-- Amount Summary -->
                        <div class="mt-4 bg-white dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600 shadow-md">
                            <h3 class="font-semibold text-gray-900 dark:text-gray-200 mb-3">Amount Summary</h3>
                            <div class="flex justify-between mb-2 text-gray-700 dark:text-gray-300">
                                <span>Event Price</span>
                                <span>Rs <span x-text="selectedEvent ? (tickets * Number(selectedEvent.price)).toFixed(2) : '0.00'"></span></span>
                            </div>
                            <div class="flex justify-between mb-2 text-gray-700 dark:text-gray-300">
                                <span>Service Charge</span>
                                <span>Rs 5.65</span>
                            </div>
                            <div class="border-t border-gray-200 dark:border-gray-600 my-2"></div>
                            <div class="flex justify-between font-bold text-gray-900 dark:text-white text-lg">
                                <span>Total Payable</span>
                                <span>Rs <span x-text="selectedEvent ? (tickets * Number(selectedEvent.price) + 5.65).toFixed(2) : '0.00'"></span></span>
                            </div>
                        </div>

                        <!-- Khalti Branding -->
                        <div class="absolute bottom-0 left-0 w-full bg-[#7B2CBF] text-white text-xs font-semibold py-2 text-center rounded-b-2xl">
                            PAYMENT POWERED BY <span class="ml-1 font-bold">KHALTI</span>
                        </div>
                    </div>

                    <!-- Right Section: Khalti Wallet -->
                    <div class="w-full md:w-1/3 bg-white dark:bg-gray-900 p-6 flex flex-col justify-start gap-4 relative rounded-r-2xl shadow-inner">

                        <!-- Close Button -->
                        <button @click="showKhaltiPopup=false; paymentError='';" 
                                class="absolute top-2 right-2 text-gray-500 hover:text-gray-900 dark:hover:text-white">
                            ✕
                        </button>

                        <!-- Khalti Logo -->
                        <div class="flex items-center justify-center mb-4">
                            <img src="uploads/khalti.png" alt="Khalti Logo" class="h-8">
                        </div><h3 class="text-lg font-bold text-gray-900 dark:text-white text-center">Pay via Khalti Wallet</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm text-center">Enter your Khalti ID and MPIN</p>

                        <!-- Khalti ID -->
                        <input type="text" x-model="phone" placeholder="Mobile Number"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#8D85EC] focus:border-[#8D85EC] outline-none text-gray-900 dark:text-gray-200">

                        <!-- MPIN -->
                        <input type="password" x-model="mpin" placeholder="Khalti Password/MPIN"
                            class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#8D85EC] focus:border-[#8D85EC] outline-none text-gray-900 dark:text-gray-200">
                        <p class="text-red-500 text-xs mt-1" x-text="paymentError"></p>

                        <!-- Submit Button -->
                        <button @click="
                            paymentError='';
                            let allowedPhones = ['9800000000','9800000001','9800000002','9800000003','9800000004','9800000005'];
                            if(allowedPhones.includes(phone) && mpin==='1111'){
                                alert('✅ Payment Successful!');
                                let eventToSave = {...selectedEvent};
                                selectedEvent.available_seats -= tickets;
                                showKhaltiPopup = false;
                                openBookingId = null;
                                selectedEvent = null;
                                saveBooking(eventToSave, tickets);
                            } else { paymentError='❌ Invalid Khalti ID or MPIN'; }"
                            class="mt-3 w-full py-3 rounded-lg text-white font-semibold transition transform hover:scale-[1.02] active:scale-95 focus:outline-none"
                            style="background: linear-gradient(90deg,#8D85EC 0%,#6E29B0 100%); box-shadow:0 2px 6px rgba(141,61,175,0.4);">
                            Submit
                        </button>
                    </div>

                </div>
            </div>
        </div>
        <!-- End of modal content -->
    </div>
</div>
<script>
function saveBooking(event, tickets) {
  fetch("{{ route('khalti.saveBooking') }}", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json",
      "X-CSRF-TOKEN": "{{ csrf_token() }}"
    },
    body: JSON.stringify({
      event_id: event.id,
      tickets: tickets,
      total_amount: tickets * event.price
    })
  })
  .then(async response => {
    const data = await response.json();
    if (response.ok && data.success) {
      // Update seats dynamically
      const seatEl = document.getElementById(`seats-${event.id}`);
      if (seatEl) seatEl.textContent = event.available_seats - tickets;
    //   alert("🎟️ Booking saved successfully and ticket emailed!");
    // } else {
    //   console.error("Error saving booking:", data);
    //   alert("❌ Failed to save booking. Check console for details.");
    // }
  })
  .catch(err => {
    console.error("Fetch error:", err);
    alert("⚠️ Network or server error.");
  });
}
</script>

@endsection