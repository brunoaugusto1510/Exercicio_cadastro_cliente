<?php
$servidor = "localhost";
$usuario  = "root";
$senha    = "";
$banco    = "banco_exemplo";

try {
    $pdo = new PDO("mysql:host=$servidor;dbname=$banco;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = $_GET['id'] ?? null;

    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM clientes WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: incluir_clientes_3.php?msg=Cliente excluído com sucesso");
            exit;
        } else {
            echo "Erro ao excluir cliente.";
        }
    } else {
        echo "ID do cliente não informado.";
    }
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
