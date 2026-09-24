<?php
require_once __DIR__ . '/header.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  if (!$username) $errors[] = 'Username required';
  if (strlen($password) < 6) $errors[] = 'Password must be 6+ chars';

  // simple uniqueness check
  $stmt = $pdo->prepare('SELECT id FROM users WHERE username=?'); $stmt->execute([$username]);
  if ($stmt->fetch()) $errors[] = 'Username taken';

  if (empty($errors)) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    // set fullname same as username, empty bio
    $ins = $pdo->prepare('INSERT INTO users (username,fullname,password,bio,created_at) VALUES (?,?,?,?,NOW())');
    $ins->execute([$username,$username,$hash,'']);
    $_SESSION['user_id'] = $pdo->lastInsertId();
    header('Location: index.php'); exit;
  }
}
?>
<div class="row justify-content-center mt-4">
  <div class="col-md-6">
    <h3>Register</h3>
    <?php if ($errors): ?><div class="alert alert-danger"><?= implode('<br>', array_map('htmlspecialchars',$errors)) ?></div><?php endif; ?>
    <form method="post">
      <div class="mb-3"><label>Username</label><input name="username" class="form-control" required></div>
      <div class="mb-3"><label>Password</label><input name="password" type="password" class="form-control" required></div>
      <button class="btn btn-primary">Register</button>
    </form>
  </div>
</div>
<?php require_once __DIR__ . '/footer.php'; ?>
