<?php
session_start(); // Required for using $_SESSION

// Sanitize function
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

require_once ('dbconnect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['email'])) {

    if (isset($_POST['submit_personal_details'])) {
        $name = sanitize_input($_POST["name"]);
        $email = sanitize_input($_POST["email"]);
        $phone = sanitize_input($_POST["phone"]);
        $address = sanitize_input($_POST["address"]);
        $github = sanitize_input($_POST["github"]);
        $linkedin = sanitize_input($_POST["linkedin"]);
        $jobrole = sanitize_input($_POST["job_role"]);
        $description = sanitize_input($_POST["description"]);

        $session_email = $_SESSION['email'];

        $conn = get_db_connection();

        $stmt = $conn->prepare("
            UPDATE personal_details
            SET name = ?, email = ?, phone = ?, address = ?, github = ?, linkedin = ?, job_role = ?, description = ? 
            WHERE user = ?
        ");
        $stmt->bind_param("sssssssss", $name, $email, $phone, $address, $github, $linkedin, $jobrole, $description, $session_email);

        if ($stmt->execute()) {
            echo "<script>
                alert('Personal details updated successfully.');
                window.location.href = 'personal.php';
            </script>";
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

    }


    else if (isset($_POST['update_education'])) {
        $education_id = sanitize_input($_POST["education_id"]);
        $qualification = sanitize_input($_POST["qualification"]);
        $institute = sanitize_input($_POST["institute"]);
        $year_of_passout = sanitize_input($_POST["year_of_passout"]);
        $percentage = sanitize_input($_POST["percentage"]);
        
        $session_email = $_SESSION['email'];
        $conn = get_db_connection();
        
        // First verify this education record belongs to the logged-in user
        $verify = $conn->prepare("SELECT id FROM education_details WHERE id = ? AND user = ?");
        $verify->bind_param("is", $education_id, $session_email);
        $verify->execute();
        $verify_result = $verify->get_result();
        
        if ($verify_result->num_rows === 0) {
            // Record doesn't belong to this user or doesn't exist
            echo "<script>
                alert('Error: You do not have permission to edit this record.');
                window.location.href = 'education.php';
            </script>";
            exit();
        }
        
        // Update the education record
        $stmt = $conn->prepare("
            UPDATE education_details 
            SET qualification = ?, institute = ?, year_of_passout = ?, percentage = ? 
            WHERE id = ? AND user = ?
        ");
        $stmt->bind_param("ssssis", $qualification, $institute, $year_of_passout, $percentage, $education_id, $session_email);
        
        if ($stmt->execute()) {
            echo "<script>
                alert('Education record updated successfully.');
                window.location.href = 'education.php';
            </script>";
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
        $conn->close();
    }    
    
    
    else if (isset($_POST['update_experience'])) {
        $experience_id = sanitize_input($_POST["experience_id"]);
        $company_name = sanitize_input($_POST["company_name"]);
        $job_title = sanitize_input($_POST["job_title"]);
        $start_date = sanitize_input($_POST["start_date"]);
        $end_date = sanitize_input($_POST["end_date"]);
        $location = sanitize_input($_POST["location"]);
        $job_description = sanitize_input($_POST["job_description"]);

        $session_email = $_SESSION['email'];
        $conn = get_db_connection();

        // First verify this education record belongs to the logged-in user
        $verify = $conn->prepare("SELECT id FROM experience_details WHERE id = ? AND user = ?");
        $verify->bind_param("is", $experience_id, $session_email);
        $verify->execute();
        $verify_result = $verify->get_result();

        if ($verify_result->num_rows === 0) {
            // Record doesn't belong to this user or doesn't exist
            echo "<script>
                alert('Error: You do not have permission to edit this record.');
                window.location.href = 'experience.php';
            </script>";
            exit();
        }

        // Update the education record   
        $stmt = $conn->prepare("
            UPDATE experience_details 
            SET company_name = ?, job_title = ?, start_date = ?, end_date = ?, job_description = ?, location = ? WHERE id = ? AND user = ?
        ");
        $stmt->bind_param("ssssssis", $company_name, $job_title, $start_date, $end_date, $job_description,$location, $experience_id, $session_email);
        
        if ($stmt->execute()) {
            echo "<script>
                alert('Experience record updated successfully.');
                window.location.href = 'experience.php';
            </script>";
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
        $conn->close();

    }


    else if (isset($_POST['update_project'])) {
        $project_id = sanitize_input($_POST["project_id"]);
        $project_name = sanitize_input($_POST["project_name"]);
        $project_description = sanitize_input($_POST["project_description"]);
        $technologies = sanitize_input($_POST["technologies"]);
        $project_link = sanitize_input($_POST["project_link"]);
        $start_date = sanitize_input($_POST["start_date"]);
        $end_date = sanitize_input($_POST["end_date"]);

        $session_email = $_SESSION['email'];
        $conn = get_db_connection();

        // First verify this education record belongs to the logged-in user
        $verify = $conn->prepare("SELECT id FROM projects_details WHERE id = ? AND user = ?");
        $verify->bind_param("is", $project_id, $session_email);
        $verify->execute();
        $verify_result = $verify->get_result();

        if ($verify_result->num_rows === 0) {
            // Record doesn't belong to this user or doesn't exist
            echo "<script>
                alert('Error: You do not have permission to edit this record.');
                window.location.href = 'projects.php';
            </script>";
            exit();
        }

        // Update the project record  
        $stmt = $conn->prepare("
            UPDATE projects_details 
            SET project_name = ?, project_description = ?, technologies = ?, project_link = ?, start_date = ?, end_date = ? WHERE id = ? AND user = ?
        ");
        $stmt->bind_param("ssssssis", $project_name, $project_description, $technologies, $project_link, $start_date, $end_date, $project_id, $session_email);
        
        if ($stmt->execute()) {
            echo "<script>
                alert('Project record updated successfully.');
                window.location.href = 'projects.php';
            </script>";
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
        $conn->close();
    }

    else if (isset($_POST['update_skill'])) {
        $skill_id = sanitize_input($_POST["skill_id"]);
        $skill = sanitize_input($_POST["skill"]);
        $proficiency = sanitize_input($_POST["proficiency"]);
        $skill_description = sanitize_input($_POST["skill_description"]);
       
        $session_email = $_SESSION['email'];
        $conn = get_db_connection();

        // First verify this education record belongs to the logged-in user
        $verify = $conn->prepare("SELECT id FROM user_skills WHERE id = ? AND user = ?");
        $verify->bind_param("is", $skill_id, $session_email);
        $verify->execute();
        $verify_result = $verify->get_result();

        if ($verify_result->num_rows === 0) {
            // Record doesn't belong to this user or doesn't exist
            echo "<script>
                alert('Error: You do not have permission to edit this record.');
                window.location.href = 'skills.php';
            </script>";
            exit();
        }

        // Update the project record 
        $stmt = $conn->prepare("
            UPDATE user_skills 
            SET skill = ?, proficiency = ?, skill_description = ? WHERE id = ? AND user = ?
        ");
        $stmt->bind_param("sssis", $skill, $proficiency, $skill_description, $skill_id, $session_email);
        
        if ($stmt->execute()) {
            echo "<script>
                alert('Skills record updated successfully.');
                window.location.href = 'skills.php';
            </script>";
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
        $conn->close();
    }


    else if (isset($_POST['update_achievement'])) {
        $achievement_id = sanitize_input($_POST["achievement_id"]);
        $achievement = sanitize_input($_POST["achievement"]);
        $organization = sanitize_input($_POST["organization"]);
        $achievement_date = sanitize_input($_POST["achievement_date"]);
        $achievement_description = sanitize_input($_POST["achievement_description"]);
       
        $session_email = $_SESSION['email'];
        $conn = get_db_connection();

        // First verify this education record belongs to the logged-in user
        $verify = $conn->prepare("SELECT id FROM user_achievements WHERE id = ? AND user = ?");
        $verify->bind_param("is", $achievement_id, $session_email);
        $verify->execute();
        $verify_result = $verify->get_result();

        if ($verify_result->num_rows === 0) {
            // Record doesn't belong to this user or doesn't exist
            echo "<script>
                alert('Error: You do not have permission to edit this record.');
                window.location.href = 'achievements.php';
            </script>";
            exit();
        }

        // Update the project record     
        $stmt = $conn->prepare("
            UPDATE user_achievements 
            SET achievement = ?, organization = ?, achievement_date = ?, achievement_description =? WHERE id = ? AND user = ?
        ");
        $stmt->bind_param("ssssis", $achievement, $organization, $achievement_date, $achievement_description, $achievement_id, $session_email);
        
        if ($stmt->execute()) {
            echo "<script>
                alert('Achievements record updated successfully.');
                window.location.href = 'achievements.php';
            </script>";
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
        $conn->close();
    }


    else if (isset($_POST['update_hobby'])) {
        $hobby_id = sanitize_input($_POST["hobby_id"]);
        $hobby = sanitize_input($_POST["hobby"]);
        $hobby_description = sanitize_input($_POST["hobby_description"]);
       
        $session_email = $_SESSION['email'];
        $conn = get_db_connection();

        // First verify this education record belongs to the logged-in user
        $verify = $conn->prepare("SELECT id FROM hobbies_details WHERE id = ? AND user = ?");
        $verify->bind_param("is", $hobby_id, $session_email);
        $verify->execute();
        $verify_result = $verify->get_result();

        if ($verify_result->num_rows === 0) {
            // Record doesn't belong to this user or doesn't exist
            echo "<script>
                alert('Error: You do not have permission to edit this record.');
                window.location.href = 'hobbies.php';
            </script>";
            exit();
        }

        // Update the project record     
        $stmt = $conn->prepare("
            UPDATE hobbies_details 
            SET hobby = ?, hobby_description = ? WHERE id = ? AND user = ?
        ");
        $stmt->bind_param("ssis", $hobby, $hobby_description, $hobby_id, $session_email);
        
        if ($stmt->execute()) {
            echo "<script>
                alert('Hobbies record updated successfully.');
                window.location.href = 'hobbies.php';
            </script>";
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
        $conn->close();
    }







    
}      

?>
