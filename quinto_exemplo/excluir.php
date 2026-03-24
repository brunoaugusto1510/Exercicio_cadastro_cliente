<?php
require '../config/conexao.php';

if (!empty($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->execute([$_GET['id']]);
}

header("Location: index.php");
exit;
