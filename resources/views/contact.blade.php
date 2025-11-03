@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<section class="relative w-full bg-[#d9d4f7] dark:bg-gray-800 h-[90vh]  z-[1]">
  <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between px-6 md:px-12 py-28">
    <!-- Left Content -->
    <div class="max-w-lg text-center md:text-left mb-10 md:mb-0 z-[0] relative">
      <h1 class="text-3xl md:text-4xl font-bold leading-tight mb-4">
        Get in Touch <br />
        <span class="text-[#8D85EC] dark:text-[#a78df0]">We’re Here to Help</span>
      </h1>
      <p class="text-base md:text-lg text-gray-600 dark:text-gray-300 mb-6">
        Have questions or need assistance? Reach out to us, and our team will be happy to support you.
      </p>
      <a href="{{ route('contact') }}" class="bg-[#8D85EC] dark:bg-[#a78df0] text-white px-6 py-3 rounded-lg text-lg font-semibold hover:opacity-90 transition">Contact Us</a>
    </div>

    <!-- Image Section -->
    <div class="w-full md:w-1/2 flex justify-center items-center relative z-[0]">
      <div class="relative w-120 h-80">
        <div class="absolute top-0 left-0 w-120 h-80 rounded-lg shadow-lg">
          <img src="uploads/arch.jpg" alt="Arch Image" class="w-full h-full object-cover" />
        </div>
        <div class="absolute bottom-0 right-0 w-48 h-48 rounded-lg border-4 border-white shadow-lg transform translate-x-4 translate-y-4">
          <img src="uploads/circle.jpg" alt="Circle Image" class="w-full h-full object-cover" />
        </div>
      </div>
    </div>
  </div>

  <!-- Bottom Wave SVG -->
  <div class="absolute bottom-0 left-0 w-full leading-[0] z-0">
    <svg class="w-full h-32" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
      <path fill="#F9FAFB" fill-opacity="1" class="dark:fill-gray-900" d="M0,64L48,80C96,96,192,128,288,160C384,192,480,224,576,213.3C672,203,768,149,864,128C960,107,1056,117,1152,138.7C1248,160,1344,192,1392,208L1440,224L1440,320L0,320Z"></path>
    </svg>
  </div>
</section>

<!-- Contact Form Section -->
<div class="max-w-7xl mx-auto px-4 py-12 mb-8 bg-[#eae4f9] dark:bg-gray-600 rounded-xl shadow-lg">
  <div class="grid md:grid-cols-2 gap-8">
    <!-- Left: Contact Form -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
      <h2 class="text-2xl font-semibold mb-4">Send a Message:</h2>
      
      <form action="{{ route('contact.store') }}" method="POST" class="space-y-4" id="contactForm">
        @csrf
        <!-- Inquiry Type -->
        <div>
          <label for="type" class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-200">Inquiry Type:</label>
          <select id="type" name="type" class="w-full p-3 rounded-lg border border-gray-300 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#8D85EC]" required>
            <option value="general">General Inquiry (Admin)</option>
            <option value="vendor">Vendor Inquiry</option>
            <option value="event">Event Inquiry</option>
            <option value="venue">Venue Inquiry</option>
          </select>
        </div>

        <!-- Vendor Selection (hidden by default, shown if 'vendor' selected) -->
        <div id="vendorDiv">
          <label for="vendor_id" class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-200">Select Vendor:</label>
          <select id="vendor_id" name="vendor_id" class="w-full p-3 rounded-lg border border-gray-300 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#8D85EC]">
            <option value="">-- Select Vendor --</option>
            @foreach($vendors ?? [] as $vendor)
              <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
            @endforeach
          </select>
        </div>
        <!-- Event Selection -->
<div id="eventDiv" >
  <label for="event_id" class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-200">Select Event:</label>
  <select id="event_id" name="event_id" class="w-full p-3 rounded-lg border border-gray-300 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#8D85EC]">
    <option value="">-- Select Event --</option>
    @foreach($events ?? [] as $event)
      <option value="{{ $event->id }}">{{ $event->event_name }}</option>
    @endforeach
  </select>
</div>
<!-- Venue Selection -->
<div id="venueDiv" >
  <label for="venue_id" class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-200">Select Venue:</label>
  <select id="venue_id" name="venue_id" class="w-full p-3 rounded-lg border border-gray-300 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#8D85EC]">
    <option value="">-- Select Venue --</option>
    @foreach($venues ?? [] as $venue)
      <option value="{{ $venue->id }}">{{ $venue->venue_name }}</option>
    @endforeach
  </select>
