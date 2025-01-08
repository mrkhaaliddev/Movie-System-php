<?php
include_once 'includes/header.php';
include_once '../includes/db.php';

// Fetch movies from the database
$sql = "
  SELECT 
    movies.*, 
    categories.name AS category_name 
  FROM movies 
  JOIN categories ON movies.category_id = categories.id 
  ORDER BY movies.created_at DESC
";

$result = $conn->query($sql);

// Store all rows in an array
$movies = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $movies[] = $row;
    }
}
?>

<style>
/* Enhanced styling */
.carousel-item {
    height: 100vh; /* Full-screen height */
    background-size: cover;
    background-position: center;
    position: relative;
}
.carousel-item .overlay {
    position: absolute;
    top: 0; 
    left: 0; 
    width: 100%; 
    height: 100%;
    background: rgba(0, 0, 0, 0.6); /* Darker overlay */
}
.carousel-caption {
    top: 35%;
    transform: translateY(-35%);
    bottom: auto;
    text-align: left;
    color: #ffffff;
}
.carousel-caption h1 {
    font-size: 3rem;
    font-weight: bold;
    margin-bottom: 1rem;
}
.carousel-caption p {
    font-size: 1.2rem;
    line-height: 1.5;
    margin-bottom: 1.5rem;
}
.carousel-caption .btn {
    font-size: 1rem;
    padding: 0.8rem 1.5rem;
}
</style>

<!-- HERO CAROUSEL -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <?php if (!empty($movies)) { 
        foreach ($movies as $index => $movie) { ?>
        <!-- Slide -->
        <div 
          class="carousel-item <?= $index === 0 ? 'active' : '' ?>" 
          style="background-image: url('<?= $movie['image'] ?>');"
        >
          <div class="overlay"></div>
          <div class="carousel-caption ms-5">
            <h1><?= htmlspecialchars($movie['title']) ?></h1>
            <p>
              <strong>Category:</strong> <?= htmlspecialchars($movie['category_name']) ?><br>
              <strong>Release Year:</strong> <?= htmlspecialchars($movie['release_year']) ?><br>
              <strong>Director:</strong> <?= htmlspecialchars($movie['director']) ?><br>
              <strong>Description:</strong> <?= htmlspecialchars($movie['description']) ?>
            </p>
            <a href="details.php?id=<?= $movie['id'] ?>" class="btn btn-primary btn-lg">View Details</a>
          </div>
        </div>
    <?php } 
    } else { ?>
      <div class='text-center text-white'><h1>No movies found.</h1></div>
    <?php } ?>
  </div>

  <!-- Carousel Controls -->
  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>


<?php
include_once 'includes/header.php';
include_once '../includes/db.php';

// Fetch movies grouped by category
$sql = "
  SELECT 
    movies.*, 
    categories.name AS category_name 
  FROM movies 
  JOIN categories ON movies.category_id = categories.id 
  ORDER BY categories.name, movies.created_at DESC
";

$result = $conn->query($sql);

// Group movies by category
$moviesByCategory = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $moviesByCategory[$row['category_name']][] = $row;
    }
}
?>

<style>
/* Enhanced styling */
.scrolling-wrapper {
    display: flex;
    overflow-x: auto;
    gap: 1rem;
    scroll-behavior: smooth;
    padding-bottom: 1rem;
}
.scrolling-wrapper::-webkit-scrollbar {
    height: 8px;
}
.scrolling-wrapper::-webkit-scrollbar-thumb {
    background-color: #cccccc;
    border-radius: 4px;
}
.movie-card {
    flex: 0 0 auto;
    width: 300px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    text-align: center;
}
.movie-card img {
    height: 350px;
    object-fit: cover;
    width: 100%;
}
.movie-card .card-body {
    padding: 1rem;
}
</style>

<div class="container my-5">
  <?php if (!empty($moviesByCategory)) { 
      foreach ($moviesByCategory as $categoryName => $movies) { ?>
        <!-- Category Section -->
        <h2 class="mb-4"><?= htmlspecialchars($categoryName) ?> Movies</h2>
        <div class="scrolling-wrapper">
          <?php foreach ($movies as $movie) { ?>
            <!-- Movie Card -->
            <div class="card movie-card">
              <img 
                src="<?= htmlspecialchars($movie['image']) ?>" 
                alt="<?= htmlspecialchars($movie['title']) ?> Poster"
              />
              <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($movie['title']) ?></h5>
                <p class="card-text">
                  <strong>Release Year:</strong> <?= htmlspecialchars($movie['release_year']) ?><br>
                  <strong>Director:</strong> <?= htmlspecialchars($movie['director']) ?><br>
                  <strong>Description:</strong> <?= htmlspecialchars($movie['description']) ?>
                </p>
                <a href="details.php?id=<?= $movie['id'] ?>" class="btn btn-primary">View Details</a>
              </div>
            </div>
          <?php } ?>
        </div>
  <?php } 
  } else { ?>
    <h3 class="text-center">No movies found.</h3>
  <?php } ?>
</div>

<?php
include_once 'includes/footer.php';
?>


<?php
  include_once 'includes/footer.php';
?>
