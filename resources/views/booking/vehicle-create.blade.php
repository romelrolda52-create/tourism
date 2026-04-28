@php
    use App\Models\Vehicle;
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Vehicle | Tourism Portal</title>
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
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans">
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
        
        @include('layouts.sidebar-user')

        <!-- Mobile Menu Button -->
        <div class="lg:hidden fixed top-4 left-4 z-50">
            <button @click="sidebarOpen = !sidebarOpen" 
                    class="p-2 rounded-lg bg-white dark:bg-gray-800 shadow-lg text-gray-600 dark:text-gray-300">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center pl-12 lg:pl-0">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                                    <i class="fas fa-truck mr-3 text-emerald-600 dark:text-emerald-400"></i>
                                    Book Vehicle
                                </h1>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Dark Mode Toggle -->
                            <button onclick="toggleDarkMode()"
                                class="p-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                                <i class="fas fa-moon text-lg dark:hidden"></i>
                                <i class="fas fa-sun text-lg hidden dark:inline"></i>
                            </button>
                            
                            <!-- Back -->
                            <a href="{{ route('bookings.user.index') }}"
                                class="bg-gradient-to-r from-gray-600 to-gray-500 hover:from-gray-700 hover:to-gray-600 text-white font-semibold py-3 px-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-3">
                                <i class="fas fa-arrow-left text-lg"></i>
                                My Bookings
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="max-w-4xl mx-auto">
                    
                    <!-- Vehicle Info Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden mb-8 border border-gray-100 dark:border-gray-700">
                        <div class="md:flex">
                            <!-- Image -->
                            <div class="md:w-1/3 h-64 md:h-auto bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center">
                                @if($vehicle->image)
                                    <img src="{{ Storage::url($vehicle->image) }}" alt="{{ $vehicle->name }}" class="w-full h-full object-cover rounded-l-2xl md:rounded-l-none">
                                @else
                                    <i class="fas fa-{{ $vehicle->type == 'car' ? 'car' : ($vehicle->type == 'bus' ? 'bus' : 'truck') }} text-6xl text-white/70"></i>
                                @endif
                            </div>
                            <!-- Info -->
                            <div class="p-6 md:w-2/3">
                                <div class="flex items-center gap-2 mb-2">
                                    @if($vehicle->status == 'active')
                                    <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 text-xs font-bold rounded-full">
                                        <i class="fas fa-check-circle mr-1"></i> Active & Available
                                    </span>
                                    @else
                                    <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/50 text-yellow-700 dark:text-yellow-300 text-xs font-bold rounded-full">
                                        <i class="fas fa-wrench mr-1"></i> {{ ucfirst($vehicle->status) }}
                                    </span>
                                    @endif
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $vehicle->name }}</h2>
                                <div class="flex items-center gap-6 text-lg mb-3">
                                    <span class="flex items-center text-emerald-600 dark:text-emerald-400">
                                        <i class="fas fa-users mr-1"></i> {{ $vehicle->capacity }} seats
                                    </span>
                                    <span class="flex items-center text-blue-600 dark:text-blue-400">
                                        <i class="fas fa-car mr-1"></i> {{ ucfirst($vehicle->type) }}
                                    </span>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-4">{{ $vehicle->description }}</p>
                                <div class="bg-emerald-50 dark:bg-emerald-500/10 rounded-xl p-4 inline-block">
                                    <p class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">Price per trip</p>
                                    <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400">₱{{ number_format($vehicle->price_per_trip, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Form -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 border border-gray-100 dark:border-gray-700">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                            <i class="fas fa-clipboard-list mr-3 text-emerald-500"></i>
                            Transportation Booking
                        </h3>

                        <form action="{{ route('bookings.vehicle.store', $vehicle) }}" method="POST" class="space-y-6">
                            @csrf
                            
                            <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

                            <!-- Guest Information -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                        Full Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="guest_name" required 
                                        value="{{ Auth::user()->name }}"
                                        class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                        placeholder="Enter your full name">
                                </div>
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                        Email Address <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="guest_email" required 
                                        value="{{ Auth::user()->email }}"
                                        class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                        placeholder="Enter your email">
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="guest_phone" required 
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                                    placeholder="Enter your phone number">
                            </div>

                            <!-- Date Selection -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                        Travel Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="travel_date" required 
                                        min="{{ date('Y-m-d') }}"
                                        class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                </div>
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                        Return Date <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="return_date" required 
                                        class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                </div>
                            </div>

                            <div>
                                <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                    Number of Passengers <span class="text-red-500">*</span>
                                    <span class="text-xs text-gray-500 ml-1">(Max {{ $vehicle->capacity }})</span>
                                </label>
                                <select name="number_of_guests" required 
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                                    <option value="">Select number of passengers</option>
                                    @for($i = 1; $i <= $vehicle->capacity; $i++)
                                    <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'Passenger' : 'Passengers' }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div>
                                <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                    Special Requests <span class="text-gray-400 text-xs">(Optional)</span>
                                </label>
                                <textarea name="special_requests" rows="4" 
                                    class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent resize-none"
                                    placeholder="Pickup location, return time, special requirements..."></textarea>
                            </div>

                            <!-- Price Calculation Info -->
                            <div class="bg-emerald-50 dark:bg-emerald-500/10 rounded-xl p-4 border border-emerald-100 dark:border-emerald-500/20">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm text-emerald-600 dark:text-emerald-400 font-medium">Price per trip</p>
                                        <p class="text-xs text-emerald-500 dark:text-emerald-300">× number of passengers</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400">₱{{ number_format($vehicle->price_per_trip, 2) }}</p>
                                        <p class="text-xs text-emerald-500 dark:text-emerald-300">per trip</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex items-center gap-4 pt-4">
                                <button type="submit"
                                    class="flex-1 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 flex items-center justify-center gap-3">
                                    <i class="fas fa-truck text-lg"></i>
                                    Book Vehicle
                                </button>
                                <a href="{{ route('bookings.user.index') }}"
                                    class="px-6 py-4 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors font-medium">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <script>
        // Dark mode toggle
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        }

        // Initialize dark mode
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }
    </script>
</body>
</html>
