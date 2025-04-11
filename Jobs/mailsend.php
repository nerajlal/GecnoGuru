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
include('navbar.php');
include('dbconnect.php');

// Fetch user details from database
$query = "SELECT * FROM personal_details WHERE user = '$email'";
$result = mysqli_query($conn, $query);

// Check if user details exist
if ($result && mysqli_num_rows($result) > 0) {
    $userData = mysqli_fetch_assoc($result);
    $applicantName = isset($userData['name']) ? $userData['name'] : "";
    $phone = isset($userData['phone']) ? $userData['phone'] : "";
    $userEmail = isset($userData['email']) ? $userData['email'] : $email; // Default to session email if not in personal_details
} else {
    // Default values if no data is found
    $applicantName = "";
    $phone = "";
    $userEmail = $email;
}
?>

<style>
    .form-container {
        background: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 90%;
        margin: 50px auto; /* This adds top spacing and centers horizontally */
    }

    h2 {
        margin-bottom: 15px;
        text-align: center;
        color: #333;
    }

    label {
        display: block;
        margin: 10px 0 5px;
        color: #555;
        font-weight: bold;
    }

    input, select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
    }

    button {
        width: 100%;
        padding: 10px;
        background: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background: #0056b3;
    }
</style>

<div class="form-container">
    <form id="jobApplicationForm">
        <h2>Job Application</h2>
        
        <label for="company_name">Company Name:</label>
        <input type="text" id="company_name" name="company_name" required>

        <label for="position">Position:</label>
        <select id="position" name="position" required>
            <option value="Full Stack Developer - Java">Full Stack Developer - Java</option>
            <option value="Software Engineer">Software Engineer</option>
            <option value="Frontend Developer">Frontend Developer</option>
            <option value="Backend Developer">Backend Developer</option>
            <option value="PHP Developer">PHP Developer</option>
            <option value="Java Developer">Java Developer</option>
            <option value="Web Developer">Web Developer</option>
        </select>

        <label for="hr_email">HR Email:</label>
        <input type="email" id="hr_email" name="hr_email" required>

        <button type="button" onclick="sendApplication()">Open in Gmail</button>
    </form>
</div>

<script>
    // Pass PHP variables to JavaScript
    const applicantName = "<?php echo addslashes($applicantName); ?>";
    const phone = "<?php echo addslashes($phone); ?>";
    const userEmail = "<?php echo addslashes($userEmail); ?>";
    
    async function sendApplication() {
        const companyName = document.getElementById('company_name').value;
        const position = document.getElementById('position').value;
        const hrEmail = document.getElementById('hr_email').value;

        const subject = `Application for ${position} position`;
        const body = `Dear Hiring Team at ${companyName},\n\n` +
                    `I am excited to apply for the ${position} position at your esteemed organization. ` +
                    `With a solid foundation and combined with a keen understanding of front-end and back-end development, I am eager to contribute to ${companyName}'s innovative projects.\n` +
                    `My hands-on experience includes creating dynamic web applications and working collaboratively in team environments. ` +
                    `I am confident that my technical skills and enthusiasm for learning will enable me to excel in this role.\n\n` +
                    `I look forward to the opportunity to discuss how my skills and aspirations align with your team's goals.\n` +
                    `I have attached my resume for your review and would welcome the opportunity to discuss how my skills and experiences align with your team's goals.\n\nThank you for considering my application, and I look forward to the possibility of contributing to ${companyName}'s success.\n` +
                    `Best regards,\n` +
                    `${applicantName}\n` +
                    `Phone: ${phone}\n` +
                    `Email: ${userEmail}`;

        try {
            const gmailUrl = `https://mail.google.com/mail/?view=cm&fs=1&to=${encodeURIComponent(hrEmail)}` +
                           `&su=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
            window.open(gmailUrl, '_blank');
        } catch (error) {
            console.error('Error sending application:', error);
        }
    }
</script>

<?php include('footer.php') ?>