@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<!-- Hero Section -->
<section class="relative w-full bg-[#d9d4f7] dark:bg-gray-900 h-[90vh] overflow-hidden">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between px-6 md:px-12 py-28">
        <!-- Left Content -->
        <div class="max-w-lg text-center md:text-left mb-10 md:mb-0 z-10 relative">
            <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6 text-black dark:text-white">
                About Eventify <br />
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
                Eventify is your trusted partner in crafting unforgettable experiences from weddings and corporate gatherings to concerts and festivals, we bring innovation, creativity, and passion to every event.
            </p>
            <a href="{{ route('register') }}" class="bg-[#8D85EC] dark:bg-[#a78df0] text-white px-6 py-3 rounded-lg text-lg font-semibold hover:opacity-90 transition">
                Get Started
            </a>
        </div>

        <!-- Right Image -->
        <div class="w-full md:w-1/2 flex justify-center items-center relative z-10">
            <div class="w-120 h-90 overflow-hidden shadow-lg rounded-lg">
                <img src="uploads/team.jpg" alt="Rectangle Image" class="w-full h-full object-cover" />
            </div>
        </div>
    </div>

    <!-- Bottom Wave SVG -->
    <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-[0] z-0">
        <svg class="w-full h-32" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path fill="#F5F2FF" class="dark:fill-gray-900" fill-opacity="1" d="M0,64L48,80C96,96,192,128,288,160C384,192,480,224,576,213.3C672,203,768,149,864,128C960,107,1056,117,1152,138.7C1248,160,1344,192,1392,208L1440,224L1440,320L0,320Z"></path>
        </svg>
    </div>
</section>

<!-- Mission Vision Values -->
<section class="w-full bg-[#F5F2FF] dark:bg-gray-900 py-20">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-10 text-center">
        <div class="p-8 bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition">
            <div class="text-5xl mb-4 animate-bounce">🎯</div>
            <h3 class="font-bold text-2xl mb-3 text-[#8D85EC] dark:text-[#a78df0]">Mission</h3>
            <p class="text-gray-600 dark:text-gray-300">To deliver exceptional events that inspire, connect, and leave lasting memories.</p>
        </div>
        <div class="p-8 bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition">
            <div class="text-5xl mb-4 animate-bounce">👁️</div>
            <h3 class="font-bold text-2xl mb-3 text-[#8D85EC] dark:text-[#a78df0]">Vision</h3>
            <p class="text-gray-600 dark:text-gray-300">To be the leading event management company known for creativity, precision, and impact.</p>
        </div>
        <div class="p-8 bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition">
            <div class="text-5xl mb-4 animate-bounce">💡</div>
            <h3 class="font-bold text-2xl mb-3 text-[#8D85EC] dark:text-[#a78df0]">Values</h3>
            <p class="text-gray-600 dark:text-gray-300">Integrity, teamwork, innovation, and client satisfaction are at the heart of everything we do.</p>
        </div>
    </div>
</section>

<!-- Why Choose Us with Stats -->
<section class="bg-gray-100 dark:bg-gray-800 py-20 px-6">
    <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-12 items-center">
        <div>
            <h2 class="text-4xl font-bold mb-6 text-black dark:text-white">Why Choose Eventify?</h2>
            <ul class="space-y-4 text-lg text-gray-700 dark:text-gray-300">
                <li>✔️ Experienced and creative team of professionals</li>
                <li>✔️ Client-first approach with tailored solutions</li>
                <li>✔️ Seamless execution and attention to detail</li>
                <li>✔️ 24/7 support and commitment to quality</li>
            </ul>
        </div>
        <div class="grid grid-cols-2 gap-6 text-center">
            <div class="p-6 bg-white dark:bg-gray-700 rounded-lg shadow-md transform transition duration-300 hover:scale-105 hover:shadow-xl hover:bg-purple-50 dark:hover:bg-gray-600">
                <h3 class="text-3xl font-bold text-[#8D85EC] dark:text-[#a78df0]">
                    <span class="counter" data-target="200">0</span>+
                </h3>
                <p class="text-gray-600 dark:text-gray-300">Events Managed</p>
            </div>
            <div class="p-6 bg-white dark:bg-gray-700 rounded-lg shadow-md transform transition duration-300 hover:scale-105 hover:shadow-xl hover:bg-purple-50 dark:hover:bg-gray-600">
                <h3 class="text-3xl font-bold text-[#8D85EC] dark:text-[#a78df0]">
                    <span class="counter" data-target="100">0</span>+
                </h3>
                <p class="text-gray-600 dark:text-gray-300">Corporate Clients</p>
            </div>
            <div class="p-6 bg-white dark:bg-gray-700 rounded-lg shadow-md transform transition duration-300 hover:scale-105 hover:shadow-xl hover:bg-purple-50 dark:hover:bg-gray-600">
                <h3 class="text-3xl font-bold text-[#8D85EC] dark:text-[#a78df0]">
                    <span class="counter" data-target="30">0</span>+
                </h3>
                <p class="text-gray-600 dark:text-gray-300">Team Members</p>
            </div>
            <div class="p-6 bg-white dark:bg-gray-700 rounded-lg shadow-md transform transition duration-300 hover:scale-105 hover:shadow-xl hover:bg-purple-50 dark:hover:bg-gray-600">
                <h3 class="text-3xl font-bold text-[#8D85EC] dark:text-[#a78df0]">
                    <span class="counter" data-target="98">0</span>%
                </h3>
                <p class="text-gray-600 dark:text-gray-300">Client Satisfaction</p>
            </div>
        </div>
    </div>
