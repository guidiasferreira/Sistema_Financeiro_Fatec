<?php
    include_once('../conexao.php');
    include_once('../verifica_login.php');

    $msg = "";

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $nome = $_POST['nome'];
        $tamanho = $_POST['tamanho'];
        $custo = $_POST['custo'];
        $producao = $_POST['preco']; 
        $id_produto = $_POST['produto'];
        $preco_saca = $_POST['preco_saca'];
        $id_proprietario = $_SESSION['id_proprietario'];

        try {
            $stmtFazenda = $conn -> prepare("INSERT INTO fazenda (id_proprietario, nome_fazenda, producao_hec, tamanho_hec, custo_hec)
                                             VALUES (:id_proprietario, :nome, :producao, :tamanho, :custo)
            ");

            $stmtFazenda -> execute([
                ':id_proprietario' => $id_proprietario,
                ':nome' => $nome,
                ':producao' => $producao,
                ':tamanho' => $tamanho,
                ':custo' => $custo
            ]);

            $id_fazenda = $conn -> lastInsertId();

            $stmtProducao = $conn -> prepare("INSERT INTO producao (id_fazenda, id_produto, preco_saca)
                                              VALUES (:id_fazenda, :id_produto, :preco_saca)
            ");

            $stmtProducao -> execute([
                ':id_fazenda' => $id_fazenda,
                ':id_produto' => $id_produto,
                ':preco_saca' => $preco_saca
            ]);

            header('Location: financeiro.php');
            exit;

        } catch (PDOException $e) {
            $msg = "Erro ao cadastrar a fazenda: " . $e->getMessage();
        }
    }

    try {
        $sqlCulturas = "SELECT id_produto, nome_produto 
                        FROM produto 
                        ORDER BY nome_produto ASC";

        $stmtCulturas = $conn -> prepare($sqlCulturas);
        $stmtCulturas -> execute();
        $culturas = $stmtCulturas -> fetchAll(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        $msg = "Erro ao carregar culturas: " . $e -> getMessage();
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
                    <input type="number" name="custo" placeholder="Custo de produção por hectare" required class="inputs">
                    <input type="number" name="preco" placeholder="Produção (sacas/hectare)" required class="inputs">
                    <select name="produto" id="produto" class="select" required>
                        <option value="">Selecione uma cultura</option>
                        <?php
                            $sqlCulturas = "SELECT id_produto, nome_produto, preco_saca 
                                            FROM produto 
                                            ORDER BY nome_produto ASC";

                            $stmtCulturas = $conn -> prepare($sqlCulturas);
                            $stmtCulturas -> execute();
                            $culturas = $stmtCulturas -> fetchAll(PDO::FETCH_ASSOC);

                            if (!empty($culturas)) {
                                foreach ($culturas as $cultura) {
                                    echo "<option value='{$cultura['id_produto']}' data-preco='{$cultura['preco_saca']}'>{$cultura['nome_produto']}</option>";
                                }

                            } else {
                                echo "<option value=''>Nenhuma cultura cadastrada</option>";
                            }
                        ?>
                    </select>
                    
                    <input type="number" step="0.01" min="0" name="preco_saca" id="preco_saca" placeholder="Preço da Saca" required class="inputs">
                    <input type="submit" name="cadastro" value="Cadastrar Fazenda" class="submit">
                </form>
            </div>
        </main>
    </div>

<script>
    const selectCultura = document.getElementById('produto');
    const inputPreco = document.getElementById('preco_saca');

    selectCultura.addEventListener('change', function() {
        const preco = this.options[this.selectedIndex].getAttribute('data-preco');
        inputPreco.value = preco || ''; // Preenche se tiver preço
    });
</script>

</body>
</html>