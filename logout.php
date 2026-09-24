<?php
require_once __DIR__ . '/header.php';
session_destroy();
header('Location: index.php');
exit;