</section>

<script>
    // Animate counters
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        counter.innerText = '0';
        const updateCounter = () => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            const increment = Math.ceil(target / 100);
            if(count < target) {
                counter.innerText = count + increment;
                setTimeout(updateCounter, 20);
            } else {
                counter.innerText = target;
            }
        };
        updateCounter();
    });
</script>

<!-- Meet the Team -->
<section id="team" class="max-w-7xl mx-auto px-6 py-20">
    <h2 class="text-4xl font-bold mb-12 text-center text-black dark:text-white">Meet Our Team</h2>
    <div class="grid md:grid-cols-4 sm:grid-cols-2 gap-10">
        <!-- Jane Doe -->
        <div class="text-center bg-white dark:bg-gray-800 p-4 rounded-2xl shadow hover:shadow-lg transition">
            <img src="uploads/jane1.jpg" alt="CEO" class="w-full h-64 object-cover rounded-2xl shadow-lg hover:scale-105 transition">
            <h3 class="mt-4 font-bold text-lg text-gray-900 dark:text-white">Jane Doe</h3>
            <p class="text-[#8D85EC] dark:text-[#a78df0] font-medium">CEO</p>
            <p class="text-gray-600 dark:text-gray-300 mt-2 text-sm">
                Visionary leader driving Eventify’s mission to innovate event management.
            </p>
        </div>

        <!-- John Smith -->
        <div class="text-center bg-white dark:bg-gray-800 p-4 rounded-2xl shadow hover:shadow-lg transition">
            <img src="uploads/john.jpg" alt="CTO" class="w-full h-64 object-cover rounded-2xl shadow-lg hover:scale-105 transition">
            <h3 class="mt-4 font-bold text-lg text-gray-900 dark:text-white">John Smith</h3>
            <p class="text-[#8D85EC] dark:text-[#a78df0] font-medium">CTO</p>
            <p class="text-gray-600 dark:text-gray-300 mt-2 text-sm">
                Tech enthusiast leading our platform development and digital growth.
            </p>
        </div>

        <!-- Sara Lee -->
        <div class="text-center bg-white dark:bg-gray-800 p-4 rounded-2xl shadow hover:shadow-lg transition">
            <img src="uploads/Sara.jpg" alt="Marketing Manager" class="w-full h-64 object-cover rounded-2xl shadow-lg hover:scale-105 transition">
            <h3 class="mt-4 font-bold text-lg text-gray-900 dark:text-white">Sara Lee</h3>
            <p class="text-[#8D85EC] dark:text-[#a78df0] font-medium">Marketing Manager</p>
            <p class="text-gray-600 dark:text-gray-300 mt-2 text-sm">
                Creative strategist connecting Eventify with people and brands.
            </p>
        </div>

        <!-- Michael Brown -->
        <div class="text-center bg-white dark:bg-gray-800 p-4 rounded-2xl shadow hover:shadow-lg transition">
            <img src="uploads/brown.webp" alt="Project Manager" class="w-full h-64 object-cover rounded-2xl shadow-lg hover:scale-105 transition">
            <h3 class="mt-4 font-bold text-lg text-gray-900 dark:text-white">Michael Brown</h3>
            <p class="text-[#8D85EC] dark:text-[#a78df0] font-medium">Project Manager</p>
            <p class="text-gray-600 dark:text-gray-300 mt-2 text-sm">
                Detail-oriented manager ensuring flawless execution of every event.
            </p>
        </div>
    </div>
