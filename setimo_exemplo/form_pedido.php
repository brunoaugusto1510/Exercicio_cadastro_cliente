<?php
require '../config/conexao.php';

$stmt = $pdo->query("SELECT * FROM clientes ORDER BY nome");
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);


$stmt2 = $pdo->query("SELECT * FROM produtos ORDER BY descricao");
$produtos = $stmt2->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lançar Pedido</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        input, select { margin: 5px; padding: 5px; }
        .produto { margin-bottom: 10px; border: 1px solid #ccc; padding: 10px; }
    </style>
    <script>
	    function addProduto() {
            let container = document.getElementById("produtos");
            let div = document.createElement("div");
            div.className = "produto";
            div.innerHTML = `
                Produto:
                <select name="id_produto[]">
                    <?php foreach ($produtos as $p): ?>
                        <option value="<?= $p['id'] ?>">
                            <?= $p['descricao'] ?> (R$ <?= number_format($p['preco'],2,',','.') ?> | Estoque: <?= $p['qtde_estoque'] ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                Qtde: <input type="number" name="quantidade[]" min="1" value="1">
                <button type="button" onclick="this.parentNode.remove()">Remover</button>
            `;
            container.appendChild(div);
        }
    </script>
</head>
<body>
    <h2>Novo Pedido</h2>
    <form action="salvar_pedido.php" method="POST">
        Cliente:
        <select name="id_cliente" required>
            <option value="">-- Selecione --</option>
            <?php foreach ($clientes as $c): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nome']) ?></option>
            <?php endforeach; ?>
        </select><br>

        Data: <input type="date" id="data_pedido" name="data_pedido" required><br>
        Condições de Pagamento: <input type="text" name="cond_pagto" required><br>
		<script>
		 // Pega o campo de data com id
		const campoData = document.getElementById("data_pedido");

		// Gera a data de hoje no formato YYYY-MM-DD
		const hoje = new Date().toISOString().split("T")[0];
		
		campoData.value = hoje; // Preenche o campo com a data atual
		</script>

        <h3>Itens do Pedido</h3>
        <div id="produtos"></div>
        <button type="button" onclick="addProduto()">Adicionar Produto</button><br><br>

        <input type="submit" value="Salvar Pedido">
    </form>
</body>
</html>
