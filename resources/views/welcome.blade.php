@extends('layouts.app')

@section('title', 'Home')

@section('content')

  <section class="relative w-full bg-[#d9d4f7] dark:bg-gray-800 h-[90vh] overflow-hidden">
      <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between px-6 md:px-12 py-28">
        <!-- Left Content -->
        <div class="max-w-lg text-center md:text-left mb-10 md:mb-0 z-10 relative">
          <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">
            Organize Memorable <br />
            <span class="text-[#8D85EC] dark:text-[#a78df0]">Events with Ease</span>
          </h1>
          <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
            From weddings to corporate events, we provide end-to-end event management solutions tailored to your needs.
          </p>
          <a href="{{ route('register') }}" class="bg-[#8D85EC] dark:bg-[#a78df0] text-white px-6 py-3 rounded-lg text-lg font-semibold hover:opacity-90 transition">Get Started</a>
        </div>

        <!-- Right Shapes -->
        <div class="w-full md:w-1/2 flex justify-center items-center relative z-10">
          <div class="relative">
            <div class="w-64 h-80 rounded-t-full overflow-hidden shadow-lg">
              <img src="uploads/arch.jpg" alt="Arch Image" class="w-full h-full object-cover" />
            </div>
            <div class="absolute -bottom-6 -left-6 w-28 h-28 rounded-full overflow-hidden border-4 border-white shadow-lg">
              <img src="uploads/circle.jpg" alt="Circle Image" class="w-full h-full object-cover" />
            </div>
          </div>
        </div>
      </div>

      <!-- Bottom Wave SVG -->
       <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-[0] z-0">
        <svg class="w-full h-32" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
          <path fill="#F9FAFB" fill-opacity="1" class="dark:fill-gray-900" d="M0,64L48,80C96,96,192,128,288,160C384,192,480,224,576,213.3C672,203,768,149,864,128C960,107,1056,117,1152,138.7C1248,160,1344,192,1392,208L1440,224L1440,320L0,320Z"></path>
        </svg>
      </div>
    </section>

    <!-- Features -->
    <section class="py-12 px-4 max-w-7xl mx-auto bg-white dark:bg-gray-800 text-black dark:text-white">
      <h2 class="text-3xl font-bold mb-12 text-center">Our Services</h2>
      <div class="grid md:grid-cols-3 gap-8 text-center">
        <div class="p-8 bg-[#d9d4f7] dark:bg-gray-700 rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">
          <div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center rounded-full bg-[#8D85EC]/10 text-[#8D85EC] text-3xl shadow-md">🎉</div>
          <h3 class="text-xl font-bold mb-3">Event Booking</h3>
          <p class="text-gray-600 dark:text-gray-300">Comprehensive booking services for weddings, birthdays, corporate events, and more.</p>
        </div>
        <div class="p-8 bg-[#d9d4f7] dark:bg-gray-700 rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">
          <div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center rounded-full bg-[#8D85EC]/10 text-[#8D85EC] text-3xl shadow-md">🍽</div>
          <h3 class="text-xl font-bold mb-3">Catering & Decor</h3>
          <p class="text-gray-600 dark:text-gray-300">Beautiful decor themes and catering customized for your event.</p>
        </div>
        <div class="p-8 bg-[#d9d4f7] dark:bg-gray-700 rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2">
          <div class="w-16 h-16 mx-auto mb-6 flex items-center justify-center rounded-full bg-[#8D85EC]/10 text-[#8D85EC] text-3xl shadow-md">🎶</div>
          <h3 class="text-xl font-bold mb-3">Entertainment</h3>
          <p class="text-gray-600 dark:text-gray-300">Live music, DJs, and entertainment tailored to your audience.</p>
        </div>
      </div>
    </section>


<!-- Upcoming Events Section -->
<section class="py-12 px-4 bg-gray-50 dark:bg-gray-900 max-w-7xl mx-auto relative">
  <h2 class="text-3xl font-bold mb-9 text-center text-gray-800 dark:text-gray-200">Upcoming Events</h2>
  <div class="relative">
    <!-- Scrollable container -->
    <div id="upcoming-container" class="flex space-x-6 overflow-x-auto scrollbar-hide snap-x snap-mandatory py-4">
      
      @if(isset($upcomingEvents) && $upcomingEvents->count() > 0)
        @foreach($upcomingEvents as $event)
          <!-- Dynamic Card -->
          <div class="flex-shrink-0 w-[calc(33.333%-16px)] bg-[#E6E4FF] dark:bg-gray-700 border border-[#8d85ec] rounded-lg shadow-sm snap-start transition-transform duration-300 hover:scale-105 hover:shadow-lg hover:border-[#746fd6]">
            <a href="{{ route('events', $event->id) }}">
              <img class="rounded-t-lg w-full h-48 object-cover" src="{{ asset('uploads/' . $event->image) }}" alt="{{ $event->event_name }}" />
            </a>
            <div class="p-5">
              <a href="{{ route('events', $event->id) }}">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-black dark:text-white">{{ $event->event_name }}</h5>
              </a>
              <p class="mb-3 font-normal text-black dark:text-gray-300">{{ $event->description }}</p>
              <p class="text-gray-600 dark:text-gray-300 text-sm">Category: {{ $event->category }}</p>
              <p class="text-gray-600 dark:text-gray-300 text-sm">Location: {{ $event->venue }}</p>
              <p class="text-gray-700 dark:text-gray-200 text-sm">Date: {{ \Carbon\Carbon::parse($event->event_date)->format('d M, Y') }}</p>
               <a href="events" class="inline-flex items-center px-3 py-2 mt-2 text-sm font-medium text-center text-white bg-[#8d85ec] rounded-lg hover:bg-[#746fd6] transition">
            Read more
            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
            </svg>
          </a>
            </div>
          </div>
        @endforeach
      @else
        <div class="flex-shrink-0 w-[calc(33.333%-16px)] flex items-center justify-center p-4 bg-gray-200 dark:bg-gray-800 rounded-lg">
          <p class="text-gray-700 dark:text-gray-200">No upcoming events found.</p>
        </div>
      @endif
         
    </div>
    <!-- Navigation arrows -->
    <button id="up-left-arrow" class="absolute top-1/2 left-0 transform -translate-y-1/2 -translate-x-8 bg-white dark:bg-gray-700 text-[#8d85ec] rounded-full shadow-lg p-2 hover:bg-gray-100 dark:hover:bg-gray-600 transition">&lt;</button>
    <button id="up-right-arrow" class="absolute top-1/2 right-0 transform -translate-y-1/2 translate-x-8 bg-white dark:bg-gray-700 text-[#8d85ec] rounded-full shadow-lg p-2 hover:bg-gray-100 dark:hover:bg-gray-600 transition">&gt;</button>
  </div>
</section>
<!-- Scrollbar hide CSS -->
<style>
.scrollbar-hide::-webkit-scrollbar { display: none; }
.scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<!-- JS for scrolling -->
<script>
const upcomingContainer = document.getElementById('upcoming-container');
const leftArrow = document.getElementById('up-left-arrow');
const rightArrow = document.getElementById('up-right-arrow');

const cardWidth = upcomingContainer.querySelector('div').offsetWidth + 24; // width + gap

leftArrow.addEventListener('click', () => {
  upcomingContainer.scrollBy({ left: -cardWidth, behavior: 'smooth' });
});

rightArrow.addEventListener('click', () => {
  upcomingContainer.scrollBy({ left: cardWidth, behavior: 'smooth' });
});
document.addEventListener('DOMContentLoaded', () => {
  const testimonialContainer = document.getElementById('testimonial-container');
  const leftTestArrow = document.getElementById('left-arrow');
  const rightTestArrow = document.getElementById('right-arrow');

  if (testimonialContainer && leftTestArrow && rightTestArrow) {
    const testimonialCard = testimonialContainer.querySelector('div');
    const testimonialCardStyle = window.getComputedStyle(testimonialCard);
    const gap = parseInt(testimonialCardStyle.marginRight) || 24;
    const testimonialCardWidth = testimonialCard.offsetWidth + gap;

    leftTestArrow.addEventListener('click', () => {
      testimonialContainer.scrollBy({ left: -testimonialCardWidth, behavior: 'smooth' });
    });

    rightTestArrow.addEventListener('click', () => {
      testimonialContainer.scrollBy({ left: testimonialCardWidth, behavior: 'smooth' });
    });
  }
});
</script>



<!-- Why Choose Us with Tailwind dark: support -->
<section class="relative py-20 px-4 bg-gradient-to-r from-[#d9d4f7] via-white to-[#d9d4f7] dark:from-gray-800 dark:via-gray-900 dark:to-gray-800 max-w-7xl mx-auto rounded-xl shadow-lg transition-colors duration-300">
  <div class="grid md:grid-cols-2 gap-12 items-center">
    <div>
      <h2 class="text-3xl font-bold mb-4 relative inline-block text-gray-900 dark:text-white">
        What Makes Us Unique?
        <!-- Optional underline -->
        <!-- <span class="absolute left-0 -bottom-1 w-20 h-1 bg-[#8D85EC] rounded-full"></span> -->
      </h2>
      <p class="text-gray-700 mb-8 dark:text-gray-300">
        Our experienced team ensures every event is stress-free and memorable, 
        offering customized services to fit your vision and budget.
      </p>
      <a href="#"
        class="bg-[#8D85EC] text-white px-6 py-3 rounded-lg font-semibold hover:opacity-90 transition shadow-md hover:shadow-lg transform hover:-translate-y-1">
        Learn More
      </a>
    </div>
   <div class="overflow-hidden inline-block">
  <img src="uploads/event.jpg" alt="event planning"
       class="rounded-lg shadow-xl transform hover:scale-105 transition duration-500" />
</div>
  </div>
</section>


<!-- Events Organized with Tailwind dark: support -->
<section class="py-16 px-4 max-w-7xl mx-auto bg-white dark:bg-gray-900">
  <h2 class="text-3xl font-bold mb-12 text-center text-gray-800 dark:text-white">Events We Have Organized</h2>
  <div class="space-y-16">
    <!-- Card 1 -->
    <div class="grid md:grid-cols-2 gap-8 items-center">
      <div class="overflow-hidden rounded-xl shadow-lg">
        <img class="w-full h-72 object-cover transform transition duration-500 hover:scale-110" src="uploads/wedding.jpg" alt="Wedding Event" />
      </div>
      <div>
        <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">Dream Weddings</h3>
        <p class="mb-6 text-gray-600 dark:text-gray-300">Elegant wedding ceremonies with beautiful decor, catering, and entertainment tailored to create lifelong memories.</p>
        <a href="#" class="inline-block px-6 py-2 bg-[#8D85EC] text-white rounded-lg shadow hover:opacity-90">Explore</a>
      </div>
    </div>
    <!-- Card 2 -->
    <div class="grid md:grid-cols-2 gap-8 items-center md:[&>*:first-child]:order-2">
      <div class="overflow-hidden rounded-xl shadow-lg">
        <img class="w-full h-72 object-cover transform transition duration-500 hover:scale-110" src="https://images.unsplash.com/photo-1507874457470-272b3c8d8ee2?auto=format&fit=crop&w=800&q=80" alt="Concert Event" />
      </div>
      <div>
        <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">Live Concerts</h3>
        <p class="mb-6 text-gray-600 dark:text-gray-300">High-energy concerts and music festivals, complete with stage design, sound systems, and crowd management.</p>
        <a href="#" class="inline-block px-6 py-2 bg-[#8D85EC] text-white rounded-lg shadow hover:opacity-90">Explore</a>
      </div>
    </div>
    <!-- Card 3 -->
    <div class="grid md:grid-cols-2 gap-8 items-center">
      <div class="overflow-hidden rounded-xl shadow-lg">
        <img class="w-full h-72 object-cover transform transition duration-500 hover:scale-110" src="uploads/corporate.jpg" alt="Corporate Event" />
      </div>
      <div>
        <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-white">Corporate Events</h3>
        <p class="mb-6 text-gray-600 dark:text-gray-300">Seamless corporate events, including conferences, product launches, and gala dinners, designed for maximum impact.</p>
        <a href="#" class="inline-block px-6 py-2 bg-[#8D85EC] text-white rounded-lg shadow hover:opacity-90">Explore</a>
      </div>
    </div>
  </div>
</section>
<!-- Testimonials with Tailwind dark: support -->
<section class="py-16 px-4 bg-gray-50 dark:bg-gray-900 max-w-7xl mx-auto relative">
  <h2 class="text-3xl font-bold mb-12 text-center text-gray-800 dark:text-white">Happy Clients</h2>

  <!-- Wrapper for arrows and scrollable container -->
  <div class="relative">
    <!-- Scrollable container -->
    <div id="testimonial-container" class="flex space-x-6 overflow-x-auto scrollbar-hide snap-x snap-mandatory py-4">
      @foreach($reviews as $review)
      <div class="flex-shrink-0 w-[calc(25%-18px)] p-6 bg-[#d9d4f7] dark:bg-gray-800 text-black dark:text-white rounded-xl shadow-lg 
            flex flex-col items-center text-center 
            transition-all duration-300 ease-in-out 
            hover:scale-105 hover:-translate-y-2 hover:shadow-2xl 
            hover:bg-[#9a8ff0] dark:hover:bg-gray-700 snap-start">
    <img src="{{ asset('uploads/profile_photos/' . $review->user->profile_photo) }}" alt="User Photo" class="w-20 h-20 rounded-full object-cover shadow-md mb-4 border-2 border-white dark:border-gray-300">            
    <p class="italic mb-4 break-all whitespace-normal max-h-24 overflow-y-auto">{{ $review->comment }}</p>
            <h4 class="font-semibold">{{ $review->user->name }}</h4>
        </div>
    @endforeach
      
    </div>

    <!-- Left Arrow -->
    <button id="left-arrow" class="absolute top-1/2 left-0 transform -translate-y-1/2 -translate-x-8 bg-white text-[#8D85EC] dark:bg-gray-800  rounded-full shadow-lg p-2 hover:bg-gray-600 dark:hover:bg-gray-700 transition">
      &lt;
    </button>

    <!-- Right Arrow -->
    <button id="right-arrow" class="absolute top-1/2 right-0 transform -translate-y-1/2 translate-x-8 bg-white text-[#8D85EC] dark:bg-gray-800 rounded-full shadow-lg p-2 hover:bg-gray-600 dark:hover:bg-gray-700 transition">
      &gt;
    </button>
  </div>
</section>

<!-- Flowbite JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>
</html>
@endsection