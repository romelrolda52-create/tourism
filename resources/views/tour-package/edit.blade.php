@php
@endphp

@extends('layouts.app')

@section('title', 'Edit Tour Package')

@section('content')
<div class="p-8 max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <i class="fas fa-edit text-4xl text-amber-500"></i>
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Tour Package</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Update the details of "{{ $tourPackage->name }}"</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-8 p-6 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl">
        <h3 class="font-bold text-red-800 dark:text-red-300 mb-3">Please fix the following errors:</h3>
        <ul class="space-y-1">
            @foreach($errors->all() as $error)
                <li class="flex items-center text-red-700 dark:text-red-300">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ $error }}
                </li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('tour-package.update', $tourPackage) }}" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 p-10">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
            <!-- Basic Info -->
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                    <i class="fas fa-info-circle text-amber-500"></i>
                    Basic Information
                </h2>
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Package Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $tourPackage->name) }}" required 
                               class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-2xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500 transition-all duration-200 @error('name') border-red-500 @enderror">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea name="description" rows="4" class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-2xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500 transition-all duration-200 @error('description') border-red-500 @enderror">{{ old('description', $tourPackage->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Price (PHP) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="price" step="0.01" min="0" value="{{ old('price', $tourPackage->price) }}" required 
                                   class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-2xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500 transition-all duration-200 @error('price') border-red-500 @enderror">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Duration (Days) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="duration_days" min="1" max="365" value="{{ old('duration_days', $tourPackage->duration_days) }}" required 
                                   class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-2xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500 transition-all duration-200 @error('duration_days') border-red-500 @enderror">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Available Slots <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="available_slots" min="1" max="1000" value="{{ old('available_slots', $tourPackage->available_slots) }}" required 
                               class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-2xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500 transition-all duration-200 @error('available_slots') border-red-500 @enderror">
                    </div>
                </div>
            </div>

            <!-- Additional Info -->
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                    <i class="fas fa-cog text-amber-500"></i>
                    Additional Details
                </h2>
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Tour Guide
                        </label>
                        <select name="guide_id" class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-2xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500 transition-all duration-200">
                            <option value="">No guide assigned</option>
                            @foreach($guides as $guide)
                                <option value="{{ $guide->id }}" {{ old('guide_id', $tourPackage->guide_id) == $guide->id ? 'selected' : '' }}>
                                    {{ $guide->name }} ({{ $guide->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" required class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-2xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500 transition-all duration-200">
                            <option value="active" {{ old('status', $tourPackage->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $tourPackage->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Package Image
                        </label>
                        @if($tourPackage->image)
                        <div class="mb-4 p-4 bg-indigo-50 dark:bg-indigo-950/30 border-2 border-dashed border-indigo-200 dark:border-indigo-800 rounded-2xl text-center">
                            <img src="{{ Storage::url($tourPackage->image) }}" alt="Current image" class="max-w-full h-48 object-cover rounded-xl mx-auto shadow-lg mb-3">
                            <p class="text-sm text-gray-600 dark:text-gray-400">Current image will be replaced</p>
                        </div>
                        @endif
                        <input type="file" name="image" accept="image/*" 
                               class="w-full px-4 py-3 border border-gray-200 dark:border-gray-600 rounded-2xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500 transition-all duration-200 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100">
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                <i class="fas fa-route text-amber-500"></i>
                Tour Itinerary <span class="text-red-500">*</span>
            </h2>
            <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-950/30 p-8 rounded-3xl border-2 border-dashed border-amber-200 dark:border-amber-800">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">
                    Daily Schedule (JSON format)
                </label>
                <textarea name="itinerary" rows="12" required class="w-full px-6 py-5 border border-gray-200 dark:border-gray-600 rounded-2xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500 font-mono text-sm leading-relaxed @error('itinerary') border-red-500 @enderror">{{ old('itinerary', $tourPackage->itinerary ? json_encode($tourPackage->itinerary) : '') }}</textarea>
                <div class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                    <i class="fas fa-info-circle mr-1"></i>
                    JSON object with day numbers as keys and arrays of activities as values.
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-3">
                <i class="fas fa-map text-amber-500"></i>
                Destinations Included <span class="text-red-500">*</span>
            </h2>
            <div class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($destinations as $destination)
                <label class="flex items-center p-4 border-2 border-gray-200 dark:border-gray-600 rounded-2xl hover:border-amber-400 hover:shadow-md transition-all duration-200 cursor-pointer group @if($tourPackage->destinations->contains($destination->id) || in_array($destination->id, old('destinations', []))) bg-amber-50 dark:bg-amber-950/50 border-amber-300 shadow-md @endif">
                    <input type="checkbox" name="destinations[]" value="{{ $destination->id }}" 
                           class="rounded border-gray-300 text-amber-600 shadow-sm focus:ring-amber-500 h-5 w-5" 
                           {{ $tourPackage->destinations->contains($destination->id) || in_array($destination->id, old('destinations', [])) ? 'checked' : '' }}>
                    <div class="ml-3">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-100 to-orange-100 dark:from-amber-900 group-hover:from-amber-200 overflow-hidden mb-2 mx-auto">
                            @if($destination->image)
                            <img src="{{ Storage::url($destination->image) }}" class="w-full h-full object-cover" alt="{{ $destination->name }}">
                            @else
                            <i class="fas fa-map-marker-alt text-amber-500 text-xl flex items-center justify-center h-full"></i>
                            @endif
                        </div>
                        <div class="text-xs font-bold text-gray-900 dark:text-white text-center leading-tight">{{ Str::limit($destination->name, 20) }}</div>
                    </div>
                </label>
                @endforeach
            </div>
            @error('destinations')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
            </p>
            @enderror
        </div>

        <div class="flex flex-col sm:flex-row gap-4 mt-12 pt-10 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('tour-package.show', $tourPackage) }}" class="flex-1 sm:w-auto bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-900 dark:text-gray-200 font-semibold py-4 px-8 rounded-2xl text-center transition-all duration-200">
                <i class="fas fa-eye mr-2"></i> View Package
            </a>
            <a href="{{ route('tour-package.index') }}" class="flex-1 sm:w-auto bg-indigo-100 dark:bg-indigo-900 hover:bg-indigo-200 dark:hover:bg-indigo-800 text-indigo-800 dark:text-indigo-200 font-semibold py-4 px-8 rounded-2xl text-center transition-all duration-200">
                <i class="fas fa-list mr-2"></i> All Packages
            </a>
            <button type="submit" class="flex-1 sm:w-auto bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-semibold py-4 px-8 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                <i class="fas fa-save mr-2"></i> Update Tour Package
            </button>
        </div>
    </form>
</div>
@endsection

