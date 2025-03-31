<?php
session_start();

// Function to get user details from database
function getUserDetails($user_email) {
    $conn = new mysqli('localhost', 'root', '', 'resume_builder');
    
    // Prepare arrays to store different sections
    $user_details = array(
        'personal' => null,
        'education' => array(),
        'experience' => array(),
        'projects' => array(),
        'hobbies' => array(),
        'skills' => array(),
        'achievement' => array()
    );

    // Fetch personal details
    $personal_query = $conn->prepare("SELECT * FROM personal_details WHERE email = ?");
    $personal_query->bind_param("s", $user_email);
    $personal_query->execute();
    $user_details['personal'] = $personal_query->get_result()->fetch_assoc();

    // Fetch education details
    $education_query = $conn->prepare("SELECT * FROM education_details WHERE user = ? ORDER BY year_of_passout DESC");
    $education_query->bind_param("s", $user_email);
    $education_query->execute();
    $education_result = $education_query->get_result();
    while ($edu = $education_result->fetch_assoc()) {
        $user_details['education'][] = $edu;
    }

    // Fetch achievements
    $achievements_query = $conn->prepare("SELECT * FROM user_achievements WHERE user = ? ORDER BY achievement_date DESC");
    $achievements_query->bind_param("s", $user_email);
    $achievements_query->execute();
    $achievements_result = $achievements_query->get_result();
    while ($achievement = $achievements_result->fetch_assoc()) {
        $user_details['achievement'][] = $achievement;
    }

    // Fetch experience details
    $experience_query = $conn->prepare("SELECT * FROM experience_details WHERE user = ? ORDER BY start_date DESC");
    $experience_query->bind_param("s", $user_email);
    $experience_query->execute();
    $experience_result = $experience_query->get_result();
    while ($exp = $experience_result->fetch_assoc()) {
        $user_details['experience'][] = $exp;
    }

    // Fetch projects
    $projects_query = $conn->prepare("SELECT * FROM projects_details WHERE user = ? ORDER BY start_date DESC");
    $projects_query->bind_param("s", $user_email);
    $projects_query->execute();
    $projects_result = $projects_query->get_result();
    while ($proj = $projects_result->fetch_assoc()) {
        $user_details['projects'][] = $proj;
    }

    // Fetch skills
    $skills_query = $conn->prepare("SELECT * FROM user_skills WHERE user = ? ORDER BY id");
    $skills_query->bind_param("s", $user_email);
    $skills_query->execute();
    $skills_result = $skills_query->get_result();
    while ($skill = $skills_result->fetch_assoc()) {
        $user_details['skills'][] = $skill;
    }

    // Fetch hobbies
    $hobbies_query = $conn->prepare("SELECT * FROM hobbies_details WHERE user = ?");
    $hobbies_query->bind_param("s", $user_email);
    $hobbies_query->execute();
    $hobbies_result = $hobbies_query->get_result();
    while ($hobby = $hobbies_result->fetch_assoc()) {
        $user_details['hobbies'][] = $hobby;
    }

    $conn->close();
    return $user_details;
}

