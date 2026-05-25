<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, viewport-fit=cover">
    <title>berUANG - Kelola Keuanganmu dengan Mudah</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Roboto:wght@300;400;500;600;700&family=Roboto+Slab:wght@400;500;600;700&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', 'Roboto', sans-serif;
            background: #FFFFFF;
            overflow-x: hidden;
            width: 100%;
            padding-top: 90px;
        }
        
        /* Container */
        .landing-container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            background: #FFFFFF;
            position: relative;
        }
        
        /* ========== NAVBAR - PUTIH DENGAN BLUR ========== */
        .navbar {
            position: fixed;
            top: 20px;
            left: 0;
            right: 0;
            width: auto;
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.08);
            border-radius: 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 6px 20px;
            transition: all 0.3s ease;
            z-index: 1000;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        /* Navbar hidden state - saat scroll ke bawah */
        .navbar.navbar-hidden {
            transform: translateY(-100%);
            opacity: 0;
            visibility: hidden;
        }
        
        /* Navbar visible state - saat scroll ke atas */
        .navbar.navbar-visible {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
        }
        
        /* Navbar scrolled state - berubah saat discroll */
        .navbar.navbar-scrolled {
            top: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 0 0 30px 30px;
            box-shadow: 0px 6px 25px rgba(0, 0, 0, 0.12);
            padding: 4px 20px;
        }
        
        .navbar.navbar-scrolled .logo-nav {
            width: 55px;
            height: 55px;
        }
        
        .navbar.navbar-scrolled .nav-menu a {
            font-size: 14px;
        }
        
        .navbar.navbar-scrolled .btn-login,
        .navbar.navbar-scrolled .btn-signin {
            padding: 4px 14px;
            font-size: 12px;
        }
        
        .logo-nav {
            width: 60px;
            height: 60px;
            background: url('{{ asset("images/berUANG-removebg-preview.png") }}') center/contain no-repeat;
            transition: all 0.3s ease;
            filter: drop-shadow(0px 2px 4px rgba(0, 0, 0, 0.1));
        }
        
        .nav-menu {
            display: flex;
            gap: 25px;
            align-items: center;
        }
        
        .nav-menu a {
            font-family: 'Roboto';
            font-weight: 500;
            font-size: 15px;
            line-height: 20px;
            color: #333333;
            text-decoration: none;
            transition: all 0.3s;
            padding: 8px 0;
            position: relative;
        }
        
        .nav-menu a:hover {
            color: #4F772D;
        }
        
        .nav-menu a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: #4F772D;
            transition: width 0.3s;
        }
        
        .nav-menu a:hover::after {
            width: 100%;
        }
        
        .nav-buttons {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        
        .btn-login {
            font-family: 'Roboto';
            font-weight: 500;
            font-size: 13px;
            line-height: 18px;
            color: #333333;
            text-decoration: none;
            padding: 6px 16px;
            transition: all 0.3s;
            border-radius: 30px;
        }
        
        .btn-login:hover {
            color: #4F772D;
            background: rgba(79, 119, 45, 0.08);
        }
        
        .btn-signin {
            background: #4F772D;
            border-radius: 30px;
            padding: 6px 18px;
            font-family: 'Roboto';
            font-weight: 500;
            font-size: 13px;
            line-height: 18px;
            color: #FFFFFF;
            text-decoration: none;
            transition: all 0.3s;
            box-shadow: 0px 2px 6px rgba(79, 119, 45, 0.3);
        }
        
        .btn-signin:hover {
            background: #3d5e22;
            transform: translateY(-1px);
            box-shadow: 0px 4px 10px rgba(79, 119, 45, 0.4);
        }
        
        /* ========== HERO SECTION ========== */
        .hero-section {
            padding: 60px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 50px;
        }
        
        .hero-left {
            flex: 1;
        }
        
        .hero-title {
            font-family: 'Inter';
            font-weight: 700;
            font-size: 56px;
            line-height: 68px;
            color: #000000;
            margin-bottom: 20px;
            text-shadow: 0px 2px 4px rgba(0, 0, 0, 0.05);
        }
        
        .hero-subtitle {
            font-family: 'Inter';
            font-weight: 400;
            font-size: 16px;
            line-height: 24px;
            color: #666666;
            margin-bottom: 35px;
        }
        
        .cta-button {
            display: inline-block;
            background: #4F772D;
            border-radius: 40px;
            padding: 14px 36px;
            font-family: 'Roboto';
            font-weight: 600;
            font-size: 16px;
            line-height: 20px;
            color: #FFFFFF;
            text-decoration: none;
            box-shadow: 0px 6px 15px rgba(79, 119, 45, 0.3);
            transition: all 0.3s;
        }
        
        .cta-button:hover {
            background: #3d5e22;
            transform: translateY(-3px);
            box-shadow: 0px 10px 25px rgba(79, 119, 45, 0.4);
        }
        
        .preview-image {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 40px 20px;
            perspective: 2000px;
            min-height: 500px;
        }
        
        .preview-stack {
            position: relative;
            width: 100%;
            max-width: 650px;
            height: 400px;
            transform-style: preserve-3d;
        }
        
        .browser-mockup {
            position: absolute;
            width: 100%;
            background: #FFFFFF;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1), 0 5px 15px rgba(0,0,0,0.05);
            border: 1px solid rgba(0,0,0,0.08);
            transition: all 0.6s cubic-bezier(0.23, 1, 0.32, 1);
        }
        
        /* Staggered positions */
        .mockup-1 {
            z-index: 3;
            transform: translateZ(50px);
        }
        
        .mockup-2 {
            z-index: 2;
            transform: translate(-30px, -30px) rotate(-2deg);
            opacity: 0.8;
        }
        
        .mockup-3 {
            z-index: 1;
            transform: translate(30px, 30px) rotate(2deg);
            opacity: 0.6;
        }
        
        /* Hover effects for the stack */
        .preview-image:hover .mockup-1 {
            transform: translateZ(100px) translateY(-10px);
            box-shadow: 0 40px 80px rgba(0,0,0,0.15);
        }
        
        .preview-image:hover .mockup-2 {
            transform: translate(-80px, -50px) rotate(-5deg) translateZ(20px);
            opacity: 1;
        }
        
        .preview-image:hover .mockup-3 {
            transform: translate(80px, 50px) rotate(5deg) translateZ(20px);
            opacity: 1;
        }
        
        .browser-header {
            background: #F5F5F5;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            border-bottom: 1px solid #E0E0E0;
        }
        
        .dot-red, .dot-yellow, .dot-green {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }
        
        .dot-red { background: #FF5F56; }
        .dot-yellow { background: #FFBD2E; }
        .dot-green { background: #27C93F; }
        
        .browser-address {
            flex: 1;
            background: white;
            height: 16px;
            border-radius: 3px;
            margin: 0 8px;
            border: 1px solid #E8E8E8;
            display: flex;
            align-items: center;
            padding: 0 8px;
            font-size: 9px;
            color: #AAA;
            overflow: hidden;
            white-space: nowrap;
        }
        
        .browser-content {
            width: 100%;
            aspect-ratio: 16/10;
            background: #FDFDFC;
            position: relative;
            overflow: hidden;
        }
        
        .dashboard-preview-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top;
        }
        
        /* Mobile adjustments for the stack */
        @media (max-width: 768px) {
            .preview-image {
                min-height: 350px;
            }
            .mockup-2, .mockup-3 {
                display: none;
            }
            .mockup-1 {
                transform: none;
            }
        }
        
        /* ========== FEATURES SECTION ========== */
        .features-section {
            padding: 70px 40px;
        }
        
        .features-header {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .features-badge {
            display: inline-block;
            background: #C5E389;
            border-radius: 25px;
            padding: 6px 20px;
            font-family: 'Inter';
            font-weight: 500;
            font-size: 14px;
            color: #000000;
            margin-bottom: 15px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.05);
        }
        
        .features-title {
            font-family: 'Inter';
            font-weight: 600;
            font-size: 36px;
            line-height: 44px;
            color: #000000;
            margin-bottom: 15px;
        }
        
        .features-subtitle {
            font-family: 'Inter';
            font-weight: 400;
            font-size: 15px;
            line-height: 22px;
            color: #666666;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .cards-row {
            display: flex;
            gap: 30px;
            justify-content: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .card {
            width: 100%;
            max-width: 350px;
            border-radius: 24px;
            padding: 30px 25px;
            text-align: center;
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .card:hover {
            transform: translateY(-10px);
        }
        
        .card-green {
            background: #4F772D;
            box-shadow: 0px 15px 30px rgba(79, 119, 45, 0.25);
        }
        
        .card-green:hover {
            box-shadow: 0px 20px 40px rgba(79, 119, 45, 0.35);
        }
        
        .card-white {
            background: #FFFFFF;
            box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.08);
        }
        
        .card-white:hover {
            box-shadow: 0px 20px 40px rgba(0, 0, 0, 0.12);
        }
        
        .card-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 20px;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            filter: drop-shadow(0px 4px 8px rgba(0, 0, 0, 0.1));
        }
        
        .card-badge {
            display: inline-block;
            background: #C5E389;
            border-radius: 20px;
            padding: 5px 14px;
            font-family: 'Inter';
            font-weight: 500;
            font-size: 11px;
            color: rgba(38, 38, 38, 0.8);
            margin-bottom: 15px;
            box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        .card-badge-white {
            background: #FFFFFF;
        }
        
        .card-title {
            font-family: 'Inter';
            font-weight: 600;
            font-size: 18px;
            line-height: 24px;
            margin-bottom: 12px;
        }
        
        .card-white .card-title {
            color: #000000;
        }
        
        .card-green .card-title {
            color: #FFFFFF;
        }
        
        .card-desc {
            font-family: 'Inter';
            font-weight: 400;
            font-size: 13px;
            line-height: 18px;
            text-align: center;
        }
        
        .card-white .card-desc {
            color: #666666;
        }
        
        .card-green .card-desc {
            color: #F0F0F0;
        }
        
        /* ========== OFFER SECTION ========== */
        .offer-section {
            padding: 70px 40px;
            background: #FAFAFA;
        }
        
        .offer-content {
            display: flex;
            align-items: center;
            gap: 60px;
        }
        
        .offer-left {
            flex: 1;
        }
        
        .offer-left h2 {
            font-family: 'Inter';
            font-weight: 600;
            font-size: 36px;
            line-height: 46px;
            color: #000000;
        }
        
        .offer-right {
            flex: 1;
        }
        
        .offer-right p {
            font-family: 'Inter';
            font-weight: 400;
            font-size: 18px;
            line-height: 28px;
            color: #444444;
        }
        
        /* ========== AI SECTION ========== */
        .ai-section {
            padding: 70px 40px;
        }
        
        .ai-cards {
            display: flex;
            gap: 30px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .ai-card {
            width: 100%;
            max-width: 350px;
            background: #4F772D;
            border-radius: 24px;
            padding: 30px 25px;
            transition: all 0.3s;
            cursor: pointer;
            box-shadow: 0px 15px 30px rgba(79, 119, 45, 0.25);
        }
        
        .ai-card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 25px 45px rgba(79, 119, 45, 0.35);
        }
        
        .ai-badge {
            display: inline-block;
            background: #FFFFFF;
            border-radius: 20px;
            padding: 5px 14px;
            font-family: 'Inter';
            font-weight: 500;
            font-size: 11px;
            color: rgba(0, 0, 0, 0.8);
            margin-bottom: 15px;
            box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        .ai-title {
            font-family: 'Inter';
            font-weight: 600;
            font-size: 18px;
            line-height: 24px;
            color: #FFFFFF;
            margin-bottom: 12px;
        }
        
        .ai-desc {
            font-family: 'Inter';
            font-weight: 400;
            font-size: 13px;
            line-height: 18px;
            color: #F0F0F0;
        }
        
        /* ========== TESTIMONIALS SECTION WITH SLIDER ========== */
        .testimonials-section {
            margin: 40px;
            padding: 50px;
            background: #F5F5F5;
            border-radius: 24px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.05);
        }
        
        .testimonials-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .testimonials-badge {
            display: inline-block;
            background: #D0D0D0;
            border-radius: 20px;
            padding: 5px 14px;
            font-family: 'Inter';
            font-weight: 500;
            font-size: 12px;
            color: rgba(0, 0, 0, 0.8);
            margin-bottom: 15px;
        }
        
        .testimonials-title {
            font-family: 'Inter';
            font-weight: 700;
            font-size: 32px;
            line-height: 42px;
            color: #000000;
            margin-bottom: 10px;
        }
        
        .testimonials-subtitle {
            font-family: 'Inter';
            font-weight: 400;
            font-size: 14px;
            color: #666;
        }
        
        /* Slider Container */
        .testimonials-slider-container {
            position: relative;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .slider-btn {
            width: 45px;
            height: 45px;
            background: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.12);
            flex-shrink: 0;
        }
        
        .slider-btn:hover {
            background: #4F772D;
            color: white;
            transform: scale(1.05);
            box-shadow: 0px 6px 16px rgba(79, 119, 45, 0.3);
        }
        
        .slider-btn:active {
            transform: scale(0.95);
        }
        
        .testimonials-slider {
            display: flex;
            gap: 25px;
            overflow-x: auto;
            scroll-behavior: smooth;
            scrollbar-width: none;
            -ms-overflow-style: none;
            flex: 1;
            padding: 10px 5px;
        }
        
        .testimonials-slider::-webkit-scrollbar {
            display: none;
        }
        
        /* Testimonial Card */
        .testimonial-card {
            min-width: 380px;
            max-width: 380px;
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            flex-shrink: 0;
        }
        
        .testimonial-card:hover {
            transform: translateY(-8px);
            box-shadow: 0px 15px 35px rgba(0, 0, 0, 0.12);
        }
        
        .testimonial-stars {
            margin-bottom: 20px;
        }
        
        .star-filled {
            color: #FFCE31;
            font-size: 20px;
            margin-right: 3px;
            text-shadow: 0px 1px 2px rgba(0, 0, 0, 0.1);
        }
        
        .star-half {
            color: #FFCE31;
            font-size: 20px;
            margin-right: 3px;
        }
        
        .testimonial-card-text {
            font-family: 'Roboto Slab';
            font-weight: 500;
            font-size: 16px;
            line-height: 24px;
            color: #333;
            margin-bottom: 25px;
            min-height: 100px;
        }
        
        .testimonial-profile {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .testimonial-avatar {
            width: 55px;
            height: 55px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
        }
        
        .testimonial-avatar.avatar2 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .testimonial-avatar.avatar3 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        .testimonial-avatar.avatar4 {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        
        .testimonial-avatar.avatar5 {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }
        
        .testimonial-info {
            flex: 1;
        }
        
        .testimonial-name {
            font-family: 'Inter';
            font-weight: 600;
            font-size: 16px;
            color: #000;
            margin-bottom: 5px;
        }
        
        .testimonial-role {
            font-family: 'Roboto';
            font-weight: 300;
            font-size: 13px;
            color: #666;
        }
        
        /* Slider Dots */
        .slider-dots {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 30px;
        }
        
        .dot {
            width: 10px;
            height: 10px;
            background: #ccc;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .dot.active {
            width: 25px;
            background: #4F772D;
            border-radius: 5px;
        }
        
        .dot:hover {
            background: #4F772D;
        }
        
        /* ========== CTA SECTION ========== */
        .cta-section {
            margin: 40px;
            background: linear-gradient(90deg, #B4E74E 0%, #4F772D 87.02%);
            border-radius: 30px;
            padding: 60px 40px;
            text-align: center;
            box-shadow: 0px 15px 35px rgba(79, 119, 45, 0.25);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .cta-section:hover {
            transform: translateY(-3px);
            box-shadow: 0px 20px 45px rgba(79, 119, 45, 0.35);
        }
        
        .cta-title {
            font-family: 'Roboto';
            font-weight: 700;
            font-size: 36px;
            line-height: 46px;
            color: #FFFFFF;
            margin-bottom: 20px;
            text-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .cta-subtitle {
            font-family: 'Roboto';
            font-weight: 500;
            font-size: 16px;
            line-height: 24px;
            color: #FFFFFF;
            margin-bottom: 35px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .cta-button-large {
            display: inline-block;
            background: #EDFF8A;
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.15);
            border-radius: 40px;
            padding: 14px 45px;
            font-family: 'Roboto';
            font-weight: 600;
            font-size: 18px;
            line-height: 22px;
            color: #000000;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .cta-button-large:hover {
            transform: translateY(-3px);
            box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.2);
        }
        
        /* ========== FOOTER ========== */
        .footer {
            width: 100%;
            background: #74A671;
            padding: 50px 0 30px;
            margin-top: 60px;
            position: relative;
        }
        
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #B4E74E, #4F772D);
        }
        
        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
        }
        
        .footer-content {
            display: flex;
            justify-content: space-between;
            gap: 40px;
            flex-wrap: wrap;
        }
        
        .footer-logo-section {
            flex: 1;
            min-width: 250px;
        }
        
        .footer-logo {
            width: 120px;
            height: 120px;
            background: url('{{ asset("images/berUANG-removebg-preview.png") }}') center/contain no-repeat;
            margin-bottom: 15px;
            filter: drop-shadow(0px 4px 8px rgba(0, 0, 0, 0.15));
        }
        
        .footer-logo-text {
            font-family: 'Roboto';
            font-weight: 300;
            font-size: 14px;
            line-height: 20px;
            color: #FFFFFF;
            max-width: 280px;
            text-shadow: 0px 1px 2px rgba(0, 0, 0, 0.1);
        }
        
        .footer-nav {
            display: flex;
            gap: 60px;
            flex-wrap: wrap;
        }
        
        .footer-nav-column h4 {
            font-family: 'Inter';
            font-weight: 700;
            font-size: 18px;
            color: #FFFFFF;
            margin-bottom: 20px;
            text-shadow: 0px 1px 2px rgba(0, 0, 0, 0.1);
        }
        
        .footer-nav-column a {
            display: block;
            font-family: 'Roboto';
            font-weight: 400;
            font-size: 14px;
            color: #FFFFFF;
            text-decoration: none;
            margin-bottom: 12px;
            opacity: 0.8;
            transition: opacity 0.3s;
        }
        
        .footer-nav-column a:hover {
            opacity: 1;
        }
        
        .footer-form {
            flex: 1;
            min-width: 250px;
        }
        
        .footer-form input, 
        .footer-form textarea {
            width: 100%;
            padding: 12px 16px;
            margin-bottom: 12px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            font-family: 'Quicksand';
            font-size: 14px;
            color: #FFFFFF;
            transition: all 0.3s;
        }
        
        .footer-form input:focus, 
        .footer-form textarea:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.25);
            border-color: #FFFFFF;
        }
        
        .footer-form input::placeholder, 
        .footer-form textarea::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .footer-form button {
            background: #0F0D0D;
            padding: 12px 28px;
            border: none;
            border-radius: 8px;
            font-family: 'Quicksand';
            font-weight: 600;
            font-size: 14px;
            color: #FFFFFF;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.2);
        }
        
        .footer-form button:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.25);
        }
        
        .footer-bottom {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 50px;
            padding-top: 25px;
            border-top: 1px solid rgba(255, 255, 255, 0.3);
            font-family: 'Roboto Slab';
            font-size: 12px;
            color: rgba(0, 0, 0, 0.7);
        }
        
        /* ========== RESPONSIVE BREAKPOINTS ========== */
        
        /* Tablet Landscape & Desktop */
        @media (min-width: 1025px) {
            .navbar {
                padding: 8px 30px;
            }
            
            .logo-nav {
                width: 75px;
                height: 75px;
            }
            
            .nav-menu {
                gap: 40px;
            }
            
            .nav-menu a {
                font-size: 16px;
            }
        }
        
        /* Tablet Portrait */
        @media (min-width: 769px) and (max-width: 1024px) {
            .navbar {
                max-width: 700px;
                padding: 5px 18px;
            }
            
            .logo-nav {
                width: 55px;
                height: 55px;
            }
            
            .nav-menu {
                gap: 20px;
            }
            
            .nav-menu a {
                font-size: 14px;
            }
            
            .btn-login, .btn-signin {
                padding: 5px 14px;
                font-size: 12px;
            }
            
            body {
                padding-top: 85px;
            }
            
            .hero-title {
                font-size: 42px;
                line-height: 52px;
            }
            
            .features-title {
                font-size: 30px;
                line-height: 38px;
            }
            
            .offer-left h2 {
                font-size: 30px;
                line-height: 40px;
            }
            
            .cta-title {
                font-size: 30px;
                line-height: 40px;
            }
            
            .testimonial-card {
                min-width: 320px;
                max-width: 320px;
            }
        }
        
        /* Mobile Landscape */
        @media (min-width: 481px) and (max-width: 768px) {
            body {
                padding-top: 80px;
            }
            
            .navbar {
                max-width: 90%;
                padding: 6px 16px;
                flex-wrap: wrap;
                justify-content: center;
                gap: 10px;
                border-radius: 30px;
            }
            
            .logo-nav {
                width: 50px;
                height: 50px;
            }
            
            .nav-menu {
                gap: 18px;
                order: 3;
                width: 100%;
                justify-content: center;
            }
            
            .nav-menu a {
                font-size: 13px;
                padding: 5px 0;
            }
            
            .nav-menu a::after {
                display: none;
            }
            
            .nav-buttons {
                gap: 8px;
            }
            
            .btn-login, .btn-signin {
                padding: 5px 12px;
                font-size: 12px;
            }
            
            .hero-section {
                flex-direction: column;
                padding: 40px 25px;
                text-align: center;
            }
            
            .hero-left {
                text-align: center;
            }
            
            .hero-title {
                font-size: 32px;
                line-height: 42px;
            }
            
            .features-section {
                padding: 50px 25px;
            }
            
            .features-title {
                font-size: 26px;
                line-height: 34px;
            }
            
            .offer-section {
                padding: 50px 25px;
            }
            
            .offer-content {
                flex-direction: column;
                gap: 30px;
                text-align: center;
            }
            
            .offer-left h2 {
                font-size: 26px;
                line-height: 36px;
                text-align: center;
            }
            
            .offer-right p {
                text-align: center;
                font-size: 15px;
            }
            
            .ai-section {
                padding: 50px 25px;
            }
            
            .testimonials-section {
                margin: 25px;
                padding: 30px 20px;
            }
            
            .testimonials-title {
                font-size: 24px;
                line-height: 32px;
            }
            
            .testimonial-card {
                min-width: 300px;
                max-width: 300px;
                padding: 20px;
            }
            
            .testimonial-card-text {
                font-size: 14px;
                line-height: 20px;
                min-height: 80px;
            }
            
            .slider-btn {
                width: 35px;
                height: 35px;
            }
            
            .cta-section {
                margin: 25px;
                padding: 40px 25px;
            }
            
            .cta-title {
                font-size: 26px;
                line-height: 36px;
            }
            
            .footer-container {
                padding: 0 25px;
            }
            
            .footer-content {
                flex-direction: column;
                text-align: center;
            }
            
            .footer-logo-section {
                text-align: center;
            }
            
            .footer-logo {
                margin: 0 auto 15px;
            }
            
            .footer-logo-text {
                margin: 0 auto;
            }
            
            .footer-nav {
                justify-content: center;
                text-align: center;
            }
            
            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
        }
        
        /* Mobile Portrait */
        @media (max-width: 480px) {
            body {
                padding-top: 70px;
            }
            
            .navbar {
                max-width: 95%;
                padding: 5px 12px;
                flex-wrap: wrap;
                justify-content: center;
                gap: 8px;
                border-radius: 25px;
                margin: 0 auto;
                top: 10px;
            }
            
            .navbar.navbar-scrolled {
                padding: 3px 12px;
            }
            
            .logo-nav {
                width: 45px;
                height: 45px;
            }
            
            .nav-menu {
                gap: 14px;
                order: 3;
                width: 100%;
                justify-content: center;
            }
            
            .nav-menu a {
                font-size: 11px;
                padding: 4px 0;
            }
            
            .nav-buttons {
                gap: 6px;
            }
            
            .btn-login, .btn-signin {
                padding: 4px 10px;
                font-size: 10px;
            }
            
            .hero-section {
                padding: 30px 20px;
                gap: 30px;
            }
            
            .hero-title {
                font-size: 28px;
                line-height: 36px;
            }
            
            .hero-subtitle {
                font-size: 14px;
                line-height: 20px;
            }
            
            .cta-button {
                padding: 12px 28px;
                font-size: 14px;
            }
            
            .preview-image {
                padding: 40px 20px;
                min-height: 250px;
            }
            
            .preview-text {
                font-size: 16px;
            }
            
            .features-section {
                padding: 40px 20px;
            }
            
            .features-badge {
                font-size: 12px;
                padding: 5px 16px;
            }
            
            .features-title {
                font-size: 24px;
                line-height: 32px;
            }
            
            .card {
                padding: 25px 20px;
            }
            
            .card-icon {
                width: 80px;
                height: 80px;
            }
            
            .offer-section {
                padding: 40px 20px;
            }
            
            .offer-left h2 {
                font-size: 24px;
                line-height: 34px;
            }
            
            .ai-section {
                padding: 40px 20px;
            }
            
            .testimonials-section {
                margin: 20px;
                padding: 25px 15px;
            }
            
            .testimonials-title {
                font-size: 20px;
                line-height: 28px;
            }
            
            .testimonial-card {
                min-width: 260px;
                max-width: 260px;
                padding: 18px;
            }
            
            .testimonial-card-text {
                font-size: 13px;
                min-height: 70px;
            }
            
            .slider-btn {
                width: 30px;
                height: 30px;
            }
            
            .testimonial-avatar {
                width: 45px;
                height: 45px;
            }
            
            .testimonial-name {
                font-size: 14px;
            }
            
            .testimonial-role {
                font-size: 11px;
            }
            
            .cta-section {
                margin: 20px;
                padding: 35px 20px;
            }
            
            .cta-title {
                font-size: 24px;
                line-height: 34px;
            }
            
            .cta-subtitle {
                font-size: 14px;
                line-height: 20px;
            }
            
            .cta-button-large {
                padding: 12px 35px;
                font-size: 16px;
            }
            
            .footer {
                padding: 40px 0 25px;
                margin-top: 40px;
            }
            
            .footer-container {
                padding: 0 20px;
            }
            
            .footer-logo {
                width: 100px;
                height: 100px;
            }
            
            .footer-logo-text {
                font-size: 12px;
            }
            
            .footer-nav {
                gap: 30px;
            }
            
            .footer-nav-column h4 {
                font-size: 16px;
            }
            
            .footer-nav-column a {
                font-size: 12px;
            }
            
            .footer-form input, 
            .footer-form textarea {
                padding: 10px 14px;
                font-size: 12px;
            }
            
            .footer-bottom {
                font-size: 10px;
            }
        }
        
        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }
        
        /* Better touch targets */
        button, a, .btn-login, .btn-signin, .cta-button, .cta-button-large {
            cursor: pointer;
            -webkit-tap-highlight-color: transparent;
        }
    </style>
</head>
<body>
    <div class="landing-container">
        <!-- Navbar Putih dengan Blur -->
        <div class="navbar">
            <div class="logo-nav"></div>
            <div class="nav-menu">
                <a href="#beranda">Beranda</a>
                <a href="#tentang">Tentang</a>
                <a href="#testimoni">Testimoni</a>
                <a href="#fitur">Fitur</a>
            </div>
            <div class="nav-buttons">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-signin">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn-login">Login</a>
                    <a href="{{ route('register') }}" class="btn-signin">Sign Up</a>
                @endauth
            </div>
        </div>
        
        <!-- Hero Section -->
        <div class="hero-section" id="beranda">
            <div class="hero-left">
                <h1 class="hero-title">Sering Bingung UANG Habis ke Mana?</h1>
                <p class="hero-subtitle">Solusi praktis untuk lacak setiap pengeluaran, lihat laporan otomatis, dan mulai kontrol keuanganmu dengan mudah.</p>
                @guest
                    <a href="{{ route('register') }}" class="cta-button">Mulai Sekarang →</a>
                @endguest
            </div>
            <div class="preview-image">
                <div class="preview-stack">
                    <!-- Mockup 3 (Bottom) -->
                    <div class="browser-mockup mockup-3">
                        <div class="browser-header">
                            <div class="dot-red"></div>
                            <div class="dot-yellow"></div>
                            <div class="dot-green"></div>
                            <div class="browser-address">beruang-expense-website/transactions</div>
                        </div>
                        <div class="browser-content">
                            <img src="{{ asset('images/p2.avif') }}" alt="Transaction Preview" class="dashboard-preview-img">
                        </div>
                    </div>
                    
                    <!-- Mockup 2 (Middle) -->
                    <div class="browser-mockup mockup-2">
                        <div class="browser-header">
                            <div class="dot-red"></div>
                            <div class="dot-yellow"></div>
                            <div class="dot-green"></div>
                            <div class="browser-address">beruang-expense-website/reports</div>
                        </div>
                        <div class="browser-content">
                            <img src="{{ asset('images/p3.avif') }}" alt="Report Preview" class="dashboard-preview-img">
                        </div>
                    </div>
                    
                    <!-- Mockup 1 (Top/Main) -->
                    <div class="browser-mockup mockup-1">
                        <div class="browser-header">
                            <div class="dot-red"></div>
                            <div class="dot-yellow"></div>
                            <div class="dot-green"></div>
                            <div class="browser-address">beruang-expense-website/dashboard</div>
                        </div>
                        <div class="browser-content">
                            <img src="{{ asset('images/P1.avif') }}" alt="Dashboard Preview" class="dashboard-preview-img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Features Section -->
        <div class="features-section" id="fitur">
            <div class="features-header">
                <div class="features-badge">Fitur Utama</div>
                <h2 class="features-title">Semua yang Kamu Butuhkan</h2>
                <p class="features-subtitle">Solusi lengkap untuk mencatat, menganalisis, dan mengontrol keuanganmu</p>
            </div>
            
            <div class="cards-row">
                <div class="card card-green">
                    <div class="card-icon" style="background-image: url('{{ asset("images/6-removebg-preview 1.png") }}')"></div>
                    <div class="card-badge card-badge-white">CATAT DENGAN MUDAH</div>
                    <h3 class="card-title">Pencatatan Transaksi Cepat</h3>
                    <p class="card-desc">Catat pemasukan dan pengeluaran hanya dalam beberapa detik tanpa ribet.</p>
                </div>
                
                <div class="card card-white">
                    <div class="card-icon" style="background-image: url('{{ asset("images/7-removebg-preview 1.png") }}')"></div>
                    <div class="card-badge">PANTAU KEUANGAN</div>
                    <h3 class="card-title">Monitoring Keuangan</h3>
                    <p class="card-desc">Lihat kondisi keuanganmu secara real-time tanpa perlu hitung manual.</p>
                </div>
                
                <div class="card card-green">
                    <div class="card-icon" style="background-image: url('{{ asset("images/2-removebg-preview 1.png") }}')"></div>
                    <div class="card-badge">ANALISIS CERDAS</div>
                    <h3 class="card-title">Laporan & Grafik</h3>
                    <p class="card-desc">Visualisasikan pengeluaranmu dengan grafik yang mudah dipahami.</p>
                </div>
            </div>
            
            <div class="cards-row">
                <div class="card card-white">
                    <div class="card-icon" style="background-image: url('{{ asset("images/5-removebg-preview 1.png") }}')"></div>
                    <div class="card-badge">KELOLA DATA</div>
                    <h3 class="card-title">Manajemen Kategori</h3>
                    <p class="card-desc">Kelompokkan transaksi agar lebih rapi dan mudah dianalisis.</p>
                </div>
                
                <div class="card card-green">
                    <div class="card-icon" style="background-image: url('{{ asset("images/8-removebg-preview 1.png") }}')"></div>
                    <div class="card-badge">KONTROL PENGELUARAN</div>
                    <h3 class="card-title">Budget Control</h3>
                    <p class="card-desc">Atur batas pengeluaran dan tetap kendalikan keuanganmu.</p>
                </div>
                
                <div class="card card-white">
                    <div class="card-icon" style="background-image: url('{{ asset("images/4-removebg-preview 1.png") }}')"></div>
                    <div class="card-badge">AKSES MUDAH</div>
                    <h3 class="card-title">Akses Kapan Saja</h3>
                    <p class="card-desc">Gunakan aplikasi ini di mana saja melalui web, tanpa install apa pun.</p>
                </div>
            </div>
        </div>
        
        <!-- Offer Section -->
        <div class="offer-section" id="tentang">
            <div class="offer-content">
                <div class="offer-left">
                    <h2>Bukan Sekadar Mencatat, Tapi Memahami UANG mu</h2>
                </div>
                <div class="offer-right">
                    <p>Temukan alasan di balik sisa saldomu. Biarkan AI menganalisis pola belanjamu agar kamu tahu kapan harus berhemat dan kapan bisa menikmati hasil jerih payahmu.</p>
                </div>
            </div>
        </div>
        
        <!-- AI Features Section -->
        <div class="ai-section">
            <div class="ai-cards">
                <div class="ai-card">
                    <div class="ai-badge">🤖 Scan Nota</div>
                    <h3 class="ai-title">Scan Nota Otomatis</h3>
                    <p class="ai-desc">Cukup upload foto struk belanja atau bukti transfermu. AI kami akan membaca data transaksi secara otomatis tanpa perlu input manual yang membosankan.</p>
                </div>
                
                <div class="ai-card">
                    <div class="ai-badge">🧠 AI Cerdas</div>
                    <h3 class="ai-title">Kategorisasi Otomatis</h3>
                    <p class="ai-desc">Bingung uang habis buat apa? Sistem AI akan memilah pengeluaranmu ke dalam kategori (makanan, transport, tagihan) secara akurat agar lebih rapi.</p>
                </div>
                
                <div class="ai-card">
                    <div class="ai-badge">📊 Real-time</div>
                    <h3 class="ai-title">Pantau Arus Kas</h3>
                    <p class="ai-desc">Pantau arus kas masuk dan keluar tanpa pusing. AI menghitung total pengeluaran dan sisa budget-mu secara instan.</p>
                </div>
            </div>
        </div>
        
        <!-- Testimonials Section with Slider -->
        <div class="testimonials-section" id="testimoni">
            <div class="testimonials-header">
                <div class="testimonials-badge">Testimoni Pengguna</div>
                <h2 class="testimonials-title">Apa Kata Mereka?</h2>
                <p class="testimonials-subtitle">Lebih dari 10.000+ pengguna percaya dengan berUANG</p>
            </div>
            
            <div class="testimonials-slider-container">
                <button class="slider-btn prev-btn" id="prevBtn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                
                <div class="testimonials-slider" id="testimonialSlider">
                    <!-- Testimonial 1 -->
                    <div class="testimonial-card">
                        <div class="testimonial-stars">
                            <span class="star-filled">★</span>
                            <span class="star-filled">★</span>
                            <span class="star-filled">★</span>
                            <span class="star-filled">★</span>
                            <span class="star-filled">★</span>
                        </div>
                        <p class="testimonial-card-text">"Aku jadi lebih sadar ke mana uangku pergi setiap bulan. berUANG benar-benar membantu mengontrol pengeluaran tanpa ribet."</p>
                        <div class="testimonial-profile">
                            <div class="testimonial-avatar"></div>
                            <div class="testimonial-info">
                                <div class="testimonial-name">Donald Terrifortino</div>
                                <div class="testimonial-role">Siswa / Pelajar</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Testimonial 2 -->
                    <div class="testimonial-card">
                        <div class="testimonial-stars">
                            <span class="star-filled">★</span>
                            <span class="star-filled">★</span>
                            <span class="star-filled">★</span>
                            <span class="star-filled">★</span>
                            <span class="star-filled">★</span>
                        </div>
                        <p class="testimonial-card-text">"Fitur AI-nya sangat membantu! Saya jadi tahu pola pengeluaran saya dan bisa menghemat lebih banyak setiap bulan."</p>
                        <div class="testimonial-profile">
                            <div class="testimonial-avatar avatar2"></div>
                            <div class="testimonial-info">
                                <div class="testimonial-name">Sarah Wijaya</div>
                                <div class="testimonial-role">Freelancer</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Testimonial 3 -->
                    <div class="testimonial-card">
                        <div class="testimonial-stars">
                            <span class="star-filled">★</span>
                            <span class="star-filled">★</span>
                            <span class="star-filled">★</span>
                            <span class="star-filled">★</span>
                            <span class="star-filled">★</span>
                        </div>
                        <p class="testimonial-card-text">"Aplikasi yang sangat membantu! Sekarang saya bisa mengatur keuangan dengan lebih baik. Dashboardnya informatif dan mudah dipahami."</p>
                        <div class="testimonial-profile">
                            <div class="testimonial-avatar avatar3"></div>
                            <div class="testimonial-info">
                                <div class="testimonial-name">Budi Santoso</div>
                                <div class="testimonial-role">Karyawan Swasta</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Testimonial 4 -->
                    <div class="testimonial-card">
                        <div class="testimonial-stars">
                            <span class="star-filled">★</span>
                            <span class="star-filled">★</span>
                            <span class="star-filled">★</span>
                            <span class="star-filled">★</span>
                            <span class="star-half">½</span>
                        </div>
                        <p class="testimonial-card-text">"Antarmuka yang sederhana dan mudah digunakan. Fitur kategorinya sangat membantu saya memantau pengeluaran bulanan."</p>
                        <div class="testimonial-profile">
                            <div class="testimonial-avatar avatar4"></div>
                            <div class="testimonial-info">
                                <div class="testimonial-name">Rina Maharani</div>
                                <div class="testimonial-role">Ibu Rumah Tangga</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Testimonial 5 -->
                    <div class="testimonial-card">
                        <div class="testimonial-stars">
                            <span class="star-filled">★</span>
                            <span class="star-filled">★</span>
                            <span class="star-filled">★</span>
                            <span class="star-filled">★</span>
                            <span class="star-filled">★</span>
                        </div>
                        <p class="testimonial-card-text">"berUANG membantu saya mencapai target tabungan! Dengan laporan yang jelas, saya bisa melihat progres keuangan saya."</p>
                        <div class="testimonial-profile">
                            <div class="testimonial-avatar avatar5"></div>
                            <div class="testimonial-info">
                                <div class="testimonial-name">Andi Pranoto</div>
                                <div class="testimonial-role">Pengusaha Muda</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button class="slider-btn next-btn" id="nextBtn">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
            
            <div class="slider-dots" id="sliderDots"></div>
        </div>
        
        <!-- CTA Section -->
        <div class="cta-section">
            <h2 class="cta-title">Siap Wujudkan Impian Finansialmu?</h2>
            <p class="cta-subtitle">Jangan biarkan uangmu habis tanpa jejak. Gabung bersama ribuan pengguna lainnya yang sudah berhasil menabung lebih banyak setiap bulan.</p>
            @guest
                <a href="{{ route('register') }}" class="cta-button-large">Coba Sekarang Gratis →</a>
            @else
                <a href="{{ route('dashboard') }}" class="cta-button-large">Go to Dashboard →</a>
            @endguest
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="footer" id="footer-contact">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-logo-section">
                    <div class="footer-logo"></div>
                    <p class="footer-logo-text">Sistem sederhana untuk mencatat pemasukan dan pengeluaran, membantu kamu mengelola keuangan dengan lebih baik.</p>
                </div>
                <div class="footer-nav">
                    <div class="footer-nav-column">
                        <h4>Navigasi</h4>
                        <a href="#beranda">Beranda</a>
                        <a href="#tentang">Tentang Kami</a>
                        <a href="#fitur">Fitur</a>
                        <a href="#testimoni">Testimoni</a>
                    </div>
                    <div class="footer-nav-column">
                        <h4>Cerita Kita</h4>
                        <a href="#">Tentang berUANG</a>
                        <a href="#">Apa kata orang?</a>
                        <a href="#">Tujuan Kami</a>
                        <a href="#">Ayo Gabung</a>
                    </div>
                </div>
                <div class="footer-form">
                    @if (session('success'))
                        <div style="color: #A3E635; margin-bottom: 10px;">{{ session('success') }}</div>
                    @endif
                    <form action="{{ route('contact.store') }}" method="POST" style="display: flex; flex-direction: column;">
                        @csrf
                        <input type="text" name="name" placeholder="Your Name" required>
                        <input type="email" name="email" placeholder="Email Address" required>
                        <textarea name="message" rows="2" placeholder="Message" required></textarea>
                        <button type="submit">Send Message</button>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                <div>Copyright © 2025 | berUANG Corp.</div>
                <div>Design & Developed by Donald Terrifortino</div>
            </div>
        </div>
    </footer>

    <script>
        // ========== NAVBAR SCROLL EFFECT - MUNCUL DAN HILANG ==========
        (function() {
            const navbar = document.querySelector('.navbar');
            let lastScrollTop = 0;
            let scrollTimeout;
            
            if (!navbar) return;
            
            // Tambahkan class awal
            navbar.classList.add('navbar-visible');
            
            window.addEventListener('scroll', function() {
                let currentScroll = window.pageYOffset || document.documentElement.scrollTop;
                
                // Deteksi arah scroll
                if (currentScroll > lastScrollTop && currentScroll > 100) {
                    // Scroll ke bawah - sembunyikan navbar
                    navbar.classList.remove('navbar-visible');
                    navbar.classList.add('navbar-hidden');
                } else {
                    // Scroll ke atas - tampilkan navbar
                    navbar.classList.remove('navbar-hidden');
                    navbar.classList.add('navbar-visible');
                }
                
                // Tambahan: navbar berubah style saat discroll melebihi 50px
                if (currentScroll > 50) {
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                }
                
                lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
                
                // Clear timeout sebelumnya
                if (scrollTimeout) {
                    clearTimeout(scrollTimeout);
                }
                
                // Sembunyikan navbar setelah 3 detik tidak discroll
                if (currentScroll > 100) {
                    scrollTimeout = setTimeout(function() {
                        if (window.pageYOffset > 100) {
                            navbar.classList.remove('navbar-visible');
                            navbar.classList.add('navbar-hidden');
                        }
                    }, 3000);
                }
            });
            
            // Tampilkan navbar saat mouse mendekati bagian atas layar
            document.addEventListener('mousemove', function(e) {
                if (e.clientY < 50) {
                    navbar.classList.remove('navbar-hidden');
                    navbar.classList.add('navbar-visible');
                    
                    if (scrollTimeout) {
                        clearTimeout(scrollTimeout);
                    }
                }
            });
            
            // Tampilkan navbar saat touch di bagian atas (untuk mobile)
            let touchStartY = 0;
            document.addEventListener('touchstart', function(e) {
                touchStartY = e.touches[0].clientY;
            });
            
            document.addEventListener('touchmove', function(e) {
                const touchEndY = e.touches[0].clientY;
                if (touchEndY - touchStartY > 10 && touchEndY < 100) {
                    navbar.classList.remove('navbar-hidden');
                    navbar.classList.add('navbar-visible');
                }
            });
        })();
        
        // ========== TESTIMONIAL SLIDER ==========
        (function() {
            const slider = document.getElementById('testimonialSlider');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const dotsContainer = document.getElementById('sliderDots');
            
            if (!slider) return;
            
            let currentIndex = 0;
            let cardWidth = 0;
            let visibleCards = 0;
            
            function updateSlider() {
                const firstCard = slider.querySelector('.testimonial-card');
                if (!firstCard) return;
                
                cardWidth = firstCard.offsetWidth + 25;
                const containerWidth = slider.parentElement.offsetWidth - 90;
                visibleCards = Math.floor(containerWidth / cardWidth) || 1;
                
                const scrollAmount = currentIndex * cardWidth;
                
                slider.scrollTo({
                    left: scrollAmount,
                    behavior: 'smooth'
                });
                
                updateDots();
            }
            
            function updateDots() {
                const cards = slider.querySelectorAll('.testimonial-card');
                const totalCards = cards.length;
                const totalDots = Math.ceil(totalCards / (visibleCards || 1));
                
                if (dotsContainer) {
                    dotsContainer.innerHTML = '';
                    for (let i = 0; i < totalDots; i++) {
                        const dot = document.createElement('div');
                        dot.classList.add('dot');
                        if (i === currentIndex) dot.classList.add('active');
                        dot.addEventListener('click', () => {
                            currentIndex = i;
                            updateSlider();
                        });
                        dotsContainer.appendChild(dot);
                    }
                }
            }
            
            function nextSlide() {
                const cards = slider.querySelectorAll('.testimonial-card');
                const totalCards = cards.length;
                const totalDots = Math.ceil(totalCards / (visibleCards || 1));
                
                if (currentIndex < totalDots - 1) {
                    currentIndex++;
                    updateSlider();
                } else {
                    currentIndex = 0;
                    updateSlider();
                }
            }
            
            function prevSlide() {
                if (currentIndex > 0) {
                    currentIndex--;
                    updateSlider();
                } else {
                    const cards = slider.querySelectorAll('.testimonial-card');
                    const totalCards = cards.length;
                    const totalDots = Math.ceil(totalCards / (visibleCards || 1));
                    currentIndex = totalDots - 1;
                    updateSlider();
                }
            }
            
            if (prevBtn && nextBtn) {
                prevBtn.addEventListener('click', prevSlide);
                nextBtn.addEventListener('click', nextSlide);
            }
            
            // Auto slide setiap 5 detik
            let autoSlide = setInterval(nextSlide, 5000);
            
            const sliderContainer = document.querySelector('.testimonials-slider-container');
            if (sliderContainer) {
                sliderContainer.addEventListener('mouseenter', () => {
                    clearInterval(autoSlide);
                });
                
                sliderContainer.addEventListener('mouseleave', () => {
                    autoSlide = setInterval(nextSlide, 5000);
                });
            }
            
            let resizeTimeout;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(() => {
                    updateSlider();
                }, 250);
            });
            
            setTimeout(updateSlider, 100);
            window.addEventListener('load', updateSlider);
        })();
    </script>
</body>
</html>