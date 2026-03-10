@php
    use App\Models\Destination;
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Destination | Travel Management</title>
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
        
        #map {
            border-radius: 0.75rem;
            z-index: 1;
        }
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
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center pl-12 lg:pl-0">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                                    <i class="fas fa-edit mr-3 text-emerald-600 dark:text-emerald-400"></i>
                                    Edit Destination
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Update destination details</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Dark Mode Toggle -->
                            <button onclick="toggleDarkMode()"
                                class="p-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                                <i class="fas fa-moon text-lg dark:hidden"></i>
                                <i class="fas fa-sun text-lg hidden dark:inline"></i>
                            </button>
                            
                            <!-- Back to Destinations -->
                            <a href="{{ route('destinations.index') }}"
                                class="bg-gradient-to-r from-gray-600 to-gray-500 hover:from-gray-700 hover:to-gray-600 text-white font-semibold py-3 px-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-3">
                                <i class="fas fa-arrow-left text-lg"></i>
                                Back to Destinations
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="max-w-5xl mx-auto">
                    
                    <!-- Alerts Section -->
                    @if($errors->any())
                    <div class="mb-8">
                        <div class="bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 border-l-4 border-red-500 rounded-xl p-5 shadow-lg">
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

                    <!-- Edit Form -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                        <form action="{{ route('destinations.update', $destination) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <!-- Left Column - Image Preview -->
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-3">
                                        Current Image
                                    </label>
                                    <div class="relative rounded-2xl overflow-hidden bg-gray-100 dark:bg-gray-700 h-72">
                                        @if($destination->image)
                                            <img 
                                                src="{{ asset('storage/' . $destination->image) }}"
                                                alt="{{ $destination->name }}"
                                                class="w-full h-72 object-cover"
                                            >
                                        @else
                                            <div class="w-full h-72 flex items-center justify-center">
                                                <div class="text-center">
                                                    <i class="fas fa-map-location-dot text-6xl text-gray-400 dark:text-gray-500 mb-4"></i>
                                                    <p class="text-gray-500 dark:text-gray-400">No image</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Replace Image -->
                                    <div class="mt-4">
                                        <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-3">
                                            Replace Image <span class="text-gray-400 text-xs">(Optional)</span>
                                        </label>
                                        <div class="border-2 border-dashed border-gray-200 dark:border-gray-600 rounded-xl p-4 text-center hover:border-emerald-400 transition-all bg-gray-50 dark:bg-gray-700/50">
                                            <input type="file" name="image" accept="image/*"
                                                class="block w-full text-sm text-gray-600 dark:text-gray-300
                                                       file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                                       file:text-sm file:font-semibold file:bg-emerald-500 file:text-white
                                                       hover:file:bg-emerald-600 cursor-pointer"
                                                id="imageInput" onchange="previewImage(this)">
                                            
                                            <div id="imagePreview" class="hidden mt-4">
                                                <div class="relative w-48 h-32 mx-auto overflow-hidden rounded-xl border-2 border-emerald-200">
                                                    <img id="previewImage" class="w-full h-full object-cover">
                                                    <button type="button" onclick="removePreview()" 
                                                            class="absolute top-1 right-1 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column - Form Fields -->
                                <div class="space-y-6">
                                    <!-- Name -->
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-3">
                                            Destination Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="name" required value="{{ old('name', $destination->name) }}" placeholder="Enter destination name"
                                            class="w-full px-4 py-3.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-emerald-500">
                                    </div>

                                    <!-- Location -->
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-3">
                                            Location <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <i class="fas fa-location-dot absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                            <input type="text" name="location" required value="{{ old('location', $destination->location) }}" placeholder="Enter location"
                                                class="w-full pl-12 pr-4 py-3.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-emerald-500">
                                        </div>
                                    </div>

                                    <!-- Price -->
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-3">
                                            Starting Price <span class="text-gray-400 text-xs">(Optional)</span>
                                        </label>
                                        <div class="relative">
                                            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">₱</span>
                                            <input type="number" name="price" step="0.01" min="0" value="{{ old('price', $destination->price) }}" placeholder="0.00"
                                                class="w-full pl-10 pr-4 py-3.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-emerald-500">
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-3">
                                            Description <span class="text-red-500">*</span>
                                        </label>
                                        <textarea name="description" rows="4" required placeholder="Describe the destination..."
                                            class="w-full px-4 py-3.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-emerald-500 resize-none">{{ old('description', $destination->description) }}</textarea>
                                    </div>

                                    <!-- Coordinates -->
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-3">
                                                Latitude <span class="text-red-500">*</span>
                                            </label>
                                            <input type="number" name="latitude" step="0.0001" required value="{{ old('latitude', $destination->latitude) }}" placeholder="-90 to 90"
                                                class="w-full px-4 py-3.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-emerald-500">
                                        </div>
                                        <div>
                                            <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-3">
                                                Longitude <span class="text-red-500">*</span>
                                            </label>
                                            <input type="number" name="longitude" step="0.0001" required value="{{ old('longitude', $destination->longitude) }}" placeholder="-180 to 180"
                                                class="w-full px-4 py-3.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-emerald-500">
                                        </div>
                                    </div>

                                    <!-- Map Preview -->
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-3">
                                            Location Preview
                                        </label>
                                        <div id="map" class="h-48 rounded-xl border border-gray-200 dark:border-gray-600"></div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                                        <button type="button" onclick="confirmDelete()"
                                            class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-medium rounded-xl flex items-center gap-2">
                                            <i class="fas fa-trash-alt"></i>
                                            Delete
                                        </button>
                                        
                                        <div class="flex gap-3">
                                            <a href="{{ route('destinations.index') }}"
                                                class="px-6 py-3 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium rounded-xl">
                                                Cancel
                                            </a>
                                            <button type="submit"
                                                class="bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-700 hover:to-teal-600 text-white font-semibold px-8 py-3 rounded-xl shadow-md hover:shadow-lg flex items-center gap-3">
                                                <i class="fas fa-save"></i>
                                                Save Changes
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-60 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
            <div class="bg-red-500 px-6 py-5">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-white font-bold text-xl">Delete Destination</h3>
                        <p class="text-red-100 text-sm mt-1">This action cannot be undone</p>
                    </div>
                    <button onclick="closeDeleteModal()" class="text-white hover:text-red-200 text-2xl">
                        &times;
                    </button>
                </div>
            </div>
            <div class="p-6">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center mr-4">
                        <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300">Are you sure you want to delete this destination? This will permanently remove it from the system.</p>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="px-6 py-2.5 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium rounded-xl">
                        Cancel
                    </button>
                    <form action="{{ route('destinations.destroy', $destination) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-6 py-2.5 bg-red-500 hover:bg-red-600 text-white font-medium rounded-xl">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet Map Script -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    
    <script>
        // Dark mode toggle
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
            updateMapTiles();
        }

        // Initialize dark mode
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }

        // Initialize Leaflet Map
        const latitude = {{ old('latitude', $destination->latitude) }};
        const longitude = {{ old('longitude', $destination->longitude) }};
        const map = L.map('map').setView([latitude, longitude], 13);

        // Add tile layer
        function updateMapTiles() {
            const isDark = document.documentElement.classList.contains('dark');
            const tileUrl = isDark 
                ? 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png'
                : 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
            
            map.eachLayer(function(layer) {
                if (layer instanceof L.TileLayer) {
                    map.removeLayer(layer);
                }
            });
            
            L.tileLayer(tileUrl, {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);
        }

        // Custom marker icon
        const customIcon = L.divIcon({
            html: '<i class="fas fa-map-marker-alt text-3xl text-red-500" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);"></i>',
            iconSize: [30, 30],
            iconAnchor: [15, 30],
            popupAnchor: [0, -30],
            className: 'custom-marker'
        });

        // Add marker
        const marker = L.marker([latitude, longitude], { icon: customIcon, draggable: true }).addTo(map);
        marker.bindPopup("{{ $destination->name }}").openPopup();

        // Update coordinates when marker is dragged
        marker.on('dragend', function(event) {
            const position = marker.getLatLng();
            document.querySelector('input[name="latitude"]').value = position.lat.toFixed(6);
            document.querySelector('input[name="longitude"]').value = position.lng.toFixed(6);
        });

        // Initial map tiles
        updateMapTiles();

        // Image preview
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImage').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removePreview() {
            document.getElementById('imageInput').value = '';
            document.getElementById('imagePreview').classList.add('hidden');
        }

        // Delete modal functions
        function confirmDelete() {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal on ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeDeleteModal();
        });

        // Close modal on backdrop click
        document.getElementById('deleteModal')?.addEventListener('click', (e) => {
            if (e.target.id === 'deleteModal') closeDeleteModal();
        });
    </script>
</body>
</html>

