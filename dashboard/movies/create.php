<?php
require_once '../../includes/dashboard_protect.php';
require_once '../../includes/db.php';
require_once '../../includes/header.php';
require_once '../../includes/sideBar.php';

$id = $_GET['id'] ?? null;
$isEdit = $id !== null;

// Fetch categories for the dropdown
$categories = $conn->query("SELECT id, name FROM categories");

// Fetch existing movie if editing
$movie = [
    'title' => '',
    'category_id' => '',
    'director' => '',
    'release_year' => '',
    'trailer_link' => '',
    'image' => '',
    'description' => ''
];
if ($isEdit) {
    $stmt = $conn->prepare("SELECT * FROM movies WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $movie = $result->fetch_assoc();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $category_id = $_POST['category_id'];
    $director = $_POST['director'];
    $release_year = $_POST['release_year'];
    $trailer_link = $_POST['trailer_link'];
    $image = $_POST['image'];
    $description = $_POST['description'];

    if ($isEdit) {
        $stmt = $conn->prepare("UPDATE movies SET title = ?, category_id = ?, director = ?, release_year = ?, trailer_link = ?, image = ?, description = ? WHERE id = ?");
        $stmt->bind_param('sisssssi', $title, $category_id, $director, $release_year, $trailer_link, $image, $description, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO movies (title, category_id, director, release_year, trailer_link, image, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param('sisssss', $title, $category_id, $director, $release_year, $trailer_link, $image, $description);
    }

    if ($stmt->execute()) {
        echo '<script type="text/javascript">
        window.location.href = "/Movie-Website/dashboard/movies/index.php";
        </script>';
    } else {
        $error = "Failed to save movie: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $isEdit ? 'Edit' : 'Create'; ?> Movie</title>
</head>
<body>
<div class="main-content">
    <h2 class="mb-5"><?= $isEdit ? 'Edit' : 'Create'; ?> Movie</h2>
    <form method="POST">
        <div class="mb-4">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($movie['title']); ?>" required />
        </div>
        <div class="mb-4">
            <label>Category</label>
            <select name="category_id" class="form-select" required>
                <option value="">--Select Category--</option>
                <?php while ($cat = $categories->fetch_assoc()): ?>
                    <option value="<?= $cat['id']; ?>" <?= $cat['id'] == $movie['category_id'] ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($cat['name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-4">
            <label>Director</label>
            <input type="text" name="director" class="form-control" value="<?= htmlspecialchars($movie['director']); ?>" />
        </div>
        <div class="mb-4">
            <label>Release Year</label>
            <input type="number" name="release_year" class="form-control" value="<?= $movie['release_year']; ?>" />
        </div>
        <div class="mb-4">
            <label>Trailer Link</label>
            <input type="text" name="trailer_link" class="form-control" value="<?= htmlspecialchars($movie['trailer_link']); ?>" />
        </div>
        <div class="mb-4">
            <label>Image</label>
            <input type="text" name="image" class="form-control" value="<?= htmlspecialchars($movie['image']); ?>" />
        </div>
        <div class="mb-4">
            <label>Description</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars($movie['description']); ?></textarea>
        </div>
        <button type="submit" class="btn btn-success"><?= $isEdit ? 'Update' : 'Create'; ?> Movie</button>
    </form>
</div>
</body>
</html>
