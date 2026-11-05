<?php 
    require_once "../assets/menu.php";
    require_once "../protec.php";
    require_once "../conexao.php";
    require_once "../permissao.php";

    $dados_pesquisa = $_SESSION['dados_pesquisa'] ?? [];
    unset($_SESSION['dados_pesquisa']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>G.A Pneus</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/menu.css">
    <link rel="stylesheet" href="../assets/css/pesquisa.css">

</head>
<body>
    <section class="conteudo">

        <header class="cabecalho-servicos">
            <h1>Pesquisa de Ordem de Serviço</h1>
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

            <form method="POST" action="../controller/acao.php">

                <div class="card">

                    <div class="card-body">

                        <h5>Filtros</h5>

                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label>Numero da O.S</label>
                                <input type="text" name="num-os" class="form-control" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>Placa</label>
                                <input type="text" name="placa" class="form-control" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>Status</label>
                                <select name="status" class="form-control">

                                    <option value="">Ambas</option>
                                    <option value="aberta">Aberta</option>
                                    <option value="encerrada">Fechada</option>

                                </select>
                            </div>

                            <div class="form-group col-md-4">
                                <label>Data Inicial</label>
                                <input type="date" id="data_incio" name="data_incio" class="form-control" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>Data Final</label>
                                <input type="date" id="data_fim" name="data_fim" class="form-control" >
                            </div>

                        </div>

                        <div class="text-right">
                            <button type="submit" name="pesquisa" class="btn btn-primary">Buscar</button>
                        </div>
                
                    </div>

                    <hr>

                    <div class="card-body">

                        <div class="tab-content">
                            <table class="table table-hover text-center">

                                <thead class="thead-light">

                                    <tr>
                                        <th>Nº O.S</th>
                                        <th>Cliente</th>
                                        <th>Carro</th>
                                        <th>Placa</th>
                                        <th>Vendedor</th>
                                        <th>Valor</th>
                                        <th>Status</th>
                                        <th>Data</th>
                                    </tr>

                                </thead>

                                
                                <tbody>

                                    <?php if(!empty($dados_pesquisa)): ?>

                                        <?php foreach($dados_pesquisa as $linha): ?>

                                            <tr>
                                                <td><?= htmlspecialchars($linha['id'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($linha['cliente'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($linha['veiculo'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($linha['placa'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($linha['vendedor'] ?? '') ?></td>
                                                <td>R$ <?= number_format((float)($linha['valor'] ?? 0), 2, ',', '.') ?></td>
                                                <td><?= htmlspecialchars($linha['status'] ?? '') ?></td>
                                                <td><?= !empty($linha['data_abertura']) ? date('d/m/Y', strtotime($linha['data_abertura'])) : '' ?></td>
                                            </tr>

                                        <?php endforeach; ?>

                                    <?php else: ?>

                                        <tr>
                                            <td colspan="8" class="text-muted">
                                                Nenhuma pesquisa realizada. Selecione o filtro e clique em "Buscar".
                                            </td>
                                        </tr>

                                    <?php endif; ?>

                                </tbody>


                            </table>
                            
                        </div>
                    </div>
                </div>

            </form>

        </div>

    </section> 
    <script src="../assets/js/script.js"></script> 
</body>
</html>