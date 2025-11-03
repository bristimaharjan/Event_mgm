@extends('layouts.app')

@section('title', 'My Venue Reviews')
@php 
$noNavbar = true;
$noFooter = true; 
@endphp

@section('content')
@include('vendor.sidebar')

<div class="max-w-7xl mx-auto mt-10 ml-72 mr-10">
    <div class="bg-white rounded-2xl shadow-lg p-6">
        <h2 class="text-3xl font-bold text-[#8d85ec] mb-6">My Venue Reviews</h2>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse table-auto">
                <thead>
                    <tr class="bg-[#8d85ec] text-white">
                        <th class="px-6 py-3 w-10 rounded-tl-lg">Id</th>
                        <th class="px-1 py-3 w-48">Venue Details</th>
                        <th class="px-6 py-3 w-32">User</th>
                        <th class="px-6 py-3 w-16">Rating</th>
                        <th class="px-6 py-3 w-48">Comment</th>
                        <th class="px-6 py-3 w-24">Date</th>
                        <th class="px-6 py-3 w-16 text-center rounded-tr-lg">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium text-gray-700">{{ $loop->iteration }}</td>

                            <!-- Venue Details -->
                            <td class="px-1 py-4 w-48">
                                <div class="flex items-start gap-3">
                                    <img src="{{ asset('uploads/' . ($review->venue->image ?? 'default.jpg')) }}" 
                                        alt="Venue Photo" class="w-20 h-20 object-cover rounded-lg border">

                                    <div class="flex flex-col justify-start">
                                        <span class="font-semibold text-gray-900 text-md">{{ $review->venue->venue_name ?? 'N/A' }}</span>
                                        <span class="text-gray-600 text-xs">📍 {{ $review->venue->location ?? '-' }}</span>
                                        <span class="text-gray-600 text-xs">💰 Rs. {{ number_format($review->venueBooking->total_price ?? 0, 2) }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- User -->
                            <td class="px-6 py-4 whitespace-nowrap truncate" title="{{ $review->user->name ?? '-' }}">
                                {{ $review->user->name ?? '-' }}
                            </td>

                            <!-- Rating -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex gap-1">
                                    @for ($i = 0; $i < $review->rating; $i++)
                                        ⭐
                                    @endfor
                                </span>
                            </td>

                            <!-- Comment -->
                            <td class="px-6 py-4 max-w-xs break-words">
                                @php
                                    $fullComment = $review->comment ?? '-';
                                    $preview = Str::limit($fullComment, 50);
                                @endphp
                                <div class="overflow-hidden max-h-20">
                                    <span class="comment-preview">{{ $preview }}</span>
                                    @if(strlen($fullComment) > 50)
                                        <button class="text-blue-500 ml-1 read-more-btn" onclick="toggleComment(this)">Read more</button>
                                        <span class="comment-full hidden">{{ $fullComment }}</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Date -->
                            <td class="px-6 py-4 whitespace-nowrap">{{ $review->created_at->format('Y-m-d') }}</td>

                            <!-- Action -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('venueReview.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this review?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" 
                                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" 
                                                  d="M6 18a2 2 0 002 2h8a2 2 0 002-2V7H6v11zM9 7V5a2 2 0 012-2h2a2 2 0 012 2v2M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-6 text-center text-gray-500">No reviews found for your venues.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function toggleComment(button) {
    const full = button.nextElementSibling;
    const preview = button.previousElementSibling;

    if(full.classList.contains('hidden')) {
        full.classList.remove('hidden');
        preview.classList.add('hidden');
        button.textContent = 'Show less';
    } else {
        full.classList.add('hidden');
        preview.classList.remove('hidden');
        button.textContent = 'Read more';
    }
}
</script>

@endsection
