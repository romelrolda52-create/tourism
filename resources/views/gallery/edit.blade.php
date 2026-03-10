@php
    use App\Models\Gallery;
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Photo | Photo Management</title>
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
        
        .sidebar-item.active {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
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
                                    <i class="fas fa-edit mr-3 text-primary-600 dark:text-primary-400"></i>
                                    Edit Photo
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">Update your photo details</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Dark Mode Toggle -->
                            <button onclick="toggleDarkMode()"
                                class="p-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                                <i class="fas fa-moon text-lg dark:hidden"></i>
                                <i class="fas fa-sun text-lg hidden dark:inline"></i>
                            </button>
                            
                            <!-- Back to Gallery -->
                            <a href="{{ route('gallery.index') }}"
                                class="bg-gradient-to-r from-gray-600 to-gray-500 hover:from-gray-700 hover:to-gray-600 text-white font-semibold py-3 px-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-3">
                                <i class="fas fa-arrow-left text-lg"></i>
                                Back to Gallery
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="max-w-4xl mx-auto">
                    
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

                    <!-- Edit Form -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                        <form action="{{ route('gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <!-- Image Preview -->
                                <div>
                                    <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-3">
                                        Current Image
                                    </label>
                                    <div class="relative rounded-2xl overflow-hidden bg-gray-100 dark:bg-gray-700 h-80">
                                        @if($gallery->image_path)
                                            <img 
                                                src="{{ asset('storage/' . $gallery->image_path) }}"
                                                alt="{{ $gallery->title }}"
                                                class="w-full h-80 object-cover"
                                            >
                                        @else
                                            <div class="w-full h-80 flex items-center justify-center">
                                                <div class="text-center">
                                                    <i class="fas fa-image text-6xl text-gray-400 dark:text-gray-500 mb-4"></i>
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
                                        <div class="border-2 border-dashed border-gray-200 dark:border-gray-600 rounded-xl p-4 text-center hover:border-primary-400 transition-all bg-gray-50 dark:bg-gray-700/50">
                                            <input type="file" name="image" accept="image/*"
                                                class="block w-full text-sm text-gray-600 dark:text-gray-300
                                                       file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                                       file:text-sm file:font-semibold file:bg-primary-500 file:text-white
                                                       hover:file:bg-primary-600 cursor-pointer"
                                                id="imageInput" onchange="previewImage(this)">
                                            
                                            <div id="imagePreview" class="hidden mt-4">
                                                <div class="relative w-40 h-40 mx-auto overflow-hidden rounded-xl border-2 border-primary-200">
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

                                <!-- Form Fields -->
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-3">
                                            Photo Title <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="title" required value="{{ old('title', $gallery->title) }}" placeholder="Enter a title"
                                            class="w-full px-4 py-3.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-primary-500">
                                    </div>

                                    <div>
                                        <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-3">
                                            Description <span class="text-gray-400 text-xs">(Optional)</span>
                                        </label>
                                        <textarea name="description" rows="4" placeholder="Tell the story..."
                                            class="w-full px-4 py-3.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-primary-500 resize-none">{{ old('description', $gallery->description) }}</textarea>
                                    </div>

                                    <!-- Photo Info -->
                                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl p-4">
                                        <h4 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center">
                                            <i class="fas fa-info-circle mr-2 text-primary-500"></i>
                                            Photo Information
                                        </h4>
                                        <div class="space-y-2 text-sm">
                                            <div class="flex justify-between">
                                                <span class="text-gray-500 dark:text-gray-400">Uploaded by:</span>
                                                <span class="text-gray-900 dark:text-white font-medium">{{ $gallery->user->name ?? 'Unknown' }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-500 dark:text-gray-400">Uploaded on:</span>
                                                <span class="text-gray-900 dark:text-white font-medium">{{ $gallery->created_at->format('M d, Y h:i A') }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-500 dark:text-gray-400">Last updated:</span>
                                                <span class="text-gray-900 dark:text-white font-medium">{{ $gallery->updated_at->format('M d, Y h:i A') }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                                        <button type="button" onclick="confirmDelete()"
                                            class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-medium rounded-xl flex items-center gap-2">
                                            <i class="fas fa-trash-alt"></i>
                                            Delete Photo
                                        </button>
                                        
                                        <div class="flex gap-3">
                                            <a href="{{ route('gallery.index') }}"
                                                class="px-6 py-3 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium rounded-xl">
                                                Cancel
                                            </a>
                                            <button type="submit"
                                                class="bg-gradient-to-r from-primary-600 to-blue-500 hover:from-primary-700 hover:to-blue-600 text-white font-semibold px-8 py-3 rounded-xl shadow-md hover:shadow-lg flex items-center gap-3">
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
                        <h3 class="text-white font-bold text-xl">Delete Photo</h3>
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
                    <p class="text-gray-600 dark:text-gray-300">Are you sure you want to delete this photo? This will permanently remove it from the gallery.</p>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeDeleteModal()"
                        class="px-6 py-2.5 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium rounded-xl">
                        Cancel
                    </button>
                    <form action="{{ route('gallery.destroy', $gallery) }}" method="POST">
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

