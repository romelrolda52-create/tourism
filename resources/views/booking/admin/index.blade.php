@php
    use App\Models\Booking;
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Bookings | Tourism Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8'
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Prevent body from scrolling */
        body {
            overflow: hidden;
            height: 100vh;
        }
        
        /* Main content scrollbar */
        .main-content-scroll {
            overflow-y: auto;
            scrollbar-width: thin;
        }
        
        .main-content-scroll::-webkit-scrollbar {
            width: 6px;
        }
        
        .main-content-scroll::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
        
        .main-content-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        
        .dark .main-content-scroll::-webkit-scrollbar-track {
            background: #1f2937;
        }
        
        .dark .main-content-scroll::-webkit-scrollbar-thumb {
            background: #4b5563;
        }
        
        /* Fix for sidebar container */
        .sidebar-container {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 16rem;
            z-index: 40;
        }
        
        /* Main content wrapper */
        .main-wrapper {
            margin-left: 16rem;
            width: calc(100% - 16rem);
            height: 100vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        
        /* Responsive adjustments */
        @media (max-width: 1023px) {
            .sidebar-container {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }
            
            .sidebar-container.open {
                transform: translateX(0);
            }
            
            .main-wrapper {
                margin-left: 0;
                width: 100%;
            }
        }
        
        /* Card hover effects */
        .stat-card {
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.15);
        }
        
        /* Table row hover */
        .booking-row {
            transition: all 0.2s ease;
        }
        
        .booking-row:hover {
            background: linear-gradient(90deg, rgba(139, 92, 246, 0.05), rgba(139, 92, 246, 0.02));
        }
        
        /* Action buttons */
        .action-btn {
            transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
        }
        
        /* Status badges */
        .status-badge {
            transition: all 0.2s ease;
        }
        
        .status-badge:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 font-sans">
    <div x-data="{ sidebarOpen: false, searchTerm: '', statusFilter: '' }" class="relative">
        
        <!-- Sidebar Container -->
        <div class="sidebar-container bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 shadow-xl"
             :class="{'open': sidebarOpen}">
            @include('layouts.sidebar-admin')
        </div>

        <!-- Mobile Menu Button -->
        <div class="lg:hidden fixed top-4 left-4 z-50">
            <button @click="sidebarOpen = !sidebarOpen"
                    class="p-2.5 rounded-xl bg-white dark:bg-gray-800 shadow-lg text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
        
        <!-- Mobile Overlay -->
        <div x-show="sidebarOpen"
             @click="sidebarOpen = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden"
             style="display: none;">
        </div>

        <!-- Main Content Wrapper -->
        <div class="main-wrapper">
            <!-- Header -->
            <header class="bg-white/80 dark:bg-gray-800/90 backdrop-blur-md border-b border-gray-200/50 dark:border-gray-700 shadow-sm flex-shrink-0 z-10">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-r from-violet-500 to-purple-600 flex items-center justify-center shadow-lg">
                                <i class="fas fa-calendar-check text-white text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                                    Booking Management
                                    <span class="text-xs bg-gradient-to-r from-violet-100 to-purple-100 dark:from-violet-900/50 dark:to-purple-900/50 text-violet-700 dark:text-violet-300 font-bold px-3 py-1 rounded-full shadow-sm">
                                        ADMIN
                                    </span>
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">Manage and track all user bookings</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <!-- Dark Mode Toggle -->
                            <button onclick="toggleDarkMode()"
                                class="p-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all duration-200">
                                <i class="fas fa-moon text-lg dark:hidden"></i>
                                <i class="fas fa-sun text-lg hidden dark:inline"></i>
                            </button>

                            <!-- Back to Dashboard -->
                            <a href="{{ route('dashboard') }}"
                                class="bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white font-semibold py-2.5 px-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2 group">
                                <i class="fas fa-home group-hover:scale-110 transition-transform"></i>
                                <span class="hidden sm:inline">Dashboard</span>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 main-content-scroll p-6">
                <div class="max-w-7xl mx-auto space-y-6">
                    
                    <!-- Success Message -->
                    @if(session('success'))
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-l-4 border-green-500 rounded-xl p-5 shadow-lg animate-fade-in">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-800/50 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-green-800 dark:text-green-300">Success!</h3>
                                <p class="text-green-700 dark:text-green-400 text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                        <!-- Total -->
                        <div class="stat-card bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Bookings</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $bookings->count() }}</p>
                                </div>
                                <div class="w-14 h-14 rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center shadow-md">
                                    <i class="fas fa-calendar-alt text-white text-2xl"></i>
                                </div>
                            </div>
                            <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                                <i class="fas fa-chart-line mr-1"></i> All time bookings
                            </div>
                        </div>

                        <!-- Pending -->
                        <div class="stat-card bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pending</p>
                                    <p class="text-3xl font-bold text-amber-500 dark:text-amber-400 mt-2">{{ $bookings->where('status', 'pending')->count() }}</p>
                                </div>
                                <div class="w-14 h-14 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 flex items-center justify-center shadow-md">
                                    <i class="fas fa-clock text-white text-2xl"></i>
                                </div>
                            </div>
                            <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                                <i class="fas fa-spinner fa-pulse mr-1"></i> Awaiting confirmation
                            </div>
                        </div>

                        <!-- Confirmed -->
                        <div class="stat-card bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Confirmed</p>
                                    <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 mt-2">{{ $bookings->where('status', 'confirmed')->count() }}</p>
                                </div>
                                <div class="w-14 h-14 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 flex items-center justify-center shadow-md">
                                    <i class="fas fa-check-circle text-white text-2xl"></i>
                                </div>
                            </div>
                            <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                                <i class="fas fa-check mr-1"></i> Approved bookings
                            </div>
                        </div>

                        <!-- Cancelled -->
                        <div class="stat-card bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Cancelled</p>
                                    <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2">{{ $bookings->where('status', 'cancelled')->count() }}</p>
                                </div>
                                <div class="w-14 h-14 rounded-xl bg-gradient-to-r from-red-500 to-rose-500 flex items-center justify-center shadow-md">
                                    <i class="fas fa-times-circle text-white text-2xl"></i>
                                </div>
                            </div>
                            <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                                <i class="fas fa-ban mr-1"></i> Cancelled bookings
                            </div>
                        </div>
                    </div>

                    <!-- Search and Filter Bar -->
                    <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-md rounded-2xl p-5 shadow-lg border border-gray-100 dark:border-gray-700">
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="flex-1 relative">
                                <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <input type="text" 
                                       x-model="searchTerm"
                                       placeholder="Search by booking ID, user name, or destination..." 
                                       class="w-full pl-11 pr-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-violet-500 focus:border-transparent transition-all">
                            </div>
                            <div class="relative">
                                <i class="fas fa-filter absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <select x-model="statusFilter"
                                        class="pl-11 pr-10 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-violet-500 focus:border-transparent cursor-pointer appearance-none">
                                    <option value="">All Statuses</option>
                                    <option value="pending">Pending</option>
                                    <option value="confirmed">Confirmed</option>
                                    <option value="cancelled">Cancelled</option>
                                    <option value="completed">Completed</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Bookings Table -->
                    @if($bookings->count() > 0)
                    <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-md rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-800/50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Booking ID</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Destination</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Dates</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Guests</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                                    @foreach($bookings as $booking)
                                    <tr class="booking-row transition-all duration-200" 
                                        x-show="searchTerm === '' || $el.textContent.toLowerCase().includes(searchTerm.toLowerCase())"
                                        x-show.transition.opacity.duration.300ms="true">
                                        
                                        <!-- Booking ID -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-mono font-bold text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">{{ $booking->booking_id }}</span>
                                        </td>

                                        <!-- User -->
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-md flex-shrink-0">
                                                    {{ substr($booking->user->name, 0, 1) }}
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $booking->user->name }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $booking->user->email }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Destination -->
                                        <td class="px-6 py-4">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $booking->destination ? $booking->destination->name : 'N/A' }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1 mt-0.5">
                                                <i class="fas fa-map-marker-alt text-xs"></i>
                                                {{ $booking->destination ? $booking->destination->location : '' }}
                                            </p>
                                        </td>

                                        <!-- Dates -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex flex-col">
                                                <span class="text-sm text-gray-900 dark:text-white font-medium">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}</span>
                                                <span class="text-xs text-gray-500 dark:text-gray-400">→ {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</span>
                                            </div>
                                        </td>

                                        <!-- Guests -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                    <i class="fas fa-users text-gray-500 dark:text-gray-400 text-sm"></i>
                                                </div>
                                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $booking->number_of_guests }}</span>
                                            </div>
                                        </td>

                                        <!-- Total -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-base font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">₱{{ number_format($booking->total_price, 2) }}</span>
                                        </td>

                                        <!-- Status -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @switch($booking->status)
                                                @case('pending')
                                                    <span class="status-badge inline-flex items-center gap-2 px-3 py-1.5 bg-amber-100 dark:bg-amber-500/20 text-amber-700 dark:text-amber-400 text-xs font-bold rounded-full">
                                                        <i class="fas fa-clock text-xs"></i>
                                                        <span>Pending</span>
                                                    </span>
                                                    @break
                                                @case('confirmed')
                                                    <span class="status-badge inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-100 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-400 text-xs font-bold rounded-full">
                                                        <i class="fas fa-check-circle text-xs"></i>
                                                        <span>Confirmed</span>
                                                    </span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="status-badge inline-flex items-center gap-2 px-3 py-1.5 bg-red-100 dark:bg-red-500/20 text-red-700 dark:text-red-400 text-xs font-bold rounded-full">
                                                        <i class="fas fa-ban text-xs"></i>
                                                        <span>Cancelled</span>
                                                    </span>
                                                    @break
                                                @case('completed')
                                                    <span class="status-badge inline-flex items-center gap-2 px-3 py-1.5 bg-blue-100 dark:bg-blue-500/20 text-blue-700 dark:text-blue-400 text-xs font-bold rounded-full">
                                                        <i class="fas fa-check-double text-xs"></i>
                                                        <span>Completed</span>
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="status-badge inline-flex items-center gap-2 px-3 py-1.5 bg-gray-100 dark:bg-gray-500/20 text-gray-700 dark:text-gray-400 text-xs font-bold rounded-full">
                                                        {{ ucfirst($booking->status) }}
                                                    </span>
                                            @endswitch
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center justify-center gap-2">
                                                <!-- View Details -->
                                                <a href="{{ route('bookings.admin.show', $booking) }}"
                                                    class="action-btn w-9 h-9 bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-200 dark:hover:bg-blue-500/30 transition-all flex items-center justify-center"
                                                    title="View Details">
                                                    <i class="fas fa-eye text-sm"></i>
                                                </a>

                                                <!-- Edit -->
                                                <a href="{{ route('bookings.admin.edit', $booking) }}"
                                                    class="action-btn w-9 h-9 bg-violet-100 dark:bg-violet-500/20 text-violet-600 dark:text-violet-400 rounded-lg hover:bg-violet-200 dark:hover:bg-violet-500/30 transition-all flex items-center justify-center"
                                                    title="Edit Booking">
                                                    <i class="fas fa-edit text-sm"></i>
                                                </a>

                                                <!-- Confirm (if pending) -->
                                                @if($booking->status === 'pending')
                                                <form action="{{ route('bookings.manage.confirm', $booking) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="action-btn w-9 h-9 bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-lg hover:bg-emerald-200 dark:hover:bg-emerald-500/30 transition-all flex items-center justify-center"
                                                        title="Confirm Booking">
                                                        <i class="fas fa-check text-sm"></i>
                                                    </button>
                                                </form>
                                                @endif

                                                <!-- Cancel (if not cancelled) -->
                                                @if($booking->status !== 'cancelled' && $booking->status !== 'completed')
                                                <form action="{{ route('bookings.manage.cancel', $booking) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to cancel this booking? This action cannot be undone.')">
                                                    @csrf
                                                    <button type="submit"
                                                        class="action-btn w-9 h-9 bg-orange-100 dark:bg-orange-500/20 text-orange-600 dark:text-orange-400 rounded-lg hover:bg-orange-200 dark:hover:bg-orange-500/30 transition-all flex items-center justify-center"
                                                        title="Cancel Booking">
                                                        <i class="fas fa-ban text-sm"></i>
                                                    </button>
                                                </form>
                                                @endif

                                                <!-- Delete -->
                                                <form action="{{ route('bookings.admin.destroy', $booking) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this booking? This action cannot be undone.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="action-btn w-9 h-9 bg-red-100 dark:bg-red-500/20 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-200 dark:hover:bg-red-500/30 transition-all flex items-center justify-center"
                                                        title="Delete Booking">
                                                        <i class="fas fa-trash text-sm"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Table Footer with Pagination -->
                        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800/50 dark:to-gray-800/50">
                            <div class="flex items-center justify-between flex-wrap gap-4">
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-chart-simple mr-2"></i>
                                    Showing {{ $bookings->count() }} bookings
                                </div>
                                @if(method_exists($bookings, 'links'))
                                    <div class="flex gap-2">
                                        {{ $bookings->links() }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @else
                    <!-- Empty State -->
                    <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-md rounded-2xl p-16 text-center shadow-lg border border-gray-100 dark:border-gray-700">
                        <div class="max-w-sm mx-auto">
                            <div class="w-24 h-24 mx-auto bg-gradient-to-br from-violet-100 to-purple-50 dark:from-violet-900/30 dark:to-purple-800/30 rounded-2xl flex items-center justify-center mb-6 shadow-inner">
                                <i class="fas fa-calendar-check text-violet-500 dark:text-violet-400 text-4xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">No Bookings Found</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-8">User bookings will appear here once they make reservations.</p>
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center gap-2 bg-gradient-to-r from-violet-600 to-purple-600 hover:from-violet-700 hover:to-purple-700 text-white font-semibold py-3 px-8 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 group">
                                <i class="fas fa-home group-hover:scale-110 transition-transform"></i>
                                Back to Dashboard
                                <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                    @endif

                </div>
            </main>
        </div>
    </div>

    <script>
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        }

        // Initialize dark mode from localStorage
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }
        
        // Close mobile sidebar when window is resized to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                document.querySelector('.sidebar-container')?.classList.remove('open');
            }
        });
        
        // Add fade-in animation style
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fade-in {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-in {
                animation: fade-in 0.3s ease-out;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>