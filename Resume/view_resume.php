<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    die("Please log in to view your resume.");
}

// Validate the requested format
$allowed_formats = array(
    'classic_professional', 
    'technical_minimalist', 
    'corporate_clean', 
    'creative_timeline', 
    'modern_infographic', 
    'academic_research', 
    'startup_pitch', 
    'minimalist_portfolio',
    'two_column_compact',
    'bold_creative'
);
$requested_format = isset($_GET['format']) ? $_GET['format'] : '';

if (!in_array($requested_format, $allowed_formats)) {
    die("Invalid resume format requested.");
}

$resume_file = 'resume_formats/' . $requested_format . '_resume.html';

if (!file_exists($resume_file)) {
    die("Resume file not found. Please generate your resumes first.");
}

// Output the resume HTML directly
readfile($resume_file);
?>  