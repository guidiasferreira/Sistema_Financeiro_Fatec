<?php 
    include_once('../conexao.php');
    include_once('../verifica_sessao.php');

    $error = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        try {
            $stmt = $conn -> prepare("SELECT * FROM proprietario WHERE email_proprietario = :email LIMIT 1");
            $stmt -> execute([":email" => $email]);
            $usuario = $stmt -> fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($senha, $usuario['senha'])) {
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
    <link rel="shortcut icon" href="../assets/img/plantar.png" type="image/x-icon">
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