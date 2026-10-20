<?php 
    //data e hora do brasil
    date_default_timezone_set('America/Sao_Paulo');

    require_once "../assets/menu.php";
    require_once "../protec.php";
    require_once "../permissao.php";
    require_once "../conexao.php";

    exigirAcesso(['admin']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/menu.css">
    <link rel="stylesheet" href="../assets/css/relatorio.css">


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

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
        
            <form method="post" action="">

                <div class="card">

                    <h5>Filtros</h5>

                    <div class="card-body">

                        <div class="form-row">

                            <div class="form-group col-md-4">
                                <label>Data Inicial</label>
                                <input type="date" id="data_incio" name="data_incio" class="form-control" value="<?= date('Y-m-01') ?>">
                            </div>

                            <div class="form-group col-md-4">
                                <label>Data Final</label>
                                <input type="date" id="data_fim" name="data_fim" class="form-control" value="<?= date('Y-m-d') ?>">
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
                                                WHERE nivel_acesso = 'vendedor'
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

                                    <a class="nav-link active" data-toggle="tab" href="#vendedor">
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
                                <div class="tab-pane fade show active" id="vendedor">

                                    <h1>vendedor</h1>
                                
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