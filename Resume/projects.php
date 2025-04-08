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

// Get all project records for this user
$query = $conn->prepare("SELECT * FROM projects_details WHERE user = ? ORDER BY start_date DESC");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();

// Fetch all project records as array
$project_records = array();
while ($row = $result->fetch_assoc()) {
    $project_records[] = $row;
}

$conn->close();
?>

    <div class="container">
        <h2>Project Details</h2>
        <a href="../uprojects.php" class="add-new-btn">
            <i class="fas fa-plus"></i> Add New Project
        </a>
        <?php if (empty($project_records)): ?>
            <p>No project records found in the database.</p>
        <?php else: ?>
            <table class="projects-table">
                <thead>
                    <tr>
                        <th>Project Name</th>
                        <th>Technologies</th>
                        <th>Duration</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($project_records as $record): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($record['project_name']); ?></td>
                            <td><?php echo htmlspecialchars($record['technologies']); ?></td>
                            <td>
                                <?php 
                                    if (!empty($record['start_date'])) {
                                        echo htmlspecialchars(date('M Y', strtotime($record['start_date'])));
                                    } else {
                                        echo 'N/A';
                                    }
                                    echo ' - ';
                                    if (!empty($record['end_date'])) {
                                        echo htmlspecialchars(date('M Y', strtotime($record['end_date'])));
                                    } else {
                                        echo 'Present';
                                    }
                                ?>
                            </td>
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
                <h3>Edit Project Details</h3>
                <form id="editForm" action="controller.php" method="POST">
                    <input type="hidden" id="project_id" name="project_id">
                    
                    <div class="form-group">
                        <label for="project_name">Project Name:</label>
                        <input type="text" id="project_name" name="project_name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="project_description">Project Description:</label>
                        <textarea id="project_description" name="project_description" rows="4" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="technologies">Technologies Used:</label>
                        <input type="text" id="technologies" name="technologies" placeholder="e.g., React, Node.js, Python">
                    </div>
                    
                    <div class="form-group">
                        <label for="project_link">Project Link (Optional):</label>
                        <input type="url" id="project_link" name="project_link" placeholder="GitHub, Live Demo, etc.">
                    </div>
                    
                    <div class="form-group">
                        <label for="start_date">Start Date:</label>
                        <input type="date" id="start_date" name="start_date">
                    </div>
                    
                    <div class="form-group">
                        <label for="end_date">End Date:</label>
                        <input type="date" id="end_date" name="end_date">
                    </div>
                    
                    <div class="form-group">
                        <input type="submit" name="update_project" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Store project records data in JavaScript for edit form
        const projectData = <?php echo json_encode($project_records); ?>;
        const modal = document.getElementById('editModal');
        
        // Function to open edit form modal with data
        function openEditForm(id) {
            // Find the record with matching ID
            const record = projectData.find(item => item.id == id);
            
            if (record) {
                // Populate form fields
                document.getElementById('project_id').value = record.id;
                document.getElementById('project_name').value = record.project_name;
                document.getElementById('project_description').value = record.project_description;
                document.getElementById('technologies').value = record.technologies || '';
                document.getElementById('project_link').value = record.project_link || '';
                document.getElementById('start_date').value = record.start_date || '';
                document.getElementById('end_date').value = record.end_date || '';
                
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