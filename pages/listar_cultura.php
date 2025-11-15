<?php
    include_once('../conexao.php');
    include_once('../verifica_login.php');

    $msg = "";

    try {
        $stmt = $conn->prepare("SELECT id_cultura, nome_cultura, valor_unitario
                                    FROM cultura ORDER BY id_cultura ASC");
        $stmt->execute();

        $culturas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        $msg = "Erro ao buscar culturas " . $e->getMessage();
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
                        <?php if (!empty($culturas)): ?>
                            <?php foreach ($culturas as $cultura): ?>
                                <tr>
                                    <td><?= $cultura['id_cultura'] ?></td>
                                    <td><?= htmlspecialchars($cultura['nome_cultura']) ?></td>
                                    <td><?= number_format($cultura['valor_unitario'], 2, ',', '.') ?></td>
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