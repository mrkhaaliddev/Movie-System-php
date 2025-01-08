<?php
session_start();
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result) {
        if ($password === $result['password']) {
            $_SESSION['user_id'] = $result['id'];
            $_SESSION['email'] = $result['email'];
            header("Location: ../dashboard/index.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "email not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>MovieApp Admin - Login</title>
    <!-- Bootstrap 5 -->
    <link 
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
      rel="stylesheet"
    />
    <!-- Bootstrap Icons (Optional) -->
    <link 
      rel="stylesheet" 
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css"
    />

    <style>
      /* CUSTOM STYLING FOR LOGIN PAGE */
      body {
        background: linear-gradient(160deg, #f0f2f5 30%, #e9ecef 100%);
        font-family: Arial, sans-serif;
      }

      .login-container {
        margin-top: 5rem; 
      }

      .card {
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.08);
      }

      .card-header {
        background-color: #0d6efd; 
        color: #fff;
        text-align: center;
        font-weight: 600;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
      }

      .card-body label {
        font-weight: 500;
      }

      .form-control {
        border-radius: 6px;
      }

      .btn-primary {
        border-radius: 6px;
      }

      .brand-logo {
        font-size: 2rem;
        color: #0d6efd;
        font-weight: bold;
        text-decoration: none;
      }

      .brand-logo i {
        margin-right: 8px;
      }
    </style>
</head>
<body>

<div class="container login-container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <!-- Optional brand/logo on top -->
            <div class="text-center mb-4">
                <a href="#" class="brand-logo">
                  <i class="bi bi-camera-reels"></i> MovieApp Admin
                </a>
            </div>

        <div class="card">
                <div class="card-header">
                  Admin Login
                </div>
                <div class="card-body">
                  <?php if(!empty($error)): ?>
                    <div class="alert alert-danger text-center">
                      <?= $error; ?>
                    </div>
                  <?php endif; ?>

                  <form method="POST" action="login.php">
                      <div class="mb-3">
                          <label class="form-label">Email</label>
                          <input 
                            name="email" 
                            type="text" 
                            class="form-control" 
                            placeholder="Enter your Email" 
                            required 
                          />
                      </div>
                      <div class="mb-3">
                          <label class="form-label">Password</label>
                          <input 
                            name="password" 
                            type="password" 
                            class="form-control" 
                            placeholder="Enter your password" 
                            required 
                          />
                      </div>
                      <button class="btn btn-primary w-100" type="submit">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                      </button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script 
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js">
</script>
</body>
</html>
