<?php
    include_once('../conexao.php');
    include_once('../verifica_login.php');

    $msg = "";

    try {
        $stmt = $conn -> prepare("SELECT id_produto, nome_produto, preco_saca FROM produto ORDER BY id_produto ASC");
        $stmt -> execute();

        $produtos = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $msg = "Erro ao buscar produtos " .$e -> getMessage();  
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/listar_cultura.css">
    <link rel="shortcut icon" href="../assets/img/plantar.png" type="image/x-icon">
    <title>Listagem de Culturas</title>
</head>
<body>
<div class="container">
    <?php include "dashboard.php"; ?>
    <main>
        <h1>Listagem de Culturas</h1>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Preço por saca</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($produtos)): ?>
                        <?php foreach ($produtos as $produto) : ?>
                            <tr>
                                <td><?= $produto['id_produto'] ?></td>
                                <td><?= htmlspecialchars($produto['nome_produto']) ?></td>
                                <td><?= number_format($produto['preco_saca'], 2, ',', '.') ?></td>
                            </tr>
                       <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="6">Nenhuma cultura cadastrada.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
</body>
</html>