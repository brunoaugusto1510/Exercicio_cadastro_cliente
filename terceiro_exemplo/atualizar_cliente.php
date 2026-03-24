<?php
$servidor = "localhost";
$usuario  = "root";
$senha    = "";
$banco    = "banco_exemplo";

try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id          = $_POST['id'] ?? null;
    $nome        = $_POST['nome'] ?? null;
    $email       = $_POST['email'] ?? null;
    $telefone    = $_POST['telefone'] ?? null;
    $endereco    = $_POST['endereco'] ?? null;
    $tipo_cliente = $_POST['tipo_cliente'] ?? null;
    $sexo        = $_POST['sexo'] ?? null;

    if ($id && $nome && $email && $tipo_cliente && $sexo) {
        $sql = "UPDATE clientes 
                   SET nome = :nome, email = :email, telefone = :telefone, 
                       endereco = :endereco, tipo_cliente = :tipo_cliente, sexo = :sexo
                 WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":telefone", $telefone);
        $stmt->bindParam(":endereco", $endereco);
        $stmt->bindParam(":tipo_cliente", $tipo_cliente);
        $stmt->bindParam(":sexo", $sexo);

        if ($stmt->execute()) {
            header("Location: incluir_clientes_3.php?msg=Cliente atualizado com sucesso");
            exit;
        } else {
            echo "Erro ao atualizar cliente.";
        }
    } else {
        echo "Preencha todos os campos obrigatórios.";
    }
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
