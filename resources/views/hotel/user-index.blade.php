<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hotels — User Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 dark:bg-gray-900">
@include('layouts.sidebar-user')

<main class="lg:ml-64 p-8">
<h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Available Hotels</h1>

@if($hotels->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
@foreach($hotels as $hotel)
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden">
  @if($hotel->image)
  <img src="{{ asset('storage/'.$hotel->image) }}" alt="{{ $hotel->name }}" class="w-full h-48 object-cover">
  @else
  <div class="w-full h-48 bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center">
    <i class="fas fa-hotel text-4xl text-white opacity-80"></i>
  </div>
  @endif
  <div class="p-6">
    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $hotel->name }}</h3>
    <p class="text-gray-600 dark:text-gray-300 mb-4">{{ $hotel->location }}</p>
    <div class="flex items-center justify-between mb-4">
      <div class="flex items-center gap-2">
        <i class="fas fa-bed text-yellow-500"></i>
        <span class="text-sm text-gray-600 dark:text-gray-300">{{ $hotel->rooms->count() }} Rooms</span>
      </div>
      @if($hotel->star_rating)
      <div class="flex">
        @for($i=1;$i<=5;$i++)
        <i class="fas fa-star {{ $i <= $hotel->star_rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
        @endfor
      </div>
      @endif
    </div>
    <a href="{{ route('hotel.show', $hotel) }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg text-center transition-colors block">
      View Details
    </a>
  </div>
</div>
@endforeach
</div>

{{ $hotels->links() }}
@else
<div class="text-center py-16">
  <i class="fas fa-hotel text-6xl text-gray-400 mb-4"></i>
  <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">No Hotels Available</h3>
  <p class="text-gray-600 dark:text-gray-300 mb-6">Check back later for new listings.</p>
  <a href="{{ route('user.destinations.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
    Explore Destinations
  </a>
</div>
@endif
</main>
</body>
</html>
