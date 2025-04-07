<?php include ('navbar.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GecnoGuru - Your Complete Career Solution</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
                /* Global styles */
                :root {
            --primary-color: #2563eb;
            --secondary-color: #3b82f6;
            --accent-color: #60a5fa;
            --light-color: #f0f9ff;
            --dark-color: #1e3a8a;
            --text-dark: #1e293b;
            --text-light: #94a3b8;
            --success-color: #10b981;
            --warning-color: #f59e0b;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
        }
        
        .container {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .section-heading {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .section-heading h2 {
            font-size: 2.5rem;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }
        
        .section-heading p {
            font-size: 1.1rem;
            color: var(--text-light);
            max-width: 700px;
            margin: 0 auto;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 28px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            text-align: center;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }
        
        .btn-primary:hover {
            background-color: var(--dark-color);
            transform: translateY(-3px);
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
        }
        
        .btn-secondary {
            background-color: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }
        
        .btn-secondary:hover {
            background-color: var(--light-color);
            transform: translateY(-3px);
        }
        
        /* Hero section styles */
        .hero-section {
            background: linear-gradient(135deg, var(--dark-color), var(--primary-color));
            color: white;
            padding: 100px 0 80px;
            position: relative;
            overflow: hidden;
        }
        
        .hero-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
            z-index: 2;
        }
        
        .hero-content {
            max-width: 600px;
        }
        
        .hero-section h1 {
            font-size: 3.2rem;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            font-weight: 800;
        }
        
        .hero-section p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            line-height: 1.7;
        }
        
        .hero-image {
            width: 45%;
            position: relative;
        }
        
        .hero-image img {
            width: 100%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }
        
        .hero-badges {
            display: flex;
            gap: 20px;
            margin-top: 2.5rem;
        }
        
        .hero-badge {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            padding: 12px 20px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            font-weight: 500;
        }
        
        .hero-badge i {
            margin-right: 10px;
            font-size: 1.2rem;
        }
        
        /* Services section styles */
        .services-section {
            padding: 100px 0;
            background-color: white;
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }
        
        .service-card {
            background-color: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            padding: 40px 30px;
            border: 1px solid #f1f5f9;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-color: var(--accent-color);
        }
        
        .service-icon {
            margin-bottom: 25px;
            width: 70px;
            height: 70px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f0f9ff;
            color: var(--primary-color);
            font-size: 2rem;
        }
        
        .service-card h3 {
            margin-bottom: 15px;
            font-size: 1.5rem;
            color: var(--dark-color);
            font-weight: 700;
        }
        
        .service-card p {
            color: var(--text-light);
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 25px;
        }
        
        .service-link {
            display: flex;
            align-items: center;
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
        }
        
        .service-link i {
            margin-left: 5px;
            transition: transform 0.2s ease;
        }
        
        .service-link:hover i {
            transform: translateX(5px);
        }
        
        /* Features section styles */
        .features-section {
            padding: 100px 0;
            background-color: #f8fafc;
        }
        
        .features-container {
            display: flex;
            align-items: center;
            gap: 50px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .features-image {
            flex: 0 0 45%;
        }
        
        .features-image img {
            width: 100%;
            height: auto;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .features-content {
            flex: 0 0 50%;
        }
        
        .features-content h2 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: var(--dark-color);
        }
        
        .features-list {
            margin: 0;
            padding: 0;
            list-style: none;
        }
        
        .feature-item {
            margin-bottom: 25px;
            display: flex;
            align-items: flex-start;
        }
        
        .feature-icon {
            margin-right: 15px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--accent-color);
            color: white;
            font-size: 1.2rem;
            flex-shrink: 0;
        }
        
        .feature-content h3 {
            margin: 0 0 8px;
            font-size: 1.25rem;
            color: var(--dark-color);
        }
        
        .feature-content p {
            margin: 0;
            color: var(--text-light);
        }
        
        /* Templates section */
        .templates-section {
            padding: 100px 0;
            background-color: white;
            position: relative;
        }
        
        .templates-header {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .templates-header h2 {
            font-size: 2.5rem;
            color: var(--dark-color);
            margin-bottom: 15px;
        }
        
        .templates-header p {
            font-size: 1.1rem;
            color: var(--text-light);
            max-width: 700px;
            margin: 0 auto;
        }
        
        .templates-container {
            display: flex;
            overflow-x: auto;
            gap: 30px;
            padding: 20px 10px 40px;
            max-width: 1200px;
            margin: 0 auto;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            scroll-snap-type: x mandatory;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        
        .templates-container::-webkit-scrollbar {
            display: none;
        }
        
        .template-card {
            min-width: 280px;
            max-width: 280px;
            background-color: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            scroll-snap-align: start;
            border: 1px solid #f1f5f9;
        }
        
        .template-card:hover {
            transform: scale(1.05);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
            border-color: var(--accent-color);
        }
        
        .template-image {
            height: 380px;
            background-size: cover;
            background-position: top center;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .template-info {
            padding: 20px;
        }
        
        .template-info h4 {
            margin: 0 0 8px;
            color: var(--dark-color);
            font-size: 1.25rem;
        }
        
        .template-info p {
            margin: 0 0 15px;
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        .template-tags {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }
        
        .template-tag {
            padding: 4px 10px;
            background-color: #f1f5f9;
            border-radius: 50px;
            font-size: 0.75rem;
            color: var(--text-dark);
        }
        
        .use-template-btn {
            display: block;
            text-align: center;
            padding: 10px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        
        .use-template-btn:hover {
            background-color: var(--dark-color);
        }
        
        /* Scroll buttons */
        .scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: white;
            color: var(--primary-color);
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            z-index: 10;
            transition: all 0.3s ease;
        }

        .scroll-btn:hover {
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .scroll-left {
            left: 20px;
        }

        .scroll-right {
            right: 20px;
        }
        
        /* Scroll indicators */
        .scroll-indicators {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 30px;
        }
        
        .indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #e2e8f0;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .indicator.active {
            background-color: var(--primary-color);
            width: 30px;
            border-radius: 10px;
        }
        
        /* Statistics section */
        .stats-section {
            padding: 80px 0;
            background-color: var(--light-color);
        }
        
        .stats-container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .stat-box {
            flex: 1;
            min-width: 200px;
            text-align: center;
            padding: 30px 20px;
            background-color: white;
            border-radius: 16px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            color: var(--primary-color);
            margin-bottom: 10px;
            line-height: 1;
        }
        
        .stat-label {
            color: var(--text-light);
            font-size: 1.1rem;
        }
        
        /* Testimonials section */
        .testimonials-section {
            padding: 100px 0;
            background-color: white;
        }
        
        .testimonials-container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            padding: 0 50px;
        }
        
        .testimonial-slider {
            display: flex;
            overflow-x: hidden;
            scroll-behavior: smooth;
            scroll-snap-type: x mandatory;
        }
        
        .testimonial-slide {
            min-width: 100%;
            scroll-snap-align: start;
            display: flex;
            gap: 30px;
            padding: 20px 0;
        }
        
        .testimonial-card {
            flex: 1;
            background-color: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
            position: relative;
        }
        
        .testimonial-card:before {
            content: '"';
            position: absolute;
            top: 10px;
            left: 20px;
            font-size: 5rem;
            color: #f1f5f9;
            font-family: serif;
            line-height: 1;
            z-index: 0;
        }
        
        .testimonial-content {
            position: relative;
            z-index: 1;
        }
        
        .testimonial-text {
            font-size: 1.1rem;
            line-height: 1.7;
            color: var(--text-dark);
            margin-bottom: 20px;
        }
        
        .testimonial-author {
            display: flex;
            align-items: center;
        }
        
        .author-image {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-size: cover;
            margin-right: 15px;
            border: 3px solid #f1f5f9;
        }
        
        .author-info h4 {
            margin: 0 0 5px;
            color: var(--dark-color);
            font-size: 1.1rem;
        }
        
        .author-info p {
            margin: 0;
            color: var(--text-light);
            font-size: 0.9rem;
        }
        
        .testimonial-rating {
            margin-top: 10px;
            color: var(--warning-color);
            font-size: 1.2rem;
        }
        
        /* Pricing section */
        .pricing-section {
            padding: 100px 0;
            background-color: #f8fafc;
        }
        
        .pricing-toggle {
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 40px 0;
        }
        
        .toggle-label {
            font-size: 1.1rem;
            font-weight: 500;
            color: var(--text-light);
            cursor: pointer;
        }
        
        .toggle-label.active {
            color: var(--dark-color);
        }
        
        .toggle-switch {
            position: relative;
            width: 60px;
            height: 30px;
            margin: 0 15px;
            background-color: var(--primary-color);
            border-radius: 30px;
            cursor: pointer;
        }
        
        .toggle-switch:before {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            width: 24px;
            height: 24px;
            background-color: white;
            border-radius: 50%;
            transition: transform 0.3s ease;
        }
        
        .toggle-switch.annually:before {
            transform: translateX(30px);
        }
        
        .pricing-plans {
            display: flex;
            justify-content: center;
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            flex-wrap: wrap;
        }
        
        .pricing-card {
            flex: 1;
            min-width: 300px;
            max-width: 350px;
            background-color: white;
            border-radius: 16px;
            padding: 40px 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-color: var(--accent-color);
        }
        
        .pricing-card.popular {
            border-color: var(--primary-color);
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.1);
        }
        
        .popular-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: var(--primary-color);
            color: white;
            padding: 5px 15px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .plan-name {
            font-size: 1.5rem;
            color: var(--dark-color);
            margin-bottom: 15px;
            font-weight: 700;
        }
        
        .plan-price {
            font-size: 2.5rem;
            color: var(--dark-color);
            margin-bottom: 20px;
            font-weight: 800;
        }
        
        .price-duration {
            font-size: 1rem;
            color: var(--text-light);
            font-weight: normal;
        }
        
        .plan-description {
            color: var(--text-light);
            margin-bottom: 25px;
        }
        
        .plan-features {
            list-style: none;
            padding: 0;
            margin: 0 0 30px;
        }
        
        .plan-features li {
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
            color: var(--text-dark);
            display: flex;
            align-items: center;
        }
        
        .plan-features li i {
            color: var(--success-color);
            margin-right: 10px;
        }
        
        .plan-features li.unavailable {
            color: var(--text-light);
        }
        
        .plan-features li.unavailable i {
            color: #cbd5e0;
        }
        
        .choose-plan-btn {
            display: block;
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background-color: var(--primary-color);
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            text-decoration: none;
        }
        
        .choose-plan-btn:hover {
            background-color: var(--dark-color);
        }
        
        .pricing-card.popular .choose-plan-btn {
            background-color: var(--primary-color);
        }
        
        /* FAQ section */
        .faq-section {
            padding: 100px 0;
            background-color: white;
        }
        
        .faq-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .faq-item {
            margin-bottom: 20px;
            border: 1px solid #f1f5f9;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .faq-question {
            padding: 20px;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            font-weight: 600;
            color: var(--dark-color);
            transition: all 0.3s ease;
        }
        
        .faq-question:hover {
            background-color: #f8fafc;
        }
        
        .faq-question i {
            margin-left: 10px;
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }
        
        .faq-item.active .faq-question i {
            transform: rotate(180deg);
        }
        
        .faq-answer {
            padding: 0 20px;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
            color: var(--text-light);
        }
        
        .faq-item.active .faq-answer {
            padding: 0 20px 20px;
            max-height: 500px;
        }
        
        /* CTA section */
        .cta-section {
            padding: 100px 0;
            background: linear-gradient(135deg, var(--dark-color), var(--primary-color));
            color: white;
            text-align: center;
        }
        
        .cta-container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .cta-section h2 {
            font-size: 2.8rem;
            margin-bottom: 20px;
            font-weight: 800;
        }
        
        .cta-section p {
            font-size: 1.2rem;
            margin-bottom: 40px;
            opacity: 0.9;
        }
        
        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        
        /* Responsive styles */
        @media (max-width: 1200px) {
            .hero-container {
                flex-direction: column;
                text-align: center;
            }
            
            .hero-content {
                max-width: 100%;
                margin-bottom: 50px;
            }
            
            .hero-image {
                width: 80%;
            }
            
            .hero-badges {
                justify-content: center;
            }
            
            .features-container {
                flex-direction: column;
                padding: 0 20px;
            }
            
            .features-image {
                flex: 0 0 100%;
                margin-bottom: 50px;
            }
            
            .features-content {
                flex: 0 0 100%;
            }
            
            .testimonial-slide {
                flex-direction: column;
            }
        }
        
        /* Add this to your existing styles */
@media (max-width: 768px) {
    /* Fix navbar overlap */
    body {
        padding-top: 60px; /* Add space for fixed navbar */
    }
    
    /* Hero section adjustments */
    .hero-section {
        padding: 60px 0 40px;
    }
    
    .hero-section h1 {
        font-size: 2rem;
    }
    
    .hero-section p {
        font-size: 1rem;
    }
    
    .hero-badges {
        flex-direction: column;
        gap: 10px;
    }
    
    /* Services grid adjustment */
    .services-grid {
        grid-template-columns: 1fr;
        max-width: 100%;
    }
    
    /* Features section */
    .features-container {
        padding: 0 15px;
    }
    
    .features-image {
        margin-bottom: 30px;
    }
    
    /* Stats section */
    .stats-container {
        flex-direction: column;
        align-items: center;
    }
    
    .stat-box {
        width: 100%;
        max-width: 300px;
        margin-bottom: 15px;
    }
    
    /* CTA section */
    .cta-section h2 {
        font-size: 2rem;
    }
    
    .cta-section p {
        font-size: 1rem;
    }
    
    .cta-buttons {
        flex-direction: column;
        gap: 15px;
    }
    
    .btn {
        padding: 10px 20px;
    }
    
    /* Section padding reduction */
    .services-section,
    .features-section,
    .templates-section,
    .stats-section,
    .testimonials-section,
    .pricing-section,
    .faq-section,
    .cta-section {
        padding: 60px 0;
    }
    
    /* Section headings */
    .section-heading h2 {
        font-size: 1.8rem;
    }
    
    .section-heading p {
        font-size: 1rem;
    }
}

    @media (max-width: 480px) {
        /* Further adjustments for very small screens */
        .hero-section h1 {
            font-size: 1.8rem;
        }
        
        .hero-buttons {
            flex-direction: column;
            gap: 10px;
        }
        
        .btn {
            width: 100%;
        }
        
        .features-content h2 {
            font-size: 1.8rem;
        }
        
        .feature-item {
            flex-direction: column;
        }
        
        .feature-icon {
            margin-bottom: 10px;
        }
    }
    
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content">
                <h1>Your Complete Career Development Solution</h1>
                <p>Build stunning resumes, compelling cover letters, professional portfolios, and prepare for interviews—all in one powerful platform. Start your success journey today.</p>
                <div class="hero-buttons">
                    <a href="login.php" class="btn btn-primary">Get Started for Free</a>
                    <a href="login.php" class="btn btn-secondary">View Templates</a>
                </div>
                <div class="hero-badges">
                    <div class="hero-badge">
                        <i class="fas fa-users"></i>
                        <span>50,000+ Users</span>
                    </div>
                    <div class="hero-badge">
                        <i class="fas fa-star"></i>
                        <span>4.9/5 Rating</span>
                    </div>
                </div>
            </div>
            <div class="hero-image">
                <img src="Images/1.avif" alt="Resume Forge Platform Preview">
            </div>
        </div>
    </section>
    
    <!-- Services Section -->
    <section class="services-section" id="services-section">
        <div class="container">
            <div class="section-heading">
                <h2> Career Services</h2>
                <p>Everything you need for your professional journey in one integrated platform</p>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3>Resume Builder</h3>
                    <p>Create professional, ATS-friendly resumes that highlight your skills and experience. Choose from dozens of expert-designed templates.</p>
                    <a href="login.php" class="service-link">Create Resume <i class="fas fa-arrow-right"></i></a>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <h3>Cover Letter Builder</h3>
                    <p>Craft compelling cover letters that complement your resume and demonstrate your value to potential employers.</p>
                    <a href="login.php" class="service-link">Write Cover Letter <i class="fas fa-arrow-right"></i></a>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                    <h3>Portfolio Website</h3>
                    <p>Showcase your work with a personalized portfolio website. Perfect for creative professionals and freelancers.</p>
                    <a href="login.php" class="service-link">Build Portfolio <i class="fas fa-arrow-right"></i></a>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3>Interview Preparation</h3>
                    <p>Practice with AI-powered interview simulations and get real-time feedback to improve your interview skills.</p>
                    <a href="login.php" class="service-link">Prepare for Interviews <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <h3>Job Portal</h3>
                    <p>Discover and apply for relevant job openings. Leverage AI-powered tools to enhance your application and interview readiness.</p>
                    <a href="login.php" class="service-link">Apply for Job <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="features-container">
            <div class="features-image">
                <img src="Images/2.avif" alt="Resume Forge Features">
            </div>
            <div class="features-content">
                <h2>Why Choose GecnoGuru?</h2>
                <ul class="features-list">
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="feature-content">
                            <h3>ATS-Optimized Templates</h3>
                            <p>Our resume templates are designed to pass through Applicant Tracking Systems with ease, ensuring your application gets seen.</p>
                        </div>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="feature-content">
                            <h3>AI-Powered Content Suggestions</h3>
                            <p>Get smart recommendations for skills, achievements, and phrases that make your resume stand out.</p>
                        </div>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="feature-content">
                            <h3>All-in-One Platform</h3>
                            <p>Manage your entire job search process from a single dashboard with integrated tools for every step.</p>
                        </div>
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="feature-content">
                            <h3>Expert Career Resources</h3>
                            <p>Access guides, tips, and best practices from industry professionals to improve your job hunting strategy.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    
    <!-- Statistics Section -->
    <section class="stats-section">
        <div class="stats-container">
            <div class="stat-box">
                <div class="stat-number">50,000+</div>
                <div class="stat-label">Active Users</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">87%</div>
                <div class="stat-label">Interview Success Rate</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">150+</div>
                <div class="stat-label">Resume Templates</div>
            </div>
            <div class="stat-box">
                <div class="stat-number">4.9/5</div>
                <div class="stat-label">Average Rating</div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-container">
            <h2>Ready to Launch Your Career?</h2>
            <p>Create your professional resume in minutes and take the first step toward your dream job.</p>
            <div class="cta-buttons">
                <a href="login.php" class="btn btn-primary">Get Started Now</a>
                <a href="#features" class="btn btn-secondary">Learn More</a>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer id="footer">
        <?php include('footer.php'); ?>
    </footer>

    <!-- JavaScript for template slider -->
    <script>
        // Template slider functionality
        const templatesContainer = document.querySelector('.templates-container');
        const scrollLeftBtn = document.querySelector('.scroll-left');
        const scrollRightBtn = document.querySelector('.scroll-right');
        const indicators = document.querySelectorAll('.indicator');
        let currentIndex = 0;
        
        scrollLeftBtn.addEventListener('click', () => {
            currentIndex = Math.max(currentIndex - 1, 0);
            updateSlider();
        });
        
        scrollRightBtn.addEventListener('click', () => {
            currentIndex = Math.min(currentIndex + 1, 2);
            updateSlider();
        });
        
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                currentIndex = index;
                updateSlider();
            });
        });
        
        function updateSlider() {
            const scrollAmount = templatesContainer.clientWidth * currentIndex;
            templatesContainer.scrollTo({
                left: scrollAmount,
                behavior: 'smooth'
            });
            
            indicators.forEach((indicator, index) => {
                if (index === currentIndex) {
                    indicator.classList.add('active');
                } else {
                    indicator.classList.remove('active');
                }
            });
        }
    </script>
</body>
</html>