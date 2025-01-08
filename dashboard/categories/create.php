<?php
require_once '../../includes/dashboard_protect.php';
require_once '../../includes/db.php';
require_once '../../includes/header.php';
require_once '../../includes/sideBar.php';

$error    = '';
$editing  = false;
$id       = $_GET['id'] ?? null;
$category = [
    'name'        => '',
    'description' => ''
];

if ($id) {
    $editing = true;
    $stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $categoryData = $result->fetch_assoc();
    
    if (!$categoryData) {
        header("Location: index.php?error=Category not found");
        exit();
    }
    $category['name']        = $categoryData['name'];
    $category['description'] = $categoryData['description'];
}

// Handle form submission (create or update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name        = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (empty($name)) {
        $error = 'Category Name is required.';
    } else {
        if ($editing) {
            $stmt = $conn->prepare("UPDATE categories SET name = ?, description = ? WHERE id = ?");
            $stmt->bind_param('ssi', $name, $description, $id);
            
            if ($stmt->execute()) {
                echo '<script type="text/javascript">
                window.location.href = "/Movie-Website/dashboard/categories/index.php";
              </script>';
            } else {
                $error = "Failed to update category: " . $conn->error;
            }
        } else {
            $stmt = $conn->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
            $stmt->bind_param('ss', $name, $description);
            
            if ($stmt->execute()) {
                echo '<script type="text/javascript">
                window.location.href = "/Movie-Website/dashboard/categories/index.php";
              </script>';            } else {
                $error = "Failed to create category: " . $conn->error;
            }
        }
    }
}
?>

<div class="main-content">
    <div class="container-fluid pt-4">
        <h2 class="mb-5"><?= $editing ? 'Edit' : 'Create'; ?> Category</h2>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- If editing, preserve the ?id in the action -->
        <form action="create.php<?= $editing ? '?id=' . $id : ''; ?>" method="POST">
            <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input 
                    type="text" 
                    name="name" 
                    class="form-control" 
                    value="<?= htmlspecialchars($category['name']); ?>" 
                    required 
                />
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea 
                    name="description" 
                    rows="5" 
                    class="form-control"
                ><?= htmlspecialchars($category['description']); ?></textarea>
            </div>

            <button type="submit" class="btn btn-success">
                <?= $editing ? 'Update' : 'Create'; ?>
            </button>
        </form>
    </div>
</div>

<?php
require_once '../../includes/footer.php';
?>
