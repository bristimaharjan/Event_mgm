@extends('layouts.app')
@section('title', 'Forgot Password')
@section('content')
<div class="max-w-md mx-auto mt-20 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg">
    <h2 class="text-2xl font-bold mb-4 text-center text-gray-900 dark:text-white">Forgot Password</h2>
    @if(session('status'))
        <p class="text-green-500 mb-4">{{ session('status') }}</p>
    @endif
    <form method="POST" action="{{ route('vendor.password.email') }}">
        @csrf
        <label class="block mb-2 text-gray-700 dark:text-gray-200">Email</label>
        <input type="email" name="email" required 
               class="w-full mb-4 p-2 border rounded-lg dark:bg-gray-700 dark:text-gray-200">
        <button type="submit" class="w-full py-2 bg-[#8D85EC] text-white rounded-lg hover:bg-[#7b76e4]">
            Send Reset Link
        </button>
    </form>
</div>
@endsection