// Resume Template 1: Classic Professional
function renderClassicProfessionalResume($user_details) {
    ob_start(); ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Professional Resume</title>
        <style>
            body { 
                font-family: Arial, sans-serif; 
                line-height: 1.6; 
                max-width: 800px; 
                margin: 0 auto; 
                padding: 20px;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            @page {
                size: A4;
                margin: 10mm;
            }
            .section { margin-bottom: 20px; }
            .section-title { 
                border-bottom: 2px solid #333; 
                padding-bottom: 5px;
                color: #2c3e50;
            }
            .job-title, .education-details { margin-bottom: 10px; }
            .skills-list { display: flex; flex-wrap: wrap; gap: 10px; }
            .skill-item { 
                background: #f0f0f0; 
                padding: 5px 10px; 
                border-radius: 3px;
                font-size: 14px;
            }
            .download-btn {
                display: block;
                text-align: center;
                margin: 20px auto;
                padding: 10px 20px;
                background: #2c3e50;
                color: white;
                text-decoration: none;
                border-radius: 4px;
                width: 200px;
            }
            @media print {
                .download-btn {
                    display: none;
                }
                body {
                    padding: 0;
                    font-size: 12pt;
                }
            }
        </style>
    </head>
    <body>
        <a href="#" class="download-btn" onclick="window.print()">Download/Print Resume</a>

        <header>
            <h1><?php echo htmlspecialchars($user_details['personal']['name']); ?></h1>
            <p>
                <?php echo htmlspecialchars($user_details['personal']['email']); ?> | 
                <?php echo htmlspecialchars($user_details['personal']['phone']); ?> | 
                <?php echo htmlspecialchars($user_details['personal']['job_role']); ?>
            </p>
            <?php if (!empty($user_details['personal']['linkedin'])) : ?>
                <p>LinkedIn: <?php echo htmlspecialchars($user_details['personal']['linkedin']); ?></p>
            <?php endif; ?>
            <?php if (!empty($user_details['personal']['github'])) : ?>
                <p>GitHub: <?php echo htmlspecialchars($user_details['personal']['github']); ?></p>
            <?php endif; ?>
        </header>

        <section class="section">
            <h2 class="section-title">Professional Summary</h2>
            <p><?php echo htmlspecialchars($user_details['personal']['description']); ?></p>
        </section>

        <section class="section">
            <h2 class="section-title">Skills</h2>
            <div class="skills-list">
                <?php foreach ($user_details['skills'] as $skill): ?>
                    <div class="skill-item">
                        <?php echo htmlspecialchars($skill['skill']); ?>
                        <?php if (!empty($skill['proficiency'])): ?>
                            (<?php echo htmlspecialchars($skill['proficiency']); ?>)
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <?php if (!empty($user_details['achievement'])): ?>
        <section class="section">
            <h2 class="section-title">Achievements</h2>
            <ul>
                <?php foreach ($user_details['achievement'] as $achievement): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($achievement['achievement']); ?></strong>
                        <?php if (!empty($achievement['achievement_date'])): ?>
                            (<?php echo htmlspecialchars($achievement['achievement_date']); ?>)
                        <?php endif; ?>
                        <?php if (!empty($achievement['achievement_description'])): ?>
                            - <?php echo htmlspecialchars($achievement['achievement_description']); ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
        <?php endif; ?>

        <section class="section">
            <h2 class="section-title">Professional Experience</h2>
            <?php foreach ($user_details['experience'] as $exp): ?>
                <div class="job-title">
                    <strong><?php echo htmlspecialchars($exp['job_title']); ?></strong> | 
                    <?php echo htmlspecialchars($exp['company_name']); ?>
                    <br>
                    <?php echo htmlspecialchars($exp['start_date']); ?> - 
                    <?php echo $exp['is_current'] ? 'Present' : htmlspecialchars($exp['end_date']); ?>
                    <?php if (!empty($exp['location'])): ?>
                        | <?php echo htmlspecialchars($exp['location']); ?>
                    <?php endif; ?>
                </div>
                <?php if (!empty($exp['job_description'])): ?>
                    <ul>
                        <?php 
                        $description_points = explode("\n", $exp['job_description']);
                        foreach ($description_points as $point):
                            if (trim($point)): ?>
                                <li><?php echo htmlspecialchars(trim($point)); ?></li>
                            <?php endif; 
                        endforeach; ?>
                    </ul>
                <?php endif; ?>
            <?php endforeach; ?>
        </section>

        <section class="section">
            <h2 class="section-title">Education</h2>
            <?php foreach ($user_details['education'] as $edu): ?>
                <div class="education-details">
                    <strong><?php echo htmlspecialchars($edu['qualification']); ?></strong> | 
                    <?php echo htmlspecialchars($edu['institute']); ?>
                    <br>
                    Graduation Year: <?php echo htmlspecialchars($edu['year_of_passout']); ?> | 
                    Percentage: <?php echo htmlspecialchars($edu['percentage']); ?>%
                </div>
            <?php endforeach; ?>
        </section>

        <?php if (!empty($user_details['projects'])): ?>
        <section class="section">
            <h2 class="section-title">Projects</h2>
            <?php foreach ($user_details['projects'] as $proj): ?>
                <div class="project">
                    <strong><?php echo htmlspecialchars($proj['project_name']); ?></strong>
                    <?php if (!empty($proj['technologies'])): ?>
                        (<?php echo htmlspecialchars($proj['technologies']); ?>)
                    <?php endif; ?>
                    <br>
                    <?php if (!empty($proj['start_date'])): ?>
                        <?php echo htmlspecialchars($proj['start_date']); ?> - 
                        <?php echo !empty($proj['end_date']) ? htmlspecialchars($proj['end_date']) : 'Present'; ?>
                    <?php endif; ?>
                    <?php if (!empty($proj['project_link'])): ?>
                        | <a href="<?php echo htmlspecialchars($proj['project_link']); ?>">View Project</a>
                    <?php endif; ?>
                    <?php if (!empty($proj['project_description'])): ?>
                        <ul>
                            <?php 
                            $project_points = explode("\n", $proj['project_description']);
                            foreach ($project_points as $point):
                                if (trim($point)): ?>
                                    <li><?php echo htmlspecialchars(trim($point)); ?></li>
                                <?php endif; 
                            endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </section>
        <?php endif; ?>

        <?php if (!empty($user_details['hobbies'])): ?>
        <section class="section">
            <h2 class="section-title">Hobbies & Interests</h2>
            <ul>
                <?php foreach ($user_details['hobbies'] as $hobby): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($hobby['hobby']); ?></strong>
                        <?php if (!empty($hobby['hobby_description'])): ?>
                            - <?php echo htmlspecialchars($hobby['hobby_description']); ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
        <?php endif; ?>

        <a href="#" class="download-btn" onclick="window.print()">Download/Print Resume</a>
    </body>
    </html>
    <?php
    return ob_get_clean();
}

// Resume Template 2: Technical Minimalist
function renderTechnicalMinimalistResume($user_details) {
    ob_start(); ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo htmlspecialchars($user_details['personal']['name']); ?> - Technical Resume</title>
        <style>
            @page {
                size: A4;
                margin: 10mm;
            }
            body { 
                font-family: 'Courier New', monospace; 
                line-height: 1.6; 
                width: 210mm;
                min-height: 297mm;
                margin: 0 auto; 
                padding: 15mm; 
                background: #f8f8f8;
                color: #333;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .code { 
                color: #007020; 
                font-weight: bold;
            }
            .comment { 
                color: #888; 
                font-style: italic;
            }
            .section { 
                margin-bottom: 30px; 
                border-left: 3px solid #007020;
                padding-left: 15px;
                page-break-inside: avoid;
            }
            .section-title { 
                border-bottom: 1px solid #007020; 
                padding-bottom: 5px; 
                margin-bottom: 15px;
                color: #2c3e50;
            }
            .item { 
                margin-bottom: 20px; 
            }
            .skills-container {
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }
            .skill-tag {
                background: #e0e0e0;
                padding: 3px 8px;
                border-radius: 3px;
                font-size: 0.9em;
            }
            .proficiency {
                color: #555;
                font-size: 0.8em;
            }
            .download-btn {
                display: block;
                text-align: center;
                margin: 20px auto;
                padding: 10px 20px;
                background: #2c3e50;
                color: white;
                text-decoration: none;
                border-radius: 4px;
                width: 200px;
                font-family: Arial, sans-serif;
            }
            ul {
                padding-left: 20px;
            }
            li {
                margin-bottom: 5px;
            }
            @media print {
                .download-btn {
                    display: none;
                }
                body {
                    padding: 0;
                    background: white;
                    font-size: 11pt;
                }
            }
        </style>
    </head>
    <body>
        <a href="#" class="download-btn" onclick="window.print()">Download/Print Resume</a>

        <header>
            <h1 class="code">/* <?php echo htmlspecialchars($user_details['personal']['name']); ?> */</h1>
            <p class="code">
                // <?php echo htmlspecialchars($user_details['personal']['job_role']); ?>
                <br>// <?php echo htmlspecialchars($user_details['personal']['email']); ?>
                <br>// <?php echo htmlspecialchars($user_details['personal']['phone']); ?>
            </p>
            <?php if (!empty($user_details['personal']['github'])): ?>
                <p class="code">// GitHub: <?php echo htmlspecialchars($user_details['personal']['github']); ?></p>
            <?php endif; ?>
            <?php if (!empty($user_details['personal']['linkedin'])): ?>
                <p class="code">// LinkedIn: <?php echo htmlspecialchars($user_details['personal']['linkedin']); ?></p>
            <?php endif; ?>
        </header>

        <section class="section">
            <h2 class="section-title code">/* Professional Summary */</h2>
            <p class="code"><?php echo htmlspecialchars($user_details['personal']['description']); ?></p>
        </section>

        <section class="section">
            <h2 class="section-title code">/* Technical Skills */</h2>
            <div class="skills-container">
                <?php foreach ($user_details['skills'] as $skill): ?>
                    <div>
                        <span class="skill-tag code"><?php echo htmlspecialchars($skill['skill']); ?></span>
                        <?php if (!empty($skill['proficiency'])): ?>
                            <span class="proficiency comment">// <?php echo htmlspecialchars($skill['proficiency']); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <?php if (!empty($user_details['achievement'])): ?>
        <section class="section">
            <h2 class="section-title code">/* Key Achievements */</h2>
            <ul>
                <?php foreach ($user_details['achievement'] as $achievement): ?>
                    <li class="code">
                        <strong><?php echo htmlspecialchars($achievement['achievement']); ?></strong>
                        <?php if (!empty($achievement['achievement_date'])): ?>
                            <span class="comment">// <?php echo htmlspecialchars($achievement['achievement_date']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($achievement['achievement_description'])): ?>
                            <br><span class="comment">/* <?php echo htmlspecialchars($achievement['achievement_description']); ?> */</span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
        <?php endif; ?>

        <section class="section">
            <h2 class="section-title code">/* Experience */</h2>
            <?php foreach ($user_details['experience'] as $exp): ?>
                <div class="item">
                    <p class="code">
                        <strong>position:</strong> <?php echo htmlspecialchars($exp['job_title']); ?>
                        <br><strong>company:</strong> <?php echo htmlspecialchars($exp['company_name']); ?>
                        <?php if (!empty($exp['location'])): ?>
                            <br><strong>location:</strong> <?php echo htmlspecialchars($exp['location']); ?>
                        <?php endif; ?>
                        <br><strong>duration:</strong> <?php echo htmlspecialchars($exp['start_date']); ?> 
                        to <?php echo $exp['is_current'] ? 'present' : htmlspecialchars($exp['end_date']); ?>
                    </p>
                    <?php if (!empty($exp['job_description'])): ?>
                        <ul class="code">
                            <?php 
                            $description_points = explode("\n", $exp['job_description']);
                            foreach ($description_points as $point):
                                if (trim($point)): ?>
                                    <li><?php echo htmlspecialchars(trim($point)); ?></li>
                                <?php endif; 
                            endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </section>

        <section class="section">
            <h2 class="section-title code">/* Education */</h2>
            <?php foreach ($user_details['education'] as $edu): ?>
                <div class="item">
                    <p class="code">
                        <strong>degree:</strong> <?php echo htmlspecialchars($edu['qualification']); ?>
                        <br><strong>institution:</strong> <?php echo htmlspecialchars($edu['institute']); ?>
                        <br><strong>year:</strong> <?php echo htmlspecialchars($edu['year_of_passout']); ?>
                        <br><strong>score:</strong> <?php echo htmlspecialchars($edu['percentage']); ?>%
                    </p>
                </div>
            <?php endforeach; ?>
        </section>

        <?php if (!empty($user_details['projects'])): ?>
        <section class="section">
            <h2 class="section-title code">/* Projects */</h2>
            <?php foreach ($user_details['projects'] as $proj): ?>
                <div class="item">
                    <p class="code">
                        <strong>project:</strong> <?php echo htmlspecialchars($proj['project_name']); ?>
                        <?php if (!empty($proj['technologies'])): ?>
                            <br><strong>stack:</strong> <?php echo htmlspecialchars($proj['technologies']); ?>
                        <?php endif; ?>
                        <?php if (!empty($proj['start_date'])): ?>
                            <br><strong>duration:</strong> <?php echo htmlspecialchars($proj['start_date']); ?> 
                            to <?php echo !empty($proj['end_date']) ? htmlspecialchars($proj['end_date']) : 'present'; ?>
                        <?php endif; ?>
                        <?php if (!empty($proj['project_link'])): ?>
                            <br><strong>link:</strong> <?php echo htmlspecialchars($proj['project_link']); ?>
                        <?php endif; ?>
                    </p>
                    <?php if (!empty($proj['project_description'])): ?>
                        <ul class="code">
                            <?php 
                            $project_points = explode("\n", $proj['project_description']);
                            foreach ($project_points as $point):
                                if (trim($point)): ?>
                                    <li><?php echo htmlspecialchars(trim($point)); ?></li>
                                <?php endif; 
                            endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </section>
        <?php endif; ?>

        <?php if (!empty($user_details['hobbies'])): ?>
        <section class="section">
            <h2 class="section-title code">/* Interests */</h2>
            <?php foreach ($user_details['hobbies'] as $hobby): ?>
                <p class="code">
                    <strong><?php echo htmlspecialchars($hobby['hobby']); ?>:</strong>
                    <?php if (!empty($hobby['hobby_description'])): ?>
                        <span class="comment">/* <?php echo htmlspecialchars($hobby['hobby_description']); ?> */</span>
                    <?php endif; ?>
                </p>
            <?php endforeach; ?>
        </section>
        <?php endif; ?>

        <a href="#" class="download-btn" onclick="window.print()">Download/Print Resume</a>

        <footer class="comment" style="text-align: center; margin-top: 40px;">
            /* <?php echo htmlspecialchars($user_details['personal']['name']); ?> - Resume generated on <?php echo date('Y-m-d'); ?> */
        </footer>
    </body>
    </html>
    <?php
    return ob_get_clean();
}

// Resume Template 3: Corporate Clean
function renderCorporateCleanResume($user_details) {
    ob_start(); ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo htmlspecialchars($user_details['personal']['name']); ?> - Professional Resume</title>
        <style>
            /* Base Print Styles */
            @page {
                size: A4;
                margin: 15mm 10mm;
            }
            body {
                font-family: 'Arial', sans-serif;
                line-height: 1.4;
                max-width: 800px;
                margin: 0 auto;
                padding: 10mm;
                color: #333;
                font-size: 11pt;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            /* Header Styles */
            .header {
                text-align: center;
                margin-bottom: 5mm;
                padding-bottom: 5mm;
                border-bottom: 1px solid #ddd;
            }
            .header h1 {
                font-size: 18pt;
                margin: 0 0 3px 0;
                color: #2c3e50;
                font-weight: 600;
            }
            .header h2 {
                font-size: 14pt;
                margin: 0 0 10px 0;
                color: #555;
                font-weight: 400;
            }
            .contact-info {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap: 8px;
                margin: 8px 0;
                font-size: 10pt;
            }
            .contact-info span {
                white-space: nowrap;
            }
            
            /* Section Styles */
            .section {
                margin-bottom: 4mm;
                page-break-inside: avoid;
            }
            .section-title {
                font-size: 12pt;
                color: #2c3e50;
                border-bottom: 1px solid #2c3e50;
                padding-bottom: 2px;
                margin: 15px 0 8px 0;
                font-weight: 600;
                text-transform: uppercase;
            }
            
            /* Experience & Education Items */
            .job, .education-item, .project {
                margin-bottom: 4mm;
                page-break-inside: avoid;
            }
            .job-header, .edu-header {
                display: flex;
                justify-content: space-between;
                margin-bottom: 2px;
            }
            .job-title, .edu-degree {
                font-weight: 600;
            }
            .job-company, .edu-institution {
                font-weight: 600;
            }
            .job-duration, .edu-duration {
                color: #666;
                font-size: 10pt;
            }
            .job-location {
                color: #666;
                font-style: italic;
                font-size: 10pt;
            }
            
            /* Skills & Lists */
            .skills-container {
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
                margin-bottom: 3mm;
            }
            .skill {
                background-color: #f5f5f5;
                padding: 2px 6px;
                border-radius: 2px;
                font-size: 10pt;
            }
            ul {
                padding-left: 5mm;
                margin: 3px 0;
            }
            li {
                margin-bottom: 2px;
                font-size: 10.5pt;
            }
            
            /* Print Button (Screen Only) */
            .print-btn {
                display: none;
                text-align: center;
                margin: 15px auto;
                padding: 8px 20px;
                background: #2c3e50;
                color: white;
                border: none;
                border-radius: 3px;
                cursor: pointer;
                font-size: 11pt;
            }
            
            /* Screen-Specific Styles */
            @media screen {
                body {
                    background: #f9f9f9;
                    padding: 15mm;
                }
                .print-btn {
                    display: block;
                }
                .job, .education-item, .project {
                    background: white;
                    padding: 8px 10px;
                    border-radius: 3px;
                    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
                }
            }
            
            /* Compact Mode for Printing */
            @media print {
                body {
                    padding: 10mm 5mm;
                }
                .section {
                    margin-bottom: 3mm;
                }
                ul {
                    padding-left: 4mm;
                }
            }
        </style>
    </head>
    <body>
        <button class="print-btn" onclick="window.print()">Print Resume</button>

        <div class="header">
            <h1><?php echo htmlspecialchars($user_details['personal']['name']); ?></h1>
            <h2><?php echo htmlspecialchars($user_details['personal']['job_role']); ?></h2>
            <div class="contact-info">
                <span><?php echo htmlspecialchars($user_details['personal']['email']); ?></span>
                <span>•</span>
                <span><?php echo htmlspecialchars($user_details['personal']['phone']); ?></span>
                <?php if (!empty($user_details['personal']['address'])): ?>
                    <span>•</span>
                    <span><?php echo htmlspecialchars($user_details['personal']['address']); ?></span>
                <?php endif; ?>
            </div>
            <div class="contact-info">
                <?php if (!empty($user_details['personal']['linkedin'])): ?>
                    <span>LinkedIn: <?php echo htmlspecialchars($user_details['personal']['linkedin']); ?></span>
                <?php endif; ?>
                <?php if (!empty($user_details['personal']['github'])): ?>
                    <span>•</span>
                    <span>GitHub: <?php echo htmlspecialchars($user_details['personal']['github']); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <section class="section">
            <h2 class="section-title">Professional Summary</h2>
            <p><?php echo htmlspecialchars($user_details['personal']['description']); ?></p>
        </section>

        <section class="section">
            <h2 class="section-title">Technical Skills</h2>
            <div class="skills-container">
                <?php foreach ($user_details['skills'] as $skill): ?>
                    <span class="skill">
                        <?php echo htmlspecialchars($skill['skill']); ?>
                        <?php if (!empty($skill['proficiency'])): ?>
                            (<?php echo htmlspecialchars($skill['proficiency']); ?>)
                        <?php endif; ?>
                    </span>
                <?php endforeach; ?>
            </div>
        </section>

        <?php if (!empty($user_details['achievement'])): ?>
        <section class="section">
            <h2 class="section-title">Key Achievements</h2>
            <ul>
                <?php foreach ($user_details['achievement'] as $achievement): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($achievement['achievement']); ?></strong>
                        <?php if (!empty($achievement['achievement_date'])): ?>
                            (<?php echo htmlspecialchars($achievement['achievement_date']); ?>)
                        <?php endif; ?>
                        <?php if (!empty($achievement['achievement_description'])): ?>
                            - <?php echo htmlspecialchars($achievement['achievement_description']); ?>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </section>
        <?php endif; ?>

        <?php if (!empty($user_details['experience'])): ?>
        <section class="section">
            <h2 class="section-title">Professional Experience</h2>
            <?php foreach ($user_details['experience'] as $exp): ?>
                <div class="job">
                    <div class="job-header">
                        <div>
                            <span class="job-title"><?php echo htmlspecialchars($exp['job_title']); ?></span>
                            <span class="job-company"> - <?php echo htmlspecialchars($exp['company_name']); ?></span>
                        </div>
                        <div class="job-duration">
                            <?php echo htmlspecialchars($exp['start_date']); ?> - <?php echo $exp['is_current'] ? 'Present' : htmlspecialchars($exp['end_date']); ?>
                        </div>
                    </div>
                    <?php if (!empty($exp['location'])): ?>
                        <div class="job-location"><?php echo htmlspecialchars($exp['location']); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($exp['job_description'])): ?>
                        <ul>
                            <?php 
                            $description_points = explode("\n", $exp['job_description']);
                            foreach ($description_points as $point):
                                if (trim($point)): ?>
                                    <li><?php echo htmlspecialchars(trim($point)); ?></li>
                                <?php endif; 
                            endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </section>
        <?php endif; ?>

        <section class="section">
            <h2 class="section-title">Education</h2>
            <?php foreach ($user_details['education'] as $edu): ?>
                <div class="education-item">
                    <div class="edu-header">
                        <div>
                            <span class="edu-degree"><?php echo htmlspecialchars($edu['qualification']); ?></span>
                            <span class="edu-institution"> - <?php echo htmlspecialchars($edu['institute']); ?></span>
                        </div>
                        <div class="edu-duration">
                            <?php echo htmlspecialchars($edu['year_of_passout']); ?>
                        </div>
                    </div>
                    <div>GPA/Percentage: <?php echo htmlspecialchars($edu['percentage']); ?>%</div>
                </div>
            <?php endforeach; ?>
        </section>

        <?php if (!empty($user_details['projects'])): ?>
        <section class="section">
            <h2 class="section-title">Projects</h2>
            <?php foreach ($user_details['projects'] as $proj): ?>
                <div class="project">
                    <div style="font-weight: 600;"><?php echo htmlspecialchars($proj['project_name']); ?></div>
                    <?php if (!empty($proj['technologies'])): ?>
                        <div style="font-size: 10pt; margin: 2px 0;">Technologies: <?php echo htmlspecialchars($proj['technologies']); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($proj['start_date'])): ?>
                        <div style="font-size: 10pt; margin: 2px 0;">
                            <?php echo htmlspecialchars($proj['start_date']); ?> - <?php echo !empty($proj['end_date']) ? htmlspecialchars($proj['end_date']) : 'Present'; ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($proj['project_description'])): ?>
                        <ul>
                            <?php 
                            $project_points = explode("\n", $proj['project_description']);
                            foreach ($project_points as $point):
                                if (trim($point)): ?>
                                    <li><?php echo htmlspecialchars(trim($point)); ?></li>
                                <?php endif; 
                            endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </section>
        <?php endif; ?>

        <?php if (!empty($user_details['hobbies'])): ?>
        <section class="section">
            <h2 class="section-title">Additional Information</h2>
            <div style="font-size: 10.5pt;">
                <strong>Interests:</strong> 
                <?php 
                $hobbies = array_map(function($hobby) {
                    $output = htmlspecialchars($hobby['hobby']);
                    if (!empty($hobby['hobby_description'])) {
                        $output .= ' (' . htmlspecialchars($hobby['hobby_description']) . ')';
                    }
                    return $output;
                }, $user_details['hobbies']);
                echo implode(', ', $hobbies);
                ?>
            </div>
        </section>
        <?php endif; ?>

        <script>
            // Auto-print when coming from view_resume.php with print parameter
            if(window.location.search.includes('print=1')) {
                window.print();
            }
        </script>
    </body>
    </html>
    <?php
    return ob_get_clean();
}

