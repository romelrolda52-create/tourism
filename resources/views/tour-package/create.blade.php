<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Tour Package | Travel Management</title>
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
                            50: '#eff6ff', 100: '#dbeafe',
                            500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8',
                        }
                    },
                    animation: { 'fade-in': 'fadeIn 0.3s ease-in-out' },
                    keyframes: { fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } } }
                }
            }
        }
    </script>
    <style>
        * { -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }

        .scrollbar-thin::-webkit-scrollbar { width: 6px; }
        .scrollbar-thin::-webkit-scrollbar-track { background: #f1f5f9; }
        .scrollbar-thin::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        /* Destination checkbox cards */
        .dest-card input:checked ~ .dest-label {
            border-color: #6366f1;
            background-color: #eef2ff;
        }
        .dark .dest-card input:checked ~ .dest-label {
            background-color: rgba(99,102,241,0.15);
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
        <div class="flex-1 flex flex-col overflow-hidden lg:pl-64">

            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center pl-12 lg:pl-0">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                                    <i class="fas fa-suitcase-rolling text-indigo-500"></i>
                                    Create Tour Package
                                </h1>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                                    Fill out the details to create a new tour package
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <!-- Dark Mode Toggle -->
                            <button onclick="toggleDarkMode()"
                                class="p-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl transition-colors">
                                <i class="fas fa-moon text-lg dark:hidden"></i>
                                <i class="fas fa-sun text-lg hidden dark:inline"></i>
                            </button>

                            <!-- Back Button -->
                            <a href="{{ route('tour-packages.index') }}"
                               class="flex items-center gap-2 px-4 py-2.5 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 font-semibold rounded-xl transition-colors border border-gray-200 dark:border-gray-600">
                                <i class="fas fa-arrow-left text-sm"></i>
                                Back to Packages
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto scrollbar-thin p-6 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800">
                <div class="max-w-5xl mx-auto space-y-6">

                    <!-- Validation Errors -->
                    @if($errors->any())
                    <div class="bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 border-l-4 border-red-500 rounded-xl p-5 shadow-sm animate-fade-in">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-800/50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 text-lg"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-red-800 dark:text-red-300 mb-1">Please fix the following errors:</h3>
                                <ul class="list-disc list-inside text-red-700 dark:text-red-400 text-sm space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Form -->
                    <form method="POST" action="{{ route('tour-packages.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        {{-- ── BASIC INFO + ADDITIONAL DETAILS ── --}}
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                            <!-- Basic Information -->
                            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-info-circle text-indigo-600 dark:text-indigo-400"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-base font-bold text-gray-900 dark:text-white">Basic Information</h2>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Package name, price & duration</p>
                                    </div>
                                </div>
                                <div class="p-6 space-y-5">
                                    <!-- Name -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">
                                            Package Name <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <i class="fas fa-suitcase text-gray-400 text-sm"></i>
                                            </div>
                                            <input type="text" name="name" value="{{ old('name') }}" required
                                                   placeholder="e.g. Ultimate Boracay Adventure"
                                                   class="w-full pl-11 pr-4 py-3 border @error('name') border-red-400 @else border-gray-200 dark:border-gray-600 @enderror dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all text-sm">
                                        </div>
                                        @error('name')
                                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Description -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">Description</label>
                                        <textarea name="description" rows="4"
                                                  placeholder="Describe the highlights of this tour package..."
                                                  class="w-full px-4 py-3 border @error('description') border-red-400 @else border-gray-200 dark:border-gray-600 @enderror dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all resize-none text-sm">{{ old('description') }}</textarea>
                                        @error('description')
                                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Price + Duration -->
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">
                                                Price (₱) <span class="text-red-500">*</span>
                                            </label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                    <span class="text-gray-400 text-sm font-medium">₱</span>
                                                </div>
                                                <input type="number" name="price" step="0.01" min="0"
                                                       value="{{ old('price') }}" required placeholder="5000"
                                                       class="w-full pl-9 pr-4 py-3 border @error('price') border-red-400 @else border-gray-200 dark:border-gray-600 @enderror dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all text-sm">
                                            </div>
                                            @error('price')
                                                <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">
                                                Duration (Days) <span class="text-red-500">*</span>
                                            </label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                    <i class="fas fa-calendar-day text-gray-400 text-sm"></i>
                                                </div>
                                                <input type="number" name="duration_days" min="1" max="365"
                                                       value="{{ old('duration_days') }}" required placeholder="7"
                                                       class="w-full pl-11 pr-4 py-3 border @error('duration_days') border-red-400 @else border-gray-200 dark:border-gray-600 @enderror dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all text-sm">
                                            </div>
                                            @error('duration_days')
                                                <p class="text-red-500 text-xs mt-1 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Available Slots -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">
                                            Available Slots <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <i class="fas fa-users text-gray-400 text-sm"></i>
                                            </div>
                                            <input type="number" name="available_slots" min="1" max="1000"
                                                   value="{{ old('available_slots', 10) }}" required placeholder="10"
                                                   class="w-full pl-11 pr-4 py-3 border @error('available_slots') border-red-400 @else border-gray-200 dark:border-gray-600 @enderror dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all text-sm">
                                        </div>
                                        @error('available_slots')
                                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Details -->
                            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-violet-50 to-fuchsia-50 dark:from-violet-900/20 dark:to-fuchsia-900/20 flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg bg-violet-100 dark:bg-violet-900/40 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-cog text-violet-600 dark:text-violet-400"></i>
                                    </div>
                                    <div>
                                        <h2 class="text-base font-bold text-gray-900 dark:text-white">Additional Details</h2>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Guide, status & image</p>
                                    </div>
                                </div>
                                <div class="p-6 space-y-5">
                                    <!-- Tour Guide -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">Tour Guide</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <i class="fas fa-user-tie text-gray-400 text-sm"></i>
                                            </div>
                                            <select name="guide_id"
                                                    class="w-full pl-11 pr-10 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent appearance-none text-sm">
                                                <option value="">No guide assigned</option>
                                                @foreach($guides as $guide)
                                                    <option value="{{ $guide->id }}" {{ old('guide_id') == $guide->id ? 'selected' : '' }}>
                                                        {{ $guide->name }} ({{ $guide->email }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Status -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">
                                            Status <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <i class="fas fa-toggle-on text-gray-400 text-sm"></i>
                                            </div>
                                            <select name="status" required
                                                    class="w-full pl-11 pr-10 py-3 border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent appearance-none text-sm">
                                                <option value="active"   {{ old('status','active') === 'active'   ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                                <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Image Upload -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1.5">
                                            Package Image <span class="text-xs text-gray-400 font-normal">(Optional)</span>
                                        </label>
                                        <div class="border-2 border-dashed border-gray-200 dark:border-gray-600 rounded-xl p-5 text-center hover:border-indigo-400 dark:hover:border-indigo-600 transition-colors bg-gray-50 dark:bg-gray-700/30 cursor-pointer"
                                             onclick="document.getElementById('imageInput').click()">
                                            <i class="fas fa-cloud-upload-alt text-2xl text-indigo-400 mb-2"></i>
                                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">PNG, JPG, WebP up to 10MB</p>
                                            <input type="file" name="image" id="imageInput" accept="image/*"
                                                   class="hidden" onchange="previewImage(this)">
                                            <div id="imagePreview" class="hidden mt-3">
                                                <div class="relative w-40 h-28 mx-auto overflow-hidden rounded-xl border-2 border-indigo-200">
                                                    <img id="previewImg" class="w-full h-full object-cover">
                                                    <button type="button" onclick="event.stopPropagation(); removePreview()"
                                                            class="absolute top-1 right-1 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600 shadow">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <p id="uploadHint" class="text-xs text-indigo-500 font-medium">Click to select image</p>
                                        </div>
                                        @error('image')
                                            <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ── ITINERARY ── --}}
                        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-route text-emerald-600 dark:text-emerald-400"></i>
                                </div>
                                <div>
                                    <h2 class="text-base font-bold text-gray-900 dark:text-white">
                                        Tour Itinerary <span class="text-red-500">*</span>
                                    </h2>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Daily schedule in JSON format</p>
                                </div>
                            </div>
                            <div class="p-6">
                                <textarea name="itinerary" rows="12" required
                                          class="w-full px-4 py-4 border @error('itinerary') border-red-400 @else border-gray-200 dark:border-gray-600 @enderror dark:bg-gray-700 dark:text-white rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent font-mono text-sm leading-relaxed resize-none"
                                          placeholder='{
  "Day 1": ["Morning: Airport pickup", "Afternoon: City tour", "Evening: Welcome dinner"],
  "Day 2": ["Full day beach hopping", "Sunset cruise"],
  "Day 3": ["Island hopping", "Farewell lunch", "Airport drop-off"]
}'>{{ old('itinerary') }}</textarea>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-2 flex items-center gap-1.5">
                                    <i class="fas fa-info-circle text-indigo-400"></i>
                                    Enter itinerary as a JSON object — day labels as keys, arrays of activities as values.
                                </p>
                                @error('itinerary')
                                    <p class="text-red-500 text-xs mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- ── DESTINATIONS ── --}}
                        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-lg bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-map text-amber-600 dark:text-amber-400"></i>
                                </div>
                                <div>
                                    <h2 class="text-base font-bold text-gray-900 dark:text-white">
                                        Destinations Included <span class="text-red-500">*</span>
                                    </h2>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Select all destinations in this package</p>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                                    @foreach($destinations as $destination)
                                    @php $checked = in_array($destination->id, old('destinations', [])); @endphp
                                    <label class="relative cursor-pointer group">
                                        <input type="checkbox" name="destinations[]" value="{{ $destination->id }}"
                                               class="peer sr-only" {{ $checked ? 'checked' : '' }}>
                                        <div class="flex flex-col items-center p-4 border-2 rounded-xl transition-all duration-200
                                                    border-gray-200 dark:border-gray-600
                                                    peer-checked:border-indigo-500 peer-checked:bg-indigo-50 dark:peer-checked:bg-indigo-900/20
                                                    hover:border-indigo-300 hover:shadow-sm">
                                            <!-- Image / Icon -->
                                            <div class="w-12 h-12 rounded-xl overflow-hidden mb-2.5 flex-shrink-0 bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/40 dark:to-purple-900/40 flex items-center justify-center">
                                                @if($destination->image)
                                                    <img src="{{ Storage::url($destination->image) }}"
                                                         class="w-full h-full object-cover"
                                                         alt="{{ $destination->name }}">
                                                @else
                                                    <i class="fas fa-map-marker-alt text-indigo-400"></i>
                                                @endif
                                            </div>
                                            <span class="text-xs font-semibold text-gray-800 dark:text-gray-200 text-center leading-tight">
                                                {{ Str::limit($destination->name, 22) }}
                                            </span>
                                            <!-- Check indicator -->
                                            <div class="absolute top-2 right-2 w-5 h-5 rounded-full bg-indigo-500 text-white flex items-center justify-center opacity-0 peer-checked:opacity-100 transition-opacity shadow-sm">
                                                <i class="fas fa-check text-[9px]"></i>
                                            </div>
                                        </div>
                                    </label>
                                    @endforeach
                                </div>
                                @error('destinations')
                                    <p class="text-red-500 text-xs mt-3 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- ── FORM ACTIONS ── --}}
                        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 shadow-sm px-6 py-4">
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                                <a href="{{ route('tour-packages.index') }}"
                                   class="w-full sm:w-auto flex items-center justify-center gap-2 px-6 py-2.5 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 font-semibold rounded-xl transition-colors border border-gray-200 dark:border-gray-600 text-sm">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                                <button type="submit"
                                        class="w-full sm:w-auto flex items-center justify-center gap-2 px-8 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 text-sm group">
                                    <i class="fas fa-plus-circle"></i>
                                    Create Tour Package
                                    <i class="fas fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                                </button>
                            </div>
                        </div>

                    </form>

                </div>
            </main>
        </div>
    </div>

    <script>
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));
        }
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('imagePreview').classList.remove('hidden');
                    document.getElementById('uploadHint').classList.add('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removePreview() {
            document.getElementById('imageInput').value = '';
            document.getElementById('imagePreview').classList.add('hidden');
            document.getElementById('uploadHint').classList.remove('hidden');
        }
    </script>
</body>
</html>