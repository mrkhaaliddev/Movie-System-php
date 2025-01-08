<?php
require_once '../../includes/dashboard_protect.php';
require_once '../../includes/db.php';
require_once '../../includes/header.php';
require_once '../../includes/sideBar.php';

// ** Delete movies
$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $conn->prepare("DELETE FROM movies WHERE id = ?");
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
      echo '<script type="text/javascript">
      window.location.href = "/Movie-Website/dashboard/movies/index.php";
      </script>';
    } else {
      header("Location: index.php?error=Failed to delete movie");
      exit();
  }
}

// Fetch movies
$sql = "SELECT movies.*, categories.name AS category_name FROM movies 
        JOIN categories ON movies.category_id = categories.id 
        ORDER BY movies.created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Movies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="main-content" style="height: 100vh">
    <h2 class="mb-5">Movies <a href="create.php" class="btn btn-primary btn-sm float-end">+ Add New</a></h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Director</th>
                <th>Release Year</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= htmlspecialchars($row['title']); ?></td>
                    <td><?= htmlspecialchars($row['category_name']); ?></td>
                    <td><?= htmlspecialchars($row['director']); ?></td>
                    <td><?= $row['release_year']; ?></td>
                    <td>
                        <a href="create.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete.php?id=<?= $row['id']; ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
<?php require_once '../../includes/footer.php'; ?>