</section>
<!-- Our Journey Timeline Section -->
<section class="bg-white dark:bg-gray-900 py-16">
  <div class="max-w-6xl mx-auto px-6">
    <h2 class="text-4xl font-bold text-center text-black dark:text-white mb-12">Our Journey</h2>
    <div class="relative border-l-4 border-indigo-500 dark:border-indigo-400 ml-6">

      <!-- Step 1 -->
      <div class="mb-10 ml-6">
        <div class="absolute -left-4 w-8 h-8 rounded-full bg-indigo-500 dark:bg-indigo-400 text-white flex items-center justify-center">1</div>
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">The Idea (2024)</h3>
        <p class="text-gray-600 dark:text-gray-300 mt-2">
          Eventify was born from a simple idea — making event planning easier, more accessible, and stress-free for everyone.
        </p>
      </div>

      <!-- Step 2 -->
      <div class="mb-10 ml-6">
        <div class="absolute -left-4 w-8 h-8 rounded-full bg-indigo-500 dark:bg-indigo-400 text-white flex items-center justify-center">2</div>
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">First Steps (2025)</h3>
        <p class="text-gray-600 dark:text-gray-300 mt-2">
          We began building our platform, focusing on small events and connecting with our very first clients and partners.
        </p>
      </div>

      <!-- Step 3 -->
      <div class="mb-10 ml-6">
        <div class="absolute -left-4 w-8 h-8 rounded-full bg-indigo-500 dark:bg-indigo-400 text-white flex items-center justify-center">3</div>
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Growing Together</h3>
        <p class="text-gray-600 dark:text-gray-300 mt-2">
          As we expand, our goal is to support more weddings, corporate events, and celebrations across Nepal.
        </p>
      </div>

      <!-- Step 4 -->
      <div class="ml-6">
        <div class="absolute -left-4 w-8 h-8 rounded-full bg-indigo-500 dark:bg-indigo-400 text-white flex items-center justify-center">4</div>
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Future Ahead</h3>
        <p class="text-gray-600 dark:text-gray-300 mt-2">
          This is just the beginning — Eventify aims to become the go-to platform for every event, big or small.
        </p>
      </div>

    </div>
  </div>
</section>

<!-- FAQs Section -->
<section class="bg-gray-100 dark:bg-gray-800 py-16 px-6">
  <div class="max-w-4xl mx-auto">
    <h2 class="text-4xl font-bold text-center text-black dark:text-white mb-12">Frequently Asked Questions</h2>
    
    <!-- Accordion Container -->
    <div id="faq-accordion" class="space-y-4">
      @php
        $faqs = [
          ['question' => '💡 What services does Eventify provide?', 'answer' => 'We offer event planning, catering, décor, entertainment, and corporate event management.'],
          ['question' => '📍 Where do you operate?', 'answer' => 'We currently serve clients across Nepal, expanding soon to more regions.'],
          ['question' => '💬 How can I get in touch?', 'answer' => 'You can contact us via our website’s contact form, email, or phone number provided below.'],
          ['question' => '📝 Do you provide custom event packages?', 'answer' => 'Yes! We customize every package according to your needs, preferences, and budget.'],
        ];
      @endphp

      @foreach($faqs as $faq)
      <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
        <button class="w-full flex justify-between items-center p-4 font-medium text-left text-[#8D85EC] dark:text-[#a78df0] bg-white dark:bg-gray-700 hover:bg-purple-50 dark:hover:bg-gray-600 transition focus:outline-none focus:ring focus:ring-[#8D85EC] flex-nowrap" aria-expanded="false">
          {{ $faq['question'] }}
          <svg class="w-6 h-6 ml-2 transition-transform" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.08 1.04l-4.25 4.25a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd"></path>
          </svg>
        </button>
        <div class="max-h-0 overflow-hidden bg-gray-50 dark:bg-gray-700 transition-all duration-300">
          <div class="p-4 text-black dark:text-gray-300">
            {{ $faq['answer'] }}
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<script>
  const faqButtons = document.querySelectorAll('#faq-accordion button');
  faqButtons.forEach(button => {
    button.addEventListener('click', () => {
      const panel = button.nextElementSibling;
      const isOpen = button.getAttribute('aria-expanded') === 'true';

      faqButtons.forEach(btn => {
        btn.setAttribute('aria-expanded', 'false');
        btn.nextElementSibling.style.maxHeight = null;
        btn.querySelector('svg').classList.remove('rotate-180');
      });

      if (!isOpen) {
        button.setAttribute('aria-expanded', 'true');
        panel.style.maxHeight = panel.scrollHeight + 'px';
        button.querySelector('svg').classList.add('rotate-180');
      }
    });
  });
</script>

<!-- Call to Action -->
<section class="bg-[#F5F2FF] dark:bg-gray-900 py-20 px-6 text-center">
  <div class="max-w-4xl mx-auto">
    <h2 class="text-4xl font-bold text-black dark:text-white mb-6">Let’s Create Your Next Unforgettable Event</h2>
    <p class="mb-8 text-gray-600 dark:text-gray-300 text-lg">From intimate gatherings to grand celebrations, Eventify is here to bring your vision to life.</p>
    <a href="{{ route('contact') }}" class="bg-[#8D85EC] dark:bg-[#a78df0] text-white px-8 py-3 rounded-lg font-semibold shadow-md hover:bg-[#7a73d9] dark:hover:bg-[#7a73d9] hover:shadow-xl hover:-translate-y-1 transition-all duration-300 transform">
      Get in Touch
    </a>
  </div>
</section>

@endsection
