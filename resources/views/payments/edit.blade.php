@extends('layouts.app')

@section('content')
<div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-700">
    @include('layouts.sidebar-admin')
    
    <div class="flex-1 lg:pl-64 p-6 lg:p-8 transition-all duration-300">
        <div class="max-w-4xl mx-auto">
            <!-- Page Header -->
            <div class="flex flex-col lg:flex-row lg:items-center gap-6 mb-10">
                <div>
                    <div class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl text-white text-sm font-bold mb-4 shadow-lg">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Payment #{{ $payment->id }}
                    </div>
                    <h1 class="text-4xl lg:text-5xl font-black bg-gradient-to-r from-gray-900 via-blue-900 to-indigo-900 dark:from-white dark:via-blue-100 dark:to-indigo-100 bg-clip-text text-transparent mb-3">
                        Update Payment
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 font-medium">Modify existing payment details and transaction information</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('payments.show', $payment) }}" 
                       class="group inline-flex items-center bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl shadow-2xl hover:shadow-3xl border-2 border-gray-200/50 dark:border-gray-700/50 px-6 py-3 rounded-2xl font-bold text-gray-900 dark:text-white transition-all duration-300 hover:-translate-y-1.5 hover:scale-[1.02]">
                        <svg class="w-4 h-4 mr-2 group-hover:-translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Preview
                    </a>
                    <a href="{{ route('payments.index') }}" 
                       class="group inline-flex items-center bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold px-8 py-3 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1.5 hover:scale-[1.02]">
                        <svg class="w-4 h-4 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 border-2 border-red-200/50 dark:border-red-800/50 rounded-3xl p-8 mb-8 shadow-2xl backdrop-blur-sm animate-pulse">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 pt-1">
                            <svg class="w-10 h-10 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-6 flex-1">
                            <h3 class="text-xl font-black text-red-900 dark:text-red-100 mb-4">Validation Issues Detected</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach ($errors->all() as $error)
                                    <div class="flex items-center bg-red-100 dark:bg-red-900/50 border-l-4 border-red-500 px-4 py-3 rounded-lg">
                                        <svg class="w-5 h-5 text-red-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-red-800 dark:text-red-200 font-medium">{{ $error }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Payment Summary Card -->
            <div class="bg-gradient-to-r from-blue-500/10 to-indigo-500/10 dark:from-blue-500/20 dark:to-indigo-500/20 border-2 border-blue-200/50 dark:border-blue-800/50 rounded-3xl p-8 mb-10 backdrop-blur-xl shadow-2xl">
                <h3 class="text-2xl font-black text-blue-900 dark:text-blue-100 mb-6 flex items-center">
                    <svg class="w-8 h-8 mr-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Current Payment Details
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-xl rounded-2xl p-6 border border-white/50">
                        <div class="text-3xl font-black text-blue-600 mb-1">#{{ $payment->booking->booking_id ?? 'N/A' }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 uppercase tracking-wide font-semibold">Booking ID</div>
                    </div>
                    <div class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-xl rounded-2xl p-6 border border-white/50">
                        <div class="text-3xl font-black bg-gradient-to-r from-green-500 to-emerald-600 bg-clip-text text-transparent mb-1">${{ number_format($payment->amount, 2) }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 uppercase tracking-wide font-semibold">Amount</div>
                    </div>
                    <div class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-xl rounded-2xl p-6 border border-white/50">
                        <span class="inline-flex px-6 py-3 rounded-full text-lg font-bold {{ $payment->status_badge }} shadow-lg">
                            {{ ucfirst($payment->status) }}
                        </span>
                        <div class="text-sm text-gray-600 dark:text-gray-400 uppercase tracking-wide font-semibold mt-2">Status</div>
                    </div>
                    <div class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-xl rounded-2xl p-6 border border-white/50">
                        <div class="font-bold text-lg text-gray-900 dark:text-white mb-1">{{ $payment->payment_method ?? 'N/A' }}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400 uppercase tracking-wide font-semibold">Method</div>
                    </div>
                </div>
            </div>

            <!-- Main Edit Form -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-3xl shadow-2xl rounded-3xl border border-white/50 dark:border-gray-700/50 overflow-hidden">
                <form action="{{ route('payments.update', $payment) }}" method="POST" class="p-10">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Booking Selection -->
                        <div>
                            <label for="booking_id" class="block text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                Booking Reference <span class="ml-1 text-red-500 text-xl">*</span>
                                <svg class="w-5 h-5 ml-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </label>
                            <div class="relative">
                                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-8 3h15M9 21h6"></path>
                                </svg>
                                <select name="booking_id" id="booking_id" required 
                                        class="w-full pl-16 pr-6 py-6 bg-white/50 dark:bg-gray-700/50 border-2 border-gray-200/50 dark:border-gray-600/50 rounded-2xl text-lg font-semibold focus:ring-4 focus:ring-blue-500/30 focus:border-blue-500 transition-all duration-300 appearance-none cursor-pointer hover:border-blue-300/70">
                                    <option value="">Select new booking...</option>
                                    @foreach($bookings as $booking)
                                        <option value="{{ $booking->id }}" {{ old('booking_id', $payment->booking_id) == $booking->id ? 'selected' : '' }}>
                                            #{{ $booking->booking_id }} • ${{ number_format($booking->total_price ?? 0, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('booking_id')
                                <p class="mt-3 p-3 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-xl text-sm font-semibold text-red-700 dark:text-red-300 flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="amount" class="block text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                                Payment Amount <span class="ml-1 text-red-500 text-xl">*</span>
                                <svg class="w-5 h-5 ml-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-3xl font-black text-green-600">$</span>
                                </div>
                                <input type="number" step="0.01" min="0.01" name="amount" id="amount" value="{{ old('amount', $payment->amount) }}" required
                                       class="w-full pl-16 pr-6 py-6 bg-white/50
