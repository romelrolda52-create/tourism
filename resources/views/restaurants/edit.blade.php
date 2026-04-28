<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit {{ $restaurant->name }} | Tourism Management</title>
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
                                Edit {{ $restaurant->name }}
                            </h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Update restaurant information</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('restaurants.show', $restaurant) }}" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2.5 px-6 rounded-xl shadow-sm hover:shadow-md transition-all">
                                <i class="fas fa-eye mr-2"></i>View
                            </a>
                            <a href="{{ route('restaurants.index') }}" class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold py-2.5 px-6 rounded-xl shadow-sm hover:shadow-md transition-all">
                                <i class="fas fa-arrow-left mr-2"></i>Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6">
                <div class="max-w-4xl mx-auto">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border overflow-hidden">
                        <form method="POST" action="{{ route('restaurants.update', $restaurant) }}" enctype="multipart/form-data" class="p-8 space-y-8">
                            @csrf @method('PUT')
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Restaurant Details</h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Left Column -->
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">
                                            Restaurant Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="name" value="{{ old('name', $restaurant->name) }}" required
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all"
                                            placeholder="Restaurant name">
                                        @error('name')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">
                                            Location <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="location" value="{{ old('location', $restaurant->location) }}" required
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all"
                                            placeholder="Location">
                                        @error('location')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">
                                            Cuisine Type <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="cuisine_type" value="{{ old('cuisine_type', $restaurant->cuisine_type) }}" required
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all"
                                            placeholder="Cuisine type">
                                        @error('cuisine_type')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">
                                            Average Price (PHP) <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class="fas fa-peso-sign text-gray-400"></i>
                                            </div>
                                            <input type="number" name="average_price" step="0.01" min="0" value="{{ old('average_price', $restaurant->average_price) }}" required
                                                class="w-full pl-10 pr-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all"
                                                placeholder="Average price">
                                        </div>
                                        @error('average_price')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">
                                            Status <span class="text-red-500">*</span>
                                        </label>
                                        <select name="status" required class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all">
                                            <option value="">Select status</option>
                                            <option value="open" {{ old('status', $restaurant->status) == 'open' ? 'selected' : '' }}>Open</option>
                                            <option value="closed" {{ old('status', $restaurant->status) == 'closed' ? 'selected' : '' }}>Closed</option>
                                            <option value="maintenance" {{ old('status', $restaurant->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                        </select>
                                        @error('status')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">
                                            Phone Number
                                        </label>
                                        <input type="tel" name="phone" value="{{ old('phone', $restaurant->phone) }}"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all"
                                            placeholder="Phone number">
                                        @error('phone')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">
                                            Email Address
                                        </label>
                                        <input type="email" name="email" value="{{ old('email', $restaurant->email) }}"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all"
                                            placeholder="Email address">
                                        @error('email')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-4">
                                            Description
                                        </label>
                                        <textarea name="description" rows="4" class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all resize-vertical"
                                            placeholder="Restaurant description...">{{ old('description', $restaurant->description) }}</textarea>
                                        @error('description')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 dark:text-gray-200 mb-2">
                                            Restaurant Image
                                        </label>
                                        <div x-data="{ imagePreview: '{{ $restaurant->image ? Storage::url($restaurant->image) : null }}' }">
                                            @if($restaurant->image)
                                            <img src="{{ Storage::url($restaurant->image) }}" alt="{{ $restaurant->name }}" class="w-48 h-32 object-cover rounded-xl shadow-md mb-4">
                                            @endif
                                            <input type="file" name="image" accept="image/*" 
                                                @change="imagePreview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
                                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white transition-all file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                                            <div x-show="imagePreview" class="mt-4 p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                                                <img :src="imagePreview" class="max-w-full h-48 object-cover rounded-lg shadow-md" alt="Preview">
                                            </div>
                                        </div>
                                        @error('image')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="pt-6 border-t border-gray-200 dark:border-gray-700 flex items-center justify-end gap-4">
                                <a href="{{ route('restaurants.show', $restaurant) }}" class="px-8 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-all font-semibold">
                                    <i class="fas fa-eye mr-2"></i>View Restaurant
                                </a>
                                <a href="{{ route('restaurants.index') }}" class="px-8 py-3 bg-indigo-500 hover:bg-indigo-600 text-white rounded-xl hover:shadow-lg transition-all font-semibold">
                                    <i class="fas fa-list mr-2"></i>Back to List
                                </a>
                                <button type="submit" class="bg-gradient-to-r from-orange-500 to-amber-600 hover:from-orange-600 hover:to-amber-700 text-white px-8 py-3 rounded-xl shadow-lg hover:shadow-xl transition-all font-semibold flex items-center">
                                    <i class="fas fa-save mr-2"></i>Update Restaurant
                                </button>
                            </div>
                        </form>
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
