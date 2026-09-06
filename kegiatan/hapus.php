<?php
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
  if ($id) {
    $stmt = $pdo->prepare("DELETE FROM kegiatan WHERE id = ?");
    $stmt->execute([$id]);
  }
}
header("Location: " . base_url('kegiatan/index.php?msg=deleted'));
exit;
