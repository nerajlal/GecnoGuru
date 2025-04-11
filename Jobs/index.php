<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session before any output
session_start();

// Include files
include('navbar1.php');
include('dbconnect.php');

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Get user email from session
$user_email = $_SESSION['email'];
$conn = get_db_connection();

// Function to get all user details
function getUserDetails($user_email, $conn) {
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
    $personal_query = $conn->prepare("SELECT * FROM personal_details WHERE user = ?");
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

    return $user_details;
}

// Call the function and get all user details
$user_details = getUserDetails($user_email, $conn);

// Extract individual sections for easier use in the template
$personal_details = isset($user_details['personal']) ? array($user_details['personal']) : array();
$education_details = $user_details['education'];
$experience_details = $user_details['experience'];
$projects_details = $user_details['projects'];
$skills_details = $user_details['skills'];
$hobbies_details = $user_details['hobbies'];
$achievements_details = $user_details['achievement'];

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <?php
// [Previous PHP code remains exactly the same until the style section]
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Profile page complete CSS */
    .profile-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    .profile-header {
        text-align: center;
        margin-bottom: 30px;
        padding: 25px;
        background: linear-gradient(135deg, #3498db, #2c3e50);
        color: white;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .profile-header h1 {
        font-size: 2.2rem;
        margin-bottom: 10px;
    }

    .profile-header p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    /* Container for all sections */
    .sections-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: flex-start; /* This prevents items from stretching to match heights */
        width: 100%;
        gap: 30px; /* Consistent spacing between items */
    }

    /* Style for all sections */
    .section {
        height: auto; 
        min-height: 0;
        width: 48%;
        margin-bottom: 30px;
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        padding: 25px;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    /* Special style for personal section */
    .section.personal {
        width: 100%;
        background: linear-gradient(to bottom right, #ffffff, #f8f9fa);
    }

    .section:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }

    .section-title {
        color: #2c3e50;
        border-bottom: 2px solid #3498db;
        padding-bottom: 12px;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .section-title h2 {
        font-size: 1.4rem;
        margin: 0;
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 10px;
        color: #3498db;
    }

    .edit-btn {
        background-color: #3498db;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .edit-btn:hover {
        background-color: #2980b9;
        transform: translateY(-2px);
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }

    .info-group {
        margin-bottom: 15px;
    }

    .info-group.full-width {
        grid-column: 1 / -1;
    }

    .info-label {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
        font-size: 0.95rem;
    }

    .info-value {
        color: #34495e;
        font-size: 1rem;
    }

    .info-value a {
        color: #3498db;
        text-decoration: none;
    }

    .info-value a:hover {
        text-decoration: underline;
    }

    .education-item, .experience-item, 
    .project-item, .skill-item,
    .hobby-item, .achievement-item {
        padding: 15px;
        height: auto;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        margin-bottom: 15px;
        background-color: #f8f9fa;
    }

    .current-job {
        color: #27ae60;
        font-weight: 600;
    }

    .skill-proficiency {
        display: flex;
        align-items: center;
        margin-top: 8px;
    }

    .skill-progress {
        flex-grow: 1;
        height: 8px;
        background-color: #e9ecef;
        border-radius: 4px;
        margin-left: 10px;
        overflow: hidden;
    }

    .progress-bar {
        height: 100%;
        background: linear-gradient(to right, #3498db, #2ecc71);
        border-radius: 4px;
    }

    .empty-message {
        color: #7f8c8d;
        font-style: italic;
        text-align: center;
        padding: 20px;
        border: 2px dashed #e9ecef;
        border-radius: 8px;
    }

    .empty-message a {
        color: #3498db;
        text-decoration: none;
        font-weight: 600;
    }

    /* Responsive styles */
    @media (max-width: 992px) {
        .section {
            width: 100%;
        }
        
        .info-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .profile-container {
            padding: 15px;
        }
        
        .profile-header {
            padding: 20px;
        }
        
        .profile-header h1 {
            font-size: 1.8rem;
        }
        
        .section {
            padding: 20px;
        }
    }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <?php if (!empty($personal_details) && isset($personal_details[0])): ?>
                <?php $personal = $personal_details[0]; ?>
                <h1><?php echo htmlspecialchars($personal['name']); ?>'s Profile</h1>
            <?php else: ?>
                <h1>User Profile</h1>
            <?php endif; ?>
            <p>Your complete professional portfolio at a glance</p>
        </div>

        <div class="sections-grid">
            <!-- Personal Details Section -->
            <div class="section personal">
                <div class="section-title">
                    <h2><i class="fas fa-user"></i> Personal Details</h2>
                    <a href="upersonal.php" class="edit-btn">Add New</a>
                </div>
                
                <?php if (!empty($personal_details) && isset($personal_details[0])): ?>
                    <?php $personal = $personal_details[0]; ?>
                    <div class="info-grid">
                        <div class="info-group">
                            <div class="info-label">Full Name</div>
                            <div class="info-value"><?php echo htmlspecialchars($personal['name']); ?></div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label">Email</div>
                            <div class="info-value"><?php echo htmlspecialchars($personal['email']) ?></div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label">Phone</div>
                            <div class="info-value"><?php echo htmlspecialchars($personal['phone']) ?></div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label">Job Role</div>
                            <div class="info-value"><?php echo htmlspecialchars($personal['job_role']) ?></div>
                        </div>
                        
                        <div class="info-group full-width">
                            <div class="info-label">Professional Description</div>
                            <div class="info-value"><?php echo nl2br(htmlspecialchars($personal['description'])) ?></div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label">Address</div>
                            <div class="info-value"><?php echo nl2br(htmlspecialchars($personal['address'])) ?></div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label">GitHub</div>
                            <div class="info-value">
                                <?php if (!empty($personal['github'])): ?>
                                    <a href="<?php echo htmlspecialchars($personal['github']) ?>" target="_blank"><?php echo htmlspecialchars($personal['github']) ?></a>
                                <?php else: ?>
                                    Not provided
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="info-group">
                            <div class="info-label">LinkedIn</div>
                            <div class="info-value">
                                <?php if (!empty($personal['linkedin'])): ?>
                                    <a href="<?php echo htmlspecialchars($personal['linkedin']) ?>" target="_blank"><?php echo htmlspecialchars($personal['linkedin']) ?></a>
                                <?php else: ?>
                                    Not provided
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="empty-message">No personal details found. <a href="upersonal.php">Add your information</a></div>
                <?php endif; ?>
            </div>

            <!-- Education Section -->
            <div class="section">
                <div class="section-title">
                    <h2><i class="fas fa-graduation-cap"></i> Education</h2>
                    <a href="ueducation.php" class="edit-btn">Add New</a>
                </div>
                
                <?php if (!empty($education_details)): ?>
                    <?php foreach ($education_details as $education): ?>
                        <div class="education-item">
                            <div class="info-group">
                                <div class="info-label">Qualification</div>
                                <div class="info-value"><?php echo htmlspecialchars($education['qualification']) ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Institute</div>
                                <div class="info-value"><?php echo htmlspecialchars($education['institute']) ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Year</div>
                                <div class="info-value"><?php echo htmlspecialchars($education['year_of_passout']) ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Grade</div>
                                <div class="info-value"><?php echo htmlspecialchars($education['percentage']) ?>%</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-message">No education details found. <a href="ueducation.php">Add your education</a></div>
                <?php endif; ?>
            </div>

            <!-- Experience Section -->
            <div class="section">
                <div class="section-title">
                    <h2><i class="fas fa-briefcase"></i> Experience</h2>
                    <a href="uexperience.php" class="edit-btn">Add New</a>
                </div>
                
                <?php if (!empty($experience_details)): ?>
                    <?php foreach ($experience_details as $experience): ?>
                        <div class="experience-item">
                            <div class="info-group">
                                <div class="info-label">Company</div>
                                <div class="info-value"><?php echo htmlspecialchars($experience['company_name']) ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Position</div>
                                <div class="info-value"><?php echo htmlspecialchars($experience['job_title']) ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Duration</div>
                                <div class="info-value">
                                    <?php echo date('M Y', strtotime($experience['start_date'])) ?> - 
                                    <?php echo $experience['is_current'] ? '<span class="current-job">Present</span>' : 
                                        (empty($experience['end_date']) ? 'Not specified' : 
                                        date('M Y', strtotime($experience['end_date']))) ?>
                                </div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Location</div>
                                <div class="info-value"><?php echo !empty($experience['location']) ? htmlspecialchars($experience['location']) : 'Not specified' ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Description</div>
                                <div class="info-value"><?php echo !empty($experience['job_description']) ? nl2br(htmlspecialchars($experience['job_description'])) : 'No description' ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-message">No experience found. <a href="uexperience.php">Add your experience</a></div>
                <?php endif; ?>
            </div>

            <!-- Projects Section -->
            <div class="section">
                <div class="section-title">
                    <h2><i class="fas fa-project-diagram"></i> Projects</h2>
                    <a href="uprojects.php" class="edit-btn">Add New</a>
                </div>
                
                <?php if (!empty($projects_details)): ?>
                    <?php foreach ($projects_details as $project): ?>
                        <div class="project-item">
                            <div class="info-group">
                                <div class="info-label">Project</div>
                                <div class="info-value"><?php echo htmlspecialchars($project['project_name']) ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Technologies</div>
                                <div class="info-value"><?php echo !empty($project['technologies']) ? htmlspecialchars($project['technologies']) : 'Not specified' ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Duration</div>
                                <div class="info-value">
                                    <?php echo !empty($project['start_date']) ? date('M Y', strtotime($project['start_date'])) : 'Not specified' ?> - 
                                    <?php echo !empty($project['end_date']) ? date('M Y', strtotime($project['end_date'])) : 'Not specified' ?>
                                </div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Link</div>
                                <div class="info-value">
                                    <?php if (!empty($project['project_link'])): ?>
                                        <a href="<?php echo htmlspecialchars($project['project_link']) ?>" target="_blank">View Project</a>
                                    <?php else: ?>
                                        Not provided
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Description</div>
                                <div class="info-value"><?php echo !empty($project['project_description']) ? nl2br(htmlspecialchars($project['project_description'])) : 'No description' ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-message">No projects found. <a href="uprojects.php">Add your projects</a></div>
                <?php endif; ?>
            </div>

            <!-- Skills Section -->
            <div class="section">
    <div class="section-title">
        <h2><i class="fas fa-tools"></i> Skills</h2>
        <a href="uskills.php" class="edit-btn">Add New</a>
    </div>

    <?php if (!empty($skills_details)): ?>
        <?php 
            // Map proficiency levels to percentages
            $proficiency_map = array(
                'beginner' => 25,
                'intermediate' => 50,
                'advanced' => 75,
                'expert' => 100
            );
        ?>

        <?php foreach ($skills_details as $skill): ?>
            <?php
                // Convert the proficiency text to lowercase and map to percentage
                $proficiency_key = strtolower(trim($skill['proficiency']));
                $proficiency_value = isset($proficiency_map[$proficiency_key]) ? $proficiency_map[$proficiency_key] : 0;
            ?>

            <div class="skill-item">
                <div class="info-group">
                    <div class="info-label">Skill</div>
                    <div class="info-value"><?php echo htmlspecialchars($skill['skill']); ?></div>
                </div>

                <div class="info-group">
                    <div class="info-label">Proficiency</div>
                    <div class="skill-proficiency">
                        <div class="info-value"><?php echo ucfirst($proficiency_key) . " ({$proficiency_value}%)"; ?></div>
                        <div class="skill-progress" style="background: #eee; border-radius: 4px; height: 8px; overflow: hidden;">
                            <div class="progress-bar" style="width: <?php echo $proficiency_value; ?>%;"></div>
                        </div>
                    </div>
                </div>

                <div class="info-group">
                    <div class="info-label">Description</div>
                    <div class="info-value">
                        <?php echo !empty($skill['skill_description']) ? nl2br(htmlspecialchars($skill['skill_description'])) : 'No description'; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="empty-message">No skills found. <a href="uskills.php">Add your skills</a></div>
    <?php endif; ?>
</div>


            <!-- Hobbies Section -->
            <div class="section">
                <div class="section-title">
                    <h2><i class="fas fa-heart"></i> Hobbies</h2>
                    <a href="uhobbies.php" class="edit-btn">Add New</a>
                </div>
                
                <?php if (!empty($hobbies_details)): ?>
                    <?php foreach ($hobbies_details as $hobby): ?>
                        <div class="hobby-item">
                            <div class="info-group">
                                <div class="info-label">Hobby</div>
                                <div class="info-value"><?php echo htmlspecialchars($hobby['hobby']) ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Description</div>
                                <div class="info-value"><?php echo !empty($hobby['hobby_description']) ? nl2br(htmlspecialchars($hobby['hobby_description'])) : 'No description' ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-message">No hobbies found. <a href="uhobbies.php">Add your hobbies</a></div>
                <?php endif; ?>
            </div>

            <!-- Achievements Section -->
            <div class="section">
                <div class="section-title">
                    <h2><i class="fas fa-trophy"></i> Achievements</h2>
                    <a href="uachievements.php" class="edit-btn">Add New</a>
                </div>
                
                <?php if (!empty($achievements_details)): ?>
                    <?php foreach ($achievements_details as $achievement): ?>
                        <div class="achievement-item">
                            <div class="info-group">
                                <div class="info-label">Achievement</div>
                                <div class="info-value"><?php echo htmlspecialchars($achievement['achievement']) ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Organization</div>
                                <div class="info-value"><?php echo !empty($achievement['organization']) ? htmlspecialchars($achievement['organization']) : 'Not specified' ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Date</div>
                                <div class="info-value"><?php echo !empty($achievement['achievement_date']) ? date('M Y', strtotime($achievement['achievement_date'])) : 'Not specified' ?></div>
                            </div>
                            
                            <div class="info-group">
                                <div class="info-label">Description</div>
                                <div class="info-value"><?php echo !empty($achievement['achievement_description']) ? nl2br(htmlspecialchars($achievement['achievement_description'])) : 'No description' ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="empty-message">No achievements found. <a href="uachievements.php">Add your achievements</a></div>
                <?php endif; ?>
            </div>
        </div>
        </div>
        <?php include('footer.php'); ?>
    
</body>
</html>
