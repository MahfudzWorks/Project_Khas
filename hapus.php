<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

  if ($id) {
    try {
      $stmt = $pdo->prepare("DELETE FROM produk_khas WHERE id = :id");
      $stmt->execute([':id' => $id]);

      header("Location: index.php?status=success_delete");
      exit;
    } catch (PDOException $e) {
      header("Location: index.php?status=error");
      exit;
    }
  }
}

header("Location: index.php");
exit;