// Resume Template 4: Creative Timeline (ATS Optimized)
function renderCreativeTimelineResume($user_details) {
    ob_start(); ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo htmlspecialchars($user_details['personal']['name']); ?> - Resume</title>
        <style>
            @page {
                size: A4;
                margin: 15mm 10mm;
            }
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                line-height: 1.5;
                width: 210mm;
                margin: 0 auto;
                padding: 10mm;
                color: #333;
                background: white;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .timeline {
                position: relative;
                padding: 20px 0;
            }
            .timeline::before {
                content: '';
                position: absolute;
                top: 0;
                bottom: 0;
                left: 20px;
                width: 2px;
                background: #ddd;
            }
            .timeline-item {
                padding: 15px 15px 15px 50px;
                position: relative;
                margin-bottom: 20px;
                page-break-inside: avoid;
            }
            .timeline-item::before {
                content: '';
                width: 12px;
                height: 12px;
                background: #3498db;
                position: absolute;
                left: 15px;
                top: 20px;
                border-radius: 50%;
                border: 2px solid white;
                box-shadow: 0 0 0 2px #3498db;
            }
            .timeline-item.achievement::before {
                background: #2ecc71;
                box-shadow: 0 0 0 2px #2ecc71;
            }
            header {
                text-align: center;
                margin-bottom: 30px;
                padding-bottom: 20px;
                border-bottom: 2px solid #3498db;
            }
            h1 {
                color: #2c3e50;
                margin-bottom: 5px;
                font-size: 24pt;
            }
            .header-subtitle {
                color: #7f8c8d;
                margin-bottom: 15px;
                font-size: 14pt;
            }
            .contact-info {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap: 10px;
                margin-bottom: 10px;
                font-size: 11pt;
            }
            .section-title {
                color: #2c3e50;
                border-bottom: 1px solid #eee;
                padding-bottom: 5px;
                margin: 25px 0 15px;
                font-size: 16pt;
            }
            .skills-container {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                margin-bottom: 15px;
            }
            .skill-tag {
                background: #f0f0f0;
                padding: 4px 10px;
                border-radius: 3px;
                font-size: 10pt;
            }
            ul {
                padding-left: 20px;
                margin: 10px 0;
            }
            li {
                margin-bottom: 5px;
            }
            .date-badge {
                background: #f0f0f0;
                padding: 2px 6px;
                border-radius: 3px;
                font-size: 10pt;
                margin-right: 8px;
            }
            .print-btn {
                display: none;
            }
            @media screen {
                .print-btn {
                    display: block;
                    text-align: center;
                    margin: 20px auto;
                    padding: 8px 20px;
                    background: #3498db;
                    color: white;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                }
                body {
                    background: #f9f9f9;
                }
                .timeline-item {
                    background: white;
                    border-radius: 4px;
                    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
                }
            }
        </style>
    </head>
    <body>
        <button class="print-btn" onclick="window.print()">Print Resume</button>

        <header>
            <h1><?php echo htmlspecialchars($user_details['personal']['name']); ?></h1>
            <div class="header-subtitle"><?php echo htmlspecialchars($user_details['personal']['job_role']); ?></div>
            <div class="contact-info">
                <span><?php echo htmlspecialchars($user_details['personal']['email']); ?></span>
                <span>•</span>
                <span><?php echo htmlspecialchars($user_details['personal']['phone']); ?></span>
                <?php if (!empty($user_details['personal']['linkedin'])): ?>
                    <span>•</span>
                    <span>LinkedIn: <?php echo htmlspecialchars($user_details['personal']['linkedin']); ?></span>
                <?php endif; ?>
                <?php if (!empty($user_details['personal']['github'])): ?>
                    <span>•</span>
                    <span>GitHub: <?php echo htmlspecialchars($user_details['personal']['github']); ?></span>
                <?php endif; ?>
            </div>
        </header>

        <section>
            <h2 class="section-title">Summary</h2>
            <p><?php echo htmlspecialchars($user_details['personal']['description']); ?></p>
        </section>

        <section>
            <h2 class="section-title">Skills</h2>
            <div class="skills-container">
                <?php foreach ($user_details['skills'] as $skill): ?>
                    <span class="skill-tag">
                        <?php echo htmlspecialchars($skill['skill']); ?>
                        <?php if (!empty($skill['proficiency'])): ?>
                            (<?php echo htmlspecialchars($skill['proficiency']); ?>)
                        <?php endif; ?>
                    </span>
                <?php endforeach; ?>
            </div>
        </section>

        <?php if (!empty($user_details['achievement'])): ?>
        <section>
            <h2 class="section-title">Achievements</h2>
            <div class="timeline">
                <?php foreach ($user_details['achievement'] as $achievement): ?>
                    <div class="timeline-item achievement">
                        <h3 style="margin-top: 0;"><?php echo htmlspecialchars($achievement['achievement']); ?></h3>
                        <?php if (!empty($achievement['achievement_date'])): ?>
                            <span class="date-badge"><?php echo htmlspecialchars($achievement['achievement_date']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($achievement['achievement_description'])): ?>
                            <p><?php echo htmlspecialchars($achievement['achievement_description']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <section>
            <h2 class="section-title">Experience</h2>
            <div class="timeline">
                <?php foreach ($user_details['experience'] as $exp): ?>
                    <div class="timeline-item">
                        <h3 style="margin-top: 0;"><?php echo htmlspecialchars($exp['job_title']); ?></h3>
                        <p style="margin-bottom: 5px;">
                            <strong><?php echo htmlspecialchars($exp['company_name']); ?></strong>
                            <?php if (!empty($exp['location'])): ?>
                                <span class="date-badge"><?php echo htmlspecialchars($exp['location']); ?></span>
                            <?php endif; ?>
                        </p>
                        <p style="margin-bottom: 10px;">
                            <span class="date-badge"><?php echo htmlspecialchars($exp['start_date']); ?> - <?php echo $exp['is_current'] ? 'Present' : htmlspecialchars($exp['end_date']); ?></span>
                        </p>
                        <?php if (!empty($exp['job_description'])): ?>
                            <ul>
                                <?php 
                                $description_points = explode("\n", $exp['job_description']);
                                foreach ($description_points as $point):
                                    if (trim($point)): ?>
                                        <li><?php echo htmlspecialchars(trim($point)); ?></li>
                                    <?php endif; 
                                endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section>
            <h2 class="section-title">Education</h2>
            <div class="timeline">
                <?php foreach ($user_details['education'] as $edu): ?>
                    <div class="timeline-item">
                        <h3 style="margin-top: 0;"><?php echo htmlspecialchars($edu['qualification']); ?></h3>
                        <p style="margin-bottom: 5px;"><strong><?php echo htmlspecialchars($edu['institute']); ?></strong></p>
                        <p>
                            <span class="date-badge">Graduated: <?php echo htmlspecialchars($edu['year_of_passout']); ?></span>
                            <span class="date-badge">GPA: <?php echo htmlspecialchars($edu['percentage']); ?>%</span>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <?php if (!empty($user_details['projects'])): ?>
        <section>
            <h2 class="section-title">Projects</h2>
            <div class="timeline">
                <?php foreach ($user_details['projects'] as $proj): ?>
                    <div class="timeline-item">
                        <h3 style="margin-top: 0;"><?php echo htmlspecialchars($proj['project_name']); ?></h3>
                        <?php if (!empty($proj['technologies'])): ?>
                            <p style="margin-bottom: 5px;"><strong>Technologies:</strong> <?php echo htmlspecialchars($proj['technologies']); ?></p>
                        <?php endif; ?>
                        <?php if (!empty($proj['start_date'])): ?>
                            <p style="margin-bottom: 10px;">
                                <span class="date-badge"><?php echo htmlspecialchars($proj['start_date']); ?> - <?php echo !empty($proj['end_date']) ? htmlspecialchars($proj['end_date']) : 'Present'; ?></span>
                            </p>
                        <?php endif; ?>
                        <?php if (!empty($proj['project_description'])): ?>
                            <ul>
                                <?php 
                                $project_points = explode("\n", $proj['project_description']);
                                foreach ($project_points as $point):
                                    if (trim($point)): ?>
                                        <li><?php echo htmlspecialchars(trim($point)); ?></li>
                                    <?php endif; 
                                endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <?php if (!empty($user_details['hobbies'])): ?>
        <section>
            <h2 class="section-title">Interests</h2>
            <div class="skills-container">
                <?php foreach ($user_details['hobbies'] as $hobby): ?>
                    <span class="skill-tag">
                        <?php echo htmlspecialchars($hobby['hobby']); ?>
                        <?php if (!empty($hobby['hobby_description'])): ?>
                            (<?php echo htmlspecialchars($hobby['hobby_description']); ?>)
                        <?php endif; ?>
                    </span>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <script>
            // Automatically trigger print dialog when printing from view_resume.php
            if(window.location.search.includes('print=1')) {
                window.print();
            }
        </script>
    </body>
    </html>
    <?php
    return ob_get_clean();
}

// New Resume Template 5: Academic Research
function renderAcademicResearchResume($user_details) {
    ob_start(); ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo htmlspecialchars($user_details['personal']['name']); ?> - Academic CV</title>
        <style>
            /* Base Print Styles */
            @page {
                size: A4;
                margin: 15mm 10mm;
            }
            body {
                font-family: 'Georgia', serif;
                line-height: 1.5;
                width: 210mm;
                margin: 0 auto;
                padding: 12mm;
                color: #222;
                font-size: 11pt;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            /* Header Styles */
            header {
                text-align: center;
                margin-bottom: 8mm;
                padding-bottom: 4mm;
                border-bottom: 1px solid #2c3e50;
            }
            h1 {
                font-size: 18pt;
                margin: 0 0 3px 0;
                color: #2c3e50;
                font-weight: normal;
                letter-spacing: 0.5px;
            }
            .header-subtitle {
                font-size: 14pt;
                margin: 0 0 8px 0;
                color: #555;
                font-weight: normal;
                font-style: italic;
            }
            .contact-info {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap: 8px;
                margin: 6px 0;
                font-size: 10pt;
            }
            
            /* Section Styles */
            .section {
                margin-bottom: 6mm;
                page-break-inside: avoid;
            }
            .section-title {
                font-size: 14pt;
                color: #2c3e50;
                border-bottom: 1px solid #ddd;
                padding-bottom: 2px;
                margin: 6mm 0 3mm 0;
                font-variant: small-caps;
                letter-spacing: 1px;
            }
            
            /* Publication/Item Styles */
            .publication, .achievement {
                margin-bottom: 5mm;
            }
            .publication-title, .achievement-title {
                font-size: 12pt;
                margin: 0 0 2px 0;
                font-weight: bold;
            }
            .publication-meta, .achievement-meta {
                font-style: italic;
                margin: 0 0 4px 0;
                font-size: 10pt;
                color: #555;
            }
            
            /* Lists & Skills */
            ul {
                padding-left: 5mm;
                margin: 3px 0;
                list-style-type: square;
            }
            li {
                margin-bottom: 2px;
                font-size: 10.5pt;
            }
            .skills-container {
                display: flex;
                flex-wrap: wrap;
                gap: 5px;
                margin-bottom: 3mm;
            }
            .skill {
                background-color: #f5f5f5;
                padding: 2px 8px;
                border-radius: 2px;
                font-size: 10pt;
            }
            
            /* Print Button (Screen Only) */
            .print-btn {
                display: none;
                text-align: center;
                margin: 15px auto;
                padding: 8px 20px;
                background: #2c3e50;
                color: white;
                border: none;
                border-radius: 3px;
                cursor: pointer;
                font-family: 'Arial', sans-serif;
            }
            
            /* Screen-Specific Styles */
            @media screen {
                body {
                    background: #f9f9f9;
                    padding: 15mm;
                }
                .print-btn {
                    display: block;
                }
            }
            
            /* Compact Mode for Printing */
            @media print {
                body {
                    padding: 12mm 8mm;
                }
                .section {
                    margin-bottom: 4mm;
                }
                a {
                    text-decoration: none;
                    color: inherit;
                }
            }
        </style>
    </head>
    <body>
        <button class="print-btn" onclick="window.print()">Print CV</button>

        <header>
            <h1><?php echo htmlspecialchars($user_details['personal']['name']); ?></h1>
            <div class="header-subtitle"><?php echo htmlspecialchars($user_details['personal']['job_role']); ?></div>
            <div class="contact-info">
                <span><?php echo htmlspecialchars($user_details['personal']['email']); ?></span>
                <span>•</span>
                <span><?php echo htmlspecialchars($user_details['personal']['phone']); ?></span>
                <?php if (!empty($user_details['personal']['address'])): ?>
                    <span>•</span>
                    <span><?php echo htmlspecialchars($user_details['personal']['address']); ?></span>
                <?php endif; ?>
            </div>
            <div class="contact-info">
                <?php if (!empty($user_details['personal']['linkedin'])): ?>
                    <span>LinkedIn: <?php echo htmlspecialchars($user_details['personal']['linkedin']); ?></span>
                <?php endif; ?>
                <?php if (!empty($user_details['personal']['github'])): ?>
                    <span>•</span>
                    <span>GitHub: <?php echo htmlspecialchars($user_details['personal']['github']); ?></span>
                <?php endif; ?>
            </div>
        </header>

        <section class="section">
            <h2 class="section-title">Research Profile</h2>
            <p><?php echo htmlspecialchars($user_details['personal']['description']); ?></p>
        </section>

        <?php if (!empty($user_details['skills'])): ?>
        <section class="section">
            <h2 class="section-title">Research Skills</h2>
            <div class="skills-container">
                <?php foreach ($user_details['skills'] as $skill): ?>
                    <span class="skill">
                        <?php echo htmlspecialchars($skill['skill']); ?>
                        <?php if (!empty($skill['proficiency'])): ?>
                            (<?php echo htmlspecialchars($skill['proficiency']); ?>)
                        <?php endif; ?>
                    </span>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <?php if (!empty($user_details['achievement'])): ?>
        <section class="section">
            <h2 class="section-title">Key Achievements</h2>
            <?php foreach ($user_details['achievement'] as $achievement): ?>
                <div class="achievement">
                    <div class="achievement-title"><?php echo htmlspecialchars($achievement['achievement']); ?></div>
                    <div class="achievement-meta">
                        <?php if (!empty($achievement['achievement_date'])): ?>
                            <?php echo htmlspecialchars($achievement['achievement_date']); ?>
                        <?php endif; ?>
                        <?php if (!empty($achievement['achievement_organization'])): ?>
                            | <?php echo htmlspecialchars($achievement['achievement_organization']); ?>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($achievement['achievement_description'])): ?>
                        <p><?php echo htmlspecialchars($achievement['achievement_description']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </section>
        <?php endif; ?>

        <?php if (!empty($user_details['education'])): ?>
        <section class="section">
            <h2 class="section-title">Education</h2>
            <?php foreach ($user_details['education'] as $edu): ?>
                <div class="publication">
                    <div class="publication-title"><?php echo htmlspecialchars($edu['qualification']); ?></div>
                    <div class="publication-meta">
                        <?php echo htmlspecialchars($edu['institute']); ?> | 
                        <?php echo htmlspecialchars($edu['year_of_passout']); ?> | 
                        GPA: <?php echo htmlspecialchars($edu['percentage']); ?>%
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
        <?php endif; ?>

        <?php if (!empty($user_details['experience'])): ?>
        <section class="section">
            <h2 class="section-title">Research Experience</h2>
            <?php foreach ($user_details['experience'] as $exp): ?>
                <div class="publication">
                    <div class="publication-title"><?php echo htmlspecialchars($exp['job_title']); ?></div>
                    <div class="publication-meta">
                        <?php echo htmlspecialchars($exp['company_name']); ?> | 
                        <?php echo htmlspecialchars($exp['start_date']); ?> - <?php echo $exp['is_current'] ? 'Present' : htmlspecialchars($exp['end_date']); ?>
                        <?php if (!empty($exp['location'])): ?>
                            | <?php echo htmlspecialchars($exp['location']); ?>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($exp['job_description'])): ?>
                        <ul>
                            <?php 
                            $description_points = explode("\n", $exp['job_description']);
                            foreach ($description_points as $point):
                                if (trim($point)): ?>
                                    <li><?php echo htmlspecialchars(trim($point)); ?></li>
                                <?php endif; 
                            endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </section>
        <?php endif; ?>

        <?php if (!empty($user_details['projects'])): ?>
        <section class="section">
            <h2 class="section-title">Research Projects & Publications</h2>
            <?php foreach ($user_details['projects'] as $proj): ?>
                <div class="publication">
                    <div class="publication-title"><?php echo htmlspecialchars($proj['project_name']); ?></div>
                    <?php if (!empty($proj['technologies'])): ?>
                        <div class="publication-meta">Techniques: <?php echo htmlspecialchars($proj['technologies']); ?></div>
                    <?php endif; ?>
                    <div class="publication-meta">
                        <?php if (!empty($proj['start_date'])): ?>
                            <?php echo htmlspecialchars($proj['start_date']); ?> - <?php echo !empty($proj['end_date']) ? htmlspecialchars($proj['end_date']) : 'Present'; ?>
                        <?php endif; ?>
                        <?php if (!empty($proj['project_link'])): ?>
                            | <a href="<?php echo htmlspecialchars($proj['project_link']); ?>">Full Text</a>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($proj['project_description'])): ?>
                        <ul>
                            <?php 
                            $project_points = explode("\n", $proj['project_description']);
                            foreach ($project_points as $point):
                                if (trim($point)): ?>
                                    <li><?php echo htmlspecialchars(trim($point)); ?></li>
                                <?php endif; 
                            endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </section>
        <?php endif; ?>

        <?php if (!empty($user_details['hobbies'])): ?>
        <section class="section">
            <h2 class="section-title">Research Interests</h2>
            <p>
                <?php 
                $interests = array_map(function($hobby) {
                    $output = htmlspecialchars($hobby['hobby']);
                    if (!empty($hobby['hobby_description'])) {
                        $output .= ' (' . htmlspecialchars($hobby['hobby_description']) . ')';
                    }
                    return $output;
                }, $user_details['hobbies']);
                echo implode('; ', $interests);
                ?>.
            </p>
        </section>
        <?php endif; ?>

        <script>
            // Auto-print when coming from view_resume.php with print parameter
            if(window.location.search.includes('print=1')) {
                window.print();
            }
        </script>
    </body>
    </html>
    <?php
    return ob_get_clean();
}

