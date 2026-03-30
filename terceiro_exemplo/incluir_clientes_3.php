<?php
$servidor = "localhost";
$usuario  = "root";
$senha    = "";
$banco    = "banco_exemplo";

try {
    // Criando a conexão com PDO
    $pdo = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $mensagem = "";

    // Se o formulário foi enviado
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $nome        = $_POST['nome'] ?? null;
        $email       = $_POST['email'] ?? null;
        $telefone    = $_POST['telefone'] ?? null;
        $endereco    = $_POST['endereco'] ?? null;
        $tipo_cliente = $_POST['tipo_cliente'] ?? null;
        $sexo        = $_POST['sexo'] ?? null;

        if ($nome && $email && $tipo_cliente && $sexo) {
            $sql = "INSERT INTO clientes 
                    (nome, email, telefone, endereco, tipo_cliente, sexo) 
                    VALUES (:nome, :email, :telefone, :endereco, :tipo_cliente, :sexo)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":nome", $nome);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":telefone", $telefone);
            $stmt->bindParam(":endereco", $endereco);
            $stmt->bindParam(":tipo_cliente", $tipo_cliente);
            $stmt->bindParam(":sexo", $sexo);

            if ($stmt->execute()) {
                $mensagem = "Cliente cadastrado com sucesso!";
            } else {
                $mensagem = "Erro ao cadastrar cliente.";
            }
        } else {
            $mensagem = "Preencha todos os campos obrigatórios.";
        }
    }

    // Buscar todos os clientes cadastrados
    $stmt = $pdo->query("SELECT * FROM clientes ORDER BY id DESC");
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Clientes</title>
    <link rel="stylesheet" href="../css/style.css">
    
</head>
<body>
    <header>
        <h1>Cadastro de Clientes</h1>
    </header>
    <main>
        <section class="formulario">
            <h2>Adicionar Novo Cliente</h2>

            <?php if ($mensagem): ?>
                <div class="mensagem"><?= $mensagem ?></div>
            <?php endif; ?>

            <form action="incluir_clientes_3.php" method="POST">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>

                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" placeholder="(99) 99999-9999">

                <label for="endereco">Endereço:</label>
                <input type="text" id="endereco" name="endereco">

                <label for="tipo_cliente">Tipo de Cliente:</label>
                <select id="tipo_cliente" name="tipo_cliente" required>
                    <option value="">Selecione</option>
                    <option value="pf">Pessoa Física</option>
                    <option value="pj">Pessoa Jurídica</option>
                </select>

                <label>Sexo:</label>
                <div class="radio-group">
                    <input type="radio" id="masculino" name="sexo" value="masculino" required>
                    <label for="masculino">Masculino</label>
                    <input type="radio" id="feminino" name="sexo" value="feminino">
                    <label for="feminino">Feminino</label>
                </div>

                <button type="submit">Cadastrar Cliente</button>
            </form>
        </section>

	<section class="lista">
		<h2>Clientes Cadastrados</h2>
		<table>
			<thead>
				<tr>
					<th>ID</th>
					<th>Nome</th>
					<th>E-mail</th>
					<th>Telefone</th>
					<th>Endereço</th>
					<th>Tipo</th>
					<th>Sexo</th>
					<th>Ações</th>
				</tr>
			</thead>
			<tbody>
            <?php if ($clientes): ?>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?= $cliente['id'] ?></td>
                        <td><?= htmlspecialchars($cliente['nome']) ?></td>
                        <td><?= htmlspecialchars($cliente['email']) ?></td>
                        <td><?= htmlspecialchars($cliente['telefone']) ?></td>
                        <td><?= htmlspecialchars($cliente['endereco']) ?></td>
                        <td><?= $cliente['tipo_cliente'] == 'pf' ? 'Pessoa Física' : 'Pessoa Jurídica' ?></td>
                        <td><?= ucfirst($cliente['sexo']) ?></td>
                        <td>
						  <div class="acoes">
						  <!-- Botão Editar -->
							<a href="editar_cliente.php?id=<?= $cliente['id'] ?>">
								<button type="button" class="btn-editar">Editar</button>
							</a>
						  <!-- Botão Excluir -->
							<a href="excluir_cliente.php?id=<?= $cliente['id'] ?>" 
								onclick="return confirm('Tem certeza que deseja excluir este cliente?');">
								<button type="button" class="btn-excluir">Excluir</button>
							</a>  
                          </div>							
                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="8">Nenhum cliente cadastrado.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</section>
</main>
</body>
</html>

