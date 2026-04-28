@php
    use App\Models\TourPackage;
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Tour Packages | Tourism Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: { 50: '#eff6ff', 500: '#3b82f6' }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.3s ease-in-out',
                        'bounce-in': 'bounceIn 0.5s ease-out',
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        bounceIn: { '0%': { transform: 'scale(0.9)', opacity: '0' }, '70%': { transform: 'scale(1.05)' }, '100%': { transform: 'scale(1)', opacity: '1' } }
                    }
                }
            }
        }
    </script>
    <style>
        * { -webkit-font-smoothing: antialiased; }
        .card-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-8px); box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); }
        .tour-card-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen lg:pl-64">
        @include('layouts.sidebar-user')

        <div class="flex-1">
            <!-- Header -->
            <header class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md sticky top-0 z-20 border-b border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                            <i class="fas fa-suitcase-rolling mr-3"></i>
                            Tour Packages
                        </h1>
                        <div class="flex items-center gap-3">
                            <button onclick="toggleDarkMode()" class="p-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                                <i class="fas fa-moon text-lg dark:hidden"></i>
                                <i class="fas fa-sun text-lg hidden dark:inline"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="p-8 max-w-7xl mx-auto">
                @if($tourPackages->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    @foreach($tourPackages as $index => $tourPackage)
                    <div class="group card-hover bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-xl border border-gray-100 dark:border-gray-700 hover:shadow-2xl transition-all duration-500" style="animation-delay: {{ $index * 0.1 }}s">
                        <div class="relative h-56 tour-card-bg overflow-hidden p-8">
                            @if($tourPackage->image)
                            <img src="{{ Storage::url($tourPackage->image) }}" alt="{{ $tourPackage->name }}" class="w-full h-full object-cover rounded-2xl group-hover:scale-110 transition-transform duration-500 absolute inset-0">
                            @endif
                            <div class="absolute bottom-4 left-4 right-4">
                                <span class="inline-flex items-center gap-2 bg-white/90 dark:bg-gray-900/90 backdrop-blur-sm px-4 py-2 rounded-2xl text-sm font-bold text-gray-800 dark:text-white shadow-lg">
                                    <i class="fas fa-calendar-days"></i>
                                    {{ $tourPackage->duration_days }} Days
                                </span>
                            </div>
                            <div class="absolute top-4 right-4">
                                <span class="px-3 py-1.5 bg-white/80 dark:bg-gray-900/80 backdrop-blur-sm rounded-full text-xs font-bold shadow-md">
                                    <i class="fas fa-circle text-emerald-400 text-xs mr-1"></i>
                                    {{ $tourPackage->remaining_slots }} slots left
                                </span>
                            </div>
                        </div>
                        <div class="p-8">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white leading-tight">{{ $tourPackage->name }}</h3>
                                @if($tourPackage->guide)
                                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                                    <i class="fas fa-user-tie text-indigo-400"></i>
                                    {{ $tourPackage->guide->name }}
                                </div>
                                @endif
                            </div>
                            @if($tourPackage->description)
                            <p class="text-gray-600 dark:text-gray-300 mb-6 line-clamp-3 leading-relaxed text-lg">{{ $tourPackage->description }}</p>
                            @endif
                            <div class="flex flex-wrap gap-2 mb-6">
                                @foreach($tourPackage->destinations->take(4) as $destination)
                                <span class="px-3 py-1.5 bg-indigo-100 dark:bg-indigo-900/50 text-indigo-700 dark:text-indigo-300 text-sm rounded-full font-medium">
                                    {{ Str::limit($destination->name, 12) }}
                                </span>
                                @endforeach
                                @if($tourPackage->destinations->count() > 4)
                                <span class="px-3 py-1.5 bg-gray-100 dark:bg-gray-700 text-gray-500 text-sm rounded-full font-medium">
                                    +{{ $tourPackage->destinations->count() - 4 }} more
                                </span>
                                @endif
                            </div>
                            <div class="flex items-center justify-between mb-8">
                                <div class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                    ${{ number_format($tourPackage->price, 2) }}
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-24 bg-emerald-100 dark:bg-emerald-900/50 rounded-full h-3 relative overflow-hidden">
                                        <div class="absolute inset-0 bg-emerald-500 rounded-full" style="width: {{ ($tourPackage->remaining_slots / $tourPackage->available_slots) * 100 }}%"></div>
                                    </div>
                                    <span class="text-sm font-bold text-emerald-600 dark:text-emerald-400">{{ $tourPackage->remaining_slots }}</span>
                                </div>
                            </div>
                            <div class="flex gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('tour-package.show', $tourPackage) }}" class="flex-1 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-2xl text-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                    <i class="fas fa-eye mr-2"></i> View Details
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-32">
                    <div class="w-32 h-32 mx-auto bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/30 rounded-3xl flex items-center justify-center mb-8 shadow-xl">
                        <i class="fas fa-suitcase-rolling text-4xl text-indigo-500 dark:text-indigo-400"></i>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">No Tour Packages Available</h2>
                    <p class="text-xl text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">Check back later for exciting tour packages and adventures!</p>
                </div>
                @endif
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
    </script>
</body>
</html>

