<?php
require_once __DIR__ . '/includes/header.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$is_admin = $pdo->prepare('SELECT is_admin FROM users WHERE id=?'); $is_admin->execute([$_SESSION['user_id']]); if (!$is_admin->fetchColumn()) { echo '<div class="alert alert-danger">Unauthorized</div>'; require_once __DIR__.'/footer.php'; exit; }
$id = (int)($_GET['id'] ?? 0);
$del = $pdo->prepare('DELETE FROM products WHERE id=?'); $del->execute([$id]);
header('Location: admin.php');
