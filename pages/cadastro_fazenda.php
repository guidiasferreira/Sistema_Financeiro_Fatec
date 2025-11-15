<?php
    include_once('../conexao.php');
    include_once('../verifica_login.php');

    $msg = "";

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $nome = $_POST['nome'];
        $tamanho = $_POST['tamanho'];
        $custo = $_POST['custo'];
        $producao = $_POST['preco'];
        $id_cultura = $_POST['cultura'];
        $valor_unitario = $_POST['valor_unitario'];
        $id_proprietario = $_SESSION['id_proprietario'];

        try {
            $stmtFazenda = $conn->prepare("INSERT INTO fazenda (id_proprietario, nome_fazenda, producao_hec, tamanho_hec, custo_hec)
                                                VALUES (:id_proprietario, :nome, :producao, :tamanho, :custo)
                ");

            $stmtFazenda->execute([
                ':id_proprietario' => $id_proprietario,
                ':nome' => $nome,
                ':producao' => $producao,
                ':tamanho' => $tamanho,
                ':custo' => $custo
            ]);

            $id_fazenda = $conn->lastInsertId();

            $stmtProducao = $conn->prepare("INSERT INTO producao (id_fazenda, id_cultura, valor_unitario)
                                                VALUES (:id_fazenda, :id_cultura, :valor_unitario)
                ");

            $stmtProducao->execute([
                ':id_fazenda' => $id_fazenda,
                ':id_cultura' => $id_cultura,
                ':valor_unitario' => $valor_unitario
            ]);

            header('Location: financeiro.php');
            exit;

        } catch (PDOException $e) {
            $msg = "Erro ao cadastrar a fazenda: " . $e->getMessage();
        }
    }

    try {
        $sqlCulturas = "SELECT id_cultura, nome_cultura 
                            FROM cultura 
                            ORDER BY nome_cultura ASC";

        $stmtCulturas = $conn->prepare($sqlCulturas);
        $stmtCulturas->execute();
        $culturas = $stmtCulturas->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $msg = "Erro ao carregar culturas: " . $e->getMessage();
    }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/cadastro_fazenda.css">
    <link rel="shortcut icon" href="../assets/img/plantar.png" type="image/x-icon">
    <title>Cadastro de Fazendas</title>
</head>

<body>
    <div class="container">
        <?php include "dashboard.php"; ?>
        <main>
            <div class="menu">
                <form action="" method="POST" class="form">
                    <h1>Cadastro de Fazenda</h1>

                    <?php if (!empty($msg)): ?>
                        <p style="color: red;"><?= $msg ?></p>
                    <?php endif; ?>

                    <input type="text" name="nome" placeholder="Nome da Fazenda" required class="inputs">
                    <input type="number" name="tamanho" placeholder="Quantidade de hectares" required class="inputs">
                    <input type="number" name="custo" placeholder="Custo de produção por hectare" required
                        class="inputs">
                    <input type="number" name="preco" placeholder="Produção (sacas/hectare)" required class="inputs">
                    <select name="cultura" id="cultura" class="select" required>
                        <option value="">Selecione uma cultura</option>
                        <?php
                        $sqlCulturas = "SELECT id_cultura, nome_cultura, valor_unitario 
                                            FROM cultura 
                                            ORDER BY nome_cultura ASC";

                        $stmtCulturas = $conn->prepare($sqlCulturas);
                        $stmtCulturas->execute();
                        $culturas = $stmtCulturas->fetchAll(PDO::FETCH_ASSOC);

                        if (!empty($culturas)) {
                            foreach ($culturas as $cultura) {
                                echo "<option value='{$cultura['id_cultura']}' data-preco='{$cultura['valor_unitario']}'>{$cultura['nome_cultura']}</option>";
                            }

                        } else {
                            echo "<option value=''>Nenhuma cultura cadastrada</option>";
                        }
                        ?>
                    </select>

                    <input type="number" step="0.01" min="0" name="valor_unitario" id="valor_unitario"
                        placeholder="Preço da Saca" required class="inputs">
                    <input type="submit" name="cadastro" value="Cadastrar Fazenda" class="submit">
                </form>
            </div>
        </main>
    </div>

    <script src="../assets/js/cadastro_fazenda.js"></script>

</body>

</html>