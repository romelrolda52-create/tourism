@php
    use App\Models\Destination;
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tourist | Travel Management</title>
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
                        'bounce-in': 'bounceIn 0.5s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideIn: {
                            '0%': { transform: 'translateY(-10px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        },
                        bounceIn: {
                            '0%': { transform: 'scale(0.9)', opacity: '0' },
                            '70%': { transform: 'scale(1.05)' },
                            '100%': { transform: 'scale(1)', opacity: '1' },
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
        
        .sidebar-item.active {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
        }
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.15);
        }
        
        /* Image loading states */
        .image-container {
            position: relative;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #bae6fd 100%);
            background-size: 200% 200%;
            animation: gradient-shift 3s ease infinite;
        }
        
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        
        .image-container img {
            opacity: 0;
            transition: opacity 0.4s ease-in-out;
        }
        
        .image-container img.loaded {
            opacity: 1;
        }
        
        .image-placeholder {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 25%, #bae6fd 50%, #7dd3fc 75%, #0ea5e9 100%);
            background-size: 400% 400%;
            animation: gradient-shift 8s ease infinite;
        }
        
        .image-error {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 50%, #fca5a5 100%);
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
        
        .modal-enter {
            animation: modalEnter 0.3s ease-out forwards;
        }
        
        @keyframes modalEnter {
            from {
                opacity: 0;
                transform: translate(-50%, -48%) scale(0.96);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }

        /* Map container styling */
        #map {
            border-radius: 1rem;
            overflow: hidden;
            z-index: 1;
        }

        .leaflet-popup-content-wrapper {
            border-radius: 0.75rem;
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.2);
        }

        .leaflet-popup-content {
            margin: 1rem;
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
                                    <i class="fas fa-map-marked-alt mr-3 text-primary-600 dark:text-primary-400"></i>
                                    Tourist Destinations
                                    <span class="ml-3 text-xs bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 font-bold px-3 py-1 rounded-full">EXPLORE</span>
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
                            
                            <!-- Search -->
                            <div class="hidden md:block relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" 
                                       class="pl-10 pr-4 py-2.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-primary-500 w-64 text-sm transition-all"
                                       placeholder="Search destinations...">
                            </div>
                            
                            <!-- Notifications -->
                            <button class="relative p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                                <i class="fas fa-bell text-lg"></i>
                                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
                            
                            <!-- Add Destination Button -->
                            <a href="{{ route('destinations.create') }}"
                                class="bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-700 hover:to-teal-600 text-white font-semibold py-3 px-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-3 group">
                                <i class="fas fa-plus-circle text-lg"></i>
                                Add Destination
                                <i class="fas fa-arrow-right text-sm group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto scrollbar-thin p-6 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="max-w-7xl mx-auto">
                    
                   

                    
                    <!-- Destinations Header -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">All Destinations</h2>
                            <p class="text-gray-600 dark:text-gray-300 mt-2">Browse and manage travel destinations</p>
                        </div>
                        <div class="flex items-center space-x-3 mt-4 md:mt-0">
                            <select class="appearance-none bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl py-2.5 pl-4 pr-10 text-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-primary-500">
                                <option>All Destinations</option>
                                <option>Active Only</option>
                                <option>Inactive Only</option>
                            </select>
                            <button class="p-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-filter text-lg"></i>
                            </button>
                            <button class="p-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-th-large text-lg"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Destinations Grid -->
                    @if($destinations->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($destinations as $index => $destination)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 card-hover border border-gray-100 dark:border-gray-700 animate-fade-in"
                             style="animation-delay: {{ $index * 0.05 }}s">
                            
                            <!-- Image Container -->
                            <div class="relative h-56 overflow-hidden bg-gray-100 dark:bg-gray-700">
                                <div class="image-container">
                                    @if($destination->image)
                                        <img 
                                            src="{{ asset('storage/' . $destination->image) }}"
                                            alt="{{ $destination->name }}"
                                            class="w-full h-56 object-cover transition-all duration-500 hover:scale-110"
                                            onload="handleImageLoad(this)"
                                            onerror="handleImageError(this)"
                                            loading="lazy"
                                        >
                                    @endif
                                    
                                    <!-- Fallback placeholder -->
                                    <div class="image-placeholder">
                                        <div class="w-16 h-16 rounded-full bg-white/50 dark:bg-gray-800/50 flex items-center justify-center mb-3">
                                            <i class="fas fa-map-location-dot text-gray-500 dark:text-gray-400 text-2xl"></i>
                                        </div>
                                        <p class="text-gray-600 dark:text-gray-300 text-sm text-center font-medium px-4">{{ $destination->name }}</p>
                                    </div>
                                </div>
                                
                                <!-- Status Badge -->
                                <div class="absolute top-4 right-4">
                                    @if($destination->is_active)
                                    <span class="px-3 py-1.5 bg-emerald-500 text-white text-xs font-bold rounded-full shadow-lg">
                                        <i class="fas fa-check-circle mr-1"></i> Active
                                    </span>
                                    @else
                                    <span class="px-3 py-1.5 bg-gray-500 text-white text-xs font-bold rounded-full shadow-lg">
                                        <i class="fas fa-pause-circle mr-1"></i> Inactive
                                    </span>
                                    @endif
                                </div>

                                <!-- Price Tag -->
                                @if($destination->price)
                                <div class="absolute bottom-4 left-4">
                                    <div class="bg-white/95 dark:bg-gray-800/95 backdrop-blur-sm px-4 py-2 rounded-xl shadow-lg border border-white/20">
                                        <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Starting at</p>
                                        <p class="text-lg font-black text-emerald-600 dark:text-emerald-400">₱{{ number_format($destination->price, 2) }}</p>
                                    </div>
                                </div>
                                @endif
                                
                                <!-- Hover gradient -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300"></div>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <div class="mb-4">
                                    <h3 class="font-bold text-gray-900 dark:text-white text-xl mb-2">{{ $destination->name }}</h3>
                                    <div class="flex items-center text-gray-600 dark:text-gray-300 text-sm mb-3">
                                        <i class="fas fa-location-dot text-red-500 mr-2"></i>
                                        <span class="font-medium">{{ $destination->location }}</span>
                                    </div>
                                </div>

                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-2">
                                    {{ Str::limit($destination->description, 100) }}
                                </p>

                                <!-- Coordinates Badge -->
                                <div class="flex items-center space-x-2 mb-4 text-xs">
                                    <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-lg font-medium">
                                        <i class="fas fa-compass mr-1"></i>
                                        {{ number_format($destination->latitude, 4) }}°, {{ number_format($destination->longitude, 4) }}°
                                    </span>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-2 pt-4 border-t border-gray-100 dark:border-gray-700">
                                    <a href="{{ route('destinations.edit', $destination) }}" 
                                       class="flex-1 bg-amber-500 hover:bg-amber-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 text-center shadow-md hover:shadow-lg">
                                        <i class="fas fa-edit mr-2"></i>Edit
                                    </a>
                                    <button onclick="viewOnMap({{ $destination->latitude }}, {{ $destination->longitude }}, '{{ $destination->name }}')"
                                            class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 shadow-md hover:shadow-lg">
                                        <i class="fas fa-map-marker-alt mr-2"></i>View Map
                                    </button>
                                    <form action="{{ route('destinations.destroy', $destination) }}" method="POST" onsubmit="return confirm('Delete this destination?')" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200 shadow-md hover:shadow-lg">
                                            <i class="fas fa-trash-alt mr-2"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Alerts Section -->
                    @if(session('success') || $errors->any())
                    <div class="mb-8">
                        @if(session('success'))
                        <div class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 border-l-4 border-green-500 rounded-xl p-5 shadow-lg animate-fade-in">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-800/50 flex items-center justify-center mr-4">
                                    <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-lg"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-semibold text-green-800 dark:text-green-300 text-lg">Success!</h3>
                                    <p class="text-green-700 dark:text-green-400">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($errors->any())
                        <div class="bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 border-l-4 border-red-500 rounded-xl p-5 shadow-lg animate-fade-in mt-4">
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
                        @endif
                    </div>
                    @endif

                    <!-- Interactive Map Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-xl mb-8 border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                                    <i class="fas fa-map text-emerald-600 dark:text-emerald-400 mr-3"></i>
                                    Interactive Destinations Map
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Click on markers to view destination details</p>
                            </div>
                            <button onclick="map.setView([10.3157, 123.8854], 6)" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-200 transition-colors">
                                <i class="fas fa-compress-arrows-alt mr-2"></i>
                                Reset View
                            </button>
                        </div>
                        <div id="map" style="height: 500px; width: 100%;" class="rounded-xl shadow-inner"></div>
                    </div>

                    @else
                    <!-- Empty State -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-12 text-center shadow-lg border border-gray-100 dark:border-gray-700 animate-bounce-in">
                        <div class="max-w-md mx-auto">
                            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-emerald-100 to-teal-50 dark:from-emerald-900/30 dark:to-teal-800/30 rounded-2xl flex items-center justify-center mb-6">
                                <i class="fas fa-map-marked-alt text-emerald-500 dark:text-emerald-400 text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">No Destinations Yet</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-8">Start adding amazing travel destinations for your users to explore!</p>
                            <a href="{{ route('destinations.create') }}"
                                class="bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-700 hover:to-teal-600 text-white font-semibold py-3.5 px-8 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 inline-flex items-center gap-3">
                                <i class="fas fa-plus-circle text-lg"></i>
                                Add Your First Destination
                            </a>
                        </div>
                    </div>
                    @endif

                    
                </div>
            </main>
        </div>
    </div>

    <!-- Leaflet Map Script -->
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

        // Image handling functions
        function handleImageLoad(img) {
            img.classList.add('loaded');
            const placeholder = img.nextElementSibling;
            if (placeholder) {
                placeholder.style.display = 'none';
            }
        }

        function handleImageError(img) {
            img.style.display = 'none';
            const placeholder = img.nextElementSibling;
            if (placeholder) {
                placeholder.classList.add('image-error');
                placeholder.style.display = 'flex';
            }
        }

        // Initialize Leaflet Map
        const map = L.map('map').setView([10.3157, 123.8854], 6);

        // Add tile layer with dark mode support
        const isDarkMode = document.documentElement.classList.contains('dark');
        const tileUrl = isDarkMode 
            ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
            : 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';

        L.tileLayer(tileUrl, {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        // Custom marker icon
        const customIcon = L.divIcon({
            html: '<i class="fas fa-map-marker-alt text-3xl text-red-500" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);"></i>',
            iconSize: [30, 30],
            iconAnchor: [15, 30],
            popupAnchor: [0, -30],
            className: 'custom-marker'
        });

        // Add markers for each destination
        const destinations = @json($destinations);
        const markers = [];
        
        destinations.data.forEach(destination => {
            const marker = L.marker([destination.latitude, destination.longitude], {
                icon: customIcon
            }).addTo(map);
            
            let popupContent = `
                <div style="min-width: 250px; padding: 8px;">
                    <div style="display: flex; align-items: center; margin-bottom: 12px;">
                        <i class="fas fa-map-marker-alt text-red-500 text-xl mr-3"></i>
                        <h3 style="font-weight: bold; font-size: 18px; margin: 0;">${destination.name}</h3>
                    </div>
                    <div style="margin-bottom: 8px;">
                        <p style="color: #6b7280; margin: 0; display: flex; align-items: center;">
                            <i class="fas fa-location-dot text-gray-500 mr-2"></i>
                            ${destination.location}
                        </p>
                    </div>
                    <p style="color: #4b5563; margin-bottom: 12px; font-size: 14px;">${destination.description.substring(0, 100)}...</p>
                    ${destination.price ? `
                        <div style="background: linear-gradient(135deg, #10b981 0%, #14b8a6 100%); color: white; padding: 8px 12px; border-radius: 8px; margin-bottom: 12px;">
                            <p style="margin: 0; font-size: 12px; opacity: 0.9;">Starting at</p>
                            <p style="margin: 0; font-weight: bold; font-size: 20px;">₱${parseFloat(destination.price).toLocaleString('en-PH', {minimumFractionDigits: 2})}</p>
                        </div>
                    ` : ''}
                    <div style="display: flex; gap: 8px; margin-top: 12px;">
                        <span style="background: ${destination.is_active ? '#10b981' : '#6b7280'}; color: white; padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: 600;">
                            <i class="fas ${destination.is_active ? 'fa-check-circle' : 'fa-pause-circle'} mr-1"></i>
                            ${destination.is_active ? 'Active' : 'Inactive'}
                        </span>
                    </div>
                </div>
            `;
            
            marker.bindPopup(popupContent, {
                maxWidth: 300,
                className: 'custom-popup'
            });
            
            markers.push(marker);
        });

        // Fit map to show all markers if there are destinations
        if (destinations.data.length > 0) {
            const group = new L.featureGroup(markers);
            map.fitBounds(group.getBounds().pad(0.1));
        }

        // Function to view specific location on map
        function viewOnMap(lat, lng, name) {
            map.setView([lat, lng], 13);
            // Find and open the popup for this marker
            markers.forEach(marker => {
                const markerLatLng = marker.getLatLng();
                if (markerLatLng.lat === lat && markerLatLng.lng === lng) {
                    marker.openPopup();
                }
            });
            // Smooth scroll to map
            document.getElementById('map').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }

        // Update map tiles when dark mode changes
        function updateMapTiles() {
            const isDark = document.documentElement.classList.contains('dark');
            const newTileUrl = isDark 
                ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
                : 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
            
            map.eachLayer(function(layer) {
                if (layer instanceof L.TileLayer) {
                    map.removeLayer(layer);
                }
            });
            
            L.tileLayer(newTileUrl, {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);
        }

        // Listen for dark mode changes
        const originalToggleDarkMode = toggleDarkMode;
        toggleDarkMode = function() {
            originalToggleDarkMode();
            setTimeout(updateMapTiles, 100);
        };
    </script>
</body>
</html>