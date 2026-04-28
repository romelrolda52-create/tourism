<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WelcomeContent extends Model
{
    protected $fillable = [
        // Hero Section
        'hero_title',
        'hero_description',
        'hero_button_text',
        'hero_button_link',
        'hero_button2_text',
        'hero_button2_link',
        
        // Stats Section
        'stats_title1',
        'stats_value1',
        'stats_title2',
        'stats_value2',
        'stats_title3',
        'stats_value3',
        'stats_title4',
        'stats_value4',
        
        // About Section
        'about_title',
        'about_subtitle',
        'about_feature1_title',
        'about_feature1_desc',
        'about_feature2_title',
        'about_feature2_desc',
        'about_feature3_title',
        'about_feature3_desc',
        'about_feature4_title',
        'about_feature4_desc',
        
        // Destinations Section
        'destinations_title',
        'destinations_subtitle',
        
        // Services Section
        'services_title',
        'services_subtitle',
        'services_service1_title',
        'services_service1_desc',
        'services_service2_title',
        'services_service2_desc',
        'services_service3_title',
        'services_service3_desc',
        
        // CTA Section
        'cta_title',
        'cta_subtitle',
        
        // Footer Section
        'footer_brand',
        'footer_description',
        'footer_email',
        'footer_phone',
        'footer_address',
        
        // Quick Links
        'footer_link1_text',
        'footer_link1_url',
        'footer_link2_text',
        'footer_link2_url',
        'footer_link3_text',
        'footer_link3_url',
        'footer_link4_text',
        'footer_link4_url',
        
        // Services Links
        'footer_service1_text',
        'footer_service1_url',
        'footer_service2_text',
        'footer_service2_url',
        'footer_service3_text',
        'footer_service3_url',
        'footer_service4_text',
        'footer_service4_url',
    ];

    /**
     * Get the first welcome content record (singleton pattern)
     */
    public static function getContent()
    {
        $content = self::first();
        
        if (!$content) {
            // Create default content if none exists
            $content = self::create(self::getDefaults());
        }
        
        return $content;
    }

    /**
     * Get default content values
     */
    public static function getDefaults()
    {
        return [
            // Hero Section
            'hero_title' => 'Discover Your Next <span>Adventure</span>',
            'hero_description' => 'Experience world-class tourism management with TourEase Pro. Book hotels, explore destinations, and create unforgettable memories.',
            'hero_button_text' => 'Explore Destinations',
            'hero_button_link' => '#destinations',
            'hero_button2_text' => 'Learn More',
            'hero_button2_link' => '#about',
            
            // Stats Section
            'stats_title1' => 'Happy Travelers',
            'stats_value1' => '10000',
            'stats_title2' => 'Destinations',
            'stats_value2' => '500',
            'stats_title3' => 'Partner Hotels',
            'stats_value3' => '200',
            'stats_title4' => 'Customer Support',
            'stats_value4' => '24/7',
            
            // About Section
            'about_title' => 'Why Choose TourEase Pro?',
            'about_subtitle' => 'We provide comprehensive tourism management solutions for travelers and businesses alike.',
            'about_feature1_title' => 'Easy Booking',
            'about_feature1_desc' => 'Book hotels, resorts, and accommodations with just a few clicks. Instant confirmation.',
            'about_feature2_title' => 'Curated Destinations',
            'about_feature2_desc' => 'Explore handpicked destinations with detailed guides and local recommendations.',
            'about_feature3_title' => 'Best Prices',
            'about_feature3_desc' => 'Get exclusive deals and competitive pricing on all your travel bookings.',
            'about_feature4_title' => '24/7 Support',
            'about_feature4_desc' => 'Our dedicated support team is available round the clock to assist you.',
            
            // Destinations Section
            'destinations_title' => 'Popular Destinations',
            'destinations_subtitle' => 'Discover amazing places around the world',
            
            // Services Section
            'services_title' => 'Our Services',
            'services_subtitle' => 'Comprehensive tourism management for every need',
            'services_service1_title' => 'Hotel Reservations',
            'services_service1_desc' => 'Book accommodations across various categories from budget to luxury.',
            'services_service2_title' => 'Travel Planning',
            'services_service2_desc' => 'Comprehensive travel itineraries tailored to your preferences and budget.',
            'services_service3_title' => 'Tour Packages',
            'services_service3_desc' => 'Curated tour packages including guided tours, activities, and experiences.',
            
            // CTA Section
            'cta_title' => 'Ready to Start Your Journey?',
            'cta_subtitle' => 'Join thousands of travelers who trust TourEase Pro for their travel needs. Sign up today and get exclusive offers.',
            
            // Footer Section
            'footer_brand' => 'TourEase Pro',
            'footer_description' => 'Your premier tourism management system. We make travel planning easy and enjoyable for everyone.',
            'footer_email' => 'info@toureasepro.com',
            'footer_phone' => '+1 (555) 123-4567',
            'footer_address' => '123 Travel Street, City',
            
            // Quick Links
            'footer_link1_text' => 'Home',
            'footer_link1_url' => '#home',
            'footer_link2_text' => 'About Us',
            'footer_link2_url' => '#about',
            'footer_link3_text' => 'Destinations',
            'footer_link3_url' => '#destinations',
            'footer_link4_text' => 'Services',
            'footer_link4_url' => '#services',
            
            // Services Links
            'footer_service1_text' => 'Hotel Booking',
            'footer_service1_url' => '#',
            'footer_service2_text' => 'Travel Packages',
            'footer_service2_url' => '#',
            'footer_service3_text' => 'Tour Guides',
            'footer_service3_url' => '#',
            'footer_service4_text' => 'Transportation',
            'footer_service4_url' => '#',
        ];
    }
}

