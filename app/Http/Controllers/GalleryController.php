<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $galleries = Gallery::with('user')->latest()->paginate(12);
        } else {
            $galleries = Gallery::with('user')->whereHas('user', function($q) {
                $q->where('role', 'manager');
            })->latest()->paginate(12);
        }
        return view('gallery.index', compact('galleries'));
    }

    /**
     * User-facing gallery index (view-only for regular users)
     */
    public function userIndex()
    {
        // Show all gallery items for users
        $galleries = Gallery::with('user')->latest()->paginate(12);
        return view('gallery.user-index', compact('galleries'));
    }

    public function create()
    {
        return view('gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = $request->file('image')->store('gallery', 'public');

        Gallery::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_path' => $imagePath,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('gallery.index')->with('success', 'Image uploaded successfully!');
    }

    public function edit(Gallery $gallery)
    {
        return view('gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        // If new image is uploaded, replace the old one
        if ($request->hasFile('image')) {
            // Delete old image
            Storage::disk('public')->delete($gallery->image_path);
            
            // Store new image
            $data['image_path'] = $request->file('image')->store('gallery', 'public');
        }

        $gallery->update($data);

        return redirect()->route('gallery.index')->with('success', 'Image updated successfully!');
    }

    public function destroy(Gallery $gallery)
    {
        // Delete the image file
        Storage::disk('public')->delete($gallery->image_path);
        
        // Delete the database record
        $gallery->delete();

        return redirect()->route('gallery.index')->with('success', 'Image deleted successfully!');
    }
}
