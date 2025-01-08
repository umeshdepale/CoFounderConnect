<?php
session_start();
require '../includes/db.php'; // Include the database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Redirect to login if not logged in
    exit();
}

// Initialize variables for editing
$isEdit = false;
$title = $description = $skills = $country = $equity = $salary = "";

// Check if an ID is provided in the URL for editing
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "SELECT * FROM jobs WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $title = $row['title'];
        $description = $row['job_description'];
        $skills = $row['skills_required'];
        $country = $row['location'];
        $equity = $row['equity_offered'];
        $salary = $row['salary'];
        $isEdit = true;
    } else {
        echo "Invalid ID or you don't have permission to edit this listing.";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en"  data-bs-theme="dark">
<head>
  <title><?php echo $isEdit ? "Edit Project" : "Post Project"; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
<?php include("../includes/header.php");  ?>
<div class="container mt-5">
    <div class="card shadow-lg p-4 form-card">
      <h3 class="fw-bold mb-4"><?php echo $isEdit ? "Edit Listing" : "Post New Listing"; ?></h3>
      <div id="responseMessage" class="mt-3"></div>
      <form id="postProjectForm">
        <input type="hidden" name="id" value="<?php echo $isEdit ? $id : ''; ?>">

        <!-- Project Title -->
        <div class="mb-3">
          <label for="title" class="form-label fw-semibold">Listing Title</label>
          <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" placeholder="Enter listing title" required>
        </div>

        <!-- Description -->
        <div class="mb-3">
          <label for="description" class="form-label fw-semibold">Description</label>
          <textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe your listing" required><?php echo htmlspecialchars($description); ?></textarea>
        </div>

        <!-- Required Skills -->
        <div class="mb-3">
          <label for="skills" class="form-label fw-semibold">Required Skills</label>
          <input type="text" class="form-control" id="skills" name="skills" value="<?php echo htmlspecialchars($skills); ?>" placeholder="Separate skills with commas" required>
        </div>

        <!-- Country Selector -->
        <div class="mb-3">
          <label for="country" class="form-label fw-semibold">Country</label>
          <select class="form-select" id="country" name="country" required>
            <option value="" disabled>Select your country</option>
            <option value="United States" <?php echo $country == "United States" ? "selected" : ""; ?>>United States</option>
            <option value="Canada" <?php echo $country == "Canada" ? "selected" : ""; ?>>Canada</option>
            <option value="United Kingdom" <?php echo $country == "United Kingdom" ? "selected" : ""; ?>>United Kingdom</option>
            <option value="Australia" <?php echo $country == "Australia" ? "selected" : ""; ?>>Australia</option>
            <option value="India" <?php echo $country == "India" ? "selected" : ""; ?>>India</option>
          </select>
        </div>

        <!-- Equity and Monthly Salary -->
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="equity" class="form-label fw-semibold">Equity Offered (%)</label>
              <input type="text" class="form-control" id="equity" name="equity" value="<?php echo htmlspecialchars($equity); ?>" placeholder="Enter equity offered">
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="salary" class="form-label fw-semibold">Monthly Salary</label>
              <input type="text" class="form-control" id="salary" name="salary" value="<?php echo htmlspecialchars($salary); ?>" placeholder="Enter monthly salary">
            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary w-100"><?php echo $isEdit ? "Update Project" : "Post Project"; ?></button>
      </form>
    </div>
  </div>

<script>
$(document).ready(function () {
    $('#postProjectForm').on('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        // Serialize the form data
        const formData = $(this).serialize();

        // Send the data to the server using AJAX
        $.ajax({
            url: '../includes/save_project.php', // The PHP file that handles saving/updating the data
            type: 'POST',
            data: formData,
            success: function (response) {
                // Display the response message
                $('#responseMessage').html('<div class="alert alert-success">' + response + '</div>');
                if (!formData.includes('id=')) $('#postProjectForm')[0].reset(); // Reset form for new projects
            },
            error: function () {
                // Handle errors
                $('#responseMessage').html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
            }
        });
    });
});
</script>
</body>
</html>
