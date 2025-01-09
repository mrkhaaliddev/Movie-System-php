<?php
require_once '../includes/dashboard_protect.php'; 
require_once '../includes/db.php';              

$error = "";
$success = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['change_password']) && $_POST['change_password'] == '1') {
        // Change password logic
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];
        $emailVerify = $_SESSION['email'];

        // Validate new password and confirm password
        if ($newPassword !== $confirmPassword) {
            $error = "New passwords do not match.";
        } else {
            // Fetch the current password hash from the database
            $stmt = $conn->prepare("SELECT password FROM users WHERE email=?");
            $stmt->bind_param("s", $emailVerify);
            $stmt->execute();
            $stmt->bind_result($password);
            $stmt->fetch();
            $stmt->close();


            // Verify current password
            if ($currentPassword !== $password) {
                $error = "Current password is incorrect.";
            } else {

                // Update the password in the database
                $stmt = $conn->prepare("UPDATE users SET password=? WHERE email=?");
                $stmt->bind_param("ss", $newPassword, $emailVerify);
                if ($stmt->execute()) {
                    // Log out the user
                    session_destroy();
                    header("Location: /Movie-Website/auth/login.php?message=Password updated. Please log in again.");
                    exit;
                } else {
                    $error = "Error updating password.";
                }
                $stmt->close();
            }
        }
    } else {
        // Update profile logic
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
  <div class="profile-card card mt-5">
  <div class="card-body">
  <!-- Change Password -->
  <form method="POST" action="">
    <input type="hidden" name="change_password" value="1" />
    <div class="mb-3">
      <label class="form-label">Current Password</label>
      <input 
        type="password" 
        name="current_password" 
        class="form-control" 
        placeholder="Enter current password" 
        required 
      />
    </div>
    <div class="mb-3">
      <label class="form-label">New Password</label>
      <input 
        type="password" 
        name="new_password" 
        class="form-control" 
        placeholder="Enter new password" 
        required 
      />
    </div>
    <div class="mb-3">
      <label class="form-label">Confirm New Password</label>
      <input 
        type="password" 
        name="confirm_password" 
        class="form-control" 
        placeholder="Re-enter new password" 
        required 
      />
    </div>
    <div class="d-grid">
      <button type="submit" class="btn btn-success">
        <i class="bi bi-key"></i> Change Password
      </button>
    </div>
  </form>
   </div>
   </div>
   </div>
<?php

// Include your footer
include_once '../includes/footer.php';
?>
