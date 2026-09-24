<?php require_once __DIR__ . '/layout/header.php'; ?>
<div class="container mt-4">
  <h2>Featured Seafood (MVC)</h2>
  <div class="row">
    <?php foreach ($products as $p): ?>
      <div class="col-md-3 col-sm-6 mb-4">
        <div class="card h-100">
          <img src="/mini-shop/images/<?= htmlspecialchars($p['image'] ?: 'placeholder.png') ?>" class="card-img-top" style="height:160px;object-fit:cover">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?= htmlspecialchars($p['name']) ?></h5>
            <p class="card-text">PHP <?= number_format($p['price'],2) ?></p>
            <div class="mt-auto">
              <a href="/mini-shop/product_view.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-primary">View</a>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<?php require_once __DIR__ . '/layout/footer.php'; ?>