</div>

        <!-- Name -->
        <div>
          <label for="name" class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-200">Your Name:</label>
          <input type="text" id="name" name="name" placeholder="Your Name"
            class="w-full p-3 rounded-lg border border-gray-300 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#8D85EC]" required />
        </div>

        <!-- Email -->
        <div>
          <label for="email" class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-200">Your Email:</label>
          <input type="email" id="email" name="email" placeholder="name@example.com"
            class="w-full p-3 rounded-lg border border-gray-300 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#8D85EC]" required />
        </div>

        <!-- Phone -->
        <div>
          <label for="phone" class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-200">Phone Number:</label>
          <input type="tel" id="phone" name="phone" placeholder="(+977) 9841266514"
            class="w-full p-3 rounded-lg border border-gray-300 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#8D85EC]" />
        </div>

        <!-- Message -->
        <div>
          <label for="message" class="block mb-1 text-sm font-semibold text-gray-700 dark:text-gray-200">Message:</label>
          <textarea id="message" name="message" rows="4" placeholder="Your message..."
            class="w-full p-3 rounded-lg border border-gray-300 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#8D85EC]"></textarea>
        </div>

        <!-- Submit Button -->
        <div class="mt-4">
          <button type="submit" class="w-full bg-[#8D85EC] dark:bg-[#a78df0] hover:bg-[#a78df0] text-white font-semibold py-3 px-4 rounded-lg transition duration-300">Submit</button>
        </div>
      </form>
    </div>

    <!-- Right: Contact Details + Map -->
    <div class="space-y-4">
      <!-- Contact Details Card -->
      <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
        <h3 class="text-xl font-semibold mb-4">Contact Details</h3>
        <!-- Contact info with icons -->
        <div class="flex items-center mb-2">
          <svg class="w-5 h-5 mr-2 text-[#8D85EC]" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5 14.5 7.62 14.5 9 13.38 11.5 12 11.5z" />
          </svg>
          <span>Thamel, Kathmandu, Nepal</span>
        </div>
        <div class="flex items-center mb-2">
          <svg class="w-5 h-5 mr-2 text-[#8D85EC]" fill="currentColor" viewBox="0 0 24 24">
            <path d="M21 8V7l-3 2-2-2-4 4-4-4-2 2-3-2v1l3 2 2-2 4 4 4-4 2 2 3-2z" />
          </svg>
          <span>Tel: +977-1-4453000, 4422325</span>
        </div>
        <div class="flex items-center mb-2">
          <svg class="w-5 h-5 mr-2 text-[#8D85EC]" fill="currentColor" viewBox="0 0 24 24">
            <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z" />
          </svg>
          <span>Email: info@eventify.com</span>
        </div>
        <div class="flex items-center mb-2">
          <svg class="w-5 h-5 mr-2 text-[#8D85EC]" fill="currentColor" viewBox="0 0 24 24">
            <path d="M21.71 20.29l-3-3c-.39-.39-1.02-.39-1.41 0l-1.3 1.3V17c0-3.86-3.14-7-7-7s-7 3.14-7 7v1.89l-1.3-1.3c-.39-.39-1.02-.39-1.41 0l-3 3c-.39.39-.39 1.02 0 1.41l1.3 1.3V21c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-2.29l1.3-1.3c.39-.39.39-1.02 0-1.41z" />
          </svg>
          <span>WhatsApp / Viber: 9801044333</span>
        </div>
      </div>

      <!-- Map -->
      <div class="rounded-lg overflow-hidden shadow-lg">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7064.147533277557!2d85.30712124163149!3d27.715008604712438!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb18fcb77fd4bd%3A0x58099b1deffed8d4!2sThamel%2C%20Kathmandu%2044600!5e0!3m2!1sen!2snp!4v1757670066744!5m2!1sen!2snp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
  </div>
</div>

<!-- Snackbar HTML -->
<div id="snackbar" class="hidden fixed bottom-4 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded shadow-lg z-50">
  <span id="snackbar-text"></span>
</div>

<!-- Snackbar styles -->
<style>
  #snackbar {
    transition: opacity 0.5s ease-in-out;
      z-index: 9999;
  }
  #snackbar.show {
    opacity: 1;
  }
  #snackbar.hidden {
    opacity: 0;
  }
</style>

<!-- Script to show snackbar if success message exists -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        <pre>{{ session('success') }}</pre>
      const snackbar = document.getElementById('snackbar');
      const snackbarText = document.getElementById('snackbar-text');
       snackbarText.textContent = "{{ (string) session('success') }}";

      // Show snackbar
      snackbar.classList.remove('hidden');
      snackbar.classList.add('show');

      // Hide after 3 seconds
      setTimeout(() => {
        snackbar.classList.remove('show');
        snackbar.classList.add('hidden');
      }, 3000);
    @endif
  });
</script>

<script>
  // Script to toggle vendor dropdown
  document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const vendorDiv = document.getElementById('vendorDiv');

    function toggleVendor() {
      if (typeSelect.value === 'vendor') {
        vendorDiv.classList.remove('hidden');
      } else {
        vendorDiv.classList.add('hidden');
        document.getElementById('vendor_id').value = '';
      }
    }

    // Initialize on page load
    toggleVendor();

    // Add event listener
    typeSelect.addEventListener('change', toggleVendor);

  });
  function toggleInquiryFields() {
  const type = document.getElementById('type').value;
  document.getElementById('eventDiv').classList.toggle('hidden', type !== 'event');
  document.getElementById('venueDiv').classList.toggle('hidden', type !== 'venue');

  if (type !== 'event') {
    document.getElementById('event_id').value = '';
  }
  if (type !== 'venue') {
    document.getElementById('venue_id').value = '';
  }
}

// Attach event listener
document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('type').addEventListener('change', toggleInquiryFields);
  toggleInquiryFields();
});
</script>

@endsection