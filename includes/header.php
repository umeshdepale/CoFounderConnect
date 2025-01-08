<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container-fluid">
    <!-- Brand -->
    <a class="navbar-brand fw-bold" href="#">
      CoFounder Connect
    </a>

    <!-- Toggler Button -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible Navbar -->
    <div class="collapse navbar-collapse" id="navbarContent">
      <!-- Links -->
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="https://umeshdepale.com/cofounder">Browse Listing</a>
        </li>
      </ul>

      <!-- Dynamic Buttons -->
      <div class="d-flex ms-3">
        <?php if (isset($_SESSION['user_id'])): ?>
          <!-- Show if the user is logged in -->
          <div class="collapse navbar-collapse" id="navbarContent">
      <!-- Links -->
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="https://umeshdepale.com/cofounder/dashboard/index.php">My Listing</a>
        </li>
      </ul>
          <a href="https://umeshdepale.com/cofounder/dashboard/manage.php" class="btn btn-light text-dark me-2">
            <i class="bi bi-person-circle me-1"></i> Manage Listing
          </a>
          <a href="https://umeshdepale.com/cofounder/dashboard/post_project.php" class="btn btn-warning">
            <i class="bi bi-file-earmark-plus me-1"></i> Post Listing
          </a>
            <a href="https://umeshdepale.com/cofounder/includes/logout.php">
             <button class="btn"><i class="fa fa-sign-out"></i></button>
          </a>
           
        <?php else: ?>
          <!-- Show if the user is not logged in -->
          <a href="login.php" class="btn btn-outline-light me-2">Login</a>
          <a href="signup.php" class="btn btn-primary">Sign Up</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
