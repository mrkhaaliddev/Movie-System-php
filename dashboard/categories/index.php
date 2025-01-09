<?php
require_once '../../includes/dashboard_protect.php'; 
require_once '../../includes/db.php';
require_once '../../includes/header.php';
require_once '../../includes/sideBar.php';

// The code that is doing the delete
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = $_GET['id'] ?? null;
    if ($id) {
        $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param('i', $id);
        
        if ($stmt->execute()) {
          echo '<script type="text/javascript">
          window.location.href = "/Movie-Website/dashboard/categories/index.php";
          </script>';
        } else {
            header("Location: /Movie-Website/dashboard/categories/index.php?error=Failed to delete category");
            exit();
        }
    } else {
        header("Location: /Movie-Website/dashboard/categories/index.php?error=Invalid category ID");
        exit();
    }
}

// Fetch categories from DB
$sql = "SELECT * FROM categories ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<div class="main-content" style="height: 100vh">
    <div class="container-fluid pt-4">
        <!-- Display success/error messages if any -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_GET['success']); ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>
        
        <h2 class="mb-5">
            Manage Categories
            <a href="create.php" class="btn btn-primary btn-sm float-end">+ Add New</a>
        </h2>

        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Created At</th>
                    <th width="180">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id']; ?></td>
                        <td><?= htmlspecialchars($row['name']); ?></td>
                        <td><?= htmlspecialchars($row['description']); ?></td>
                        <td><?= $row['created_at']; ?></td>
                        <td>
                            <a href="create.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">
                                Edit
                            </a>
                            <a href="index.php?action=delete&id=<?= $row['id']; ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure you want to delete this category?');">
                                Delete
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No categories found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
require_once '../../includes/footer.php';
?>
