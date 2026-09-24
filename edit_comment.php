<?php
require_once __DIR__ . '/header.php';
$id = (int)($_GET['id'] ?? 0);
$c = $pdo->prepare('SELECT * FROM comments WHERE id=?'); $c->execute([$id]); $row = $c->fetch();
if (!$row) { header('Location: index.php'); exit; }
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $row['user_id']) { header('Location: index.php'); exit; }
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $content = trim($_POST['content'] ?? '');
    if ($content==='') $errors[]='Content required';
    if (empty($errors)){
        $u = $pdo->prepare('UPDATE comments SET content=? WHERE id=?'); $u->execute([$content,$id]);
        header('Location: product_view.php?id='.$row['product_id']); exit;
    }
}
?>
<div class="row justify-content-center mt-4"><div class="col-md-6">
  <h3>Edit Comment</h3>
  <?php if ($errors): ?><div class="alert alert-danger"><?= implode('<br>', array_map('htmlspecialchars',$errors)) ?></div><?php endif; ?>
  <form method="post">
    <div class="mb-3"><textarea name="content" class="form-control"><?= htmlspecialchars($row['content']) ?></textarea></div>
    <button class="btn btn-primary">Save</button>
  </form>
</div></div>
<?php require_once __DIR__.'/footer.php'; ?>
