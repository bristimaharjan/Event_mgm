@extends('layouts.app')

@section('title', 'Register')

@section('content')

<div class="bg-[#FFF8F0] dark:bg-gray-800 min-h-screen flex justify-center items-start pt-3">
  <div class="bg-white dark:bg-gray-700 shadow-xl rounded-2xl overflow-hidden w-[420px] flex flex-col">
    
    <!-- Form -->
    <div class="w-full p-5 flex flex-col justify-center">
      <h2 class="text-3xl font-bold text-[#8d85ec] mb-4 text-center">Create Account</h2>
      
      <form action="{{ route('register') }}" method="POST" class="space-y-2">
        @csrf
        <!-- Name -->
        <div class="mb-3">
          <label class="block text-sm font-medium text-gray-900 dark:text-gray-200">Full Name</label>
          <input name="name" type="text" id="name" 
                 class="w-full mt-1 px-2 py-2 border rounded-lg focus:ring-2 focus:ring-[#C48F3A] outline-none dark:bg-gray-700 dark:text-gray-200"/>
        </div>

        <!-- Email -->
        <div class="mb-3">
          <label class="block text-sm font-medium text-gray-900 dark:text-gray-200">Email</label>
          <input name="email" type="email" id="email" required 
                 placeholder="eventify@gmail.com" 
                 class="w-full mt-1 px-2 py-2 border rounded-lg focus:ring-2 focus:ring-[#C48F3A] outline-none dark:bg-gray-700 dark:text-gray-200"/>
        </div>

        <!-- Role -->
        <div class="mb-3">
          <label class="block text-sm font-medium text-gray-900 dark:text-gray-200">Role</label>          
          <select id="role" name="role" 
                  class="w-full mt-1 px-2 py-2 border rounded-lg focus:ring-2 focus:ring-[#C48F3A] outline-none dark:bg-gray-700 dark:text-gray-200">
            <option value="user">User</option>
            <option value="vendor">Vendor</option>
          </select>
        </div>

        <!-- Password -->
        <div class="mb-3">
          <label class="block text-sm font-medium text-gray-900 dark:text-gray-200">Password</label>
          <div class="relative mt-1">
            <input type="password" id="password" name="password" required 
                   class="w-full px-2 py-2 border rounded-lg pr-10 dark:bg-gray-700 dark:text-gray-200"/>
          </div>

          <!-- Password rules checklist -->
          <ul class="mt-2 text-xs text-gray-600 dark:text-gray-400 space-y-1" id="password-rules">
            <li id="rule-length" class="flex items-center"><span class="w-3 h-3 mr-2 border rounded-full"></span> At least 8 characters</li>
            <li id="rule-uppercase" class="flex items-center"><span class="w-3 h-3 mr-2 border rounded-full"></span> At least one uppercase letter</li>
            <li id="rule-number" class="flex items-center"><span class="w-3 h-3 mr-2 border rounded-full"></span> At least one number</li>
            <li id="rule-special" class="flex items-center"><span class="w-3 h-3 mr-2 border rounded-full"></span> At least one special character (!@#$%)</li>
          </ul>

          <!-- Password strength message -->
          <p id="password-strength" class="mt-2 text-xs font-medium"></p>
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
          <label class="block text-sm font-medium text-gray-900 dark:text-gray-200">Confirm Password</label>
          <div class="relative mt-1">
            <input type="password" id="password_confirmation" name="password_confirmation" required 
                   class="w-full px-2 py-2 border rounded-lg pr-10 dark:bg-gray-700 dark:text-gray-200"/>
          </div>
          <p id="password-match" class="mt-2 text-xs font-medium"></p>
        </div>

        <!-- Button -->
        <button type="submit" 
                class="w-full py-2 rounded-lg font-semibold transition text-white bg-[#8d85ec] hover:bg-[#883AFE]">
          Sign Up
        </button>
      </form>

      <p class="mt-3 text-sm text-gray-600 dark:text-gray-400 text-center">
        Already have an account? <a href="{{route('login')}}" class="text-[#F76C6C] font-medium hover:underline">Log in</a>
      </p>
    </div>
  </div>
</div>

<!-- Password Validation Script -->
<script>
  const passwordInput = document.getElementById('password');
  const confirmInput = document.getElementById('password_confirmation');
  const strengthText = document.getElementById('password-strength');
  const matchText = document.getElementById('password-match');

  const rules = {
    length: document.getElementById('rule-length'),
    uppercase: document.getElementById('rule-uppercase'),
    number: document.getElementById('rule-number'),
    special: document.getElementById('rule-special'),
  };

  passwordInput.addEventListener('input', validatePassword);
  confirmInput.addEventListener('input', checkMatch);

  function validatePassword() {
    const value = passwordInput.value;
    let strength = 0;

    // Rule checks
    updateRule(rules.length, value.length >= 8);
    updateRule(rules.uppercase, /[A-Z]/.test(value));
    updateRule(rules.number, /\d/.test(value));
    updateRule(rules.special, /[!@#$%^&*(),.?":{}|<>]/.test(value));

    // Strength calculation
    if (value.length >= 8) strength++;
    if (/[A-Z]/.test(value)) strength++;
    if (/\d/.test(value)) strength++;
    if (/[!@#$%^&*(),.?":{}|<>]/.test(value)) strength++;

    switch (strength) {
      case 0:
      case 1:
        strengthText.textContent = "Weak password ❌";
        strengthText.className = "mt-2 text-xs font-medium text-red-600";
        break;
      case 2:
        strengthText.textContent = "Fair password ⚠️";
        strengthText.className = "mt-2 text-xs font-medium text-yellow-600";
        break;
      case 3:
        strengthText.textContent = "Good password 🙂";
        strengthText.className = "mt-2 text-xs font-medium text-blue-600";
        break;
      case 4:
        strengthText.textContent = "Strong password ✅";
        strengthText.className = "mt-2 text-xs font-medium text-green-600";
        break;
    }

    // Check match when password changes
    checkMatch();
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
    if (confirmInput.value === "") {
      matchText.textContent = "";
      return;
    }
    if (passwordInput.value === confirmInput.value) {
      matchText.textContent = "Password match ✅";
      matchText.className = "mt-2 text-xs font-medium text-green-600";
    } else {
      matchText.textContent = "Password does not match ❌";
      matchText.className = "mt-2 text-xs font-medium text-red-600";
    }
  }
</script>
@endsection