// New Resume Template 6: Startup Pitch
function renderStartupPitchResume($user_details) {
    ob_start(); ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo htmlspecialchars($user_details['personal']['name']); ?> - Startup Resume</title>
        <style>
            @page {
                size: A4;
                margin: 15mm 10mm;
            }
            body {
                font-family: 'Helvetica Neue', Arial, sans-serif;
                line-height: 1.5;
                width: 210mm;
                min-height: 297mm;
                margin: 0 auto;
                padding: 0;
                color: #333;
                background: white;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .resume-container {
                max-width: 800px;
                margin: 0 auto;
                padding: 15mm;
            }
            header {
                text-align: center;
                background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
                color: white;
                padding: 30px;
                margin-bottom: 30px;
                border-radius: 8px;
            }
            h1 {
                font-size: 28px;
                margin: 0 0 5px 0;
                font-weight: 700;
            }
            .header-subtitle {
                font-size: 18px;
                opacity: 0.9;
                margin: 0 0 15px 0;
            }
            .contact-info {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap: 10px;
                font-size: 14px;
            }
            .contact-info a {
                color: white;
                text-decoration: none;
                border-bottom: 1px solid transparent;
                transition: border-color 0.3s;
            }
            .contact-info a:hover {
                border-bottom: 1px solid white;
            }
            .pitch-section {
                margin-bottom: 25px;
                page-break-inside: avoid;
            }
            .section-title {
                font-size: 18px;
                color: #2575fc;
                margin: 0 0 15px 0;
                padding-bottom: 8px;
                border-bottom: 2px solid #f0f0f0;
            }
            .achievement-item {
                margin-bottom: 15px;
            }
            .achievement-title {
                font-weight: bold;
                color: #2c3e50;
                margin: 0 0 5px 0;
            }
            .achievement-meta {
                font-size: 14px;
                color: #666;
                margin: 0 0 8px 0;
                font-style: italic;
            }
            .skills-container {
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
                margin: 15px 0;
            }
            .skill-tag {
                background: #eef5ff;
                color: #2575fc;
                padding: 6px 12px;
                border-radius: 20px;
                font-size: 14px;
                font-weight: 500;
            }
            .project-card {
                margin-bottom: 20px;
                padding-bottom: 15px;
                border-bottom: 1px solid #eee;
            }
            ul {
                padding-left: 20px;
                margin: 8px 0;
            }
            li {
                margin-bottom: 6px;
            }
            .print-btn {
                display: block;
                text-align: center;
                margin: 30px auto;
                padding: 10px 25px;
                background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
                color: white;
                border: none;
                border-radius: 30px;
                cursor: pointer;
                font-weight: 600;
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                transition: all 0.3s ease;
            }
            .print-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 12px rgba(0,0,0,0.15);
            }
            @media print {
                body {
                    padding: 0;
                }
                .resume-container {
                    padding: 15mm 10mm;
                }
                .print-btn {
                    display: none;
                }
                a {
                    color: inherit;
                    text-decoration: none;
                }
            }
        </style>
    </head>
    <body>
        <div class="resume-container">
            <button class="print-btn" onclick="window.print()">Download/Print Resume</button>

            <header>
                <h1><?php echo htmlspecialchars($user_details['personal']['name']); ?></h1>
                <div class="header-subtitle"><?php echo htmlspecialchars($user_details['personal']['job_role']); ?></div>
                <div class="contact-info">
                    <span><?php echo htmlspecialchars($user_details['personal']['email']); ?></span>
                    <span>•</span>
                    <span><?php echo htmlspecialchars($user_details['personal']['phone']); ?></span>
                    <?php if (!empty($user_details['personal']['linkedin'])): ?>
                        <span>•</span>
                        <a href="<?php echo htmlspecialchars($user_details['personal']['linkedin']); ?>">LinkedIn</a>
                    <?php endif; ?>
                    <?php if (!empty($user_details['personal']['github'])): ?>
                        <span>•</span>
                        <a href="<?php echo htmlspecialchars($user_details['personal']['github']); ?>">GitHub</a>
                    <?php endif; ?>
                </div>
            </header>

            <div class="pitch-section">
                <h2 class="section-title">ENTREPRENEURIAL PROFILE</h2>
                <p><?php echo htmlspecialchars($user_details['personal']['description']); ?></p>
                
                <?php if (!empty($user_details['skills'])): ?>
                <div class="skills-container">
                    <?php foreach ($user_details['skills'] as $skill): ?>
                        <div class="skill-tag">
                            <?php echo htmlspecialchars($skill['skill']); ?>
                            <?php if (!empty($skill['proficiency'])): ?>
                                (<?php echo htmlspecialchars($skill['proficiency']); ?>)
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <?php if (!empty($user_details['achievement'])): ?>
            <div class="pitch-section">
                <h2 class="section-title">KEY ACHIEVEMENTS</h2>
                <?php foreach ($user_details['achievement'] as $achievement): ?>
                    <div class="achievement-item">
                        <div class="achievement-title"><?php echo htmlspecialchars($achievement['achievement_title']); ?></div>
                        <div class="achievement-meta">
                            <?php if (!empty($achievement['achievement_date'])): ?>
                                <?php echo htmlspecialchars($achievement['achievement_date']); ?>
                            <?php endif; ?>
                            <?php if (!empty($achievement['achievement_organization'])): ?>
                                • <?php echo htmlspecialchars($achievement['achievement_organization']); ?>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($achievement['achievement_description'])): ?>
                            <p><?php echo htmlspecialchars($achievement['achievement_description']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($user_details['experience'])): ?>
            <div class="pitch-section">
                <h2 class="section-title">PROFESSIONAL MILESTONES</h2>
                <?php foreach ($user_details['experience'] as $exp): ?>
                    <div class="achievement-item">
                        <div class="achievement-title"><?php echo htmlspecialchars($exp['job_title']); ?></div>
                        <div class="achievement-meta">
                            <?php echo htmlspecialchars($exp['company_name']); ?> • 
                            <?php echo htmlspecialchars($exp['start_date']); ?> - <?php echo $exp['is_current'] ? 'Present' : htmlspecialchars($exp['end_date']); ?>
                            <?php if (!empty($exp['location'])): ?>
                                • <?php echo htmlspecialchars($exp['location']); ?>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($exp['job_description'])): ?>
                            <ul>
                                <?php 
                                $description_points = explode("\n", $exp['job_description']);
                                foreach ($description_points as $point):
                                    if (trim($point)): ?>
                                        <li><?php echo htmlspecialchars(trim($point)); ?></li>
                                    <?php endif; 
                                endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($user_details['projects'])): ?>
            <div class="pitch-section">
                <h2 class="section-title">NOTABLE PROJECTS</h2>
                <?php foreach ($user_details['projects'] as $proj): ?>
                    <div class="project-card">
                        <div class="achievement-title"><?php echo htmlspecialchars($proj['project_name']); ?></div>
                        <div class="achievement-meta">
                            <?php if (!empty($proj['technologies'])): ?>
                                <?php echo htmlspecialchars($proj['technologies']); ?> • 
                            <?php endif; ?>
                            <?php if (!empty($proj['start_date'])): ?>
                                <?php echo htmlspecialchars($proj['start_date']); ?> - <?php echo !empty($proj['end_date']) ? htmlspecialchars($proj['end_date']) : 'Present'; ?>
                            <?php endif; ?>
                            <?php if (!empty($proj['project_link'])): ?>
                                • <a href="<?php echo htmlspecialchars($proj['project_link']); ?>">View Project</a>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($proj['project_description'])): ?>
                            <ul>
                                <?php 
                                $project_points = explode("\n", $proj['project_description']);
                                foreach ($project_points as $point):
                                    if (trim($point)): ?>
                                        <li><?php echo htmlspecialchars(trim($point)); ?></li>
                                    <?php endif; 
                                endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($user_details['education'])): ?>
            <div class="pitch-section">
                <h2 class="section-title">EDUCATION & TRAINING</h2>
                <?php foreach ($user_details['education'] as $edu): ?>
                    <div class="achievement-item">
                        <div class="achievement-title"><?php echo htmlspecialchars($edu['qualification']); ?></div>
                        <div class="achievement-meta">
                            <?php echo htmlspecialchars($edu['institute']); ?> • 
                            Graduated: <?php echo htmlspecialchars($edu['year_of_passout']); ?> • 
                            GPA: <?php echo htmlspecialchars($edu['percentage']); ?>%
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <button class="print-btn" onclick="window.print()">Download/Print Resume</button>
        </div>

        <script>
            // Auto-print when coming from view_resume.php with print parameter
            if(window.location.search.includes('print=1')) {
                window.print();
            }
        </script>
    </body>
    </html>
    <?php
    return ob_get_clean();
}

