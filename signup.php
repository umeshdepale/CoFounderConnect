<?php
session_start(); 


if (isset($_SESSION['user_id'])) {
    header("Location: dashboard"); 
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
  <title>Sign Up</title>
  <link href="static/style.css" rel="stylesheet">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
<?php include("includes/header.php");  ?>
<body class="">
  <div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px;">
      <!-- Logo (optional) -->
      <div class="text-center mb-3">
        <img src="https://w7.pngwing.com/pngs/505/761/png-transparent-login-computer-icons-avatar-icon-monochrome-black-silhouette.png"  width="20%" height="20%" alt="Logo" class="rounded-circle">
      </div>

      <!-- Title -->
      <h3 class="text-center mb-4">Create an account</h3>
      <div id="responseMessage"></div>
      <!-- Login Form -->
      <form id="signupForm">
      <div class="mb-3">
          <label for="name" class="form-label">Name</label>
          <input type="name" class="form-control" id="name" name="name" placeholder="Enter your name" required>
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
        </div>
        <input type="hidden" name="signup" value="1">
        <button type="submit" class="btn btn-primary w-100">Sign Up</button>
      </form>

      <!-- Signup Link -->
      <p class="text-center mt-3">
        Already have an account? <a href="login.php" class="text-primary">Login</a>
      </p>
    </div>
  </div>

  <script>
  $(document).ready(function () {
    $('#signupForm').on('submit', function (e) {
      e.preventDefault();

      $.ajax({
        url: 'includes/auth.php', 
        type: 'POST',
        data: $(this).serialize(),
        success: function (response) {
          if (response.trim() === "success") {
            // Redirect to the dashboard
            window.location.href = "dashboard";
          } else {
            // Show error message
            $('#responseMessage').html('<div class="alert alert-danger">' + response + '</div>');
          }
        },
        error: function () {
          // Show error message
          $('#responseMessage').html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
        }
      });
    });
  });
</script>

</body>
</html>


