<?php 
    require_once "../assets/menu.php";
    require_once "../protec.php";
?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/menu.css">
    <link rel="stylesheet" href="../assets/css/ordem-servico.css">


    <title>G.A Pneus</title>
</head>
<body>
    <section class="conteudo">

        <header class="cabecalho-servicos">

            <h1>Ordem de Serviço</h1>
            <form class="acao" method="POST"  action="../modelo/abrir-os.php">

                <button class="bnt-os" name="acao" value="abr-os">Abrir O.S</button>
                <input type="text" class="input-busca" placeholder="Pesquisar O.S...">

            </form>

        </header>

            <div class="p-3">
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

                            <tr>
                                <td>1254</td>
                                <td>João Miguel</td>
                                <td>VW/Gol</td>
                                <td>ISI-9873</td>
                                <td>Gustavo</td>
                                <td>R$1750,00</td>
                                <td>Aberta</td>
                                <td>25/04/2026</td>
                            </tr>


                        </tbody>

                    </table>
                </div>
    </section>

    <script src="../assets/js/script.js"></script>
</body>
</html>