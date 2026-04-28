<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class TransportationController extends Controller
{
    public function index()
    {
        $vehicles = \App\Models\Vehicle::withCount(['bookings as booked_slots' => function ($query) {
            $query->where('status', '!=', 'cancelled');
        }])->orderBy('created_at', 'desc')->get();

        return view('transportation.index', compact('vehicles'));
    }

    public function create()
    {
        return view('transportation.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|in:car,van,bus,boat,plane',
            'capacity' => 'required|integer|min:1|max:200',
            'price_per_trip' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive,maintenance',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('vehicles', 'public');
        }

        Vehicle::create($data);

        return redirect()->route('transportation.index')
            ->with('success', 'Vehicle added successfully!');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load('bookings');
        return view('transportation.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        return view('transportation.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type' => 'required|in:car,van,bus,boat,plane',
            'capacity' => 'required|integer|min:1|max:200',
            'price_per_trip' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive,maintenance',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        if ($request->hasFile('image')) {
            if ($vehicle->image) {
                Storage::disk('public')->delete($vehicle->image);
            }
            $data['image'] = $request->file('image')->store('vehicles', 'public');
        }

        $vehicle->update($data);

        return redirect()->route('transportation.show', $vehicle)
            ->with('success', 'Vehicle updated successfully!');
    }

    public function destroy(Vehicle $vehicle)
    {
        if ($vehicle->image) {
            Storage::disk('public')->delete($vehicle->image);
        }
        $vehicle->delete();

        return redirect()->route('transportation.index')
            ->with('success', 'Vehicle deleted successfully!');
    }
}

