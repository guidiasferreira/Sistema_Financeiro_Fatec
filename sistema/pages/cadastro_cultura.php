<?php
    session_start();
    include_once('../conexao.php');
    $msg = "";

    if (!isset($_SESSION['id_proprietario'])) {
        header('Location: login.php');
        exit;
    }
    
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $nome = $_POST['nome'];
        $valor_unitario = $_POST['valor_unitario'];
        $id_proprietario = $_SESSION['id_proprietario'];

        try {
            $stmt = $conn->prepare("INSERT INTO produto (nome_produto, valor_unitario, id_proprietario) VALUES (:nome, :valor_unitario, :id_proprietario)");
            $stmt -> execute([":nome" => $nome, ":valor_unitario" => $valor_unitario, ":id_proprietario" => $id_proprietario]);

            header("location: financeiro.php");  
            exit;

        } catch (PDOException $e) {
            $msg = "Erro ao tentar registrar: " . $e->getMessage();
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/cadastro_cultura.css">
    <title>Cadastro de Cultura</title>
</head>
<body>
    <div class="container">
        <?php include "dashboard.php"; ?>
        <main>
            <div class="menu">
                <form action="cadastro_cultura.php" method="POST" class="form">
                    <h1>Cadastro de Cultura</h1>
                    <input type="text" name="nome" placeholder="Nome" required class="inputs">
                    <input type="text" name="valor_unitario" placeholder="Valor na bolsa" required class="inputs">
                    <input type="submit" name="cadastro" value="Cadastrar Cultura" class="submit">
                </form>
            </div>
        </main>
    </div>
</body>
</html>