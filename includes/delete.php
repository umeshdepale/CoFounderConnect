<?php
session_start();
require 'db.php'; // Include the database connection

if(isset($_GET['id'])){
          
    $id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Prepare and execute the delete query
    $query = "DELETE FROM jobs WHERE id = $id AND user_id = $user_id";

    if (mysqli_query($conn, $query)) {
        header("Location: ../dashboard/index.php?message=Project deleted successfully");
    } else {
        echo "Error: Could not delete the project. " . mysqli_error($conn);
    }

    mysqli_close($conn);
    exit();
}else{
    header("Location: ../dashboard"); 
}