<?php
require_once __DIR__ . '/header.php';
// show posts from all users, newest first
$posts = $pdo->query('SELECT p.*, u.username, u.avatar FROM posts p JOIN users u ON u.id=p.user_id ORDER BY p.created_at DESC LIMIT 50')->fetchAll();
?>
<div class="row mt-4"><div class="col-md-8">
  <h3>Newsfeed</h3>
  <?php if (isset($_SESSION['user_id'])): ?>
    <form method="post" action="post_action.php">
      <div class="mb-2"><input name="title" class="form-control" placeholder="Post title (optional)"></div>
      <div class="mb-2"><textarea name="content" class="form-control" required placeholder="Share something..."></textarea></div>
      <button class="btn btn-primary btn-sm">Post</button>
    </form>
  <?php else: ?>
    <p><a href="login.php">Sign in</a> to post.</p>
  <?php endif; ?>

  <?php foreach ($posts as $p): ?>
    <div class="card mb-2">
      <div class="card-body">
        <div class="d-flex align-items-center mb-2">
          <img src="images/<?= htmlspecialchars($p['avatar']?:'avatar.png') ?>" style="width:40px;height:40px;object-fit:cover;border-radius:50%" class="me-2">
          <div>
            <strong><?= htmlspecialchars($p['username']) ?></strong><br>
            <small class="text-muted"><?= $p['created_at'] ?></small>
          </div>
        </div>
        <?php if ($p['title']): ?><h5><?= htmlspecialchars($p['title']) ?></h5><?php endif; ?>
        <p><?= nl2br(htmlspecialchars($p['content'])) ?></p>
      </div>
    </div>
  <?php endforeach; ?>
</div></div>
<?php require_once __DIR__ . '/footer.php'; ?>
