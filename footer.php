<!-- Footer Section -->
<footer class="footer-section">
    <div class="footer-container">
        <div class="footer-column">
            <h3>GecnoGuru</h3>
            <p>Creating professional, job-winning content since 2020. Our mission is to help job seekers stand out with polished resumes, compelling cover letters, impressive portfolio websites, effective interview preparation, and seamless job portal connections that accelerate your career journey.</p>
            <div class="social-icons">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        
        <div class="footer-column">
            <h3>Our Services</h3>
            <ul class="footer-links">
                <li><a href="Resume/index.php">Resume Builder</a></li>
                <li><a href="#.php">Cover Letter Builder</a></li>
                <li><a href="#.php">Portfolio Website Builder</a></li>
                <li><a href="#.php">Interview Preparation</a></li>
                <li><a href="#.php">Job Portal</a></li>
            </ul>
        </div>
        
        <div class="footer-column">
            <h3>Quick Links</h3>
            <ul class="footer-links">
                <li><a href="#">About Us</a></li>
                <li><a href="#">Pricing</a></li>
                <li><a href="#">FAQ</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms of Service</a></li>
            </ul>
        </div>
        
        <div class="footer-column">
            <h3>Contact Us</h3>
            <address class="contact-info">
                <p><i class="fas fa-map-marker-alt"></i> 123 Resume Street, Suite 456<br>San Francisco, CA 94103</p>
                <p><i class="fas fa-phone"></i> (555) 123-4567</p>
                <p><i class="fas fa-envelope"></i> <a href="mailto:support@gecnoguru.com">
                    support@gecnoguru.com</a></p>
                <p><i class="fas fa-clock"></i> Mon-Fri: 9 AM - 6 PM (PST)</p>
            </address>
        </div>
    </div>
    
    <div class="footer-bottom">
        <p>&copy; 2025 GecnoGuru. All rights reserved.</p>
    </div>
</footer>

<style>
    /* Footer Styles */
    .footer-section {
        background-color: #2c3e50;
        color: #ecf0f1;
        padding: 60px 0 20px;
        margin-top: 60px;
    }
    
    .footer-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .footer-column {
        flex: 1;
        min-width: 200px;
        margin-bottom: 30px;
        padding-right: 20px;
    }
    
    .footer-column h3 {
        font-size: 1.3rem;
        margin-bottom: 20px;
        position: relative;
        padding-bottom: 10px;
    }
    
    .footer-column h3::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 2px;
        background-color: #3498db;
    }
    
    .footer-column p {
        margin-bottom: 20px;
        line-height: 1.6;
        color: #bdc3c7;
    }
    
    .social-icons {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }
    
    .social-icons a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #34495e;
        color: #ecf0f1;
        transition: all 0.3s ease;
    }
    
    .social-icons a:hover {
        background-color: #3498db;
        transform: translateY(-3px);
    }
    
    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .footer-links li {
        margin-bottom: 12px;
    }
    
    .footer-links a {
        color: #bdc3c7;
        text-decoration: none;
        transition: color 0.3s ease;
        display: inline-block;
        position: relative;
    }
    
    .footer-links a::after {
        content: '';
        position: absolute;
        width: 0;
        height: 1px;
        bottom: -2px;
        left: 0;
        background-color: #3498db;
        transition: width 0.3s ease;
    }
    
    .footer-links a:hover {
        color: #3498db;
    }
    
    .footer-links a:hover::after {
        width: 100%;
    }
    
    .contact-info p {
        margin-bottom: 12px;
        display: flex;
        align-items: flex-start;
    }
    
    .contact-info i {
        margin-right: 10px;
        color: #3498db;
        min-width: 16px;
    }
    
    .contact-info a {
        color: #bdc3c7;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .contact-info a:hover {
        color: #3498db;
    }
    
    .footer-bottom {
        text-align: center;
        padding-top: 30px;
        margin-top: 20px;
        border-top: 1px solid #34495e;
        font-size: 0.9rem;
        color: #95a5a6;
    }
    
    @media (max-width: 768px) {
        .footer-container {
            flex-direction: column;
        }
        
        .footer-column {
            width: 100%;
            padding-right: 0;
        }
    }
</style>