@extends('layouts.app')

@section('title', 'Vendor Dashboard')
@php 
    $noNavbar = true; 
    $noFooter = true; 
@endphp
@include('vendor.sidebar')
@section('content')
<div class="w-full mx-auto ml-30 mt-15 space-y-8"> 
    <div> 
        <h2 class="text-3xl font-bold text-[#8d85ec] mb-4 text-center">Vendor Dashboard</h2> 
        <p class="text-center dark:text-gray-50">Welcome, {{ $vendor->name }}</p>

</div>
@endsection
