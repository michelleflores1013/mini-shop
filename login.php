<?php
require_once __DIR__ . '/includes/header.php';
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT id,password FROM users WHERE username=?');
    $stmt->execute([$username]);
    $u = $stmt->fetch();
    if ($u && password_verify($password,$u['password'])) {
        $_SESSION['user_id'] = $u['id'];
        header('Location: index.php'); exit;
    } else {
        $errors[] = 'Invalid credentials';
    }
}
?>
<div class="row justify-content-center mt-4">
  <div class="col-md-6">
    <h3>Login</h3>
    <?php if ($errors): ?><div class="alert alert-danger"><?= implode('<br>', array_map('htmlspecialchars',$errors)) ?></div><?php endif; ?>
    <form method="post">
      <div class="mb-3"><label>Username</label><input name="username" class="form-control" required></div>
      <div class="mb-3"><label>Password</label><input name="password" type="password" class="form-control" required></div>
      <button class="btn btn-primary">Login</button>
    </form>
  </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
