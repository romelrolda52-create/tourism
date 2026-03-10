@php
    use App\Models\Gallery;
@endphp

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery | Photo Management</title>
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

        @keyframes ripple {
            to {
                transform: scale(4);
                opacity: 0;
            }
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
                                    Photo Gallery
                                    <span class="ml-3 text-xs bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-300 font-bold px-3 py-1 rounded-full">PRO</span>
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1 flex items-center">
                                    <i class="fas fa-database text-xs mr-2"></i>
                                    {{ $galleries->total() }} photos • Last updated: {{ now()->format('M d, Y') }}
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
                            
                            <!-- Search -->
                            <div class="hidden md:block relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" 
                                       class="pl-10 pr-4 py-2.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-primary-500 w-64 text-sm transition-all"
                                       placeholder="Search photos...">
                            </div>
                            
                            <!-- Notifications -->
                            <button class="relative p-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                                <i class="fas fa-bell text-lg"></i>
                                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
                            
                           
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto scrollbar-thin p-6 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="max-w-7xl mx-auto">
                    
                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 card-hover border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Photos</p>
                                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $galleries->total() }}</h3>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                    <i class="fas fa-images text-blue-600 dark:text-blue-400 text-xl"></i>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-arrow-up text-green-500 mr-2"></i>
                                    <span class="text-green-600 dark:text-green-400 font-semibold">12%</span>
                                    <span class="text-gray-500 dark:text-gray-400 ml-2">from last month</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 card-hover border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Storage Used</p>
                                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white">4.2 GB</h3>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                                    <i class="fas fa-database text-purple-600 dark:text-purple-400 text-xl"></i>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 h-2 rounded-full" style="width: 65%"></div>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">65% of 10GB limit</p>
                            </div>
                        </div>
                        
                        
                        
                       
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

                    <!-- Gallery Header -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Gallery Collection</h2>
                            <p class="text-gray-600 dark:text-gray-300 mt-2">Manage and organize your visual content</p>
                        </div>

                         <!-- Upload Button -->
                            <button onclick="openUploadModal()"
                                class="bg-gradient-to-r from-primary-600 to-blue-500 hover:from-primary-700 hover:to-blue-600 text-white font-semibold py-3 px-5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-3 group">
                                <i class="fas fa-cloud-upload-alt text-lg"></i>
                                Upload Photo
                                <i class="fas fa-plus text-sm group-hover:rotate-90 transition-transform"></i>
                            </button>
                        <div class="flex items-center space-x-3 mt-4 md:mt-0">
                            <select class="appearance-none bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl py-2.5 pl-4 pr-10 text-gray-700 dark:text-gray-200 text-sm focus:ring-2 focus:ring-primary-500">
                                <option>Sort by: Newest</option>
                                <option>Sort by: Oldest</option>
                                <option>Sort by: Name</option>
                            </select>
                            <button class="p-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                <i class="fas fa-filter text-lg"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Gallery Grid -->
                    @if($galleries->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($galleries as $index => $gallery)
                        <div class="bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 card-hover border border-gray-100 dark:border-gray-700 animate-fade-in"
                             style="animation-delay: {{ $index * 0.05 }}s">
                            
                            <!-- Image Container -->
                            <div class="relative h-56 overflow-hidden bg-gray-100 dark:bg-gray-700">
                                <div class="image-container">
                                    @if($gallery->image_path)
                                        <img 
                                            src="{{ asset('storage/' . $gallery->image_path) }}"
                                            alt="{{ $gallery->title }}"
                                            class="w-full h-56 object-cover transition-all duration-500 hover:scale-110"
                                            onload="handleImageLoad(this)"
                                            onerror="handleImageError(this)"
                                            loading="lazy"
                                        >
                                    @endif
                                    
                                    <!-- Fallback placeholder -->
                                    <div class="image-placeholder">
                                        <div class="w-16 h-16 rounded-full bg-white/50 dark:bg-gray-800/50 flex items-center justify-center mb-3">
                                            <i class="fas fa-image text-gray-500 dark:text-gray-400 text-2xl"></i>
                                        </div>
                                        <p class="text-gray-600 dark:text-gray-300 text-sm text-center font-medium px-4">{{ $gallery->title }}</p>
                                    </div>
                                </div>
                                
                                <!-- Hover gradient -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 hover:opacity-100 transition-opacity duration-300"></div>
                            </div>

                            <!-- Content -->
                            <div class="p-5">
                                <div class="flex items-start justify-between mb-3">
                                    <h3 class="font-bold text-gray-900 dark:text-white text-lg truncate pr-2">{{ $gallery->title }}</h3>
                                @if(auth()->id() === $gallery->user_id || auth()->user()->role === 'admin')
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('gallery.edit', $gallery) }}" class="text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors p-1" title="Edit">
                                            <i class="fas fa-edit text-sm"></i>
                                        </a>
                                        
                                        <form action="{{ route('gallery.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Delete this photo?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors p-1">
                                                <i class="fas fa-trash-alt text-sm"></i>
                                            </button>
                                        </form>
                                    </div>
                                    @endif
                                </div>

                                @if($gallery->description)
                                <p class="text-gray-600 dark:text-gray-300 text-sm mb-4 line-clamp-2">{{ $gallery->description }}</p>
                                @else
                                <p class="text-gray-400 dark:text-gray-500 text-sm italic mb-4">No description</p>
                                @endif

                                <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary-500 to-blue-400 flex items-center justify-center text-white font-bold text-sm mr-3">
                                            {{ substr($gallery->user ? $gallery->user->name : 'U', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $gallery->user ? $gallery->user->name : 'Unknown' }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $gallery->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-3">
                                        <button class="text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors">
                                            <i class="fas fa-heart text-sm"></i>
                                        </button>
                                        <button class="text-gray-400 hover:text-blue-500 dark:hover:text-blue-400 transition-colors">
                                            <i class="fas fa-eye text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <!-- Empty State -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl p-12 text-center shadow-lg border border-gray-100 dark:border-gray-700 animate-bounce-in">
                        <div class="max-w-md mx-auto">
                            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-blue-100 to-blue-50 dark:from-blue-900/30 dark:to-blue-800/30 rounded-2xl flex items-center justify-center mb-6">
                                <i class="fas fa-images text-blue-500 dark:text-blue-400 text-3xl"></i>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">No Photos Yet</h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-8">Start building your gallery by uploading your first photo!</p>
                            <button onclick="openUploadModal()"
                                class="bg-gradient-to-r from-primary-600 to-blue-500 hover:from-primary-700 hover:to-blue-600 text-white font-semibold py-3.5 px-8 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 inline-flex items-center gap-3">
                                <i class="fas fa-cloud-upload-alt text-lg"></i>
                                Upload Your First Photo
                            </button>
                        </div>
                    </div>
                    @endif

                    <!-- Pagination -->
                    @if($galleries->hasPages())
                    <div class="mt-10 pt-8 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-600 dark:text-gray-300">
                                Showing {{ $galleries->firstItem() }} to {{ $galleries->lastItem() }} of {{ $galleries->total() }} photos
                            </p>
                            <div class="flex space-x-2">
                                @if($galleries->onFirstPage())
                                <button disabled class="px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-400 text-sm">
                                    <i class="fas fa-chevron-left mr-2"></i> Previous
                                </button>
                                @else
                                <a href="{{ $galleries->previousPageUrl() }}" class="px-4 py-2.5 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 text-sm">
                                    <i class="fas fa-chevron-left mr-2"></i> Previous
                                </a>
                                @endif
                                
                                @if($galleries->hasMorePages())
                                <a href="{{ $galleries->nextPageUrl() }}" class="px-4 py-2.5 bg-gradient-to-r from-primary-600 to-blue-500 text-white rounded-xl text-sm shadow-sm hover:shadow">
                                    Next <i class="fas fa-chevron-right ml-2"></i>
                                </a>
                                @else
                                <button disabled class="px-4 py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-400 rounded-xl text-sm">
                                    Next <i class="fas fa-chevron-right ml-2"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <!-- Upload Modal - Full Screen Overlay -->
    <div id="uploadModal" class="hidden fixed inset-0 z-[60] overflow-y-auto">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm transition-opacity" onclick="closeUploadModal()"></div>

        <!-- Modal Container - Centered with proper spacing -->
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-xl my-8 overflow-hidden">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center mr-3">
                                <i class="fas fa-cloud-upload-alt text-white text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-xl">Upload New Photo</h3>
                                <p class="text-blue-100 text-sm mt-0.5">Add a new photo to your gallery</p>
                            </div>
                        </div>
                        <button onclick="closeUploadModal()" class="text-white/80 hover:text-white hover:bg-white/20 rounded-lg p-2 transition-colors">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Form -->
                <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5" id="uploadForm">
                    @csrf

                    <!-- Photo Title -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                            <i class="fas fa-heading mr-2 text-blue-500"></i>
                            Photo Title <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-tag text-gray-400"></i>
                            </div>
                            <input type="text" name="title" required placeholder="Enter photo title"
                                class="w-full pl-11 pr-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                            <i class="fas fa-align-left mr-2 text-blue-500"></i>
                            Description <span class="text-gray-400 text-xs">(Optional)</span>
                        </label>
                        <textarea name="description" rows="3" placeholder="Tell the story behind this photo..."
                            class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none"></textarea>
                    </div>

                    <!-- Upload Photo -->
                    <div>
                        <label class="block text-gray-700 dark:text-gray-200 font-semibold text-sm mb-2">
                            <i class="fas fa-image mr-2 text-blue-500"></i>
                            Upload Photo <span class="text-red-500">*</span>
                        </label>
                        <div class="border-2 border-dashed border-gray-200 dark:border-gray-600 rounded-xl p-6 text-center hover:border-blue-400 dark:hover:border-blue-500 transition-all bg-gray-50 dark:bg-gray-700/30"
                             onclick="document.getElementById('imageInput').click()">
                            <input type="file" name="image" required accept="image/*"
                                class="hidden"
                                id="imageInput" onchange="previewImage(this)">
                            
                            <div id="uploadPlaceholder">
                                <div class="w-14 h-14 mx-auto mb-3 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                    <i class="fas fa-cloud-upload-alt text-blue-500 dark:text-blue-400 text-2xl"></i>
                                </div>
                                <p class="text-gray-700 dark:text-gray-200 font-medium mb-1">Click to upload or drag and drop</p>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">JPG, PNG, GIF, WebP (max 10MB)</p>
                            </div>
                            
                            <div id="imagePreview" class="hidden">
                                <div class="relative w-full h-48 overflow-hidden rounded-xl border-2 border-blue-200 dark:border-blue-700">
                                    <img id="previewImage" class="w-full h-full object-contain bg-gray-100 dark:bg-gray-700">
                                    <button type="button" onclick="event.stopPropagation(); removePreview()" 
                                            class="absolute top-2 right-2 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors shadow-lg">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-4 flex justify-end gap-3">
                        <button type="button" onclick="closeUploadModal()"
                            class="px-5 py-2.5 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 font-medium rounded-xl transition-colors flex items-center gap-2">
                            <i class="fas fa-times"></i>
                            Cancel
                        </button>
                        <button type="submit" form="uploadForm"
                            class="bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center gap-2">
                            <i class="fas fa-cloud-upload-alt"></i>
                            Upload Photo
                        </button>
                    </div>
                </form>
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

        // Upload modal functions
        function openUploadModal() {
            document.getElementById('uploadModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeUploadModal() {
            document.getElementById('uploadModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.getElementById('uploadForm').reset();
            // Reset preview
            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('uploadPlaceholder');
            if (preview) preview.classList.add('hidden');
            if (placeholder) placeholder.classList.remove('hidden');
            // Reset file input
            const fileInput = document.getElementById('imageInput');
            if (fileInput) fileInput.value = '';
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImage').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                    document.getElementById('uploadPlaceholder').classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removePreview() {
            const fileInput = document.getElementById('imageInput');
            const preview = document.getElementById('imagePreview');
            const placeholder = document.getElementById('uploadPlaceholder');
            const previewImg = document.getElementById('previewImage');
            
            if (fileInput) fileInput.value = '';
            if (preview) preview.classList.add('hidden');
            if (placeholder) placeholder.classList.remove('hidden');
            if (previewImg) previewImg.src = '';
        }

        // Close modal on ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeUploadModal();
        });

        // Close modal on backdrop click
        document.getElementById('uploadModal')?.addEventListener('click', (e) => {
            if (e.target.classList.contains('bg-black')) {
                closeUploadModal();
            }
        });
    </script>
</body>
</html>