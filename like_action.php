<?php
require_once __DIR__ . '/header.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
$product_id = (int)($_POST['product_id'] ?? 0);
$action = $_POST['action'] ?? '';
if ($action === 'like'){
    $ins = $pdo->prepare('INSERT IGNORE INTO likes (product_id,user_id,created_at) VALUES (?,?,NOW())');
    $ins->execute([$product_id,$_SESSION['user_id']]);
} else {
    $del = $pdo->prepare('DELETE FROM likes WHERE product_id=? AND user_id=?');
    $del->execute([$product_id,$_SESSION['user_id']]);
}
header('Location: product_view.php?id='.$product_id);
