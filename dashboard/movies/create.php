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
    $description = $_POST['description'];

    // File upload handling
    $imagePath = $movie['image']; // Default to the existing image if editing

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Validate file type
        $allowedFileExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($fileExtension, $allowedFileExtensions)) {
            // Generate a unique file name
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $uploadFileDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/';

            // Ensure the directory exists
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true); // Create the directory if it doesn't exist
            }

            $destPath = $uploadFileDir . $newFileName;

            // Move the file to the uploads directory
            if (move_uploaded_file($fileTmpPath, $destPath)) {
                $imagePath = '/uploads/' . $newFileName;
            } else {
                $error = "There was an error uploading the file.";
            }
        } else {
            $error = "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    }

    if (!isset($error)) {
        if ($isEdit) {
            $stmt = $conn->prepare("UPDATE movies SET title = ?, category_id = ?, director = ?, release_year = ?, trailer_link = ?, image = ?, description = ? WHERE id = ?");
            $stmt->bind_param('sisssssi', $title, $category_id, $director, $release_year, $trailer_link, $imagePath, $description, $id);
        } else {
            $stmt = $conn->prepare("INSERT INTO movies (title, category_id, director, release_year, trailer_link, image, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param('sisssss', $title, $category_id, $director, $release_year, $trailer_link, $imagePath, $description);
        }

        if ($stmt->execute()) {
            echo '<script type="text/javascript">
            window.location.href = "/Movie-Website/dashboard/movies/index.php";
            </script>';
        } else {
            $error = "Failed to save movie: " . $conn->error;
        }
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
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
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
            <input type="file" name="image" class="form-control" accept="image/*" />
            <?php if (!empty($movie['image'])): ?>
                <img src="<?= htmlspecialchars($movie['image']); ?>" alt="Movie Image" width="200" class="mt-3">
            <?php endif; ?>
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
