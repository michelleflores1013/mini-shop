<?php
require_once __DIR__ . '/header.php';
$id = (int)($_GET['id'] ?? 0);
$c = $pdo->prepare('SELECT product_id,user_id FROM comments WHERE id=?'); $c->execute([$id]); $row = $c->fetch();
if (!$row) { header('Location: index.php'); exit; }
if (!isset($_SESSION['user_id']) || ($_SESSION['user_id'] != $row['user_id'] && !$pdo->query('SELECT is_admin FROM users WHERE id='.((int)$_SESSION['user_id']?:0))->fetchColumn())) { header('Location: index.php'); exit; }
$del = $pdo->prepare('DELETE FROM comments WHERE id=?'); $del->execute([$id]);
header('Location: product_view.php?id='.$row['product_id']);
