<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memory Gallery - 2024</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700&display=swap');
        
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
        }
        
        .gallery-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            height: 90vh;
            overflow-y: auto;
        }
        
        .gallery-card {
            width: 100%;
            margin-bottom: 25px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
            position: relative;
            background: white;
        }
        
        .gallery-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }
        
        .gallery-content {
            padding: 20px;
            position: relative;
        }
        
        .year-badge {
            position: absolute;
            top: -20px;
            right: 20px;
            background: #2c3e50;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 14px;
        }
        
        .title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #2c3e50;
        }
        
        .date {
            font-size: 14px;
            color: #7f8c8d;
            margin-bottom: 15px;
        }
        
        .logo-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #ecf0f1;
        }
        
        .logo {
            font-weight: 700;
            color: #2c3e50;
            font-size: 18px;
        }
        
        .institution {
            font-weight: 300;
            color: #7f8c8d;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="gallery-container">
        <!-- Card 1 -->
        <div class="gallery-card">
            <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Graduation Day" class="gallery-image">
            <div class="gallery-content">
                <div class="year-badge">2024</div>
                <h1 class="title">One day in photos</h1>
                <p class="date">23 Nov 2024</p>
                <div class="logo-container">
                    <span class="logo">V.I. PI</span>
                    <span class="institution">UAT</span>
                </div>
            </div>
        </div>
        
        <!-- Card 2 -->
        <div class="gallery-card">
            <img src="https://images.unsplash.com/photo-1541178735493-479c1a27ed24?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Campus Life" class="gallery-image">
            <div class="gallery-content">
                <div class="year-badge">2024</div>
                <h1 class="title">Campus memories</h1>
                <p class="date">15 Nov 2024</p>
                <div class="logo-container">
                    <span class="logo">V.I. PI</span>
                    <span class="institution">UAT</span>
                </div>
            </div>
        </div>
        
        <!-- Card 3 -->
        <div class="gallery-card">
            <img src="https://images.unsplash.com/photo-1492684223066-81342ee5ff30?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Graduation Party" class="gallery-image">
            <div class="gallery-content">
                <div class="year-badge">2024</div>
                <h1 class="title">Night of celebration</h1>
                <p class="date">24 Nov 2024</p>
                <div class="logo-container">
                    <span class="logo">V.I. PI</span>
                    <span class="institution">UAT</span>
                </div>
            </div>
        </div>
        
        <!-- Card 4 -->
        <div class="gallery-card">
            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Study Session" class="gallery-image">
            <div class="gallery-content">
                <div class="year-badge">2024</div>
                <h1 class="title">Final exams</h1>
                <p class="date">10 Nov 2024</p>
                <div class="logo-container">
                    <span class="logo">V.I. PI</span>
                    <span class="institution">UAT</span>
                </div>
            </div>
        </div>
        
        <!-- Card 5 -->
        <div class="gallery-card">
            <img src="https://images.unsplash.com/photo-1542626991-cbc4e32524cc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Friend Group" class="gallery-image">
            <div class="gallery-content">
                <div class="year-badge">2024</div>
                <h1 class="title">Our squad</h1>
                <p class="date">5 Nov 2024</p>
                <div class="logo-container">
                    <span class="logo">V.I. PI</span>
                    <span class="institution">UAT</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>