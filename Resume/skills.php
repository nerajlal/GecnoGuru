<?php
include 'navbar.php';
require_once 'dbconnect.php';

session_start();

$email = $_SESSION['email'];
$conn = get_db_connection();

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

// Get all skills records for this user
$query = $conn->prepare("SELECT * FROM user_skills WHERE user = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();

// Fetch all skills records as array
$skills_records = array();
while ($row = $result->fetch_assoc()) {
    $skills_records[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skills and Expertise</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h2>Skills and Expertise</h2>
        <a href="../uskills.php" class="add-new-btn">
            <i class="fas fa-plus"></i> Add New Skill
        </a>
        <?php if (empty($skills_records)): ?>
            <p>No skills records found in the database.</p>
        <?php else: ?>
            <table class="skills-table">
                <thead>
                    <tr>
                        <th>Skill</th>
                        <th>Proficiency</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($skills_records as $record): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($record['skill']); ?></td>
                            <td><?php echo htmlspecialchars($record['proficiency']); ?></td>
                            <td><?php echo htmlspecialchars($record['skill_description']); ?></td>
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
                <h3>Edit Skill Details</h3>
                <form id="editForm" action="controller.php" method="POST">
                    <input type="hidden" id="skill_id" name="skill_id">
                    
                    <div class="form-group">
                        <label for="skill">Skill/Expertise:</label>
                        <input type="text" id="skill" name="skill" required placeholder="e.g., Python, Graphic Design">
                    </div>
                    
                    <div class="form-group">
                        <label for="proficiency">Proficiency Level:</label>
                        <select id="proficiency" name="proficiency" required>
                            <option value="">Select Proficiency</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Expert">Expert</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="skill_description">Description (Optional):</label>
                        <textarea id="skill_description" name="skill_description" rows="3" placeholder="Provide details about your skill"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <input type="submit" name="update_skill" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Store skills records data in JavaScript for edit form
        const skillsData = <?php echo json_encode($skills_records); ?>;
        const modal = document.getElementById('editModal');
        
        // Function to open edit form modal with data
        function openEditForm(id) {
            // Find the record with matching ID
            const record = skillsData.find(item => item.id == id);
            
            if (record) {
                // Populate form fields
                document.getElementById('skill_id').value = record.id;
                document.getElementById('skill').value = record.skill;
                document.getElementById('proficiency').value = record.proficiency;
                document.getElementById('skill_description').value = record.skill_description;
                
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