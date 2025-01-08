<?php
session_start();
require '../includes/db.php'; // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Redirect to login if not logged in
    exit();
}
$user_id = $_SESSION['user_id'];
// Fetch projects from the database
$query = "SELECT * FROM jobs WHERE user_id='$user_id' ORDER BY created_at DESC";
$result = $conn->query($query);
?>
<html lang="en"  data-bs-theme="dark">
<head>
  <title><?php echo $_SESSION['full_name']; ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    .project-container {
      max-width: 1200px;
      margin: 0 auto;
    }
    .project-card {
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .project-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 25px rgba(0, 0, 0, 0.1);
    }
    .salary-icon {
      width: 20px;
      height: 20px;
      margin-right: 5px;
    }
    .badge-equity {
      font-size: 0.8rem;
    }
    .card-title {
      font-size: 1rem;
      font-weight: 600;
    }
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
</head>
<body>
<?php include("../includes/header.php"); ?>
<div class="container project-container mt-5">
  <!-- Show message -->
    <h2 class="mb-4 text-center">Your Listing</h2>
    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($_GET['message']); ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php endif; ?>

    <div class="row row-cols-1 row-cols-md-2 g-4">
      <?php
      if ($result->num_rows > 0):
          while ($row = $result->fetch_assoc()):
              $description = htmlspecialchars($row['job_description']);
              $short_description = implode(' ', array_slice(explode(' ', $description), 0, 20));
      ?>
      <div class="col">
        <div class="card project-card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">
              <b><?php echo htmlspecialchars($row['title']); ?></b>
              <span class="badge bg-success badge-equity" style="float:right">
                <?php echo htmlspecialchars($row['equity_offered']); ?>% Equity
              </span>
            </h5>
            <p class="card-text"><strong>Posted by:</strong> <?php echo htmlspecialchars($row['full_name']); ?></p>
            <p class="card-text"><?php echo $short_description; ?> <button class="btn btn-link p-0 text-primary" data-bs-toggle="modal" data-bs-target="#descriptionModal<?php echo $row['id']; ?>">
              <small>Read More</small>
            </button></p>
            
            <span class="badge bg-primary" style="  text-transform: capitalize;"><?php echo htmlspecialchars($row['skills_required']); ?></span>
            <div class="d-flex align-items-center mt-3">
              <img src="https://cdn-icons-png.flaticon.com/512/261/261778.png" alt="money-bag" class="salary-icon">
              <p class="card-text mb-0"><?php echo htmlspecialchars($row['salary']); ?>/month</p>
            </div>
            <div class="d-flex align-items-center mt-3">
              <p class="card-text mb-0">Location: <?php echo htmlspecialchars($row['location']); ?></p>
            </div>
            <div class="d-flex align-items-center mt-3">
              <p class="card-text mb-0"><small><?php echo date("d/m/Y H:i:s", strtotime($row['created_at'])); ?></small></p>
            </div>
            <div class="mt-3">
              <a href="post_project.php?id=<?php echo $row['id']; ?>" class="btn btn-warning w-100">Edit</a>
              <br><br>
              <a href="../includes/delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger w-100">Delete</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal for Full Description -->
      <div class="modal fade" id="descriptionModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="descriptionModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="descriptionModalLabel<?php echo $row['id']; ?>">Listing Description</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <?php echo $description; ?>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>


      <?php
          endwhile;
      else:
      ?>
      <div class="col">
        <p class="text-center">No Listing available.</p>
      </div>
      <?php
      endif;
      ?>
    </div>
</div>
</body>
</html>
