<?php

include_once '../includes/dashboard_protect.php';

include_once '../includes/db.php';

include_once '../includes/header.php';

// Include sidebar
include_once '../includes/sideBar.php';
?>

<!-- ADDITIONAL CUSTOM STYLES FOR THE DASHBOARD PAGE -->
<style>
  .card {
    border: none; 
    border-radius: 8px; 
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  }
  .card-header {
    border-top-left-radius: 8px; 
    border-top-right-radius: 8px; 
    font-weight: 600;
  }
  /* Slight gradient on the card headers */
  .card-header.bg-primary {
    background: linear-gradient(45deg, #0d6efd, #328af7);
  }
  .card-header.bg-success {
    background: linear-gradient(45deg, #28a745, #58cd85);
  }
</style>

<!-- MAIN CONTENT AREA -->
<div class="main-content" style="height: 100vh">
  <?php 
 if (isset($_SESSION['email'])) {
  $email = $_SESSION['email'];

  // Build the SQL query
  $sql = "SELECT username FROM users WHERE email = '$email'";

  // Execute the query
  $result = $conn->query($sql);

  // Check if a user is found
  if ($result->num_rows > 0) {
      // Fetch the username
      $row = $result->fetch_assoc();
      $username = htmlspecialchars($row['username']);

      // Display the username in an <h1> tag
      echo "<h2>Welcome, $username!</h2>";
  } else {
      echo "<h1>User not found</h1>";
  }
}

  ?>
 
  <p>
    This is your admin dashboard. Manage categories, movies,
    or update your profile from the left sidebar.
  </p>

  <!-- FIRST ROW with two cards (Movies and Categories) -->
  <div class="row mt-4">
    <div class="col-md-6">
      <div class="card mb-4">
        <div class="card-header bg-primary text-white">
          <i class="bi bi-film"></i> Movies
        </div>
        <div class="card-body">
          <h5 class="card-title">Manage Your Movies</h5>
          <p class="card-text">
            Click <strong>Movies</strong> in the sidebar to create, edit, or delete movies.
          </p>
          <a href="/Movie-Website/dashboard/movies/index.php" class="btn btn-outline-primary">
            <i class="bi bi-arrow-right-square"></i> Go to Movies
          </a>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card mb-4">
        <div class="card-header bg-success text-white">
          <i class="bi bi-tags"></i> Categories
        </div>
        <div class="card-body">
          <h5 class="card-title">Organize by Category</h5>
          <p class="card-text">
            Navigate to <strong>Categories</strong> to keep your movies organized.
          </p>
          <a href="/Movie-Website/dashboard/categories/index.php" class="btn btn-outline-success">
            <i class="bi bi-arrow-right-square"></i> Go to Categories
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- END MAIN CONTENT AREA -->

<?php
// Include footer (closes body/html)
include_once '../includes/footer.php';
?>
