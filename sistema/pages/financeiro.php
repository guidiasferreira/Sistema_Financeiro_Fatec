<?php
    include_once('../conexao.php');
    include_once('../verifica_login.php');

    $nome = $_SESSION['nome_proprietario'];
    $id_proprietario = $_SESSION['id_proprietario'];
    $msg = "";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/financeiro.css">
    <link rel="shortcut icon" href="../assets/img/plantar.png" type="image/x-icon">
    <title>Financeiro</title>
</head>
<body>
<div class="container">
    <?php include "dashboard.php"; ?>
    <main>
        <h1>Seja Bem-vindo(a) de volta, <u><?= htmlspecialchars($nome) ?></u></h1>

        <div class="cards">
            <div class="card">
                <h3>Investimento Total</h3>
                <p>R$ 120.000,00</p>
            </div>

            <div class="card">
                <h3>Faturamento</h3>
                <p>R$ 185.500,00</p>
            </div>

            <div class="card">
                <h3>Lucro</h3>
                <p>R$ 65.500,00</p>
            </div>

            <div class="card">
                <h3>Investimento por hectare</h3>
                <p>R$ 2.400,00</p>
            </div>

            <div class="card">
                <h3>ROI médio</h3>
                <p>54,5%</p>
            </div>

            <div class="card">
                <h3>Ponto de Equilíbrio</h3>
                <p>64,7%</p>
            </div>

            <div class="actions">
                <button class="excel"><img src="../assets/img/excel.png" alt="Ícone de Excel">Gerar Excel</button>
                <button class="pdf"><img src="../assets/img/pdf.png" alt="Ícone de PDF">Gerar PDF</button>
            </div>
        </div>

        <div class="table-container">
            <h3>Fazendas Ativas</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nome da Fazenda</th>
                        <th>Tamanho (ha)</th>
                        <th>Investimento por ha</th>
                        <th>Produção por ha (saca)</th>
                        <th>Preço da saca</th>
                        <th>Investimento total</th>
                        <th>Lucro</th>
                        <th>ROI</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Fazenda Boa Esperança</td>
                        <td>50,00</td>
                        <td>R$ 2.000,00</td>
                        <td>60,00</td>
                        <td>R$ 90,00</td>
                        <td>R$ 100.000,00</td>
                        <td>R$ 70.000,00</td>
                        <td>70,0%</td>
                    </tr>
                    <tr>
                        <td>Fazenda Santa Luzia</td>
                        <td>30,00</td>
                        <td>R$ 2.500,00</td>
                        <td>55,00</td>
                        <td>R$ 92,00</td>
                        <td>R$ 75.000,00</td>
                        <td>R$ 35.000,00</td>
                        <td>46,7%</td>
                    </tr>
                    <tr>
                        <td>Fazenda Boa Vista</td>
                        <td>50,00</td>
                        <td>R$ 2.500,00</td>
                        <td>130,00</td>
                        <td>R$ 92,00</td>
                        <td>R$ 75.000,00</td>
                        <td>R$ 35.000,00</td>
                        <td>78,7%</td>
                    </tr>
                    <tr>
                        <td>Fazenda Primavera</td>
                        <td>20,00</td>
                        <td>R$ 2.300,00</td>
                        <td>58,00</td>
                        <td>R$ 91,00</td>
                        <td>R$ 46.000,00</td>
                        <td>R$ 28.000,00</td>
                        <td>60,8%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>
