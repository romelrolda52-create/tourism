<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('welcome_contents', function (Blueprint $table) {
            $table->id();
            
            // Hero Section
            $table->string('hero_title')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('hero_button_text')->nullable();
            $table->string('hero_button_link')->nullable();
            $table->string('hero_button2_text')->nullable();
            $table->string('hero_button2_link')->nullable();
            
            // Stats Section
            $table->string('stats_title1')->nullable();
            $table->string('stats_value1')->nullable();
            $table->string('stats_title2')->nullable();
            $table->string('stats_value2')->nullable();
            $table->string('stats_title3')->nullable();
            $table->string('stats_value3')->nullable();
            $table->string('stats_title4')->nullable();
            $table->string('stats_value4')->nullable();
            
            // About Section
            $table->string('about_title')->nullable();
            $table->text('about_subtitle')->nullable();
            $table->string('about_feature1_title')->nullable();
            $table->text('about_feature1_desc')->nullable();
            $table->string('about_feature2_title')->nullable();
            $table->text('about_feature2_desc')->nullable();
            $table->string('about_feature3_title')->nullable();
            $table->text('about_feature3_desc')->nullable();
            $table->string('about_feature4_title')->nullable();
            $table->text('about_feature4_desc')->nullable();
            
            // Destinations Section
            $table->string('destinations_title')->nullable();
            $table->text('destinations_subtitle')->nullable();
            
            // Services Section
            $table->string('services_title')->nullable();
            $table->text('services_subtitle')->nullable();
            $table->string('services_service1_title')->nullable();
            $table->text('services_service1_desc')->nullable();
            $table->string('services_service2_title')->nullable();
            $table->text('services_service2_desc')->nullable();
            $table->string('services_service3_title')->nullable();
            $table->text('services_service3_desc')->nullable();
            
            // CTA Section
            $table->string('cta_title')->nullable();
            $table->text('cta_subtitle')->nullable();
            
            // Footer Section
            $table->string('footer_brand')->nullable();
            $table->text('footer_description')->nullable();
            $table->string('footer_email')->nullable();
            $table->string('footer_phone')->nullable();
            $table->string('footer_address')->nullable();
            
            // Quick Links
            $table->string('footer_link1_text')->nullable();
            $table->string('footer_link1_url')->nullable();
            $table->string('footer_link2_text')->nullable();
            $table->string('footer_link2_url')->nullable();
            $table->string('footer_link3_text')->nullable();
            $table->string('footer_link3_url')->nullable();
            $table->string('footer_link4_text')->nullable();
            $table->string('footer_link4_url')->nullable();
            
            // Services Links
            $table->string('footer_service1_text')->nullable();
            $table->string('footer_service1_url')->nullable();
            $table->string('footer_service2_text')->nullable();
            $table->string('footer_service2_url')->nullable();
            $table->string('footer_service3_text')->nullable();
            $table->string('footer_service3_url')->nullable();
            $table->string('footer_service4_text')->nullable();
            $table->string('footer_service4_url')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('welcome_contents');
    }
};

