<?php
session_start();
require 'db.php'; // Include the database connection

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to post or edit a project.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the data from the POST request
    $user_id = $_SESSION['user_id'];
    $name = $_SESSION['full_name'];
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $skills = $conn->real_escape_string($_POST['skills']);
    $country = $conn->real_escape_string($_POST['country']);
    $equity = $conn->real_escape_string($_POST['equity']);
    $salary = $conn->real_escape_string($_POST['salary']);

    // Check if this is an edit request
    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Edit existing project
        $id = intval($_POST['id']);
        $query = "UPDATE jobs 
                  SET title = '$title', 
                      job_description = '$description', 
                      skills_required = '$skills', 
                      location = '$country', 
                      equity_offered = '$equity', 
                      salary = '$salary', 
                      created_at = NOW() 
                  WHERE id = '$id' AND user_id = '$user_id'";

        if ($conn->query($query)) {
            echo "Project updated successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        // Insert a new project
        $query = "INSERT INTO jobs (user_id, full_name, title, job_description, skills_required, equity_offered, salary, location, created_at) 
                  VALUES ('$user_id', '$name', '$title', '$description', '$skills', '$equity', '$salary', '$country', NOW())";

        if ($conn->query($query)) {
            echo "Project posted successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    }
} else {
    echo "Invalid request method.";
}

$conn->close();
?>
