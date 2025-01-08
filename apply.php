<?php
session_start();
require 'includes/db.php'; // Include database connection

if (isset($_GET['t_id'])) {
    // Assign the t_id value to the session
    $_SESSION['t_id'] = $_GET['t_id'];

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data
        $t_id = $_SESSION['t_id'];
        $user_id = $_SESSION['g_user_id'];
        $name = $conn->real_escape_string($_POST['name']);
        $github_profile = $conn->real_escape_string($_POST['github_profile']);
        $skills = $conn->real_escape_string($_POST['skills']);
        $description = $conn->real_escape_string($_POST['description']);
        $whatsapp_number = $conn->real_escape_string($_POST['whatsappNumber']);

        // Insert data into the database
        $query = "INSERT INTO applications (t_id, user_id, name, github_profile, skills, description, whatsapp_number) 
                  VALUES ('$t_id', '$user_id', '$name', '$github_profile', '$skills', '$description', '$whatsapp_number')";

        if ($conn->query($query)) {
          echo "
            <script>
                alert('Application submitted successfully! Founder will contact you soon :)');
                setTimeout(function() {
                    window.location.href = 'index.php'; // Replace with your desired redirect URL
                }, 5000); // Redirect after 5 seconds
            </script> ";
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
  <title>Apply</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
        font-family: 'Inter', sans-serif;
    }
    .form-control, .form-select {
      border: none;
      border-bottom: 2px solid #ced4da; 
      border-radius: 0; 
      box-shadow: none; 
    }
    .form-control:focus, .form-select:focus {
      border-bottom-color: #007bff;
      box-shadow: none; 
    }
    textarea.form-control {
      resize: none; 
    }
    .form-card {
      max-width: 600px; 
      margin: auto; 
    }
  </style>
</head>
<body>
<?php include("includes/header.php"); ?>
<div class="container mt-5"> 
<?php
if (isset($_SESSION['g_user_id'])) {
    if (isset($success_message)) {
        echo "<div class='alert alert-success'>$success_message</div>";
    }
    if (isset($error_message)) {
        echo "<div class='alert alert-danger'>$error_message</div>";
    }
?>

<div class="card"> 
    <div class="card-header"> 
        <h3>Apply For Co-Founder</h3> 
    </div> 
    <div class="card-body"> 
        <form method="POST"> 
            <div class="mb-3"> 
                <label for="name" class="form-label">Your Name</label> 
                <input type="text" name="name" class="form-control" id="name" required> 
            </div> 
            <div class="mb-3"> 
                <label for="githubProfile" class="form-label">GitHub Profile</label> 
                <input type="text" name="github_profile" value="https://github.com/<?php echo $_SESSION['g_full_name']; ?>" class="form-control" id="githubProfile" readonly> 
            </div> 
            <div class="mb-3"> 
                <label for="skills" class="form-label">Skills</label> 
                <small class="text-muted">Separate skills with commas</small> 
                <input type="text" name="skills" class="form-control" id="skills" required> 
            </div> 
            <div class="mb-3">
                <label for="description" class="form-label fw-semibold">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe your skills" required></textarea>
            </div>
            <div class="mb-3"> 
                <label for="whatsappNumber" class="form-label">WhatsApp Number</label> 
                <input type="text" name="whatsappNumber" class="form-control" id="whatsappNumber" required> 
            </div> 
            <button type="submit" class="btn btn-primary">Apply Now</button> 
        </form> 
    </div> 
</div> 
<?php } else { ?>
<!--- Login open -->
<div class="card"> 
    <div class="card-header"> 
        <h3>Apply For Co-Founder</h3> 
    </div> 
    <div class="card-body"> 
        <div class="text-center mt-5">
            <a href="includes/github_login.php" class="btn btn-dark">
                <i class="bi bi-github"></i> Login with GitHub
            </a>
        </div>
    </div> 
</div> 
<!--- Login close -->
<?php } ?>
</div>
</body>
</html>
<?php
} else {
    // Redirect to another page if t_id is not set
    header("Location: index.php");
    exit();
}
?>
