<?php
require_once __DIR__ . '/header.php';
$id = (int)($_GET['id'] ?? $_SESSION['user_id'] ?? 0);
$stmt = $pdo->prepare('SELECT id,username,fullname,bio,avatar,created_at FROM users WHERE id=?');
$stmt->execute([$id]);
$user = $stmt->fetch();
if (!$user) { echo '<div class="alert alert-danger">User not found</div>'; require_once __DIR__.'/footer.php'; exit; }
// fetch posts by user
$posts = $pdo->prepare('SELECT * FROM posts WHERE user_id=? ORDER BY created_at DESC'); $posts->execute([$id]);
$posts = $posts->fetchAll();
?>
<div class="row mt-4">
  <div class="col-md-4">
    <div class="card">
      <div class="card-body text-center">
        <img src="images/<?= htmlspecialchars($user['avatar']?:'avatar.png') ?>" class="rounded-circle mb-2" style="width:120px;height:120px;object-fit:cover">
        <h5><?= htmlspecialchars($user['fullname']) ?></h5>
        <p class="text-muted">@<?= htmlspecialchars($user['username']) ?></p>
        <p><?= nl2br(htmlspecialchars($user['bio'])) ?></p>
        <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id']==$user['id']): ?>
          <a href="edit_profile.php" class="btn btn-sm btn-primary">Edit Profile</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="col-md-8">
    <h4>Posts</h4>
    <?php foreach ($posts as $p): ?>
      <div class="card mb-2">
        <div class="card-body">
          <h5><?= htmlspecialchars($p['title']) ?></h5>
          <p><?= nl2br(htmlspecialchars($p['content'])) ?></p>
          <small class="text-muted"><?= $p['created_at'] ?></small>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<?php require_once __DIR__ . '/footer.php'; ?>
