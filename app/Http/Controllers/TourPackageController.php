<?php

namespace App\Http\Controllers;

use App\Models\TourPackage;
use App\Models\Destination;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TourPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tourPackages = TourPackage::with(['destinations', 'guide', 'bookings' => function($query) {
            $query->whereIn('status', ['pending', 'confirmed']);
        }])->orderBy('created_at', 'desc')->get();
        
        return view('tour-package.index', compact('tourPackages'));
    }

    /**
     * User-facing index (read-only)
     */
    public function userIndex()
    {
        $tourPackages = TourPackage::active()->with(['destinations', 'guide'])->hasAvailableSlots()->get();
        return view('tour-package.user-index', compact('tourPackages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $guides = User::all(); // TODO: filter by role 'guide' if exists
        $destinations = Destination::active()->get();
        return view('tour-package.create', compact('guides', 'destinations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1|max:365',
            'itinerary' => 'required|json',
            'status' => 'required|in:active,inactive',
            'available_slots' => 'required|integer|min:1|max:1000',
            'image' => 'nullable|image|max:2048',
            'guide_id' => 'nullable|exists:users,id',
            'destinations' => 'required|array|min:1',
            'destinations.*' => 'exists:destinations,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('tour-packages', 'public');
        }

        $tourPackage = TourPackage::create($data);
        $tourPackage->destinations()->sync($request->input('destinations', []));

        return redirect()->route('tour-package.index')
            ->with('success', 'Tour package created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(TourPackage $tourPackage)
    {
        $tourPackage->load(['destinations', 'guide', 'bookings' => function($query) {
            $query->with(['user', 'tourPackage'])->latest();
        }]);
        
        return view('tour-package.show', compact('tourPackage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TourPackage $tourPackage)
    {
        $guides = User::all();
        $destinations = Destination::active()->get();
        $tourPackage->load('destinations');
        
        return view('tour-package.edit', compact('tourPackage', 'guides', 'destinations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TourPackage $tourPackage)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1|max:365',
            'itinerary' => 'required|json',
            'status' => 'required|in:active,inactive',
            'available_slots' => 'required|integer|min:1|max:1000',
            'image' => 'nullable|image|max:2048',
            'guide_id' => 'nullable|exists:users,id',
            'destinations' => 'required|array|min:1',
            'destinations.*' => 'exists:destinations,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        if ($request->hasFile('image')) {
            if ($tourPackage->image) {
                Storage::disk('public')->delete($tourPackage->image);
            }
            $data['image'] = $request->file('image')->store('tour-packages', 'public');
        }

        $tourPackage->update($data);
        $tourPackage->destinations()->sync($request->input('destinations', []));

        return redirect()->route('tour-package.show', $tourPackage)
            ->with('success', 'Tour package updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TourPackage $tourPackage)
    {
        if ($tourPackage->image) {
            Storage::disk('public')->delete($tourPackage->image);
        }
        $tourPackage->destinations()->detach();
        $tourPackage->delete();

        return redirect()->route('tour-package.index')
            ->with('success', 'Tour package deleted successfully!');
    }
}