// New Resume Template 7: Minimalist Portfolio
function renderMinimalistPortfolioResume($user_details) {
    ob_start(); ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo htmlspecialchars($user_details['personal']['name']); ?> | Minimalist Portfolio</title>
        <style>
            @page {
                size: A4;
                margin: 1.5cm;
            }
            body {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
                line-height: 1.5;
                color: #333;
                width: 210mm;
                min-height: 297mm;
                margin: 0 auto;
                padding: 1.5cm;
                box-sizing: border-box;
                background-color: #fff;
            }
            .page-container {
                max-width: 800px;
                margin: 0 auto;
            }
            header {
                text-align: center;
                margin-bottom: 2.5rem;
                padding-bottom: 1.5rem;
                border-bottom: 2px solid #000;
            }
            h1 {
                font-size: 2.2rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
                letter-spacing: -0.5px;
            }
            .header-subtitle {
                font-size: 1.2rem;
                color: #666;
                margin-bottom: 1.5rem;
            }
            .contact-info {
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap: 1rem;
                font-size: 0.9rem;
            }
            .contact-info a {
                color: #333;
                text-decoration: none;
                border-bottom: 1px solid transparent;
                transition: border-color 0.2s;
            }
            .contact-info a:hover {
                border-bottom: 1px solid #333;
            }
            .section {
                margin-bottom: 2.5rem;
                page-break-inside: avoid;
            }
            .section-title {
                font-size: 1.4rem;
                font-weight: 600;
                margin-bottom: 1.2rem;
                padding-bottom: 0.5rem;
                border-bottom: 1px solid #eee;
            }
            .project-card {
                margin-bottom: 1.8rem;
                padding-bottom: 1.8rem;
                border-bottom: 1px solid #f0f0f0;
            }
            .project-card:last-child {
                border-bottom: none;
            }
            .project-title {
                font-size: 1.1rem;
                font-weight: 600;
                margin-bottom: 0.5rem;
            }
            .project-meta {
                font-size: 0.9rem;
                color: #666;
                margin-bottom: 0.8rem;
                display: flex;
                flex-wrap: wrap;
                gap: 1rem;
            }
            .project-description {
                margin-bottom: 0.8rem;
            }
            .project-link {
                font-size: 0.9rem;
            }
            .project-link a {
                color: #333;
                text-decoration: none;
                border-bottom: 1px solid #333;
            }
            .skills-container {
                display: flex;
                flex-wrap: wrap;
                gap: 0.8rem;
                margin-top: 1rem;
            }
            .skill-tag {
                background: #f5f5f5;
                padding: 0.4rem 0.8rem;
                border-radius: 4px;
                font-size: 0.85rem;
            }
            .experience-item {
                margin-bottom: 1.8rem;
            }
            .experience-title {
                font-weight: 600;
                margin-bottom: 0.3rem;
            }
            .experience-meta {
                font-size: 0.9rem;
                color: #666;
                margin-bottom: 0.8rem;
            }
            .achievement-item {
                margin-bottom: 1.5rem;
            }
            .achievement-title {
                font-weight: 600;
                margin-bottom: 0.3rem;
            }
            .achievement-meta {
                font-size: 0.9rem;
                color: #666;
                margin-bottom: 0.5rem;
            }
            ul {
                padding-left: 1.2rem;
                margin: 0.8rem 0;
            }
            li {
                margin-bottom: 0.4rem;
            }
            .print-btn {
                display: block;
                text-align: center;
                margin: 2rem auto;
                padding: 0.8rem 1.5rem;
                background: #333;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 1rem;
            }
            @media print {
                body {
                    padding: 0;
                    background: white;
                }
                .print-btn {
                    display: none;
                }
                a {
                    text-decoration: none;
                    color: #333;
                }
            }
        </style>
    </head>
    <body>
        <div class="page-container">
            <button class="print-btn" onclick="window.print()">Download/Print Resume</button>

            <header>
                <h1><?php echo htmlspecialchars($user_details['personal']['name']); ?></h1>
                <div class="header-subtitle"><?php echo htmlspecialchars($user_details['personal']['job_role']); ?></div>
                <div class="contact-info">
                    <span><?php echo htmlspecialchars($user_details['personal']['email']); ?></span>
                    <span>•</span>
                    <span><?php echo htmlspecialchars($user_details['personal']['phone']); ?></span>
                    <?php if (!empty($user_details['personal']['linkedin'])): ?>
                        <span>•</span>
                        <a href="<?php echo htmlspecialchars($user_details['personal']['linkedin']); ?>">LinkedIn</a>
                    <?php endif; ?>
                    <?php if (!empty($user_details['personal']['github'])): ?>
                        <span>•</span>
                        <a href="<?php echo htmlspecialchars($user_details['personal']['github']); ?>">GitHub</a>
                    <?php endif; ?>
                </div>
            </header>

            <section class="section">
                <h2 class="section-title">Professional Summary</h2>
                <p><?php echo htmlspecialchars($user_details['personal']['description']); ?></p>
                
                <?php if (!empty($user_details['skills'])): ?>
                <div class="skills-container">
                    <?php foreach ($user_details['skills'] as $skill): ?>
                        <div class="skill-tag">
                            <?php echo htmlspecialchars($skill['skill']); ?>
                            <?php if (!empty($skill['proficiency'])): ?>
                                (<?php echo htmlspecialchars($skill['proficiency']); ?>)
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </section>

            <?php if (!empty($user_details['achievement'])): ?>
            <section class="section">
                <h2 class="section-title">Key Achievements</h2>
                <?php foreach ($user_details['achievement'] as $achievement): ?>
                    <div class="achievement-item">
                        <div class="achievement-title"><?php echo htmlspecialchars($achievement['achievement']); ?></div>
                        <?php if (!empty($achievement['achievement_date'])): ?>
                            <div class="achievement-meta"><?php echo htmlspecialchars($achievement['achievement_date']); ?></div>
                        <?php endif; ?>
                        <?php if (!empty($achievement['achievement_description'])): ?>
                            <p><?php echo htmlspecialchars($achievement['achievement_description']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </section>
            <?php endif; ?>

            <?php if (!empty($user_details['experience'])): ?>
            <section class="section">
                <h2 class="section-title">Professional Experience</h2>
                <?php foreach ($user_details['experience'] as $exp): ?>
                    <div class="experience-item">
                        <div class="experience-title"><?php echo htmlspecialchars($exp['job_title']); ?></div>
                        <div class="experience-meta">
                            <?php echo htmlspecialchars($exp['company_name']); ?> • 
                            <?php echo htmlspecialchars($exp['start_date']); ?> - 
                            <?php echo $exp['is_current'] ? 'Present' : htmlspecialchars($exp['end_date']); ?>
                            <?php if (!empty($exp['location'])): ?>
                                • <?php echo htmlspecialchars($exp['location']); ?>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($exp['job_description'])): ?>
                            <ul>
                                <?php 
                                $description_points = explode("\n", $exp['job_description']);
                                foreach ($description_points as $point):
                                    if (trim($point)): ?>
                                        <li><?php echo htmlspecialchars(trim($point)); ?></li>
                                    <?php endif; 
                                endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </section>
            <?php endif; ?>

            <?php if (!empty($user_details['projects'])): ?>
            <section class="section">
                <h2 class="section-title">Portfolio Projects</h2>
                <?php foreach ($user_details['projects'] as $proj): ?>
                    <div class="project-card">
                        <div class="project-title"><?php echo htmlspecialchars($proj['project_name']); ?></div>
                        <div class="project-meta">
                            <?php if (!empty($proj['technologies'])): ?>
                                <span><?php echo htmlspecialchars($proj['technologies']); ?></span>
                            <?php endif; ?>
                            <?php if (!empty($proj['start_date'])): ?>
                                <span><?php echo htmlspecialchars($proj['start_date']); ?> - 
                                <?php echo !empty($proj['end_date']) ? htmlspecialchars($proj['end_date']) : 'Present'; ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($proj['project_description'])): ?>
                            <div class="project-description">
                                <?php echo htmlspecialchars($proj['project_description']); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($proj['project_link'])): ?>
                            <div class="project-link">
                                <a href="<?php echo htmlspecialchars($proj['project_link']); ?>">View Project →</a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </section>
            <?php endif; ?>

            <?php if (!empty($user_details['education'])): ?>
            <section class="section">
                <h2 class="section-title">Education</h2>
                <?php foreach ($user_details['education'] as $edu): ?>
                    <div class="project-card">
                        <div class="project-title"><?php echo htmlspecialchars($edu['qualification']); ?></div>
                        <div class="project-meta">
                            <span><?php echo htmlspecialchars($edu['institute']); ?></span>
                            <span>Graduated: <?php echo htmlspecialchars($edu['year_of_passout']); ?></span>
                            <span>GPA: <?php echo htmlspecialchars($edu['percentage']); ?>%</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
            <?php endif; ?>

            <button class="print-btn" onclick="window.print()">Download/Print Resume</button>
        </div>
    </body>
    </html>
    <?php
    return ob_get_clean();
}

