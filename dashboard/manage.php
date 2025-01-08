<?php
session_start();
require '../includes/db.php'; // Include database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Redirect to login if not logged in
    exit();
}

// Fetch jobs posted by the logged-in founder
$user_id = $_SESSION['user_id'];
$query_jobs = "SELECT * FROM jobs WHERE user_id = '$user_id' ORDER BY created_at DESC";
$result_jobs = $conn->query($query_jobs);
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
  <title>Manage Applications</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
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
    body {
      font-family: 'Inter', sans-serif;
    }
    .application-list {
      margin-top: 20px;
      border-top: 1px solid #ddd;
      padding-top: 10px;
    }
  </style>
</head>
<body>
<?php include("../includes/header.php"); ?>
<div class="container project-container mt-5">
    <h2 class="mb-4 text-center">Manage Applications for Your Jobs</h2>
    <div class="row row-cols-1 row-cols-md-2 g-4">
      <?php if ($result_jobs->num_rows > 0): ?>
          <?php while ($job = $result_jobs->fetch_assoc()): ?>
          <div class="col">
            <div class="card project-card shadow-sm">
              <div class="card-body">
                <h5 class="card-title">
                  <b><?php echo htmlspecialchars($job['title']); ?></b>
                  <span class="badge bg-success badge-equity" style="float:right">
                    <?php echo htmlspecialchars($job['equity_offered']); ?>% Equity
                  </span>
                </h5>
                <p class="card-text"><strong>Location:</strong> <?php echo htmlspecialchars($job['location']); ?></p>
                <p class="card-text"><strong>Description:</strong> <?php echo htmlspecialchars($job['job_description']); ?></p>
                <p class="card-text"><strong>Salary:</strong> <?php echo htmlspecialchars($job['salary']); ?>/month</p>
                
                <!-- Fetch Applications for the Job -->
                <?php
                $job_id = $job['id']; // Get the current job ID
                $query_applications = "SELECT * FROM applications WHERE t_id = '$job_id' ORDER BY created_at DESC";
                $result_applications = $conn->query($query_applications);
                ?>
                <div class="application-list">
                  <h6>Applications:</h6>
                  <?php if ($result_applications->num_rows > 0): ?>
                    <ul class="list-group">
                      <?php while ($application = $result_applications->fetch_assoc()): ?>
                        <li class="list-group-item">
                          <strong><?php echo htmlspecialchars($application['name']); ?></strong><br>
                          <a href="<?php echo htmlspecialchars($application['github_profile']); ?>" target="_blank">GitHub Profile</a><br>
                          <strong>Skills:</strong> <?php echo htmlspecialchars($application['skills']); ?><hr>
                          <p>About: <?php echo $application['description']; ?></p><hr>
                          <strong>WhatsApp Number:</strong> 
                          <a href="https://wa.me/<?php echo htmlspecialchars($application['whatsapp_number']); ?>" target="_blank" class="text-success"><?php echo $application['whatsapp_number']; ?></a>
                          <div class="mt-2">
                            <a href="https://wa.me/<?php echo htmlspecialchars($application['whatsapp_number']); ?>" class="btn btn-primary btn-sm">Chat On Whatsapp</a>
                          </div>
                        </li>
                      <?php endwhile; ?>
                    </ul>
                  <?php else: ?>
                    <p class="text-muted">No applications yet for this job.</p>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
          <?php endwhile; ?>
      <?php else: ?>
          <div class="col">
            <p class="text-center">No jobs found. <a href="add_job.php">Post a new job</a>.</p>
          </div>
      <?php endif; ?>
    </div>
</div>
</body>
</html>
