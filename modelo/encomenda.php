<?php 
    require_once "../assets/menu.php";
    require_once "../protec.php";
    require_once "../conexao.php";

    // Verifica se recebeu o ID pela URL
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

    if (!$id || $id <= 0) {
        $_SESSION['mensagem'] = "Encomenda inválida.";
        header("Location: ../paginas/estoque.php");
        exit;
    };

    //busca a encomenda
    $sql = 
    "
        SELECT * FROM cotacoes 
        WHERE id_cotacao = $id
    ";

    $resultado = mysqli_query($mysqli, $sql);
    $encomenda = mysqli_fetch_assoc($resultado);

    // Verifica se existe
    if (!$encomenda) {
        $_SESSION['mensagem'] = "Encomenda não encontrada.";
        header("Location: ../paginas/estoque.php");
        exit;
    }

    // Busca os produtos da encomenda
    $sql = "
        SELECT
            produtos.id,
            produtos.nome,
            produtos.tipo,
            itens_cotacao.quantidade,
            itens_cotacao.custo_unitario,
            itens_cotacao.margem_percentual,
            itens_cotacao.venda_unitaria
        FROM itens_cotacao
        INNER JOIN produtos
            ON produtos.id = itens_cotacao.produto_id
        WHERE itens_cotacao.cotacao_id = ?
    ";

    $resultado = $mysqli->prepare($sql);
    $resultado->bind_param("i", $id);
    $resultado->execute();

    $itens = $resultado->get_result();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/menu.css">
    <link rel="stylesheet" href="../assets/css/produtos.css">

    <title>G.A Pneus</title>
</head>
<body>
    
    <section class="conteudo">

        <header class="cabecalho-produto">
            <h1>Encomendas</h1>
        </header>

        <div class="container mt-4">

            <!--Mensagem-->
            <?php if(isset($_SESSION['mensagem'])): ?>

                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?= $_SESSION['mensagem']; ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <?php unset($_SESSION['mensagem']); ?>

            <?php endif; ?>

            <form action="../controller/acao.php" method="POST">

                <input type="hidden" name="id_cotacao"
                    value="<?= (int) $encomenda['id_cotacao'] ?>"
                >

                <div class="card mb-4">

                    <div class="card-header">
                        <h4 class="mb-0">
                            Encomenda nº <?= (int) $encomenda['id_cotacao'] ?>
                        </h4>
                    </div>

                    <div class="card-body">

                        <div class="row mb-4">

                            <div class="col-md-3">
                                <strong>Data:</strong><br>
                                <?= date('d/m/Y H:i', strtotime($encomenda['data_abertura'])) ?>
                            </div>

                            <div class="col-md-3">
                                <strong>Tipo:</strong><br>
                                <?= htmlspecialchars($encomenda['tipo']) ?>
                            </div>

                            <div class="col-md-3">
                                <strong>Status:</strong><br>
                                <span class="badge badge-info">
                                    <?= htmlspecialchars($encomenda['status']) ?>
                                </span>
                            </div>

                        </div>

                        <h5>Produtos da encomenda</h5>
                        <div class="table-responsive">

                            <table class="table table-hover text-center">
                                <thead class="thead-light">

                                    <tr>
                                        <th>Código</th>
                                        <th>Produto</th>
                                        <th>Quantidade</th>
                                        <th>Custo unitário</th>
                                        <th>Margem (%)</th>
                                        <th>Venda unitária</th>
                                    </tr>

                                </thead>

                                <tbody>
                                    <?php if ($itens->num_rows > 0): ?>
                                        <?php while ($item = $itens->fetch_assoc()): ?>
                                            <tr>

                                                <!--codigo-->
                                                <td>
                                                    <input
                                                        type="hidden"
                                                        name="produto_id[<?= $item['id'] ?>]"
                                                        value="<?= (int) $item['id'] ?>"
                                                    >
                                                </td>
                                                <!--nome-->
                                                <td>
                                                    <?= htmlspecialchars($item['nome']) ?>
                                                </td>
                                                <!--quantidade-->
                                                <td>
                                                    <input
                                                        type="number"
                                                        name="quantidade[<?= $item['id'] ?>]"
                                                        value="<?= (int) $item['quantidade'] ?>"
                                                        min="1"
                                                        class="form-control form-control-sm quantidade-item text-center"
                                                        style="width: 80px; margin: auto;"
                                                    >
                                                </td>
                                                <!-- Custo unitário -->
                                                <td>
                                                    <input
                                                        type="text"
                                                        inputmode="decimal"
                                                        name="custo[<?= $item['id'] ?>]"
                                                        value="<?= number_format((float)$item['custo_unitario'], 2, '.', '') ?>"
                                                        class="form-control form-control-sm custo-unitario text-center"
                                                        style="width: 100px; margin: auto;"
                                                    >
                                                </td>
                                                <!-- Margem percentual -->
                                                <td>
                                                    <input
                                                        type="number"
                                                        name="margem[<?= $item['id'] ?>]"
                                                        value="<?= number_format((float)$item['margem_percentual'], 2, '.', '') ?>"
                                                        min="0"
                                                        step="0.01"
                                                        class="form-control form-control-sm margem-percentual text-center"
                                                        style="width: 85px; margin: auto;"
                                                    >
                                                </td>
                                                <!-- Venda unitária -->
                                                <td>
                                                    <input
                                                        type="text"
                                                        name="valor_fim[<?= $item['id'] ?>]"
                                                        value="<?= number_format((float)$item['venda_unitaria'], 2, '.', '') ?>"
                                                        class="form-control form-control-sm venda-unitaria text-center"
                                                        style="width: 100px; margin: auto;"
                                                        readonly
                                                    >
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6">
                                                <p>Nenhum produto encontrado nesta encomenda.</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <a href="../paginas/estoque.php#encomenda" class="btn btn-secondary mr-2 px-3">
                            Voltar
                        </a>

                        <button type="submit" class="btn btn-success mr-2 px-3" name="encomenda">
                            Efetivar Encomenda
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script src="../assets/js/script.js"></script>
    
    <!--calculo da porcentagem-->
    <script>
        document.querySelectorAll("tbody tr").forEach(function (linha) {

            const custo = linha.querySelector(".custo-unitario");
            const margem = linha.querySelector(".margem-percentual");
            const venda = linha.querySelector(".venda-unitaria");

            // Ignora linhas sem os campos
            if (!custo || !margem || !venda) return;

            function calcularVenda() {

                // Aceita valores com vírgula ou ponto
                const valorCusto = parseFloat(
                    custo.value.replace(",", ".")
                ) || 0;

                const valorMargem = parseFloat(
                    margem.value.replace(",", ".")
                ) || 0;

                // Calcula custo + margem percentual
                const valorVenda = valorCusto * (1 + valorMargem / 100);

                venda.value = valorVenda.toFixed(2);
            }

            custo.addEventListener("input", calcularVenda);
            margem.addEventListener("input", calcularVenda);

            // Calcula também ao abrir a página
            calcularVenda();
        });
    </script>


</body>
</html>