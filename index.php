<?php
// If MVC controller exists, use it; otherwise fall back to legacy index listing.
if (file_exists(__DIR__ . '/app/controllers/HomeController.php')) {
    require_once __DIR__ . '/app/controllers/HomeController.php';
    $c = new HomeController();
    $c->index();
    exit;
}

require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/db.php';

$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 12");
$products = $stmt->fetchAll();
?>

<div class="container mt-4">
    <h2>Featured Seafood</h2>
    <div class="row">
        <?php foreach ($products as $p): ?>
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
                    <img src="images/<?= htmlspecialchars($p['image'] ?: 'placeholder.png') ?>" class="card-img-top" style="height:160px;object-fit:cover">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($p['name']) ?></h5>
                        <p class="card-text">PHP <?= number_format($p['price'],2) ?></p>
                        <div class="mt-auto">
                            <a href="product_view.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-primary">View</a>
                            <?php if (!isset($_SESSION['user_id'])): ?>
                                <a href="login.php" class="btn btn-sm btn-outline-secondary">Sign in to buy</a>
                            <?php else: ?>
                                <button class="btn btn-sm btn-success" disabled>Buy (signin required)</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>