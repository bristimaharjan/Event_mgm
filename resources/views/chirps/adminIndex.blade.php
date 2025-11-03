@extends('layouts.app')

@section('title', 'Admin')
@php $noNavbar = true; $noFooter = true; @endphp
@include('admin.sidebar')

@section('content')
<div class="w-full mx-auto ml-30 mt-2 space-y-8"> 
    <div> 
        <h2 class="text-3xl font-bold text-[#8d85ec] mb-4 text-center">Admin Dashboard</h2> 
        <p class="text-center dark:text-gray-50">Welcome, {{ $user->name }}</p>
<div class="max-w-7xl mx-auto mt-2 space-y-8">

    <!-- Dashboard Cards -->
    <div class="max-w-7xl mx-auto mt-2 space-y-8">

    <!-- Dashboard Cards -->
    <div class="flex flex-wrap justify-center gap-6">
        <!-- Total Users Card -->
        <div class="mt-8 text-center flex-1 min-w-[200px] max-w-[250px]">
            <a href="#"
               class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-purple-50 transition">
                <div class="flex justify-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 12a5 5 0 100-10 5 5 0 000 10z"/>
                    </svg>
                </div>
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ $totalCount }}</h5>
                <p class="font-normal text-gray-700">Total</p>
            </a>
        </div>

        <!-- Admins Card -->
        <div class="mt-8 text-center flex-1 min-w-[200px] max-w-[250px]">
            <a href="#"
               class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-purple-100 transition">
                <div class="flex justify-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 2l9 4-9 4-9-4 9-4zm0 6v14"/>
                    </svg>
                </div>
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ $adminCount }}</h5>
                <p class="font-normal text-gray-700">Admins</p>
            </a>
        </div>

        <!-- Users Card -->
        <div class="mt-8 text-center flex-1 min-w-[200px] max-w-[250px]">
            <a href="#"
               class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-blue-50 transition">
                <div class="flex justify-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M12 12a5 5 0 100-10 5 5 0 000 10z"/>
                    </svg>
                </div>
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ $userCount }}</h5>
                <p class="font-normal text-gray-700">Users</p>
            </a>
        </div>

        <!-- Vendors Card -->
        <div class="mt-8 text-center flex-1 min-w-[200px] max-w-[250px]">
            <a href="#"
               class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-green-50 transition">
                <div class="flex justify-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 9l1-2h16l1 2M5 9v12h14V9M5 9L4 4h16l-1 5M9 13h6"/>
                    </svg>
                </div>
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ $vendorCount }}</h5>
                <p class="font-normal text-gray-700">Vendors</p>
            </a>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="flex flex-wrap justify-center gap-6 mt-4">
        <!-- Bar Chart -->
        <div class="bg-white p-6 rounded-lg shadow flex-1 min-w-[200px] max-w-[450px]">
            <h3 class="text-xl font-bold mb-4 text-center">Total Users Overview</h3>
            <canvas id="barChart" height="180"></canvas>
        </div>

        <!-- Doughnut Chart -->
        <div class="bg-white p-6 rounded-lg shadow flex-1 min-w-[200px] max-w-[450px]">
            <h3 class="text-xl font-bold mb-4 text-center">User Distribution</h3>
            <canvas id="doughnutChart" height="180"></canvas>
        </div>
    </div>


</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Bar Chart with Tooltip
    const barCtx = document.getElementById('barChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: ['Admins', 'Users', 'Vendors'],
            datasets: [{
                label: 'Number of Users',
                data: [{{ $adminCount }}, {{ $userCount }}, {{ $vendorCount }}],
                backgroundColor: [
                    'rgba(141, 133, 236, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(72, 187, 120, 0.8)'
                ],
                borderColor: [
                    'rgba(141, 133, 236, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(72, 187, 120, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    enabled: true,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    precision: 0,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            hover: {
                mode: 'nearest',
                intersect: true
            }
        }
    });

    // Doughnut Chart with Tooltip
    const doughnutCtx = document.getElementById('doughnutChart').getContext('2d');
    new Chart(doughnutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Admins', 'Users', 'Vendors'],
            datasets: [{
                data: [{{ $adminCount }}, {{ $userCount }}, {{ $vendorCount }}],
                backgroundColor: [
                    'rgba(141, 133, 236, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(72, 187, 120, 0.8)'
                ],
                borderColor: [
                    'rgba(141, 133, 236, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(72, 187, 120, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { font: { size: 14 } }
                },
                tooltip: {
                    enabled: true,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const value = context.parsed;
                            const percentage = ((value / total) * 100).toFixed(1);
                            return context.label + ': ' + value + ' (' + percentage + '%)';
                        }
                    }
                }
            },
            hover: {
                mode: 'nearest',
                intersect: true
            }
        }
    });
</script>


@endsection
