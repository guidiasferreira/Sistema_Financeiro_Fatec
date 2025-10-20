<div class="menu">
    <form action="" method="POST" class="form">
        <h1>Cadastro de Fazenda</h1>
        <input type="text" name="nome" placeholder="Nome da Fazenda" required class="inputs">
        <input type="number" name="tamanho" placeholder="Quantidade de hectares" required class="inputs">
        <input type="number" name="custo" placeholder="Custo de produção por hectare" required class="inputs">
        <input type="number" name="quantidade" placeholder="Quantidade esperada de produção por hectare" required class="inputs">
        <input type="number" name="preco" placeholder="Preço médio da saca por hectare" required class="inputs">

        <div class="radios">
            <input type="radio"name="cultura" value="novo" id="nova_cultura">
            <label for="nova_cultura">Cadastrar nova cultura</label>    
            <input type="radio"name="cultura" value="existente" id="cultura_existente">
            <label for="cultura_existente">Adicionar cultura existente</label>
        </div>

        <select name="produto" class="select">
            <option value="">Selecione uma cultura</option>
            <?php
            
            include_once('../conexao.php');
            $sqlCulturas = "SELECT id_produto, nome_produto FROM produto ORDER BY nome_produto ASC";
            $resultCulturas = mysqli_query($conn, $sqlCulturas);

            if ($resultCulturas) {
                while ($row = mysqli_fetch_assoc($resultCulturas)) {
                    echo "<option value='{$row['id_produto']}'>{$row['nome_produto']}</option>";
                }
            } else {
                echo "<option value=''>Erro ao carregar culturas</option>";
            }
        ?>
        </select>

                        
