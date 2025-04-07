<?php
// Include database connection
include ('dbconnect.php');

// Start session
session_start();
$user_email = $_SESSION['email'];
$conn = get_db_connection();

// Function to sanitize input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Handle Personal Details Form Submission
if(isset($_POST['submit_personal_details'])) {
    try {
        // Sanitize and validate inputs
        $name = sanitize_input($_POST['name']);
        $email = sanitize_input($_POST['email']);
        $phone = sanitize_input($_POST['phone']);
        $address = sanitize_input($_POST['address']);
        $github = sanitize_input($_POST['github']);
        $linkedin = sanitize_input($_POST['linkedin']);
        $job_role = sanitize_input($_POST['job_role']);
        $description = sanitize_input($_POST['description']);

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format");
        }

        // Create database connection
        $conn = get_db_connection();

        // Check if user already exists
        $check_stmt = $conn->prepare("SELECT id FROM personal_details WHERE email = ?");
        $check_stmt->bind_param("s", $email);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        // Prepare SQL statement
        if ($check_result->num_rows > 0) {
            // Update existing record
            $stmt = $conn->prepare("UPDATE personal_details SET 
                name = ?, phone = ?, address = ?, 
                github = ?, linkedin = ?, job_role = ?, 
                description = ? WHERE email = ?");
            $stmt->bind_param("ssssssss", 
                $name, $phone, $address, 
                $github, $linkedin, $job_role, 
                $description, $email
            );
        } else {
            // Insert new record
            $stmt = $conn->prepare("INSERT INTO personal_details 
                (user, name, email, phone, address, github, linkedin, job_role, description) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssss", 
                $user_email, $name, $email, $phone, $address, 
                $github, $linkedin, $job_role, $description
            );
        }

        // Execute the statement
        if ($stmt->execute()) {
            // Store email in session for future use
            $_SESSION['user_email'] = $email;
            
            echo "<script>
                alert('Personal details saved successfully!');
                window.location.href = 'ueducation.php';
            </script>";
        } else {
            throw new Exception("Error saving details: " . $stmt->error);
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();

    } catch (Exception $e) {
        // Handle exceptions
        echo "<script>
            alert('" . $e->getMessage() . "');
            window.history.back();
        </script>";
        exit();
    }
}

// Handle Education Details Form Submission
if(isset($_POST['submit_education_details'])) {
    try {
        // Ensure user is logged in
        if (!isset($_SESSION['email'])) {
            throw new Exception("You are not authorised to access this page.Please Login First ⚠️");
        }

        // Create database connection
        $conn = get_db_connection();

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO education_details 
            (user, qualification, institute, year_of_passout, percentage) 
            VALUES (?, ?, ?, ?, ?)");
        
        // Get form data
        $qualifications = $_POST['qualification'];
        $institutes = $_POST['institute'];
        $years_of_passout = $_POST['year_of_passout'];
        $percentages = $_POST['percentage'];

        // Track successful insertions
        $insertSuccess = true;
        $insertCount = 0;

        // Loop through education entries
        for ($i = 0; $i < count($qualifications); $i++) {
            // Sanitize inputs
            $qualification = sanitize_input($qualifications[$i]);
            $institute = sanitize_input($institutes[$i]);
            $year_of_passout = sanitize_input($years_of_passout[$i]);
            $percentage = sanitize_input($percentages[$i]);

            // Bind parameters
            $stmt->bind_param("ssssd", 
                $user_email, $qualification, 
                $institute, $year_of_passout, $percentage
            );

            // Execute the statement
            if (!$stmt->execute()) {
                $insertSuccess = false;
                break;
            }
            $insertCount++;
        }

        // Check overall success
        if ($insertSuccess) {
            echo "<script>
                alert('$insertCount education details saved successfully!');
                window.location.href = 'uexperience.php';
            </script>";
        } else {
            throw new Exception("Error saving education details: " . $stmt->error);
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();

    } catch (Exception $e) {
        // Handle exceptions
        echo "<script>
            alert('" . $e->getMessage() . "');
            window.history.back();
        </script>";
        exit();
    }
}


// Handle Experience Details Form Submission
if(isset($_POST['submit_experience_details'])) {
    try {
        // Ensure user is logged in
        if (!isset($_SESSION['email'])) {
            throw new Exception("You are not authorised to access this page.Please Login First ⚠️");
        }

        // Create database connection
        $conn = get_db_connection();

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO experience_details 
            (user, company_name, job_title, start_date, end_date, is_current, location, job_description) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        
        // Get form data
        $company_names = $_POST['company_name'];
        $job_titles = $_POST['job_title'];
        $start_dates = $_POST['start_date'];
        $end_dates = $_POST['end_date'];
        $is_current_array = isset($_POST['is_current']);
        $locations = $_POST['location'];
        $job_descriptions = $_POST['job_description'];

        // Track successful insertions
        $insertSuccess = true;
        $insertCount = 0;

        // Loop through experience entries
        for ($i = 0; $i < count($company_names); $i++) {
            // Sanitize inputs
            $company_name = sanitize_input($company_names[$i]);
            $job_title = sanitize_input($job_titles[$i]);
            $start_date = sanitize_input($start_dates[$i]);
            
            // Handle end date and current job
            $end_date = null;
            $is_current_job = 0;
            
            // Check if the current job checkbox is set for this entry
            if (isset($is_current_array[$i]) && $is_current_array[$i] == 'on') {
                $is_current_job = 1;
            } else {
                $end_date = !empty($end_dates[$i]) ? sanitize_input($end_dates[$i]) : null;
            }

            $location = isset($locations[$i]) ? sanitize_input($locations[$i]) : '';
            $job_description = isset($job_descriptions[$i]) ? sanitize_input($job_descriptions[$i]) : '';

            // Bind parameters
            $stmt->bind_param("sssssiss", 
                $user_email, 
                $company_name, 
                $job_title, 
                $start_date, 
                $end_date, 
                $is_current_job, 
                $location, 
                $job_description
            );

            // Execute the statement
            if (!$stmt->execute()) {
                $insertSuccess = false;
                error_log("Error inserting experience: " . $stmt->error);
                break;
            }
            $insertCount++;
        }

        // Check overall success
        if ($insertSuccess) {
            echo "<script>
                alert('$insertCount experience details saved successfully!');
                window.location.href = 'uprojects.php';
            </script>";
        } else {
            throw new Exception("Error saving experience details: " . $stmt->error);
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();

    } catch (Exception $e) {
        // Handle exceptions
        echo "<script>
            alert('" . $e->getMessage() . "');
            window.history.back();
        </script>";
        error_log($e->getMessage());
        exit();
    }
}
?>





<?php
// Handle Projects Details Form Submission
if(isset($_POST['submit_projects_details'])) {
    try {
        // Ensure user is logged in
        if (!isset($_SESSION['email'])) {
            throw new Exception("You are not authorised to access this page.Please Login First ⚠️");
        }

        // Create database connection
        $conn = get_db_connection();

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO projects_details 
            (user, project_name, project_description, technologies, project_link, start_date, end_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        // Get form data
        $project_names = $_POST['project_name'];
        $project_descriptions = $_POST['project_description'];
        $technologies = $_POST['technologies'];
        $project_links = $_POST['project_link'];
        $start_dates = $_POST['start_date'];
        $end_dates = $_POST['end_date'];

        // Track successful insertions
        $insertSuccess = true;
        $insertCount = 0;

        // Loop through project entries
        for ($i = 0; $i < count($project_names); $i++) {
            // Sanitize inputs
            $project_name = sanitize_input($project_names[$i]);
            $project_description = sanitize_input($project_descriptions[$i]);
            $technology = isset($technologies[$i]) ? sanitize_input($technologies[$i]) : null;
            $project_link = isset($project_links[$i]) ? sanitize_input($project_links[$i]) : null;
            $start_date = !empty($start_dates[$i]) ? sanitize_input($start_dates[$i]) : null;
            $end_date = !empty($end_dates[$i]) ? sanitize_input($end_dates[$i]) : null;

            // Bind parameters
            $stmt->bind_param("sssssss", 
                $user_email, 
                $project_name, 
                $project_description, 
                $technology, 
                $project_link, 
                $start_date, 
                $end_date
            );

            // Execute the statement
            if (!$stmt->execute()) {
                $insertSuccess = false;
                error_log("Error inserting project: " . $stmt->error);
                break;
            }
            $insertCount++;
        }

        // Check overall success
        if ($insertSuccess) {
            echo "<script>
                alert('$insertCount project details saved successfully!');
                window.location.href = 'uhobbies.php';
            </script>";
        } else {
            throw new Exception("Error saving project details: " . $stmt->error);
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();

    } catch (Exception $e) {
        // Handle exceptions
        echo "<script>
            alert('" . $e->getMessage() . "');
            window.history.back();
        </script>";
        error_log($e->getMessage());
        exit();
    }
}
?>



<?php
// Handle Hobbies Details Form Submission
if(isset($_POST['submit_hobbies_details'])) {
    try {
        // Ensure user is logged in
        if (!isset($_SESSION['email'])) {
            throw new Exception("You are not authorised to access this page.Please Login First ⚠️");
        }

        // Create database connection
        $conn = get_db_connection();

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO hobbies_details 
            (user, hobby, hobby_description) 
            VALUES (?, ?, ?)");
        
        // Get form data
        $hobbies = $_POST['hobby'];
        $hobby_descriptions = $_POST['hobby_description'];

        // Track successful insertions
        $insertSuccess = true;
        $insertCount = 0;

        // Loop through hobby entries
        for ($i = 0; $i < count($hobbies); $i++) {
            // Sanitize inputs
            $hobby = sanitize_input($hobbies[$i]);
            $hobby_description = !empty($hobby_descriptions[$i]) ? 
                sanitize_input($hobby_descriptions[$i]) : null;

            // Bind parameters
            $stmt->bind_param("sss", 
                $user_email, 
                $hobby, 
                $hobby_description
            );

            // Execute the statement
            if (!$stmt->execute()) {
                $insertSuccess = false;
                error_log("Error inserting hobby: " . $stmt->error);
                break;
            }
            $insertCount++;
        }

        // Check overall success
        if ($insertSuccess) {
            echo "<script>
                alert('$insertCount hobbies saved successfully!');
                window.location.href = 'uskills.php';
            </script>";
        } else {
            throw new Exception("Error saving hobbies details: " . $stmt->error);
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();

    } catch (Exception $e) {
        // Handle exceptions
        echo "<script>
            alert('" . $e->getMessage() . "');
            window.history.back();
        </script>";
        error_log($e->getMessage());
        exit();
    }
}
?>


<?php
// Handle Skills Details Form Submission
if(isset($_POST['submit_skills_details'])) {
    try {
        // Ensure user is logged in
        if (!isset($_SESSION['email'])) {
            throw new Exception("You are not authorised to access this page.Please Login First ⚠️");
        }

        // Create database connection
        $conn = get_db_connection();

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO user_skills 
            (user, skill, proficiency, skill_description) 
            VALUES (?, ?, ?, ?)");
        
        // Get form data
        $skills = $_POST['skill'];
        $proficiencies = $_POST['skill_proficiency'];
        $skill_descriptions = $_POST['skill_description'];

        // Track successful insertions
        $insertSuccess = true;
        $insertCount = 0;

        // Loop through skill entries
        for ($i = 0; $i < count($skills); $i++) {
            // Sanitize inputs
            $skill = sanitize_input($skills[$i]);
            $proficiency = sanitize_input($proficiencies[$i]);
            $skill_description = !empty($skill_descriptions[$i]) ? 
                sanitize_input($skill_descriptions[$i]) : null;

            // Bind parameters
            $stmt->bind_param("ssss", 
                $user_email,
                $skill, 
                $proficiency,
                $skill_description
            );

            // Execute the statement
            if (!$stmt->execute()) {
                $insertSuccess = false;
                error_log("Error inserting skill: " . $stmt->error);
                break;
            }
            $insertCount++;
        }

        // Check overall success
        if ($insertSuccess) {
            echo "<script>
                alert('$insertCount skills saved successfully!');
                window.location.href = 'uachievements.php';
            </script>";
        } else {
            throw new Exception("Error saving skills details: " . $stmt->error);
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();

    } catch (Exception $e) {
        // Handle exceptions
        echo "<script>
            alert('" . $e->getMessage() . "');
            window.history.back();
        </script>";
        error_log($e->getMessage());
        exit();
    }
}

?>


<?php

    // Handle Achievement Details Form Submission
if(isset($_POST['submit_achievement_details'])) {
    try {
        // Ensure user is logged in
        if (!isset($_SESSION['email'])) {
            throw new Exception("You are not authorised to access this page.Please Login First ⚠️");
        }

        // Create database connection
        $conn = get_db_connection();

        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO user_achievements 
            (user, achievement, organization, achievement_date, achievement_description) 
            VALUES (?, ?, ?, ?, ?)");
        
        // Get form data
        $achievements = $_POST['achievement'];
        $organizations = $_POST['achievement_organization'];
        $achievement_dates = $_POST['achievement_date'];
        $achievement_descriptions = $_POST['achievement_description'];

        // Track successful insertions
        $insertSuccess = true;
        $insertCount = 0;

        // Loop through achievement entries
        for ($i = 0; $i < count($achievements); $i++) {
            // Sanitize inputs
            $achievement = sanitize_input($achievements[$i]);
            $organization = !empty($organizations[$i]) ? sanitize_input($organizations[$i]) : null;
            $achievement_date = !empty($achievement_dates[$i]) ? sanitize_input($achievement_dates[$i]) : null;
            $achievement_description = !empty($achievement_descriptions[$i]) ? 
                sanitize_input($achievement_descriptions[$i]) : null;

            // Bind parameters
            $stmt->bind_param("sssss", 
                $user_email, 
                $achievement, 
                $organization,
                $achievement_date,
                $achievement_description
            );

            // Execute the statement
            if (!$stmt->execute()) {
                $insertSuccess = false;
                error_log("Error inserting achievement: " . $stmt->error);
                break;
            }
            $insertCount++;
        }

        // Check overall success
        if ($insertSuccess) {
            echo "<script>
                alert('$insertCount achievements saved successfully!');
                alert('All Datas were saved you can use these for future works!');
                window.location.href = 'index1.php';
            </script>";
        } else {
            throw new Exception("Error saving achievement details: " . $stmt->error);
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();

    } catch (Exception $e) {
        // Handle exceptions
        echo "<script>
            alert('" . $e->getMessage() . "');
            window.history.back();
        </script>";
        error_log($e->getMessage());
        exit();
    }
}

?>