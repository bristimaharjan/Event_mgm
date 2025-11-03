@extends('layouts.app')

@section('title', 'Vendor Profile')
@php 
    $noNavbar = true; 
    $noFooter = true; 
@endphp
@include('vendor.sidebar')

@section('content')
<div x-data="{ openChange: false, openForgot: false }"> <!-- Alpine scope with two modals -->

    <div class="max-w-2xl mx-auto p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-lg mt-10">
        <h2 class="text-2xl font-bold mb-8 text-gray-900 dark:text-white text-center">My Profile</h2>

        <form action="{{ route('profile.updates') }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-8 items-center md:items-start">
            @csrf

            <!-- Left Side: Profile Photo -->
            <div class="relative flex flex-col items-center">
                <label for="profile_photo" class="cursor-pointer">
                    @if($user->profile_photo)
                        <img id="photoPreview" src="{{ asset('storage/' . $user->profile_photo) }}" 
                             alt="Profile Photo" 
                             class="w-28 h-28 sm:w-32 sm:h-32 rounded-full object-cover mb-2 transition transform hover:scale-105 shadow-md">
                    @else
                        <div id="photoPreview" class="w-28 h-28 sm:w-32 sm:h-32 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center mb-2 transition transform hover:scale-105 shadow-inner">
                            <span class="text-gray-700 dark:text-gray-200 text-sm">No Photo</span>
                        </div>
                    @endif
                </label>
                <input type="file" name="profile_photo" id="profile_photo" accept="image/*" class="hidden">
                <span class="text-sm text-gray-500 dark:text-gray-300 mt-2">Click the photo to change</span>
            </div>

            <!-- Right Side: Profile Details -->
            <div class="flex-1 space-y-6 w-full">
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1 font-semibold">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                           class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-[#8D85EC]">
                </div>

                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1 font-semibold">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                           class="w-full px-4 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-[#8D85EC]">
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" class="px-8 py-2 bg-[#8D85EC] hover:bg-[#7b76e4] text-white font-semibold rounded-lg shadow-md transition transform hover:scale-105">
                        Update Profile
                    </button>

                    <!-- Change Password Button -->
                    <button type="button" @click="openChange = true" 
                            class="px-8 py-2 bg-[#8D85EC] hover:bg-[#7b76e4] text-white font-semibold rounded-lg shadow-md transition transform hover:scale-105">
                        Change Password
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Change Password Modal -->
    <div x-show="openChange" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div @click.away="openChange = false" class="bg-white dark:bg-gray-800 p-6 rounded-2xl w-96 shadow-lg relative">
            <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Change Password</h3>
            <form action="{{ route('vendor.password.change') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="email" value="{{ $user->email }}">
                
                <!-- Current Password -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1 font-medium">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-[#8D85EC]">
                </div>
                <!-- Forgot Password Link -->
                <p class="mt-1 text-xs text-blue-600 hover:underline cursor-pointer" @click="openForgot = true; openChange = false">
                    Forgot Password?
                </p>

                <!-- New Password -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1 font-medium">New Password</label>
                    <input type="password" id="new_password" name="password" required
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-[#8D85EC]">
                </div>

                <!-- Password rules checklist -->
                <ul class="mt-2 text-xs text-gray-600 dark:text-gray-400 space-y-1" id="password-rules">
                    <li id="rule-length" class="flex items-center"><span class="w-3 h-3 mr-2 border rounded-full"></span> At least 8 characters</li>
                    <li id="rule-uppercase" class="flex items-center"><span class="w-3 h-3 mr-2 border rounded-full"></span> At least one uppercase letter</li>
                    <li id="rule-number" class="flex items-center"><span class="w-3 h-3 mr-2 border rounded-full"></span> At least one number</li>
                    <li id="rule-special" class="flex items-center"><span class="w-3 h-3 mr-2 border rounded-full"></span> At least one special character (!@#$%)</li>
                </ul>

                <!-- Confirm New Password -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 mb-1 font-medium">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="password_confirmation" required
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-[#8D85EC]">
                    <p id="password-match" class="mt-2 text-xs font-medium"></p>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button" @click="openChange = false" class="px-4 py-2 bg-gray-400 hover:bg-gray-500 text-white rounded-lg">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-[#8D85EC] hover:bg-[#7b76e4] text-white rounded-lg">Update</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Forgot Password Modal -->
    <div x-show="openForgot" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div @click.away="openForgot = false" class="bg-white dark:bg-gray-800 p-6 rounded-2xl w-96 shadow-lg relative">
            <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Forgot Password</h3>
            <form id="forgotPasswordForm" class="space-y-4">
                @csrf
                <p class="text-gray-700 dark:text-gray-300 mb-2">
                    Enter your email to receive a password reset link.
                </p>
                <input type="email" name="email" id="forgot_email" value="{{ $user->email }}" required
                    class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-[#8D85EC]">
                <p id="forgot-feedback" class="text-xs mt-1"></p>
                <div class="flex justify-end gap-2">
                    <button type="button" @click="openForgot = false" class="px-4 py-2 bg-[#8D85EC] hover:bg-[#7b76e4] text-white rounded-lg">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-[#8D85EC] hover:bg-[#7b76e4] text-white rounded-lg">Send Link</button>
                </div>
            </form>


        </div>
    </div>

</div> <!-- Alpine scope ends -->

<script>
    // Profile Photo Preview
    const profileInput = document.getElementById('profile_photo');
    const photoPreview = document.getElementById('photoPreview');

    profileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if(photoPreview.tagName === 'IMG') {
                    photoPreview.src = e.target.result;
                } else {
                    const img = document.createElement('img');
                    img.id = 'photoPreview';
                    img.src = e.target.result;
                    img.className = 'w-28 h-28 sm:w-32 sm:h-32 rounded-full object-cover mb-2 transition transform hover:scale-105 shadow-md';
                    photoPreview.replaceWith(img);
                }
            }
            reader.readAsDataURL(file);
        }
    });

    // Change Password Validation
    const newPasswordInput = document.getElementById('new_password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    const currentPasswordInput = document.getElementById('current_password');

    const rules = {
        length: document.getElementById('rule-length'),
        uppercase: document.getElementById('rule-uppercase'),
        number: document.getElementById('rule-number'),
        special: document.getElementById('rule-special')
    };

    const matchText = document.getElementById('password-match');

const currentPasswordFeedback = document.createElement('p');
currentPasswordFeedback.className = "mt-2 text-xs font-medium";
currentPasswordInput.parentNode.appendChild(currentPasswordFeedback);

// Validate new password on input
newPasswordInput.addEventListener('input', validatePassword);
confirmPasswordInput.addEventListener('input', checkMatch);

let debounceTimer; // 🕒 used for delaying the password check

currentPasswordInput.addEventListener('input', function() {
    clearTimeout(debounceTimer); // cancel previous timer if user keeps typing

    const currentPassword = currentPasswordInput.value.trim();

    if (currentPassword.length === 0) {
        currentPasswordFeedback.textContent = '';
        return;
    }

    // Show temporary "checking" message instantly
    currentPasswordFeedback.textContent = "Checking...";
    currentPasswordFeedback.className = "mt-2 text-xs font-medium text-gray-500";

    // Wait 500ms after user stops typing before sending the fetch request
    debounceTimer = setTimeout(() => {
        fetch("{{ route('vendor.password.check') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify({ current_password: currentPassword })
        })
        .then(res => res.json())
        .then(data => {
            if (data.valid) {
                currentPasswordFeedback.textContent = "Current password is correct ✅";
                currentPasswordFeedback.className = "mt-2 text-xs font-medium text-green-600";
            } else {
                currentPasswordFeedback.textContent = "Current password is incorrect ❌";
                currentPasswordFeedback.className = "mt-2 text-xs font-medium text-red-600";
            }

            validatePassword(); // revalidate new password after current password check
        })
        .catch(() => {
            currentPasswordFeedback.textContent = "Error checking password.";
            currentPasswordFeedback.className = "mt-2 text-xs font-medium text-red-600";
        });
    }, 500); // 500ms delay after typing stops
});

    function validatePassword() {
        const value = newPasswordInput.value;

        // Update rules
        updateRule(rules.length, value.length >= 8);
        updateRule(rules.uppercase, /[A-Z]/.test(value));
        updateRule(rules.number, /\d/.test(value));
        updateRule(rules.special, /[!@#$%^&*(),.?":{}|<>]/.test(value));

        // Check if new password is same as current
        if(currentPasswordInput.value && value === currentPasswordInput.value) {
            matchText.textContent = "New password cannot be the same as current ❌";
            matchText.className = "mt-2 text-xs font-medium text-red-600";
        } else {
            checkMatch();
        }
    }

    function updateRule(element, isValid) {
        const circle = element.querySelector('span');
        if (isValid) {
            circle.classList.remove('border', 'border-gray-400');
            circle.classList.add('bg-green-500');
            element.classList.add('text-green-600');
        } else {
            circle.classList.remove('bg-green-500');
            circle.classList.add('border', 'border-gray-400');
            element.classList.remove('text-green-600');
        }
    }

    function checkMatch() {
        if (confirmPasswordInput.value === "") {
            matchText.textContent = "";
            return;
        }

        if(newPasswordInput.value === currentPasswordInput.value) {
            matchText.textContent = "New password cannot be the same as current ❌";
            matchText.className = "mt-2 text-xs font-medium text-red-600";
            return;
        }

        if (newPasswordInput.value === confirmPasswordInput.value) {
            matchText.textContent = "Password match ✅";
            matchText.className = "mt-2 text-xs font-medium text-green-600";
        } else {
            matchText.textContent = "Password does not match ❌";
            matchText.className = "mt-2 text-xs font-medium text-red-600";
        }
    }

    // Prevent form submission if new password is same as current
    const changeForm = document.querySelector('form[action="{{ route('vendor.password.change') }}"]');
    changeForm.addEventListener('submit', function(e) {
        if(newPasswordInput.value === currentPasswordInput.value) {
            e.preventDefault();
            alert("New password cannot be the same as current password.");
        }
    });
const forgotForm = document.getElementById('forgotPasswordForm');
const forgotEmail = document.getElementById('forgot_email');
const forgotFeedback = document.getElementById('forgot-feedback');

forgotForm.addEventListener('submit', function(e) {
    e.preventDefault();

    // 🌟 Show immediate loading feedback
    forgotFeedback.innerHTML = `
        <span class="flex items-center gap-2 text-gray-500">
            <svg class="animate-spin h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            Sending reset link...
        </span>
    `;
    forgotFeedback.className = "text-xs mt-1 text-gray-500";

    fetch("{{ route('vendor.password.email') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        body: JSON.stringify({ email: forgotEmail.value })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status) {
            // ✅ Success message
            forgotFeedback.textContent = data.status;
            forgotFeedback.className = "text-xs mt-1 text-green-600";
        } else if (data.error) {
            // ❌ Error message from backend
            forgotFeedback.textContent = data.error;
            forgotFeedback.className = "text-xs mt-1 text-red-600";
        } else if (data.errors) {
            // ⚠️ Validation errors
            forgotFeedback.textContent = data.errors.email ? data.errors.email[0] : 'Error';
            forgotFeedback.className = "text-xs mt-1 text-red-600";
        }
    })
    .catch(() => {
        forgotFeedback.textContent = 'Something went wrong!';
        forgotFeedback.className = "text-xs mt-1 text-red-600";
    });
});

</script>

@endsection
