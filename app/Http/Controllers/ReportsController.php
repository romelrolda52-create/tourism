<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Feedback;
use App\Models\Destination;
use App\Models\Hotel;
use App\Models\TourPackage;
use App\Models\Vehicle;
use App\Models\Restaurant;
use App\Models\Gallery;
use App\Models\Room;

class ReportsController extends Controller
{
    public function index()
    {
        $stats = [
            'totalUsers' => User::count(),
            'totalBookings' => Booking::count(),
            'pendingBookings' => Booking::where('status', 'pending')->count(),
            'confirmedBookings' => Booking::where('status', 'confirmed')->count(),
            'cancelledBookings' => Booking::where('status', 'cancelled')->count(),
            'totalPayments' => Payment::sum('amount'),
            'totalRevenue' => Payment::where('status', 'completed')->sum('amount'),
            'averageRating' => Feedback::avg('rating') ?? 0,
            'totalFeedbacks' => Feedback::count(),
            'totalDestinations' => Destination::count(),
            'totalHotels' => Hotel::count(),
            'totalRestaurants' => Restaurant::count(),
            'totalVehicles' => Vehicle::count(),
            'totalTourPackages' => TourPackage::count(),
            'totalRooms' => Room::count(),
            'totalGallery' => Gallery::count(),
        ];

        // Monthly bookings this year
        $monthlyBookings = Booking::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('created_at', now()->year)
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('count', 'month')
        ->toArray();

        $monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $monthlyBookingsData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyBookingsData[] = $monthlyBookings[$i] ?? 0;
        }

        // Recent bookings
        $recentBookings = Booking::with(['user', 'destination'])
            ->latest()
            ->limit(10)
            ->get();

        // Recent payments
        $recentPayments = Payment::with(['booking.user'])
            ->latest()
            ->limit(10)
            ->get();

        return view('reports.index', compact(
            'stats',
            'monthlyBookingsData',
            'monthNames',
            'recentBookings',
            'recentPayments'
        ));
    }
}

