<?php
require '../config/conexao.php'
$stmt = $pdo->query("SELECT * FROM produtos ORDER BY descricao");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Produtos</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>

    <div class="container">
        <h2 class="titulo">Lista de Produtos</h2>
        <a href="form.php" class="botao incluir">Incluir Produto</a>

        <table class="tabela-produtos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descrição</th>
                    <th>Estoque</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['descricao']) ?></td>
                    <td><?= $p['qtde_estoque'] ?></td>
                    <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                    <td>
                        <a href="form.php?id=<?= $p['id'] ?>" class="botao editar">Editar</a>
                        <a href="excluir.php?id=<?= $p['id'] ?>" class="botao excluir" onclick="return confirm('Confirmar exclusão?')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

</body>
</html>
