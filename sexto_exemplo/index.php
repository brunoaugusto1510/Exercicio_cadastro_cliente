<?php
require '../config/conexao.php';

// Recebendo filtros
$descricao = $_GET['descricao'] ?? '';
$estoque_min = $_GET['estoque_min'] ?? '';
$estoque_max = $_GET['estoque_max'] ?? '';
$preco_min = $_GET['preco_min'] ?? '';
$preco_max = $_GET['preco_max'] ?? '';
$categoria = $_GET['categoria'] ?? '';

// Montando consulta com filtros
$sql = "SELECT p.*,c.nome_categoria FROM produtos p JOIN categoria c ON p.id_categoria = c.id WHERE 1=1";

$params = [];

// fazendo os filtros
if ($descricao) {
    $sql .= " AND descricao LIKE :descricao";
    $params[':descricao'] = "%$descricao%";
}

if ($estoque_min !== '') {
    $sql .= " AND qtde_estoque >= :estoque_min";
    $params[':estoque_min'] = $estoque_min;
}

if ($estoque_max !== '') {
    $sql .= " AND qtde_estoque <= :estoque_max";
    $params[':estoque_max'] = $estoque_max;
}

if ($preco_min !== '') {
    $sql .= " AND preco >= :preco_min";
    $params[':preco_min'] = $preco_min;
}

if ($preco_max !== '') {
    $sql .= " AND preco <= :preco_max";
    $params[':preco_max'] = $preco_max;
}

if ($categoria) {
    $sql .= " AND nome_categoria LIKE :categoria";
    $params[':categoria'] = "%$categoria%";
}

$sql .= " ORDER BY descricao";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Produtos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

    <div class="container">
        <h2 class="titulo">Lista de Produtos</h2>
		<form method="get" class="form-filtros">
			<label>
			Descrição:
			<input type="text" name="descricao" value="<?= htmlspecialchars($descricao) ?>">
			</label>

			<label>
			Estoque (mínimo):
			<input type="number" name="estoque_min" value="<?= htmlspecialchars($estoque_min) ?>">
			</label>

			<label>
			Estoque (máximo):
			<input type="number" name="estoque_max" value="<?= htmlspecialchars($estoque_max) ?>">
			</label>

			<label>
			Preço (mínimo):
			<input type="number" step="0.01" name="preco_min" value="<?= htmlspecialchars($preco_min) ?>">
			</label>

			<label>
			Preço (máximo):
			<input type="number" step="0.01" name="preco_max" value="<?= htmlspecialchars($preco_max) ?>">
			</label>
			
			<label>
			Categoria:
			<input type="text" name="categoria" value="<?= htmlspecialchars($categoria) ?>">
			</label>

			<button type="submit" class="botao filtrar">Filtrar</button>
			<a href="index.php" class="botao limpar">Limpar Filtros</a>
		</form>


        <table class="tabela-produtos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Estoque</th>
                    <th>Preço</th>
					<th>Categoria</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['descricao']) ?></td>
                    <td><?= $p['qtde_estoque'] ?></td>
                    <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
					<td><?=htmlspecialchars($p['nome_categoria']) ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

</body>
</html>
