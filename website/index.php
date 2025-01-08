<?php
require_once 'config/db.php';
// Fetch all movies
$sql = "SELECT m.*, c.name as category_name FROM movies m
        LEFT JOIN categories c ON m.category_id = c.id
        ORDER BY m.created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Movie App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">MovieApp</a>
    <!-- You can add more links here -->
  </div>
</nav>

<!-- Hero section with a carousel or slider for "hot" films (just an example) -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <!-- You can add images or calls to the DB for "hot" films -->
    <div class="carousel-item active">
      <img src="public/images/hero1.jpg" class="d-block w-100" alt="Hot Movie Poster">
    </div>
    <!-- Add more carousel items as needed -->
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<!-- Display Movies -->
<div class="container my-5">
  <h2 class="mb-4">Latest Movies</h2>
  <div class="row">
    <?php while($movie = $result->fetch_assoc()): ?>
    <div class="col-md-3 mb-4">
      <div class="card h-100">
        <?php if(!empty($movie['image'])): ?>
          <img src="<?php echo $movie['image']; ?>" class="card-img-top" alt="Movie Poster">
        <?php else: ?>
          <img src="public/images/default-poster.png" class="card-img-top" alt="Default Poster">
        <?php endif; ?>
        <div class="card-body">
          <h5 class="card-title"><?php echo $movie['title']; ?></h5>
          <p class="card-text text-truncate"><?php echo $movie['description']; ?></p>
        </div>
        <div class="card-footer">
          <small class="text-muted"><?php echo $movie['category_name']; ?></small><br>
          <a href="movie_detail.php?id=<?php echo $movie['id']; ?>" class="btn btn-primary btn-sm">View</a>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
