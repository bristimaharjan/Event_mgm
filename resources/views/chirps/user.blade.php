@extends('layouts.app')

@section('title', 'Users')
@php 
$noNavbar = true ;
$noFooter = true; 
@endphp

@section('content')
@include('admin.sidebar')

<div class="max-w-7xl mx-auto mt-10 ml-72 mr-10">
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h2 class="text-3xl font-bold text-[#8d85ec] mb-6">Manage Users</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="bg-[#8d85ec] text-white">
                        <th scope="col" class="px-6 py-3 rounded-tl-lg">ID</th>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Role</th>
                        <th scope="col" class="px-6 py-3 text-center rounded-tr-lg">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-700">{{ $user->id }}</td>
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if($user->role === 'Admin') bg-purple-100 text-purple-700 
                                    @elseif($user->role === 'Vendor') bg-green-100 text-green-700
                                    @else bg-gray-100 text-gray-700 @endif">
                                    {{ $user->role ?? 'User' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 flex justify-center space-x-4">
                                <!-- Edit Icon -->
                                <a href="{{ route('users.adminEdit', $user->id) }}" 
                                   class="text-[#8d85ec] hover:text-blue-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> <path stroke-linecap="round" stroke-linejoin="round" d="M11 5h2m-2 14h2m7-7h2M4 12h2m9.586-6.586a2 2 0 012.828 2.828L7.828 21H4v-3.828l11.586-11.586z" /> </svg>                                </a>

                                <!-- Delete Icon -->
                                <form action="{{ route('users.adminDestroy', $user->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> <path stroke-linecap="round" stroke-linejoin="round" d="M6 18a2 2 0 002 2h8a2 2 0 002-2V7H6v11zM9 7V5a2 2 0 012-2h2a2 2 0 012 2v2M4 7h16" /> </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                                No users found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
