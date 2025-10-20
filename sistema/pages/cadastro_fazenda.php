<?php
/*
session_start();
include_once('../conexao.php');

if (isset($_POST['cadastro'])) {
    $nome = $_POST['nome'];
    $tamanho = $_POST['tamanho'];
    $custo = $_POST['custo'];
    $quantidade = $_POST['quantidade'];
    $preco = $_POST['preco'];
    $produto = $_POST['produto']; 
    $idProprietario = 1;

    $sql = "INSERT INTO fazenda (id_proprietario, id_produto, nome_fazenda, producao_hec, tamanho_hec, custo_hec, quantidade_sacas_esperadas) 
            VALUES ('$idProprietario', '$produto', '$nome', '$preco', '$tamanho', '$custo', '$quantidade')";
    
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('Location: financeiro.php');
        exit;
    } else {
        echo 'Erro ao cadastrar a fazenda: ' . mysqli_error($conn);
    }
}
*/

    session_start();
    include_once('../conexao.php');

    if (!isset($_SESSION['id_proprietario'])) {
        header('Location: login.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/cadastro_fazenda.css">
    <title>Cadastro de Fazendas</title>
</head>
<body>
    <div class="container">
    <?php include "dashboard.php"; ?>
    <main>

<?php
$cadastro = true;

if ($cadastro == true) {
    include "cadastro_fazenda_novo_usuario.php";
?>      
                    

                    <input type="submit" name="cadastro" value="Cadastrar Fazenda" class="submit">
                </form>
            </div>
        </main>
    </div>
    <script src="../assets/js/cadastro_fazenda.js"></script>
</body>
</html>
<?php
}else{
?>
<html></html>
<?php
}
?>
