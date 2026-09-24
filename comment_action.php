<?php
require_once __DIR__ . '/header.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php'); exit; }
$product_id = (int)($_POST['product_id'] ?? 0);
$content = trim($_POST['content'] ?? '');
if ($content === '') { header('Location: product_view.php?id='.$product_id); exit; }
$ins = $pdo->prepare('INSERT INTO comments (product_id,user_id,content,created_at) VALUES (?,?,?,NOW())');
$ins->execute([$product_id,$_SESSION['user_id'],$content]);
header('Location: product_view.php?id='.$product_id);
