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

// Get all experience records for this user
$query = $conn->prepare("SELECT * FROM experience_details WHERE user = ? ORDER BY start_date DESC");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();

// Fetch all experience records as array
$experience_records = array();
while ($row = $result->fetch_assoc()) {
    $experience_records[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Experience</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h2>Professional Experience</h2>
        <a href="../uexperience.php" class="add-new-btn">
            <i class="fas fa-plus"></i> Add New Experience
        </a>
        <?php if (empty($experience_records)): ?>
            <p>No experience records found in the database.</p>
        <?php else: ?>
            <table class="experience-table">
                <thead>
                    <tr>
                        <th>Company</th>
                        <th>Job Title</th>
                        <th>Duration</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($experience_records as $record): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($record['company_name']); ?></td>
                            <td><?php echo htmlspecialchars($record['job_title']); ?></td>
                            <td>
                                <?php 
                                    echo htmlspecialchars(date('M Y', strtotime($record['start_date'])));
                                    echo ' - ';
                                    if (!empty($record['end_date'])) {
                                        echo htmlspecialchars(date('M Y', strtotime($record['end_date'])));
                                    } else {
                                        echo 'Present';
                                    }
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($record['location']); ?></td>
                            <td>
                                <button class="edit-btn" onclick="openEditForm(<?php echo $record['id']; ?>)">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        
        <!-- Edit Form Modal -->
        <div id="editModal" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeEditForm()">&times;</span>
                <h3>Edit Professional Experience</h3>
                <form id="editForm" action="controller.php" method="POST">
                    <input type="hidden" id="experience_id" name="experience_id">
                    
                    <div class="form-group">
                        <label for="company_name">Company Name:</label>
                        <input type="text" id="company_name" name="company_name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="job_title">Job Title:</label>
                        <input type="text" id="job_title" name="job_title" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="start_date">Start Date:</label>
                        <input type="date" id="start_date" name="start_date" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="end_date">End Date:</label>
                        <input type="date" id="end_date" name="end_date">
                    </div>
                    
                    <div class="form-group">
                        <label>
                            <input type="checkbox" id="is_current" name="is_current">
                            I currently work here
                        </label>
                    </div>
                    
                    <div class="form-group">
                        <label for="location">Location:</label>
                        <input type="text" id="location" name="location">
                    </div>
                    
                    <div class="form-group">
                        <label for="job_description">Job Description:</label>
                        <textarea id="job_description" name="job_description" rows="4"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <input type="submit" name="update_experience" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        // Store experience records data in JavaScript for edit form
        const experienceData = <?php echo json_encode($experience_records); ?>;
        const modal = document.getElementById('editModal');
        
        // Function to open edit form modal with data
        function openEditForm(id) {
            // Find the record with matching ID
            const record = experienceData.find(item => item.id == id);
            
            if (record) {
                // Populate form fields
                document.getElementById('experience_id').value = record.id;
                document.getElementById('company_name').value = record.company_name;
                document.getElementById('job_title').value = record.job_title;
                document.getElementById('start_date').value = record.start_date;
                document.getElementById('end_date').value = record.end_date || '';
                document.getElementById('location').value = record.location || '';
                document.getElementById('job_description').value = record.job_description || '';
                
                // Handle is_current checkbox
                if (!record.end_date) {
                    document.getElementById('is_current').checked = true;
                    document.getElementById('end_date').disabled = true;
                } else {
                    document.getElementById('is_current').checked = false;
                    document.getElementById('end_date').disabled = false;
                }
                
                // Show modal
                modal.style.display = 'block';
            }
        }
        
        // Function to close edit form modal
        function closeEditForm() {
            modal.style.display = 'none';
        }
        
        // Close modal if user clicks outside of it
        window.onclick = function(event) {
            if (event.target == modal) {
                closeEditForm();
            }
        }
        
        // Handle is_current checkbox in edit form
        document.getElementById('is_current').addEventListener('change', function() {
            const endDateInput = document.getElementById('end_date');
            endDateInput.disabled = this.checked;
            if (this.checked) {
                endDateInput.value = '';
            }
        });
    </script>
</body>
</html>

<?php
    include('footer.php');
?>