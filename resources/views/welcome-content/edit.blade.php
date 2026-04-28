<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page Content | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: { 50:'#eff6ff', 100:'#dbeafe', 500:'#3b82f6', 600:'#2563eb', 700:'#1d4ed8' }
                    },
                    animation: { 'fade-in': 'fadeIn 0.3s ease-in-out' },
                    keyframes: {
                        fadeIn: { '0%': { opacity:'0' }, '100%': { opacity:'1' } }
                    }
                }
            }
        }
    </script>
    <style>
        * { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
        
        /* Prevent body from scrolling */
        body {
            overflow: hidden;
            height: 100vh;
        }
        
        /* Main content scrollbar */
        .main-content-scroll {
            overflow-y: auto;
            scrollbar-width: thin;
        }
        
        .main-content-scroll::-webkit-scrollbar {
            width: 6px;
        }
        
        .main-content-scroll::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }
        
        .main-content-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        
        .main-content-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        
        .dark .main-content-scroll::-webkit-scrollbar-track {
            background: #1f2937;
        }
        
        .dark .main-content-scroll::-webkit-scrollbar-thumb {
            background: #4b5563;
        }
        
        .dark .main-content-scroll::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }

        /* Sticky save bar */
        .sticky-bar {
            position: sticky;
            bottom: 1rem;
            z-index: 10;
        }
        
        /* Fix for sidebar container */
        .sidebar-container {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 16rem; /* w-64 */
            z-index: 40;
        }
        
        /* Main content wrapper */
        .main-wrapper {
            margin-left: 16rem; /* w-64 */
            width: calc(100% - 16rem);
            height: 100vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        
        /* Responsive adjustments */
        @media (max-width: 1023px) {
            .sidebar-container {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }
            
            .sidebar-container.open {
                transform: translateX(0);
            }
            
            .main-wrapper {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-sans">
    <div x-data="{ sidebarOpen: false }" class="relative">
        
        <!-- Sidebar Component -->
        <div class="sidebar-container bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 shadow-xl"
             :class="{'open': sidebarOpen}">
            @if(auth()->user()->role === 'admin')
                @include('layouts.sidebar-admin')
            @else
                @include('layouts.sidebar-manager')
            @endif
        </div>

        <!-- Mobile Menu Button -->
        <div class="lg:hidden fixed top-4 left-4 z-50">
            <button @click="sidebarOpen = !sidebarOpen"
                    class="p-2.5 rounded-xl bg-white dark:bg-gray-800 shadow-lg text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
        
        <!-- Mobile Overlay -->
        <div x-show="sidebarOpen"
             @click="sidebarOpen = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden"
             style="display: none;">
        </div>

        <!-- Main Content Wrapper -->
        <div class="main-wrapper">
            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm flex-shrink-0">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center pl-12 lg:pl-0">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                                    <i class="fas fa-edit text-primary-600 dark:text-primary-400"></i>
                                    Welcome Page Content
                                    <span class="text-xs bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-bold px-3 py-1 rounded-full">EDIT</span>
                                </h1>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                                    Manage the content displayed on the public welcome page
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <button onclick="toggleDarkMode()"
                                class="p-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                                <i class="fas fa-moon text-lg dark:hidden"></i>
                                <i class="fas fa-sun text-lg hidden dark:inline"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Scrollable Main Content Area -->
            <main class="flex-1 main-content-scroll p-6 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="max-w-5xl mx-auto space-y-6 pb-8">

                    <!-- Success Alert -->
                    @if(session('success'))
                    <div class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 border-l-4 border-green-500 rounded-xl p-5 shadow-sm animate-fade-in">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-800/50 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-green-800 dark:text-green-300">Success!</h3>
                                <p class="text-green-700 dark:text-green-400 text-sm">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 border-l-4 border-red-500 rounded-xl p-5 shadow-sm animate-fade-in">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-800/50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-red-800 dark:text-red-300 mb-1">Please correct the following errors:</h3>
                                <ul class="list-disc list-inside text-red-700 dark:text-red-400 text-sm space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- ===================== FORM ===================== -->
                    <form action="{{ route('welcome-content.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">

                            {{-- ── 1. HERO SECTION ── --}}
                            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-home text-emerald-600 dark:text-emerald-400"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Hero Section</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Main banner content</p>
                                    </div>
                                </div>
                                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">Title <span class="text-xs text-gray-400 font-normal">(HTML supported)</span></label>
                                        <input type="text" name="hero_title" value="{{ old('hero_title', $content->hero_title) }}"
                                               class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">Button 1 Text</label>
                                        <input type="text" name="hero_button_text" value="{{ old('hero_button_text', $content->hero_button_text) }}"
                                               class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">Button 1 Link</label>
                                        <input type="text" name="hero_button_link" value="{{ old('hero_button_link', $content->hero_button_link) }}"
                                               class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">Button 2 Text</label>
                                        <input type="text" name="hero_button2_text" value="{{ old('hero_button2_text', $content->hero_button2_text) }}"
                                               class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">Button 2 Link</label>
                                        <input type="text" name="hero_button2_link" value="{{ old('hero_button2_link', $content->hero_button2_link) }}"
                                               class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">Description</label>
                                        <textarea name="hero_description" rows="3"
                                                  class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm resize-none">{{ old('hero_description', $content->hero_description) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- ── 2. STATS SECTION ── --}}
                            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-chart-bar text-blue-600 dark:text-blue-400"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Stats Section</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Numbers displayed in the hero banner</p>
                                    </div>
                                </div>
                                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                                    @foreach([1,2,3,4] as $i)
                                    <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-100 dark:border-gray-700">
                                        <h4 class="text-sm font-bold text-gray-700 dark:text-gray-200 mb-3 flex items-center gap-2">
                                            <span class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 text-xs flex items-center justify-center font-bold">{{ $i }}</span>
                                            Stat {{ $i }}
                                        </h4>
                                        <div class="space-y-2">
                                            <input type="text" name="stats_title{{ $i }}" value="{{ old('stats_title'.$i, $content->{'stats_title'.$i}) }}"
                                                   placeholder="Label (e.g. Happy Clients)"
                                                   class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-primary-500 text-sm">
                                            <input type="text" name="stats_value{{ $i }}" value="{{ old('stats_value'.$i, $content->{'stats_value'.$i}) }}"
                                                   placeholder="Value (e.g. 5,000+)"
                                                   class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-primary-500 text-sm">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            {{-- ── 3. ABOUT / FEATURES SECTION ── --}}
                            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-violet-50 to-purple-50 dark:from-violet-900/20 dark:to-purple-900/20 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-violet-100 dark:bg-violet-900/40 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-info-circle text-violet-600 dark:text-violet-400"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-bold text-gray-900 dark:text-white">About / Features Section</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Why choose us section</p>
                                    </div>
                                </div>
                                <div class="p-6 space-y-5">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">Title</label>
                                            <input type="text" name="about_title" value="{{ old('about_title', $content->about_title) }}"
                                                   class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-primary-500 text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">Subtitle</label>
                                            <textarea name="about_subtitle" rows="2"
                                                      class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-primary-500 text-sm resize-none">{{ old('about_subtitle', $content->about_subtitle) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach([1,2,3,4] as $i)
                                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-100 dark:border-gray-700">
                                            <h4 class="text-sm font-bold text-gray-700 dark:text-gray-200 mb-3 flex items-center gap-2">
                                                <span class="w-6 h-6 rounded-full bg-violet-100 dark:bg-violet-900/40 text-violet-600 dark:text-violet-400 text-xs flex items-center justify-center font-bold">{{ $i }}</span>
                                                Feature {{ $i }}
                                            </h4>
                                            <div class="space-y-2">
                                                <input type="text" name="about_feature{{ $i }}_title" value="{{ old('about_feature'.$i.'_title', $content->{'about_feature'.$i.'_title'}) }}"
                                                       placeholder="Feature title"
                                                       class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-primary-500 text-sm">
                                                <textarea name="about_feature{{ $i }}_desc" rows="2" placeholder="Feature description"
                                                          class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-primary-500 text-sm resize-none">{{ old('about_feature'.$i.'_desc', $content->{'about_feature'.$i.'_desc'}) }}</textarea>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- ── 4. DESTINATIONS SECTION ── --}}
                            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-emerald-50 to-cyan-50 dark:from-emerald-900/20 dark:to-cyan-900/20 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-map-marked-alt text-emerald-600 dark:text-emerald-400"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Destinations Section</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Featured destinations heading</p>
                                    </div>
                                </div>
                                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">Title</label>
                                        <input type="text" name="destinations_title" value="{{ old('destinations_title', $content->destinations_title) }}"
                                               class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-primary-500 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">Subtitle</label>
                                        <textarea name="destinations_subtitle" rows="2"
                                                  class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-primary-500 text-sm resize-none">{{ old('destinations_subtitle', $content->destinations_subtitle) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- ── 5. SERVICES SECTION ── --}}
                            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-cogs text-amber-600 dark:text-amber-400"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Services Section</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">What we offer</p>
                                    </div>
                                </div>
                                <div class="p-6 space-y-5">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">Title</label>
                                            <input type="text" name="services_title" value="{{ old('services_title', $content->services_title) }}"
                                                   class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-primary-500 text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">Subtitle</label>
                                            <textarea name="services_subtitle" rows="2"
                                                      class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-primary-500 text-sm resize-none">{{ old('services_subtitle', $content->services_subtitle) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        @foreach([1,2,3] as $i)
                                        <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-100 dark:border-gray-700">
                                            <h4 class="text-sm font-bold text-gray-700 dark:text-gray-200 mb-3 flex items-center gap-2">
                                                <span class="w-6 h-6 rounded-full bg-amber-100 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 text-xs flex items-center justify-center font-bold">{{ $i }}</span>
                                                Service {{ $i }}
                                            </h4>
                                            <div class="space-y-2">
                                                <input type="text" name="services_service{{ $i }}_title" value="{{ old('services_service'.$i.'_title', $content->{'services_service'.$i.'_title'}) }}"
                                                       placeholder="Service title"
                                                       class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-primary-500 text-sm">
                                                <textarea name="services_service{{ $i }}_desc" rows="2" placeholder="Service description"
                                                          class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg focus:ring-2 focus:ring-primary-500 text-sm resize-none">{{ old('services_service'.$i.'_desc', $content->{'services_service'.$i.'_desc'}) }}</textarea>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- ── 6. CTA SECTION ── --}}
                            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-pink-50 to-rose-50 dark:from-pink-900/20 dark:to-rose-900/20 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-pink-100 dark:bg-pink-900/40 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-bullhorn text-pink-600 dark:text-pink-400"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-bold text-gray-900 dark:text-white">CTA Section</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Call to action banner</p>
                                    </div>
                                </div>
                                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">Title</label>
                                        <input type="text" name="cta_title" value="{{ old('cta_title', $content->cta_title) }}"
                                               class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-primary-500 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">Subtitle</label>
                                        <textarea name="cta_subtitle" rows="2"
                                                  class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-primary-500 text-sm resize-none">{{ old('cta_subtitle', $content->cta_subtitle) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- ── 7. FOOTER SECTION ── --}}
                            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-gray-50 to-slate-50 dark:from-gray-800 dark:to-slate-800 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-gray-200 dark:bg-gray-700 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-layer-group text-gray-600 dark:text-gray-400"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Footer Section</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Brand info, contact, and links</p>
                                    </div>
                                </div>
                                <div class="p-6 space-y-6">

                                    <!-- Brand + Contact -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">Brand Name</label>
                                            <input type="text" name="footer_brand" value="{{ old('footer_brand', $content->footer_brand) }}"
                                                   class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-primary-500 text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">Email</label>
                                            <input type="text" name="footer_email" value="{{ old('footer_email', $content->footer_email) }}"
                                                   class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-primary-500 text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">Phone</label>
                                            <input type="text" name="footer_phone" value="{{ old('footer_phone', $content->footer_phone) }}"
                                                   class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-primary-500 text-sm">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">Address</label>
                                            <input type="text" name="footer_address" value="{{ old('footer_address', $content->footer_address) }}"
                                                   class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-primary-500 text-sm">
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">Description</label>
                                            <textarea name="footer_description" rows="2"
                                                      class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-primary-500 text-sm resize-none">{{ old('footer_description', $content->footer_description) }}</textarea>
                                        </div>
                                    </div>

                                    <!-- Quick Links -->
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-700 dark:text-gray-200 mb-3 flex items-center gap-2">
                                            <i class="fas fa-link text-gray-400 text-xs"></i> Quick Links
                                        </h4>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                            @foreach([1,2,3,4] as $i)
                                            <input type="text" name="footer_link{{ $i }}_text" value="{{ old('footer_link'.$i.'_text', $content->{'footer_link'.$i.'_text'}) }}"
                                                   placeholder="Link {{ $i }} text"
                                                   class="px-3 py-2.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm focus:ring-2 focus:ring-primary-500">
                                            <input type="text" name="footer_link{{ $i }}_url" value="{{ old('footer_link'.$i.'_url', $content->{'footer_link'.$i.'_url'}) }}"
                                                   placeholder="URL"
                                                   class="px-3 py-2.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm focus:ring-2 focus:ring-primary-500">
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Services Links -->
                                    <div>
                                        <h4 class="text-sm font-bold text-gray-700 dark:text-gray-200 mb-3 flex items-center gap-2">
                                            <i class="fas fa-cogs text-gray-400 text-xs"></i> Services Links
                                        </h4>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                            @foreach([1,2,3,4] as $i)
                                            <input type="text" name="footer_service{{ $i }}_text" value="{{ old('footer_service'.$i.'_text', $content->{'footer_service'.$i.'_text'}) }}"
                                                   placeholder="Service {{ $i }} text"
                                                   class="px-3 py-2.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm focus:ring-2 focus:ring-primary-500">
                                            <input type="text" name="footer_service{{ $i }}_url" value="{{ old('footer_service'.$i.'_url', $content->{'footer_service'.$i.'_url'}) }}"
                                                   placeholder="URL"
                                                   class="px-3 py-2.5 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-lg text-sm focus:ring-2 focus:ring-primary-500">
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>{{-- end space-y-6 --}}

                        <!-- ── Sticky Action Bar ── -->
                        <div class="sticky-bar mt-6 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 px-6 py-4 shadow-lg rounded-2xl">
                            <div class="flex items-center justify-between gap-4">
                                <form action="{{ route('welcome-content.reset') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                            onclick="return confirm('Reset all content to defaults? This cannot be undone.')"
                                            class="flex items-center gap-2 px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-xl shadow-sm transition-colors text-sm">
                                        <i class="fas fa-undo"></i>
                                        Reset to Defaults
                                    </button>
                                </form>

                                <button type="submit"
                                        class="flex items-center gap-2 px-7 py-2.5 bg-gradient-to-r from-emerald-600 to-teal-500 hover:from-emerald-700 hover:to-teal-600 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 text-sm group">
                                    <i class="fas fa-save"></i>
                                    Save Changes
                                    <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                                </button>
                            </div>
                        </div>

                    </form>
                    {{-- end form --}}

                </div>
            </main>
        </div>
    </div>

    <script>
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        }
        
        // Initialize dark mode from localStorage
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }
        
        // Close mobile sidebar when window is resized to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                document.querySelector('.sidebar-container')?.classList.remove('open');
            }
        });
    </script>
</body>
</html>