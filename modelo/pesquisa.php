<?php 
    require_once "../assets/menu.php";
    require_once "../protec.php";
    require_once "../conexao.php";
    require_once "../permissao.php";
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

            <form method="POST" action="">

                <div class="card">

                    <div class="card-body">

                        <h5>Filtros</h5>

                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label>Numero da O.S</label>
                                <input type="text" class="form-control" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>Placa</label>
                                <input type="text" class="form-control" >
                            </div>

                            <div class="form-group col-md-4">
                                <label>Status</label>
                                <select name="" class="form-control">

                                    <option value="">Ambas</option>
                                    <option value="">Aberta</option>
                                    <option value="">Fechada</option>

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
                            <button type="submit" class="btn btn-primary">Buscar</button>
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

                                    <?php if (!empty($dados_relatorio)): ?>

                                        <?php foreach ($dados_relatorio as $linha): ?>

                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>

                                        <?php endforeach; ?>

                                    <?php else: ?>

                                        <tr>
                                            <td colspan="9" class="text-muted">
                                                Nenhum pesquisa realizada. Selecione o filtro e clique em
                                                "Buscar".
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