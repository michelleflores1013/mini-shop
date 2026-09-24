<?php
require_once __DIR__ . '/includes/header.php';
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: newsfeed.php'); exit; }
$title = trim($_POST['title'] ?? '');
$content = trim($_POST['content'] ?? '');
if ($content === '') { header('Location: newsfeed.php'); exit; }
$ins = $pdo->prepare('INSERT INTO posts (user_id,title,content,created_at) VALUES (?,?,?,NOW())');
$ins->execute([$_SESSION['user_id'],$title,$content]);
header('Location: newsfeed.php');