// Resume Template 8: Modern Infographic
function renderModernInfographicResume($user_details) {
    ob_start(); ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo htmlspecialchars($user_details['personal']['name']); ?> - Infographic Resume</title>
        <style>
            @page {
                size: A4;
                margin: 10mm;
            }
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                line-height: 1.6;
                width: 210mm;
                min-height: 297mm;
                margin: 0 auto;
                padding: 15mm;
                background: white;
                color: #333;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .header {
                display: flex;
                justify-content: space-between;
                margin-bottom: 30px;
            }
            .name-title {
                flex: 2;
            }
            .contact-info {
                flex: 1;
                text-align: right;
            }
            h1 {
                font-size: 28pt;
                margin: 0;
                color: #2c3e50;
            }
            .job-title {
                font-size: 14pt;
                color: #7f8c8d;
                margin: 5px 0;
            }
            .section {
                margin-bottom: 25px;
                page-break-inside: avoid;
            }
            .section-title {
                font-size: 16pt;
                color: #2c3e50;
                border-bottom: 2px solid #3498db;
                padding-bottom: 5px;
                margin-bottom: 15px;
            }
            .two-column {
                display: flex;
                gap: 30px;
            }
            .column {
                flex: 1;
            }
            .progress-container {
                margin-bottom: 15px;
            }
            .progress-label {
                display: flex;
                justify-content: space-between;
                margin-bottom: 5px;
            }
            .progress-bar {
                height: 10px;
                background: #ecf0f1;
                border-radius: 5px;
                overflow: hidden;
            }
            .progress-fill {
                height: 100%;
                background: #3498db;
                width: 0%;
            }
            .timeline {
                position: relative;
                padding-left: 20px;
            }
            .timeline:before {
                content: '';
                position: absolute;
                left: 7px;
                top: 0;
                bottom: 0;
                width: 2px;
                background: #3498db;
            }
            .timeline-item {
                position: relative;
                margin-bottom: 20px;
            }
            .timeline-item:before {
                content: '';
                position: absolute;
                left: -23px;
                top: 5px;
                width: 12px;
                height: 12px;
                border-radius: 50%;
                background: #3498db;
                border: 2px solid white;
            }
            .timeline-date {
                font-size: 12pt;
                color: #7f8c8d;
                margin-bottom: 5px;
            }
            .timeline-title {
                font-weight: bold;
                margin-bottom: 5px;
            }
            .timeline-subtitle {
                font-style: italic;
                margin-bottom: 5px;
            }
            .download-btn {
                display: block;
                text-align: center;
                margin: 30px auto;
                padding: 10px 20px;
                background: #3498db;
                color: white;
                text-decoration: none;
                border-radius: 4px;
                width: 200px;
            }
            @media print {
                .download-btn {
                    display: none;
                }
                body {
                    padding: 0;
                }
            }
        </style>
    </head>
    <body>
        <a href="#" class="download-btn" onclick="window.print()">Download/Print Resume</a>

        <div class="header">
            <div class="name-title">
                <h1><?php echo htmlspecialchars($user_details['personal']['name']); ?></h1>
                <div class="job-title"><?php echo htmlspecialchars($user_details['personal']['job_role']); ?></div>
            </div>
            <div class="contact-info">
                <p><?php echo htmlspecialchars($user_details['personal']['email']); ?></p>
                <p><?php echo htmlspecialchars($user_details['personal']['phone']); ?></p>
                <?php if (!empty($user_details['personal']['linkedin'])): ?>
                    <p><?php echo htmlspecialchars($user_details['personal']['linkedin']); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="two-column">
            <div class="column">
                <section class="section">
                    <h2 class="section-title">Professional Summary</h2>
                    <p><?php echo htmlspecialchars($user_details['personal']['description']); ?></p>
                </section>

                <section class="section">
                    <h2 class="section-title">Skills</h2>
                    <?php foreach ($user_details['skills'] as $skill): ?>
                        <div class="progress-container">
                            <div class="progress-label">
                                <span><?php echo htmlspecialchars($skill['skill']); ?></span>
                                <span><?php echo !empty($skill['proficiency']) ? htmlspecialchars($skill['proficiency']) : '80%'; ?></span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: <?php echo !empty($skill['proficiency']) ? str_replace('%', '', htmlspecialchars($skill['proficiency'])) : '80'; ?>%"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </section>

                <?php if (!empty($user_details['hobbies'])): ?>
                <section class="section">
                    <h2 class="section-title">Interests</h2>
                    <p>
                        <?php 
                        $hobbies = array_map(function($hobby) {
                            return htmlspecialchars($hobby['hobby']);
                        }, $user_details['hobbies']);
                        echo implode(', ', $hobbies);
                        ?>
                    </p>
                </section>
                <?php endif; ?>
            </div>

            <div class="column">
                <section class="section">
                    <h2 class="section-title">Experience</h2>
                    <div class="timeline">
                        <?php foreach ($user_details['experience'] as $exp): ?>
                            <div class="timeline-item">
                                <div class="timeline-date">
                                    <?php echo htmlspecialchars($exp['start_date']); ?> - <?php echo $exp['is_current'] ? 'Present' : htmlspecialchars($exp['end_date']); ?>
                                </div>
                                <div class="timeline-title"><?php echo htmlspecialchars($exp['job_title']); ?></div>
                                <div class="timeline-subtitle"><?php echo htmlspecialchars($exp['company_name']); ?></div>
                                <?php if (!empty($exp['job_description'])): ?>
                                    <ul>
                                        <?php 
                                        $description_points = explode("\n", $exp['job_description']);
                                        foreach ($description_points as $point):
                                            if (trim($point)): ?>
                                                <li><?php echo htmlspecialchars(trim($point)); ?></li>
                                            <?php endif; 
                                        endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>

                <section class="section">
                    <h2 class="section-title">Education</h2>
                    <div class="timeline">
                        <?php foreach ($user_details['education'] as $edu): ?>
                            <div class="timeline-item">
                                <div class="timeline-date"><?php echo htmlspecialchars($edu['year_of_passout']); ?></div>
                                <div class="timeline-title"><?php echo htmlspecialchars($edu['qualification']); ?></div>
                                <div class="timeline-subtitle"><?php echo htmlspecialchars($edu['institute']); ?></div>
                                <div>GPA: <?php echo htmlspecialchars($edu['percentage']); ?>%</div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            </div>
        </div>

        <a href="#" class="download-btn" onclick="window.print()">Download/Print Resume</a>
    </body>
    </html>
    <?php
    return ob_get_clean();
}

