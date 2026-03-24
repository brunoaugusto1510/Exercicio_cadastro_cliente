<?php
require '../config/conexao.php';

$id = $_POST['id'];
$descricao = $_POST['descricao'];
$qtde_estoque = $_POST['qtde_estoque'];
$preco = str_replace(',', '.', $_POST['preco']); // compatível com input brasileiro
$id_categoria = $_POST['id_categoria'];

if ($id) {
    // Atualizar
    $sql = "UPDATE produtos SET descricao = ?, qtde_estoque = ?, preco = ?, id_categoria = ? WHERE id = ?";
    $pdo->prepare($sql)->execute([$descricao, $qtde_estoque, $preco, $id_categoria, $id]);
} else {
    // Inserir 
    $sql = "INSERT INTO produtos (descricao, qtde_estoque, preco, id_categoria) VALUES (?, ?, ?, ?)";
    $pdo->prepare($sql)->execute([$descricao, $qtde_estoque, $preco, $id_categoria]);
}

header("Location: index.php");
exit;
