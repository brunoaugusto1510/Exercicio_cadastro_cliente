<?php
require "../config/conexao.php";

try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Busca todos os pedidos
    $sql = "
    SELECT p.id_pedido, p.data_pedido, p.cond_pagto,
           c.nome AS cliente,
           i.id_item, i.quantidade, i.preco,
           pr.descricao AS produto
    FROM pedido p
    INNER JOIN clientes c ON p.id_cliente = c.id
    INNER JOIN itens_pedido i ON p.id_pedido = i.id_pedido
    INNER JOIN produtos pr ON i.id_produto = pr.id
    ORDER BY p.id_pedido DESC, i.id_pedido
    ";
	
    $stmt = $pdo->query($sql);
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Organizar por pedido
    $pedidos = [];
    foreach ($dados as $linha) {
        $id = $linha['id_pedido'];
        if (!isset($pedidos[$id])) {
            $pedidos[$id] = [
                'cliente' => $linha['cliente'],
                'data'    => $linha['data_pedido'],
                'cond'    => $linha['cond_pagto'],
                'itens'   => [],
                'total'   => 0
            ];
        }
        $subtotal = $linha['quantidade'] * $linha['preco'];
        $pedidos[$id]['itens'][] = [
            'produto' => $linha['produto'],
            'qtde'    => $linha['quantidade'],
            'preco'   => $linha['preco'],
            'subtotal'=> $subtotal
        ];
        $pedidos[$id]['total'] += $subtotal;
    }

} catch (Exception $e) {
    die("Erro: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Listagem de Pedidos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 30px; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        th { background: #eee; }
        .total { font-weight: bold; color: darkblue; }
    </style>
</head>
<body>
    <h2>Pedidos Cadastrados</h2>
    <a href="form_pedido.php"> Novo Pedido</a>
    <hr>

    <?php if (count($pedidos) > 0): ?>
        <?php foreach ($pedidos as $id => $pedido): ?>
            <h3>Pedido <?= $id ?> - Cliente: <?= htmlspecialchars($pedido['cliente']) ?></h3>
            <p>Data: <?= date('d/m/Y', strtotime($pedido['data'])) ?> | Condições de Pagamento: <?= htmlspecialchars($pedido['cond']) ?></p>
			<table>
                <tr>
                    <th>Produto</th>
                    <th>Qtde</th>
                    <th>Preço Unitário</th>
                    <th>Subtotal</th>
                </tr>
                <?php foreach ($pedido['itens'] as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['produto']) ?></td>
                    <td><?= $item['qtde'] ?></td>
                    <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                    <td>R$ <?= number_format($item['subtotal'], 2, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" class="total">Total do Pedido</td>
                    <td class="total">R$ <?= number_format($pedido['total'], 2, ',', '.') ?></td>
                </tr>
            </table>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nenhum pedido cadastrado.</p>
    <?php endif; ?>
</body>
</html>

