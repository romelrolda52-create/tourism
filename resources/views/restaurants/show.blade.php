<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant->name }} | Tourism Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: { 500: '#3b82f6', 600: '#2563eb' },
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans">
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
        @include('layouts.sidebar-admin')

        <div class="flex-1 flex flex-col overflow-hidden lg:pl-64">
            <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                                <i class="fas fa-utensils text-orange-500"></i>
                                {{ $restaurant->name }}
                            </h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Restaurant details and management</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('restaurants.edit', $restaurant) }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2.5 px-6 rounded-xl shadow-sm hover:shadow-md transition-all">
                                <i class="fas fa-edit mr-2"></i>Edit
                            </a>
                            <a href="{{ route('restaurants.index') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2.5 px-6 rounded-xl shadow-sm hover:shadow-md transition-all">
                                <i class="fas fa-list mr-2"></i>Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="max-w-5xl mx-auto space-y-8">
                    <!-- Main Header -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border p-8">
                        <div class="flex flex-col lg:flex-row lg:items-start lg:gap-8">
                            <div class="flex-shrink-0">
                                @if($restaurant->image)
                                <img src="{{ Storage::url($restaurant->image) }}" alt="{{ $restaurant->name }}" class="w-64 h-48 object-cover rounded-2xl shadow-2xl">
                                @else
                                <div class="w-64 h-48 bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-600 rounded-2xl flex items-center justify-center">
                                    <i class="fas fa-utensils text-4xl text-gray-400"></i>
                                </div>
                                @endif
                            </div>
                            <div class="flex-1 mt-6 lg:mt-0">
                                <div class="flex flex-wrap items-center gap-4 mb-6">
                                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $restaurant->name }}</h2>
                                    <span class="inline-flex items-center gap-1 px-4 py-2 bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-200 rounded-full text-sm font-semibold">
                                        <i class="fas fa-tag"></i>
                                        {{ ucfirst($restaurant->cuisine_type) }}
                                    </span>
                                    @php $status = $restaurant->status; $statusColor = $status == 'open' ? 'green' : ($status == 'maintenance' ? 'yellow' : 'gray'); @endphp
                                    <span class="inline-flex items-center gap-1 px-4 py-2 rounded-full text-sm font-bold bg-{{ $statusColor }}-100 dark:bg-{{ $statusColor }}-900/30 text-{{ $statusColor }}-800 dark:text-{{ $statusColor }}-200">
                                        <i class="fas fa-circle text-xs text-{{ $statusColor }}-500"></i>
                                        {{ ucfirst($status) }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                                    <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 dark:from-emerald-900/30 dark:to-emerald-800/30 p-6 rounded-2xl">
                                        <div class="flex items-center">
                                            <div class="p-3 bg-emerald-500 rounded-xl">
                                                <i class="fas fa-map-marker-alt text-white text-xl"></i>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-emerald-800 dark:text-emerald-200">Location</p>
                                                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $restaurant->location }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-gradient-to-r from-orange-50 to-orange-100 dark:from-orange-900/30 dark:to-orange-800/30 p-6 rounded-2xl">
                                        <div class="flex items-center">
                                            <div class="p-3 bg-orange-500 rounded-xl">
                                                <i class="fas fa-peso-sign text-white text-xl"></i>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-orange-800 dark:text-orange-200">Avg Price</p>
                                                <p class="text-2xl font-bold text-gray-900 dark:text-white">₱{{ number_format($restaurant->average_price, 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @if($restaurant->phone)
                                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/30 p-6 rounded-2xl">
                                        <div class="flex items-center">
                                            <div class="p-3 bg-blue-500 rounded-xl">
                                                <i class="fas fa-phone text-white text-xl"></i>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-blue-800 dark:text-blue-200">Phone</p>
                                                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $restaurant->phone }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($restaurant->email)
                                    <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 dark:from-indigo-900/30 dark:to-indigo-800/30 p-6 rounded-2xl">
                                        <div class="flex items-center">
                                            <div class="p-3 bg-indigo-500 rounded-xl">
                                                <i class="fas fa-envelope text-white text-xl"></i>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-sm font-medium text-indigo-800 dark:text-indigo-200">Email</p>
                                                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $restaurant->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description & Actions -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Description -->
                        <div class="lg:col-span-2">
                            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border p-8">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                                    <i class="fas fa-align-left text-gray-500"></i>
                                    Description
                                </h3>
                                <div class="prose dark:prose-invert max-w-none">
                                    <p class="text-lg leading-relaxed text-gray-700 dark:text-gray-300 whitespace-pre-wrap">
                                        {{ $restaurant->description ?: 'No description available.' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div>
                            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border p-8 sticky top-6">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">
                                    Quick Actions
                                </h3>
                                <div class="space-y-3">
                                    <a href="{{ route('restaurants.edit', $restaurant) }}" class="w-full bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 text-white py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center font-semibold">
                                        <i class="fas fa-edit mr-2"></i>
                                        Edit Restaurant
                                    </a>
                                    <form action="{{ route('restaurants.destroy', $restaurant) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete {{ $restaurant->name }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-full bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center font-semibold">
                                            <i class="fas fa-trash mr-2"></i>
                                            Delete Restaurant
                                        </button>
                                    </form>
                                    <a href="{{ route('restaurants.index') }}" class="w-full bg-gray-500 hover:bg-gray-600 text-white py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center font-semibold">
                                        <i class="fas fa-list mr-2"></i>
                                        View All Restaurants
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        if (localStorage.getItem('darkMode') === 'true') document.documentElement.classList.add('dark');
    </script>
</body>
</html>
