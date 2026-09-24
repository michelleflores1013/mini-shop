<?php
require_once __DIR__ . '/header.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$uid = $_SESSION['user_id'];
$u = $pdo->prepare('SELECT username,fullname,bio,avatar FROM users WHERE id=?'); $u->execute([$uid]); $user = $u->fetch();
$errors=[];
if ($_SERVER['REQUEST_METHOD']==='POST'){
    $fullname = trim($_POST['fullname'] ?? '');
    $bio = trim($_POST['bio'] ?? '');
    if (!$fullname) $errors[]='Full name required';
    // handle avatar upload
    if (!empty($_FILES['avatar']['tmp_name'])){
        $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $fn = 'avatar_'. $uid . '.' . $ext;
        move_uploaded_file($_FILES['avatar']['tmp_name'], __DIR__.'/images/'.$fn);
        $avatar = $fn;
    } else { $avatar = $user['avatar']; }
    if (empty($errors)){
        $stmt = $pdo->prepare('UPDATE users SET fullname=?,bio=?,avatar=? WHERE id=?');
        $stmt->execute([$fullname,$bio,$avatar,$uid]);
        header('Location: profile.php?id='.$uid); exit;
    }
}
?>
<div class="row justify-content-center mt-4">
  <div class="col-md-6">
    <h3>Edit Profile</h3>
    <?php if ($errors): ?><div class="alert alert-danger"><?= implode('<br>', array_map('htmlspecialchars',$errors)) ?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data">
      <div class="mb-3"><label>Full name</label><input name="fullname" value="<?= htmlspecialchars($user['fullname']) ?>" class="form-control" required></div>
      <div class="mb-3"><label>Bio</label><textarea name="bio" class="form-control"><?= htmlspecialchars($user['bio']) ?></textarea></div>
      <div class="mb-3"><label>Avatar</label><input type="file" name="avatar" class="form-control"></div>
      <button class="btn btn-primary">Save</button>
    </form>
  </div>
</div>
<?php require_once __DIR__.'/footer.php'; ?>
