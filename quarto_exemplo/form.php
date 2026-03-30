<?php
require '../config/conexao.php';
$produto = ['id' => '', 'descricao' => '', 'qtde_estoque' => '', 'preco' => ''];

if (!empty($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $produto['id'] ? 'Editar' : 'Incluir' ?> Produto</title>
    <link rel="stylesheet" href="../css/estilo_form.css">
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

            <div class="form-botoes">
                <button type="submit" class="botao salvar">Salvar</button>
                <a href="index.php" class="botao cancelar">Cancelar</a>
            </div>
        </form>
    </div>

</body>
</html>
