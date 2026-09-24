<?php
require_once __DIR__ . '/includes/header.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$is_admin = $pdo->prepare('SELECT is_admin FROM users WHERE id=?'); $is_admin->execute([$_SESSION['user_id']]); if (!$is_admin->fetchColumn()) { echo '<div class="alert alert-danger">Unauthorized</div>'; require_once __DIR__.'/footer.php'; exit; }
$id = (int)($_GET['id'] ?? 0);
$p = $pdo->prepare('SELECT * FROM products WHERE id=?'); $p->execute([$id]); $prod = $p->fetch(); if (!$prod) { header('Location: admin.php'); exit; }
$errors=[];
if ($_SERVER['REQUEST_METHOD']==='POST'){
    $name = trim($_POST['name'] ?? '');
    $desc = trim($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $img = $prod['image'];
    if (!empty($_FILES['image']['tmp_name'])){
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $img = 'prod_'.time().'.'.$ext;
        move_uploaded_file($_FILES['image']['tmp_name'], __DIR__.'/images/'.$img);
    }
    $upd = $pdo->prepare('UPDATE products SET name=?,description=?,price=?,image=? WHERE id=?');
    $upd->execute([$name,$desc,$price,$img,$id]);
    header('Location: admin.php'); exit;
}
?>
<div class="row justify-content-center mt-4"><div class="col-md-6">
  <h3>Edit Product</h3>
  <form method="post" enctype="multipart/form-data">
    <div class="mb-3"><label>Name</label><input name="name" value="<?= htmlspecialchars($prod['name']) ?>" class="form-control" required></div>
    <div class="mb-3"><label>Description</label><textarea name="description" class="form-control"><?= htmlspecialchars($prod['description']) ?></textarea></div>
    <div class="mb-3"><label>Price</label><input name="price" type="number" step="0.01" value="<?= $prod['price'] ?>" class="form-control" required></div>
    <div class="mb-3"><label>Image</label><input name="image" type="file" class="form-control"></div>
    <button class="btn btn-primary">Save</button>
  </form>
</div></div>
<?php require_once __DIR__.'/footer.php'; ?>