// Resume Template 9: Two-Column Compact
function renderTwoColumnCompactResume($user_details) {
    ob_start(); ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo htmlspecialchars($user_details['personal']['name']); ?> - Compact Resume</title>
        <style>
            @page {
                size: A4;
                margin: 10mm;
            }
            body {
                font-family: 'Helvetica Neue', Arial, sans-serif;
                line-height: 1.5;
                width: 210mm;
                min-height: 297mm;
                margin: 0 auto;
                padding: 10mm;
                background: white;
                color: #333;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .resume-container {
                display: flex;
                gap: 20px;
            }
            .left-column {
                flex: 1;
                background: #2c3e50;
                color: white;
                padding: 20px;
                border-radius: 5px;
            }
            .right-column {
                flex: 2;
            }
            .name {
                font-size: 24pt;
                margin-bottom: 5px;
                font-weight: bold;
            }
            .job-title {
                font-size: 14pt;
                margin-bottom: 20px;
                opacity: 0.8;
            }
            .contact-info {
                margin-bottom: 30px;
            }
            .contact-item {
                display: flex;
                align-items: center;
                margin-bottom: 10px;
            }
            .contact-icon {
                margin-right: 10px;
                width: 20px;
                text-align: center;
            }
            .section {
                margin-bottom: 25px;
            }
            .section-title {
                font-size: 16pt;
                border-bottom: 2px solid #3498db;
                padding-bottom: 5px;
                margin-bottom: 15px;
                color: white;
            }
            .right-section-title {
                font-size: 16pt;
                border-bottom: 2px solid #2c3e50;
                padding-bottom: 5px;
                margin-bottom: 15px;
                color: #2c3e50;
            }
            .skill-item {
                margin-bottom: 10px;
            }
            .skill-name {
                margin-bottom: 5px;
            }
            .achievement-item {
                margin-bottom: 15px;
            }
            .achievement-title {
                font-weight: bold;
                margin-bottom: 3px;
            }
            .achievement-date {
                font-size: 11pt;
                color: #ddd;
                margin-bottom: 5px;
            }
            .experience-item {
                margin-bottom: 20px;
            }
            .experience-title {
                font-weight: bold;
                font-size: 14pt;
                margin-bottom: 5px;
            }
            .experience-company {
                font-style: italic;
                margin-bottom: 5px;
            }
            .experience-date {
                color: #7f8c8d;
                margin-bottom: 10px;
                font-size: 12pt;
            }
            .download-btn {
                display: block;
                text-align: center;
                margin: 30px auto;
                padding: 10px 20px;
                background: #2c3e50;
                color: white;
                text-decoration: none;
                border-radius: 4px;
                width: 200px;
            }
            @media print {
                .download-btn {
                    display: none;
                }
                body {
                    padding: 0;
                }
            }
        </style>
    </head>
    <body>
        <a href="#" class="download-btn" onclick="window.print()">Download/Print Resume</a>

        <div class="resume-container">
            <div class="left-column">
                <div class="name"><?php echo htmlspecialchars($user_details['personal']['name']); ?></div>
                <div class="job-title"><?php echo htmlspecialchars($user_details['personal']['job_role']); ?></div>
                
                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-icon">✉</div>
                        <div><?php echo htmlspecialchars($user_details['personal']['email']); ?></div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">📱</div>
                        <div><?php echo htmlspecialchars($user_details['personal']['phone']); ?></div>
                    </div>
                    <?php if (!empty($user_details['personal']['linkedin'])): ?>
                    <div class="contact-item">
                        <div class="contact-icon">🔗</div>
                        <div><?php echo htmlspecialchars($user_details['personal']['linkedin']); ?></div>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="section">
                    <h2 class="section-title">Skills</h2>
                    <?php foreach ($user_details['skills'] as $skill): ?>
                        <div class="skill-item">
                            <div class="skill-name"><?php echo htmlspecialchars($skill['skill']); ?></div>
                            <?php if (!empty($skill['proficiency'])): ?>
                                <div><?php echo htmlspecialchars($skill['proficiency']); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if (!empty($user_details['hobbies'])): ?>
                <div class="section">
                    <h2 class="section-title">Interests</h2>
                    <p>
                        <?php 
                        $hobbies = array_map(function($hobby) {
                            return htmlspecialchars($hobby['hobby']);
                        }, $user_details['hobbies']);
                        echo implode(', ', $hobbies);
                        ?>
                    </p>
                </div>
                <?php endif; ?>
            </div>

            <div class="right-column">
                <div class="section">
                    <h2 class="right-section-title">Profile</h2>
                    <p><?php echo htmlspecialchars($user_details['personal']['description']); ?></p>
                </div>

                <?php if (!empty($user_details['achievement'])): ?>
                <div class="section">
                    <h2 class="right-section-title">Achievements</h2>
                    <?php foreach ($user_details['achievement'] as $achievement): ?>
                        <div class="achievement-item">
                            <div class="achievement-title"><?php echo htmlspecialchars($achievement['achievement']); ?></div>
                            <?php if (!empty($achievement['achievement_date'])): ?>
                                <div class="achievement-date"><?php echo htmlspecialchars($achievement['achievement_date']); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($achievement['achievement_description'])): ?>
                                <p><?php echo htmlspecialchars($achievement['achievement_description']); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <div class="section">
                    <h2 class="right-section-title">Experience</h2>
                    <?php foreach ($user_details['experience'] as $exp): ?>
                        <div class="experience-item">
                            <div class="experience-title"><?php echo htmlspecialchars($exp['job_title']); ?></div>
                            <div class="experience-company"><?php echo htmlspecialchars($exp['company_name']); ?></div>
                            <div class="experience-date">
                                <?php echo htmlspecialchars($exp['start_date']); ?> - <?php echo $exp['is_current'] ? 'Present' : htmlspecialchars($exp['end_date']); ?>
                                <?php if (!empty($exp['location'])): ?>
                                    | <?php echo htmlspecialchars($exp['location']); ?>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($exp['job_description'])): ?>
                                <ul>
                                    <?php 
                                    $description_points = explode("\n", $exp['job_description']);
                                    foreach ($description_points as $point):
                                        if (trim($point)): ?>
                                            <li><?php echo htmlspecialchars(trim($point)); ?></li>
                                        <?php endif; 
                                    endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="section">
                    <h2 class="right-section-title">Education</h2>
                    <?php foreach ($user_details['education'] as $edu): ?>
                        <div class="experience-item">
                            <div class="experience-title"><?php echo htmlspecialchars($edu['qualification']); ?></div>
                            <div class="experience-company"><?php echo htmlspecialchars($edu['institute']); ?></div>
                            <div class="experience-date">
                                Graduated: <?php echo htmlspecialchars($edu['year_of_passout']); ?> | 
                                GPA: <?php echo htmlspecialchars($edu['percentage']); ?>%
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <a href="#" class="download-btn" onclick="window.print()">Download/Print Resume</a>
    </body>
    </html>
    <?php
    return ob_get_clean();
}

// Resume Template 10: Bold Creative
function renderBoldCreativeResume($user_details) {
    ob_start(); ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?php echo htmlspecialchars($user_details['personal']['name']); ?> - Creative Resume</title>
        <style>
            @page {
                size: A4;
                margin: 0;
            }
            body {
                font-family: 'Montserrat', Arial, sans-serif;
                line-height: 1.6;
                width: 210mm;
                min-height: 297mm;
                margin: 0;
                padding: 0;
                background: white;
                color: #333;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .page {
                display: flex;
                min-height: 297mm;
            }
            .sidebar {
                width: 30%;
                background: #e74c3c;
                color: white;
                padding: 30px;
                box-sizing: border-box;
            }
            .main-content {
                width: 70%;
                padding: 30px;
                box-sizing: border-box;
            }
            .name {
                font-size: 28pt;
                font-weight: bold;
                margin-bottom: 10px;
                text-transform: uppercase;
            }
            .job-title {
                font-size: 14pt;
                margin-bottom: 30px;
                opacity: 0.9;
            }
            .section {
                margin-bottom: 30px;
            }
            .sidebar-title {
                font-size: 18pt;
                font-weight: bold;
                margin-bottom: 15px;
                text-transform: uppercase;
                border-bottom: 2px solid white;
                padding-bottom: 5px;
            }
            .main-title {
                font-size: 18pt;
                font-weight: bold;
                margin-bottom: 15px;
                text-transform: uppercase;
                border-bottom: 2px solid #e74c3c;
                padding-bottom: 5px;
                color: #e74c3c;
            }
            .contact-item {
                display: flex;
                align-items: center;
                margin-bottom: 15px;
            }
            .contact-icon {
                margin-right: 10px;
                font-size: 16pt;
            }
            .skill-item {
                margin-bottom: 15px;
            }
            .skill-name {
                margin-bottom: 5px;
                font-weight: bold;
            }
            .experience-item {
                margin-bottom: 25px;
            }
            .achievement-item {
                margin-bottom: 20px;
                padding-left: 15px;
                border-left: 3px solid #e74c3c;
            }
            .achievement-title {
                font-size: 14pt;
                font-weight: bold;
                margin-bottom: 5px;
                color: #e74c3c;
            }
            .achievement-date {
                font-size: 11pt;
                color: #7f8c8d;
                margin-bottom: 8px;
                font-style: italic;
            }
            .experience-title {
                font-size: 16pt;
                font-weight: bold;
                margin-bottom: 5px;
            }
            .experience-company {
                font-size: 14pt;
                font-style: italic;
                margin-bottom: 5px;
                color: #e74c3c;
            }
            .experience-date {
                font-size: 12pt;
                margin-bottom: 10px;
                color: #7f8c8d;
            }
            .download-btn {
                display: block;
                text-align: center;
                margin: 30px auto;
                padding: 10px 20px;
                background: #e74c3c;
                color: white;
                text-decoration: none;
                border-radius: 4px;
                width: 200px;
            }
            @media print {
                .download-btn {
                    display: none;
                }
            }

            .template-card {
                transition: all 0.3s ease;
                padding: 15px;
                border-radius: 8px;
                background: white;
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                height: 100%;
                display: flex;
                flex-direction: column;
            }

            .template-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 6px 12px rgba(0,0,0,0.15);
            }

            .template-image-container {
                height: 200px;
                overflow: hidden;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #f8f9fa;
                border-radius: 4px;
                border: 1px solid #eee;
            }

            .template-img {
                max-height: 100%;
                width: auto;
                transition: all 0.3s ease;
            }

            .template-card:hover .template-img {
                transform: scale(1.05);
            }

            .template-card h5 {
                margin-top: 15px;
                color: #2c3e50;
                font-size: 16px;
                font-weight: 600;
                flex-grow: 1;
            }

            /* Responsive adjustments */
            @media (max-width: 767px) {
                .template-image-container {
                    height: 150px;
                }
            }
        </style>
    </head>
    <body>
        <a href="#" class="download-btn" onclick="window.print()">Download/Print Resume</a>

        <div class="page">
            <div class="sidebar">
                <div class="name"><?php echo htmlspecialchars($user_details['personal']['name']); ?></div>
                <div class="job-title"><?php echo htmlspecialchars($user_details['personal']['job_role']); ?></div>
                
                <div class="section">
                    <h2 class="sidebar-title">Contact</h2>
                    <div class="contact-item">
                        <div class="contact-icon">✉</div>
                        <div><?php echo htmlspecialchars($user_details['personal']['email']); ?></div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">📱</div>
                        <div><?php echo htmlspecialchars($user_details['personal']['phone']); ?></div>
                    </div>
                    <?php if (!empty($user_details['personal']['linkedin'])): ?>
                    <div class="contact-item">
                        <div class="contact-icon">🔗</div>
                        <div><?php echo htmlspecialchars($user_details['personal']['linkedin']); ?></div>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="section">
                    <h2 class="sidebar-title">Skills</h2>
                    <?php foreach ($user_details['skills'] as $skill): ?>
                        <div class="skill-item">
                            <div class="skill-name"><?php echo htmlspecialchars($skill['skill']); ?></div>
                            <?php if (!empty($skill['proficiency'])): ?>
                                <div><?php echo htmlspecialchars($skill['proficiency']); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if (!empty($user_details['hobbies'])): ?>
                <div class="section">
                    <h2 class="sidebar-title">Interests</h2>
                    <p>
                        <?php 
                        $hobbies = array_map(function($hobby) {
                            return htmlspecialchars($hobby['hobby']);
                        }, $user_details['hobbies']);
                        echo implode(', ', $hobbies);
                        ?>
                    </p>
                </div>
                <?php endif; ?>
            </div>

            <div class="main-content">
                <div class="section">
                    <h2 class="main-title">Profile</h2>
                    <p><?php echo htmlspecialchars($user_details['personal']['description']); ?></p>
                </div>

                <?php if (!empty($user_details['achievement'])): ?>
                <div class="section">
                    <h2 class="main-title">Key Achievements</h2>
                    <?php foreach ($user_details['achievement'] as $achievement): ?>
                        <div class="achievement-item">
                            <div class="achievement-title"><?php echo htmlspecialchars($achievement['achievement']); ?></div>
                            <?php if (!empty($achievement['achievement_date'])): ?>
                                <div class="achievement-date"><?php echo htmlspecialchars($achievement['achievement_date']); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($achievement['achievement_description'])): ?>
                                <p><?php echo htmlspecialchars($achievement['achievement_description']); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <div class="section">
                    <h2 class="main-title">Experience</h2>
                    <?php foreach ($user_details['experience'] as $exp): ?>
                        <div class="experience-item">
                            <div class="experience-title"><?php echo htmlspecialchars($exp['job_title']); ?></div>
                            <div class="experience-company"><?php echo htmlspecialchars($exp['company_name']); ?></div>
                            <div class="experience-date">
                                <?php echo htmlspecialchars($exp['start_date']); ?> - <?php echo $exp['is_current'] ? 'Present' : htmlspecialchars($exp['end_date']); ?>
                                <?php if (!empty($exp['location'])): ?>
                                    | <?php echo htmlspecialchars($exp['location']); ?>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($exp['job_description'])): ?>
                                <ul>
                                    <?php 
                                    $description_points = explode("\n", $exp['job_description']);
                                    foreach ($description_points as $point):
                                        if (trim($point)): ?>
                                            <li><?php echo htmlspecialchars(trim($point)); ?></li>
                                        <?php endif; 
                                    endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="section">
                    <h2 class="main-title">Education</h2>
                    <?php foreach ($user_details['education'] as $edu): ?>
                        <div class="experience-item">
                            <div class="experience-title"><?php echo htmlspecialchars($edu['qualification']); ?></div>
                            <div class="experience-company"><?php echo htmlspecialchars($edu['institute']); ?></div>
                            <div class="experience-date">
                                Graduated: <?php echo htmlspecialchars($edu['year_of_passout']); ?> | 
                                GPA: <?php echo htmlspecialchars($edu['percentage']); ?>%
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <a href="#" class="download-btn" onclick="window.print()">Download/Print Resume</a>
    </body>
    </html>
    <?php
    return ob_get_clean();
}

