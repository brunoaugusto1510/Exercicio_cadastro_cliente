<?php
$servidor = "localhost";
$usuario  = "root";
$senha    = "";
$banco    = "banco_exemplo";

try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_GET['id'] ?? null;

    if (!$id) {
        die("ID do cliente não informado.");
    }

    $stmt = $pdo->prepare("SELECT * FROM clientes WHERE id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $cliente = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$cliente) {
        die("Cliente não encontrado.");
    }
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
	<link rel="stylesheet" href="style_editar.css">
</head>
<body>
    <!--h1>Editar Cliente</h1-->

    <form action="atualizar_cliente.php" method="POST">
        <input type="hidden" name="id" value="<?= $cliente['id'] ?>">

        <label for="nome">Nome:</label>
        <input type="text" name="nome" value="<?= htmlspecialchars($cliente['nome']) ?>" required><br>

        <label for="email">E-mail:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($cliente['email']) ?>" required><br>

        <label for="telefone">Telefone:</label>
        <input type="text" name="telefone" value="<?= htmlspecialchars($cliente['telefone']) ?>"><br>

        <label for="endereco">Endereço:</label>
        <input type="text" name="endereco" value="<?= htmlspecialchars($cliente['endereco']) ?>"><br>

        <label for="tipo_cliente">Tipo de Cliente:</label>
        <select name="tipo_cliente" required>
            <option value="pf" <?= $cliente['tipo_cliente'] === 'pf' ? 'selected' : '' ?>>Pessoa Física</option>
            <option value="pj" <?= $cliente['tipo_cliente'] === 'pj' ? 'selected' : '' ?>>Pessoa Jurídica</option>
        </select><br>

        <label>Sexo:</label>
        <input type="radio" name="sexo" value="masculino" <?= $cliente['sexo'] === 'masculino' ? 'checked' : '' ?>> Masculino
        <input type="radio" name="sexo" value="feminino" <?= $cliente['sexo'] === 'feminino' ? 'checked' : '' ?>> Feminino
        <br><br>

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>
