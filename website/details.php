<?php
include_once 'includes/header.php';
include_once '../includes/db.php';

// Check if an ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $movieId = $_GET['id'];

    // Fetch the movie details from the database
    $sql = "
      SELECT 
        movies.*, 
        categories.name AS category_name 
      FROM movies 
      JOIN categories ON movies.category_id = categories.id 
      WHERE movies.id = ?
    ";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $movieId);
    $stmt->execute();
    $result = $stmt->get_result();
    $movie = $result->fetch_assoc();

    // Check if the movie exists
    if (!$movie) {
        echo "<div class='container my-5'><h2 class='text-center'>Movie not found.</h2></div>";
        include_once 'includes/footer.php';
        exit();
    }
} else {
    echo "<div class='container my-5'><h2 class='text-center'>Invalid movie ID.</h2></div>";
    include_once 'includes/footer.php';
    exit();
}
?>

<style>
/* Add relevant CSS styles here */
</style>

<div class="container my-5" style="height: 100vh">
  <div class="row align-items-center">
    <!-- Poster and Trailer -->
    <div class="col-md-4 movie-poster text-center">
      <img 
        src="<?= htmlspecialchars($movie['image']) ?>" 
        class="img-fluid mb-3" 
        alt="<?= htmlspecialchars($movie['title']) ?> Poster"
      >
      <!-- Trailer Button -->
      <?php if (!empty($movie['trailer_link'])) { ?>
        <button 
          class="btn btn-primary" 
          data-bs-toggle="modal" 
          data-bs-target="#trailerModal"
        >
          Watch Trailer
        </button>
      <?php } ?>
    </div>

    <!-- Movie Details -->
    <div class="col-md-8 movie-details">
      <h1 class="mb-5"><?= htmlspecialchars($movie['title']) ?></h1>
      <p>
        <strong>Rating:</strong> 7.7<br>
        <strong>Views:</strong> 238 (and counting)<br>
        <strong>Duration:</strong> 1h 45m (estimated)<br>
        <strong>Genre:</strong> <?= htmlspecialchars($movie['category_name']) ?>
      </p>
      <div class="movie-overview">
        <h4>Overview</h4>
        <p><?= htmlspecialchars($movie['description']) ?></p>
      </div>
      <p>
        <strong>Release Date:</strong> <?= htmlspecialchars($movie['release_year']) ?><br>
        <strong>Director:</strong> <?= htmlspecialchars($movie['director']) ?>
      </p>
    </div>
  </div>
</div>

<!-- Trailer Modal -->
<div 
  class="modal fade" 
  id="trailerModal" 
  tabindex="-1" 
  aria-labelledby="trailerModalLabel" 
  aria-hidden="true"
>
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title text-black" id="trailerModalLabel">
          <?= htmlspecialchars($movie['title']) ?> - Official Trailer
        </h5>
        <button 
          type="button" 
          class="btn-close btn-close-black" 
          data-bs-dismiss="modal" 
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body p-0">
        <div class="ratio ratio-16x9">
        <iframe 
            src="<?= htmlspecialchars($movie['trailer_link']) ?>" 
            title="<?= htmlspecialchars($movie['title']) ?> Official Trailer" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen
          ></iframe>
        </div>
      </div>
    </div>
  </div>
</div>


<?php
include_once 'includes/footer.php';
?>
