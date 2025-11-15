<?php
include_once('../conexao.php');
include_once('../verifica_login.php');

$nome = $_SESSION['nome_proprietario'];
$id_proprietario = $_SESSION['id_proprietario'];
$msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_fazenda'])) {
    $id_fazenda = $_POST['id_fazenda'];

    try {
        $sql1 = "DELETE FROM producao WHERE id_fazenda = :id_fazenda";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->execute([':id_fazenda' => $id_fazenda]);

        $sql2 = "DELETE FROM fazenda WHERE id_fazenda = :id_fazenda";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute([':id_fazenda' => $id_fazenda]);

        header("Location: financeiro.php");
        exit;
    } catch (PDOException $e) {
        echo "Erro ao excluir: " . $e->getMessage();
    }
}

try {
    $sqlInvestTotal = "
        SELECT 
        SUM((tamanho_hec * custo_hec)) AS v_custo_total 
        FROM fazenda 
        WHERE id_proprietario = :id_proprietario;";
    $stmtInvestTotal = $conn->prepare($sqlInvestTotal);
    $stmtInvestTotal->execute([':id_proprietario' => $id_proprietario]);
    $invest_total = $stmtInvestTotal->fetch(PDO::FETCH_ASSOC);

    $sqlFaturamentoTotal = "
        SELECT 
        SUM((p.valor_unitario * f.producao_hec) * f.tamanho_hec) AS v_receita_total, 
        SUM(f.tamanho_hec) AS tamanho_hec
        FROM fazenda f 
        JOIN producao p ON p.id_fazenda = f.id_fazenda 
        WHERE id_proprietario = :id_proprietario;";
    $stmtFaturamentoTotal = $conn->prepare($sqlFaturamentoTotal);
    $stmtFaturamentoTotal->execute([':id_proprietario' => $id_proprietario]);
    $faturamento_total = $stmtFaturamentoTotal->fetch(PDO::FETCH_ASSOC);

    // ✅ adicionamos o id_fazenda
    $sqlFazendas = "
        SELECT 
        f.id_fazenda,
        f.nome_fazenda,
        f.tamanho_hec,
        f.custo_hec,
        f.producao_hec,
        (f.tamanho_hec * f.custo_hec) AS investimento_total,
        ((p.valor_unitario * f.producao_hec) * f.tamanho_hec) AS faturamento_total,
        (((p.valor_unitario * f.producao_hec) * f.tamanho_hec) - (f.tamanho_hec * f.custo_hec)) AS lucro,
        ROUND(
            (
                (
                    ((p.valor_unitario * f.producao_hec) * f.tamanho_hec) 
                    - (f.tamanho_hec * f.custo_hec)
                ) / NULLIF((f.tamanho_hec * f.custo_hec), 0)
            ) * 100
        , 1) AS ROI
        FROM fazenda f
        JOIN producao p ON p.id_fazenda = f.id_fazenda
        WHERE f.id_proprietario = :id_proprietario;";
    $stmtFazendas = $conn->prepare($sqlFazendas);
    $stmtFazendas->execute([':id_proprietario' => $id_proprietario]);
    $fazendas = $stmtFazendas->fetchAll(PDO::FETCH_ASSOC);

    $sqlHectares = "
        SELECT SUM(tamanho_hec) AS total_hectares
        FROM fazenda
        WHERE id_proprietario = :id_proprietario
    ";
    $stmtHectares = $conn->prepare($sqlHectares);
    $stmtHectares->execute([':id_proprietario' => $id_proprietario]);
    $hectares = $stmtHectares->fetch(PDO::FETCH_ASSOC); 
    

} catch (PDOException $e) {
    $msg = "Erro ao carregar dados financeiros: " . $e->getMessage();
}
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

            <?php if (!empty($msg))
                echo "<p class='erro'>$msg</p>"; ?>

            <?php if ($fazendas): ?>
                <div class="cards">
                    <div class="card">
                        <h3>Investimento Total</h3>
                        <p>R$ <?= number_format($invest_total['v_custo_total'], 2, ',', '.') ?></p>
                    </div>

                    <div class="card">
                        <h3>Faturamento Total</h3>
                        <p>R$ <?= number_format($faturamento_total['v_receita_total'], 2, ',', '.') ?></p>
                    </div>

                    <div class="card">
                        <h3>Lucro Total</h3>
                        <p>R$
                            <?= number_format($faturamento_total['v_receita_total'] - $invest_total['v_custo_total'], 2, ',', '.') ?>
                        </p>
                    </div>

                    <div class="card">
                        <h3>Total de Hectares</h3>
                        <p><?= number_format($faturamento_total['tamanho_hec'] ?? 0, 2, ',', '.') ?> ha</p>
                    </div>

                    <div class="card">
                        <h3>ROI Médio</h3>
                        <p>
                            <?php
                            if ($invest_total['v_custo_total'] > 0) {
                                echo round((($faturamento_total['v_receita_total'] - $invest_total['v_custo_total']) / $invest_total['v_custo_total']) * 100, 2) . "%";
                            } else {
                                echo "—";
                            }
                            ?>
                        </p>
                    </div>
                </div>
            <?php else: ?>
                <p>Nenhum dado financeiro encontrado.</p>
            <?php endif; ?>


            <div class="table-container">
                <h3>Fazendas Ativas</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Nome da Fazenda</th>
                            <th>Tamanho (ha)</th>
                            <th>Investimento por ha</th>
                            <th>Produção por ha (saca)</th>
                            <th>Investimento total</th>
                            <th>Faturamento</th>
                            <th>Lucro</th>
                            <th>ROI</th>
                            <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($fazendas && count($fazendas) > 0): ?>
                            <?php foreach ($fazendas as $fazenda): ?>
                                <tr>
                                    <td><?= htmlspecialchars($fazenda['nome_fazenda']) ?></td>
                                    <td><?= number_format($fazenda['tamanho_hec'], 2, ',', '.') ?></td>
                                    <td>R$ <?= number_format($fazenda['custo_hec'], 2, ',', '.') ?></td>
                                    <td><?= number_format($fazenda['producao_hec'], 2, ',', '.') ?></td>
                                    <td>R$ <?= number_format($fazenda['investimento_total'], 2, ',', '.') ?></td>
                                    <td>R$ <?= number_format($fazenda['faturamento_total'], 2, ',', '.') ?></td>
                                    <td>R$ <?= number_format($fazenda['lucro'], 2, ',', '.') ?></td>
                                    <td><?= number_format($fazenda['ROI'], 1, ',', '.') ?>%</td>
                                    <td>
                                        <button class="delete-btn"
                                            data-fazenda="<?= htmlspecialchars($fazenda['nome_fazenda']) ?>"
                                            data-id="<?= htmlspecialchars($fazenda['id_fazenda']) ?>">
                                            <img width="40" height="40"
                                                src="https://img.icons8.com/ios-filled/50/FA5252/multiply.png" alt="Excluir" />
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" style="text-align:center;">Nenhuma fazenda cadastrada.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <form method="POST">
                <input type="hidden" name="id_fazenda" id="id-fazenda-selecionada">
                <div class="modal-container" id="modal-container">
                    <div class="modal">
                        <h2>Você deseja realmente excluir <span id="nome-fazenda"></span>?</h2>
                        <div class="modal-buttons">
                            <button type="submit" id="confirm-delete">Sim</button>
                            <button id="cancel-delete">Não</button>
                        </div>
                    </div>
                </div>
            </form>

        </main>
    </div>

    <script src="../assets/js/modal.js"></script>
</body>

</html>