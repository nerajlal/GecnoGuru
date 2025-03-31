<?php
// preview.php
session_start();
include 'navbar.php';

if (!isset($_SESSION['email'])) {
    header("Location: personal.php");
    exit();
}

if (!isset($_SESSION['cover_letter'])) {
    header("Location: specifics.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cover Letter Preview</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .preview-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 40px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            line-height: 1.6;
            white-space: pre-line;
            font-family: 'Times New Roman', Times, serif;
            font-size: 16px;
        }
        
        .letter-actions {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        
        .btn-download {
            background-color: #4361ee;
            color: white;
        }
        
        .btn-download:hover {
            background-color: #3a56d4;
        }
        
        .btn-edit {
            background-color: #f8f9fa;
            color: #333;
            border: 1px solid #ddd;
        }
        
        .btn-edit:hover {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="preview-container">
        <?php echo nl2br(htmlspecialchars($_SESSION['cover_letter'])); ?>
        
        <div class="letter-actions">
            <button class="btn btn-download" onclick="window.print()">
                <i class="fas fa-print"></i> Print
            </button>
            <!-- <a href="specifics.php" class="btn btn-edit">
                <i class="fas fa-edit"></i> Edit
            </a> -->
            <button class="btn btn-download" id="downloadPdf">
                <i class="fas fa-file-pdf"></i> Download PDF
            </button>
        </div>
    </div>

    <script>
        document.getElementById('downloadPdf').addEventListener('click', function() {
            // This would require a PDF generation library or server-side processing
            alert('PDF generation would be implemented here with a library like jsPDF or a server-side solution');
        });
    </script>
</body>
</html>

<?php
    include('footer.php');
?>