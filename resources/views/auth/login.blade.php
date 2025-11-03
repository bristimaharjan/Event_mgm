@extends('layouts.app')

@section('title', 'Login')

@section('content')

<!-- Error messages -->
<div class="w-full max-w-sm mx-auto">
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div id="toast-danger" class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow-sm dark:text-gray-400 dark:bg-gray-800" role="alert">
                <div class="inline-flex items-center justify-center shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                    <!-- SVG icon -->
                </div>
                <div class="ms-3 text-sm font-normal">{{ $error }}</div>
                <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 dark:bg-gray-800 dark:text-gray-500 dark:hover:text-white dark:hover:bg-gray-700" data-dismiss-target="#toast-danger" aria-label="Close">
                    <!-- Close icon -->
                </button>
            </div>
        @endforeach
    @endif
</div>

<!-- Login container -->
<div class="bg-[#FFF8F0] dark:bg-gray-800 min-h-screen flex justify-center items-start pt-10">
    <div class="bg-white dark:bg-gray-700 shadow-xl rounded-2xl overflow-hidden w-[420px] flex flex-col">
        <div class="w-full p-5 flex flex-col justify-center">
            <h2 class="text-3xl font-bold text-[#8d85ec] mb-4 text-center">Login</h2>
            <form action="{{ route('login') }}" method="POST" class="space-y-2">
                @if(session('status'))
                    <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-center">
                        {{ session('status') }}
                    </div>
                @endif

                @csrf
                <!-- Email -->
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-900 dark:text-gray-200">Email</label>
                    <input name="email" type="email" id="email" 
                        class="w-full mt-1 px-2 py-2 border rounded-lg focus:ring-2 focus:ring-[#C48F3A] outline-none dark:bg-gray-700 dark:text-gray-200" 
                        placeholder="eventify@gmail.com" required />
                </div>
                <!-- Password -->
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-900 dark:text-gray-200">Password</label>
                    <div class="relative mt-1">
                        <input type="password" id="password" name="password" required 
                            class="w-full px-2 py-2 border rounded-lg pr-10 dark:bg-gray-700 dark:text-gray-200"/>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full py-2 rounded-lg font-semibold transition text-white bg-[#8d85ec] hover:bg-[#883AFE]">
                    Login
                </button>

                <!-- Sign up link -->
                <p class="mt-3 text-sm text-gray-600 dark:text-gray-400 text-center">
                    Don't have an account? <a href="{{route('register')}}" class="text-[#F76C6C] font-medium hover:underline">Sign Up</a>
                </p>
            </form>
        </div>
    </div>
</div>

@endsection