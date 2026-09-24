<?php
require_once __DIR__ . '/header.php';
$stmt = $pdo->query('SELECT * FROM products ORDER BY created_at DESC');
$products = $stmt->fetchAll();
?>
<div class="row mt-4">
  <?php foreach ($products as $p): ?>
    <div class="col-md-4 mb-3">
      <div class="card">
        <img src="images/<?= htmlspecialchars($p['image']?:'placeholder.png') ?>" class="card-img-top" style="height:200px;object-fit:cover">
        <div class="card-body">
          <h5><?= htmlspecialchars($p['name']) ?></h5>
          <p><?= htmlspecialchars($p['description']) ?></p>
          <p><strong>PHP <?= number_format($p['price'],2) ?></strong></p>
          <a href="product_view.php?id=<?= $p['id'] ?>" class="btn btn-primary btn-sm">View</a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php require_once __DIR__ . '/footer.php'; ?>
