<?php 
    require_once "../assets/menu.php";
    require_once "../protec.php";
    require_once "../conexao.php";
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

                            <h4>Produtos com necessidade de reposição</h4>

                            <form action="../controller/acao.php" method="post">
                                <table class="table table-hover text-center">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Código</th>
                                            <th>Produto</th>
                                            <th>Unidade</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php
                                
                                                //Pega o produto com tipo "Pneu Novo" e qntd menor que "4"
                                                $sql ="
                                                    SELECT * FROM produtos
                                                    WHERE qntd <= 4 AND tipo ='Pneu Novo'
                                                ";
                                                $resultado = mysqli_query($mysqli, $sql);
                                                while ($produto = mysqli_fetch_assoc($resultado)) {
                                            ?>
                                                    <!--traz o resultado da consulta-->
                                                    <tr>
                                                        <td><?= $produto['id'] ?></td>
                                                        <td><?= htmlspecialchars($produto['nome']) ?></td>
                                                        <td><?= $produto['qntd'] ?></td>
                                                        <td>
                                                            <input type="checkbox" name="produtos[]" value="<?= $produto['id'] ?>">
                                                        </td>
                                
                                                    </tr>
                                            <?php
                                                };
                                            ?>
                                            <tfood>
                                                <tr>
                                                    <td colspan="5" class="text-right">
                                
                                                        <button class="btn btn-primary btn-sm" name="abrir_encomenda">
                                                            Encomendar Pneu
                                                        </button>
                                
                                                    </td>
                                                </tr>
                                            </tfood>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>

                        </div>

                        <!--Aba cotação-->
                        <div class="tab-pane fade show" id="cotacao">

                            <h1>Cotação</h1>

                        </div>

                        <!--Aba encomenda-->
                        <div class="tab-pane fade show" id="encomenda">

                            <h4>Encomendas</h4>

                            <table class="table table-hover text-center">

                                <thead class="thead-light">
                                    <tr>
                                        <th>N° Cotação</th>
                                        <th>Tipo</th>
                                        <th>Status</th>
                                        <th>Data</th>
                                    </tr>
                                </thead>

                                <!--Consulta da tabela-->
                                <?php 

                                    $sql=
                                    "
                                        SELECT
                                        id_cotacao as id,
                                        data_abertura as data,
                                        tipo,
                                        status
                                        FROM cotacoes

                                        ORDER BY id DESC
                                    ";
                                    $resultado = $mysqli->query($sql)

                                ?>

                                <tbody>
                                    <?php while($encomenda = $resultado->fetch_assoc()): ?>

                                        <tr>

                                            <td>
                                                <a href="#">
                                                    <?= (int) $encomenda['id'] ?>
                                                </a>
                                            </td>

                                            <td>

                                                <?= $encomenda['tipo'] ?>

                                            </td>

                                            <td>

                                                <?= $encomenda['status'] ?>

                                            </td>

                                            <td>

                                                <?= date('d/m/Y', strtotime ($encomenda['data'])) ?>

                                            </td>

                                        </tr>
                                    <?php endwhile; ?>
                                    
                                </tbody>

                            </table>

                        </div>


                    </div>

                </div>

            </div>

        </div>

    </section>
    <script src="../assets/js/script.js"></script>
</body>
</html>