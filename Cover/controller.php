<?php

include('dbconnect.php');
$conn = get_db_connection();

// Handle professional details form submission
if (isset($_POST['submit_profesional_details']) && isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $current_job_title = $_POST['current_job_title'];
    $years_experience = $_POST['years_experience'];
    $key_skills = $_POST['key_skills'];
    $notable_achievements = $_POST['notable_achievements'];

    // Check if record exists for this user
    $check_query = "SELECT * FROM professional_details_cover WHERE user_email = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing record
        $update_query = "UPDATE professional_details_cover SET 
                         current_job_title = ?, 
                         years_experience = ?, 
                         key_skills = ?, 
                         notable_achievements = ? 
                         WHERE user_email = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sisss", $current_job_title, $years_experience, $key_skills, $notable_achievements, $email);
    } else {
        // Insert new record
        $insert_query = "INSERT INTO professional_details_cover 
                        (user_email, current_job_title, years_experience, key_skills, notable_achievements) 
                        VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ssiss", $email, $current_job_title, $years_experience, $key_skills, $notable_achievements);
    }

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Professional details saved successfully!";
    } else {
        $_SESSION['error_message'] = "Error saving professional details: " . $conn->error;
    }

    $stmt->close();
    header("Location: profesional.php");
    exit();
}

// Load professional details if they exist
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $query = "SELECT * FROM professional_details_cover WHERE user_email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $professional_details = $result->fetch_assoc();
    }
    $stmt->close();
}
?>


<?php

// Handle application specifics form submission
if (isset($_POST['submit_company_letter']) && isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $company_name = $_POST['company_name'];
    $position_applying_for = $_POST['position_applying_for'];
    $hiring_manager = $_POST['hiring_manager'];
    $job_source = $_POST['job_source'];

    // Check if record exists for this user
    $check_query = "SELECT * FROM application_specifics WHERE user_email = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing record
        $update_query = "UPDATE application_specifics SET 
                         company_name = ?, 
                         position_applying_for = ?, 
                         hiring_manager = ?, 
                         job_source = ? 
                         WHERE user_email = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sssss", $company_name, $position_applying_for, $hiring_manager, $job_source, $email);
    } else {
        // Insert new record
        $insert_query = "INSERT INTO application_specifics 
                        (user_email, company_name, position_applying_for, hiring_manager, job_source) 
                        VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("sssss", $email, $company_name, $position_applying_for, $hiring_manager, $job_source);
    }

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Application specifics saved successfully!";
    } else {
        $_SESSION['error_message'] = "Error saving application specifics: " . $conn->error;
    }

    $stmt->close();
    header("Location: specifics.php");
    exit();
}

// Load application specifics if they exist
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $query = "SELECT * FROM application_specifics WHERE user_email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $application_specifics = $result->fetch_assoc();
    }
    $stmt->close();
}

?>