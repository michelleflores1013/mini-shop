<?php
require_once __DIR__ . '/../../db.php';
class HomeController {
    public function index() {
        $stmt = $GLOBALS['pdo']->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 12");
        $products = $stmt->fetchAll();
        include __DIR__ . '/../views/home.php';
    }
}
