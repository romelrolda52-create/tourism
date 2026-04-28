@extends('layouts.app')

@section('content')
<div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gradient-to-br from-gray-50 to-indigo-50 dark:from-gray-900 dark:to-gray-800">
    @include('layouts.sidebar-admin')
    
    <div class="flex-1 lg:pl-64 p-6 lg:p-8 transition-all duration-300">
        <div class="max-w-4xl mx-auto">
            <!-- Page Header -->
            <div class="flex flex-col lg:flex-row lg:items-center gap-6 mb-10">
                <div>
                    <div class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full text-white text-sm font-semibold mb-4">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                        New Payment Record
                    </div>
                    <h1 class="text-4xl lg:text-5xl font-black bg-gradient-to-r from-gray-900 to-gray-700 dark:from-white dark:to-gray-200 bg-clip-text text-transparent mb-3">
                        Create Payment
                    </h1>
                    <p class="text-xl text-gray-600 dark:text-gray-300 font-medium">Add a new payment record for booking transactions</p>
                </div>
                <a href="{{ route('payments.index') }}" 
                   class="group inline-flex items-center bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl shadow-2xl hover:shadow-3xl border-2 border-gray-200/50 dark:border-gray-700/50 px-8 py-4 rounded-3xl font-bold text-gray-900 dark:text-white transition-all duration-300 hover:-translate-y-2 hover:scale-[1.02] hover:bg-white dark:hover:bg-gray-700">
                    <svg class="w-5 h-5 mr-3 group-hover:-translate-x-1 transition-all duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Payments
                </a>
            </div>

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="bg-gradient-to-r from-red-50 to-pink-50 dark:from-red-900/20 dark:to-pink-900/20 border-2 border-red-200/50 dark:border-red-800/50 rounded-3xl p-8 mb-8 shadow-xl backdrop-blur-sm">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 pt-0.5">
                            <svg class="w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-lg font-bold text-red-900 dark:text-red-100 mb-3">Please fix the following errors:</h3>
                            <ul class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm space-y-0">
                                @foreach ($errors->all() as $error)
                                    <li class="flex items-center text-red-800 dark:text-red-300">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $error }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Main Form Card -->
            <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-3xl shadow-2xl rounded-3xl border border-white/50 dark:border-gray-700/50 overflow-hidden">
                <form action="{{ route('payments.store') }}" method="POST" class="p-10">
                    @csrf
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Booking Selection -->
                        <div>
                            <label for="booking_id" class="block text-lg font-bold text-gray-900 dark:text-white mb-4">
                                Booking <span class="text-red-500 text-xl">*</span>
                            </label>
                            <div class="relative">
                                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-6 h-6 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-8 3h15M9 21h6"></path>
                                </svg>
                                <select name="booking_id" id="booking_id" required 
                                        class="w-full pl-16 pr-6 py-6 bg-white/50 dark:bg-gray-700/50 border-2 border-gray-200/50 dark:border-gray-600/50 rounded-2xl text-lg font-semibold focus:ring-4 focus:ring-green-500/30 focus:border-green-500 transition-all duration-300 appearance-none cursor-pointer hover:border-gray-300/70">
                                    <option value="">Choose a booking...</option>
                                    @foreach($bookings as $booking)
                                        <option value="{{ $booking->id }}" {{ old('booking_id') == $booking->id ? 'selected' : '' }}>
                                            #{{ $booking->booking_id }} • ${{ number_format($booking->total_price ?? 0, 2) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('booking_id')
                                <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="amount" class="block text-lg font-bold text-gray-900 dark:text-white mb-4">
                                Amount <span class="text-red-500 text-xl">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-2xl font-black text-green-600">$</span>
                                </div>
                                <input type="number" step="0.01" min="0.01" name="amount" id="amount" value="{{ old('amount') }}" required
                                       class="w-full pl-12 pr-6 py-6 bg-white/50 dark:bg-gray-700/50 border-2 border-gray-200/50 dark:border-gray-600/50 rounded-2xl text-2xl font-bold text-gray-900 focus:ring-4 focus:ring-green-500/30 focus:border-green-500 transition-all duration-300"
                                       placeholder="0.00">
                            </div>
                            @error('amount')
                                <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-lg font-bold text-gray-900 dark:text-white mb-4">
                                Status <span class="text-red-500 text-xl">*</span>
                            </label>
                            <select name="status" id="status" required 
                                    class="w-full px-6 py-6 bg-white/50 dark:bg-gray-700/50 border-2 border-gray-200/50 dark:border-gray-600/50 rounded-2xl text-lg font-semibold focus:ring-4 focus:ring-green-500/30 focus:border-green-500 transition-all duration-300 appearance-none cursor-pointer hover:border-gray-300/70">
                                <option value="">Select payment status...</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }} class="bg-orange-50 text-orange-800">Pending</option>
                                <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }} class="bg-green-50 text-green-800">Paid</option>
                                <option value="refunded" {{ old('status') == 'refunded' ? 'selected' : '' }} class="bg-blue-50 text-blue-800">Refunded</option>
                                <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }} class="bg-red-50 text-red-800">Failed</option>
                            </select>
                            @error('status')
                                <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <label for="payment_method" class="block text-lg font-bold text-gray-900 dark:text-white mb-4">
                                Payment Method
                            </label>
                            <div class="relative">
                                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-6 h-6 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3-3V15z"></path>
                                </svg>
                                <input type="text" name="payment_method" id="payment_method" value="{{ old('payment_method') }}"
                                       class="w-full pl-16 pr-6 py-6 bg-white/50 dark:bg-gray-700/50 border-2 border-gray-200/50 dark:border-gray-600/50 rounded-2xl text-lg font-semibold focus:ring-4 focus:ring-green-500/30 focus:border-green-500 transition-all duration-300"
                                       placeholder="Cash, Credit Card, GCash, Bank Transfer...">
                            </div>
                            @error('payment_method')
                                <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Full Width Fields -->
                        <div class="lg:col-span-2">
                            <label for="transaction_id" class="block text-lg font-bold text-gray-900 dark:text-white mb-4">
                                Transaction ID
                            </label>
                            <div class="relative">
                                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-6 h-6 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <input type="text" name="transaction_id" id="transaction_id" value="{{ old('transaction_id') }}"
                                       class="w-full pl-16 pr-6 py-6 bg-white/50 dark:bg-gray-700/50 border-2 border-gray-200/50 dark:border-gray-600/50 rounded-2xl text-lg font-semibold focus:ring-4 focus:ring-green-500/30 focus:border-green-500 transition-all duration-300"
                                       placeholder="TXN-2026-123456789">
                            </div>
                            @error('transaction_id')
                                <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="lg:col-span-2">
                            <label for="paid_at" class="block text-lg font-bold text-gray-900 dark:text-white mb-4">
                                Paid At (Optional)
                            </label>
                            <div class="relative">
                                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-6 h-6 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2V3a2 2 0 012 2h6.5"></path>
                                </svg>
                                <input type="datetime-local" name="paid_at" id="paid_at" value="{{ old('paid_at') }}"
                                       class="w-full pl-16 pr-6 py-6 bg-white/50 dark:bg-gray-700/50 border-2 border-gray-200/50 dark:border-gray-600/50 rounded-2xl text-lg font-semibold focus:ring-4 focus:ring-green-500/30 focus:border-green-500 transition-all duration-300">
                            </div>
                            @error('paid_at')
                                <p class="mt-2 text-sm font-medium text-red-600 dark:text-red-400 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-end mt-12 pt-10 border-t-2 border-gray-100 dark:border-gray-700">
                        <a href="{{ route('payments.index') }}" 
                           class="flex-1 sm:flex-none px-10 py-6 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-bold rounded-3xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 text-center">
                            <svg class="inline w-5 h-5 mr-2 mb-1 sm:mb-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Cancel
                        </a>
                        <button type="submit" 
                                class="flex-1 sm:flex-none px-12 py-6 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-black text-lg rounded-3xl shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 hover:scale-[1.02] transition-all duration-300">
                            <svg class="inline w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Create Payment Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('title', 'Create New Payment')

