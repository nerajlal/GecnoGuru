<?php
// controller.php
session_start();
include 'dbconnect.php';

// Initialize database connection
$conn = new mysqli($host, $user, $pass, $dbname);

// Check database connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Function to sanitize input data
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Handle Personal Details Form Submission
if (isset($_POST['submit_personal_details'])) {
    // Sanitize and validate inputs
    $full_name = sanitizeInput($_POST['full_name']);
    $professional_title = sanitizeInput($_POST['professional_title']);
    $email = sanitizeInput($_POST['email']);
    $phone = sanitizeInput($_POST['phone']);
    $linkedin_url = isset($_POST['linkedin_url']) ? sanitizeInput($_POST['linkedin_url']) : '';
    $portfolio_url = isset($_POST['portfolio_url']) ? sanitizeInput($_POST['portfolio_url']) : '';
    $address = isset($_POST['address']) ? sanitizeInput($_POST['address']) : '';
    $user_email = $_SESSION['email'];

    // Check if user already has personal details
    $check_sql = "SELECT * FROM personal_details_cover WHERE user_email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $user_email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing record
        $sql = "UPDATE personal_details_cover SET 
                full_name = ?, 
                professional_title = ?, 
                email = ?, 
                phone = ?, 
                linkedin_url = ?, 
                portfolio_url = ?, 
                address = ? 
                WHERE user_email = ?";
    } else {
        // Insert new record
        $sql = "INSERT INTO personal_details_cover (
                full_name, 
                professional_title, 
                email, 
                phone, 
                linkedin_url, 
                portfolio_url, 
                address, 
                user_email
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", 
        $full_name, 
        $professional_title, 
        $email, 
        $phone, 
        $linkedin_url, 
        $portfolio_url, 
        $address, 
        $user_email
    );

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Personal details saved successfully!";
    } else {
        $_SESSION['error_message'] = "Error saving personal details: " . $conn->error;
    }

    $stmt->close();
    $check_stmt->close();
    header("Location: profesional.php");
    exit();
}

// Handle Professional Details Form Submission
if (isset($_POST['submit_profesional_details'])) {
    // Sanitize and validate inputs
    $current_job_title = sanitizeInput($_POST['current_job_title']);
    $years_experience = sanitizeInput($_POST['years_experience']);
    $key_skills = sanitizeInput($_POST['key_skills']);
    $notable_achievements = sanitizeInput($_POST['notable_achievements']);
    $user_email = $_SESSION['email'];

    // Check if user already has professional details
    $check_sql = "SELECT * FROM professional_details_cover WHERE user_email = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $user_email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing record
        $sql = "UPDATE professional_details_cover SET 
                current_job_title = ?, 
                years_experience = ?, 
                key_skills = ?, 
                notable_achievements = ? 
                WHERE user_email = ?";
    } else {
        // Insert new record
        $sql = "INSERT INTO professional_details_cover (
                current_job_title, 
                years_experience, 
                key_skills, 
                notable_achievements, 
                user_email
                ) VALUES (?, ?, ?, ?, ?)";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisss", 
        $current_job_title, 
        $years_experience, 
        $key_skills, 
        $notable_achievements, 
        $user_email
    );

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Professional details saved successfully!";
    } else {
        $_SESSION['error_message'] = "Error saving professional details: " . $conn->error;
    }

    $stmt->close();
    $check_stmt->close();
    header("Location: specifics.php");
    exit();
}

