@extends('layouts.app')

@section('content')
<div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-50 dark:bg-gray-900">
    @include('layouts.sidebar-admin')
    
    <div class="flex-1 lg:pl-64 p-4 sm:p-6 lg:p-8 transition-all duration-200">
        <div class="max-w-7xl mx-auto">
            <!-- Page Header -->
            <div class="flex flex-col lg:flex-row lg:items-center gap-6 mb-8">
                <div>
                    <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-2">Payments Management</h1>
                    <p class="text-lg text-gray-600 dark:text-gray-300">Manage all payment records and transactions with ease.</p>
                </div>
                <a href="{{ route('payments.create') }}" 
                   class="inline-flex items-center bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-3 px-8 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 border-0">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    New Payment
                </a>
            </div>

            @if (session('success'))
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-800 px-6 py-4 rounded-2xl mb-8 shadow-sm dark:from-green-900/30 dark:to-emerald-900/30 dark:border-green-800 dark:text-green-200">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Search & Filters Card -->
            <div class="bg-white/80 dark:bg-gray-800/90 backdrop-blur-xl shadow-xl rounded-3xl p-6 mb-8 border border-white/50 dark:border-gray-700/50">
                <form method="GET" action="{{ route('payments.index') }}" class="flex flex-col lg:flex-row gap-4 items-end">
                    <div class="flex-1 min-w-0">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-3">Search Payments</label>
                        <div class="relative">
                            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="w-full pl-12 pr-4 py-4 bg-white/50 dark:bg-gray-700/50 border-2 border-gray-200/50 dark:border-gray-600/50 rounded-2xl focus:ring-4 focus:ring-green-500/20 focus:border-green-500 text-lg placeholder-gray-500 dark:placeholder-gray-400 transition-all duration-200"
                                   placeholder="Search by booking ID, transaction ID, customer...">
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 flex-shrink-0">
                        <button type="submit" class="flex-1 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-4 px-8 rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                            Filter Results
                        </button>
                        <a href="{{ route('payments.index') }}" class="flex-1 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-semibold py-4 px-8 rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-center">
                            Clear All
                        </a>
                    </div>
                </form>
            </div>

            <!-- Payments Table Card -->
            <div class="bg-white/80 dark:bg-gray-800/90 backdrop-blur-xl shadow-2xl rounded-3xl border border-white/50 dark:border-gray-700/50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-800/50 sticky top-0 z-10">
                            <tr>
                                <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Booking ID</th>
                                <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider hidden lg:table-cell">Amount</th>
                                <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider hidden xl:table-cell">Status</th>
                                <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider hidden 2xl:table-cell">Method</th>
                                <th class="px-6 py-5 text-left text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider hidden md:table-cell">Paid Date</th>
                                <th class="px-6 py-5 text-right text-xs font-bold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                            @forelse ($payments as $payment)
                                <tr class="hover:bg-white/50 dark:hover:bg-gray-700/50 transition-all duration-150">
                                    <td class="px-6 py-6 whitespace-nowrap">
                                        <div class="font-bold text-xl text-gray-900 dark:text-white">#{{ $payment->booking->booking_id ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-6 whitespace-nowrap hidden lg:table-cell">
                                        <span class="text-2xl font-black bg-gradient-to-r from-green-500 to-emerald-600 bg-clip-text text-transparent">${{ number_format($payment->amount, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-6 whitespace-nowrap hidden xl:table-cell">
                                        <span class="inline-flex px-4 py-2 rounded-full text-sm font-bold {{ $payment->status_badge }} uppercase tracking-wide shadow-lg">
                                            {{ $payment->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-6 whitespace-nowrap hidden 2xl:table-cell">
                                        <span class="font-semibold text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full text-sm">{{ $payment->payment_method ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-6 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 hidden md:table-cell font-medium">
                                        {{ $payment->paid_at?->format('M d, Y') ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-6 whitespace-nowrap text-right text-sm font-semibold">
                                        <div class="flex items-center justify-end space-x-3">
                                            <a href="{{ route('payments.show', $payment) }}" 
                                               class="inline-flex items-center px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white font-semibold rounded-xl shadow hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                View
                                            </a>
                                            <a href="{{ route('payments.edit', $payment) }}" 
                                               class="inline-flex items-center px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-xl shadow hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit
                                            </a>
                                            <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this payment?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-xl shadow hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-20 text-center">
                                        <div class="max-w-md mx-auto">
                                            <svg class="mx-auto h-24 w-24 text-gray-400 mb-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                            </svg>
                                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No payments found</h3>
                                            <p class="text-xl text-gray-500 dark:text-gray-400 mb-8">Get started by creating your first payment record.</p>
                                            <a href="{{ route('payments.create') }}" class="inline-flex items-center bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-8 py-4 rounded-2xl font-bold shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-200">
                                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                                Create First Payment
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($payments->hasPages())
                <div class="px-8 py-6 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700/50 dark:to-gray-800/50 border-t border-gray-200 dark:border-gray-700">
                    {{ $payments->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('title', 'Payments Management')
