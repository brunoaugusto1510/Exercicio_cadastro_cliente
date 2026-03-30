<?php
require "../config/conexao.php";

try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Dados do pedido
    $id_cliente  = $_POST['id_cliente'];
    $data_pedido = $_POST['data_pedido'];
    $cond_pagto  = $_POST['cond_pagto'];

    $id_produtos = $_POST['id_produto'];
    $quantidades = $_POST['quantidade'];

    // abre a transação
    $pdo->beginTransaction();

    // Insert na tabela pedido
    $stmt = $pdo->prepare("INSERT INTO pedido (id_cliente, data_pedido, cond_pagto) VALUES (?, ?, ?)");
    $stmt->execute([$id_cliente, $data_pedido, $cond_pagto]);
    $id_pedido = $pdo->lastInsertId(); // retorna o id (pk) da tabela pedido

    // Insert na tabela itens pedido
    $stmt_item = $pdo->prepare("INSERT INTO itens_pedido (id_pedido, id_produto, quantidade, preco) VALUES (?, ?, ?, ?)");
    $stmt_estoque = $pdo->prepare("UPDATE produtos SET qtde_estoque = qtde_estoque - ? WHERE id = ? AND qtde_estoque >= ?");

    for ($i = 0; $i < count($id_produtos); $i++) {
        $id_prod = $id_produtos[$i];
        $qtde    = $quantidades[$i];

        // Busca preço do produto
        $stmt_preco = $pdo->prepare("SELECT preco, qtde_estoque FROM produtos WHERE id = ?");
        $stmt_preco->execute([$id_prod]);
        $produto = $stmt_preco->fetch(PDO::FETCH_ASSOC);

        if (!$produto) {
            throw new Exception("Produto ID $id_prod não encontrado!");
        }
        if ($produto['qtde_estoque'] < $qtde) {
            throw new Exception("Estoque insuficiente para o produto: " . $id_prod);
        }

        // Insere item do pedido
        $stmt_item->execute([$id_pedido, $id_prod, $qtde, $produto['preco']]);

        // Atualiza estoque
        $stmt_estoque->execute([$qtde, $id_prod, $qtde]);
    }

    $pdo->commit();

    echo "<p style='color:green;'>Pedido $id_pedido lançado com sucesso!</p>";
    echo "<a href='form_pedido.php'>Novo Pedido</a> | <a href='listar_pedidos.php'>Listar Pedidos</a>";

} catch (Exception $e) {
    $pdo->rollBack();
    echo "<p style='color:red;'>Erro: " . $e->getMessage() . "</p>";
}
