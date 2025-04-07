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
    <title>Achievements</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
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
</body>
</html>

<?php
    include('footer.php');
?>