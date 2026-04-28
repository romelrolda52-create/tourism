@extends('layouts.app')

@section('content')
<div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-100">
    @include('layouts.sidebar-admin')
    
    <div class="flex-1 lg:pl-64 p-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Payment Details</h1>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">Payment #{{ $payment->id }}</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('payments.edit', $payment) }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg shadow transition duration-200">
                        Edit
                    </a>
                    <a href="{{ route('payments.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-6 rounded-lg shadow transition duration-200">
                        All Payments
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-lg mb-6 dark:bg-green-900/20 dark:border-green-800 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                        <div class="text-center bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 p-8 rounded-xl border border-green-200 dark:border-green-800">
                            <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($payment->amount, 2) }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Payment Amount</p>
                        </div>

                        <div class="p-8 border border-gray-200 dark:border-gray-700 rounded-xl">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-4">Status</h4>
                            <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $payment->status_badge }} capitalize">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>

                        <div class="p-8 border border-gray-200 dark:border-gray-700 rounded-xl">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-4">Payment Method</h4>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $payment->payment_method ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Booking Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Booking ID</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">#{{ $payment->booking->booking_id ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Guest Name</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $payment->booking->guest_name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Guest Email</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $payment->booking->guest_email ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Booking Amount</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">${{ number_format($payment->booking->total_price ?? 0, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Payment Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Transaction ID</label>
                                    <p class="font-mono bg-gray-100 dark:bg-gray-700 px-4 py-2 rounded-lg text-sm">
                                        {{ $payment->transaction_id ?? 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Paid At</label>
                                    <p class="text-lg text-gray-900 dark:text-white">{{ $payment->paid_at?->format('M d, Y @ h:i A') ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Created At</label>
                                    <p class="text-lg text-gray-900 dark:text-white">{{ $payment->created_at->format('M d, Y @ h:i A') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Updated At</label>
                                    <p class="text-lg text-gray-900 dark:text-white">{{ $payment->updated_at->format('M d, Y @ h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-12">
                        <div class="flex gap-3">
                            <a href="{{ route('payments.edit', $payment) }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 px-6 rounded-lg shadow transition duration-200">
                                Edit Payment
                            </a>
                            <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this payment?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2.5 px-6 rounded-lg shadow transition duration-200">
                                    Delete Payment
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')
<div x-data="{ sidebarOpen: false }" class="flex min-h-screen bg-gray-100">
    @include('layouts.sidebar-admin')
    
    <div class="flex-1 lg:pl-64 p-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Payment Details</h1>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">Payment #{{ $payment->id }}</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('payments.edit', $payment) }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg shadow transition duration-200">
                        Edit
                    </a>
                    <a href="{{ route('payments.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-6 rounded-lg shadow transition duration-200">
                        All Payments
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-lg mb-6 dark:bg-green-900/20 dark:border-green-800 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                        <div class="text-center bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 p-8 rounded-xl border border-green-200 dark:border-green-800">
                            <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($payment->amount, 2) }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Payment Amount</p>
                        </div>

                        <div class="p-8 border border-gray-200 dark:border-gray-700 rounded-xl">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-4">Status</h4>
                            <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $payment->status_badge }} capitalize">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>

                        <div class="p-8 border border-gray-200 dark:border-gray-700 rounded-xl">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-4">Payment Method</h4>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $payment->payment_method ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Booking Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Booking ID</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">#{{ $payment->booking->booking_id ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Guest Name</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $payment->booking->guest_name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Guest Email</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $payment->booking->guest_email ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Booking Amount</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">${{ number_format($payment->booking->total_price ?? 0, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Payment Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Transaction ID</label>
                                    <p class="font-mono bg-gray-100 dark:bg-gray-700 px-4 py-2 rounded-lg text-sm">
                                        {{ $payment->transaction_id ?? 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Paid At</label>
                                    <p class="text-lg text-gray-900 dark:text-white">{{ $payment->paid_at?->format('M d, Y @ h:i A') ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Created At</label>
                                    <p class="text-lg text-gray-900 dark:text-white">{{ $payment->created_at->format('M d, Y @ h:i A') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Updated At</label>
                                    <p class="text-lg text-gray-900 dark:text-white">{{ $payment->updated_at->format('M d, Y @ h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-12">
                        <div class="flex gap-3">
                            <a href="{{ route('payments.edit', $payment) }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 px-6 rounded-lg shadow transition duration-200">
                                Edit Payment
                            </a>
                            <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this payment?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2.5 px-6 rounded-lg shadow transition duration-200">
                                    Delete Payment
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('title', 'Payment Details')

@section('content')
<div x-data="{ sidebarOpen: false }" class="flex min-h-screen">
    @include('layouts.sidebar-admin')
    
    <div class="flex-1 lg:pl-64 p-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Payment Details</h1>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">Payment #{{ $payment->id }}</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('payments.edit', $payment) }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-lg shadow transition duration-200">
                        Edit
                    </a>
                    <a href="{{ route('payments.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-6 rounded-lg shadow transition duration-200">
                        All Payments
                    </a>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-lg mb-6 dark:bg-green-900/20 dark:border-green-800 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                        <div class="text-center bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 p-8 rounded-xl border border-green-200 dark:border-green-800">
                            <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($payment->amount, 2) }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Payment Amount</p>
                        </div>

                        <div class="p-8 border border-gray-200 dark:border-gray-700 rounded-xl">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-4">Status</h4>
                            <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $payment->status_badge }} capitalize">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>

                        <div class="p-8 border border-gray-200 dark:border-gray-700 rounded-xl">
                            <h4 class="font-medium text-gray-900 dark:text-white mb-4">Payment Method</h4>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $payment->payment_method ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Booking Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Booking ID</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">#{{ $payment->booking->booking_id ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Guest Name</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $payment->booking->guest_name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Guest Email</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $payment->booking->guest_email ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total Booking Amount</label>
                                    <p class="text-lg font-semibold text-gray-900 dark:text-white">${{ number_format($payment->booking->total_price ?? 0, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Payment Information</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Transaction ID</label>
                                    <p class="font-mono bg-gray-100 dark:bg-gray-700 px-4 py-2 rounded-lg text-sm">
                                        {{ $payment->transaction_id ?? 'N/A' }}
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Paid At</label>
                                    <p class="text-lg text-gray-900 dark:text-white">{{ $payment->paid_at?->format('M d, Y @ h:i A') ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Created At</label>
                                    <p class="text-lg text-gray-900 dark:text-white">{{ $payment->created_at->format('M d, Y @ h:i A') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Updated At</label>
                                    <p class="text-lg text-gray-900 dark:text-white">{{ $payment->updated_at->format('M d, Y @ h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end mt-12">
                        <div class="flex gap-3">
                            <a href="{{ route('payments.edit', $payment) }}" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 px-6 rounded-lg shadow transition duration-200">
                                Edit Payment
                            </a>
                            <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this payment?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2.5 px-6 rounded-lg shadow transition duration-200">
                                    Delete Payment
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

