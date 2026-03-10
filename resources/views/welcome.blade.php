<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="TourEase Pro - Your Premier Tourism Management System">
    <title>{{ config('app.name', 'TourEase Pro') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        :root {
            --primary: #0F1923;
            --secondary: #1E2D3D;
            --accent: #22C55E;
            --accent-light: #4ADE80;
            --accent-glow: rgba(34, 197, 94, 0.4);
            --text-muted: #8B9BAA;
            --text-light: #C4CDD6;
            --bg-light: #F8F6F3;
            --bg-cream: #FDFCFA;
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        body {
            font-family: 'Outfit', sans-serif;
            color: var(--primary);
            overflow-x: hidden;
        }
        
        .font-display {
            font-family: 'Playfair Display', serif;
        }
        
        /* Header Styles */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: transparent;
            padding: 20px 0;
        }
        
        .header.scrolled {
            background: rgba(15, 25, 35, 0.95);
            backdrop-filter: blur(20px);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
            padding: 12px 0;
        }
        
        .header.scrolled .nav-links a {
            color: rgba(255,255,255,0.9);
        }
        
        .header.scrolled .nav-links a:hover {
            color: var(--accent-light);
        }
        
        /* Hero Section */
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            overflow: hidden;
            background: linear-gradient(135deg, #0F1923 0%, #1E2D3D 100%);
        }
        
        /* Background Slideshow */
        .hero-slideshow {
            position: absolute;
            inset: 0;
            z-index: 0;
        }
        
        .hero-slide {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 1.5s ease-in-out;
        }
        
        .hero-slide.active {
            opacity: 1;
        }
        
        .hero-slide::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(15,25,35,0.25) 0%, rgba(30,45,61,0.15) 50%, rgba(15,25,35,0.25) 100%);
        }
        
        /* Animated background shapes */
        .hero-shapes {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 1;
        }
        
        .shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            animation: float 20s ease-in-out infinite;
        }
        
        .shape-1 {
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, var(--accent) 0%, transparent 70%);
            top: -200px;
            right: -100px;
            animation-delay: 0s;
        }
        
        .shape-2 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, #3B82F6 0%, transparent 70%);
            bottom: -100px;
            left: -100px;
            animation-delay: -5s;
        }
        
        .shape-3 {
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, #8B5CF6 0%, transparent 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: -10s;
        }
        
        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(30px, -30px) scale(1.1); }
            50% { transform: translate(-20px, 20px) scale(0.9); }
            75% { transform: translate(-30px, -20px) scale(1.05); }
        }
        
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(15,25,35,0.75) 0%, rgba(30,45,61,0.65) 50%, rgba(15,25,35,0.75) 100%);
            z-index: 2;
        }
        
        .hero-content {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 120px 40px 80px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }
        
        @media (max-width: 1024px) {
            .hero-content {
                grid-template-columns: 1fr;
                text-align: center;
                padding: 100px 20px 60px;
            }
            .hero-text { order: 1; }
            .hero-form { order: 2; }
            .hero-buttons { justify-content: center; }
            .hero-text p { margin: 0 auto 35px; }
            .hero-text h1 { font-size: 2.8rem; }
        }
        
        .hero-text h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3.8rem;
            font-weight: 700;
            color: white;
            line-height: 1.15;
            margin-bottom: 24px;
        }
        
        .hero-text h1 span {
            color: var(--accent-light);
            font-style: italic;
            position: relative;
        }
        
        .hero-text h1 span::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--accent), var(--accent-light));
            border-radius: 2px;
        }
        
        .hero-text p {
            font-size: 1.15rem;
            color: var(--text-light);
            line-height: 1.8;
            margin-bottom: 35px;
            max-width: 520px;
        }
        
        .hero-buttons {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }
        
        /* Section Styles */
        .section {
            padding: 110px 20px;
            position: relative;
        }
        
        .section-dark {
            background: var(--primary);
            color: white;
        }
        
        .section-light {
            background: var(--bg-cream);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-align: center;
            color: white;
            position: relative;
        }
        
        .section-title::after {
            content: '';
            display: block;
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, var(--accent), var(--accent-light));
            margin: 15px auto 0;
            border-radius: 2px;
        }
        
        .section-title.dark {
            color: var(--primary);
        }
        
        .section-title.dark::after {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
        }
        
        .section-subtitle {
            font-size: 1.15rem;
            color: var(--text-muted);
            text-align: center;
            max-width: 600px;
            margin: 0 auto 4rem;
            line-height: 1.7;
        }
        
        .section-subtitle.dark {
            color: #64748B;
        }
        
        /* Stats */
        .stats-section {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 70px 20px;
            position: relative;
            overflow: hidden;
        }
        
        .stats-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2322C55E' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
            position: relative;
        }
        
        @media (max-width: 768px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
        
        .stat-item {
            padding: 30px 20px;
            background: rgba(255,255,255,0.03);
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.05);
            transition: all 0.4s ease;
        }
        
        .stat-item:hover {
            background: rgba(255,255,255,0.06);
            transform: translateY(-5px);
            border-color: rgba(34, 197, 94, 0.3);
        }
        
        .stat-number {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--accent-light);
            display: block;
            margin-bottom: 8px;
            text-shadow: 0 0 30px var(--accent-glow);
        }
        
        .stat-label {
            font-size: 1rem;
            color: var(--text-light);
            font-weight: 500;
        }
        
        /* Cards Grid */
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 35px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        @media (max-width: 900px) {
            .grid-3 { grid-template-columns: repeat(2, 1fr); }
        }
        
        @media (max-width: 600px) {
            .grid-3 { grid-template-columns: 1fr; }
        }
        
        /* Cards */
        .card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }
        
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent), var(--accent-light));
            transform: scaleX(0);
            transition: transform 0.5s ease;
            transform-origin: left;
        }
        
        .card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        }
        
        .card:hover::before { transform: scaleX(1); }
        
        .card-img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            background: linear-gradient(135deg, var(--secondary) 0%, var(--primary) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-light);
            font-size: 3.5rem;
            position: relative;
            overflow: hidden;
        }
        
        .card-img::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 50%, rgba(0,0,0,0.3) 100%);
        }
        
        .card-img i {
            position: relative;
            z-index: 1;
            transition: transform 0.5s ease;
        }
        
        .card:hover .card-img i {
            transform: scale(1.15) rotate(5deg);
        }
        
        .card-body { padding: 28px; }
        
        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.35rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            color: var(--primary);
            transition: color 0.3s ease;
        }
        
        .card:hover .card-title { color: var(--accent); }
        
        .card-text {
            color: #64748B;
            font-size: 0.95rem;
            line-height: 1.7;
        }
        
        .card-price {
            color: var(--accent);
            font-weight: 700;
            font-size: 1.2rem;
            margin-top: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .card-price::before {
            content: '';
            width: 20px;
            height: 2px;
            background: var(--accent);
        }
        
        /* Features */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        @media (max-width: 900px) {
            .features-grid { grid-template-columns: repeat(2, 1fr); }
        }
        
        @media (max-width: 500px) {
            .features-grid { grid-template-columns: 1fr; }
        }
        
        .feature {
            text-align: center;
            padding: 45px 28px;
            background: rgba(255,255,255,0.03);
            border-radius: 20px;
            border: 1px solid rgba(255,255,255,0.05);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .feature::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at center, var(--accent-glow) 0%, transparent 70%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        
        .feature:hover {
            background: rgba(255,255,255,0.06);
            border-color: rgba(34, 197, 94, 0.3);
            transform: translateY(-8px);
        }
        
        .feature:hover::before { opacity: 0.15; }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 1.8rem;
            color: white;
            position: relative;
            z-index: 1;
            transition: all 0.4s ease;
            box-shadow: 0 8px 25px var(--accent-glow);
        }
        
        .feature:hover .feature-icon {
            transform: scale(1.1) rotate(-5deg);
            box-shadow: 0 15px 40px var(--accent-glow);
        }
        
        .feature-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 12px;
            color: white;
            position: relative;
            z-index: 1;
        }
        
        .feature-text {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.7;
            position: relative;
            z-index: 1;
        }
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--accent), #16a34a);
            padding: 100px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 50%);
            animation: ctaGlow 8s ease-in-out infinite;
        }
        
        @keyframes ctaGlow {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(20px, 20px); }
        }
        
        .cta-section .container { position: relative; z-index: 1; }
        
        .cta-title {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            font-weight: 700;
            color: white;
            margin-bottom: 18px;
        }
        
        .cta-text {
            font-size: 1.2rem;
            color: rgba(255,255,255,0.9);
            margin-bottom: 35px;
            max-width: 550px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.7;
        }
        
        /* Footer */
        .footer {
            background: #080c10;
            color: white;
            padding: 80px 20px 30px;
            position: relative;
        }
        
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
            opacity: 0.3;
        }
        
        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 50px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        @media (max-width: 900px) {
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }
        
        @media (max-width: 500px) {
            .footer-grid { grid-template-columns: 1fr; text-align: center; }
        }
        
        .footer-brand {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 700;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        @media (max-width: 500px) {
            .footer-brand { justify-content: center; }
        }
        
        .footer-brand span {
            color: var(--accent-light);
            font-style: italic;
        }
        
        .footer-desc {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.8;
            margin-bottom: 22px;
        }
        
        .social-links { display: flex; gap: 14px; }
        
        @media (max-width: 500px) {
            .social-links { justify-content: center; }
        }
        
        .social-link {
            width: 44px;
            height: 44px;
            background: rgba(255,255,255,0.06);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid rgba(255,255,255,0.08);
        }
        
        .social-link:hover {
            background: var(--accent);
            transform: translateY(-4px) scale(1.05);
            box-shadow: 0 8px 25px var(--accent-glow);
            border-color: var(--accent);
        }
        
        .footer-title {
            font-size: 1.05rem;
            font-weight: 600;
            margin-bottom: 22px;
            color: white;
            position: relative;
            padding-bottom: 12px;
        }
        
        .footer-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 30px;
            height: 2px;
            background: var(--accent);
            border-radius: 1px;
        }
        
        @media (max-width: 500px) {
            .footer-title::after { left: 50%; transform: translateX(-50%); }
        }
        
        .footer-links { list-style: none; }
        
        .footer-links li { margin-bottom: 14px; }
        
        .footer-links a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .footer-links a:hover {
            color: var(--accent-light);
            transform: translateX(5px);
        }
        
        @media (max-width: 500px) {
            .footer-links a:hover { transform: none; }
        }
        
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.06);
            margin-top: 60px;
            padding-top: 28px;
            text-align: center;
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        
        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 16px 32px;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .btn:hover::before { left: 100%; }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            color: white;
            box-shadow: 0 4px 20px var(--accent-glow);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px var(--accent-glow);
        }
        
        .btn-outline {
            background: transparent;
            border: 2px solid rgba(255,255,255,0.4);
            color: white;
        }
        
        .btn-outline:hover {
            background: rgba(255,255,255,0.1);
            border-color: white;
            transform: translateY(-3px);
        }
        
        .btn-white {
            background: white;
            color: var(--primary);
        }
        
        .btn-white:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(255,255,255,0.35);
        }
        
        /* Auth Form Styles */
        .auth-container {
            background: rgba(30, 45, 61, 0.95);
            border-radius: 24px;
            padding: 45px;
            max-width: 460px;
            width: 100%;
            margin: 0 auto;
            box-shadow: 0 25px 80px rgba(0,0,0,0.4);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.08);
        }
        
        .auth-tabs {
            display: flex;
            background: rgba(255,255,255,0.05);
            border-radius: 14px;
            padding: 5px;
            margin-bottom: 35px;
        }
        
        .auth-tab {
            flex: 1;
            padding: 14px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            border-radius: 10px;
            transition: all 0.4s ease;
        }
        
        .auth-tab.active {
            background: linear-gradient(135deg, var(--accent), var(--accent-light));
            color: var(--primary);
            box-shadow: 0 4px 15px var(--accent-glow);
        }
        
        .auth-tab:not(.active):hover {
            color: var(--text-light);
            background: rgba(255,255,255,0.05);
        }
        
        .form-group { margin-bottom: 22px; }
        
        .form-label {
            display: block;
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1.2px;
        }
        
        .form-input {
            width: 100%;
            padding: 16px 18px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--accent);
            background: rgba(255,255,255,0.08);
            box-shadow: 0 0 0 4px var(--accent-glow);
        }
        
        .form-input::placeholder { color: rgba(255,255,255,0.25); }
        
        .form-checkbox {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }
        
        .form-checkbox input {
            width: 20px;
            height: 20px;
            accent-color: var(--accent);
            cursor: pointer;
        }
        
        .form-checkbox label {
            font-size: 0.9rem;
            color: var(--text-muted);
            cursor: pointer;
        }
        
        .form-link {
            color: var(--accent-light);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }
        
        .form-link:hover {
            text-decoration: underline;
            color: white;
        }
        
        .btn-auth {
            width: 100%;
            padding: 18px;
            font-size: 1.05rem;
        }
        
        /* Scroll Animations */
        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .reveal.active { opacity: 1; transform: translateY(0); }
        
        .reveal-left {
            opacity: 0;
            transform: translateX(-50px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .reveal-left.active { opacity: 1; transform: translateX(0); }
        
        .reveal-right {
            opacity: 0;
            transform: translateX(50px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .reveal-right.active { opacity: 1; transform: translateX(0); }
        
        .reveal-scale {
            opacity: 0;
            transform: scale(0.9);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .reveal-scale.active { opacity: 1; transform: scale(1); }
        
        /* Initial animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(35px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        
        .animate-fadeInUp {
            opacity: 0;
            animation: fadeInUp 0.7s ease forwards;
        }
        
        .animate-fadeInScale {
            opacity: 0;
            animation: fadeInScale 0.7s ease forwards;
        }
        
        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }
        
        /* Stagger delays */
        .stagger-1 { transition-delay: 0.1s; }
        .stagger-2 { transition-delay: 0.2s; }
        .stagger-3 { transition-delay: 0.3s; }
        .stagger-4 { transition-delay: 0.4s; }
        
        /* Floating particles */
        .particles {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
        }
        
        .particle {
            position: absolute;
            width: 6px;
            height: 6px;
            background: var(--accent-light);
            border-radius: 50%;
            opacity: 0.3;
            animation: particleFloat 15s infinite;
        }
        
        @keyframes particleFloat {
            0%, 100% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 0.4; }
            90% { opacity: 0.4; }
            100% { transform: translateY(-100vh) rotate(720deg); opacity: 0; }
        }
        
        /* Nav link hover effect */
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--accent-light);
            transition: width 0.3s ease;
        }
        
        .nav-links a:hover::after { width: 100%; }
        
        /* Pulse animation for CTA */
        @keyframes pulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.5); }
            50% { box-shadow: 0 0 0 20px rgba(34, 197, 94, 0); }
        }
        
        .cta-section .btn-white { animation: pulse 2s infinite; }
        
        /* Slideshow Dots */
        .slideshow-dots {
            position: absolute;
            bottom: 100px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 15;
            display: flex;
            gap: 12px;
        }
        
        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            cursor: pointer;
            transition: all 0.4s ease;
            border: 2px solid transparent;
        }
        
        .dot:hover {
            background: rgba(255, 255, 255, 0.7);
            transform: scale(1.2);
        }
        
        .dot.active {
            background: var(--accent-light);
            box-shadow: 0 0 15px var(--accent-glow);
            transform: scale(1.3);
        }
        
        /* Ken Burns Effect */
        .ken-burns-layer {
            position: absolute;
            inset: 0;
            z-index: 1;
            pointer-events: none;
            overflow: hidden;
        }
        
        .hero-slide.ken-burns img {
            animation: kenBurns 20s ease-in-out infinite alternate;
        }
        
        @keyframes kenBurns {
            0% { transform: scale(1) translate(0, 0); }
            25% { transform: scale(1.1) translate(-1%, -1%); }
            50% { transform: scale(1.15) translate(1%, 1%); }
            75% { transform: scale(1.1) translate(-0.5%, 0.5%); }
            100% { transform: scale(1) translate(0, 0); }
        }
        
        /* Title text shadow */
        .hero-text h1 {
            text-shadow: 2px 2px 20px rgba(0, 0, 0, 0.5);
        }
        
        .hero-text p {
            text-shadow: 1px 1px 10px rgba(0, 0, 0, 0.5);
        }
        
        @media (max-width: 768px) {
            .slideshow-dots { bottom: 80px; }
            .dot { width: 10px; height: 10px; }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header" id="header">
        <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <nav style="display: flex; align-items: center; justify-content: space-between;">
                <a href="/" style="display: flex; align-items: center; gap: 14px; text-decoration: none;">
                    <div style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--accent), var(--accent-light)); border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; color: white; font-weight: 700; font-family: 'Playfair Display', serif; box-shadow: 0 4px 15px var(--accent-glow);">
                        T
                    </div>
                    <span style="font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; color: white;">
                        TourEase <span style="color: var(--accent-light); font-style: italic;">Pro</span>
                    </span>
                </a>
                
                <div style="display: flex; align-items: center; gap: 45px;">
                    <div style="display: flex; gap: 32px;" class="nav-links">
                        <a href="#home" style="color: white; text-decoration: none; font-weight: 500; transition: color 0.3s;">Home</a>
                        <a href="#about" style="color: rgba(255,255,255,0.8); text-decoration: none; font-weight: 500; transition: color 0.3s;">About</a>
                        <a href="#destinations" style="color: rgba(255,255,255,0.8); text-decoration: none; font-weight: 500; transition: color 0.3s;">Destinations</a>
                        <a href="#services" style="color: rgba(255,255,255,0.8); text-decoration: none; font-weight: 500; transition: color 0.3s;">Services</a>
                        <a href="#contact" style="color: rgba(255,255,255,0.8); text-decoration: none; font-weight: 500; transition: color 0.3s;">Contact</a>
                    </div>
                    
                   
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section with Auth Form -->
    <section class="hero" id="home">
        <!-- Background Slideshow -->
        <div class="hero-slideshow" id="heroSlideshow">
            @forelse($galleries as $gallery)
            <div class="hero-slide{{ $loop->first ? ' active' : '' }}" data-slide="{{ $loop->index }}">
                <img src="{{ asset('storage/' . $gallery->image_path) }}" alt="{{ $gallery->title }}" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            @empty
            <!-- Fallback slides if no gallery images -->
            <div class="hero-slide active" data-slide="0">
                <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1920&q=80" alt="Mountain" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div class="hero-slide" data-slide="1">
                <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?w=1920&q=80" alt="Lake" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <div class="hero-slide" data-slide="2">
                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1920&q=80" alt="Beach" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            @endforelse
        </div>
        
        <!-- Slideshow Overlay -->
        <div class="hero-overlay"></div>
        
        <!-- Ken Burns Effect Layer -->
        <div class="ken-burns-layer" id="kenBurnsLayer"></div>
        
        <!-- Slideshow Dots -->
        <div class="slideshow-dots" id="slideshowDots">
            @forelse($galleries as $gallery)
            <span class="dot{{ $loop->first ? ' active' : '' }}" data-dot="{{ $loop->index }}"></span>
            @empty
            <span class="dot active" data-dot="0"></span>
            <span class="dot" data-dot="1"></span>
            <span class="dot" data-dot="2"></span>
            @endforelse
        </div>
        
        <!-- Animated Shapes (kept from original) -->
        <div class="hero-shapes">
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
        </div>
        <div class="particles" id="particles"></div>
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="animate-fadeInUp">Discover Your Next <span>Adventure</span></h1>
                <p class="animate-fadeInUp delay-100">Experience world-class tourism management with TourEase Pro. Book hotels, explore destinations, and create unforgettable memories.</p>
                <div class="hero-buttons animate-fadeInUp delay-200">
                    <a href="#destinations" class="btn btn-primary">Explore Destinations <i class="fas fa-arrow-right"></i></a>
                    <a href="#about" class="btn btn-outline">Learn More</a>
                </div>
            </div>
            
            <div class="hero-form animate-fadeInScale delay-300">
                <div class="auth-container">
                    <div class="auth-tabs">
                        <button class="auth-tab active" onclick="switchTab('login')">Sign In</button>
                        <button class="auth-tab" onclick="switchTab('register')">Register</button>
                    </div>
                    
                    <!-- Login Form -->
                    <form id="login-form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-input" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-input" placeholder="Enter your password" required>
                        </div>
                        <div class="form-checkbox">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Remember me</label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-auth">Sign In <i class="fas fa-sign-in-alt"></i></button>
                        @if (Route::has('password.request'))
                        <p style="text-align: center; margin-top: 18px;">
                            <a href="{{ route('password.request') }}" class="form-link">Forgot your password?</a>
                        </p>
                        @endif
                    </form>
                    
                    <!-- Register Form -->
                    <form id="register-form" method="POST" action="{{ route('register') }}" style="display: none;">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">First Name</label>
                            <input type="text" name="first_name" class="form-input" placeholder="Enter your first name" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Last Name</label>
                            <input type="text" name="last_name" class="form-input" placeholder="Enter your last name" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-input" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-input" placeholder="Create a password" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-input" placeholder="Confirm your password" required>
                        </div>
                        <div class="form-checkbox">
                            <input type="checkbox" id="terms" required>
                            <label for="terms">I agree to the <a href="#" class="form-link">Terms & Conditions</a></label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-auth">Create Account <i class="fas fa-user-plus"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="stats-grid">
            <div class="stat-item reveal stagger-1">
                <span class="stat-number" data-target="10000">0</span>
                <span class="stat-label">Happy Travelers</span>
            </div>
            <div class="stat-item reveal stagger-2">
                <span class="stat-number" data-target="500">0</span>
                <span class="stat-label">Destinations</span>
            </div>
            <div class="stat-item reveal stagger-3">
                <span class="stat-number" data-target="200">0</span>
                <span class="stat-label">Partner Hotels</span>
            </div>
            <div class="stat-item reveal stagger-4">
                <span class="stat-number" data-target="24" data-suffix="/7">0</span>
                <span class="stat-label">Customer Support</span>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section section-dark" id="about">
        <div class="container">
            <h2 class="section-title reveal">Why Choose TourEase Pro?</h2>
            <p class="section-subtitle reveal">We provide comprehensive tourism management solutions for travelers and businesses alike.</p>
            
            <div class="features-grid">
                <div class="feature reveal-scale stagger-1">
                    <div class="feature-icon">
                        <i class="fas fa-hotel"></i>
                    </div>
                    <h3 class="feature-title">Easy Booking</h3>
                    <p class="feature-text">Book hotels, resorts, and accommodations with just a few clicks. Instant confirmation.</p>
                </div>
                <div class="feature reveal-scale stagger-2">
                    <div class="feature-icon">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h3 class="feature-title">Curated Destinations</h3>
                    <p class="feature-text">Explore handpicked destinations with detailed guides and local recommendations.</p>
                </div>
                <div class="feature reveal-scale stagger-3">
                    <div class="feature-icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <h3 class="feature-title">Best Prices</h3>
                    <p class="feature-text">Get exclusive deals and competitive pricing on all your travel bookings.</p>
                </div>
                <div class="feature reveal-scale stagger-4">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="feature-title">24/7 Support</h3>
                    <p class="feature-text">Our dedicated support team is available round the clock to assist you.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Destinations Section -->
    <section class="section section-light" id="destinations">
        <div class="container">
            <h2 class="section-title dark reveal">Popular Destinations</h2>
            <p class="section-subtitle dark reveal">Discover amazing places around the world</p>
            
            <div class="grid-3">
                @forelse($destinations->take(3) as $destination)
                <div class="card reveal-left stagger-{{ $loop->iteration }}">
                    <div class="card-img">
                        @if($destination->image)
                        <img src="{{ asset('storage/' . $destination->image) }}" alt="{{ $destination->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                        <i class="fas fa-map-marker-alt"></i>
                        @endif
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">{{ $destination->name }}</h3>
                        <p class="card-text">{{ $destination->description }}</p>
                        <span class="card-price">From ${{ number_format($destination->price, 0) }}</span>
                    </div>
                </div>
                @empty
                <div class="card reveal-left stagger-1">
                    <div class="card-img">
                        <i class="fas fa-mountain"></i>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">Mountain Retreats</h3>
                        <p class="card-text">Escape to serene mountain destinations with breathtaking views and adventure activities.</p>
                        <span class="card-price">From $299</span>
                    </div>
                </div>
                <div class="card reveal-left stagger-2">
                    <div class="card-img">
                        <i class="fas fa-umbrella-beach"></i>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">Beach Paradise</h3>
                        <p class="card-text">Relax on pristine beaches with crystal-clear waters and luxury coastal resorts.</p>
                        <span class="card-price">From $449</span>
                    </div>
                </div>
                <div class="card reveal-left stagger-3">
                    <div class="card-img">
                        <i class="fas fa-city"></i>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">Urban Exploration</h3>
                        <p class="card-text">Discover vibrant cities with rich culture, dining, and entertainment experiences.</p>
                        <span class="card-price">From $399</span>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="section section-dark" id="services">
        <div class="container">
            <h2 class="section-title reveal">Our Services</h2>
            <p class="section-subtitle reveal">Comprehensive tourism management for every need</p>
            
            <div class="grid-3">
                <div class="card reveal-right stagger-1" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                    <div class="card-body" style="text-align: center;">
                        <div style="width: 70px; height: 70px; background: linear-gradient(135deg, var(--accent), var(--accent-light)); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 1.5rem; color: white; box-shadow: 0 8px 25px var(--accent-glow);">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h3 class="card-title" style="color: white;">Hotel Reservations</h3>
                        <p class="card-text">Book accommodations across various categories from budget to luxury.</p>
                    </div>
                </div>
                <div class="card reveal-right stagger-2" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                    <div class="card-body" style="text-align: center;">
                        <div style="width: 70px; height: 70px; background: linear-gradient(135deg, var(--accent), var(--accent-light)); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 1.5rem; color: white; box-shadow: 0 8px 25px var(--accent-glow);">
                            <i class="fas fa-plane-departure"></i>
                        </div>
                        <h3 class="card-title" style="color: white;">Travel Planning</h3>
                        <p class="card-text">Comprehensive travel itineraries tailored to your preferences and budget.</p>
                    </div>
                </div>
                <div class="card reveal-right stagger-3" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05);">
                    <div class="card-body" style="text-align: center;">
                        <div style="width: 70px; height: 70px; background: linear-gradient(135deg, var(--accent), var(--accent-light)); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 1.5rem; color: white; box-shadow: 0 8px 25px var(--accent-glow);">
                            <i class="fas fa-camera"></i>
                        </div>
                        <h3 class="card-title" style="color: white;">Tour Packages</h3>
                        <p class="card-text">Curated tour packages including guided tours, activities, and experiences.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="cta-title reveal">Ready to Start Your Journey?</h2>
            <p class="cta-text reveal">Join thousands of travelers who trust TourEase Pro for their travel needs. Sign up today and get exclusive offers.</p>
            <a href="{{ route('register') }}" class="btn btn-white reveal" style="font-size: 1.1rem; padding: 18px 38px;">Get Started Now <i class="fas fa-rocket"></i></a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer" id="contact">
        <div class="footer-grid">
            <div>
                <div class="footer-brand">
                    <div style="width: 44px; height: 44px; background: linear-gradient(135deg, var(--accent), var(--accent-light)); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; color: white; font-weight: 700; font-family: 'Playfair Display', serif;">
                        T
                    </div>
                    TourEase <span>Pro</span>
                </div>
                <p class="footer-desc">Your premier tourism management system. We make travel planning easy and enjoyable for everyone.</p>
                <div class="social-links">
                    <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            <div>
                <h4 class="footer-title">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="#home"><i class="fas fa-chevron-right"></i> Home</a></li>
                    <li><a href="#about"><i class="fas fa-chevron-right"></i> About Us</a></li>
                    <li><a href="#destinations"><i class="fas fa-chevron-right"></i> Destinations</a></li>
                    <li><a href="#services"><i class="fas fa-chevron-right"></i> Services</a></li>
                </ul>
            </div>
            <div>
                <h4 class="footer-title">Services</h4>
                <ul class="footer-links">
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Hotel Booking</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Travel Packages</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Tour Guides</a></li>
                    <li><a href="#"><i class="fas fa-chevron-right"></i> Transportation</a></li>
                </ul>
            </div>
            <div>
                <h4 class="footer-title">Contact</h4>
                <ul class="footer-links">
                    <li><a href="#"><i class="fas fa-envelope"></i> info@toureasepro.com</a></li>
                    <li><a href="#"><i class="fas fa-phone"></i> +1 (555) 123-4567</a></li>
                    <li><a href="#"><i class="fas fa-map-marker-alt"></i> 123 Travel Street, City</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} TourEase Pro. All rights reserved. Made with <i class="fas fa-heart" style="color: var(--accent);"></i> for travelers</p>
        </div>
    </footer>

    <script>
        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.getElementById('header');
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Auth tab switching with animation
        function switchTab(tab) {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            const tabs = document.querySelectorAll('.auth-tab');
            
            if (tab === 'login') {
                loginForm.style.display = 'block';
                loginForm.style.opacity = '0';
                registerForm.style.display = 'none';
                tabs[0].classList.add('active');
                tabs[1].classList.remove('active');
                setTimeout(() => {
                    loginForm.style.opacity = '1';
                    loginForm.style.transition = 'opacity 0.3s ease';
                }, 10);
            } else {
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
                registerForm.style.opacity = '0';
                tabs[0].classList.remove('active');
                tabs[1].classList.add('active');
                setTimeout(() => {
                    registerForm.style.opacity = '1';
                    registerForm.style.transition = 'opacity 0.3s ease';
                }, 10);
            }
        }

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });

        // Scroll reveal animations
        const revealElements = document.querySelectorAll('.reveal, .reveal-left, .reveal-right, .reveal-scale');
        
        const revealOnScroll = () => {
            const windowHeight = window.innerHeight;
            const elementVisible = 100;
            
            revealElements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                
                if (elementTop < windowHeight - elementVisible) {
                    element.classList.add('active');
                }
            });
        };
        
        window.addEventListener('scroll', revealOnScroll);
        revealOnScroll();

        // Stats counter animation
        const statNumbers = document.querySelectorAll('.stat-number');
        let statsAnimated = false;
        
        const animateStats = () => {
            if (statsAnimated) return;
            
            const statsSection = document.querySelector('.stats-section');
            const statsSectionTop = statsSection.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            
            if (statsSectionTop < windowHeight - 200) {
                statsAnimated = true;
                
                statNumbers.forEach(stat => {
                    const target = parseInt(stat.getAttribute('data-target'));
                    const suffix = stat.getAttribute('data-suffix') || '+';
                    const duration = 2000;
                    const increment = target / (duration / 16);
                    let current = 0;
                    
                    const updateCount = () => {
                        current += increment;
                        if (current < target) {
                            stat.textContent = Math.floor(current).toLocaleString();
                            requestAnimationFrame(updateCount);
                        } else {
                            stat.textContent = target.toLocaleString() + suffix;
                        }
                    };
                    
                    updateCount();
                });
            }
        };
        
        window.addEventListener('scroll', animateStats);
        animateStats();

        // Create floating particles
        const createParticles = () => {
            const particlesContainer = document.getElementById('particles');
            const particleCount = 20;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 15 + 's';
                particle.style.animationDuration = (15 + Math.random() * 10) + 's';
                particle.style.opacity = Math.random() * 0.5 + 0.1;
                particle.style.width = (4 + Math.random() * 4) + 'px';
                particle.style.height = particle.style.width;
                particlesContainer.appendChild(particle);
            }
        };
        
        createParticles();

        // Initial animations on page load
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                revealOnScroll();
                animateStats();
            }, 100);
        });
        
        // ========== SLIDESHOW FUNCTIONALITY ==========
        
        // Slideshow Configuration
        const slideshowConfig = {
            interval: 5000, // 5 seconds per slide
            transitionDuration: 1500,
            currentSlide: 0,
            totalSlides: 0,
            intervalId: null
        };
        
        // Initialize Slideshow
        const initSlideshow = () => {
            const slides = document.querySelectorAll('.hero-slide');
            const dots = document.querySelectorAll('.dot');
            
            if (slides.length === 0) return;
            
            slideshowConfig.totalSlides = slides.length;
            
            // Add Ken Burns effect to active slide
            const activeSlide = document.querySelector('.hero-slide.active');
            if (activeSlide) {
                activeSlide.classList.add('ken-burns');
            }
            
            // Start autoplay
            startSlideshow();
            
            // Add click handlers for dots
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    goToSlide(index);
                    resetSlideshow();
                });
            });
            
            // Pause on hover
            const heroSection = document.getElementById('home');
            heroSection.addEventListener('mouseenter', stopSlideshow);
            heroSection.addEventListener('mouseleave', startSlideshow);
        };
        
        // Go to specific slide
        const goToSlide = (index) => {
            if (index < 0 || index >= slideshowConfig.totalSlides) return;
            
            const slides = document.querySelectorAll('.hero-slide');
            const dots = document.querySelectorAll('.dot');
            
            // Remove active class and ken-burns from all slides
            slides.forEach(slide => {
                slide.classList.remove('active', 'ken-burns');
            });
            
            // Remove active class from all dots
            dots.forEach(dot => dot.classList.remove('active'));
            
            // Add active class to current slide and dot
            slides[index].classList.add('active');
            slides[index].classList.add('ken-burns');
            dots[index].classList.add('active');
            
            slideshowConfig.currentSlide = index;
        };
        
        // Next slide
        const nextSlide = () => {
            let next = slideshowConfig.currentSlide + 1;
            if (next >= slideshowConfig.totalSlides) {
                next = 0;
            }
            goToSlide(next);
        };
        
        // Start autoplay
        const startSlideshow = () => {
            if (slideshowConfig.intervalId) return;
            slideshowConfig.intervalId = setInterval(nextSlide, slideshowConfig.interval);
        };
        
        // Stop autoplay
        const stopSlideshow = () => {
            if (slideshowConfig.intervalId) {
                clearInterval(slideshowConfig.intervalId);
                slideshowConfig.intervalId = null;
            }
        };
        
        // Reset slideshow
        const resetSlideshow = () => {
            stopSlideshow();
            startSlideshow();
        };
        
        // Initialize slideshow when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initSlideshow);
        } else {
            initSlideshow();
        }
    </script>
</body>
</html>

