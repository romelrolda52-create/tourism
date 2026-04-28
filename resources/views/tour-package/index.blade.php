@php
    use App\Models\TourPackage;
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tour Package Management | Tourism Management</title>
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
                    animation: {
                        'fade-in': 'fadeIn 0.3s ease-in-out',
                        'bounce-in': 'bounceIn 0.5s ease-out',
                        'slide-up': 'slideUp 0.4s ease-out',
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        bounceIn: { '0%': { transform: 'scale(0.9)', opacity: '0' }, '70%': { transform: 'scale(1.05)' }, '100%': { transform: 'scale(1)', opacity: '1' } },
                        slideUp: { '0%': { transform: 'translateY(20px)', opacity: '0' }, '100%': { transform: 'translateY(0)', opacity: '1' } }
                    }
                }
            }
        }
    </script>
    <style>
        * { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
        
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
        .package-card {
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        .package-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.25);
        }
        
        /* Stat card hover */
        .stat-card {
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.15);
        }
        
        /* Action buttons */
        .action-btn {
            transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        
        .action-btn:hover {
            transform: translateY(-2px) scale(1.05);
        }
        
        /* Slots bar animation */
        .slots-bar {
            transition: width 0.5s ease-out;
        }
        
        /* Image overlay gradient */
        .image-overlay {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .dark .image-overlay {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        }
        
        /* Line clamp utility */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        /* Animation delays */
        .delay-1 { animation-delay: 0.05s; }
        .delay-2 { animation-delay: 0.1s; }
        .delay-3 { animation-delay: 0.15s; }
        .delay-4 { animation-delay: 0.2s; }
        .delay-5 { animation-delay: 0.25s; }
        .delay-6 { animation-delay: 0.3s; }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 font-sans">
    <div x-data="{ sidebarOpen: false, searchTerm: '' }" class="relative">
        
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
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-r from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg">
                                <i class="fas fa-suitcase text-white text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                                    Tour Package Management
                                    <span class="text-xs bg-gradient-to-r from-indigo-100 to-purple-100 dark:from-indigo-900/50 dark:to-purple-900/50 text-indigo-700 dark:text-indigo-300 font-bold px-3 py-1 rounded-full shadow-sm">
                                        {{ $tourPackages->count() }} Packages
                                    </span>
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">
                                    <i class="fas fa-map mr-1"></i>
                                    Manage tour packages, availability, and bookings
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <!-- Dark Mode Toggle -->
                            <button onclick="toggleDarkMode()"
                                class="p-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-all duration-200">
                                <i class="fas fa-moon text-lg dark:hidden"></i>
                                <i class="fas fa-sun text-lg hidden dark:inline"></i>
                            </button>

                            <!-- Add Package Button -->
                            <a href="{{ route('tour-packages.create') }}"
                               class="bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold py-2.5 px-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2 group">
                                <i class="fas fa-plus-circle group-hover:scale-110 transition-transform"></i>
                                <span class="hidden sm:inline">Add Package</span>
                                <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
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
                    <div class="bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 border-l-4 border-emerald-500 rounded-xl p-5 shadow-lg animate-fade-in">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-800/50 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check-circle text-emerald-600 dark:text-emerald-400 text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-emerald-800 dark:text-emerald-300">Success!</h3>
                                <p class="text-emerald-700 dark:text-emerald-400 text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Error Messages -->
                    @if($errors->any())
                    <div class="bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 border-l-4 border-red-500 rounded-xl p-5 shadow-lg animate-fade-in">
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

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                        <!-- Total Packages -->
                        <div class="stat-card bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Total Packages</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $tourPackages->count() }}</p>
                                </div>
                                <div class="w-14 h-14 rounded-xl bg-gradient-to-r from-indigo-500 to-indigo-600 flex items-center justify-center shadow-md">
                                    <i class="fas fa-suitcase text-white text-2xl"></i>
                                </div>
                            </div>
                            <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                                <i class="fas fa-chart-line mr-1"></i> Total tour packages
                            </div>
                        </div>

                        <!-- Active Packages -->
                        <div class="stat-card bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Active</p>
                                    <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 mt-2">{{ $tourPackages->where('status', 'active')->count() }}</p>
                                </div>
                                <div class="w-14 h-14 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-500 flex items-center justify-center shadow-md">
                                    <i class="fas fa-check-circle text-white text-2xl"></i>
                                </div>
                            </div>
                            <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                                <i class="fas fa-circle text-emerald-500 text-[8px] mr-1"></i> Currently active
                            </div>
                        </div>

                        <!-- Total Destinations -->
                        <div class="stat-card bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Destinations</p>
                                    <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-2">{{ $tourPackages->sum(fn($p) => $p->destinations->count()) }}</p>
                                </div>
                                <div class="w-14 h-14 rounded-xl bg-gradient-to-r from-blue-500 to-cyan-500 flex items-center justify-center shadow-md">
                                    <i class="fas fa-map-marked-alt text-white text-2xl"></i>
                                </div>
                            </div>
                            <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                                <i class="fas fa-globe mr-1"></i> Unique destinations
                            </div>
                        </div>

                        <!-- Available Slots -->
                        <div class="stat-card bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Available Slots</p>
                                    <p class="text-3xl font-bold text-violet-600 dark:text-violet-400 mt-2">{{ $tourPackages->sum(fn($p) => $p->remaining_slots) }}</p>
                                </div>
                                <div class="w-14 h-14 rounded-xl bg-gradient-to-r from-violet-500 to-purple-500 flex items-center justify-center shadow-md">
                                    <i class="fas fa-calendar-check text-white text-2xl"></i>
                                </div>
                            </div>
                            <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                                <i class="fas fa-ticket-alt mr-1"></i> Open for booking
                            </div>
                        </div>
                    </div>

                    <!-- Search Bar -->
                    <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-md rounded-2xl p-5 shadow-lg border border-gray-100 dark:border-gray-700">
                        <div class="relative">
                            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            <input type="text" 
                                   x-model="searchTerm"
                                   placeholder="Search tour packages by name, destination, or guide..." 
                                   class="w-full pl-11 pr-4 py-3 border border-gray-200 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                        </div>
                    </div>

                    <!-- Tour Packages Grid -->
                    @if($tourPackages->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($tourPackages as $index => $tourPackage)
                        <div class="package-card bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg border border-gray-100 dark:border-gray-700 animate-slide-up" 
                             x-show="searchTerm === '' || $el.textContent.toLowerCase().includes(searchTerm.toLowerCase())"
                             x-transition.opacity.duration.300ms
                             style="animation-delay: {{ $index * 0.05 }}s">
                            
                            <!-- Image Section -->
                            <div class="relative h-48 image-overlay overflow-hidden">
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-24 h-24 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center shadow-xl border border-white/30">
                                        <i class="fas fa-suitcase text-4xl text-white drop-shadow-lg"></i>
                                    </div>
                                </div>
                                
                                <!-- Duration Badge -->
                                <div class="absolute top-4 left-4">
                                    <div class="bg-white/95 dark:bg-gray-900/90 backdrop-blur-sm px-3 py-1.5 rounded-full shadow-md flex items-center gap-1.5">
                                        <i class="fas fa-calendar-days text-indigo-500 text-xs"></i>
                                        <span class="text-xs font-bold text-gray-700 dark:text-gray-200">{{ $tourPackage->duration_days }} Days</span>
                                    </div>
                                </div>
                                
                                <!-- Status Badge -->
                                <div class="absolute top-4 right-4">
                                    @if($tourPackage->status === 'active')
                                    <span class="flex items-center gap-1.5 px-3 py-1.5 bg-emerald-500 text-white text-xs font-bold rounded-full shadow-lg">
                                        <i class="fas fa-circle text-[6px] animate-pulse"></i> 
                                        Active
                                    </span>
                                    @else
                                    <span class="flex items-center gap-1.5 px-3 py-1.5 bg-gray-500 text-white text-xs font-bold rounded-full shadow-lg">
                                        <i class="fas fa-circle text-[6px]"></i> 
                                        Inactive
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Content Section -->
                            <div class="p-5">
                                <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2 line-clamp-1">{{ $tourPackage->name }}</h3>
                                
                                <!-- Destinations -->
                                <div class="flex items-center gap-1.5 text-gray-500 dark:text-gray-400 text-sm mb-3">
                                    <i class="fas fa-map-marker-alt text-indigo-400 flex-shrink-0"></i>
                                    <span class="line-clamp-1">{{ $tourPackage->destinations->pluck('name')->implode(', ') }}</span>
                                </div>
                                
                                <!-- Description -->
                                @if($tourPackage->description)
                                <p class="text-gray-500 dark:text-gray-400 text-sm mb-4 line-clamp-2 leading-relaxed">
                                    {{ Str::limit($tourPackage->description, 90) }}
                                </p>
                                @endif
                                
                                <!-- Price and Guide -->
                                <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100 dark:border-gray-700">
                                    <div class="flex flex-col">
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Starting from</span>
                                        <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                                            ${{ number_format($tourPackage->price, 2) }}
                                        </div>
                                    </div>
                                    @if($tourPackage->guide)
                                    <div class="flex items-center gap-2 bg-gray-50 dark:bg-gray-700/50 px-3 py-2 rounded-lg">
                                        <i class="fas fa-user-tie text-indigo-400"></i>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">Tour Guide</p>
                                            <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">{{ $tourPackage->guide->name }}</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Slots Progress -->
                                <div class="mb-4">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400">
                                            <i class="fas fa-users mr-1"></i> Available Slots
                                        </span>
                                        <span class="text-xs font-bold text-gray-900 dark:text-white">
                                            {{ $tourPackage->remaining_slots }} / {{ $tourPackage->available_slots }}
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 overflow-hidden">
                                        <div class="slots-bar h-2 rounded-full bg-gradient-to-r from-emerald-500 to-teal-500" 
                                             style="width: {{ ($tourPackage->remaining_slots / max(1, $tourPackage->available_slots)) * 100 }}%">
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="grid grid-cols-4 gap-2">
                                    <a href="{{ route('bookings.create', ['tour_package_id' => $tourPackage->id]) }}" 
                                       class="action-btn flex flex-col items-center gap-1 py-2.5 bg-emerald-50 dark:bg-emerald-900/20 hover:bg-emerald-100 dark:hover:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 rounded-xl transition-all text-xs font-semibold group">
                                        <i class="fas fa-calendar-check group-hover:scale-110 transition-transform"></i>
                                        <span>Book</span>
                                    </a>
                                    <a href="{{ route('tour-package.show', $tourPackage) }}" 
                                       class="action-btn flex flex-col items-center gap-1 py-2.5 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/40 text-blue-600 dark:text-blue-400 rounded-xl transition-all text-xs font-semibold group">
                                        <i class="fas fa-eye group-hover:scale-110 transition-transform"></i>
                                        <span>View</span>
                                    </a>
                                    <a href="{{ route('tour-package.edit', $tourPackage) }}" 
                                       class="action-btn flex flex-col items-center gap-1 py-2.5 bg-amber-50 dark:bg-amber-900/20 hover:bg-amber-100 dark:hover:bg-amber-900/40 text-amber-600 dark:text-amber-400 rounded-xl transition-all text-xs font-semibold group">
                                        <i class="fas fa-edit group-hover:scale-110 transition-transform"></i>
                                        <span>Edit</span>
                                    </a>
                                    <form action="{{ route('tour-package.destroy', $tourPackage) }}" method="POST" class="block" onsubmit="return confirm('Are you sure you want to delete " . addslashes($tourPackage->name) . "? This action cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="action-btn w-full flex flex-col items-center gap-1 py-2.5 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/40 text-red-600 dark:text-red-400 rounded-xl transition-all text-xs font-semibold group">
                                            <i class="fas fa-trash group-hover:scale-110 transition-transform"></i>
                                            <span>Delete</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    @else
                    <!-- Empty State -->
                    <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-md rounded-2xl p-16 text-center shadow-lg border border-gray-100 dark:border-gray-700 animate-bounce-in">
                        <div class="max-w-md mx-auto">
                            <div class="w-28 h-28 mx-auto bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-800/30 rounded-3xl flex items-center justify-center mb-6 shadow-inner">
                                <i class="fas fa-suitcase text-indigo-500 dark:text-indigo-400 text-5xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">No Tour Packages Yet</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-8">Start creating amazing tour packages for your customers!</p>
                            <a href="{{ route('tour-packages.create') }}" 
                               class="inline-flex items-center gap-3 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold py-3.5 px-8 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 group">
                                <i class="fas fa-plus-circle text-lg group-hover:scale-110 transition-transform"></i>
                                Create First Package
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
        
        // Animate slots bars on load
        document.addEventListener('DOMContentLoaded', function() {
            const slotsBars = document.querySelectorAll('.slots-bar');
            slotsBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0%';
                setTimeout(() => {
                    bar.style.width = width;
                }, 100);
            });
        });
    </script>
</body>
</html>