<?php
require_once __DIR__ . '/includes/header.php';
$q = trim($_GET['q'] ?? '');
$results = [];
if ($q !== ''){
    $like = '%' . $q . '%';
    $s = $pdo->prepare('SELECT id,name,description FROM products WHERE name LIKE ? OR description LIKE ? LIMIT 50');
    $s->execute([$like,$like]); $results = $s->fetchAll();
}
?>
<div class="row mt-4"><div class="col-md-8">
  <h4>Search results for "<?= htmlspecialchars($q) ?>"</h4>
  <?php if (empty($results)): ?><p>No results</p><?php else: ?>
    <?php foreach ($results as $r): ?>
      <div class="card mb-2"><div class="card-body">
        <h5><?= htmlspecialchars($r['name']) ?></h5>
        <p><?= htmlspecialchars($r['description']) ?></p>
        <a href="product_view.php?id=<?= $r['id'] ?>">View</a>
      </div></div>
    <?php endforeach; ?>
  <?php endif; ?>
</div></div>
<?php require_once __DIR__.'/footer.php'; ?>
