<?php

namespace App\Http\Controllers;

use App\Models\WelcomeContent;
use Illuminate\Http\Request;

class WelcomeContentController extends Controller
{
    /**
     * Display the welcome content editor for admin.
     */
    public function edit()
    {
        $content = WelcomeContent::getContent();
        return view('welcome-content.edit', compact('content'));
    }

    /**
     * Update the welcome content.
     */
    public function update(Request $request)
    {
        $content = WelcomeContent::getContent();
        
        $validated = $request->validate([
            // Hero Section
            'hero_title' => 'nullable|string|max:500',
            'hero_description' => 'nullable|string',
            'hero_button_text' => 'nullable|string|max:100',
            'hero_button_link' => 'nullable|string|max:255',
            'hero_button2_text' => 'nullable|string|max:100',
            'hero_button2_link' => 'nullable|string|max:255',
            
            // Stats Section
            'stats_title1' => 'nullable|string|max:100',
            'stats_value1' => 'nullable|string|max:50',
            'stats_title2' => 'nullable|string|max:100',
            'stats_value2' => 'nullable|string|max:50',
            'stats_title3' => 'nullable|string|max:100',
            'stats_value3' => 'nullable|string|max:50',
            'stats_title4' => 'nullable|string|max:100',
            'stats_value4' => 'nullable|string|max:50',
            
            // About Section
            'about_title' => 'nullable|string|max:255',
            'about_subtitle' => 'nullable|string',
            'about_feature1_title' => 'nullable|string|max:255',
            'about_feature1_desc' => 'nullable|string',
            'about_feature2_title' => 'nullable|string|max:255',
            'about_feature2_desc' => 'nullable|string',
            'about_feature3_title' => 'nullable|string|max:255',
            'about_feature3_desc' => 'nullable|string',
            'about_feature4_title' => 'nullable|string|max:255',
            'about_feature4_desc' => 'nullable|string',
            
            // Destinations Section
            'destinations_title' => 'nullable|string|max:255',
            'destinations_subtitle' => 'nullable|string',
            
            // Services Section
            'services_title' => 'nullable|string|max:255',
            'services_subtitle' => 'nullable|string',
            'services_service1_title' => 'nullable|string|max:255',
            'services_service1_desc' => 'nullable|string',
            'services_service2_title' => 'nullable|string|max:255',
            'services_service2_desc' => 'nullable|string',
            'services_service3_title' => 'nullable|string|max:255',
            'services_service3_desc' => 'nullable|string',
            
            // CTA Section
            'cta_title' => 'nullable|string|max:255',
            'cta_subtitle' => 'nullable|string',
            
            // Footer Section
            'footer_brand' => 'nullable|string|max:255',
            'footer_description' => 'nullable|string',
            'footer_email' => 'nullable|string|max:255',
            'footer_phone' => 'nullable|string|max:50',
            'footer_address' => 'nullable|string|max:255',
            
            // Quick Links
            'footer_link1_text' => 'nullable|string|max:100',
            'footer_link1_url' => 'nullable|string|max:255',
            'footer_link2_text' => 'nullable|string|max:100',
            'footer_link2_url' => 'nullable|string|max:255',
            'footer_link3_text' => 'nullable|string|max:100',
            'footer_link3_url' => 'nullable|string|max:255',
            'footer_link4_text' => 'nullable|string|max:100',
            'footer_link4_url' => 'nullable|string|max:255',
            
            // Services Links
            'footer_service1_text' => 'nullable|string|max:100',
            'footer_service1_url' => 'nullable|string|max:255',
            'footer_service2_text' => 'nullable|string|max:100',
            'footer_service2_url' => 'nullable|string|max:255',
            'footer_service3_text' => 'nullable|string|max:100',
            'footer_service3_url' => 'nullable|string|max:255',
            'footer_service4_text' => 'nullable|string|max:100',
            'footer_service4_url' => 'nullable|string|max:255',
        ]);

        $content->update($validated);

        return redirect()->route('welcome-content.edit')
            ->with('success', 'Welcome page content updated successfully!');
    }

    /**
     * Reset content to defaults.
     */
    public function reset()
    {
        $content = WelcomeContent::getContent();
        $content->update(WelcomeContent::getDefaults());

        return redirect()->route('welcome-content.edit')
            ->with('success', 'Content reset to defaults successfully!');
    }
}

