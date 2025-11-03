<aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-6 py-6 overflow-y-auto bg-gray-200 dark:bg-gray-800">

        <!-- Profile Section -->
        <div class="flex flex-col items-center mb-8">
            <div class="relative">
                <img class="w-20 h-20 rounded-full border-4 border-[#8d85ec] object-cover" 
                src="{{ Auth::user()->profile_photo ? asset('storage/' . Auth::user()->profile_photo) : asset('uploads/avatar.jpg') }}" 
                alt="Profile Picture">

                <span class="absolute bottom-0 right-0 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></span>
            </div>
            <h2 class="mt-3 text-lg font-semibold text-gray-900 dark:text-white">
                {{ Auth::user()->name ?? 'Admin Name' }}
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 truncate max-w-[180px] text-center">
                {{ Auth::user()->email ?? 'admin@example.com' }}
            </p>

            <a href="{{ route('profile.show') }}" 
            class="mt-3 inline-block text-sm text-[#8d85ec] hover:underline">
                View Profile
            </a>
        </div>

        <!-- Sidebar Links -->
        <ul class="space-y-2 font-medium">

            <!-- Admin Panel -->
            <li>
                <a href="{{ route('chirps.adminIndex') }}" 
                   class="flex items-center p-2 rounded-lg group transition-colors duration-200 ease-in-out
                          {{ request()->routeIs('chirps.adminIndex') ? 'bg-gray-300 dark:bg-gray-700 text-[#8d85ec]' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5 text-[#8d85ec]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                    </svg>
                    <span class="ms-3">Admin Panel</span>
                </a>
            </li>

            <!-- Users -->
            <li>
                <a href="{{ route('chirps.user') }}" 
                   class="flex items-center p-2 rounded-lg group transition-colors duration-200 ease-in-out
                          {{ request()->routeIs('chirps.user') ? 'bg-gray-300 dark:bg-gray-700 text-[#8d85ec]' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5 text-[#8d85ec]" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18">
                        <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                    </svg>
                    <span class="flex-1 ms-3 whitespace-nowrap">Users</span>
                </a>
            </li>

            <!-- Review -->
            <li>
                <a href="{{ route('admin.reports.review') }}" 
                class="flex items-center p-2 rounded-lg group transition-colors duration-200 ease-in-out
                        {{ request()->routeIs('admin.reports.review') 
                                ? 'bg-gray-300 dark:bg-gray-700 text-[#8d85ec]' 
                                : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-5 h-5 text-[#8d85ec]" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5z"/>
                    </svg>
                    <span class="ms-3 flex-1 whitespace-nowrap">Review</span>
                </a>
            </li>

            <!-- Reports Dropdown -->
            <li class="relative" x-data="{ open: {{ request()->routeIs('admin.reports.admineventbooking') || request()->routeIs('admin.reports.adminbooking') ? 'true' : 'false' }} }">
                <button 
                    @click="open = !open"
                    class="flex items-center w-full p-2 rounded-lg group transition-colors duration-200 ease-in-out text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                    <svg class="w-5 h-5 text-[#8d85ec]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 6h18v2H3V6zm0 5h18v2H3v-2zm0 5h18v2H3v-2z"/>
                    </svg>
                    <span class="ms-3 flex-1 text-left whitespace-nowrap">Reports</span>
                    <svg class="w-4 h-4 ms-auto transition-transform duration-200" 
                        :class="{'rotate-90': open}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                <ul x-show="open" x-transition class="mt-2 space-y-2 pl-8">
                    <li>
                        <a href="{{ route('admin.reports.admineventbooking') }}"
                        class="flex items-center p-2 rounded-lg group transition-colors duration-200 ease-in-out
                                {{ request()->routeIs('admin.reports.admineventbooking') ? 'bg-gray-300 dark:bg-gray-700 text-[#8d85ec]' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            Event Booking Report
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reports.adminbooking') }}"
                        class="flex items-center p-2 rounded-lg group transition-colors duration-200 ease-in-out
                                {{ request()->routeIs('admin.reports.adminbooking') ? 'bg-gray-300 dark:bg-gray-700 text-[#8d85ec]' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            Venue Booking Report
                        </a>
                    </li>
                </ul>
            </li>




            <!-- Sign Out -->
            <li>
                <form action="{{ route('chirps.adminLogout') }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="flex items-center w-full p-2 rounded-lg group transition-colors duration-200 ease-in-out
                                   text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 text-left">
                        <svg class="w-5 h-5 text-[#8d85ec]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                            <g transform="scale(-1,1) translate(-512,0)">
                                <path d="M497 273L329 441c-15 15-41 4.5-41-17v-96H192c-17.7 0-32-14.3-32-32V216c0-17.7 14.3-32 32-32h96v-96c0-21.5 26-32 41-17l168 168c9.4 9.4 9.4 24.6 0 34zM160 64H96c-17.7 0-32 14.3-32 32v320c0 17.7 14.3 32 32 32h64c17.7 0 32 14.3 32 32s-14.3 32-32 32H96c-53 0-96-43-96-96V96c0-53 43-96 96-96h64c17.7 0 32 14.3 32 32s-14.3 32-32 32z"/>
                            </g>
                        </svg>
                        <span class="ms-3 flex-1 whitespace-nowrap">Sign Out</span>
                    </button>
                </form>
            </li>

        </ul>
    </div>
</aside>

<script src="//unpkg.com/alpinejs" defer></script>