// Handle Company/Letter Details Form Submission
if (isset($_POST['submit_company_letter'])) {
    // Sanitize and validate inputs
    $company_name = sanitizeInput($_POST['company_name']);
    $position_applying_for = sanitizeInput($_POST['position_applying_for']);
    $hiring_manager = isset($_POST['hiring_manager']) ? sanitizeInput($_POST['hiring_manager']) : '';
    $job_source = isset($_POST['job_source']) ? sanitizeInput($_POST['job_source']) : '';
    $user_email = $_SESSION['email'];

    // Get user's personal and professional details
    $personal_sql = "SELECT * FROM personal_details_cover WHERE user_email = ?";
    $personal_stmt = $conn->prepare($personal_sql);
    $personal_stmt->bind_param("s", $user_email);
    $personal_stmt->execute();
    $personal_result = $personal_stmt->get_result();
    $personal_data = $personal_result->fetch_assoc();

    $professional_sql = "SELECT * FROM professional_details_cover WHERE user_email = ?";
    $professional_stmt = $conn->prepare($professional_sql);
    $professional_stmt->bind_param("s", $user_email);
    $professional_stmt->execute();
    $professional_result = $professional_stmt->get_result();
    $professional_data = $professional_result->fetch_assoc();

    if (!$personal_data || !$professional_data) {
        $_SESSION['error_message'] = "Please complete your personal and professional details first.";
        header("Location: specifics.php");
        exit();
    }

    // Generate the cover letter
    $cover_letter = generateCoverLetter(
        $personal_data, 
        $professional_data, 
        array(
            'company_name' => $company_name,
            'position_applying_for' => $position_applying_for,
            'hiring_manager' => $hiring_manager,
            'job_source' => $job_source
        )
    );
    
    
    // Save the cover letter to the database
    $sql = "INSERT INTO cover_letters (
            user_email, 
            company_name, 
            position_applying_for, 
            hiring_manager, 
            job_source, 
            cover_letter_content, 
            generated_date
            ) VALUES (?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", 
        $user_email, 
        $company_name, 
        $position_applying_for, 
        $hiring_manager, 
        $job_source, 
        $cover_letter
    );

    if ($stmt->execute()) {
        $_SESSION['cover_letter'] = $cover_letter;
        $_SESSION['success_message'] = "Cover letter generated successfully!";
        header("Location: preview.php");
    } else {
        $_SESSION['error_message'] = "Error generating cover letter: " . $conn->error;
        header("Location: specifics.php");
    }

    $stmt->close();
    $personal_stmt->close();
    $professional_stmt->close();
    exit();
}

// Function to generate cover letter
function generateCoverLetter($personal_data, $professional_data, $company_data) {
    $salutation = !empty($company_data['hiring_manager']) ? 
        "Dear " . $company_data['hiring_manager'] . "," : "Dear Hiring Manager,";
    
    $introduction = "I am excited to apply for the " . $company_data['position_applying_for'] . 
        " position at " . $company_data['company_name'] . ". " . 
        "With " . $professional_data['years_experience'] . " years of experience as a " . 
        $professional_data['current_job_title'] . ", I am confident in my ability to contribute effectively to your team.";
    
    $body = "In my current role, I have developed expertise in " . 
        str_replace(",", ", ", $professional_data['key_skills']) . ". " .
        "Some of my notable achievements include: " . $professional_data['notable_achievements'] . ". " .
        "I am particularly drawn to this opportunity at " . $company_data['company_name'];
    
    $closing = "I would welcome the opportunity to discuss how my skills and experiences align with your needs. " . 
        "Thank you for your time and consideration. I look forward to your response.";
    
    $signature = "Sincerely,\n" . $personal_data['full_name'] . "\n" . 
        $personal_data['professional_title'] . "\n" . 
        (!empty($personal_data['phone']) ? "Phone: " . $personal_data['phone'] . "\n" :"") .
        (!empty($personal_data['email']) ? "Email: " . $personal_data['email'] : "") .
        (!empty($personal_data['linkedin_url']) ? "LinkedIn: " . $personal_data['linkedin_url'] : "") .
        (!empty($personal_data['portfolio_url']) ? "Portfolio: " . $personal_data['portfolio_url'] : "");
    
    $cover_letter = $personal_data['full_name'] . "\n" . 
        (!empty($personal_data['address']) ? $personal_data['address'] . "\n" : "\n") .
        date("F j, Y") . "\n" .
        $company_data['company_name'] . "\n" .
        $salutation . "\n" .
        $introduction . "\n" .
        $body . "\n" .
        $closing . "\n" .
        $signature;
    
    return $cover_letter;
}

// Close database connection
$conn->close();
?>