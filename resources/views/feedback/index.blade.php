<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback | Tourism Management</title>
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
                            700: '#1d4ed8'
                        },
                    }
                }
            }
        }
    </script>
    <style>
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
        
        .dark .main-content-scroll::-webkit-scrollbar-track {
            background: #1f2937;
        }
        
        .dark .main-content-scroll::-webkit-scrollbar-thumb {
            background: #4b5563;
        }
        
        /* Fix for sidebar container */
        .sidebar-container {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 16rem;
            z-index: 40;
        }
        
        /* Main content wrapper */
        .main-wrapper {
            margin-left: 16rem;
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
        
        /* Card hover effects */
        .stat-card {
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        /* Rating stars */
        .rating-star {
            transition: all 0.2s ease;
        }
        
        /* Table row hover */
        .feedback-row {
            transition: all 0.2s ease;
        }
        
        /* Read more button animation */
        .read-more-btn {
            transition: all 0.2s ease;
        }
        
        .read-more-btn:hover {
            transform: translateX(3px);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 font-sans">
    <div x-data="{ sidebarOpen: false, expandedFeedback: null }" class="relative">
        
        <!-- Sidebar Container -->
        <div class="sidebar-container bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 shadow-xl"
             :class="{'open': sidebarOpen}">
            @include('layouts.sidebar-admin')
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
            <header class="bg-white/80 dark:bg-gray-800/90 backdrop-blur-md border-b border-gray-200/50 dark:border-gray-700 shadow-sm flex-shrink-0 z-10">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center shadow-lg">
                                <i class="fas fa-comment-dots text-white text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                                    Customer Feedback
                                    <span class="text-xs bg-gradient-to-r from-primary-100 to-primary-200 dark:from-primary-900/50 dark:to-primary-800/50 text-primary-700 dark:text-primary-300 font-bold px-3 py-1 rounded-full shadow-sm">
                                        {{ $feedbacks->count() ?? 0 }} total
                                    </span>
                                </h1>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">Manage customer reviews and feedback</p>
                            </div>
                        </div>
                        <a href="{{ route('feedback.create') }}" 
                           class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-semibold py-3 px-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center gap-2">
                            <i class="fas fa-plus"></i>
                            <span class="hidden sm:inline">Add Feedback</span>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Scrollable Main Content -->
            <main class="flex-1 main-content-scroll p-6">
                <div class="max-w-7xl mx-auto space-y-6">
                    
                    <!-- Success/Error Alerts -->
                    @if(session('success'))
                    <div class="bg-gradient-to-r from-emerald-50 to-green-50 dark:from-emerald-900/20 dark:to-green-900/20 border-l-4 border-emerald-500 rounded-xl p-4 shadow-sm">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-emerald-600 dark:text-emerald-400 text-lg"></i>
                            <p class="text-emerald-700 dark:text-emerald-300 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 border-l-4 border-red-500 rounded-xl p-4 shadow-sm">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 text-lg"></i>
                            <p class="text-red-700 dark:text-red-300 font-medium">{{ session('error') }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Total Feedbacks -->
                        <div class="stat-card bg-white/70 dark:bg-gray-800/70 backdrop-blur-md rounded-2xl p-6 shadow-lg border border-white/50 dark:border-gray-700/50 hover:shadow-xl">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">Total Feedbacks</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                                        {{ $feedbacks->count() ?? 0 }}
                                    </p>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-primary-500 to-primary-600 flex items-center justify-center shadow-lg">
                                    <i class="fas fa-comments text-white text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Average Rating -->
                        <div class="stat-card bg-white/70 dark:bg-gray-800/70 backdrop-blur-md rounded-2xl p-6 shadow-lg border border-white/50 dark:border-gray-700/50 hover:shadow-xl">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">Average Rating</p>
                                    <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2">
                                        {{ number_format($feedbacks->avg('rating') ?? 0, 1) }}
                                    </p>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-amber-500 to-orange-600 flex items-center justify-center shadow-lg">
                                    <i class="fas fa-star text-white text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Positive Feedbacks -->
                        <div class="stat-card bg-white/70 dark:bg-gray-800/70 backdrop-blur-md rounded-2xl p-6 shadow-lg border border-white/50 dark:border-gray-700/50 hover:shadow-xl">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">Positive (4-5★)</p>
                                    <p class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 mt-2">
                                        {{ $feedbacks->where('rating', '>=', 4)->count() ?? 0 }}
                                    </p>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg">
                                    <i class="fas fa-thumbs-up text-white text-xl"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Needs Improvement -->
                        <div class="stat-card bg-white/70 dark:bg-gray-800/70 backdrop-blur-md rounded-2xl p-6 shadow-lg border border-white/50 dark:border-gray-700/50 hover:shadow-xl">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">Needs Improvement</p>
                                    <p class="text-3xl font-bold text-amber-600 dark:text-amber-400 mt-2">
                                        {{ $feedbacks->where('rating', '<', 4)->count() ?? 0 }}
                                    </p>
                                </div>
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-amber-500 to-orange-600 flex items-center justify-center shadow-lg">
                                    <i class="fas fa-chart-line text-white text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Feedback Table -->
                    <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-md rounded-2xl shadow-xl border border-white/50 dark:border-gray-700/50 overflow-hidden">
                        <div class="p-6 border-b border-gray-200/50 dark:border-gray-700/50 bg-gradient-to-r from-slate-50 to-blue-50 dark:from-gray-800/50 dark:to-slate-800/50">
                            <div class="flex items-center justify-between flex-wrap gap-4">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                                    <i class="fas fa-list text-primary-600"></i>
                                    All Feedbacks
                                </h3>
                                <div class="flex items-center gap-3">
                                    <div class="relative">
                                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                                        <input type="text" 
                                               placeholder="Search feedback..." 
                                               class="pl-10 pr-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                    </div>
                                    <select class="px-4 py-2 border border-gray-200 dark:border-gray-600 rounded-xl text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500">
                                        <option value="">All Ratings</option>
                                        <option value="5">5 Stars</option>
                                        <option value="4">4 Stars</option>
                                        <option value="3">3 Stars</option>
                                        <option value="2">2 Stars</option>
                                        <option value="1">1 Star</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50/50 dark:bg-gray-800/50">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rating</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Feedback</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($feedbacks as $feedback)
                                    <tr class="feedback-row hover:bg-gradient-to-r hover:from-primary-50 hover:to-purple-50 dark:hover:from-primary-950/30 dark:hover:to-purple-950/30 transition-all duration-200">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary-500 to-primary-600 flex items-center justify-center text-white font-semibold shadow-md flex-shrink-0">
                                                    {{ substr($feedback->guest_name ?? 'Guest', 0, 1) }}
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="font-semibold text-gray-900 dark:text-white truncate">{{ $feedback->guest_name ?? 'Anonymous' }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $feedback->guest_email ?? 'No email' }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star text-xs {{ $i <= $feedback->rating ? 'text-amber-400' : 'text-gray-300 dark:text-gray-600' }} rating-star"></i>
                                                @endfor
                                                <span class="ml-2 text-xs font-bold text-gray-700 dark:text-gray-300">({{ $feedback->rating }})</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div x-data="{ expanded: false }">
                                                <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed">
                                                    <span x-show="!expanded">{{ Str::limit($feedback->feedback, 80) }}</span>
                                                    <span x-show="expanded" x-cloak>{{ $feedback->feedback }}</span>
                                                </p>
                                                @if(strlen($feedback->feedback) > 80)
                                                    <button @click="expanded = !expanded" 
                                                            class="read-more-btn text-primary-600 dark:text-primary-400 text-xs font-semibold hover:underline mt-1 inline-flex items-center gap-1">
                                                        <span x-show="!expanded">Read more</span>
                                                        <span x-show="expanded" x-cloak>Show less</span>
                                                        <i class="fas fa-chevron-down text-xs transition-transform" :class="{'rotate-180': expanded}"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="space-y-1">
                                                <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-3 py-1.5 rounded-full font-medium whitespace-nowrap block">
                                                    {{ $feedback->created_at->format('M d, Y') }}
                                                </span>
                                                @if($feedback->admin_reply)
                                                    <span class="text-xs bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 px-3 py-1 rounded-full font-medium flex items-center gap-1">
                                                        <i class="fas fa-check-circle text-emerald-500 text-xs"></i>
                                                        {{ $feedback->replied_at->diffForHumans() }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center gap-1 justify-end">
                                                <a href="{{ route('feedback.reply', $feedback) }}" 
                                                   class="p-2 {{ $feedback->admin_reply ? 'text-emerald-600 hover:bg-emerald-100 dark:hover:bg-emerald-900/50' : 'text-primary-600 hover:bg-primary-100 dark:hover:bg-primary-900/50' }} rounded-xl transition-colors relative group" 
                                                   title="{{ $feedback->admin_reply ? 'Replied on ' . $feedback->replied_at->format('M d, Y') : 'Reply' }}">
                                                    <i class="fas {{ $feedback->admin_reply ? 'fa-check-circle' : 'fa-reply' }}"></i>
                                                    @if($feedback->admin_reply)
                                                        <span class="absolute -top-10 left-1/2 transform -translate-x-1/2 bg-emerald-600 text-white text-xs px-2 py-1 rounded-full opacity-0 group-hover:opacity-100 transition-all duration-200 whitespace-nowrap shadow-lg z-10">
                                                            Replied
                                                        </span>
                                                    @endif
                                                </a>
                                                <a href="{{ route('feedback.edit', $feedback->id) }}" 
                                                   class="p-2 text-amber-600 hover:bg-amber-100 dark:hover:bg-amber-900/50 rounded-xl transition-colors" 
                                                   title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this feedback? This action cannot be undone.')">
                                                    @csrf 
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-100 dark:hover:bg-red-900/50 rounded-xl transition-colors" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center space-y-4">
                                                <div class="w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-2xl flex items-center justify-center">
                                                    <i class="fas fa-comments text-3xl text-gray-400"></i>
                                                </div>
                                                <div>
                                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">No feedbacks yet</h3>
                                                    <p class="text-gray-500 dark:text-gray-400">Customer feedbacks will appear here once submitted.</p>
                                                    <a href="{{ route('feedback.create') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-xl transition-colors">
                                                        <i class="fas fa-plus"></i>
                                                        Add First Feedback
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        @if(isset($feedbacks) && method_exists($feedbacks, 'links'))
                        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                            {{ $feedbacks->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Dark mode toggle function
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
        
        // Search functionality
        document.querySelector('input[placeholder="Search feedback..."]')?.addEventListener('keyup', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
        
        // Filter by rating
        document.querySelector('select')?.addEventListener('change', function(e) {
            const rating = e.target.value;
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                if (!rating) {
                    row.style.display = '';
                    return;
                }
                
                const ratingCell = row.querySelector('td:nth-child(2)');
                if (ratingCell) {
                    const ratingText = ratingCell.textContent.match(/\d+/);
                    const rowRating = ratingText ? parseInt(ratingText[0]) : 0;
                    row.style.display = rowRating === parseInt(rating) ? '' : 'none';
                }
            });
        });
    </script>
</body>
</html>