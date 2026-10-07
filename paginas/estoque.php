<?php 
    require_once "../assets/menu.php";
    require_once "../protec.php";
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
            <h1>Gerencimento de Estoque</h1>
        </header>

        <div class="container mt-4">

            <div class="card">

                <!--Abas da pagina-->
                <div class="card-header">

                    <ul class="nav nav-tabs card-header-tabs">

                        <li class="nav-item">

                            <a class="nav-link active" data-toggle="tab" href="#estoque">
                                Estoque
                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" data-toggle="tab" href="#cotacao">
                                Cotação
                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="#encomenda" class="nav-link" data-toggle="tab">
                                Encomenda
                            </a>

                        </li>

                    </ul>

                </div>

                <div class="card-body">

                    <div class="tab-content">
                        
                        <!--Aba Estoque -->
                        <div class="tab-pane fade show active" id="estoque">

                            <h1>Estoque</h1>

                        </div>

                        <!--Aba cotação-->
                        <div class="tab-pane fade show" id="cotacao">

                            <h1>Cotação</h1>

                        </div>

                        <!--Aba encomenda-->
                        <div class="tab-pane fade show" id="encomenda">


                            <h1>Encomenda</h1>

                        </div>


                    </div>

                </div>

            </div>

        </div>

    </section>
    <script src="../assets/js/script.js"></script>
</body>
</html>