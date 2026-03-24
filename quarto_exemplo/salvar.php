<?php
require '../config/conexao.php'

$id = $_POST['id'];
$descricao = $_POST['descricao'];
$qtde_estoque = $_POST['qtde_estoque'];
$preco = str_replace(',', '.', $_POST['preco']); // compatível com input brasileiro

if ($id) {
    // Atualizar
    $sql = "UPDATE produtos SET descricao = ?, qtde_estoque = ?, preco = ? WHERE id = ?";
    $pdo->prepare($sql)->execute([$descricao, $qtde_estoque, $preco, $id]);
} else {
    // Inserir novo
    $sql = "INSERT INTO produtos (descricao, qtde_estoque, preco) VALUES (?, ?, ?)";
    $pdo->prepare($sql)->execute([$descricao, $qtde_estoque, $preco]);
}

header("Location: index.php");
exit;
