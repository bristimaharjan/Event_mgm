@extends('layouts.app')

@section('title', 'Edit User')
@php
    $noNavbar = true;
    $noFooter = true;
@endphp
@include('admin.sidebar')

@section('content')
<div class="max-w-3xl mx-auto mt-12 ml-72">
    <div class="bg-white rounded-2xl shadow-lg p-8">
        <h2 class="text-3xl font-bold text-[#8D85EC] mb-6">Edit User</h2>

        <form action="{{ route('users.adminUpdate', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#8D85EC] focus:border-[#8D85EC]">
            </div>

            <!-- Email -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#8D85EC] focus:border-[#8D85EC]">
            </div>

            <!-- Role -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Role</label>
                <select name="role" required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#8D85EC] focus:border-[#8D85EC]">
                    <option value="User" {{ $user->role === 'User' ? 'selected' : '' }}>User</option>
                    <option value="Admin" {{ $user->role === 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Vendor" {{ $user->role === 'Vendor' ? 'selected' : '' }}>Vendor</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-[#8D85EC] text-white font-semibold px-6 py-3 rounded-lg hover:bg-[#7a73d9] transition">
                    Update User
                </button>
                <a href="{{ route('chirps.user') }}"
                   class="bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-medium hover:bg-gray-200 transition">
                   Cancel
                </a>
                
            </div>
        </form>
    </div>
</div>
@endsection
