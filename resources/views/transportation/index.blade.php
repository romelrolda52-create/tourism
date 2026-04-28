<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transportation | Travel Management</title>
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
    <style>
        .table-row-hover:hover { background-color: rgba(139, 92, 246, 0.04); }
        .dark .table-row-hover:hover { background-color: rgba(139, 92, 246, 0.08); }
    </style>
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
                                <i class="fas fa-bus text-green-500"></i>
                                Transportation Management
<span class="text-xs bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 font-bold px-3 py-1 rounded-full">
                                    {{ $vehicles->count() }} Vehicles
                                </span>
                            </h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage vehicles and transportation bookings</p>
                        </div>
                        <a href="{{ route('transportation.create') }}" class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold py-2.5 px-6 rounded-xl shadow-sm hover:shadow-md transition-all">
                            <i class="fas fa-plus mr-2"></i>New Vehicle
                        </a>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="max-w-7xl mx-auto space-y-6">
                    <!-- Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Vehicles</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $vehicles->count() }}</p>
                                </div>
                                <i class="fas fa-truck text-3xl text-blue-500"></i>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active</p>
                                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $vehicles->where('status', 'active')->count() }}</p>
                                </div>
                                <i class="fas fa-check-circle text-3xl text-green-500"></i>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Capacity</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $vehicles->sum('capacity') }}</p>
                                </div>
                                <i class="fas fa-users text-3xl text-purple-500"></i>
                            </div>
                        </div>
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Bookings</p>
                                    <p class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">12</p>
                                </div>
                                <i class="fas fa-calendar-check text-3xl text-indigo-500"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Vehicles Table -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border overflow-hidden">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-white dark:from-gray-800">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">All Vehicles</h3>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900/50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Vehicle</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Capacity</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price/Trip</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($vehicles as $vehicle)
                                    <tr class="table-row-hover">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white">
                                                    <i class="fas fa-car text-xl"></i>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-gray-900 dark:text-white">{{ $vehicle->name }}</p>
                                                    <p class="text-sm text-gray-500">{{ $vehicle->description }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200 rounded-full text-sm font-medium">
                                                <i class="fas fa-car-side text-blue-500"></i>
                                                {{ ucfirst($vehicle->type) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $vehicle->capacity }} seats
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-lg font-bold text-emerald-600 dark:text-emerald-400">
                                                ₱{{ number_format($vehicle->price_per_trip, 2) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @php $statusColor = $vehicle->status == 'active' ? 'green' : ($vehicle->status == 'maintenance' ? 'yellow' : 'gray'); @endphp
                                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-{{ $statusColor }}-100 dark:bg-{{ $statusColor }}-900/30 text-{{ $statusColor }}-800 dark:text-{{ $statusColor }}-200">
                                                <i class="fas fa-circle text-{{ $statusColor }}-500 text-xs"></i>
                                                {{ ucfirst($vehicle->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('transportation.show', $vehicle) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('transportation.edit', $vehicle) }}" class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('transportation.destroy', $vehicle) }}" method="POST" class="inline" onsubmit="return confirm('Delete {{ $vehicle->name }}?')">
                                                    @csrf @method('DELETE')
                                                    <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                                <a href="{{ route('bookings.vehicle.create', $vehicle) }}" class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg ml-1" title="Book this vehicle">
                                                    <i class="fas fa-calendar-check"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-2xl flex items-center justify-center mb-4">
                                                    <i class="fas fa-truck text-gray-400 text-2xl"></i>
                                                </div>
                                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">No Vehicles</h3>
                                                <p class="text-gray-500 dark:text-gray-400 mb-6">Add your first vehicle to get started</p>
                                                <a href="{{ route('transportation.create') }}" class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-2 rounded-xl font-semibold hover:shadow-lg transition-all">
                                                    Add Vehicle
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
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
