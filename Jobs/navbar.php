<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GecnoGuru</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-bg: #333;
            --text-color: white;
            --hover-color: #ddd;
            --border-color: #444;
            --dropdown-bg: #444;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        html {
            scroll-behavior: smooth;
        }
        
        body {
            padding-top: 60px; 
        }
        
        .navbar {
            background-color: var(--primary-bg);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1001;
        }
        
        .navbar .logo a {
            color: var(--text-color);
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .nav-menu {
            list-style: none;
            display: flex;
            gap: 20px;
        }
        
        .nav-menu li a {
            color: var(--text-color);
            text-decoration: none;
            transition: color 0.3s ease;
            padding: 10px 0;
            display: block;
        }
        
        .nav-menu li a:hover {
            color: var(--hover-color);
        }
        
        /* Dropdown styles */
        .dropdown {
            position: relative;
            display: inline-block;
        }
        
        .dropdown-toggle {
            color: var(--text-color);
            background: var(--primary-bg);
            border: none;
            cursor: pointer;
            padding: 10px 0;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .dropdown-toggle:hover {
            color: var(--hover-color);
        }
        
        .dropdown-menu {
            display: none;
            position: absolute;
            background-color: var(--dropdown-bg);
            min-width: 180px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            z-index: 1002;
            top: 100%;
            left: 0px;
            border-radius: 4px;
            padding: 5px 0;
        }
        
        .dropdown-menu a {
            color: var(--text-color);
            padding: 10px 15px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s;
        }
        
        .dropdown-menu a:hover {
            background-color: var(--primary-bg);
        }
        
        .dropdown:hover .dropdown-menu {
            display: block;
        }
        
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--text-color);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 5px;
        }
        
        /* Mobile styles */
        @media (max-width: 768px) {
            .nav-menu {
                position: fixed;
                top: 60px;
                left: 0;
                width: 100%;
                background-color: var(--primary-bg);
                flex-direction: column;
                align-items: center;
                padding: 20px 0;
                gap: 0;
                transform: translateY(-100%);
                opacity: 0;
                transition: transform 0.3s ease, opacity 0.3s ease;
                pointer-events: none;
            }
            
            .nav-menu.active {
                transform: translateY(0);
                opacity: 1;
                pointer-events: all;
            }
            
            .nav-menu li {
                width: 100%;
                text-align: center;
                border-bottom: 1px solid var(--border-color);
            }
            
            .nav-menu li:last-child {
                border-bottom: none;
            }
            
            .nav-menu li a {
                padding: 15px;
            }
            
            .menu-toggle {
                display: block;
            }
            
            /* Mobile dropdown styles */
            .dropdown {
                width: 100%;
            }
            
            .dropdown-toggle {
                width: 100%;
                padding: 15px;
                justify-content: center;
            }
            
            .dropdown-menu {
                position: static;
                width: 100%;
                box-shadow: none;
                display: none;
                padding: 0;
            }
            
            .dropdown-menu.show {
                display: block;
            }
            
            .dropdown-menu a {
                padding: 15px;
                background-color: var(--dropdown-bg);
                border-bottom: 1px solid var(--border-color);
            }
            
            .dropdown-menu a:last-child {
                border-bottom: none;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <a href="#">GecnoGuru</a>
        </div>
        <button class="menu-toggle" aria-label="Toggle navigation menu">
            <i class="fas fa-bars"></i>
        </button>
        <ul class="nav-menu">
            <li><a href="../index1.php">Main </a></li>
            <li><a href="index.php">Home</a></li>
            <li><a href="mailsend.php">Automail </a></li>
        </ul>
    </nav>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuToggle = document.querySelector('.menu-toggle');
            const navMenu = document.querySelector('.nav-menu');
            const icon = menuToggle.querySelector('i');
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            
            // Initialize menu state
            function initMenu() {
                if (window.innerWidth > 768) {
                    navMenu.classList.add('active');
                } else {
                    navMenu.classList.remove('active');
                }
            }
            
            // Toggle menu visibility
            function toggleMenu() {
                navMenu.classList.toggle('active');
                icon.classList.toggle('fa-bars');
                icon.classList.toggle('fa-times');
            }
            
            // Close menu when clicking outside or on a link (mobile only)
            function closeMenu(e) {
                if (window.innerWidth <= 768 && 
                    !navMenu.contains(e.target) && 
                    !menuToggle.contains(e.target)) {
                    navMenu.classList.remove('active');
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            }
            
            // Toggle dropdown on mobile
            function toggleDropdown(e) {
                if (window.innerWidth <= 768) {
                    e.preventDefault();
                    const dropdownMenu = this.nextElementSibling;
                    dropdownMenu.classList.toggle('show');
                }
            }
            
            // Event listeners
            menuToggle.addEventListener('click', toggleMenu);
            document.addEventListener('click', closeMenu);
            
            // Add event listeners to dropdown toggles
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', toggleDropdown);
            });
            
            // Close menu when clicking a nav link (mobile)
            document.querySelectorAll('.nav-menu a').forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 768) {
                        navMenu.classList.remove('active');
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                });
            });
            
            // Handle window resize
            window.addEventListener('resize', () => {
                initMenu();
                if (window.innerWidth > 768) {
                    navMenu.classList.add('active');
                    // Hide all mobile dropdowns
                    document.querySelectorAll('.dropdown-menu').forEach(menu => {
                        menu.classList.remove('show');
                    });
                } else if (navMenu.classList.contains('active')) {
                    navMenu.classList.remove('active');
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });
            
            // Initialize on load
            initMenu();
        });
    </script>