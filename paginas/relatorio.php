<?php 
    // Data e hora do Brasil
    date_default_timezone_set('America/Sao_Paulo');

    require_once "../assets/menu.php";
    require_once "../protec.php";
    require_once "../permissao.php";
    require_once "../conexao.php";

    exigirAcesso(['admin']);

    // Limpa o relatório somente quando abrir a página normalmente
    if(isset($_GET['novo'])){
        unset($_SESSION['relatorio']);
    }

    $dados_relatorio = $_SESSION['relatorio'] ?? [];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/menu.css">
    <link rel="stylesheet" href="../assets/css/relatorio.css">

    <title>G.A Pneus</title>
</head>
<body>
    <section class="conteudo">

        <header class="cabecalho-relatorio">
            <div>
                <h1>Relatório</h1>
            </div>
        </header>
        
        <div class="container mt-4">
        
            <form method="post" action="../controller/acao.php">

                <!--Mensagem de erro ou sucesso-->
                <?php if(isset($_SESSION['mensagem'])): ?>

                    <div class="alert alert-warning alert-dismissible fade show" role="alert">

                        <?= $_SESSION['mensagem']; ?>

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>

                    </div>

                    <?php unset($_SESSION['mensagem']); ?>

                <?php endif; ?>

                <div class="card">

                    <h5>Filtros</h5>

                    <div class="card-body">

                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label>Data Inicial</label>
                                <input type="date" id="data_incio" name="data_incio" class="form-control" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>Data Final</label>
                                <input type="date" id="data_fim" name="data_fim" class="form-control" >
                            </div>

                            <!--Vendedores-->
                            <div class="form-group col-md-4">
                                <label>Vendedor</label>
                                <select name="vendedor" id="vendedor" class="form-control">
                                    <option value="">Todos</option>

                                    <?php 
                                        //pega os usuarios salvos como vendedor
                                        $sql = 
                                        "
                                            SELECT id_usuario, nome
                                            FROM usuarios
                                            WHERE nivel_acesso IN ('vendedor', 'admin')
                                            ORDER BY nome ASC
                                        ";

                                        $resultado = mysqli_query($mysqli, $sql);

                                        if (!$resultado) {
                                            die("Erro ao buscar vendedores: " . mysqli_error($mysqli));
                                        }

                                        while ($vendedor = mysqli_fetch_assoc($resultado)) {
                                    ?>
                                        <option value="<?= $vendedor['id_usuario'] ?>">
                                            <?= htmlspecialchars($vendedor['nome']) ?>
                                        </option>
                                    <?php
                                        }
                                    ?>

                                
                                </select>
                            </div>

                        </div>

                        <div class="text-right">
                            <button type="submit" name="relatorio" class="btn btn-primary">Gerar relatório</button>
                        </div>
                        
                        <!--Abas-->
                        <div class="card-header">
                            
                            <ul class="nav nav-tabs card-header-tabs">

                                <li class="nav-item">

                                    <a class="nav-link active" data-toggle="tab" href="#aba_vendedor">
                                        Relatório Vendedores
                                    </a>

                                </li>

                                <li class="nav-item">

                                    <a class="nav-link" data-toggle="tab" href="#grafico">
                                        Gráficos 
                                    </a>

                                </li>

                            </ul>  
                        </div>

                        <!--opções de abas-->
                        <div class="card-body">

                            <div class="tab-content">
                                <!--desempenho vendedores-->
                                <div class="tab-pane fade show active" id="aba_vendedor">

                                    <table class="table table-hover text-center">

                                        <thead class="thead-light">

                                            <tr>
                                                <th>Vendedor</th>
                                                <th>Ordem de Serviço</th>
                                                <th>Venda Bruta</th>
                                                <th>Venda Limpa</th>
                                                <th>Pneus</th>
                                            </tr>

                                        </thead>

                                        
                                        <tbody>

                                            <?php if (!empty($dados_relatorio)): ?>

                                                <?php foreach ($dados_relatorio as $linha): ?>

                                                    <tr>
                                                        <!-- Nome do vendedor -->
                                                        <td>
                                                            <?= htmlspecialchars($linha['vendedor']) ?>
                                                        </td>

                                                        <!-- Número da Ordem de Serviço -->
                                                        <td>
                                                            <?= (int) $linha['ordem_servico'] ?>
                                                        </td>

                                                        <!-- Venda Bruta -->
                                                        <td>
                                                            R$ <?= number_format(
                                                                (float) $linha['venda_bruta'],
                                                                2,
                                                                ',',
                                                                '.'
                                                            ) ?>
                                                        </td>

                                                        <!-- Venda Limpa -->
                                                        <td>
                                                            R$ <?= number_format(
                                                                (float) $linha['venda_limpa'],
                                                                2,
                                                                ',',
                                                                '.'
                                                            ) ?>
                                                        </td>

                                                        <!-- Quantidade de pneus vendidos -->
                                                        <td>
                                                            <?= (int) $linha['pneus'] ?>
                                                        </td>
                                                    </tr>

                                                <?php endforeach; ?>

                                            <?php else: ?>

                                                <tr>
                                                    <td colspan="5" class="text-muted">
                                                        Nenhum relatório gerado. Selecione o período e clique em
                                                        "Gerar relatório".
                                                    </td>
                                                </tr>

                                            <?php endif; ?>

                                        </tbody>


                                    </table>
                                
                                </div>

                                <!--Graficos-->
                                <div class="tab-pane fade show" id="grafico">

                                    <h1>grafico</h1>

                                </div>

                            </div>

                        </div>
                        
                    </div>

                </div>

            </form>
        
        </div>
            
    </section>
        
    <script src="../assets/js/script.js"></script>
</body>
</html>