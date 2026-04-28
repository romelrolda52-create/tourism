@php
@endphp

@extends('layouts.app')

@section('title', $tourPackage->name)

@section('content')
<div class="p-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-8 py-4 rounded-3xl shadow-2xl mb-6">
                <i class="fas fa-suitcase-rolling text-2xl"></i>
                <h1 class="text-4xl font-bold">{{ $tourPackage->name }}</h1>
            </div>
            <div class="flex flex-wrap gap-4 justify-center items-center text-lg mb-8">
                <div class="flex items-center gap-2 bg-emerald-100 dark:bg-emerald-900/50 px-4 py-2 rounded-2xl">
                    <i class="fas fa-calendar-days text-emerald-600"></i>
                    <span>{{ $tourPackage->duration_days }} Days</span>
                </div>
                <div class="flex items-center gap-2 bg-blue-100 dark:bg-blue-900/50 px-4 py-2 rounded-2xl">
                    <i class="fas fa-dollar-sign text-blue-600"></i>
                    <span>${{ number_format($tourPackage->price, 2) }}</span>
                </div>
                @if($tourPackage->guide)
                <div class="flex items-center gap-2 bg-indigo-100 dark:bg-indigo-900/50 px-4 py-2 rounded-2xl">
                    <i class="fas fa-user-tie text-indigo-600"></i>
                    <span>{{ $tourPackage->guide->name }}</span>
                </div>
                @endif
                <div class="flex items-center gap-2 bg-amber-100 dark:bg-amber-900/50 px-4 py-2 rounded-2xl">
                    <i class="fas fa-calendar-check text-amber-600"></i>
                    <span>{{ $tourPackage->remaining_slots }} slots available</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-16">
            <!-- Left Column - Image & Description -->
            <div>
                @if($tourPackage->image)
                <div class="rounded-3xl overflow-hidden shadow-2xl mb-8 group relative">
                    <img src="{{ Storage::url($tourPackage->image) }}" alt="{{ $tourPackage->name }}" class="w-full h-96 object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                </div>
                @else
                <div class="w-full h-96 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-3xl flex items-center justify-center mb-8">
                    <i class="fas fa-suitcase-rolling text-9xl text-white/80"></i>
                </div>
                @endif

                <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-xl border border-gray-200 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                        <i class="fas fa-align-left text-indigo-500"></i>
                        Description
                    </h2>
                    <div class="prose dark:prose-invert max-w-none text-lg leading-relaxed">
                        {!! nl2br(e($tourPackage->description)) !!}
                    </div>
                </div>
            </div>

            <!-- Right Column - Itinerary & Destinations -->
            <div class="space-y-8">
                <!-- Itinerary -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-xl border border-gray-200 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                        <i class="fas fa-route text-emerald-500"></i>
                        Detailed Itinerary
                    </h2>
                    <div class="space-y-6">
                        {!! $tourPackage->itinerary_html !!}
                    </div>
                </div>

                <!-- Destinations -->
                <div class="bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-xl border border-gray-200 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                        <i class="fas fa-map-marked-alt text-blue-500"></i>
                        Destinations Included
                    </h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($tourPackage->destinations as $destination)
                        <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-950/30 p-6 text-center hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                            @if($destination->image)
                            <div class="w-full h-32 rounded-xl overflow-hidden mb-4 group-hover:scale-110 transition-transform duration-300">
                                <img src="{{ Storage::url($destination->image) }}" alt="{{ $destination->name }}" class="w-full h-full object-cover">
                            </div>
                            @endif
                            <h4 class="font-bold text-gray-900 dark:text-white text-lg mb-2 leading-tight">{{ $destination->name }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ Str::limit($destination->description, 60) }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Bookings -->
        @if($tourPackage->bookings->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-200 dark:border-gray-700 p-8">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 flex items-center gap-3">
                <i class="fas fa-list text-orange-500"></i>
                Recent Bookings ({{ $tourPackage->bookings->count() }})
            </h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="text-left py-4 font-semibold text-gray-900 dark:text-white">Booking ID</th>
                            <th class="text-left py-4 font-semibold text-gray-900 dark:text-white">Customer</th>
                            <th class="text-left py-4 font-semibold text-gray-900 dark:text-white">Date</th>
                            <th class="text-left py-4 font-semibold text-gray-900 dark:text-white">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($tourPackage->bookings->take(10) as $booking)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="py-4 font-mono text-sm text-indigo-600">{{ $booking->booking_id }}</td>
                            <td class="py-4">
                                <div class="font-medium text-gray-900 dark:text-white">{{ $booking->guest_name }}</div>
                                <div class="text-sm text-gray-500">{{ $booking->guest_email }}</div>
                            </td>
                            <td class="py-4 text-sm text-gray-600">{{ $booking->created_at->format('M d, Y') }}</td>
                            <td class="py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-{{ $booking->status == 'confirmed' || $booking->status == 'checked_in' ? 'emerald' : $booking->status == 'cancelled' ? 'gray' : 'amber' }}-100 text-{{ $booking->status == 'confirmed' || $booking->status == 'checked_in' ? 'emerald' : $booking->status == 'cancelled' ? 'gray' : 'amber' }}-800 dark:bg-{{ $booking->status == 'confirmed' || $booking->status == 'checked_in' ? 'emerald' : 'gray' }}-900/50">
                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($tourPackage->bookings->count() > 10)
            <div class="mt-6 text-center">
                <a href="#" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 font-semibold">View all bookings &rarr;</a>
            </div>
            @endif
        </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 mt-12 pt-10 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('tour-package.edit', $tourPackage) }}" class="flex items-center justify-center gap-3 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-semibold py-4 px-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300">
                <i class="fas fa-edit"></i>
                Edit Package
            </a>
            <a href="{{ route('tour-package.index') }}" class="flex items-center justify-center gap-3 bg-indigo-100 dark:bg-indigo-900 hover:bg-indigo-200 dark:hover:bg-indigo-800 text-indigo-800 dark:text-indigo-200 font-semibold py-4 px-8 rounded-2xl transition-all duration-300">
                <i class="fas fa-list"></i>
                All Packages
            </a>
        </div>
    </div>
</div>
@endsection

