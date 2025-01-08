<?php
// sideBar.php
?>
<style>
  /* SIDEBAR WRAPPER */
  .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;            /* Fixed sidebar width */
    height: 100vh;           /* Full viewport height */
    background-color: #343a40;
    padding: 1rem 1rem 2rem;
    overflow-y: auto;
    transition: all 0.3s ease;
    z-index: 999;            /* Ensures sidebar is on top */
  }

  /* BRAND / LOGO AREA */
  .sidebar .sidebar-brand {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    color: #fff;
    text-decoration: none;
  }
  .sidebar .sidebar-brand img {
    height: 40px;            /* Logo height */
    margin-right: 10px;
  }
  .sidebar .brand-text {
    font-size: 1.2rem;
    font-weight: 600;
    color: #ffffff;
  }

  /* SIDEBAR HEADER / TITLE */
  .sidebar h5 {
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 1rem;
    margin-bottom: 1rem;
    font-size: 0.9rem;
  }

  /* NAVIGATION LINKS */
  .sidebar .nav {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;            /* Spacing between items */
  }
  .sidebar .nav-link {
    display: flex;
    align-items: center;
    color: #adb5bd;          /* Lighter gray for unselected links */
    padding: 0.45rem 0.75rem;
    border-radius: 4px;
    transition: background-color 0.2s ease, color 0.2s ease;
    text-decoration: none;
  }
  .sidebar .nav-link i {
    margin-right: 8px;       /* Spacing for icons */
    font-size: 1.1rem;
  }
  .sidebar .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1);
    color: #fff;
    text-decoration: none;
  }

  /* ACTIVE LINK STYLING */
  .sidebar .nav-link.active {
    background-color: #495057;
    color: #fff;
  }

  /* COLLAPSE BUTTON (OPTIONAL) */
  .sidebar-toggle {
    display: none;           /* You can set it to block if you implement toggling */
    color: #fff;
    background-color: #495057;
    padding: 0.4rem 0.6rem;
    border-radius: 4px;
    cursor: pointer;
    margin-bottom: 1rem;
  }

  /* MEDIA QUERY (EXAMPLE): COLLAPSE SIDEBAR ON SMALLER SCREENS */
  @media (max-width: 768px) {
    .sidebar {
      left: -250px;          /* Hide sidebar by default on smaller screens */
    }
    .sidebar.active {
      left: 0;               /* Slide out sidebar when toggled */
    }
    .sidebar-toggle {
      display: inline-block;
    }
    nav.navbar {
      margin-left: 0 !important; /* So the navbar won't be shifted if you use margin-left in header.php */
    }
  }
</style>

<!-- SIDEBAR START -->
<div class="sidebar" id="sidebar">
  <!-- OPTIONAL COLLAPSE/EXPAND BUTTON FOR SMALL SCREENS -->
  <!--
  <div class="sidebar-toggle" onclick="toggleSidebar()">
    <i class="bi bi-list"></i>
  </div>
  -->

  <!-- BRAND/LOGO SECTION -->
  <!-- Replace with your brand image/logo if you have one -->
  <a href="../dashboard/index.php" class="sidebar-brand">
    <!-- Example brand image (optional) -->
    <!-- <img src="../public/images/your-logo.png" alt="Brand Logo" /> -->
    <span class="brand-text">MovieApp Admin</span>
  </a>

  <!-- HEADER -->
  <h5>Menu</h5>

  <!-- NAVIGATION LINKS -->
  <ul class="nav flex-column">
    <li class="nav-item">
      <a href="/Movie-Website/dashboard/index.php" class="nav-link active">
        <i class="bi bi-speedometer2"></i> Dashboard
      </a>
    </li>
    <li class="nav-item">
      <a href="/Movie-Website/dashboard/profile.php" class="nav-link">
        <i class="bi bi-person"></i> Profile
      </a>
    </li>
    <li class="nav-item">
      <a href="/Movie-Website/dashboard/categories/index.php" class="nav-link">
        <i class="bi bi-tags"></i> Categories
      </a>
    </li>
    <li class="nav-item">
      <a href="/Movie-Website/dashboard/movies/index.php" class="nav-link">
        <i class="bi bi-film"></i> Movies
      </a>
    </li>
  </ul>
</div>
<!-- SIDEBAR END -->

<!-- (OPTIONAL) SIDEBAR TOGGLE SCRIPT for smaller screens -->
<script>
  function toggleSidebar() {
    let sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('active');
  }
</script>
