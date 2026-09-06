<?php
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
  if ($id) {
    $stmt = $pdo->prepare("DELETE FROM anggota WHERE id = ?");
    $stmt->execute([$id]);
  }
}
header("Location: " . base_url('anggota/index.php?msg=deleted'));
exit;
