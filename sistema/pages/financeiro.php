<?php
    session_start();
    include_once('../conexao.php');

    if (!isset($_SESSION['id_proprietario'])) {
        header('Location: login.php');
        exit;
    }

    $nome = $_SESSION['nome_proprietario'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financeiro</title>
    <link rel="stylesheet" href="../assets/css/financeiro.css">
</head>
<body>

    <div class="container">
        <?php include "dashboard.php";?>
        <main>
            <?php echo "<h1>Seja Bem-vindo(a) de volta, <u>$nome</u></h1>"; ?>
            <div class="box">
                <div class="gasto">
                    <h3>Lucro Total</h3>
                    <p>R$ 700.000,00</p>
                </div>
                <div class="lucro">
                    <h3>Faturamento</h3>   
                    <p>R$ 1.000.000,00</p>   
                </div>
            </div>

            <div class="menu">
                <div class="fazenda">
                    <h3>Fazendas Ativas</h3>
                    <p>3</p>
                </div>
                <div class="roi">
                    <h3>ROI Médio</h3>
                    <p>55,5%</p>
                </div>
            </div>
        </main>
    </div>
    
</body>
</html>