@extends('layouts.app')
@section('title', 'Reset Password')
@php 
    $noNavbar = true; 
    $noFooter = true; 
@endphp
@section('content')

<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
    <div class="w-full max-w-sm bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
        <h2 class="text-2xl font-bold mb-4 text-center text-gray-900 dark:text-white">Reset Password</h2>

        <!-- Success Message -->
        @if(session('status'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-center">
                {{ session('status') }}
            </div>
        @endif

        <!-- Validation Errors -->
        @if($errors->any())
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('vendor.password.update') }}" id="resetPasswordForm">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div>
                <label class="block text-gray-700 dark:text-gray-200 mb-1 font-medium">New Password</label>
                <input type="password" id="new_password" name="password" required
                    class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-[#8D85EC]">
            </div>

            <!-- Password rules checklist -->
            <ul class="mb-4 text-xs text-gray-600 dark:text-gray-400 space-y-1" id="password-rules">
                <li id="rule-length" class="flex items-center"><span class="w-3 h-3 mr-2 border border-gray-400 rounded-full"></span> At least 8 characters</li>
                <li id="rule-uppercase" class="flex items-center"><span class="w-3 h-3 mr-2 border border-gray-400 rounded-full"></span> At least one uppercase letter</li>
                <li id="rule-number" class="flex items-center"><span class="w-3 h-3 mr-2 border border-gray-400 rounded-full"></span> At least one number</li>
                <li id="rule-special" class="flex items-center"><span class="w-3 h-3 mr-2 border border-gray-400 rounded-full"></span> At least one special character (!@#$%)</li>
            </ul>

            <div>
                <label class="block text-gray-700 dark:text-gray-200 mb-1 font-medium">Confirm New Password</label>
                <input type="password" id="confirm_password" name="password_confirmation" required
                    class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200 focus:ring-2 focus:ring-[#8D85EC]">
                <p id="password-match" class="mt-2 text-xs font-medium"></p>
            </div>

            <button type="submit" class="w-full py-2 bg-[#8D85EC] text-white rounded-lg hover:bg-[#7b76e4]">
                Reset Password
            </button>
        </form>
    </div>
</div>

<script>
const newPasswordInput = document.getElementById('new_password');
const confirmPasswordInput = document.getElementById('confirm_password');
const rules = {
    length: document.getElementById('rule-length'),
    uppercase: document.getElementById('rule-uppercase'),
    number: document.getElementById('rule-number'),
    special: document.getElementById('rule-special')
};
const matchText = document.getElementById('password-match');

newPasswordInput.addEventListener('input', validatePassword);
confirmPasswordInput.addEventListener('input', checkMatch);

function validatePassword() {
    const value = newPasswordInput.value;

    updateRule(rules.length, value.length >= 8);
    updateRule(rules.uppercase, /[A-Z]/.test(value));
    updateRule(rules.number, /\d/.test(value));
    updateRule(rules.special, /[!@#$%^&*(),.?":{}|<>]/.test(value));

    checkMatch();
}

function updateRule(element, isValid) {
    const circle = element.querySelector('span');
    if (isValid) {
        circle.classList.remove('border', 'border-gray-400');
        circle.classList.add('bg-green-500');
        element.classList.add('text-green-600');
        element.classList.remove('text-gray-600', 'dark:text-gray-400');
    } else {
        circle.classList.remove('bg-green-500');
        circle.classList.add('border', 'border-gray-400');
        element.classList.remove('text-green-600');
        element.classList.add('text-gray-600', 'dark:text-gray-400');
    }
}

function checkMatch() {
    if (confirmPasswordInput.value === "") {
        matchText.textContent = "";
        return;
    }
    if (newPasswordInput.value === confirmPasswordInput.value) {
        matchText.textContent = "Passwords match ✅";
        matchText.className = "mt-1 text-xs font-medium text-green-600";
    } else {
        matchText.textContent = "Passwords do not match ❌";
        matchText.className = "mt-1 text-xs font-medium text-red-600";
    }
}

// Prevent form submission if password rules not met or passwords do not match
document.getElementById('resetPasswordForm').addEventListener('submit', function(e){
    const allValid = Object.values(rules).every(rule => rule.querySelector('span').classList.contains('bg-green-500'));
    if (!allValid) {
        e.preventDefault();
        alert("Password does not meet all requirements!");
        return;
    }
    if (newPasswordInput.value !== confirmPasswordInput.value) {
        e.preventDefault();
        alert("Passwords do not match!");
    }
});
</script>

@endsection
