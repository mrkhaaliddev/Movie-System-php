<?php
// If you need sessions on every page, you can do:
// if (session_status() === PHP_SESSION_NONE) { session_start(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>MovieApp Admin</title>
  <!-- Bootstrap CSS -->
  <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <!-- Bootstrap Icons (optional) -->
  <link 
    rel="stylesheet" 
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css"
  />

  <!-- Custom Styles -->
  <style>
    /* GENERAL RESET / THEMES */
    body {
      margin: 0; 
      padding: 0;
      font-family: Arial, sans-serif;
      background-color: #f4f6f9; /* Light neutral background */
    }
    
    /* NAVBAR (top) */
    .navbar {
      background-color: #f8f9fa; 
      border-bottom: 1px solid #dee2e6; /* subtle bottom border */
      margin-left: 250px; /* So it aligns with the fixed sidebar’s width */
    }
    .navbar .navbar-brand {
      color: #212529 !important; /* Dark text */
      font-weight: 600;
      letter-spacing: 0.5px;
    }
    .navbar .nav-link {
      color: #212529 !important;
    }
    .navbar .nav-link:hover {
      color: #000 !important;
    }

    /* MAIN CONTENT - spaced from the sidebar */
    .main-content {
      margin-left: 250px; /* same width as the sidebar */
      padding: 2rem;
    }
  </style>
</head>

<body>
<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">MovieApp Admin</a>
    <button 
      class="navbar-toggler" 
      type="button" 
      data-bs-toggle="collapse" 
      data-bs-target="#navbarSupportedContent" 
      aria-controls="navbarSupportedContent" 
      aria-expanded="false" 
      aria-label="Toggle navigation"
      style="border: none;"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div 
      class="collapse navbar-collapse justify-content-end" 
      id="navbarSupportedContent"
    >
      <ul class="navbar-nav mb-2 mb-lg-0">
        <!-- Profile link -->
        <li class="nav-item">
          <a class="nav-link" href="/Movie-Website/dashboard/profile.php">
            <i class="bi bi-person-circle"></i> Profile
          </a>
        </li>
        <!-- Logout link -->
        <li class="nav-item">
          <a class="nav-link" href="/Movie-Website/auth/logout.php">
            <i class="bi bi-box-arrow-right"></i> Logout
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
