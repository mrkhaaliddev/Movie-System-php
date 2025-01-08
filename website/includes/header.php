<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Moiveo - Front Website</title>
  <!-- Bootstrap CSS -->
  <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
    rel="stylesheet"
  >
  <!-- Optional Bootstrap Icons -->
  <link 
    rel="stylesheet" 
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css"
  >
  <!-- Your custom CSS -->
  <link rel="stylesheet" href="assets/css/style.css" />

  <style>
    /* Example styling – you can move this to style.css if you prefer */

    /* NAVBAR */
    .navbar-brand {
      font-weight: 600;
      letter-spacing: 0.5px;
      color: #fdc200 !important; /* Example color for brand text/logo */
    }
    .navbar .nav-link {
      color: #ffffff !important;
      margin: 0 8px;
    }
    .navbar {
      background-color: #333;
    }

    /* FOR SCROLLING ROWS */
    .scrolling-wrapper {
      display: flex;
      flex-wrap: nowrap;
      overflow-x: auto;         /* horizontal scroll */
      -webkit-overflow-scrolling: touch;
      gap: 1rem;
    }
    .scrolling-wrapper .card {
      min-width: 200px;         /* control the card width */
      flex: 0 0 auto;
    }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">MOIVEO</a>
    <button 
      class="navbar-toggler" 
      type="button" 
      data-bs-toggle="collapse"
      data-bs-target="#navbarNav" 
      aria-controls="navbarNav" 
      aria-expanded="false" 
      aria-label="Toggle navigation"
      style="border: none;"
    >
      <span class="navbar-toggler-icon" style="color: #fff;"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="#">TV Shows</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Movies</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Categories</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
