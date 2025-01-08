<?php
require_once '../includes/dashboard_protect.php'; 
require_once '../includes/db.php';              

$error = "";
$success = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'];
        $email    = $_POST['email'];
        $emailVerify = $_SESSION['email'];
        
        // Validate & update
        $stmt = $conn->prepare("UPDATE users SET username=?, email=? WHERE email=?");
        $stmt->bind_param("sss", $username, $email, $emailVerify);
        if ($stmt->execute()) {
            $success = "Profile updated successfully.";
            $_SESSION['email'] = $email;
        } else {
            $error = "Error updating profile.";
        }
}




// Include your header + sidebar if needed
include_once '../includes/header.php';
include_once '../includes/sideBar.php';
?>

<style>
  /* Additional styles for the profile card */
  .profile-container {
    margin-left: 250px; /* offset for sidebar if needed */
    padding: 2rem;
  }
  .profile-card {
    max-width: 700px;
    margin: 0 auto;
  }
  .card-header {
    font-weight: 600;
    font-size: 1.1rem;
  }
  .form-label {
    font-weight: 500;
  }
</style>

<div class="profile-container" style="height: 100vh">
  <div class="profile-card card">
    <div class="card-header bg-primary text-white">Update Profile</div>
    <div class="card-body">
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger text-center"><?= $error; ?></div>
      <?php endif; ?>
      <?php if (!empty($success)): ?>
        <div class="alert alert-success text-center"><?= $success; ?></div>
      <?php endif; ?>

      <!-- Update Basic Info -->
      <form method="POST" action="">
        <?php
       if (isset($_SESSION['email'])) {
        $email = $_SESSION['email'];

        // Build the SQL query
       $sql = "SELECT username, email FROM users WHERE email = '$email'";

       // Execute the query
       $result = $conn->query($sql);

       // Check if a user is found
       if ($result->num_rows > 0) {
        // Fetch the user data
        $row = $result->fetch_assoc();
        $userName = htmlspecialchars($row['username']);
        $email = htmlspecialchars($row['email']);
        } else {
        echo "<h1>User not found</h1>";
        exit; 
       }
     } else {
       echo "<h1>Error: User is not logged in.</h1>";
       exit;
       }
?>

    <div class="mb-3">
    <label class="form-label">Username</label>
    <input 
      type="text" 
      name="username" 
      class="form-control" 
      value="<?php echo $userName; ?>" 
      required 
        />
    </div>
    <div class="mb-3">
    <label class="form-label">Email</label>
    <input 
        type="email" 
        name="email" 
        class="form-control" 
        value="<?php echo $email; ?>" 
        required 
    />
    </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Save Changes
          </button>
        </div>
      </form>

      <hr />
    </div>
  </div>
   </div>

<?php
// Include your footer
include_once '../includes/footer.php';
?>
