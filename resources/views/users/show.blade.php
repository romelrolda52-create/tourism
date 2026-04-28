<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - {{ $user->name }} | Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div x-data="{ sidebarOpen: false }" class="flex">
        @include('layouts.sidebar-admin')

        <div class="flex-1 flex flex-col lg:ml-64">
            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="px-6 py-4">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('users.index') }}" class="p-2 text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                <i class="fas fa-user text-violet-600 mr-3"></i>
                                {{ $user->name }}
                            </h1>
                            <p class="text-sm text-gray-600 dark:text-gray-400">User Profile #{{ $user->id }}</p>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-8">
                <div class="max-w-4xl mx-auto space-y-8">
                    <!-- User Avatar Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg border border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-6">
                            <div class="flex-shrink-0">
                                <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-violet-500 to-purple-600 flex items-center justify-center text-white font-bold text-2xl shadow-xl mx-auto">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h2>
                                <p class="text-xl text-gray-600 dark:text-gray-400">{{ $user->email }}</p>
                                @if($user->role === 'admin')
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200 border border-blue-200 dark:border-blue-700 mt-2">
                                        <i class="fas fa-crown mr-1"></i> Admin
                                    </span>
                                @elseif($user->role === 'manager')
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold bg-amber-100 dark:bg-amber-900/50 text-amber-800 dark:text-amber-200 border border-amber-200 dark:border-amber-700 mt-2">
                                        <i class="fas fa-user-tie mr-1"></i> Manager
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-200 border border-green-200 dark:border-green-700 mt-2">
                                        <i class="fas fa-user mr-1"></i> User
                                    </span>
                                @endif
                            </div>
                            <div class="flex gap-3">
                                <a href="{{ route('users.edit', $user) }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete {{ $user->name }}?')" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Account Info</h3>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Member since:</span>
                                    <span class="font-semibold">{{ $user->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Last login:</span>
                                    <span class="font-semibold">{{ $user->updated_at->format('M d, Y H:i') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Status:</span>
                                    <span class="text-green-600 font-semibold">Active</span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Permissions</h3>
                            <ul class="space-y-2">
                                <li class="flex items-center">
                                    <i class="fas fa-check text-green-500 mr-3"></i>
                                    {{ ucfirst($user->role) }} access
                                </li>
                                @if($user->role === 'admin')
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-3"></i>
                                        Full system control
                                    </li>
                                @elseif($user->role === 'manager')
                                    <li class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-3"></i>
                                        Content & bookings management
                                    </li>
                                @endif
                            </ul>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg border border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Recent Activity</h3>
                            <div class="space-y-2 text-xs">
                                <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                    <span>Profile updated</span>
                                    <span>{{ $user->updated_at->diffForHumans() }}</span>
                                </div>
                                <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                    <span>Account created</span>
                                    <span>{{ $user->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bookings & Activity -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-8">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Recent Bookings</h3>
                            <div class="space-y-3">
                                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-hotel text-blue-600 dark:text-blue-400"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Hotel Booking</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Paradise Resort • 3 nights</p>
                                    </div>
                                    <span class="text-sm font-bold text-green-600">Confirmed</span>
                                </div>
                                <div class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-car text-green-600 dark:text-green-400"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-gray-900 dark:text-white">Transportation</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Airport Transfer</p>
                                    </div>
                                    <span class="text-sm font-bold text-blue-600">Scheduled</span>
                                </div>
                            </div>
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 text-center">
                                <a href="#" class="text-violet-600 dark:text-violet-400 hover:underline font-medium">View all bookings →</a>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-200 dark:border-gray-700 p-8">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Account Details</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Email</label>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl">
                                        <div class="flex items-center">
                                            <i class="fas fa-envelope text-gray-400 mr-3"></i>
                                            <span class="text-lg font-medium">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Role</label>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl">
                                        <span class="px-4 py-2 bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200 rounded-full text-sm font-bold">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">Joined</label>
                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-xl">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $user->created_at->format('M d, Y') }}</span>
                                            <span class="text-xs bg-green-100 dark:bg-green-900/50 text-green-800 px-2 py-1 rounded-full">
                                                Active {{ $user->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
