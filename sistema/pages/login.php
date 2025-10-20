<?php 
    session_start();
    include_once('../conexao.php');

    $error = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        try {
            $stmt = $conn -> prepare("SELECT * FROM proprietario WHERE email_proprietario = :email LIMIT 1");
            $stmt -> execute([":email" => $email]);
            $usuario = $stmt -> fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($senha, $usuario['senha'])) {
                $_SESSION['id_proprietario'] = $usuario['id_proprietario'];
                $_SESSION['email_proprietario'] = $usuario['email_proprietario'];
                $_SESSION['nome_proprietario'] = $usuario['nome_proprietario'];

                header('Location: financeiro.php');
                exit;

            }  else {
                $error = "E-mail e/ou senha inválido(s).";
            }

        } catch (PDOException) {
            $error = "Erro ao tentar fazer o login: " . $e -> getMessage();
        }
    }
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/login.css">
    <title>Login</title>
</head>

<body>
    <div class="container">
        <div class="menu">
            <form action="login.php" method="POST" class="form">
                <h1>Login</h1>
                <input type="email" name="email" placeholder="E-mail" required class="inputs">
                <input type="password" name="senha" placeholder="Senha" required class="inputs">
                <input type="submit" name="logar" value="Entrar" class="submit">
                <u>Não possui uma conta? <a href="cadastro_proprietario.php">Cadastrar</a></u>

                <?php if($error != "") { echo "<p style='color:red;'>$error</p>"; } ?>
            </form>
        </div>
    </div>
</body>
</html>