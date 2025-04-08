<?php
// Start the session first
session_start();

// Ensure user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Get user email
$user_email = $_SESSION['email'];

// Include the navbar after session check
include('navbar1.php');
?>

<div class="form-container">
    <form action="ucontroller.php" method="POST" id="achievementsForm">
        <div id="achievements-container">
            <div class="achievements-entry">
                <div class="form-group">
                    <label for="achievement_1">Achievement Title:</label>
                    <input type="text" id="achievement_1" name="achievement[]" required placeholder="e.g., Employee of the Month, Competition Winner, Award">
                </div>
                
                <div class="form-group">
                    <label for="achievement_organization_1">Organization/Issuer:</label>
                    <input type="text" id="achievement_organization_1" name="achievement_organization[]" placeholder="e.g., Company Name, University, Competition">
                </div>
                
                <div class="form-group">
                    <label for="achievement_date_1">Date:</label>
                    <input type="date" id="achievement_date_1" name="achievement_date[]">
                </div>
                
                <div class="form-group">
                    <label for="achievement_description_1">Description (Optional):</label>
                    <textarea id="achievement_description_1" name="achievement_description[]" rows="3" placeholder="Describe your achievement and its significance"></textarea>
                </div>
            </div>
        </div>

        <button type="button" class="add-education-btn" id="addAchievementBtn">
            <i class="fas fa-plus-circle"></i> Add Another Achievement
        </button>
        
        <div class="form-group">
            <input type="submit" name="submit_achievement_details" value="Save Achievements">
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const achievementsContainer = document.getElementById('achievements-container');
    const addAchievementBtn = document.getElementById('addAchievementBtn');
    let achievementCount = 1;

    addAchievementBtn.addEventListener('click', function() {
        achievementCount++;
        
        // Create new achievement entry
        const newEntry = document.createElement('div');
        newEntry.classList.add('achievements-entry');
        newEntry.innerHTML = `
            <br><hr><br>

            <div class="form-group">
                <label for="achievement_${achievementCount}">Achievement Title:</label>
                <input type="text" id="achievement_${achievementCount}" name="achievement[]" required placeholder="e.g., Employee of the Month, Competition Winner, Award">
            </div>
            
            <div class="form-group">
                <label for="achievement_organization_${achievementCount}">Organization/Issuer:</label>
                <input type="text" id="achievement_organization_${achievementCount}" name="achievement_organization[]" placeholder="e.g., Company Name, University, Competition">
            </div>
            
            <div class="form-group">
                <label for="achievement_date_${achievementCount}">Date:</label>
                <input type="date" id="achievement_date_${achievementCount}" name="achievement_date[]">
            </div>
            
            <div class="form-group">
                <label for="achievement_description_${achievementCount}">Description (Optional):</label>
                <textarea id="achievement_description_${achievementCount}" name="achievement_description[]" rows="3" placeholder="Describe your achievement and its significance"></textarea>
            </div>
        `;
        
        achievementsContainer.appendChild(newEntry);
    });
});
</script>

<?php
include('footer.php');
?>