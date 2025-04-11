<?php

session_start();

$email = $_SESSION['email'];
if (!isset($_SESSION['email'])) {
    echo '<script>alert("You are not able to access this page. Please Login!!"); window.location.href="../login.php";</script>';
    exit(); // Stop script execution
}
?>

<?php include 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobConnect Pro | Find Your Dream Job</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        /* [Previous CSS remains the same, just update color scheme if needed] */
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --primary-light: #4cc9f0;
            --secondary: #7209b7;
            --accent: #f72585;
            --dark: #212529;
            --gray-dark: #495057;
            --gray: #6c757d;
            --gray-light: #e9ecef;
            --light: #f8f9fa;
            --white: #ffffff;
            --success: #4cc9f0;
            --warning: #f8961e;
            --danger: #ef233c;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.1);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            color: var(--dark);
            background-color: var(--light);
            overflow-x: hidden;
        }

        h1, h2, h3, h4 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            line-height: 1.2;
        }

        .container {
            width: 100%;
            max-width: 1500px;
            margin: 0 auto;
            padding: 0 20px;
        }

        section {
            padding: 100px 0;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .section-header h2 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: var(--dark);
            position: relative;
            display: inline-block;
        }

        .section-header h2:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            border-radius: 2px;
        }

        .section-header p {
            font-size: 1.1rem;
            color: var(--gray);
            margin-top: 20px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 28px;
            border-radius: var(--radius-xl);
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            text-align: center;
            cursor: pointer;
            border: none;
            font-size: 1rem;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            box-shadow: var(--shadow-md);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary {
            background-color: var(--white);
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-secondary:hover {
            background-color: var(--primary);
            color: var(--white);
            transform: translateY(-3px);
        }

        .btn-accent {
            background: linear-gradient(135deg, var(--accent), #f72585cc);
            color: var(--white);
            box-shadow: var(--shadow-md);
        }

        .btn-accent:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, #3a0ca3, #4361ee);
            color: var(--white);
            padding: 120px 0 80px;
            position: relative;
            overflow: hidden;
        }

        .hero-section:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80') center/cover no-repeat;
            opacity: 0.15;
            z-index: 1;
        }

        .hero-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            z-index: 2;
        }

        .hero-content {
            flex: 1;
            max-width: 600px;
        }

        .hero-section h1 {
            font-size: 3.5rem;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero-section p {
            font-size: 1.25rem;
            margin-bottom: 30px;
            opacity: 0.9;
            line-height: 1.7;
        }

        .hero-image {
            flex: 1;
            position: relative;
            text-align: center;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }

        .hero-image img {
            max-width: 100%;
            height: auto;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-lg);
        }

        .hero-buttons {
            display: flex;
            gap: 20px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .hero-stats {
            display: flex;
            gap: 30px;
            margin-top: 40px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background-color: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .stat-text span {
            display: block;
            font-weight: 700;
            font-size: 1.5rem;
        }

        .stat-text small {
            font-size: 0.9rem;
            opacity: 0.8;
        }

        /* Features Section */
        .features-section {
            background-color: var(--white);
            position: relative;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background-color: var(--white);
            border-radius: var(--radius-md);
            padding: 40px 30px;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            border: 1px solid var(--gray-light);
            text-align: center;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 25px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--white);
            box-shadow: var(--shadow-md);
        }

        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--dark);
        }

        .feature-card p {
            color: var(--gray);
            font-size: 1rem;
            line-height: 1.6;
        }

        /* Templates Section */
        .templates-section {
            background-color: var(--light);
            position: relative;
        }

        .templates-container:hover .template-card {
            transform: none !important;
        }

        .templates-container {
            display: flex;
            overflow-x: auto;
            gap: 30px;
            padding: 20px 10px 40px;
            scroll-behavior: smooth;
            transition: scroll-left 0.3s ease;
            scroll-snap-type: x mandatory;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .templates-container::-webkit-scrollbar {
            display: none;
        }

        .template-card {
            min-width: 300px;
            background-color: var(--white);
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            scroll-snap-align: start;
            border: 1px solid var(--gray-light);
            position: relative;
        }

        .template-card:hover {
            transform: scale(1.03);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary);
        }

        .template-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: var(--accent);
            color: var(--white);
            padding: 5px 15px;
            border-radius: var(--radius-xl);
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 2;
        }

        .template-image {
            height: 400px;
            background-size: cover;
            background-position: top center;
            background-repeat: no-repeat;
            position: relative;
        }

        .template-image:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
            opacity: 0;
            transition: var(--transition);
        }

        .template-card:hover .template-image:after {
            opacity: 1;
        }

        .template-info {
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        .template-info h4 {
            margin: 0 0 5px;
            color: var(--dark);
            font-size: 1.3rem;
        }

        .template-info p {
            margin: 0 0 15px;
            color: var(--gray);
            font-size: 0.95rem;
        }

        .template-tags {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .template-tag {
            padding: 4px 12px;
            background-color: var(--gray-light);
            border-radius: var(--radius-xl);
            font-size: 0.75rem;
            color: var(--dark);
        }

        .use-template-btn {
            display: block;
            text-align: center;
            padding: 12px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            border-radius: var(--radius-sm);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            margin-top: 10px;
        }

        .use-template-btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        /* Scroll buttons */
        .scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: var(--white);
            color: var(--primary);
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-md);
            z-index: 10;
            transition: var(--transition);
        }

        .scroll-btn:hover {
            background-color: var(--primary);
            color: var(--white);
            box-shadow: var(--shadow-lg);
        }

        .scroll-left {
            left: 20px;
        }

        .scroll-right {
            right: 20px;
        }

        /* Testimonials Section */
        .testimonials-section {
            background-color: var(--white);
        }

        .testimonials-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .testimonial-card {
            background-color: var(--white);
            border-radius: var(--radius-md);
            padding: 40px 30px;
            box-shadow: var(--shadow-sm);
            position: relative;
            border: 1px solid var(--gray-light);
            transition: var(--transition);
        }

        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .testimonial-card:before {
            content: '"';
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 5rem;
            color: var(--gray-light);
            font-family: serif;
            line-height: 1;
            z-index: 0;
            opacity: 0.5;
        }

        .testimonial-content {
            position: relative;
            z-index: 1;
        }

        .testimonial-rating {
            color: var(--warning);
            font-size: 1.1rem;
            margin-bottom: 15px;
        }

        .testimonial-text {
            font-size: 1.1rem;
            line-height: 1.7;
            color: var(--dark);
            margin-bottom: 25px;
            font-style: italic;
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
            background-position: center;
            margin-right: 15px;
            border: 3px solid var(--gray-light);
        }

        .author-info h4 {
            margin: 0 0 5px;
            color: var(--dark);
            font-size: 1.1rem;
        }

        .author-info p {
            margin: 0;
            color: var(--gray);
            font-size: 0.9rem;
        }

        /* Pricing Section */
        .pricing-section {
            background-color: var(--light);
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
            color: var(--gray);
            cursor: pointer;
        }

        .toggle-label.active {
            color: var(--dark);
            font-weight: 600;
        }

        .toggle-switch {
            position: relative;
            width: 60px;
            height: 30px;
            margin: 0 15px;
            background-color: var(--primary);
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
            background-color: var(--white);
            border-radius: 50%;
            transition: transform 0.3s ease;
        }

        .toggle-switch.annually:before {
            transform: translateX(30px);
        }

        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .pricing-card {
            background-color: var(--white);
            border-radius: var(--radius-md);
            padding: 40px 30px;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            border: 1px solid var(--gray-light);
            position: relative;
        }

        .pricing-card.popular {
            border-color: var(--primary);
            box-shadow: 0 10px 30px rgba(67, 97, 238, 0.1);
        }

        .popular-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: var(--accent);
            color: var(--white);
            padding: 5px 15px;
            border-radius: var(--radius-xl);
            font-size: 0.8rem;
            font-weight: 600;
        }

        .pricing-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .plan-name {
            font-size: 1.5rem;
            color: var(--dark);
            margin-bottom: 15px;
        }

        .plan-price {
            font-size: 2.5rem;
            color: var(--dark);
            margin-bottom: 5px;
            font-weight: 700;
        }

        .price-duration {
            font-size: 1rem;
            color: var(--gray);
            margin-bottom: 20px;
        }

        .plan-description {
            color: var(--gray);
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--gray-light);
        }

        .plan-features {
            list-style: none;
            padding: 0;
            margin: 0 0 30px;
        }

        .plan-features li {
            padding: 10px 0;
            border-bottom: 1px solid var(--gray-light);
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .plan-features li i {
            color: var(--success);
        }

        .plan-features li.unavailable {
            color: var(--gray);
        }

        .plan-features li.unavailable i {
            color: var(--gray-light);
        }

        .choose-plan-btn {
            display: block;
            width: 100%;
            padding: 12px;
            border-radius: var(--radius-sm);
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
            text-decoration: none;
            border: none;
        }

        .choose-plan-btn:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .pricing-card.popular .choose-plan-btn {
            background: linear-gradient(135deg, var(--accent), #f72585cc);
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #3a0ca3, #4361ee);
            color: var(--white);
            text-align: center;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .cta-section:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1600&q=80') center/cover no-repeat;
            opacity: 0.15;
            z-index: 1;
        }

        .cta-container {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .cta-section h2 {
            font-size: 2.8rem;
            margin-bottom: 20px;
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

        /* Responsive Styles */
        @media (max-width: 1024px) {
            .hero-container {
                flex-direction: column;
                text-align: center;
            }

            .hero-content {
                max-width: 100%;
                margin-bottom: 50px;
            }

            .hero-buttons {
                justify-content: center;
            }

            .hero-stats {
                justify-content: center;
            }

            section {
                padding: 80px 0;
            }
        }

        @media (max-width: 768px) {
            .section-header h2 {
                font-size: 2rem;
            }

            .hero-section h1 {
                font-size: 2.8rem;
            }

            .hero-section p {
                font-size: 1.1rem;
            }

            .cta-section h2 {
                font-size: 2.2rem;
            }

            .cta-section p {
                font-size: 1rem;
            }

            .scroll-btn {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .section-header h2 {
                font-size: 1.8rem;
            }

            .hero-section h1 {
                font-size: 2.2rem;
            }

            .hero-buttons {
                flex-direction: column;
                gap: 15px;
            }

            .hero-stats {
                flex-direction: column;
                gap: 20px;
            }

            .cta-buttons {
                flex-direction: column;
                gap: 15px;
            }

            .btn {
                width: 100%;
            }

            section {
                padding: 60px 0;
            }
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container hero-container">
            <div class="hero-content">
                <h1>Find Your Dream Job Today</h1>
                <p>Connect with top employers and discover thousands of job opportunities across all industries. Our platform makes job searching simple and effective.</p>
                <div class="hero-buttons">
                    <a href="jobs.php" class="btn btn-primary">
                        <i class="fas fa-search"></i> Browse Jobs
                    </a>
                    <a href="#categories" class="btn btn-secondary">
                        <i class="fas fa-list"></i> Job Categories
                    </a>
                </div>
                <div class="hero-stats">
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="stat-text">
                            <span>10,000+</span>
                            <small>Jobs Available</small>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="stat-text">
                            <span>500+</span>
                            <small>Companies Hiring</small>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="stat-text">
                            <span>85%</span>
                            <small>Success Rate</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-image">
                <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80" alt="Happy professional at work">
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="container">
            <div class="section-header">
                <h2>Why Choose JobConnect Pro?</h2>
                <p>We provide everything you need to find and land your perfect job</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-search-plus"></i>
                    </div>
                    <h3>Smart Job Matching</h3>
                    <p>Our AI matches you with jobs that fit your skills, experience, and preferences perfectly.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h3>Instant Alerts</h3>
                    <p>Get notified immediately when new jobs matching your criteria are posted.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h3>Privacy Control</h3>
                    <p>Control who sees your profile and application history with detailed privacy settings.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Job Categories Section -->
    <section class="templates-section" id="categories">
        <div class="container">
            <div class="section-header">
                <h2>Popular Job Categories</h2>
                <p>Browse jobs by industry and find your perfect match</p>
            </div>
            
            <button class="scroll-btn scroll-left"><i class="fas fa-chevron-left"></i></button>
            <button class="scroll-btn scroll-right"><i class="fas fa-chevron-right"></i></button>
            
            <div class="templates-container">
                <div class="template-card">
                    <div class="template-badge">Most Popular</div>
                    <div class="template-image" style="background-image: url('https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80');"></div>
                    <div class="template-info">
                        <h4>Technology</h4>
                        <p>Software development, IT, cybersecurity and more</p>
                        <div class="template-tags">
                            <span class="template-tag">Developer</span>
                            <span class="template-tag">Engineer</span>
                        </div>
                        <a href="jobs.php?category=technology" class="use-template-btn">View Jobs</a>
                    </div>
                </div>
                
                <div class="template-card">
                    <div class="template-image" style="background-image: url('https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80');"></div>
                    <div class="template-info">
                        <h4>Finance</h4>
                        <p>Banking, accounting, investment and financial services</p>
                        <div class="template-tags">
                            <span class="template-tag">Analyst</span>
                            <span class="template-tag">Accountant</span>
                        </div>
                        <a href="jobs.php?category=finance" class="use-template-btn">View Jobs</a>
                    </div>
                </div>
                
                <div class="template-card">
                    <div class="template-badge">New</div>
                    <div class="template-image" style="background-image: url('https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80');"></div>
                    <div class="template-info">
                        <h4>Healthcare</h4>
                        <p>Medical, nursing, pharmaceuticals and health services</p>
                        <div class="template-tags">
                            <span class="template-tag">Doctor</span>
                            <span class="template-tag">Nurse</span>
                        </div>
                        <a href="jobs.php?category=healthcare" class="use-template-btn">View Jobs</a>
                    </div>
                </div>
                
                <div class="template-card">
                    <div class="template-image" style="background-image: url('https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80');"></div>
                    <div class="template-info">
                        <h4>Marketing</h4>
                        <p>Digital marketing, advertising, PR and communications</p>
                        <div class="template-tags">
                            <span class="template-tag">Manager</span>
                            <span class="template-tag">Specialist</span>
                        </div>
                        <a href="jobs.php?category=marketing" class="use-template-btn">View Jobs</a>
                    </div>
                </div>
                
                <div class="template-card">
                    <div class="template-image" style="background-image: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80');"></div>
                    <div class="template-info">
                        <h4>Education</h4>
                        <p>Teaching, administration, and academic positions</p>
                        <div class="template-tags">
                            <span class="template-tag">Teacher</span>
                            <span class="template-tag">Professor</span>
                        </div>
                        <a href="jobs.php?category=education" class="use-template-btn">View Jobs</a>
                    </div>
                </div>

                <div class="template-card">
                    <div class="template-image" style="background-image: url('https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80');"></div>
                    <div class="template-info">
                        <h4>Engineering</h4>
                        <p>Civil, mechanical, electrical and other engineering fields</p>
                        <div class="template-tags">
                            <span class="template-tag">Civil</span>
                            <span class="template-tag">Mechanical</span>
                        </div>
                        <a href="jobs.php?category=engineering" class="use-template-btn">View Jobs</a>
                    </div>
                </div>

                <div class="template-card">
                    <div class="template-image" style="background-image: url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80');"></div>
                    <div class="template-info">
                        <h4>Design</h4>
                        <p>Graphic design, UX/UI, product design and creative roles</p>
                        <div class="template-tags">
                            <span class="template-tag">Graphic</span>
                            <span class="template-tag">UX/UI</span>
                        </div>
                        <a href="jobs.php?category=design" class="use-template-btn">View Jobs</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section">
        <div class="container">
            <div class="section-header">
                <h2>Success Stories</h2>
                <p>Don't just take our word for it - hear from people who found jobs through our platform</p>
            </div>
            
            <div class="testimonials-container">
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">"I found my dream job within two weeks of using JobConnect Pro. The job matching system is incredibly accurate and saved me hours of searching."</p>
                        <div class="testimonial-author">
                            <div class="author-image" style="background-image: url('https://randomuser.me/api/portraits/women/44.jpg');"></div>
                            <div class="author-info">
                                <h4>Sarah Johnson</h4>
                                <p>Product Manager at TechCorp</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">"After months of unsuccessful job hunting, JobConnect Pro connected me with the perfect opportunity. I start my new position next week!"</p>
                        <div class="testimonial-author">
                            <div class="author-image" style="background-image: url('https://randomuser.me/api/portraits/men/32.jpg');"></div>
                            <div class="author-info">
                                <h4>Michael Rodriguez</h4>
                                <p>Senior Developer at InnovateSoft</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="testimonial-card">
                    <div class="testimonial-content">
                        <div class="testimonial-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="testimonial-text">"The instant job alerts helped me apply early to competitive positions. I landed an interview within 24 hours of applying!"</p>
                        <div class="testimonial-author">
                            <div class="author-image" style="background-image: url('https://randomuser.me/api/portraits/women/68.jpg');"></div>
                            <div class="author-info">
                                <h4>Emily Chen</h4>
                                <p>Marketing Director at BrandVision</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container cta-container">
            <h2>Ready to Find Your Dream Job?</h2>
            <p>Join thousands of professionals who found their perfect career match with JobConnect Pro</p>
            <div class="cta-buttons">
                <a href="jobs.php" class="btn btn-accent">
                    <i class="fas fa-search"></i> Browse Jobs
                </a>
                <a href="register.php" class="btn btn-secondary">
                    <i class="fas fa-user-plus"></i> Create Account
                </a>
            </div>
        </div>
    </section>

    <script>
        // [Previous JavaScript remains the same, just update variable names if needed]
        document.addEventListener('DOMContentLoaded', function() {
            // Job categories slider elements
            const categoriesContainer = document.querySelector('.templates-container');
            const scrollLeftBtn = document.querySelector('.scroll-left');
            const scrollRightBtn = document.querySelector('.scroll-right');
            
            // Auto-scroll settings
            let autoScrollInterval;
            const scrollSpeed = 1;
            const scrollDelay = 30;
            const scrollResetDelay = 3000;

            // Initialize categories slider
            function initCategoriesSlider() {
                updateScrollButtons();
                startAutoScroll();
                setupEventListeners();
            }

            // Auto-scroll functions
            function startAutoScroll() {
                stopAutoScroll();
                
                autoScrollInterval = setInterval(() => {
                    const maxScroll = categoriesContainer.scrollWidth - categoriesContainer.clientWidth;
                    
                    if (categoriesContainer.scrollLeft >= maxScroll - 10) {
                        categoriesContainer.scrollTo({
                            left: 0,
                            behavior: 'smooth'
                        });
                    } else {
                        categoriesContainer.scrollBy({
                            left: scrollSpeed,
                            behavior: 'smooth'
                        });
                    }
                    
                    updateScrollButtons();
                }, scrollDelay);
            }

            function stopAutoScroll() {
                if (autoScrollInterval) {
                    clearInterval(autoScrollInterval);
                    autoScrollInterval = null;
                }
            }

            function updateScrollButtons() {
                const scrollLeft = categoriesContainer.scrollLeft;
                const maxScroll = categoriesContainer.scrollWidth - categoriesContainer.clientWidth;
                
                scrollLeftBtn.style.display = scrollLeft > 0 ? 'flex' : 'none';
                scrollRightBtn.style.display = scrollLeft < maxScroll - 10 ? 'flex' : 'none';
            }

            // Event listeners setup
            function setupEventListeners() {
                scrollLeftBtn.addEventListener('click', () => {
                    categoriesContainer.scrollBy({
                        left: -300,
                        behavior: 'smooth'
                    });
                });
                
                scrollRightBtn.addEventListener('click', () => {
                    categoriesContainer.scrollBy({
                        left: 300,
                        behavior: 'smooth'
                    });
                });
                
                categoriesContainer.addEventListener('mouseenter', stopAutoScroll);
                categoriesContainer.addEventListener('mouseleave', () => {
                    if (!autoScrollInterval) {
                        startAutoScroll();
                    }
                });
                
                categoriesContainer.addEventListener('scroll', () => {
                    stopAutoScroll();
                    updateScrollButtons();
                    
                    setTimeout(() => {
                        if (!categoriesContainer.matches(':hover')) {
                            startAutoScroll();
                        }
                    }, scrollResetDelay);
                });
            }

            // Initialize the categories slider
            initCategoriesSlider();
        });
    </script>

    <?php
    include ('footer.php');
    ?>