<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply to Feedback | Tourism Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gradient-to-br from-slate-50 to-blue-50 dark:from-gray-900 dark:to-gray-800 min-h-screen">
    <div x-data="{ sidebarOpen: false }" class="flex">
        <!-- Sidebar -->
        <div class="sidebar-container bg-white dark:bg-gray-800 border-r shadow-xl fixed lg:relative lg:translate-x-0 z-40 w-64 h-screen overflow-y-auto"
             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
            @include('layouts.sidebar-admin')
        </div>

        <!-- Main Content -->
        <div class="flex-1 ml-0 lg:ml-64 p-8">
            <!-- Header -->
            <div class="bg-white/80 dark:bg-gray-800/90 backdrop-blur-md rounded-2xl shadow-lg p-6 mb-8">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-xl bg-gray-100 dark:bg-gray-700">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-gradient-to-r from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-reply-all text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Reply to Feedback</h1>
                            <p class="text-gray-600 dark:text-gray-400">Respond to customer feedback #{{ $feedback->id }}</p>
                        </div>
                    </div>
                    <a href="{{ route('feedback.index') }}" class="ml-auto bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-xl font-semibold transition-colors flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i>
                        Back to Feedbacks
                    </a>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 dark:bg-emerald-900/30 dark:border-emerald-800 rounded-2xl p-4 mb-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <i class="fas fa-check-circle text-emerald-500 text-xl"></i>
                    <span class="font-semibold text-emerald-800 dark:text-emerald-200">{{ session('success') }}</span>
                </div>
            </div>
            @endif

            <div class="grid lg:grid-cols-2 gap-8">
                <!-- Customer Feedback -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-200/50 dark:border-gray-700/50">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                        <i class="fas fa-comment text-amber-500"></i>
                        Customer Feedback
                    </h3>
                    
                    <div class="space-y-6">
                        <!-- Customer Info -->
                        <div class="flex items-start gap-4 p-4 bg-gray-50 dark:bg-gray-900/50 rounded-2xl">
                            <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center rounded-xl text-white font-bold flex-shrink-0 mt-1">
                                {{ substr($feedback->guest_name ?? 'G', 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-gray-900 dark:text-white">{{ $feedback->guest_name ?? 'Anonymous' }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $feedback->guest_email ?? 'No email provided' }}</p>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="flex items-center gap-3 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-2xl">
                            <div class="flex gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-sm {{ $i <= $feedback->rating ? 'text-amber-400 fill-amber-400' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                            <span class="font-bold text-lg text-gray-900 dark:text-white"> {{ $feedback->rating }}/5</span>
                        </div>

                        <!-- Feedback Text -->
                        <div class="p-4 bg-gradient-to-r from-gray-50 to-slate-50 dark:from-gray-900/50 dark:to-slate-900/50 rounded-2xl">
                            <p class="text-gray-800 dark:text-gray-200 leading-relaxed whitespace-pre-wrap">{{ $feedback->feedback }}</p>
                            @if($feedback->booking)
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-3">
                                    <i class="fas fa-link mr-1"></i> 
                                    Related to Booking #{{ $feedback->booking->id }}
                                </p>
                            @endif
                        </div>

                        <!-- Date -->
                        <div class="text-right">
                            <span class="text-xs text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-800 px-3 py-1 rounded-full">
                                {{ $feedback->created_at->format('M d, Y \\a\\t g:i A') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Reply Form -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-8 border border-gray-200/50 dark:border-gray-700/50">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                        <i class="fas fa-reply text-primary-500"></i>
                        Your Reply
                    </h3>
                    
                    <form method="POST" action="{{ route('feedback.reply.store', $feedback) }}" class="space-y-6">
                        @csrf
                        @method('POST')
                        
                        <!-- Reply Textarea -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                                Reply Message
                            </label>
                            <textarea 
                                name="admin_reply" 
                                required 
                                rows="8"
                                class="w-full p-4 border-2 border-gray-200 dark:border-gray-600 rounded-2xl focus:ring-4 focus:ring-primary-500/20 focus:border-primary-500 bg-gray-50 dark:bg-gray-900/50 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 resize-vertical font-medium min-h-[150px] transition-all duration-200"
                                placeholder="Thank you for your feedback! We appreciate your input and are working to improve..."
                            >{{ old('admin_reply') }}</textarea>
                            @error('admin_reply')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                Max 1000 characters • Will be visible to customer
                            </p>
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <button type="submit" class="flex-1 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-bold py-4 px-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-3">
                                <i class="fas fa-paper-plane"></i>
                                <span>Send Reply</span>
                            </button>
                            <a href="{{ route('feedback.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-4 px-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-3">
                                <i class="fas fa-times"></i>
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>

