<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Vehicle | Travel Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="flex min-h-screen">
        @include('layouts.sidebar-admin')
        <div class="flex-1 lg:pl-64 p-8">
            <div class="max-w-2xl mx-auto">
                <div class="flex items-center gap-4 mb-8">
                    <i class="fas fa-edit text-4xl text-amber-500"></i>
                    <h1 class="text-3xl font-bold text-gray-900">Edit Vehicle: {{ $vehicle->name }}</h1>
                </div>

                <form method="POST" action="{{ route('transportation.update', $vehicle) }}" enctype="multipart/form-data" class="bg-white rounded-3xl shadow-2xl p-8 border">
                    @csrf @method('PUT')
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Vehicle Name *</label>
                            <input type="text" name="name" value="{{ old('name', $vehicle->name) }}" required class="w-full p-4 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Type *</label>
                                <select name="type" required class="w-full p-4 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500">
                                    <option value="car" {{ $vehicle->type == 'car' ? 'selected' : '' }}>Car</option>
                                    <option value="van" {{ $vehicle->type == 'van' ? 'selected' : '' }}>Van</option>
                                    <option value="bus" {{ $vehicle->type == 'bus' ? 'selected' : '' }}>Bus</option>
                                    <option value="boat" {{ $vehicle->type == 'boat' ? 'selected' : '' }}>Boat</option>
                                    <option value="plane" {{ $vehicle->type == 'plane' ? 'selected' : '' }}>Plane</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Capacity *</label>
                                <input type="number" name="capacity" min="1" max="200" value="{{ old('capacity', $vehicle->capacity) }}" required class="w-full p-4 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Price per Trip (PHP) *</label>
                            <input type="number" name="price_per_trip" step="0.01" min="0" value="{{ old('price_per_trip', $vehicle->price_per_trip) }}" required class="w-full p-4 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Status *</label>
                            <select name="status" required class="w-full p-4 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500">
                                <option value="active" {{ $vehicle->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $vehicle->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="maintenance" {{ $vehicle->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                            <textarea name="description" rows="4" class="w-full p-4 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-amber-500/20 focus:border-amber-500">{{ old('description', $vehicle->description) }}</textarea>
                        </div>

                        @if($vehicle->image)
                        <div class="p-4 bg-gray-50 rounded-2xl">
                            <p class="text-sm font-medium mb-2">Current Image:</p>
                            <img src="{{ Storage::url($vehicle->image) }}" class="max-w-md h-48 object-cover rounded-xl">
                            <p class="text-xs text-gray-500 mt-2">Upload new to replace</p>
                        </div>
                        @endif

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">New Vehicle Image</label>
                            <input type="file" name="image" accept="image/*" class="w-full p-4 border border-gray-200 rounded-2xl focus:ring-4 focus:ring-amber-500/20">
                        </div>

                        <div class="flex gap-4 pt-6">
                            <a href="{{ route('transportation.index') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-2xl text-center transition-colors">Cancel</a>
                            <button type="submit" class="flex-1 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-bold py-3 px-6 rounded-2xl shadow-lg hover:shadow-xl transition-all">Update Vehicle</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
