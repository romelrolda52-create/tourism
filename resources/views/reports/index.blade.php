@php
    $monthNames = $monthNames ?? [];
    $monthlyBookingsData = $monthlyBookingsData ?? [];
@endphp

<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Reports - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="h-full bg-gray-100 dark:bg-gray-900">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
        @include('layouts.sidebar-admin')

        <div class="lg:hidden fixed top-4 left-4 z-50">
            <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg bg-white dark:bg-gray-800 shadow-lg text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-white focus:outline-none border border-gray-200 dark:border-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path :class="{'hidden': sidebarOpen, 'inline-flex': !sidebarOpen}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    <path :class="{'hidden': !sidebarOpen, 'inline-flex': sidebarOpen}" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-40"></div>

        <aside x-show="sidebarOpen" x-transition:enter="transition ease-in-out duration-300 transform" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="lg:hidden fixed inset-y-0 left-0 w-64 bg-white dark:bg-gray-800 shadow-lg z-50 border-r border-gray-200 dark:border-gray-700">
            @include('layouts.sidebar-admin')
        </aside>

        <main class="flex-1 overflow-y-auto bg-gradient-to-br from-gray-50 via-white to-gray-50 dark:from-gray-900 dark:via-gray-900 dark:to-gray-800">
            <!-- Header -->
            <div class="sticky top-0 z-30 bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg border-b border-gray-200 dark:border-gray-700">
                <div class="px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex justify-between items-center">
                        <div class="pl-12 lg:pl-0">
                            <h2 class="font-bold text-3xl text-gray-900 dark:text-white">Reports & Analytics</h2>
                            <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">Complete system overview and business intelligence</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <button class="px-4 py-2 bg-gradient-to-r from-purple-600 to-violet-600 text-white rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300 font-medium">
                                Export CSV
                            </button>
                            <button id="darkModeToggle" onclick="toggleDarkMode()" class="p-3 rounded-xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:border-purple-300 dark:hover:border-purple-600 hover:shadow-lg hover:shadow-purple-500/20 dark:hover:shadow-purple-500/10 transition-all duration-300">
                                <svg id="lightModeIcon" class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <svg id="darkModeIcon" class="w-5 h-5 text-violet-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="py-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="group bg-white dark:bg-gray-800 border-2 border-blue-300 dark:border-blue-700 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 p-6 hover:-translate-y-2 overflow-hidden">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span class="text-sm font-bold text-gray-800 dark:text-gray-200 uppercase tracking-wide">Total Bookings</span>
                                    <p class="text-4xl font-black text-gray-900 dark:text-white mt-2">{{ number_format($stats['totalBookings']) }}</p>
                                </div>
                                <div class="p-3.5 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white shadow-lg group-hover:scale-110 transition-transform">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex space-x-2 text-sm">
                                <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $stats['confirmedBookings'] }} Confirmed</span>
                                <span class="font-bold text-amber-600 dark:text-amber-400">{{ $stats['pendingBookings'] }} Pending</span>
                            </div>
                        </div>

                        <div class="group bg-white dark:bg-gray-800 border-2 border-emerald-300 dark:border-emerald-700 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 p-6 hover:-translate-y-2 overflow-hidden">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span class="text-sm font-bold text-gray-800 dark:text-gray-200 uppercase tracking-wide">Total Revenue</span>
                                    <p class="text-4xl font-black text-gray-900 dark:text-white mt-2">${{ number_format($stats['totalRevenue'], 2) }}</p>
                                </div>
                                <div class="p-3.5 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-lg group-hover:scale-110 transition-transform">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08 .402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="text-sm text-gray-800 dark:text-gray-200">{{ $stats['totalPayments'] }} total payments processed</div>
                        </div>

                        <div class="group bg-white dark:bg-gray-800 border-2 border-purple-300 dark:border-purple-700 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 p-6 hover:-translate-y-2 overflow-hidden">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span class="text-sm font-bold text-gray-800 dark:text-gray-200 uppercase tracking-wide">Avg Rating</span>
                                    <p class="text-4xl font-black text-gray-900 dark:text-white mt-2">{{ number_format($stats['averageRating'], 1) }}/5</p>
                                </div>
                                <div class="p-3.5 rounded-xl bg-gradient-to-br from-purple-500 to-pink-600 text-white shadow-lg group-hover:scale-110 transition-transform">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="text-sm text-gray-800 dark:text-gray-200">{{ $stats['totalFeedbacks'] }} total feedbacks</div>
                        </div>

                        <div class="group bg-white dark:bg-gray-800 border-2 border-indigo-300 dark:border-indigo-700 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 p-6 hover:-translate-y-2 overflow-hidden">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span class="text-sm font-bold text-gray-800 dark:text-gray-200 uppercase tracking-wide">Active Resources</span>
                                    <p class="text-4xl font-black text-gray-900 dark:text-white mt-2">{{ $stats['totalHotels'] + $stats['totalRestaurants'] + $stats['totalVehicles'] }}</p>
                                </div>
                                <div class="p-3.5 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white shadow-lg group-hover:scale-110 transition-transform">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-2 text-xs mt-2">
                                <div>H: {{ $stats['totalHotels'] }}</div>
                                <div>R: {{ $stats['totalRestaurants'] }}</div>
                                <div>V: {{ $stats['totalVehicles'] }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <!-- Bookings Trend Chart -->
                        <div class="bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-2xl shadow-xl p-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Bookings Trend ({{ now()->year }})</h3>
                            <canvas id="bookingsChart" height="200"></canvas>
                        </div>

                        <!-- Revenue & Feedback Chart -->
                        <div class="bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-2xl shadow-xl p-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Revenue vs Feedback</h3>
                            <div class="grid grid-cols-2 gap-6 h-64">
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-gray-800 dark:text-gray-200">Monthly Revenue</span>
                                        <span class="font-bold text-emerald-600 dark:text-emerald-400">${{ number_format($stats['totalRevenue']/12, 0) }} avg</span>
                                    </div>
                                    <div class="h-32 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-xl p-4">
                                        <div class="h-20 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-lg shadow-lg" style="width: 75%;"></div>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-gray-800 dark:text-gray-200">Feedback Rating</span>
                                        <span class="font-bold text-purple-600 dark:text-purple-400">{{ number_format($stats['averageRating'], 1) }}/5</span>
                                    </div>
                                    <div class="h-32 bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-xl p-4">
                                        <div class="flex space-x-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <div class="w-12 h-8 {{ $i <= round($stats['averageRating']) ? 'bg-gradient-to-r from-yellow-400 to-yellow-500 shadow-lg rounded-lg' : 'bg-gray-200 dark:bg-gray-600 rounded-lg' }}"></div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity Tables -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-2xl shadow-xl p-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Recent Bookings (Last 10)</h3>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Customer</th>
                                            <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Destination</th>
                                            <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Status</th>
                                            <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Amount</th>
                                            <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentBookings as $booking)
                                        <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                            <td class="py-3 px-4">
                                                <div class="font-medium text-gray-900 dark:text-white">{{ $booking->user->name ?? 'Guest' }}</div>
                                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $booking->user->email ?? '-' }}</div>
                                            </td>
                                            <td class="py-3 px-4 font-medium text-gray-900 dark:text-white">{{ $booking->destination->name ?? '-' }}</td>
                                            <td class="py-3 px-4">
                                                <span class="px-3 py-1 rounded-full text-xs font-bold 
                                                    {{ $booking->status == 'confirmed' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-200' : 
                                                       ($booking->status == 'pending' ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/50 dark:text-amber-200' : 
                                                        'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-200') }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 font-bold text-gray-900 dark:text-white">${{ number_format($booking->total_amount ?? 0, 2) }}</td>
                                            <td class="py-3 px-4 text-sm text-gray-500 dark:text-gray-400">{{ $booking->created_at->format('M j, Y') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-2xl shadow-xl p-6">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Recent Payments (Last 10)</h3>
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="border-b border-gray-200 dark:border-gray-700">
                                            <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Customer</th>
                                            <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Amount</th>
                                            <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Status</th>
                                            <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentPayments as $payment)
                                        <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                            <td class="py-3 px-4 font-medium text-gray-900 dark:text-white">{{ $payment->booking->user->name ?? 'Guest' }}</td>
                                            <td class="py-3 px-4 font-bold text-emerald-600 dark:text-emerald-400">${{ number_format($payment->amount, 2) }}</td>
                                            <td class="py-3 px-4">
                                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-200">
                                                    {{ ucfirst($payment->status) }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-sm text-gray-500 dark:text-gray-400">{{ $payment->created_at->format('M j, Y') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Bookings Chart
        const ctx = document.getElementById('bookingsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($monthNames),
                datasets: [{
                    label: 'Bookings',
                    data: @json($monthlyBookingsData),
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(16, 185, 129, 0.9)',
                        'rgba(16, 185, 129, 0.9)',
                        'rgba(16, 185, 129, 0.9)',
                        'rgba(34, 197, 94, 0.9)',
                        'rgba(34, 197, 94, 0.9)',
                        'rgba(34, 197, 94, 0.9)'
                    ],
                    borderColor: [
                        'rgba(59, 130, 246, 1)',
                        'rgba(59, 130, 246, 1)',
                        'rgba(59, 130, 246, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(34, 197, 94, 1)',
                        'rgba(34, 197, 94, 1)',
                        'rgba(34, 197, 94, 1)'
                    ],
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });

        function toggleDarkMode() {
            const html = document.documentElement;
            const lightIcon = document.getElementById('lightModeIcon');
            const darkIcon = document.getElementById('darkModeIcon');
            html.classList.toggle('dark');
            lightIcon.classList.toggle('hidden');
            darkIcon.classList.toggle('hidden');
            localStorage.setItem('darkMode', html.classList.contains('dark'));
        }

        // Load saved theme
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
            document.getElementById('lightModeIcon').classList.add('hidden');
            document.getElementById('darkModeIcon').classList.remove('hidden');
        }
    </script>
</body>
</html>

