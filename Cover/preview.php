<?php
// Start the session first
session_start();

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

// Get user email
$email = $_SESSION['email'];

// Include the navbar after session check
include ('navbar.php');
include_once('dbconnect.php');
?>

<?php

$conn = get_db_connection();

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

// Get personal details
$personal_details = array();
$query = "SELECT * FROM personal_details WHERE user = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $personal_details = $result->fetch_assoc();
}
$stmt->close();

// Get professional details
$professional_details = array();
$query = "SELECT * FROM professional_details_cover WHERE user_email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $professional_details = $result->fetch_assoc();
}
$stmt->close();

// Get application specifics
$application_specifics = array();
$query = "SELECT * FROM application_specifics WHERE user_email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $application_specifics = $result->fetch_assoc();
}
$stmt->close();

// Generate current date
$current_date = date("F j, Y");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cover Letter Preview</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .cover-letter {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px;
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .header {
            margin-bottom: 30px;
        }
        .contact-info {
            margin-bottom: 20px;
        }
        .date {
            text-align: right;
            margin-bottom: 20px;
        }
        .company-address {
            margin-bottom: 20px;
        }
        .salutation {
            margin-bottom: 15px;
        }
        .paragraph {
            margin-bottom: 15px;
            text-align: justify;
        }
        .closing {
            margin-top: 30px;
        }
        .signature {
            margin-top: 50px;
        }
        .actions {
            margin-top: 30px;
            text-align: center;
        }
        .btn {
            padding: 10px 20px;
            margin: 0 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-print {
            background-color: #2196F3;
        }
        .btn-download {
            background-color: #ff9800;
        }
    </style>
</head>
<body>
    <div class="cover-letter">
        <div class="header">
        <h1><?php echo htmlspecialchars(isset($personal_details['name']) ? $personal_details['name'] : ''); ?></h1>
        <div class="contact-info">
            <?php echo htmlspecialchars(isset($personal_details['address']) ? $personal_details['address'] : ''); ?><br>
            Phone: <?php echo htmlspecialchars(isset($personal_details['phone']) ? $personal_details['phone'] : ''); ?><br>
            Email: <?php echo htmlspecialchars(isset($personal_details['email']) ? $personal_details['email'] : ''); ?><br>
            <?php if (!empty($personal_details['linkedin'])): ?>
                LinkedIn: <?php echo htmlspecialchars($personal_details['linkedin']); ?><br>
            <?php endif; ?>
            <?php if (!empty($personal_details['github'])): ?>
                GitHub: <?php echo htmlspecialchars($personal_details['github']); ?>
            <?php endif; ?>
        </div>

        </div>

        <div class="date">
            <?php echo $current_date; ?>
        </div>

        <div class="company-address">
            <?php if (!empty($application_specifics['hiring_manager'])): ?>
                <p><?php echo htmlspecialchars($application_specifics['hiring_manager']); ?><br>
            <?php endif; ?>
            <?php echo htmlspecialchars(isset($application_specifics['company_name']) ? $application_specifics['company_name'] : 'Hiring Manager'); ?>
            <br>
        </div>

        <div class="salutation">
            <p>Dear <?php echo !empty($application_specifics['hiring_manager']) ? htmlspecialchars($application_specifics['hiring_manager']) : 'Hiring Manager'; ?>,</p>
        </div>

        <div class="paragraph">
            <p>
                I am excited to apply for the 
                <?php echo htmlspecialchars(isset($application_specifics['position_applying_for']) ? $application_specifics['position_applying_for'] : 'position'); ?> 
                at 
                <?php echo htmlspecialchars(isset($application_specifics['company_name']) ? $application_specifics['company_name'] : 'your company'); ?>. 
                With 
                <?php echo htmlspecialchars(isset($professional_details['years_experience']) ? $professional_details['years_experience'] : 'several'); ?> 
                years of experience as a 
                <?php echo htmlspecialchars(isset($professional_details['current_job_title']) ? $professional_details['current_job_title'] : 'professional'); ?>, 
                I have developed the skills and expertise that make me a strong candidate for this role.
            </p>
        </div>

        <div class="paragraph">
            <p>
                In my current position, I have 
                <?php echo htmlspecialchars(isset($professional_details['notable_achievements']) ? $professional_details['notable_achievements'] : 'achieved significant results'); ?>. 
                My key skills include 
                <?php echo htmlspecialchars(isset($professional_details['key_skills']) ? $professional_details['key_skills'] : 'relevant skills for this position'); ?>.
            </p>
        </div>

        <div class="paragraph">
            <p>
                <?php echo htmlspecialchars(isset($personal_details['description']) ? $personal_details['description'] : 'I am particularly drawn to this opportunity because...'); ?>
            </p>
        </div>

        <div class="paragraph">
            <p>
                <?php echo !empty($application_specifics['job_source']) 
                    ? 'I learned about this opportunity through ' . htmlspecialchars($application_specifics['job_source']) . ' and' 
                    : 'I'; ?> 
                I am excited about the possibility of contributing to your team. I would welcome the opportunity to discuss how my experience and skills align with your needs.
            </p>
        </div>


        <div class="closing">
            <p>Sincerely,</p>
        </div>

        <div class="signature">
            <p><?php echo htmlspecialchars(isset($personal_details['name']) ? $personal_details['name'] : ''); ?>
            </p>
        </div>

        <div class="actions">
            <button onclick="window.print()" class="btn btn-print">Print Cover Letter</button>
            <a href="#" class="btn btn-download">Download as PDF</a>
        </div>
    </div>
</body>
</html>

<?php
    include('footer.php');
?>