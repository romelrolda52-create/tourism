<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $vehicle->name }} | Travel Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen">
    <div class="flex min-h-screen">
        @include('layouts.sidebar-admin')
        <div class="flex-1 lg:pl-64 p-8">
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-3xl shadow-2xl p-8 mb-8">
                    <div class="flex items-start gap-6 mb-8">
                        <div class="w-24 h-24 rounded-2xl bg-gradient-to-br from-green-400 to-emerald-500 flex items-center justify-center text-white text-3xl">
                            <i class="fas fa-{{ $vehicle->type == 'car' ? 'car' : ($vehicle->type == 'bus' ? 'bus' : 'truck') }}"></i>
                        </div>
                        <div>
                            <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $vehicle->name }}</h1>
                            <div class="flex items-center gap-4 text-lg">
                                <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-xl">{{ ucfirst($vehicle->type) }}</span>
                                <span class="px-4 py-2 bg-green-100 text-green-800 rounded-xl">{{ $vehicle->capacity }} seats</span>
                                <span class="text-2xl font-bold text-emerald-600">₱{{ number_format($vehicle->price_per_trip, 2) }}/trip</span>
                            </div>
                        </div>
                    </div>

                    @if($vehicle->image)
                    <div class="mb-8">
                        <img src="{{ Storage::url($vehicle->image) }}" class="w-full h-80 object-cover rounded-2xl shadow-xl">
                    </div>
                    @endif

                    @if($vehicle->description)
                    <div class="prose max-w-none mb-8">
                        {!! nl2br(e($vehicle->description)) !!}
                    </div>
                    @endif
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="bg-white rounded-3xl shadow-xl p-6">
                        <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
                            <i class="fas fa-cog text-indigo-500"></i>Vehicle Details
                        </h2>
                        <dl class="space-y-4">
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Status</dt>
                                <dd>
                                    <span class="px-3 py-1 bg-{{ $vehicle->status == 'active' ? 'green' : 'gray' }}-100 text-{{ $vehicle->status == 'active' ? 'green' : 'gray' }}-800 rounded-full text-sm">
                                        {{ ucfirst($vehicle->status) }}
                                    </span>
                                </dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Capacity</dt>
                                <dd class="font-bold text-2xl text-gray-900">{{ $vehicle->capacity }} seats</dd>
                            </div>
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Price/Trip</dt>
                                <dd class="font-bold text-2xl text-emerald-600">₱{{ number_format($vehicle->price_per_trip, 2) }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="bg-white rounded-3xl shadow-xl p-6">
                        <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
                            <i class="fas fa-calendar-check text-blue-500"></i>Bookings
                        </h2>
                        <p class="text-gray-600 mb-4">Recent bookings for this vehicle</p>
                        <div class="space-y-3">
                            @forelse($vehicle->bookings->take(5) as $booking)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                <div>
                                    <p class="font-semibold">{{ $booking->guest_name }}</p>
                                    <p class="text-sm text-gray-500">{{ $booking->created_at->format('M d') }}</p>
                                </div>
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center py-8">No bookings yet</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="flex gap-4 mt-12 pt-8 border-t">
                    <a href="{{ route('transportation.edit', $vehicle) }}" class="flex-1 bg-amber-500 hover:bg-amber-600 text-white font-bold py-4 px-8 rounded-2xl text-center transition-colors">
                        Edit Vehicle
                    </a>
                    <a href="{{ route('transportation.index') }}" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-4 px-8 rounded-2xl text-center transition-colors">
                        All Vehicles
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
