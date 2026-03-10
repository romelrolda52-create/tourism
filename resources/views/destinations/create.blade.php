<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($destination) ? 'Edit' : 'Add New' }} Destination | Travel Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
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
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.3s ease-in-out',
                        'slide-in': 'slideIn 0.3s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideIn: {
                            '0%': { transform: 'translateY(-10px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
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
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.15);
        }
        
        .scrollbar-thin::-webkit-scrollbar {
            width: 6px;
        }
        
        .scrollbar-thin::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        #map {
            height: 450px;
            width: 100%;
            border-radius: 1rem;
            overflow: hidden;
        }

        .leaflet-popup-content-wrapper {
            border-radius: 0.75rem;
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.2);
        }

        .image-preview-container {
            position: relative;
            width: 100%;
            max-width: 300px;
        }

        .image-preview {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 1rem;
            border: 2px solid #e5e7eb;
        }

        .dark .image-preview {
            border-color: #4b5563;
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans">
    <div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
        
        @if(auth()->user()->role === 'admin')
            @include('layouts.sidebar-admin')
        @else
            @include('layouts.sidebar-manager')
        @endif

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
                                    <i class="fas fa-{{ isset($destination) ? 'edit' : 'plus-circle' }} mr-3 text-emerald-500"></i>
                                    {{ isset($destination) ? 'Edit Destination' : 'Add New Destination' }}
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 flex items-center">
                                    <i class="fas fa-map-marker-alt text-xs mr-2"></i>
                                    {{ isset($destination) ? 'Update destination information' : 'Create a new travel destination' }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Dark Mode Toggle -->
                            <button onclick="toggleDarkMode()"
                                class="p-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                                <i class="fas fa-moon text-lg dark:hidden"></i>
                                <i class="fas fa-sun text-lg hidden dark:inline"></i>
                            </button>
                            
                            <!-- Back Button -->
                            <a href="{{ route('destinations.index') }}"
                                class="px-4 py-2.5 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors font-semibold flex items-center gap-2">
                                <i class="fas fa-arrow-left"></i>
                                Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto scrollbar-thin p-6 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="max-w-5xl mx-auto">

                    <!-- Alerts Section -->
                    @if($errors->any())
                    <div class="mb-8">
                        <div class="bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 border-l-4 border-red-500 rounded-xl p-5 shadow-lg animate-fade-in">
                            <div class="flex items-start">
                                <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-800/50 flex items-center justify-center mr-4 mt-1">
                                    <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-red-800 dark:text-red-300 text-lg mb-2">Please correct the following errors:</h3>
                                    <ul class="list-disc list-inside text-red-700 dark:text-red-400 space-y-1">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Form Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
                        
                        <!-- Form Header -->
                        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center text-white mr-4 shadow-lg">
                                    <i class="fas fa-map-marked-alt text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Destination Information</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">Fill in the details below</p>
                                </div>
                            </div>
                        </div>

                        <!-- Form Body -->
                        <form action="{{ isset($destination) ? route('destinations.update', $destination) : route('destinations.store') }}" 
                              method="POST" 
                              enctype="multipart/form-data"
                              class="p-6 space-y-6">
                            @csrf
                            @if(isset($destination))
                                @method('PUT')
                            @endif

                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                    Destination Name <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-map-pin text-gray-400"></i>
                                    </div>
                                    <input type="text" 
                                           name="name" 
                                           id="name" 
                                           value="{{ old('name', $destination->name ?? '') }}"
                                           class="w-full pl-12 pr-4 py-3.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                                           placeholder="e.g., Mayon Volcano"
                                           required>
                                </div>
                                @error('name')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Location -->
                            <div>
                                <label for="location" class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                    Location <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-location-dot text-gray-400"></i>
                                    </div>
                                    <input type="text" 
                                           name="location" 
                                           id="location" 
                                           value="{{ old('location', $destination->location ?? '') }}"
                                           class="w-full pl-12 pr-4 py-3.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                                           placeholder="e.g., Cebu City, Philippines"
                                           required>
                                </div>
                                @error('location')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Coordinates -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="latitude" class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                        Latitude <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-compass text-gray-400"></i>
                                        </div>
                                        <input type="number" 
                                               name="latitude" 
                                               id="latitude" 
                                               step="0.00000001"
                                               value="{{ old('latitude', $destination->latitude ?? '10.3157') }}"
                                               class="w-full pl-12 pr-4 py-3.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all font-mono"
                                               placeholder="10.3157"
                                               required>
                                    </div>
                                    @error('latitude')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="longitude" class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                        Longitude <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <i class="fas fa-compass text-gray-400"></i>
                                        </div>
                                        <input type="number" 
                                               name="longitude" 
                                               id="longitude" 
                                               step="0.00000001"
                                               value="{{ old('longitude', $destination->longitude ?? '123.8854') }}"
                                               class="w-full pl-12 pr-4 py-3.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all font-mono"
                                               placeholder="123.8854"
                                               required>
                                    </div>
                                    @error('longitude')
                                        <p class="text-red-500 text-sm mt-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Interactive Map -->
                            <div>
                                <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                    <i class="fas fa-map-marked-alt mr-2 text-emerald-500"></i>
                                    Select Location on Map
                                </label>
                                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/10 dark:to-cyan-900/10 p-4 rounded-xl border-2 border-emerald-200 dark:border-emerald-800">
                                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-3 flex items-center">
                                        <i class="fas fa-info-circle text-emerald-500 mr-2"></i>
                                        Click on the map or drag the marker to set coordinates
                                    </p>
                                    <div id="map" class="shadow-lg border-2 border-white dark:border-gray-700"></div>
                                </div>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                    Description <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute top-4 left-4 pointer-events-none">
                                        <i class="fas fa-align-left text-gray-400"></i>
                                    </div>
                                    <textarea name="description" 
                                              id="description" 
                                              rows="5"
                                              class="w-full pl-12 pr-4 py-3.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all resize-none"
                                              placeholder="Describe what makes this destination special..."
                                              required>{{ old('description', $destination->description ?? '') }}</textarea>
                                </div>
                                @error('description')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Price -->
                            <div>
                                <label for="price" class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                    Price (₱) <span class="text-gray-400 text-xs">(Optional)</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-peso-sign text-gray-400"></i>
                                    </div>
                                    <input type="number" 
                                           name="price" 
                                           id="price" 
                                           step="0.01"
                                           value="{{ old('price', $destination->price ?? '') }}"
                                           class="w-full pl-12 pr-4 py-3.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all"
                                           placeholder="0.00">
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Leave empty if no entrance fee
                                </p>
                                @error('price')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Image Upload -->
                            <div>
                                <label for="image" class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                                    Destination Image <span class="text-gray-400 text-xs">(Optional)</span>
                                </label>
                                <div class="border-3 border-dashed border-gray-200 dark:border-gray-600 rounded-2xl p-8 text-center hover:border-emerald-400 dark:hover:border-emerald-600 transition-all bg-gray-50 dark:bg-gray-700/30">
                                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center">
                                        <i class="fas fa-cloud-upload-alt text-emerald-500 dark:text-emerald-400 text-2xl"></i>
                                    </div>
                                    <p class="text-gray-700 dark:text-gray-200 font-medium mb-2">Click to upload or drag and drop</p>
                                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-4">PNG, JPG, WebP up to 10MB</p>
                                    <input type="file" 
                                           name="image" 
                                           id="image" 
                                           accept="image/*"
                                           class="block w-full text-sm text-gray-600 dark:text-gray-300
                                                  file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0
                                                  file:text-sm file:font-semibold file:bg-emerald-500 file:text-white
                                                  hover:file:bg-emerald-600 cursor-pointer transition-all"
                                           onchange="previewImage(this)">
                                    
                                    <!-- Image Preview -->
                                    <div id="imagePreview" class="mt-6 {{ (isset($destination) && $destination->image) ? '' : 'hidden' }}">
                                        <div class="image-preview-container mx-auto">
                                            <img id="previewImg" 
                                                 src="{{ isset($destination) && $destination->image ? asset('storage/' . $destination->image) : '' }}" 
                                                 alt="Preview" 
                                                 class="image-preview shadow-lg">
                                            <button type="button" 
                                                    onclick="removePreview()" 
                                                    class="absolute top-2 right-2 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors shadow-lg">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @error('image')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Active Status -->
                            <div class="bg-gray-50 dark:bg-gray-900/50 p-4 rounded-xl border border-gray-200 dark:border-gray-700">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           name="is_active" 
                                           value="1"
                                           {{ old('is_active', $destination->is_active ?? true) ? 'checked' : '' }}
                                           class="w-5 h-5 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500 dark:border-gray-600 dark:bg-gray-700">
                                    <span class="ml-3 text-gray-700 dark:text-gray-200 font-semibold">
                                        <i class="fas fa-check-circle text-emerald-500 mr-2"></i>
                                        Set as Active Destination
                                    </span>
                                </label>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 ml-8">
                                    Active destinations will be visible to users
                                </p>
                            </div>

                            <!-- Form Actions -->
                            <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex flex-col sm:flex-row gap-3 justify-end">
                                    <a href="{{ route('destinations.index') }}" 
                                       class="px-6 py-3 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 font-semibold rounded-xl transition-colors text-center border-2 border-gray-200 dark:border-gray-600">
                                        <i class="fas fa-times mr-2"></i>
                                        Cancel
                                    </a>
                                    <button type="submit"
                                            class="px-8 py-3 bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-700 hover:to-teal-600 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-3 group">
                                        <i class="fas fa-{{ isset($destination) ? 'save' : 'plus-circle' }} text-lg"></i>
                                        {{ isset($destination) ? 'Update Destination' : 'Create Destination' }}
                                        <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </main>
        </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
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

        // Get initial coordinates or default to Cebu
        const initialLat = parseFloat(document.getElementById('latitude').value) || 10.3157;
        const initialLng = parseFloat(document.getElementById('longitude').value) || 123.8854;

        // Initialize map
        const map = L.map('map').setView([initialLat, initialLng], 13);

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        // Custom marker icon
        const customIcon = L.divIcon({
            className: 'custom-marker',
            html: '<div style="background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%); width: 40px; height: 40px; border-radius: 50% 50% 50% 0; transform: rotate(-45deg); border: 3px solid white; box-shadow: 0 4px 12px rgba(0,0,0,0.3); display: flex; align-items: center; justify-content: center;"><i class="fas fa-map-marker-alt" style="color: white; transform: rotate(45deg); font-size: 20px;"></i></div>',
            iconSize: [40, 40],
            iconAnchor: [20, 40]
        });

        // Add draggable marker
        let marker = L.marker([initialLat, initialLng], {
            draggable: true,
            icon: customIcon
        }).addTo(map);

        // Add popup to marker
        marker.bindPopup(`
            <div style="text-align: center; padding: 8px;">
                <strong style="font-size: 14px;">Drag me to select location</strong><br>
                <small style="color: #6b7280;">or click anywhere on the map</small>
            </div>
        `).openPopup();

        // Update coordinates when marker is dragged
        marker.on('dragend', function(e) {
            const position = marker.getLatLng();
            document.getElementById('latitude').value = position.lat.toFixed(8);
            document.getElementById('longitude').value = position.lng.toFixed(8);
            updatePopup(position);
        });

        // Add marker on map click
        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            document.getElementById('latitude').value = e.latlng.lat.toFixed(8);
            document.getElementById('longitude').value = e.latlng.lng.toFixed(8);
            updatePopup(e.latlng);
        });

        // Update marker when coordinates are manually entered
        document.getElementById('latitude').addEventListener('change', updateMarker);
        document.getElementById('longitude').addEventListener('change', updateMarker);

        function updateMarker() {
            const lat = parseFloat(document.getElementById('latitude').value);
            const lng = parseFloat(document.getElementById('longitude').value);
            
            if (!isNaN(lat) && !isNaN(lng)) {
                marker.setLatLng([lat, lng]);
                map.setView([lat, lng], 13);
                updatePopup({lat, lng});
            }
        }

        function updatePopup(position) {
            marker.setPopupContent(`
                <div style="text-align: center; padding: 8px;">
                    <strong style="font-size: 14px; color: #10b981;">Location Selected</strong><br>
                    <small style="color: #6b7280;">
                        ${position.lat.toFixed(6)}, ${position.lng.toFixed(6)}
                    </small>
                </div>
            `);
        }

        // Image preview function
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Remove preview function
        function removePreview() {
            document.getElementById('image').value = '';
            document.getElementById('imagePreview').classList.add('hidden');
            document.getElementById('previewImg').src = '';
        }
    </script>
</body>
</html>