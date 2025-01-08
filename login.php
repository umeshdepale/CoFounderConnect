<?php
session_start(); 


if (isset($_SESSION['user_id'])) {
    header("Location: dashboard"); 
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="en"  data-bs-theme="dark">
<head>
  <title>Login</title>
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
      <h3 class="text-center mb-4">Login</h3>
      <div id="loginResponse" class="mt-3"></div>
      <!-- Login Form -->
      <form id="loginForm">
        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <input type="checkbox" id="remember" class="form-check-input">
            <label for="remember" class="form-check-label">Remember me</label>
          </div>
          <a href="#" class="text-decoration-none">Forgot password?</a>
        </div>
        <input type="hidden" name="login" value="1">
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>
            <!-- Signup Link -->
      <p class="text-center mt-3">
        Don't have an account? <a href="signup.php" class="text-primary">Sign up here</a>
      </p>
    </div>
  </div>
  <script>
  $(document).ready(function () {
    $('#loginForm').on('submit', function (e) {
      e.preventDefault();

      // Send AJAX request
      $.ajax({
        url: 'includes/auth.php', 
        type: 'POST',
        data: $(this).serialize(),
        success: function (response) {
          if (response.trim() === "success") {
            // Redirect to dashboard
            window.location.href = "dashboard";
          } else {
            // Show error message
            $('#loginResponse').html('<div class="alert alert-danger">' + response + '</div>');
          }
        },
        error: function () {
          // Show error message
          $('#loginResponse').html('<div class="alert alert-danger">An error occurred. Please try again.</div>');
        }
      });
    });
  });
</script>

</body>
</html>


