<?php
include ('navbar.php');
require_once ('dbconnect.php');

session_start();

$email = $_SESSION['email'];
$conn = get_db_connection();

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../index.php");
    exit();
}

// Get all hobbies records for this user
$query = $conn->prepare("SELECT * FROM hobbies_details WHERE user = ?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();

// Fetch all hobbies records as array
$hobbies_records = array();
while ($row = $result->fetch_assoc()) {
    $hobbies_records[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hobbies and Interests</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <h2>Hobbies and Interests</h2>
        <a href="../uhobbies.php" class="add-new-btn">
            <i class="fas fa-plus"></i> Add New Hobby
        </a>
        <?php if (empty($hobbies_records)): ?>
            <p class="no-records">No hobbies records found in the database.</p>
        <?php else: ?>
            <table class="skills-table">
                <thead>
                    <tr>
                        <th>Hobby/Interest</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($hobbies_records as $record): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($record['hobby']); ?></td>
                            <td><?php echo htmlspecialchars($record['hobby_description']); ?></td>
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
                <h3>Edit Hobby Details</h3>
                <form id="editForm" action="controller.php" method="POST">
                    <input type="hidden" id="hobby_id" name="hobby_id">
                    
                    <div class="form-group">
                        <label for="hobby">Hobby/Interest:</label>
                        <input type="text" id="hobby" name="hobby" required placeholder="e.g., Photography, Reading">
                    </div>
                    
                    <div class="form-group">
                        <label for="hobby_description">Description (Optional):</label>
                        <textarea id="hobby_description" name="hobby_description" rows="3" placeholder="Tell us more about this hobby"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <input type="submit" name="update_hobby" value="Update" class="submit-btn">
                        <!-- <button type="button" onclick="closeEditForm()" class="cancel-btn">Cancel</button> -->
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Store hobbies records data in JavaScript for edit form
        const hobbiesData = <?php echo json_encode($hobbies_records); ?>;
        const modal = document.getElementById('editModal');
        
        // Function to open edit form modal with data
        function openEditForm(id) {
            // Find the record with matching ID
            const record = hobbiesData.find(item => item.id == id);
            
            if (record) {
                // Populate form fields
                document.getElementById('hobby_id').value = record.id;
                document.getElementById('hobby').value = record.hobby;
                document.getElementById('hobby_description').value = record.hobby_description;
                
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