// Update the generateMultipleResumeFormats function to include the new templates
function generateMultipleResumeFormats($user_email) {
    $user_details = getUserDetails($user_email);
    
    $resume_formats = array(
        'classic_professional' => renderClassicProfessionalResume($user_details),
        'technical_minimalist' => renderTechnicalMinimalistResume($user_details),
        'corporate_clean' => renderCorporateCleanResume($user_details),
        'creative_timeline' => renderCreativeTimelineResume($user_details),
        'modern_infographic' => renderModernInfographicResume($user_details),
        'academic_research' => renderAcademicResearchResume($user_details),
        'startup_pitch' => renderStartupPitchResume($user_details),
        'minimalist_portfolio' => renderMinimalistPortfolioResume($user_details),
        'two_column_compact' => renderTwoColumnCompactResume($user_details),
        'bold_creative' => renderBoldCreativeResume($user_details)
    );
    
    // Save each resume format to a file
    $output_dir = 'resume_formats/';
    if (!is_dir($output_dir)) {
        mkdir($output_dir, 0777, true);
    }
    
    foreach ($resume_formats as $format_name => $resume_content) {
        file_put_contents($output_dir . $format_name . '_resume.html', $resume_content);
    }
    
    return $resume_formats;
}

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    die("Please log in to view your resume.");
}

include 'dbconnect.php';
include 'navbar.php';

// Generate and display resumes
try {
    $user_email = $_SESSION['user_email']; // Ensure this is set during login
    $resumes = generateMultipleResumeFormats($user_email);

 // Display resume selection
// Update the display section in your resume.php file (replace the existing display code)
echo "<div class='resume-template-container mt-5'>";
echo "<div class='resume-template-row'>";

// Template data with all the required information (same as before)
$templates = array(
    'classic_professional' => array(
        'image' => 'Images/1.jpg',
        'title' => 'Classic Professional',
        'subtitle' => 'Traditional resume format with clean layout',
        'tags' => array('Professional', 'Clean')
    ),
    'technical_minimalist' => array(
        'image' => 'Images/2.jpg',
        'title' => 'Technical Minimalist',
        'subtitle' => 'Perfect for IT and engineering roles',
        'tags' => array('Technical', 'Minimal')
    ),
    'corporate_clean' => array(
        'image' => 'Images/3.jpg',
        'title' => 'Corporate Clean',
        'subtitle' => 'Modern design for business professionals',
        'tags' => array('Corporate', 'Modern')
    ),
    'creative_timeline' => array(
        'image' => 'Images/4.jpg',
        'title' => 'Creative Timeline',
        'subtitle' => 'Visual timeline format for career progression',
        'tags' => array('Timeline', 'Visual')
    ),
    'modern_infographic' => array(
        'image' => 'Images/1.jpg',
        'title' => 'Classic Professional',
        'subtitle' => 'Traditional resume format with clean layout',
        'tags' => array('Professional', 'Clean')
    ),
    'academic_research' => array(
        'image' => 'Images/2.jpg',
        'title' => 'Technical Minimalist',
        'subtitle' => 'Perfect for IT and engineering roles',
        'tags' => array('Technical', 'Minimal')
    ),
    'startup_pitch' => array(
        'image' => 'Images/3.jpg',
        'title' => 'Corporate Clean',
        'subtitle' => 'Modern design for business professionals',
        'tags' => array('Corporate', 'Modern')
    ),
    'minimalist_portfolio' => array(
        'image' => 'Images/4.jpg',
        'title' => 'Creative Timeline',
        'subtitle' => 'Visual timeline format for career progression',
        'tags' => array('Timeline', 'Visual')
    ),
    'two_column_compact' => array(
        'image' => 'Images/2.jpg',
        'title' => 'Technical Minimalist',
        'subtitle' => 'Perfect for IT and engineering roles',
        'tags' => array('Technical', 'Minimal')
    ),
    'bold_creative' => array(
        'image' => 'Images/3.jpg',
        'title' => 'Corporate Clean',
        'subtitle' => 'Modern design for business professionals',
        'tags' => array('Corporate', 'Modern')
    )
);

// Add CSS for the new design with more specific styles
echo "<style>
    /* Main container and row styles to override any framework */
    .resume-template-container {
        width: 100%;
        max-width: 1200px;
        margin: 100px auto 0;
        margin: 0 auto;
        padding: 0 15px;
    }
    
    .resume-template-row {
        display: flex;  
        flex-wrap: wrap;
        margin: 0 -15px;
    }
    
    /* Column styles */
    .template-column {
        flex: 0 0 25%;
        width: 25%;
        padding: 0 15px;
        margin-bottom: 30px;
        box-sizing: border-box;
    }
    
    /* Card styles */
    .template-card {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: transform 0.3s;
        height: 100%;
        background-color: white;
        display: flex;
        flex-direction: column;
    }
    
    .template-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }
    
    .template-img-container {
        width: 100%;
        height: 180px;
        overflow: hidden;
        flex-shrink: 0;
    }
    
    .template-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .template-content {
        padding: 15px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    
    .template-title {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .template-subtitle {
        font-size: 0.8rem;
        color: #666;
        margin-bottom: 12px;
        min-height: 36px;
    }
    
    .template-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-bottom: 15px;
    }
    
    .template-tag {
        background-color: #f2f2f2;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        color: #555;
        display: inline-block;
    }
    
    .use-template-btn {
        display: block;
        width: 100%;
        background-color: #4869ed;
        color: white;
        font-weight: 500;
        text-align: center;
        padding: 8px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 0.9rem;
        margin-top: auto;
    }
    
    .use-template-btn:hover {
        background-color: #3a5bd9;
        color: white;
        text-decoration: none;
    }
    
    .new-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #ff3e9a;
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    /* Responsive styles */
    @media (max-width: 1199px) {
        .template-column {
            flex: 0 0 33.333%;
            width: 33.333%;
        }
    }
    
    @media (max-width: 991px) {
        .template-column {
            flex: 0 0 50%;
            width: 50%;
        }
    }
    
    @media (max-width: 576px) {
        .template-column {
            flex: 0 0 100%;
            width: 100%;
        }
        .template-subtitle {
            min-height: auto;
        }
    }
</style>";

foreach ($templates as $format_name => $template) {
    echo "<div class='template-column'>";
    echo "<div class='template-card position-relative'>";
    
    // Add "New" badge to specific templates
    if ($format_name == 'creative_timeline' || $format_name == 'modern_infographic') {
        echo "<div class='new-badge'>New</div>";
    }
    
    echo "<div class='template-img-container'>";
    echo "<img src='" . htmlspecialchars($template['image']) . "' alt='" . htmlspecialchars($template['title']) . "' class='template-img'>";
    echo "</div>";
    
    echo "<div class='template-content'>";
    echo "<h3 class='template-title'>" . htmlspecialchars($template['title']) . "</h3>";
    echo "<p class='template-subtitle'>" . htmlspecialchars($template['subtitle']) . "</p>";
    
    echo "<div class='template-tags'>";
    foreach ($template['tags'] as $tag) {
        echo "<span class='template-tag'>" . htmlspecialchars($tag) . "</span>";
    }
    echo "</div>";
    
    echo "<a href='view_resume.php?format=" . urlencode($format_name) . "' class='use-template-btn'>Use This Template</a>";
    echo "</div>"; // Close template-content
    
    echo "</div>"; // Close template-card
    echo "</div>"; // Close column
}

echo "</div>"; // Close row
echo "</div>"; // Close container
} catch (Exception $e) {
    echo "Error generating resumes: " . $e->getMessage();
}
?>

<?php
    include('footer.php');
?>