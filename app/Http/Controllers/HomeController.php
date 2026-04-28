<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Gallery;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $destinations = Destination::where('is_active', true)->take(6)->get();
        $galleries = Gallery::with('user')->latest()->take(8)->get();
$welcomeContent = \App\Models\WelcomeContent::getContent();

        return view('welcome', compact('destinations', 'galleries', 'welcomeContent'));
    }
}
