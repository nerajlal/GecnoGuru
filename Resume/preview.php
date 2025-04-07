<?php
session_start(); // Add this at the top of the file
include 'navbar.php';

// Ensure user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: personal.php");
    exit();
}

// Create database connection
$conn = new mysqli('localhost', 'root', '', 'resume_builder');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details
$user_email = $_SESSION['user_email'];

// Use prepared statements to prevent SQL injection
// Prepare and execute queries for each section
$personal_query = $conn->prepare("SELECT * FROM personal_details WHERE email = ?");
$personal_query->bind_param("s", $user_email);
$personal_query->execute();
$personal_result = $personal_query->get_result();

$education_query = $conn->prepare("SELECT * FROM education_details WHERE user = ?");
$education_query->bind_param("s", $user_email);
$education_query->execute();
$education_result = $education_query->get_result();

$experience_query = $conn->prepare("SELECT * FROM experience_details WHERE user = ?");
$experience_query->bind_param("s", $user_email);
$experience_query->execute();
$experience_result = $experience_query->get_result();

$projects_query = $conn->prepare("SELECT * FROM projects_details WHERE user = ?");
$projects_query->bind_param("s", $user_email);
$projects_query->execute();
$projects_result = $projects_query->get_result();

$hobbies_query = $conn->prepare("SELECT * FROM hobbies_details WHERE user = ?");
$hobbies_query->bind_param("s", $user_email);
$hobbies_query->execute();
$hobbies_result = $hobbies_query->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resume Preview</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="preview-container">
        <?php if ($personal_result->num_rows > 0): ?>
            <?php $personal = $personal_result->fetch_assoc(); ?>
            <div class="section personal-details">
                <h1><?php echo htmlspecialchars($personal['name']); ?></h1>
                <p>
                    <?php echo htmlspecialchars($personal['email']); ?> | 
                    <?php echo htmlspecialchars($personal['phone']); ?> | 
                    <?php echo htmlspecialchars($personal['job_role']); ?>
                </p>
                <p><?php echo htmlspecialchars($personal['description']); ?></p>
            </div>
        <?php endif; ?>

        <?php if ($education_result->num_rows > 0): ?>
            <div class="section education">
                <h2 class="section-title">Education</h2>
                <?php while ($education = $education_result->fetch_assoc()): ?>
                    <div>
                        <strong><?php echo htmlspecialchars($education['qualification']); ?></strong>
                        <p><?php echo htmlspecialchars($education['institute']); ?> 
                        (<?php echo htmlspecialchars($education['year_of_passout']); ?>)</p>
                        <p>Percentage: <?php echo htmlspecialchars($education['percentage']); ?>%</p>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

        <?php if ($experience_result->num_rows > 0): ?>
            <div class="section experience">
                <h2 class="section-title">Professional Experience</h2>
                <?php while ($experience = $experience_result->fetch_assoc()): ?>
                    <div>
                        <strong><?php echo htmlspecialchars($experience['job_title']); ?></strong>
                        <p><?php echo htmlspecialchars($experience['company_name']); ?> 
                        (<?php echo htmlspecialchars($experience['start_date']); ?> - 
                        <?php echo $experience['is_current'] ? 'Present' : htmlspecialchars($experience['end_date']); ?>)</p>
                        <p><?php echo htmlspecialchars($experience['job_description']); ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

        <?php if ($projects_result->num_rows > 0): ?>
            <div class="section projects">
                <h2 class="section-title">Projects</h2>
                <?php while ($project = $projects_result->fetch_assoc()): ?>
                    <div>
                        <strong><?php echo htmlspecialchars($project['project_name']); ?></strong>
                        <p><?php echo htmlspecialchars($project['technologies']); ?></p>
                        <p><?php echo htmlspecialchars($project['project_description']); ?></p>
                        <?php if (!empty($project['project_link'])): ?>
                            <p>Link: <a href="<?php echo htmlspecialchars($project['project_link']); ?>" target="_blank">
                                <?php echo htmlspecialchars($project['project_link']); ?>
                            </a></p>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

        <?php if ($hobbies_result->num_rows > 0): ?>
            <div class="section hobbies">
                <h2 class="section-title">Hobbies and Interests</h2>
                <?php while ($hobby = $hobbies_result->fetch_assoc()): ?>
                    <div>
                        <strong><?php echo htmlspecialchars($hobby['hobby']); ?></strong>
                        <?php if (!empty($hobby['hobby_description'])): ?>
                            <p><?php echo htmlspecialchars($hobby['hobby_description']); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <a href="generate_pdf.php" class="btn">Generate PDF Resume</a>
        </div>
    </div>
</body>
</html>
<?php
// Close prepared statements and connection
$personal_query->close();
$education_query->close();
$experience_query->close();
$projects_query->close();
$hobbies_query->close();
$conn->close();
?>

<?php
    include('footer.php');
?>