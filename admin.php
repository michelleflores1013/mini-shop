<?php
require_once __DIR__ . '/includes/header.php';
// only admin
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$is_admin = $pdo->prepare('SELECT is_admin FROM users WHERE id=?'); $is_admin->execute([$_SESSION['user_id']]); if (!$is_admin->fetchColumn()) { echo '<div class="alert alert-danger">Unauthorized</div>'; require_once __DIR__.'/footer.php'; exit; }
// simple product CRUD
$products = $pdo->query('SELECT * FROM products ORDER BY created_at DESC')->fetchAll();
?>
<div class="row mt-4"><div class="col-md-12">
  <h3>Admin - Products</h3>
  <a class="btn btn-primary mb-2" href="admin_add_product.php">Add Product</a>
  <table class="table">
    <thead><tr><th>ID</th><th>Name</th><th>Price</th><th>Actions</th></tr></thead>
    <tbody>
      <?php foreach ($products as $p): ?>
        <tr>
          <td><?= $p['id'] ?></td>
          <td><?= htmlspecialchars($p['name']) ?></td>
          <td><?= number_format($p['price'],2) ?></td>
          <td>
            <a class="btn btn-sm btn-secondary" href="admin_edit_product.php?id=<?= $p['id'] ?>">Edit</a>
            <a class="btn btn-sm btn-danger" href="admin_delete_product.php?id=<?= $p['id'] ?>">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div></div>
<?php require_once __DIR__.'/footer.php'; ?>
