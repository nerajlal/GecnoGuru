<?php
include ('navbar.php');
include ('controller.php');
include_once('dbconnect.php');

$user_email = $_SESSION['email'];

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

// Get existing personal details if available
$personal_details = array();
if (isset($_SESSION['email'])) {
    $conn = get_db_connection();
    $stmt = $conn->prepare("SELECT * FROM personal_details WHERE user = ?");
    $stmt->bind_param("s", $_SESSION['email']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $personal_details = $result->fetch_assoc();
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <form action="controller.php" method="POST">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" 
                       value="<?php echo isset($personal_details['name']) ? htmlspecialchars($personal_details['name']) : ''; ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" 
                       value="<?php echo isset($personal_details['email']) ? htmlspecialchars($personal_details['email']) : ''; ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" 
                       value="<?php echo isset($personal_details['phone']) ? htmlspecialchars($personal_details['phone']) : ''; ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea id="address" name="address" rows="3"><?php 
                    echo isset($personal_details['address']) ? htmlspecialchars($personal_details['address']) : ''; 
                ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="github">GitHub Profile:</label>
                <input type="url" id="github" name="github" 
                       value="<?php echo isset($personal_details['github']) ? htmlspecialchars($personal_details['github']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="linkedin">LinkedIn Profile:</label>
                <input type="url" id="linkedin" name="linkedin" 
                       value="<?php echo isset($personal_details['linkedin']) ? htmlspecialchars($personal_details['linkedin']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="job_role">Job Role:</label>
                <input type="text" id="job_role" name="job_role" 
                       value="<?php echo isset($personal_details['job_role']) ? htmlspecialchars($personal_details['job_role']) : ''; ?>">
            </div>
            
            <div class="form-group">
                <label for="description">Professional Description:</label>
                <textarea id="description" name="description" rows="5"><?php 
                    echo isset($personal_details['description']) ? htmlspecialchars($personal_details['description']) : ''; 
                ?></textarea>
            </div>
            
            <div class="form-group">
                <input type="submit" name="submit_personal_details" value="<?php 
                    echo isset($personal_details['email']) ? 'Update Personal Details' : 'Save Personal Details'; 
                ?>">
            </div>
        </form>
    </div>
</body>
</html>

<?php
    include('footer.php');
?>