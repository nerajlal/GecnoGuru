<?php
include ('navbar1.php');
include ('ucontroller.php');

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
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
    <div class="form-container">
        <form action="ucontroller.php" method="POST" id="hobbiesForm">
            <div id="hobbies-container">
                <div class="hobbies-entry">
                    <div class="form-group">
                        <label for="hobby_1">Hobby/Interest:</label>
                        <input type="text" id="hobby_1" name="hobby[]" required placeholder="e.g., Photography, Reading, Hiking">
                    </div>
                    
                    <div class="form-group">
                        <label for="hobby_description_1">Description (Optional):</label>
                        <textarea id="hobby_description_1" name="hobby_description[]" rows="3" placeholder="Tell us more about this hobby"></textarea>
                    </div>
                </div>
            </div>

            <button type="button" class="add-education-btn" id="addHobbyBtn">
                <i class="fas fa-plus-circle"></i> Add Another Hobby
            </button>
            
            <div class="form-group">
                <input type="submit" name="submit_hobbies_details" value="Save Hobbies">
            </div>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const hobbiesContainer = document.getElementById('hobbies-container');
        const addHobbyBtn = document.getElementById('addHobbyBtn');
        let hobbyCount = 1;

        addHobbyBtn.addEventListener('click', function() {
            hobbyCount++;
            
            // Create new hobby entry
            const newEntry = document.createElement('div');
            newEntry.classList.add('hobbies-entry');
            newEntry.innerHTML = `

                <br><hr><br>

                <div class="form-group">
                    <label for="hobby_${hobbyCount}">Hobby/Interest:</label>
                    <input type="text" id="hobby_${hobbyCount}" name="hobby[]" required placeholder="e.g., Photography, Reading, Hiking">
                </div>
                
                <div class="form-group">
                    <label for="hobby_description_${hobbyCount}">Description (Optional):</label>
                    <textarea id="hobby_description_${hobbyCount}" name="hobby_description[]" rows="3" placeholder="Tell us more about this hobby"></textarea>
                </div>

            `;
            
            hobbiesContainer.appendChild(newEntry);
        });
    });
    </script>
</body>
</html>

<?php
    include('footer.php');
?>