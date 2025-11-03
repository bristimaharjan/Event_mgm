<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite('resources/css/app.css') {{-- or your CSS build setup --}}
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet" />
    <style>
              /* Your custom styles */
        .brand-color { background-color: #8d85ec; }
        .brand-text { color: #8d85ec; }
        .brand-logo { font-family: 'Pacifico', cursive; }
        nav a.active { color: #8d85ec !important; font-weight: 600; }

        /* Hide scrollbar for all modern browsers */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        [x-cloak] { display: none !important; }
    </style>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>
<body class="flex flex-col min-h-screen bg-gray-50 dark:bg-gray-900 text-black dark:text-white">

    {{-- Navbar only shows if $noNavbar is not set or false --}}
    @if (!isset($noNavbar) || !$noNavbar)
        <!-- Navbar -->
        <header class="w-full bg-[#8D85EC]  dark:bg-gray-900 shadow-md">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-8 py-4">
            <!-- Logo + Title -->
            <div class="flex items-center space-x-4">
            <div class="w-12 h-12 bg-white  dark:bg-gray-700 rounded-full flex items-center justify-center overflow-hidden">
                <img src="uploads/eventicon.png" alt="E Icon" class="w-8 h-8 object-contain" />
            </div>
            <span class="text-black dark:text-white text-4xl brand-logo">Eventify</span>
            </div>
            <nav class="hidden md:flex bg-white dark:bg-gray-700 rounded-full px-8 py-3 shadow-md w-1/2 justify-center">
               <a href="{{ route('welcome') }}" 
                    class="text-black dark:text-white font-semibold hover:underline mx-4 
                    {{ request()->routeIs('welcome') || request()->is('/') ? 'active' : '' }}">
                    Home
                </a>

                <a href="{{ route('about') }}" 
                class="text-black dark:text-white font-semibold hover:underline mx-4 {{ request()->routeIs('about') ? 'active' : '' }}">
                About Us
                </a>

                <a href="{{ route('events') }}" 
                class="text-black dark:text-white font-semibold hover:underline mx-4 {{ request()->routeIs('events') ? 'active' : '' }}">
                Events
                </a>
                 <a href="{{ route('venues') }}" 
                class="text-black dark:text-white font-semibold hover:underline mx-4 {{ request()->routeIs('venues') ? 'active' : '' }}">
                Venues
                </a>

                <a href="{{ route('contact') }}" 
                class="text-black dark:text-white font-semibold hover:underline mx-4 {{ request()->routeIs('contact') ? 'active' : '' }}">
                Contact
                </a>
            </nav>

            <!-- Navbar Right Section -->
            <div class="flex items-center space-x-4 relative">
                @guest
                    <!-- When user is NOT logged in -->
                    <a href="{{ route('login') }}" class="bg-white dark:bg-gray-700 text-[#8D85EC] dark:text-white font-semibold px-5 py-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-600 transition"> Login </a> 
                    <a href="{{ route('register') }}" class="bg-[#7b76e4] text-white dark:bg-gray-700 font-semibold px-5 py-2 rounded-full hover:bg-[#6f69d9] transition"> Sign Up </a>
                @endguest

                @auth
                <div x-data="{ open: false }" class="relative">
                    <!-- Profile button -->
                    <button @click="open = !open" class="flex items-center focus:outline-none">
                        <img src="{{ Auth::user()->profile_image ?? asset('uploads/avatar.jpg') }}"
                            alt="Profile"
                            class="w-8 h-8 rounded-full border-2 border-purple-500 hover:border-purple-700 transition">
                    </button>

                    <!-- Dropdown -->
                    <div x-show="open" @click.away="open = false" 
                        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-xl py-2 z-50 transition duration-200"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform scale-95"
                        x-transition:enter-end="opacity-100 transform scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 transform scale-100"
                        x-transition:leave-end="opacity-0 transform scale-95">

                        <!-- Profile link -->
                        <a href="{{ route('profile') }}"
                          class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-purple-100 dark:hover:bg-purple-700 rounded-lg transition">
                            <svg class="w-5 h-5 mr-2 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 10a4 4 0 100-8 4 4 0 000 8zm-6 8a6 6 0 1112 0H4z"/>
                            </svg>
                            Profile
                        </a>

                        <!-- Logout button -->
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>

                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="flex items-center w-full px-4 py-2 text-gray-700 dark:text-gray-200 hover:bg-red-100 dark:hover:bg-red-700 rounded-lg transition">
                            <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 10a1 1 0 011-1h8a1 1 0 110 2H4a1 1 0 01-1-1zm9-4a1 1 0 00-1-1H4a1 1 0 100 2h7a1 1 0 001-1zm0 8a1 1 0 00-1-1H4a1 1 0 100 2h7a1 1 0 001-1z"/>
                            </svg>
                            Logout
                        </a>

                    </div>
                </div>
                @endauth

                <!-- Theme toggle button -->
                <button id="theme-toggle" class="p-2 rounded-full bg-white dark:bg-gray-700 focus:outline-none" aria-label="Toggle theme">
                    <!-- Moon icon -->
                    <svg id="icon-moon" class="w-6 h-6 text-gray-800 dark:text-gray-200" fill="currentColor" viewBox="0 0 20 20" style="display: none;">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/>
                    </svg>
                    <!-- Sun icon -->
                    <svg id="icon-sun" class="w-6 h-6 text-gray-800 dark:text-gray-200" fill="currentColor" viewBox="0 0 20 20" style="display: none;">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1z"/>
                    </svg>
                </button>
            </div>
        </div>
        </header>
    @endif
        <!-- Main Content -->
        <main class="flex-1 p-0">
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            class="max-w-4xl mx-auto mt-4 bg-green-100 text-green-800 p-4 rounded-lg relative transition duration-300">
            {{ session('success') }}
            <button @click="show = false" 
                    class="absolute top-2 right-2 text-green-800 font-bold hover:text-green-900">&times;</button>
        </div>
        @endif

        @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            class="max-w-4xl mx-auto mt-4 bg-red-100 text-red-800 p-4 rounded-lg relative transition duration-300">
            {{ session('error') }}
            <button @click="show = false" 
                    class="absolute top-2 right-2 text-red-800 font-bold hover:text-red-900">&times;</button>
        </div>
        @endif

        @yield('content')
    </main>
    @if (!isset($noFooter) || !$noFooter)
    
      <!-- Footer -->
    <footer class="bg-gray-700 dark:bg-gray-800 text-white py-16 px-4">
      <div class="max-w-7xl mx-auto grid md:grid-cols-4 gap-8 text-left">
        <!-- Logo & About -->
        <div>
          <h2 class="text-2xl font-bold mb-4">Eventify</h2>
          <p class="text-gray-400 mb-4">
            Eventify is your trusted partner for creating unforgettable weddings, corporate events, and live concerts with personalized planning, catering, and entertainment.
          </p>
          <div class="flex gap-4 mt-4">
            <a href="#" class="hover:text-[#8D85EC]"><i class="fab fa-facebook-f"></i>Facebook</a>
            <a href="#" class="hover:text-[#8D85EC]"><i class="fab fa-instagram"></i>Instagram</a>
            <a href="#" class="hover:text-[#8D85EC]"><i class="fab fa-linkedin-in"></i>LinkedIn</a>
          </div>
        </div>
        <!-- Quick Links -->
        <div>
          <h3 class="text-xl font-semibold mb-4">Quick Links</h3>
          <ul class="space-y-2">
            <li><a href="#" class="hover:text-[#8D85EC]">Home</a></li>
            <li><a href="#" class="hover:text-[#8D85EC]">Services</a></li>
            <li><a href="#" class="hover:text-[#8D85EC]">Events</a></li>
            <li><a href="#" class="hover:text-[#8D85EC]">Contact</a></li>
          </ul>
        </div>
        <!-- Services -->
        <div>
          <h3 class="text-xl font-semibold mb-4">Our Services</h3>
          <ul class="space-y-2">
            <li><a href="#" class="hover:text-[#8D85EC]">Event Planning</a></li>
            <li><a href="#" class="hover:text-[#8D85EC]">Catering & Decor</a></li>
            <li><a href="#" class="hover:text-[#8D85EC]">Entertainment</a></li>
            <li><a href="#" class="hover:text-[#8D85EC]">Corporate Events</a></li>
          </ul>
        </div>
        <!-- Contact & Newsletter -->
        <div>
          <h3 class="text-xl font-semibold mb-4">Contact Us</h3>
          <p class="text-gray-400 mb-2">123 Event Street, Kathmandu, Nepal</p>
          <p class="text-gray-400 mb-2">Email: info@eventify.com</p>
          <p class="text-gray-400 mb-4">Phone: +977 9812345678</p>
        </div>
      </div>
      <!-- Bottom Footer -->
      <div class="mt-12 border-t border-gray-700 pt-6 text-center text-gray-500 text-sm">
        © 2025 Eventify. All rights reserved. Designed with ❤️ by Eventify Team.
      </div>
    </footer>
  
     @endif
   
    <!-- Scripts for theme toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('theme-toggle');
            const moonIcon = document.getElementById('icon-moon');
            const sunIcon = document.getElementById('icon-sun');

            function updateIcons() {
                if (document.documentElement.classList.contains('dark')) {
                    moonIcon.style.display = 'none';
                    sunIcon.style.display = 'block';
                } else {
                    moonIcon.style.display = 'block';
                    sunIcon.style.display = 'none';
                }
            }

            // Initialize theme based on localStorage or prefers-color-scheme
            if (
                localStorage.getItem('color-theme') === 'dark' ||
                (!localStorage.getItem('color-theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)
            ) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            updateIcons();

            // Toggle theme on button click
            toggleBtn.addEventListener('click', () => {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
                updateIcons();
            });
        });
</script>
@include('partials.chatbot')

</body>
</html>

