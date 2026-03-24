<?php
require '../config/conexao.php';

// array produto (vazio)
$produto = [
    'id' => '',
    'descricao' => '',
    'qtde_estoque' => '',
    'preco' => '',
    'id_categoria' => ''
];

// Carrega produto se for edição
if (!empty($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Carrega categorias da tabela categoria
$stmtCategorias = $pdo->query("SELECT id, nome_categoria FROM categoria ORDER BY nome_categoria");
$categorias = $stmtCategorias->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $produto['id'] ? 'Editar' : 'Incluir' ?> Produto</title>
    <link rel="stylesheet" href="estilo_form.css">
</head>
<body>

    <div class="container">
        <h2 class="titulo"><?= $produto['id'] ? 'Editar' : 'Incluir' ?> Produto</h2>

        <form method="post" action="salvar.php" class="formulario">
            <input type="hidden" name="id" value="<?= $produto['id'] ?>">

            <div class="form-grupo">
                <label for="descricao">Descrição</label>
                <input type="text" id="descricao" name="descricao" required value="<?= htmlspecialchars($produto['descricao']) ?>">
            </div>

            <div class="form-grupo">
                <label for="qtde_estoque">Quantidade em Estoque</label>
                <input type="number" id="qtde_estoque" name="qtde_estoque" required value="<?= $produto['qtde_estoque'] ?>">
            </div>

            <div class="form-grupo">
                <label for="preco">Preço</label>
                <input type="text" id="preco" name="preco" required value="<?= $produto['preco'] ?>">
            </div>

            <div class="form-grupo">
                <label for="id_categoria">Categoria</label>
                <select name="id_categoria" id="id_categoria" required>
                    <option value="">Selecione uma categoria</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $produto['id_categoria'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['nome_categoria']) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="form-botoes">
                <button type="submit" class="botao salvar">Salvar</button>
                <a href="index.php" class="botao cancelar">Cancelar</a>
            </div>
        </form>
    </div>

</body>
</html>
