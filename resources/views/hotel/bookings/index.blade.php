<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Bookings | Travel Management</title>
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
                            50: '#eff6ff', 100: '#dbeafe',
                            500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8',
                        }
                    },
                    animation: { 'fade-in': 'fadeIn 0.3s ease-in-out' },
                    keyframes: { fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } } }
                }
            }
        }
    </script>
    <style>
        * { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }

        .scrollbar-thin::-webkit-scrollbar { width: 6px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: #f1f5f9; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        .table-row-hover { transition: background 0.15s ease; }
        .table-row-hover:hover { background-color: rgba(139, 92, 246, 0.04); }
        .dark .table-row-hover:hover { background-color: rgba(139, 92, 246, 0.08); }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans">
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">

        @include('layouts.sidebar-admin')

        <!-- Mobile Menu Button -->
        <div class="lg:hidden fixed top-4 left-4 z-50">
            <button @click="sidebarOpen = !sidebarOpen"
                    class="p-2 rounded-lg bg-white dark:bg-gray-800 shadow-lg text-gray-600 dark:text-gray-300">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden lg:pl-64">

            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
<div class="flex items-center">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                                    <i class="fas fa-calendar-check text-violet-500"></i>
                                    Hotel Bookings
                                    <span class="text-xs bg-violet-100 dark:bg-violet-900/30 text-violet-700 dark:text-violet-300 font-bold px-3 py-1 rounded-full">
                                        {{ $bookings->total() }} Reservations
                                    </span>
                                </h1>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5 flex items-center gap-1.5">
                                    <i class="fas fa-hotel text-xs"></i>
                                    Manage all hotel reservations and guest check-ins
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <!-- Dark Mode Toggle -->
                            <button onclick="toggleDarkMode()"
                                class="p-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                                <i class="fas fa-moon text-lg dark:hidden"></i>
                                <i class="fas fa-sun text-lg hidden dark:inline"></i>
                            </button>

                            <!-- New Reservation -->
                            <a href="{{ route('hotel.bookings.create') }}"
                                class="flex items-center gap-2 bg-gradient-to-r from-violet-600 to-purple-500 hover:from-violet-700 hover:to-purple-600 text-white font-semibold py-2.5 px-5 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 group">
                                <i class="fas fa-plus-circle"></i>
                                New Reservation
                                <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto scrollbar-thin p-8 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
<div class="max-w-6xl mx-auto py-12 space-y-8">

                    <!-- Stats Row -->
                    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
                        @php
                            $statuses = [
                                ['label'=>'Pending',    'value'=>$bookings->where('status','pending')->count(),    'color'=>'yellow',  'icon'=>'fa-clock'],
                                ['label'=>'Confirmed',  'value'=>$bookings->where('status','confirmed')->count(),  'color'=>'green',   'icon'=>'fa-check-circle'],
                                ['label'=>'Checked In', 'value'=>$bookings->where('status','checked_in')->count(),'color'=>'blue',    'icon'=>'fa-sign-in-alt'],
                                ['label'=>'Completed',  'value'=>$bookings->where('status','completed')->count(),  'color'=>'indigo',  'icon'=>'fa-flag-checkered'],
                                ['label'=>'Cancelled',  'value'=>$bookings->where('status','cancelled')->count(),  'color'=>'red',     'icon'=>'fa-times-circle'],
                            ];
                        @endphp
                        @foreach($statuses as $stat)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-4 border border-gray-100 dark:border-gray-700 shadow-sm">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-xs font-medium text-gray-500 dark:text-gray-400">{{ $stat['label'] }}</p>
                                <div class="w-8 h-8 rounded-lg bg-{{ $stat['color'] }}-100 dark:bg-{{ $stat['color'] }}-900/30 flex items-center justify-center flex-shrink-0">
                                    <i class="fas {{ $stat['icon'] }} text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400 text-sm"></i>
                                </div>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stat['value'] }}</h3>
                        </div>
                        @endforeach
                    </div>

                    <!-- Alerts -->
                    @if(session('success'))
                    <div class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 border-l-4 border-green-500 rounded-xl p-5 shadow-sm animate-fade-in">
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

                    @if($errors->any())
                    <div class="bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 border-l-4 border-red-500 rounded-xl p-5 shadow-sm animate-fade-in">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-800/50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-red-800 dark:text-red-300 mb-1">Please correct the following errors:</h3>
                                <ul class="list-disc list-inside text-red-700 dark:text-red-400 text-sm space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Filters -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800 dark:to-gray-800 flex items-center justify-between">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <i class="fas fa-filter text-gray-400"></i>
                                Filter Reservations
                            </h3>
                            <a href="{{ route('hotel.bookings.index') }}"
                               class="text-xs text-violet-600 hover:text-violet-800 dark:text-violet-400 font-medium flex items-center gap-1">
                                <i class="fas fa-times"></i> Clear Filters
                            </a>
                        </div>
                        <form method="GET" action="{{ route('hotel.bookings.index') }}" class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1.5">Hotel</label>
                                    <select name="hotel_id"
                                            class="w-full border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl py-2.5 px-4 text-sm focus:ring-2 focus:ring-violet-500 focus:border-transparent">
                                        <option value="">All Hotels</option>
                                        @foreach($hotels as $hotel)
                                            <option value="{{ $hotel->id }}" {{ request('hotel_id') == $hotel->id ? 'selected' : '' }}>
                                                {{ $hotel->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1.5">Status</label>
                                    <select name="status"
                                            class="w-full border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl py-2.5 px-4 text-sm focus:ring-2 focus:ring-violet-500 focus:border-transparent">
                                        <option value="">All Status</option>
                                        <option value="pending"     {{ request('status') == 'pending'     ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed"   {{ request('status') == 'confirmed'   ? 'selected' : '' }}>Confirmed</option>
                                        <option value="cancelled"   {{ request('status') == 'cancelled'   ? 'selected' : '' }}>Cancelled</option>
                                        <option value="checked_in"  {{ request('status') == 'checked_in'  ? 'selected' : '' }}>Checked In</option>
                                        <option value="checked_out" {{ request('status') == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                                        <option value="completed"   {{ request('status') == 'completed'   ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1.5">Check-in From</label>
                                    <input type="date" name="check_in_date" value="{{ request('check_in_date') }}"
                                           class="w-full border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl py-2.5 px-4 text-sm focus:ring-2 focus:ring-violet-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-1.5">Check-out To</label>
                                    <input type="date" name="check_out_date" value="{{ request('check_out_date') }}"
                                           class="w-full border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl py-2.5 px-4 text-sm focus:ring-2 focus:ring-violet-500 focus:border-transparent">
                                </div>
                            </div>
                            <div class="flex justify-end mt-4">
                                <button type="submit"
                                        class="flex items-center gap-2 bg-violet-600 hover:bg-violet-700 text-white font-semibold py-2.5 px-6 rounded-xl transition-colors text-sm shadow-sm">
                                    <i class="fas fa-search"></i> Apply Filters
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Bookings Table -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">

                        <!-- Table Header -->
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-violet-50 to-purple-50 dark:from-violet-900/20 dark:to-purple-900/20 flex items-center justify-between">
                            <h3 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <i class="fas fa-list text-violet-500"></i>
                                All Reservations
                            </h3>
                            <span class="text-xs text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-700 px-3 py-1.5 rounded-full border border-gray-200 dark:border-gray-600">
                                {{ $bookings->total() }} bookings found
                            </span>
                        </div>

                        <!-- Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900/50">
                                    <tr>
                                        @foreach(['Booking ID','Guest','Hotel','Room','Check-in','Check-out','Guests','Total','Status','Actions'] as $th)
                                        <th class="px-5 py-3.5 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider whitespace-nowrap">
                                            {{ $th }}
                                        </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                                    @forelse($bookings as $booking)
                                    <tr class="table-row-hover">
                                        <!-- Booking ID -->
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <span class="text-sm font-bold text-violet-600 dark:text-violet-400 font-mono">
                                                {{ $booking->booking_id }}
                                            </span>
                                        </td>

                                        <!-- Guest -->
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-violet-100 to-purple-100 dark:from-violet-900/30 dark:to-purple-900/30 flex items-center justify-center flex-shrink-0">
                                                    <i class="fas fa-user text-violet-500 text-sm"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $booking->guest_name }}</p>
                                                    @if($booking->guest_email)
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $booking->guest_email }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Hotel -->
                                        <td class="px-5 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">
                                            {{ $booking->hotel->name ?? '—' }}
                                        </td>

                                        <!-- Room -->
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            @if($booking->room)
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg text-xs font-semibold">
                                                    <i class="fas fa-door-open text-[10px]"></i>
                                                    {{ $booking->room->room_number }}
                                                </span>
                                            @else
                                                <span class="text-xs text-gray-400 italic">Unassigned</span>
                                            @endif
                                        </td>

                                        <!-- Check-in -->
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-1.5 text-sm text-gray-700 dark:text-gray-300">
                                                <i class="fas fa-sign-in-alt text-gray-400 text-xs flex-shrink-0"></i>
                                                {{ $booking->check_in_date ? $booking->check_in_date->format('M d, Y') : '—' }}
                                            </div>
                                        </td>

                                        <!-- Check-out -->
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-1.5 text-sm text-gray-700 dark:text-gray-300">
                                                <i class="fas fa-sign-out-alt text-gray-400 text-xs flex-shrink-0"></i>
                                                {{ $booking->check_out_date ? $booking->check_out_date->format('M d, Y') : '—' }}
                                            </div>
                                        </td>

                                        <!-- Guests -->
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-xs font-semibold">
                                                <i class="fas fa-users text-[10px]"></i>
                                                {{ $booking->number_of_guests }}
                                            </span>
                                        </td>

                                        <!-- Total -->
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <span class="text-sm font-bold text-emerald-600 dark:text-emerald-400">
                                                ₱{{ number_format($booking->total_price, 2) }}
                                            </span>
                                        </td>

                                        <!-- Status -->
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            @php
                                                $statusMap = [
                                                    'confirmed'  => ['bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400',  'fa-check'],
                                                    'checked_in' => ['bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400',  'fa-door-open'],
                                                    'pending'    => ['bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-400','fa-clock'],
                                                    'cancelled'  => ['bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-400',           'fa-times'],
                                                    'checked_out'=> ['bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-400',       'fa-check-circle'],
                                                    'completed'  => ['bg-indigo-100 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-400','fa-flag-checkered'],
                                                ];
                                                [$cls, $ico] = $statusMap[$booking->status] ?? ['bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300','fa-circle'];
                                            @endphp
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold {{ $cls }}">
                                                <i class="fas {{ $ico }} text-[10px]"></i>
                                                {{ ucwords(str_replace('_', ' ', $booking->status)) }}
                                            </span>
                                        </td>

                                        <!-- Actions -->
                                        <td class="px-5 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-1">
                                                {{-- Assign room --}}
                                                @if(!$booking->room && $booking->status !== 'cancelled')
                                                <button type="button" onclick="openAssignModal({{ $booking->id }})"
                                                        title="Assign Room"
                                                        class="p-2 text-purple-600 dark:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-900/20 rounded-lg transition-colors">
                                                    <i class="fas fa-bed text-sm"></i>
                                                </button>
                                                @endif

                                                {{-- Confirm --}}
                                                @if($booking->status === 'pending')
                                                <form method="POST" action="{{ route('hotel.bookings.confirm', $booking) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" title="Confirm"
                                                            class="p-2 text-green-600 dark:text-green-400 hover:bg-green-50 dark:hover:bg-green-900/20 rounded-lg transition-colors">
                                                        <i class="fas fa-check text-sm"></i>
                                                    </button>
                                                </form>
                                                @endif

                                                {{-- Cancel --}}
                                                @if(in_array($booking->status, ['pending','confirmed']))
                                                <form method="POST" action="{{ route('hotel.bookings.cancel', $booking) }}" class="inline"
                                                      onsubmit="return confirm('Cancel this reservation?')">
                                                    @csrf
                                                    <button type="submit" title="Cancel"
                                                            class="p-2 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                                        <i class="fas fa-ban text-sm"></i>
                                                    </button>
                                                </form>
                                                @endif

                                                {{-- Check-in --}}
                                                @if($booking->status === 'confirmed')
                                                <form method="POST" action="{{ route('hotel.bookings.checkin', $booking) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" title="Check In"
                                                            class="p-2 text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors">
                                                        <i class="fas fa-sign-in-alt text-sm"></i>
                                                    </button>
                                                </form>
                                                @endif

                                                {{-- Check-out --}}
                                                @if($booking->status === 'checked_in')
                                                <form method="POST" action="{{ route('hotel.bookings.checkout', $booking) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" title="Check Out"
                                                            class="p-2 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 rounded-lg transition-colors">
                                                        <i class="fas fa-sign-out-alt text-sm"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10" class="px-6 py-16 text-center">
                                            <div class="max-w-sm mx-auto">
                                                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-violet-50 dark:bg-violet-900/20 flex items-center justify-center">
                                                    <i class="fas fa-calendar-times text-violet-400 text-2xl"></i>
                                                </div>
                                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">No Bookings Found</h3>
                                                <p class="text-gray-500 dark:text-gray-400 text-sm mb-6">No reservations match your filters, or none have been created yet.</p>
                                                <a href="{{ route('hotel.bookings.create') }}"
                                                   class="inline-flex items-center gap-2 text-sm text-violet-600 hover:text-violet-800 dark:text-violet-400 font-semibold">
                                                    <i class="fas fa-plus-circle"></i> Create New Reservation
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($bookings->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                            {{ $bookings->links() }}
                        </div>
                        @endif
                    </div>

                </div>
            </main>
        </div>
    </div>

    <script>
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        }
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }

        function openAssignModal(bookingId) {
            alert('Room assignment modal for booking: ' + bookingId);
        }
    </script>
</body>
</html>