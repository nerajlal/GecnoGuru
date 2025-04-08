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

// Get all achievements records for this user
$query = $conn->prepare("SELECT * FROM user_achievements WHERE user = ? ORDER BY achievement_date DESC");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();

// Fetch all achievements records as array
$achievements_records = array();
while ($row = $result->fetch_assoc()) {
    $achievements_records[] = $row;
}

$conn->close();
?>

    <div class="container">
        <h2>Achievements</h2>
        <a href="../uachievements.php" class="add-new-btn">
            <i class="fas fa-plus"></i> Add New Achievement
        </a>
        <?php if (empty($achievements_records)): ?>
            <p class="no-records">No achievements records found in the database.</p>
        <?php else: ?>
            <table class="skills-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Organization</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($achievements_records as $record): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($record['achievement']); ?></td>
                            <td><?php echo htmlspecialchars($record['organization']); ?></td>
                            <td><?php echo htmlspecialchars($record['achievement_date']); ?></td>
                            <td><?php echo htmlspecialchars($record['achievement_description']); ?></td>
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
                <h3>Edit Achievement Details</h3>
                <form id="editForm" action="controller.php" method="POST">
                    <input type="hidden" id="achievement_id" name="achievement_id">
                    
                    <div class="form-group">
                        <label for="achievement">Achievement Title:</label>
                        <input type="text" id="achievement" name="achievement" required placeholder="e.g., Employee of the Month">
                    </div>
                    
                    <div class="form-group">
                        <label for="organization">Organization/Issuer:</label>
                        <input type="text" id="organization" name="organization" placeholder="e.g., Company Name">
                    </div>
                    
                    <div class="form-group">
                        <label for="achievement_date">Date:</label>
                        <input type="date" id="achievement_date" name="achievement_date">
                    </div>
                    
                    <div class="form-group">
                        <label for="achievement_description">Description (Optional):</label>
                        <textarea id="achievement_description" name="achievement_description" rows="3" placeholder="Describe your achievement"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <input type="submit" name="update_achievement" value="Update" class="submit-btn">
                        <!-- <button type="button" onclick="closeEditForm()" class="cancel-btn">Cancel</button> -->
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Store achievements records data in JavaScript for edit form
        const achievementsData = <?php echo json_encode($achievements_records); ?>;
        const modal = document.getElementById('editModal');
        
        // Function to open edit form modal with data
        function openEditForm(id) {
            // Find the record with matching ID
            const record = achievementsData.find(item => item.id == id);
            
            if (record) {
                // Populate form fields
                document.getElementById('achievement_id').value = record.id;
                document.getElementById('achievement').value = record.achievement;
                document.getElementById('organization').value = record.organization;
                document.getElementById('achievement_date').value = record.achievement_date;
                document.getElementById('achievement_description').value = record.achievement_description;
                
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


<?php
    include('footer.php');
?>