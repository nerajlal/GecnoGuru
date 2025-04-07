<?php
include ('navbar.php');
?>

<?php
require_once ('dbconnect.php');

session_start();
$email = $_SESSION['email'];
$conn = get_db_connection();

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

// Get all education records for this user
$query = $conn->prepare("SELECT * FROM education_details WHERE user = ? ORDER BY year_of_passout DESC");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();

// Fetch all education records as array
$education_records = array();
while ($row = $result->fetch_assoc()) {
    $education_records[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Education Details</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h2>Education Details</h2>
        <a href="../ueducation.php" class="add-new-btn">
            <i class="fas fa-plus"></i> Add New Education
        </a>
        <?php if (empty($education_records)): ?>
            <p>No education records found in the database.</p>
        <?php else: ?>
            <table class="education-table">
                <thead>
                    <tr>
                        <th>Qualification</th>
                        <th>Institute</th>
                        <th>Year of Completion</th>
                        <th>Percentage/CGPA</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($education_records as $record): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($record['qualification']); ?></td>
                            <td><?php echo htmlspecialchars($record['institute']); ?></td>
                            <td><?php echo htmlspecialchars($record['year_of_passout']); ?></td>
                            <td><?php echo htmlspecialchars($record['percentage']); ?>%</td>
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
                <h3>Edit Education Details</h3>
                <form id="editForm" action="controller.php" method="POST">
                    <input type="hidden" id="education_id" name="education_id">
                    
                    <div class="form-group">
                        <label for="qualification">Qualification:</label>
                        <select id="qualification" name="qualification" required>
                            <option value="">Select Qualification</option>
                            <option value="High School">High School</option>
                            <option value="Diploma">Diploma</option>
                            <option value="Bachelor's">Bachelor's</option>
                            <option value="Master's">Master's</option>
                            <option value="PhD">PhD</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="institute">Institute:</label>
                        <input type="text" id="institute" name="institute" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="year_of_passout">Year of Completion:</label>
                        <input type="number" id="year_of_passout" name="year_of_passout" min="1900" max="2099" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="percentage">Percentage/CGPA:</label>
                        <input type="number" id="percentage" name="percentage" min="0" max="100" step="0.01" required>
                    </div>
                    
                    <div class="form-group">
                        <input type="submit" name="update_education" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Store education records data in JavaScript for edit form
        const educationData = <?php echo json_encode($education_records); ?>;
        const modal = document.getElementById('editModal');
        
        // Function to open edit form modal with data
        function openEditForm(id) {
            // Find the record with matching ID
            const record = educationData.find(item => item.id == id);
            
            if (record) {
                // Populate form fields
                document.getElementById('education_id').value = record.id;
                document.getElementById('qualification').value = record.qualification;
                document.getElementById('institute').value = record.institute;
                document.getElementById('year_of_passout').value = record.year_of_passout;
                document.getElementById('percentage').value = record.percentage;
                
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
    </script>
</body>
</html>

<?php
    include('footer.php');
?>