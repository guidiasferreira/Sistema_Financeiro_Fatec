<?php
    include_once('../conexao.php');
    include_once('../verifica_sessao.php');

    $error = "";
    
    if ($_SERVER['REQUEST_METHOD'] === "POST") {  
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        
        try {
            $stmt = $conn -> prepare("INSERT INTO proprietario (nome_proprietario, email_proprietario, senha) VALUES (:nome, :email, :senha)");
            
            $stmt -> execute(
                [":nome" => $nome, 
                ":email" => $email, 
                ":senha" => $senha_hash]
            );

            header("location: login.php");
            exit;

        } catch (PDOException $e) {
            if ($e -> errorInfo[1] == 1062) { $error = "Este e-mail já está em uso."; }
            else { $error = "Erro ao tentar registrar: " .$e -> getMessage(); }
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/cadastro_proprietario.css">
    <link rel="shortcut icon" href="../assets/img/plantar.png" type="image/x-icon">
    <title>Cadastro Proprietário</title>
</head>
<body>
    <div class="container">
        <div class="menu">
            <form action="cadastro_proprietario.php" method="POST" class="form">
                <h1>Cadastro</h1>
                <input type="text" name="nome" placeholder="Nome" required class="inputs">
                <input type="email" name="email" placeholder="E-mail" required class="inputs">
                <input type="password" name="senha" placeholder="Senha" required class="inputs">
                <input type="submit" name="cadastro" value="Cadastrar Proprietário" class="submit">
                <u>Já possui uma conta? <a href="login.php">Logar</a></u>
                <p class="erro"></p>
            </form>
        </div>
    </div>

    <script>
        const errorMsg = <?php echo json_encode($error); ?>;

        if (errorMsg) {
            const errorElement = document.querySelector(".erro");
            errorElement.textContent = errorMsg;
            errorElement.style.display = "block";

            errorElement.animate([{ opacity: 0 }, { opacity: 1 }], {
            duration: 300,
            fill: "forwards"
        });
    }
    </script>
</body>
</html>