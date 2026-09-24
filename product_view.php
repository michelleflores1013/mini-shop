<?php
require_once __DIR__ . '/includes/header.php';
$id = (int)($_GET['id'] ?? 0);
$p = $pdo->prepare('SELECT p.*, u.username FROM products p LEFT JOIN users u ON u.id=p.user_id WHERE p.id=?');
$p->execute([$id]); $prod = $p->fetch();
if (!$prod) { echo '<div class="alert alert-danger">Product not found</div>'; require_once __DIR__.'/footer.php'; exit; }
// fetch comments
$cm = $pdo->prepare('SELECT c.*, u.username FROM comments c JOIN users u ON u.id=c.user_id WHERE c.product_id=? ORDER BY c.created_at'); $cm->execute([$id]); $comments = $cm->fetchAll();

// likes
$likeCount = $pdo->prepare('SELECT COUNT(*) FROM likes WHERE product_id=?'); $likeCount->execute([$id]); $likes = (int)$likeCount->fetchColumn();
$liked = false;
if (isset($_SESSION['user_id'])){
  $l = $pdo->prepare('SELECT 1 FROM likes WHERE product_id=? AND user_id=?'); $l->execute([$id,$_SESSION['user_id']]); $liked = (bool)$l->fetchColumn();
}
?>
<div class="row mt-4">
  <div class="col-md-6">
    <img src="images/<?= htmlspecialchars($prod['image']?:'placeholder.png') ?>" class="img-fluid" style="height:360px;object-fit:cover">
  </div>
  <div class="col-md-6">
    <h3><?= htmlspecialchars($prod['name']) ?></h3>
    <p><?= nl2br(htmlspecialchars($prod['description'])) ?></p>
    <p><strong>PHP <?= number_format($prod['price'],2) ?></strong></p>
    <?php if (!isset($_SESSION['user_id'])): ?>
      <a href="login.php" class="btn btn-primary">Sign in to buy</a>
    <?php else: ?>
      <button class="btn btn-success" disabled>Buy (sign-in required)</button>
    <?php endif; ?>

    <hr>
    <h5>Comments</h5>
    <?php if (isset($_SESSION['user_id'])): ?>
      <form method="post" action="comment_action.php">
        <input type="hidden" name="product_id" value="<?= $prod['id'] ?>">
        <div class="mb-2"><textarea name="content" class="form-control" required></textarea></div>
        <button class="btn btn-sm btn-primary">Post Comment</button>
      </form>
    <?php else: ?>
      <p><a href="login.php">Sign in</a> to comment.</p>
    <?php endif; ?>

    <div class="mt-3">
      <form method="post" action="like_action.php" style="display:inline">
        <input type="hidden" name="product_id" value="<?= $prod['id'] ?>">
        <?php if (isset($_SESSION['user_id'])): ?>
          <input type="hidden" name="action" value="<?= $liked ? 'unlike' : 'like' ?>">
          <button class="btn btn-sm <?= $liked ? 'btn-danger' : 'btn-outline-primary' ?>"><?= $liked ? 'Unlike' : 'Like' ?></button>
        <?php else: ?>
          <a href="login.php" class="btn btn-sm btn-outline-primary">Sign in to like</a>
        <?php endif; ?>
      </form>
      <span class="ms-2"><?= $likes ?> likes</span>
    </div>

    <?php foreach ($comments as $c): ?>
      <div class="border rounded p-2 mb-2">
        <strong><?= htmlspecialchars($c['username']) ?></strong> <small class="text-muted"><?= $c['created_at'] ?></small>
        <p><?= nl2br(htmlspecialchars($c['content'])) ?></p>
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id']==$c['user_id']): ?>
          <a href="edit_comment.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-secondary">Edit</a>
          <a href="delete_comment.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-outline-danger">Delete</a>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>

  </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
